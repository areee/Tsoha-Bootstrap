<?php

class Food extends BaseModel {

    public $id, $name, $volume, $unit, $added, $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
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
        
        if($row){
            $food[] = new Food(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'volume' => $row['volume'],
                'unit' => $row['unit'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
            return $food;
        }
        return NULL;
    }

}
