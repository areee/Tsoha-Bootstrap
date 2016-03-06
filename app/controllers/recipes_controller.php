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
        $chef = Chef::find($recipe->chef_id);
        $foods = Food::find_by_recipe_id($id);
        View::make('recipe/show.html', array('recipe' => $recipe, 'chef'=> $chef, 'foods'=> $foods));
    }

    // reseptin lisäys:
    public static function store() {
        self::check_logged_in();
//        self::check_is_admin();
        $params = self::trim_double_spaces_from_params($_POST);

        // $params['name'] = preg_replace('/\s+/', ' ', $params['name']);
        // $params['instructions'] = preg_replace('/\s+/', ' ', $params['instructions']);
        // $params['source'] = preg_replace('/\s+/', ' ', $params['source']);
        // $params['portions'] = preg_replace('/\s+/', ' ', $params['portions']);
        // $params['description'] = preg_replace('/\s+/', ' ', $params['description']);

        $chef_id = self::get_user_logged_in()->id;
        $ingredients = self::create_ingredients($params, false);
        // $foods = $params['foods'];
        // $food = $params['food'];

        // if (count($ingredients) == 0) {
          // $recipe->save();
          // Redirect::to('/recipe/' . $recipe->id, array('message' => 'Resepti on lisätty Reseptipankkiin!'));
        // }
        // else {
            // View::make('recipe/new.html', array('errors' => $errors, 'attributes' => $attributes));
        // }

        $attributes = array(
            'name' => $params['name'],
            'instructions' => $params['instructions'],
            'source' => $params['source'],
            'portions' => $params['portions'],
            'description' => $params['description']
            // 'chef_id' => self::get_user_logged_in()->id // voidaan hoitaa myös erikseen, ei listassa
            // 'food' => array() // ei periaatteessa kuulu tänne
            // 'food' => $food
        );

        // foreach ($foods as $food) {
        //   $attributes['foods'][] = $food;
        // }

        // $array = array();
        // foreach ($ingredients as $key => $ingredient) {
        //     $array['name' . $key] = $ingredient->name;
        //     $array['quantity' . $key] = $ingredient->quantity;
        // }


        $recipe = new Recipe($attributes);
        $errors = $recipe->errors();

        if (count($errors) == 0 && !in_array("validate", $ingredients)) {
            // $recipe->save();
            // Redirect::to('/recipe/' . $recipe->id, array('message' => 'Resepti on lisätty Reseptipankkiin!'));
            self::save_and_redirect($params, $chef_id, $ingredients);
        } else {
            View::make('recipe/new.html', array('errors' => $errors,
            'ingredient_errors'=> $ingredients, 'attributes' => $params));
        }
    }

    public static function create_ingredients($params, $edit) {
        $foods = $params['foods'];
        // $attributes = array(
        // 'food' => array()
        // );
        // foreach ($foods as $food) {
        //   $attributes['foods'][] = $food;
        // }
        $ingredients = array();
        $i = 'volume';
        $q = 'unit';
        if ($edit) {
            $i = $i . 'New';
            $q = $q . 'New';
        }
        foreach ($params[$i] as $index => $row) { // kaikki kentät, joissa 'volume', käydään yksitellen läpi $row:na
            // ei huomioida tyhjiä kenttiä
            if (strlen(trim($row) . '' . trim($params[$q][$index])) > 0) {
              $food_id = $foods[$index]; // otetaan talteen samassa tahdissa raaka-aineen id:n

                $ingredient = new Ingredient(array(
                    'food_id' => $food_id,
                    'volume' => preg_replace('/\s+/', ' ', $row), //"raaka-aine" esim. suola
                    'unit' => preg_replace('/\s+/', ' ', $params[$q][$index]) //"määrä" esim. 1 tl
                ));
                $errors = $ingredient->errors();
                $ingredients[] = $ingredient;
            }
        }
        if (count($errors) == 0) {
          // $recipe->save();
          return $ingredients;
          // Redirect::to('/recipe/' . $recipe->id, array('message' => 'Resepti on lisätty Reseptipankkiin!'));
        }
        // else {
            // View::make('recipe/new.html', array('errors' => $errors, 'params' => $params));
        // }
        return $errors;
    }

    public static function save_and_redirect($params, $chef_id, $ingredients) {
        $recipe = self::create_recipe_base($params, $chef_id);
        $recipe_id = $recipe->save();
        self::save_ingredients_for_recipe($ingredients, $recipe_id);

        Redirect::to('/recipe/' . $recipe->id, array('message' => 'Resepti on lisätty Reseptipankkiin!'));
    }

    public static function trim_double_spaces_from_params($params) {
        $params['name'] = preg_replace('/\s+/', ' ', $params['name']);
        $params['instructions'] = preg_replace('/\s+/', ' ', $params['instructions']);
        $params['source'] = preg_replace('/\s+/', ' ', $params['source']);
        $params['portions'] = preg_replace('/\s+/', ' ', $params['portions']);
        $params['description'] = preg_replace('/\s+/', ' ', $params['description']);
        return $params;
    }

    public static function create_recipe_base($params, $chef_id) {
        $recipe = new Recipe(array(
            'name' => $params['name'],
            'instructions' => $params['instructions'],
            'source' => $params['source'],
            'portions' => $params['portions'],
            'description' => $params['description'],
            'chef_id' => $chef_id
          ));
        return $recipe;
    }

    public static function save_ingredients_for_recipe($ingredients, $recipe_id)
    {
        foreach ($ingredients as $ingredient) { // käydään yksitellen läpi jokainen raaka-aine
            $ingredient->recipe_id = $recipe_id;
            $ingredient->save();
        }
    }

    public static function create() {
        self::check_logged_in();
//        self::check_is_admin();
        $foods = Food::all();
        // View::make('recipe/new.html');
        View::make('recipe/new.html', array('foods'=> $foods));
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
