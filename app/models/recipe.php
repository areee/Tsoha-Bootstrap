<?php

class Recipe extends BaseModel {

    public $id, $name, $volume, $unit, $instructions, $source, $portions, $added,
            $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
//        $this->validators = array('validate_name', 'validate_volume', 'validate_unit');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Recipe');
        $query->execute();
        $rows = $query->fetchAll();
        $recipes = array();

        foreach ($rows as $row) {
            $recipes[] = new Recipe(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'volume' => $row['volume'],
                'unit' => $row['unit'],
                'instructions' => $row['instructions'],
                'source' => $row['source'],
                'portions' => $row['portions'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
        }
        return $recipes;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Recipe WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $recipe = new Recipe(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'volume' => $row['volume'],
                'unit' => $row['unit'],
                'instructions' => $row['instructions'],
                'source' => $row['source'],
                'portions' => $row['portions'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
            return $recipe;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare(
                'INSERT INTO Recipe (name, volume, unit, instructions, source,'
                . 'portions, added, updated) VALUES (:name, :volume, :unit,'
                . ' :instructions, :source, :portions, CURRENT_DATE,'
                . ' CURRENT_DATE) RETURNING id');
        $query->execute(array('name' => $this->name, 'volume' => $this->volume,
            'unit' => $this->unit, 'instructions' => $this->instructions,
            'source' => $this->source, 'portions' => $this->portions));

        $row = $query->fetch();

//        Kint::trace();
//        Kint::dump($row);

        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Recipe SET name = :name,'
                . ' volume = :volume, unit = :unit, instructions = :instructions,'
                . ' source = :source, portions = :portions,'
                . ' updated = CURRENT_DATE WHERE id = :id');
        $query->execute(array('name' => $this->name, 'volume' => $this->volume,
            'unit' => $this->unit, 'instructions' => $this->instructions,
            'source' => $this->source, 'portions' => $this->portions,
            'id' => $this->id));
        $row = $query->fetch();

//        Kint::dump($row);
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Recipe WHERE id = :id');
        $query->execute(array('id' => $this->id));

////        Kint::trace();
////        Kint::dump($row);
    }

//    public function validate_name() {
//        $errors = array();
//        $validate_string_length = 'validate_string_length';
//        $errors = $this->{$validate_string_length}($this->name, strlen($this->name));
////        if ($this->name == '' || $this->name == null) {
////            $errors[] = 'Nimi ei saa olla tyhjä!';
////        }
////        if (strlen($this->name) < 3) {
////            $errors[] = 'Nimen pituuden tulee olla vähintään kolme merkkiä!';
////        }
//        return $errors;
//    }
//
//    public function validate_string_length($string, $length) {
//        $errors = array();
//        if ($string == '' || $string == null) {
//            $errors[] = 'Merkkijono ei saa olla tyhjä!';
//        }
//        if ($length < 3) {
//            $errors[] = 'Merkkijonon "' . $string . '" pituuden tulee olla vähintään kolme merkkiä!';
//        }
//        return $errors;
//    }
//
//    public function validate_number($number) {
//        $errors = array();
//        if ($number == '' || $number == null) {
//            $errors[] = 'Määrä ei saa olla tyhjä!';
//        }
//
//        if (!is_numeric($number)) {
//            $errors[] = 'Määrän tulee olla numero!';
//        }
//
//        if ($number < 0) {
//            $errors[] = 'Määrän tulee olla vähintään nolla!';
//        }
//        return $errors;
//    }
//
//    public function validate_volume() {
//        $errors = array();
//        $validate_number = 'validate_number';
//        $errors = $this->{$validate_number}($this->volume);
//        return $errors;
//    }
//
//    public function validate_unit() {
//        $errors = array();
//        if ($this->unit == '' || $this->unit == null) {
//            $errors[] = 'Yksikkö tulee olla valittuna!';
//        }
//        return $errors;
//    }
}
