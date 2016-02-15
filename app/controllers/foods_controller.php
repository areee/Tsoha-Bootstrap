<?php

class FoodController extends BaseController {

    public static function index() {
        $foods = Food::all();
        View::make('food/index.html', array('foods' => $foods));
    }

    public static function show($id) {
        $food = Food::find($id);
        View::make('food/show.html', array('food' => $food));
    }

    public static function store() {
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
        View::make('food/new.html');
    }

    public static function edit($id) {
        $food = Food::find($id);
        View::make('food/edit.html', array('attributes' => $food));
    }

    public static function update($id) {
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
        $food = new Food(array('id' => $id));
        $food->delete();

        Redirect::to('/food', array('message' => 'Raaka-aine on poistettu onnistuneesti!'));
    }

}
