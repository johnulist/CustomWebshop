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
		public $uses = array('Gebruiker');

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
                'winkelwagen' => array()
            ));

            // Winkelwagen laden, uit sessie of default
            $this->_laadWinkelwagen();

            // Authorisatie initialiseren
            $this->_laadGebruiker();

            // Laden van de metadefaults
	        $this->Instelling->load();
	        $this->params['meta_title'] = Configure::read('Site.meta_title');
	        $this->params['meta_keywords'] = Configure::read('Site.meta_keywords');
	        $this->params['meta_description'] = Configure::read('Site.meta_description');

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
            $this->params['gebruiker'] = $this->Auth->user();
        }

        function _laadWinkelwagen()
        {
            if($this->Session->check('winkelwagen'))
			{
				$this->params['winkelwagen'] = $this->Session->read('winkelwagen');
			}
			else
			{
				// nieuwe winkelwagen aanmaken
				$this->params['winkelwagen'] = array(
					'aantal'    => 0,
					'totaal'    => 0,
					'ex'        => 0,
					'verzendkosten' => 0,
					'producten' => array()
				);

                $this->Session->write('winkelwagen', $this->params['winkelwagen']);
			}
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
		}
	}
?>