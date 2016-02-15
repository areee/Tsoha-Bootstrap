<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

//        $errors = array_merge($errors, $this->validators);

        foreach ($this->validators as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
            // käy läpi validators-taulukon ja kutsuu sen sisältämiä validointimetodeja niiden nimellä

            $metodin_nimi = $validator;
            $error = $this->{$metodin_nimi}();

            $errors = array_merge($errors, $error);
        }
//        $errors = array_merge($errors, $validator);

        return $errors;
    }

}
