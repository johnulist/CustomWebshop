<?php
	class Pagina extends AppModel
	{
		// Algemene gegevens
		public $useTable = 'paginas';
		public $actsAs = array(
		   'Containable',
		   'Slug' => array('separator' => '-', 'overwrite' => false, 'label' => 'titel'),
		   'Tree',
	    );

	    // Validatie
		public $validate = array(
		   'titel' => array(
		       'rule' => array('maxLength', 255),
		       'allowEmpty' => false, 
		       'required' => true,
		       'on' => 'wf_create'
		    )
		);

		// Lijsten
		public static $statusOptions = array(
		   '0' => 'Published',
		   '1' => 'Draft'
		);

		/**
	     * Before save callback
	     *
	     * @return bool Success
	     */
	    function beforeSave()
		{
	        parent::beforeSave();

	    	// Construct the absolute page URL
	    	if (isset($this->data[$this->name]['slug'])) {
		    	$level = 0;
				$root_id = intval(Configure::read('Site.home_id'));
		    	if (intval($this->id) === $root_id && $root_id !== 0) {
		    		// Home page has the URL of root
		    		$this->data[$this->name]['url'] = '/';
		    	} else if (!isset($this->data[$this->name]['parent_id']) or !is_numeric($this->data[$this->name]['parent_id'])) {
		    	    // Page has no parent
		    	    $this->data[$this->name]['url'] = "/{$this->data[$this->name]['slug']}";
		    	} else {
		    		$parentPage = $this->findById($this->data[$this->name]['parent_id'], array('url'));

		    		$url = "{$this->data[$this->name]['slug']}/";
		    		$url = $parentPage[$this->name]['url'] . $url;

		    		$this->data[$this->name]['url'] = $url;
		    	}
	    	}

	    	// Publish?
	        if (isset($this->data[$this->name]['publish'])) {
	            $this->data[$this->name]['draft'] = 0;
	            unset($this->data[$this->name]['publish']);
	        }

	    	return true;
	    }

	    function updateChildPageUrls($id, $oldUrl, $newUrl) {
	        // Update child pages URLs
	    	$children = $this->children($id);
	        if (!empty($children)) {
	            foreach ($children as $page) {
					// Just resave, beforeSave does the magic
					$this->create($page);
					$this->save();
	            }
	        }
	    }

	    function findAllRoot() {
	        return $this->find('all', array(
	            'conditions' => 'parent_id IS NULL',
	            'recursive' => -1,
	            'fields' => array('id', 'titel','slug', 'url'),
	            'order' => 'lft ASC',
	        ));
	    }

	    function findChildrenBySlug($slug) {
	        $pageId = $this->field('id', array('slug' => $slug));
	        if ($pageId === false) {
	            return false;
	        }
	        $pages = $this->children($pageId, true);
	        // Filter out drafts
	        function noDrafts($page) {
	            if ($page['Page']['draft'] == 1) {
	                return false;
	            }
	            return true;
	        }
	        $pages = self::filterOutDrafts($pages);
	        return $pages;
	    }

	    function findAllBySlugWithChildren($slug) {
	        $page = $this->find('first', array('conditions' => array('slug' => $slug)));
	        if ($page === false) {
	            return false;
	        }
	        $pages = $this->children($page['Page']['id'], false);
	        array_unshift($pages, $page);
	        $pages = self::filterOutDrafts($pages);
	        return $pages;
	    }

	    static function filterOutDrafts($pages) {
	        function noDrafts($page) {
	            if ($page['Page']['draft'] == 1) {
	                return false;
	            }
	            return true;
	        }
	        return array_filter($pages, 'noDrafts');
	    }

	    function beforeValidate() {
	        if (isset($this->data[$this->name]['parent_id']) && !is_numeric($this->data[$this->name]['parent_id'])) {
	            $this->data[$this->name]['parent_id'] = null;
	        }

	        // We don't want titels constructed from spaces
	        if (isset($this->data[$this->name]['titel'])) {
	        	$this->data[$this->name]['titel'] = trim($this->data[$this->name]['titel']);
	        }

	        return true;
	    }

	    /**
	     * Mark a page(s) as a draft
	     *
	     * @param mixed $ids
	     * @return void
	     */
	    function draft($ids) {
	        if (!is_array($ids)) {
	            $ids = array(intval($ids));
	        }
	        $ids = join(', ', $ids);
	        $this->query("UPDATE {$this->useTable} SET draft = 1 WHERE id IN ($ids)");
	    }

	    /**
	     * Alias for $this->draft()
	     *
	     * @param mixed $ids
	     * @return void
	     */
	    function unpublish($ids) {
	        $this->draft($ids);
	    }

	    function getStatusOptions() {
	        return self::$statusOptions;
	    }

	    /**
	     * Return [titel => url] pairs of children pages
	     *
	     * @param string $pageSlug
	     * @return array
	     */
	    function getChildrenForMenu($pageSlug) {
	        $page = $this->findBySlug($pageSlug);
	        $pages = $this->children($page[$this->name]['id']);
	        if (empty($pages)) {
	            return null;
	        }
	        $titels = Set::extract($pages, "{n}.{$this->name}.titel");
	        $urls = Set::extract($pages, "{n}.{$this->name}.url");
	        return array_combine($titels, $urls);
	    }

	    /**
	     * Find full set of pages for a table
	     *
	     * @deprecated: Use Cake's TreeBehavior::genera...
	     * @param int $skipId id to skip
	     */
	    function getAllThreaded($rootId = null, $alias = 'titel')
		{
			if(is_null($rootId)) $rootId = intval(Configure::read('Site.root_id'));

			$root = $this->read(null, $rootId);

			$pages = $this->find('threaded', array(
				'conditions' => array
				(
					"{$this->name}.lft >" => $root[$this->name]['lft'],
					"{$this->name}.rght <" => $root[$this->name]['rght'],
				),
				'order' => "{$this->name}.lft ASC"
			));

			return $pages;
		}

	    /**
	     * Find possible parents of a page for select box
	     *
	     * @deprecated: Use Cake's TreeBehavior::genera...
	     * @param int $skipId id to skip
	     */
	    function getListThreaded($skipId = null, $alias = 'titel') {
	        $parentPages = $this->find('all', array(
				'order' => "{$this->name}.lft ASC"
			));

	        // Array for form::select
	        $selectBoxData = array();
	        $skipLeft = false;
	        $skipRight = false;

	        if (empty($parentPages)) return $selectBoxData;

	        $rightNodes = array();
	        foreach ($parentPages as $key => $page) {
	            $level = 0;
	            // Check if we should remove a node from the stack
	            while (!empty($rightNodes) && ($rightNodes[count($rightNodes) - 1] < $page[$this->name]['rght'])) {
	               array_pop($rightNodes);
	            }
	            $level = count($rightNodes);

	            $dashes = '';
	            if ($level > 0) {
	                $dashes = str_repeat('&nbsp;&nbsp;', $level - 1) . '&raquo;';
	            }

	            if ($skipId == $page[$this->name]['id']) {
	                $skipLeft = $page[$this->name]['lft'];
	                $skipRight = $page[$this->name]['rght'];
	            } else {
	                if (!($skipLeft
	                   && $skipRight
	                   && $page[$this->name]['lft'] > $skipLeft
	                   && $page[$this->name]['rght'] < $skipRight)) {
	                       $alias = $page[$this->name]['titel'];
	                       if (!empty($dashes)) $alias = "$dashes $alias";
	                       $selectBoxData[$page[$this->name]['id']] = $alias;

	                }
	            }

	            $rightNodes[] = $page[$this->name]['rght'];
	        }

	        return $selectBoxData;
	    }

	    /**
	     * Mark a page(s) as published
	     *
	     * @param mixed $ids
	     * @return void
	     */
	    function publish($ids) {
	        if (!is_array($ids)) {
	            $ids = array(intval($ids));
	        }
	        $ids = join(', ', $ids);
	        $this->query("UPDATE {$this->useTable} SET draft = 0 WHERE id IN ($ids)");
	    }

		/**
	     * Search titel and content fields
	     *
	     * @TODO Create a Search behavior
	     *
	     * @param string $query
	     * @return array
	     */
	    function search($query) {
	        $query = Sanitize::escape($query);
	    	$fields = null;
	    	$titelResults = $this->findAll("{$this->name}.titel LIKE '%$query%'", $fields, null, null, 1);
	    	$contentResults = array();
	    	if (empty($titelResults)) {
	    		$titelResults = array();
				$contentResults = $this->findAll("MATCH ({$this->name}.content) AGAINST ('$query')", $fields, null, null, 1);
	    	} else {
	    		$alredyFoundIds = join(', ', Set::extract($titelResults, '{n}.' . $this->name . '.id'));
	    		$notInQueryPart = '';
	    		if (!empty($alredyFoundIds)) {
	    			$notInQueryPart = " AND {$this->name}.id NOT IN ($alredyFoundIds)";
	    		}
	    		$contentResults = $this->findAll("MATCH ({$this->name}.content) AGAINST ('$query')$notInQueryPart", $fields, null, null, 1);
	    	}

	    	if (!is_array(($contentResults))) {
	    		$contentResults = array();
	    	}

	    	$results = array_merge($titelResults, $contentResults);
	    	return $results;
	    }
	}
?>