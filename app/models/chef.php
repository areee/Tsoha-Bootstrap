<?php

class User extends BaseModel {

    public $id, $name, $volume, $unit, $added, $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    
}
