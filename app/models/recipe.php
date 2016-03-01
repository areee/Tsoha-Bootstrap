<?php

class Recipe extends BaseModel {

    public $id, $name, $volume, $unit, $instructions, $source, $portions,
            $description, $chef_id, $added, $updated;

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
                'description' => $row['description'],
                'chef_id' => $row['chef_id'],
                'added' => $row['added'],
                'updated' => $row['updated']
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
                'volume' => $row['volume'],
                'unit' => $row['unit'],
                'instructions' => $row['instructions'],
                'source' => $row['source'],
                'portions' => $row['portions'],
                'description' => $row['description'],
                'chef_id' => $row['chef_id'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
            return $recipe;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare(
                'INSERT INTO Recipe ('
                . 'name, volume, unit, instructions, source,'
                . 'portions, description, chef_id, added, updated)'
                . 'VALUES (:name, :volume, :unit, :instructions, :source,'
                . ':portions, :description, :chef_id, CURRENT_DATE, CURRENT_DATE)'
                . ' RETURNING id');
        $query->execute(array(
            'name' => $this->name,
            'volume' => $this->volume,
            'unit' => $this->unit,
            'instructions' => $this->instructions,
            'source' => $this->source,
            'portions' => $this->portions,
            'description' => $this->description,
            'chef_id' => $this->chef_id));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare(
                'UPDATE Recipe SET name = :name,'
                . 'volume = :volume, unit = :unit, instructions = :instructions,'
                . 'source = :source, portions = :portions,'
                . 'description = :description,'
                . 'updated = CURRENT_DATE WHERE id = :id');
        $query->execute(array(
            'name' => $this->name,
            'volume' => $this->volume,
            'unit' => $this->unit,
            'instructions' => $this->instructions,
            'source' => $this->source,
            'portions' => $this->portions,
            'description' => $this->description,
            'id' => $this->id));
        $row = $query->fetch();
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Recipe WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

}
