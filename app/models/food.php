<?php

class Food extends BaseModel {

    public $id, $name, $volume, $unit, $added, $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_volume');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Food');
        $query->execute();
        $rows = $query->fetchAll();
        $foods = array();

        foreach ($rows as $row) {
            $foods[] = new Food(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'volume' => $row['volume'],
                'unit' => $row['unit'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
        }
        return $foods;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Food WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $food = new Food(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'volume' => $row['volume'],
                'unit' => $row['unit'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
            return $food;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Food (name, volume, unit, added, updated) VALUES (:name, :volume, :unit, CURRENT_DATE, CURRENT_DATE) RETURNING id');
        $query->execute(array('name' => $this->name, 'volume' => $this->volume, 'unit' => $this->unit)); //, 'added' => $this->added, 'updated' => $this->updated

        $row = $query->fetch();

//        Kint::trace();
//        Kint::dump($row);

        $this->id = $row['id'];
    }

    public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->name) < 3) {
            $errors[] = 'Nimen pituuden tulee olla vähintään kolme merkkiä!';
        }
        return $errors;
    }

    public function validate_string_length($string, $length) {
        $errors = array();
        if ($string == '' || $string == null) {
            $errors[] = 'Merkkijono ei saa olla tyhjä!';
        }
        if ($length < 3) {
            $errors[] = 'Merkkijonon pituuden tulee olla vähintään kolme merkkiä!';
        }
        return $errors;
    }

    public function validate_number($number) {
        $errors = array();
        if ($number == '' || $number == null) {
            $errors[] = 'Määrä ei saa olla tyhjä!';
        }

        if (!is_numeric($number)) {
            $errors[] = 'Määrän tulee olla numero!';
        }

        if ($number < 0) {
            $errors[] = 'Määrän tulee olla vähintään nolla!';
        }
        return $errors;
    }

    public function validate_volume() {
        $errors = array();
        $validate_number = 'validate_number';
        $errors = $this->{$validate_number}($this->volume);
        return $errors;
    }

}
