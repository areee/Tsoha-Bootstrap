<?php

class RecipeController extends BaseController {

    // kaikki reseptit:
    public static function index() {
        self::check_logged_in();
        $recipes = Recipe::all();
        $chefs = array();
        foreach ($recipes as $recipe) {
            $chefs[$recipe->chef_id] = Chef::find($recipe->chef_id);
        }
        View::make('recipe/index.html', array('recipes' => $recipes,
            'chefs' => $chefs));
    }

    // näytä yksittäinen resepti:
    public static function show($id) {
        self::check_logged_in();
        $recipe = Recipe::find($id);
        $chef = Chef::find($recipe->chef_id);
        $foods = Food::find_by_recipe_id($id);
        View::make('recipe/show.html', array('recipe' => $recipe,
            'chef' => $chef, 'foods' => $foods));
    }

    // reseptin lisäys:
    public static function store() {
        self::check_logged_in();
        $params = self::trim_params($_POST);
        $chef_id = self::get_user_logged_in()->id;
        $ingredients = self::create_ingredients($params);

        $attributes = array(
            'name' => $params['name'],
            'instructions' => $params['instructions'],
            'source' => $params['source'],
            'portions' => $params['portions'],
            'description' => $params['description']
        );
        $recipe = new Recipe($attributes);
        $errors = $recipe->errors();

        if (count($errors) == 0 && !in_array("validate", $ingredients)) {
            self::save_and_redirect($params, $chef_id, $ingredients);
        } else {
            View::make('recipe/new.html', array('errors' => $errors,
                'ingredient_errors' => $ingredients, 'attributes' => $params));
        }
    }

    public static function create() {
        self::check_logged_in();
        $foods = Food::all();
        View::make('recipe/new.html', array('foods' => $foods));
    }

    // reseptin poisto:
    public static function destroy($id) {
        self::check_logged_in();
        self::check_is_admin();

        $recipe = Recipe::find($id);
        $recipe->destroy();
        Redirect::to('/recipe', array(
            'message' => 'Resepti on poistettu onnistuneesti!'));
    }

    // raaka-aineiden luonti:
    private static function create_ingredients($params) {
        $foods = $params['foods'];
        $ingredients = array();
        $i = 'volume';
        $q = 'unit';

        foreach ($params[$i] as $index => $row) {
            // kaikki kentät, joissa 'volume', käydään yksitellen läpi $row:na
            // otetaan talteen samassa tahdissa raaka-aineen id:n:
            $food_id = $foods[$index];

            $ingredient = new Ingredient(array(
                'food_id' => $food_id,
                'volume' => preg_replace(
                        '/\s+/', ' ', $row),
                'unit' => preg_replace(
                        '/\s+/', ' ', $params[$q][$index])
            ));
            $errors = $ingredient->errors();
            $ingredients[] = $ingredient;
        }
        if (count($errors) == 0) {
            return $ingredients;
        }
        return $errors;
    }

    private static function save_and_redirect($params, $chef_id, $ingredients) {
        $recipe = self::create_recipe_base($params, $chef_id);
        $recipe_id = $recipe->save();
        self::save_ingredients_for_recipe($ingredients, $recipe_id);

        Redirect::to('/recipe/' . $recipe->id, array(
            'message' => 'Resepti on lisätty Reseptipankkiin!'));
    }

    private static function trim_params($params) {
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

    public static function save_ingredients_for_recipe($ingredients, $recipe_id) {
        foreach ($ingredients as $ingredient) {
            // käydään yksitellen läpi jokainen raaka-aine:
            $ingredient->recipe_id = $recipe_id;
            $ingredient->save();
        }
    }

}
