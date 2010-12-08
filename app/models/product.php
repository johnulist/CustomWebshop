<?php
    class Product extends AppModel
    {
        var $name = 'Product';
        var $useTable = 'producten';
        var $actsAs = array(
            'Slug' => array('separator' => '-', 'overwrite' => true, 'label' => 'naam'),
            'CounterCacheHabtm'
        );

        // Relaties met andere modellen
        var $belongsTo = array('Merk','Attributenset');
        var $hasMany = array('Productafbeelding' => array('foreignKey' => 'product_id', 'order' => 'Productafbeelding.isHoofdafbeelding DESC, Productafbeelding.id ASC'));
        var $hasAndBelongsToMany = array(
            'Categorie' => array(
                'joinTable' => 'categorien_producten',
                'foreignKey' => 'product_id',
                'associationForeignKey' => 'categorie_id',
                'unique' => true
            )
        );

        function afterFind($results, $primary)
        {
            // Itereren over producten
            if($primary)
            {
                foreach ($results as $key => $val)
                {
                    // Controleren of we een product kunnen vinden
                    if (isset($val['Product']))
                    {
                        $results[$key]['Product']['prijs'] = (empty($val['Product']['aanbiedingsprijs']) ? $val['Product']['verkoopprijs'] : $val['Product']['aanbiedingsprijs']);
                        $results[$key]['Product']['btw_bedrag'] = $results[$key]['Product']['prijs'] * ($val['Product']['btw'] / 100);
                    }
                }
            }

            return $results;
        }

        /**
         * Upload een afbeelding indien aanwezig en
         * voegt deze toe aan het product.
         * 
         * @param array $data PHP array met uploaddata
         */
        function checkUpload($data)
        {
            if(is_uploaded_file($data['Afbeelding']['tmp_name']))
            {
                if($bestandsnaam = $this->uploadBestand($data['Afbeelding']['data'], 'img/producten/'))
                {
                    $this->Productafbeelding->create();
                    $afbeelding = array('Productafbeelding' => array(
                        'bestandsnaam' => $bestandsnaam,
                        'product_id' => $data['Product']['id']
                    ));
                    $this->Productafbeelding->save($afbeelding);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                // Upload skippen
                return true;
            }
        }

        /**
         * Stelt een hoofdafbeelding in bij een product. De voorgaande
         * hoofdafbeelding wordt tevens uitgezet.
         *
         * @param integer $product_id       ID van het product
         * @param integer $afbeelding_id    ID van de nieuwe hoofdafbeelding
         */
        function setHoofdafbeelding($product_id, $afbeelding_id)
        {
            $this->query("UPDATE productafbeeldingen SET isHoofdafbeelding = 0 WHERE product_id = '$product_id'");
            $this->query("UPDATE productafbeeldingen SET isHoofdafbeelding = 1 WHERE id = '$afbeelding_id'");

            return true;
        }
    }
 ?>