<?php

class FoodController extends BaseController {

    public static function index() {
        $foods = Food::all();
        View::make('food/index.html', array('foods' => $foods));
    }

}
