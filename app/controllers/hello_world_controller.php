<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
//   	  View::make('home.html');
        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
//        View::make('helloworld.html');
//        $maito = Food::find(2);
//        $foods = Food::all();
//        Kint::dump($foods);
//        Kint::dump($maito);   
        $food = new Food(array(
            'name' => 'd',
            'volume' => '-1',
//            'unit' => 'kilogrammaa'
        ));

        $errors = $food->errors();
        Kint::dump($errors);
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function food_list() {
        View::make('suunnitelmat/food_list.html');
    }

    public static function food_show() {
        View::make('suunnitelmat/food_show.html');
    }

    public static function food_edit() {
        View::make('suunnitelmat/food_edit.html');
    }

    public static function recipe_list() {
        View::make('suunnitelmat/recipe_list.html');
    }

    public static function recipe_show() {
        View::make('suunnitelmat/recipe_show.html');
    }

    public static function recipe_edit() {
        View::make('suunnitelmat/recipe_edit.html');
    }

}
