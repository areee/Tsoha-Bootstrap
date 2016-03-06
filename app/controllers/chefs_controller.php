<?php

class ChefController extends BaseController {

    // kokkailijoiden CRUD-toiminnot:
    // kaikki käyttäjät:
    public static function index() {
        self::check_logged_in();
        self::check_is_admin();
        $chefs = Chef::all();
        View::make('chef/index.html', array('chefs' => $chefs));
    }

    // näytä yksittäinen kokkailija:
    public static function show($id) {
        self::check_logged_in();
        self::check_is_admin();
        $chef = Chef::find($id);
        View::make('chef/show.html', array('chef' => $chef));
    }

    // kokkailijan lisäys
    // (onnistuu sekä ylläpitäjältä, että rekisteröimättömältä kokkailijalta):
    public static function create() {
        View::make('chef/new.html');
    }

    public static function store() {
        $params = $_POST;
        $attributes = self::get_attributes($params, null);

        $chef = new Chef($attributes);
        $errors = $chef->errors();

        if (count($errors) == 0) {
            $chef->save();

            Redirect::to('/chef/' . $chef->id, array(
                'message' => 'Kokkailija on lisätty kokkailijoihin!'));
        } else {
            View::make('chef/new.html', array(
                'errors' => $errors, 'attributes' => $attributes));
        }
    }

    // kokkailijan päivitys:
    public static function edit($id) {
        self::check_logged_in();
        self::check_is_admin();
        $chef = Chef::find($id);
        View::make('chef/edit.html', array('attributes' => $chef));
    }

    public static function update($id) {
        self::check_logged_in();
        self::check_is_admin();
        $params = $_POST;

        $attributes = self::get_attributes($params, $id);

        $chef = new Chef($attributes);

        // Tässä välissä olisi kokkailijan validointi. 
        // Se on kuitenkin otettu pois käytöstä, sillä en onnistunut päivittämään
        // kokkailijaa käyttämättä validate_username_not_in_use -funktiota.

        $chef->update();
        Redirect::to('/chef/' . $chef->id, array('message' => 'Kokkailija on päivitetty onnistuneesti!'));
    }

    // kokkailijan poisto:
    public static function destroy($id) {
        self::check_logged_in();
        self::check_is_admin();
        $chef = new Chef(array('id' => $id));
        $chef->destroy();

        Redirect::to('/chef', array('message' => 'Kokkailija on poistettu onnistuneesti!'));
    }

    private static function get_attributes($params, $id) {
        $attributes = array(
            'id' => $id,
            'username' => $params['username'],
            'password' => $params['password'],
            'password_verification' => $params['password_verification'],
            'is_admin' => $params['is_admin']);
        return $attributes;
    }

}
