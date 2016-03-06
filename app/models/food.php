<?php

class Food extends BaseModel {

    public $id, $name, $volume, $unit, $description, $chef_id, $added, $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_description',
        'validate_volume');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Food ORDER BY name ASC');
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

    public static function find_by_recipe_id($id){
        $query = DB::connection()->prepare(
        "SELECT * FROM RecipeFood WHERE recipe_id = :id");
        $query->execute(array('id' => $id));

        $rows = $query->fetchAll();
        $foods = array();

        foreach ($rows as $row) {
            $food = self::find_food_by_id($row['food_id']);
            $foods[] = self::new_food_from_row($id, $row, $food);
        }
        return $foods;
    }

    public static function find_food_by_id($id){
        $query = DB::connection()->prepare(
        "SELECT * FROM Food WHERE id = :id LIMIT 1");
        $query->execute(array('id' => $id));
        $food = $query->fetch();
        return $food;
    }

    public static function new_food_from_row($id, $row, $food)
    {
        return new Food(array(
            'food_id' => $row['food_id'],
            'recipe_id' => $id,
            'name' => $food['name'],
            'volume' => $row['volume'],
            'unit' => $row['unit']
        ));
    }

    // validointimetodit:

    public function validate_string_length($method, $required, $string, $length) {
        $errors = array();
        if ($required == true && ($string == '' || $string == null)) {
            $errors[] = $method . ' ei saa olla tyhjä!';
        }
        if ($required == true && $length < 3) {
          $errors[] = $method . ' "' . $string .
          '": pituuden tulee olla vähintään kolme merkkiä!';
        }
        if(preg_match("/[^A-Za-z0-9åäöÅÄÖ\!?+\.\-\/ ]/",$string)){
          $errors[] = 'Kentässä "' . $method . '" on kiellettyjä merkkejä!';
        }
        return $errors;
    }

    public function validate_name() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Nimi', true, $this->name, strlen($this->name));
        return $errors;
    }

    public function validate_description() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Kuvaus', false, $this->description, strlen($this->description));
        return $errors;
    }

    public function validate_number($method, $number) {
        $errors = array();
        if ($number == '' || $number == null) {
            $errors[] = $method . ' ei saa olla tyhjä!';
        }

        if (!is_numeric($number)) {
            $errors[] = $method . 'n tulee olla numero!';
        }

        if ($number < 0) {
            $errors[] = $method . 'n tulee olla vähintään nolla!';
        }
        return $errors;
    }

    public function validate_volume() {
        $errors = array();
        $validate_number = 'validate_number';
        $errors = $this->{$validate_number}('Määrä', $this->volume);
        return $errors;
    }
}
