<?php

class Food extends BaseModel {

    public $id, $name, $volume, $unit, $description, $chef_id, $added, $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_volume',
            'validate_unit');
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
                'description' => $row['description'],
                'chef_id' => $row['chef_id'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
        }
        return $foods;
    }

    public static function find($id) {
        $query = DB::connection()->prepare(
                'SELECT * FROM Food WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $food = new Food(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'volume' => $row['volume'],
                'unit' => $row['unit'],
                'description' => $row['description'],
                'chef_id' => $row['chef_id'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
            return $food;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare(
                'INSERT INTO Food ('
                . 'name, volume, unit, description, chef_id, added, updated)'
                . 'VALUES (:name, :volume, :unit, :description,'
                . ' :chef_id, CURRENT_DATE, CURRENT_DATE) RETURNING id');
        $query->execute(array(
            'name' => $this->name,
            'volume' => $this->volume,
            'unit' => $this->unit,
            'description' => $this->description,
            'chef_id' => $this->chef_id));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare(
                'UPDATE Food SET name = :name, volume = :volume, unit = :unit,'
                . 'description = :description, updated = CURRENT_DATE WHERE id = :id');
        $query->execute(array(
            'name' => $this->name,
            'volume' => $this->volume,
            'unit' => $this->unit,
            'description' => $this->description,
            'id' => $this->id));
        $row = $query->fetch();
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Food WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    // validointimetodit:
    public function validate_name() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ($this->name, strlen($this->name));
        return $errors;
    }

    public function validate_string_length($string, $length) {
        $errors = array();
        if ($string == '' || $string == null) {
            $errors[] = 'Merkkijono ei saa olla tyhjä!';
        }
        if ($length < 3) {
            $errors[] = 'Merkkijonon "' . $string .
                    '" pituuden tulee olla vähintään kolme merkkiä!';
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

    // toistaiseksi tarpeeton:
    public function validate_unit() {
        $errors = array();
        if ($this->unit == '' || $this->unit == null) {
            $errors[] = 'Yksikkö tulee olla valittuna!';
        }
        return $errors;
    }

}
