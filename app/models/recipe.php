<?php

class Recipe extends BaseModel {

    public $id, $name, $instructions, $source, $portions, $description, $chef_id,
            $added, $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_instructions',
            'validate_source', 'validate_portions', 'validate_description');
    }

    public static function all() {
        $query = DB::connection()->prepare(
                'SELECT * FROM Recipe ORDER BY name ASC');
        $query->execute();
        $rows = $query->fetchAll();
        $recipes = array();

        foreach ($rows as $row) {
            $recipes[] = new Recipe(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'instructions' => $row['instructions'],
                'source' => $row['source'],
                'portions' => $row['portions'],
                'description' => $row['description'],
                'chef_id' => $row['chef_id'],
                'added' => date("d.m.Y", strtotime($row['added'])),
                'updated' => date("d.m.Y", strtotime($row['updated']))
            ));
        }
        return $recipes;
    }

    public static function find($id) {
        $query = DB::connection()->prepare(
                'SELECT * FROM Recipe WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $recipe = new Recipe(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'instructions' => $row['instructions'],
                'source' => $row['source'],
                'portions' => $row['portions'],
                'description' => $row['description'],
                'chef_id' => $row['chef_id'],
                'added' => date("d.m.Y", strtotime($row['added'])),
                'updated' => date("d.m.Y", strtotime($row['updated']))
            ));
            return $recipe;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare(
                'INSERT INTO Recipe ('
                . 'name, instructions, source, portions, description, chef_id,'
                . 'added, updated)'
                . 'VALUES (:name, :instructions, :source, :portions,'
                . ':description, :chef_id, CURRENT_DATE, CURRENT_DATE)'
                . 'RETURNING id');
        $query->execute(array(
            'name' => $this->name,
            'instructions' => $this->instructions,
            'source' => $this->source,
            'portions' => $this->portions,
            'description' => $this->description,
            'chef_id' => $this->chef_id));

        $row = $query->fetch();
        $this->id = $row['id'];
        return $this->id;
    }

    public function update() {
        $query = DB::connection()->prepare(
                'UPDATE Recipe SET name = :name,'
                . 'instructions = :instructions,'
                . 'source = :source,'
                . 'portions = :portions,'
                . 'description = :description,'
                . 'updated = CURRENT_DATE WHERE id = :id');
        $query->execute(array(
            'name' => $this->name,
            'instructions' => $this->instructions,
            'source' => $this->source,
            'portions' => $this->portions,
            'description' => $this->description,
            'id' => $this->id));
        $row = $query->fetch();
    }

    public function destroy() {
        Ingredient::delete_from_recipe($this->id);
        // Ingredient::delete_unused();

        $query = DB::connection()->prepare('DELETE FROM Recipe WHERE id = :id');
        $query->execute(array('id' => $this->id));
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
        if (preg_match("/[^A-Za-z0-9åäöÅÄÖ\!?+\.\-\/ ]/", $string)) {
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

    public function validate_instructions() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Ohjeet', true, $this->instructions, strlen(
                        $this->instructions));
        return $errors;
    }

    public function validate_source() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Lähde', true, $this->source, strlen($this->source));
        return $errors;
    }

    public function validate_description() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Kuvaus', false, $this->description, strlen(
                        $this->description));
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

    public function validate_portions() {
        $errors = array();
        $validate_number = 'validate_number';
        $errors = $this->{$validate_number}('Määrä', $this->portions);
        return $errors;
    }

}
