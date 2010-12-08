<?php
    /**
     * Controller voor producten
     */
    class WinkelwagenController extends AppController
    {
        var $uses = array();
        var $name = 'Winkelwagen';

        function beforeFilter()
        {
            parent::beforeFilter();
            $this->Auth->allow('index');
        }

        function index()
        {
            
        }

        function verzenden()
        {
            $this->loadModel('Levermethode');

            if(!empty($this->data))
            {
                // Winkelwagen-sessie uitbreiden met info
                if(!empty($this->params['form']['levermethode']) && is_numeric($this->params['form']['levermethode']))
                {
                    // Methode uitlezen
                    $levermethode = $this->Levermethode->read(null, $this->params['form']['levermethode']);

                    // Sessie schrijven
                    $this->params['winkelwagen']['levering'] = array(
                        'methode' => $levermethode['Levermethode'],
                        'adres' => $this->data['Bestelling']['adres'],
                        'postcode' => $this->data['Bestelling']['postcode'],
                        'plaats' => $this->data['Bestelling']['plaats'],
                    );

                    // Verzendkosten toevoegen
                    $gratis_verzending_vanaf = Configure::read('Site.gratisVerzendingVanaf');
                    if($gratis_verzending_vanaf !== "" && $this->params['winkelwagen']['totaal'] >= $gratis_verzending_vanaf)
                    {
                        $this->params['winkelwagen']['verzendkosten_excl'] = 0;
                        $this->params['winkelwagen']['verzendkosten_btw']  = 0;
                        $this->params['winkelwagen']['verzendkosten_incl'] = 0;
                        $this->params['winkelwagen']['btw_totaal']         = $this->params['winkelwagen']['subtotaal_btw'];
                    }
                    else
                    {
                        // verzendkosten rekenen
                        $this->params['winkelwagen']['verzendkosten_excl'] = $levermethode['Levermethode']['verzendkosten_excl'];
                        $this->params['winkelwagen']['verzendkosten_btw']  = $levermethode['Levermethode']['verzendkosten_excl'] * ($levermethode['Levermethode']['btw'] / 100);
                        $this->params['winkelwagen']['verzendkosten_incl'] = $levermethode['Levermethode']['verzendkosten_excl'] + $this->params['winkelwagen']['verzendkosten_btw'];
                        $this->params['winkelwagen']['btw_totaal']         = $this->params['winkelwagen']['subtotaal_btw'] + $this->params['winkelwagen']['verzendkosten_btw'];
                    }
                    
                    
                    $this->Session->write('winkelwagen', $this->params['winkelwagen']);

                    // Naar betalen
                    $this->redirect('/winkelwagen/betalen/');
                }
                else
                {
                    $this->Session->setFlash('Kies een levermethode uit de lijst met opties.', 'flash_error');
                }
            }

            // Opties inladen
            
            $this->data = $this->Levermethode->find('all');
        }

        function betalen()
        {
            $this->loadModel('Betaalmethode');

            if(!empty($this->data))
            {
                // Winkelwagen-sessie uitbreiden met info
                if(!empty($this->params['form']['betaalmethode']) && is_numeric($this->params['form']['betaalmethode']))
                {
                    // Methode uitlezen
                    $betaalmethode = $this->Betaalmethode->read(null, $this->params['form']['betaalmethode']);

                    // Sessie schrijven
                    $this->params['winkelwagen']['betaling'] = array(
                        'methode' => $betaalmethode['Betaalmethode'],
                        'adres' => $this->params['gebruiker']['factuuradres'],
                        'postcode' => $this->params['gebruiker']['f_postcode'],
                        'plaats' => $this->params['gebruiker']['f_plaats'],
                    );

                    $this->Session->write('winkelwagen', $this->params['winkelwagen']);

                    // Naar betalen
                    $this->redirect('/winkelwagen/bevestigen/');
                }
                else
                {
                    $this->Session->setFlash('Kies een betaalmethode uit de lijst met opties.', 'flash_error');
                }
            }

            // Opties inladen
            $this->data = $this->Betaalmethode->find('all');
        }
        
        function besteld($bestelling_id)
        {
            $this->loadModel('Bestelling');
            $this->Bestelling->contain('Gebruiker','Betaalmethode');
            $this->data = $this->Bestelling->read(null, $bestelling_id);
            
            if($this->data['Bestelling']['gebruiker_id'] != $this->Auth->user('id'))
            {
                $this->Session->setFlash(__("U heeft geen toegang tot deze bestelling", true), 'flash_error');
                $this->redirect('/');
            }
        }
        
        function ideal($bestelling_id)
        {
            
        }
        
        function paypal($bestelling_id)
        {
            
        }
        
        function bevestigen()
        {
            if(!empty($this->data))
            {
                if($this->data['Bestelling']['akkoord'])
                {
                    // opslaan
                    $this->loadModel('Bestelling');
                    
                    if($bestelling_id = $this->Bestelling->saveFromWinkelwagen($this->params))
                    {
                        // wagentje resetten
                        $betaalmethode = $this->params['winkelwagen']['betaling']['methode']['key'];
                        $this->_laadWinkelwagen(true);
                        
                        // betalingen
                        switch($betaalmethode)
                        {
                            case 'ideal' :
                                $this->redirect('/winkelwagen/ideal/' . $bestelling_id);
                                break;
                                
                            case 'paypal' : 
                                $this->redirect('/winkelwagen/paypal/' . $bestelling_id);
                                break;
                                
                            case 'overboeking' : 
                            case 'machtiging' :
                                $this->Bestelling->stuurBevestigingsmail($bestelling_id);
                                $this->redirect('/winkelwagen/besteld/' . $bestelling_id);
                                break;
                                
                            default: 
                                $this->Bestelling->stuurBevestigingsmail($bestelling_id);
                                $this->redirect('/winkelwagen/besteld/' . $bestelling_id);
                        }
                    }
                    else
                    {
                        $this->Session->setFlash(__("Er is een fout ontstaan bij het plaatsen van de bestelling", true), 'flash_error');
                    }
                }
                else
                {
                    $this->Session->setFlash(__("U dient akkoord te gaan met de algemene voorwaarden", true), 'flash_error');
                }
            }
        }
    }
?>
