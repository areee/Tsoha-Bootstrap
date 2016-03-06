<?php

class Ingredient extends BaseModel {

    public $id, $recipe_id, $food_id, $volume, $unit, $added, $updated;

    public function __construct($attributes){
      parent::__construct($attributes);
      $this->validators = array('validate_volume','validate_unit');
    }

    public function save() {
        // $ingredient = $this->find_ingredient();
        $query = DB::connection()->prepare(
            'INSERT INTO RecipeFood ('
            . 'recipe_id, food_id, volume, unit, added, updated) VALUES (:recipe_id, :food_id, :volume, :unit, CURRENT_DATE, CURRENT_DATE) RETURNING id');

        // if (!$ingredient) {
        //     $ingredient = $this->new_ingredient_store();
        // }

        // $this->ingredient_id = $ingredient['id'];

        $query->execute(array(
          'recipe_id' => $this->recipe_id,
          'food_id' => $this->food_id,
          'volume' => $this->volume,
          'unit' => $this->unit));

          $row = $query->fetch();

          $this->id = $row['id'];
    }

    public static function delete_from_recipe($id)
    {
        $query = DB::connection()->prepare(
        'DELETE FROM RecipeFood WHERE recipe_id = :id');
        $query->execute(array('id' => $id));
    }

    // validointimetodit:
    public function validate_number($method, $number) {
        $errors = array();
        if ($number == '' || $number == null) {
            $errors[] = $method . ' ei saa olla tyhjä!';
        }

        if (!is_numeric($number)) {
            $errors[] = $method . 'n tulee olla numero!';
        }

        if ($number < 0.000001) {
            $errors[] = $method . 'n tulee olla vähintään 0.000001!';
        }
        return $errors;
    }

    public function validate_volume() {
        $errors = array();
        $validate_number = 'validate_number';
        $errors = $this->{$validate_number}('Määrä', $this->volume);
        return $errors;
    }

    public function validate_unit() {
        $errors = array();
        if ($this->unit== '' || $this->unit == null) {
            $errors[] = 'Yksikkö ei saa olla tyhjä!';
        }
        if (!$this->unit == 'kilogrammaa' || !$this->unit == 'litraa' || !$this->unit == 'kappaletta') {
          $errors[] = 'Väärä yksikkö "' . $this->unit .
          '"! Käytä yksikkönä joko kilogrammaa, litraa tai kappaletta.';
        }
        if(preg_match("/[^A-Za-z]/",$this->unit)){
          $errors[] = 'Yksikkö-kentässä on kiellettyjä merkkejä!';
        }
        return $errors;
    }
}
