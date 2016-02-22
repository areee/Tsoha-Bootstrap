<?php

class FoodController extends BaseController {

    public static function index() {
        self::check_logged_in();
        $foods = Food::all();
        View::make('food/index.html', array('foods' => $foods));
    }

    public static function show($id) {
        self::check_logged_in();
        $food = Food::find($id);
        View::make('food/show.html', array('food' => $food));
    }

    public static function store() {
        self::check_logged_in();
        self::check_is_admin();
        $params = $_POST;
        $attributes = array(
            'name' => $params['name'],
            'volume' => $params['volume'],
            'unit' => $params['unit']
        );

//        $food = new Food(array(
//            'name' => $params['name'],
//            'volume' => $params['volume'],
//            'unit' => $params['unit'],
////            'added' => $params['added'],
////            'updated' => $params['updated']
//        ));
//        Kint::dump($params);

        $food = new Food($attributes);
        $errors = $food->errors();

        if (count($errors) == 0) {
            $food->save();

            Redirect::to('/food/' . $food->id, array('message' => 'Raaka-aine on lisätty Ruokakomeroon!'));
        } else {
            View::make('food/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        self::check_logged_in();
        self::check_is_admin();
        View::make('food/new.html');
    }

    public static function edit($id) {
        self::check_logged_in();
        self::check_is_admin();
        $food = Food::find($id);
        View::make('food/edit.html', array('attributes' => $food));
    }

    public static function update($id) {
        self::check_logged_in();
        self::check_is_admin();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'volume' => $params['volume'],
            'unit' => $params['unit'],
//            'updated' => $params['updated']
        );

//        Kint::dump($params);

        $food = new Food($attributes);
        $errors = $food->errors();

        if (count($errors) > 0) {
            View::make('food/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $food->update();

            Redirect::to('/food/' . $food->id, array('message' => 'Raaka-aine on päivitetty onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        self::check_is_admin();
        $food = new Food(array('id' => $id));
        $food->destroy();

        Redirect::to('/food', array('message' => 'Raaka-aine on poistettu onnistuneesti!'));
    }

}
