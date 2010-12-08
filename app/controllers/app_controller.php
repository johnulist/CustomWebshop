<?php
	App::import('Sanitize');
	App::import('Core', 'l10n');

    /**
     * AppController voor Custom Webwinkel
     *
     * Custom Webwinkel is een volledig beheerbare webwinkel met bijbehorend
     * online beheer. Insteek is gebruiksvriendelijkheid en snelheid.
     *
     * @author Mattijs Meiboom, Patrick de Vos (info@customwebsite.nl)
     * @copyright Custom Website 2010
     */
	class AppController extends Controller
	{
		public $components = array('Auth','Session');
		public $helpers = array('Html','Form','Javascript','Text','Time', 'Session','Image','Number','Cw');
		public $uses = array('Gebruiker','Instelling','Categorie');

        /**
         * CakePHP hook. Wordt aangeroepen aan het begin van ieder request,
         * voordat de betreffende controllerfunctie wordt aangeroepen.
         */
		function beforeFilter()
		{
            // Parameters uitbreiden
            $this->params = array_merge($this->params, array(
                'isIngelogd' => false,
                'isBeheerder' => false,
                'locale' => 'NLD',
                'valuta' => 'EUR',
                'winkelwagen' => array(),
                'linkerblokken' => array()                
            ));

            // Winkelwagen laden, uit sessie of default
            $this->_laadWinkelwagen();

            // Authorisatie initialiseren
            $this->_laadGebruiker();

            // Laden van de (meta)defaults
	        $this->Instelling->load();
            $this->params['siteNaam'] = Configure::read('Site.naam');
            $this->params['siteLocales'] = explode(",",Configure::read('Site.locales'));
	        $this->params['meta_title'] = Configure::read('Site.meta_title');
	        $this->params['meta_keywords'] = Configure::read('Site.meta_keywords');
	        $this->params['meta_description'] = Configure::read('Site.meta_description');

            // Locale koppelen aan de view, indien aanwezig
            $locale = Configure::read('Config.language');
            if ($locale && file_exists(VIEWS . $locale . DS . $this->viewPath))
            {
                // bijv. /app/views/fre/winkelwagen/index.ctp instead of /app/views/winkelwagen/index.ctp
                $this->viewPath = $locale . DS . $this->viewPath;
            }

            // Layout default of beheer afhankelijk van prefix
            if(isset($this->params['prefix']) && $this->params['prefix'] == "admin")
            {
                $this->layout = 'beheer';
            }
            else
            {
                $this->_activeerMerkenBlok();
            }
		}

        /**
         * Controleert rechten afhankelijk van het al dan niet
         * aanroepen van een beheerdersfunctie.
         *
         * @return boolean
         */
        function isAuthorized()
        {
            if(isset($this->params['prefix']) && $this->params['prefix'] == "admin")
            {
                return $this->isBeheerder();
            }

            return true;
        }

        /**
         * Controleert of de gebruiker ingelogd is als beheerder.
         *
         * @return boolean
         */
        function isBeheerder()
        {
            return ($this->Auth->user('isBeheerder') == 1);
        }

        /**
         * Voegt een blok toe aan de linkerkolom met enkele merken die
         * de webshop verkoopt.
         */
        function _activeerMerkenBlok()
        {
            $this->loadModel('Merk');
            $this->set('merken',$this->Merk->find('all', array(
                'order' => 'Merk.naam ASC',
                'conditions' => array('Merk.flagToonInMenu' => 1),
                'limit' => 10
            )));

            $this->params['linkerblokken']['merken'] = 'merken';
        }

        /**
         * Initialiseert de AuthComponent en laad de gebruiker
         */
        function _laadGebruiker()
        {
            // AuthComponent config
	        $this->Auth->userModel = 'Gebruiker';
	        $this->Auth->fields = array('username' => 'emailadres', 'password' => 'wachtwoord');
	        $this->Auth->loginAction = array('controller' => 'gebruikers', 'action' => 'inloggen', 'admin' => false);
	        $this->Auth->logoutAction = array('controller' => 'gebruikers', 'action' => 'uitloggen', 'admin' => false);
	        $this->Auth->autoRedirect = true;

            // Gebruiker laden
            $gebruiker = $this->Auth->user();
            $this->params['gebruiker'] = $gebruiker['Gebruiker'];
            $this->params['isIngelogd'] = !empty($gebruiker);
        }

        function _laadWinkelwagen($reset = false)
        {
            if(!$reset && $this->Session->check('winkelwagen'))
			{
				$this->params['winkelwagen'] = $this->Session->read('winkelwagen');
			}
			else
			{
				// nieuwe winkelwagen aanmaken
				$this->params['winkelwagen'] = array(
					'aantal'         => 0,
					'totaal'         => 0,
                    'subtotaal_btw'  => 0,
					'subtotaal_excl' => 0,
					'levering'       => array(),
                    'betaling'       => array(),
					'producten'      => array()
				);

                $this->Session->write('winkelwagen', $this->params['winkelwagen']);
			}
        }

        /**
         * Voegt een product toe aan de winkelwagen van een bezoeker
         * en update de totalen in de winkelwagen.
         *
         * @param integer $product_id   ID van het te bestellen product
         * @param integer $variant_id   ID van een mogelijke variant
         */
        function _plaatsInWinkelwagen($product_id, $variant_id = null)
        {
            // Model en data van product laden
            $this->loadModel('Product');
            $product = $this->Product->read(null, $product_id);

            // Update van prijs en aantal
            $this->params['winkelwagen']['aantal']          = $this->params['winkelwagen']['aantal'] + 1;
            $this->params['winkelwagen']['totaal']          = $this->params['winkelwagen']['totaal'] + $product['Product']['prijs'];
            $this->params['winkelwagen']['subtotaal_btw']   = $this->params['winkelwagen']['subtotaal_btw'] + $product['Product']['btw_bedrag'];
                        
            // Locatie van toevoegen bepalen (nieuw of extra?)
            if(array_key_exists($product_id, $this->params['winkelwagen']['producten']))
            {
                // bestaat al, extra
                $this->params['winkelwagen']['producten'][$product_id]['aantal']++;
            }
            else
            {
                // nieuwe entry
                $this->params['winkelwagen']['producten'][$product_id] = array(
                    'aantal' => 1,
                    'product' => $product['Product']
                );
            }

            $this->Session->write('winkelwagen', $this->params['winkelwagen']);
            return true;
        }

        /**
         * CakePHP hook. Wordt aangeroepen aan het einde van ieder request,
         * nadat de betreffende controllerfunctie is aangeroepen.
         */
		function beforeRender()
		{
            // extra parameters instellen
            $this->params['referer'] = $this->referer();
            $this->set('params', $this->params);

            $this->set('nav_categorien', $this->Categorie->getNavigatieData());
		}
	}
?>