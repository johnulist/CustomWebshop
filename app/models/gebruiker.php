<?php
    class Gebruiker extends AppModel
    {
        var $useTable = 'gebruikers';
        var $hasMany = array(
            'Bestelling' => array('counterCache' => 'count_bestellingen', 'conditions' => 'Bestelling.factuurnummer IS NULL'),
            'Factuur' => array('className' => 'Bestelling', 'counterCache' => 'count_bestellingen', 'conditions' => 'Factuur.factuurnummer IS NOT NULL')
        );

        var $displayField = 'contactpersoon';

        var $validate = array(
            'wachtwoord_invoeren' => array(
                'minLengthCreate' => array(
                    'required' => true,
                    'on' => 'create',
                    'rule' => array('minLength', 6),
                    'message' => 'Voer een wachtwoord van minstens 6 tekens in',
                    'last' => true
                ),
                'minLengthUpdate' => array(
                    'required' => false,
                    'on' => 'update',
                    'rule' => array('minLength', 6),
                    'message' => 'Voer een wachtwoord van minstens 6 tekens in',
                    'last' => true
                ),
                'identicalFieldValues' => array(
                    'rule' => array('identicalFieldValues', 'wachtwoord_herhalen' ),
                    'message' => 'De ingevoerde wachtwoorden komen niet overeen'
                )
            ),
            'emailadres' => array(
                'isUnique' => array(
                    'rule' => 'isUnique',
                    'message' => 'Dit emailadres is al geregistreerd',
                    'empty' => false,
                    'last' => true
                ),
                'valid' => array(
                    'rule' => 'email',
                    'message' => 'Voer een geldig emailadres in'
                )
            )
        );

        function beforeValidate()
        {
            if(empty($this->data['Gebruiker']['wachtwoord_invoeren']))
            {
                unset($this->data['Gebruiker']['wachtwoord_invoeren']);
            }
            return true;
        }

        function beforeSave()
        {
            if(!empty($this->data['Gebruiker']['wachtwoord_invoeren']))
            {
                // Indien nieuw wachtwoord: overnemen!
                $this->data['Gebruiker']['wachtwoord'] = $this->data['Gebruiker']['wachtwoord_invoeren'];
            }

            return true;
        }
    }
?>