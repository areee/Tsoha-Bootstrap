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
        $food = new Food(array(
            'name' => $params['name'],
            'volume' => $params['volume'],
            'unit' => $params['unit'],
            'added' => $params['added'],
            'updated' => $params['updated']
        ));

//        Kint::dump($params);

        $food->save();

        Redirect::to('/food/' . $food->id, array('message' => 'Raaka-aine on lisätty Ruokakomeroon!'));
    }

    public static function create() {
        View::make('food/new.html');
    }

}
