<?php
    class Banner extends AppModel
    {
        var $actsAs = 'Tree';
        var $useTable = 'banners';

        /**
         * Upload een afbeelding indien aanwezig en
         * voegt deze toe aan het product.
         *
         * @param array $data PHP array met uploaddata
         */
        function checkUpload($data)
        {
            if(is_uploaded_file($data['Banner']['tmp_name']))
            {
                if($bestandsnaam = $this->uploadBestand($data['Banner']['file'], 'img/banners/'))
                {
                    $this->saveField('afbeelding', $bestandsnaam);
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return true;
            }
        }

        function beforeSave()
        {
            if(!empty($this->data['Banner']['url']))
            {
                $this->data['Banner']['url'] = 'http://' . str_replace('http://','',$this->data['Banner']['url']);
            }

            return true;
        }
    }
?>