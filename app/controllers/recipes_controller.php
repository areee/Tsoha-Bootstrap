<?php

class RecipeController extends BaseController {

    public static function index() {
        self::check_logged_in();
        $recipes = Recipe::all();
        View::make('recipe/index.html', array('recipes' => $recipes));
    }

    public static function show($id) {
        self::check_logged_in();
        $recipe = Recipe::find($id);
        View::make('recipe/show.html', array('recipe' => $recipe));
    }

    // reseptin lisäys:
    public static function store() {
        self::check_logged_in();
//        self::check_is_admin();
        $params = $_POST;
        $foods = $params['foods']; // testaa, toimiiko!
        $attributes = array(
            'name' => $params['name'],
            'food' => array(), //testaa, toimiiko!
//            'volume' => $params['volume'],
//            'unit' => $params['unit'],
            'instructions' => $params['instructions'],
            'source' => $params['source'],
            'portions' => $params['portions'],
            'description' => $params['description'],
            'chef_id' => self::get_user_logged_in()->id
        );

        //testaa, toimiiko!
        foreach ($foods as $food) {
          $attributes['foods'][] = $food;
        }

        $recipe = new Recipe($attributes);
        $errors = $recipe->errors();

        if (count($errors) == 0) {
            $recipe->save();

            Redirect::to('/recipe/' . $recipe->id, array('message' => 'Resepti on lisätty Reseptipankkiin!'));
        } else {
            View::make('recipe/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        self::check_logged_in();
//        self::check_is_admin();
        View::make('recipe/new.html');
    }

    public static function edit($id) {
        self::check_logged_in();
//        self::check_is_admin();
        $recipe = Recipe::find($id);
        View::make('recipe/edit.html', array('attributes' => $recipe));
    }

    // reseptin päivitys:
    public static function update($id) {
        self::check_logged_in();
//        self::check_is_admin();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
//            'volume' => $params['volume'],
//            'unit' => $params['unit'],
            'instructions' => $params['instructions'],
            'source' => $params['source'],
            'portions' => $params['portions'],
            'description' => $params['description']
        );

        $recipe = new Recipe($attributes);
        $errors = $recipe->errors();

        if (count($errors) > 0) {
            View::make('recipe/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $recipe->update();

            Redirect::to('/recipe/' . $recipe->id, array('message' => 'Resepti on päivitetty onnistuneesti!'));
        }
    }

    // reseptin poisto:
    public static function destroy($id) {
        self::check_logged_in();
        self::check_is_admin();
        $recipe = new Recipe(array('id' => $id));
        $recipe->destroy();

        Redirect::to('/recipe', array('message' => 'Resepti on poistettu onnistuneesti!'));
    }

}
