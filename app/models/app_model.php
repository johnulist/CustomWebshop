<?php
    class AppModel extends Model
    {
        var $actsAs = array('Containable');
        var $recursive = -1;

        function find($type, $options = array())
        {
            $method = null;
            if(is_string($type))
            {
                $method = sprintf('__find%s', Inflector::camelize($type));
            }
            if($method && method_exists($this, $method))
            {
                return $this->{$method}($options);
            }
            else
            {
                $args = func_get_args();
                return call_user_func_array(array('parent', 'find'), $args);
            }
        }

        function getSelectList($conditions=null, $keyPath=null, $valuePath=null, $spacer= '&nbsp;&nbsp;&nbsp;&nbsp;', $recursive=null,$prefix = '&raquo;')
        {
            $list = $this->generatetreelist($conditions,$keyPath,$valuePath,'_',$recursive);
            foreach($list as $key => $value)
            {
                if(substr($value,0,1) == '_')
                {
                    $length = strrpos($value, '_') + 1;
                    $spacing = substr($value, 0, $length);
                    $value   = substr($value, $length);
                    $list[$key] = str_replace('_',$spacer,$spacing) . $prefix . '&nbsp;' . $value;
                }
                else
                {
                    $list[$key] = $prefix . '&nbsp;' . $value;
                }
            }
            
            return $list;
        }

         /**
	     * Find full set of pages for a table
	     *
	     * @deprecated: Use Cake's TreeBehavior::genera...
	     * @param int $skipId id to skip
	     */
	    function getAllThreaded($rootId = null, $alias = 'naam')
		{
			$root = $this->read(null, $rootId);
            if(empty($root))
            {
                $result = $this->find('threaded', array(
                    'order' => "{$this->name}.lft ASC"
                ));
            }
            else
            {
    			$result = $this->find('threaded', array(
                    'conditions' => array
                    (
                        "{$this->name}.lft >" => $root[$this->name]['lft'],
                        "{$this->name}.rght <" => $root[$this->name]['rght'],
                    ),
                    'order' => "{$this->name}.lft ASC"
                ));
            }

			return $result;
		}

        public function slugify($string)
        {
            require_once APP . 'views' . DS . 'helpers' . DS . 'app_helper.php';
            return AppHelper::slug($string, '-');
        }

        /**
         * Find a path to an item in MPTT tree
         *
         * @param int $tree_left Left tree value
         * @param int $tree_right Right tree value
         * @return array Ancestors ordered from top to bottom
         */
        function findPath($tree_left, $tree_right, $fields = null)
        {
            $ancestors = $this->find('all', array(
                'conditions' => "{$this->name}.lft < $tree_left AND {$this->name}.rght > $tree_right",
                'order' => "{$this->name}.lft ASC",
                'fields' => $fields
            ));

            return $ancestors;
        }

        /**
         * Overloading AppModel invalidate to include l18n
         *
         * @param string $field
         * @param bool $value
         */
        function invalidate($field, $value = true)
        {
            return parent::invalidate($field, __($value, true));
        }

        /**
         * Delete record(s)
         *
         * @param mixed $ids
         * @return void
         */
        function mass_delete($ids)
        {
            if (!is_array($ids)) {
                $ids = array(intval($ids));
            }
            $ids = join(', ', $ids);
            $this->query("DELETE FROM {$this->useTable} WHERE id IN ($ids)");
        }

        /**
         * Format a timestamp to MySQL date format
         *
         * @param int $time
         * @return string
         */
        function timeToDate($time)
        {
            return date("Y-m-d", $time);
        }

        /**
         * Format a timestamp to MySQL datetime format
         *
         * @param int $time
         * @return string
         */
        function timeToDatetime($time)
        {
            return date("Y-m-d H:i:s", $time);
        }

        /**
		 * Upload een bestand naar de server
		 *
		 * De functie zoekt naar een geschikte bestandsnaam voor het
		 * te uploaden bestand en probeert deze vervolgens te uploaden
		 * naar de opgegeven map.
		 *
		 * De returnwaarde kan gebruikt worden in een data-array.
		 *
		 * @return mixed De naam van het bestand op de server of null
		 */
 		function uploadBestand($bestand, $pad)
		{
			if(is_uploaded_file(@$bestand['tmp_name']))
			{
				$root = ROOT . DS . 'app' . DS . 'webroot' . DS;
				$naam = $this->maakVeilig($bestand['name'], $root . $pad);

				if(move_uploaded_file($bestand['tmp_name'], $root . $pad . $naam))
				{
					// afbeeldingen hoeven niet de 'img' map te verwijzen, dit doet de resizer al!
					$pad = str_replace('img/','', $pad);
					return $pad . $naam;
				}
			}

			return null;
		}

        function verwijderBestand($naam)
        {
            $root = ROOT . DS . 'app' . DS . 'webroot' . DS;
            if(is_file($root . $naam))
            {
                return unlink($root . $naam);
            }
            else
            {
                return false;
            }
        }

		/**
		 * Zoekt een ongebruikte bestandsnaam
		 *
		 * Controleert of een bestandsnaam al bestaat, en verandert
		 * de meegegeven bestandsnaam totdat er nog geen bestand op de
		 * server aanwezig is met de betreffende naam.
		 *
		 * @return De aangepaste bestandsnaam
		 */
		function maakveilig($bestandsnaam, $pad)
		{
			if(file_exists($pad.$bestandsnaam))
			{
				$i = 1;
				while(file_exists($pad . $i . '_' . $bestandsnaam))
				{
					$i++;
				}
				$bestandsnaam = $i . '_' . $bestandsnaam;
			}

			return $bestandsnaam;
		}
    }
?>