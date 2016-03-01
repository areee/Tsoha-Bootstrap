<?php

class ChefController extends BaseController {

    // käyttäjien CRUD-toiminnot:
    public static function index() {
//        self::check_logged_in();
//        self::check_is_admin();
        $chefs = Chef::all();
        View::make('chef/index.html', array('chefs' => $chefs));
    }

    public static function show($id) {
//        self::check_logged_in();
//        self::check_is_admin();
        $chef = Chef::find($id);
        View::make('chef/show.html', array('chef' => $chef));
    }

    // käyttäjän lisäys:
    public static function store() {
//        self::check_logged_in();
//        self::check_is_admin();
        $params = $_POST;
        $attributes = array(
            'username' => $params['username'],
            'password' => $params['password'],
            'is_admin' => $params['is_admin']
        );

        $chef = new Chef($attributes);
        $errors = $chef->errors();

        if (count($errors) == 0) {
            $chef->save();

            Redirect::to('/chef/' . $chef->id, array('message' => 'Kokkailija on lisätty kokkailijoihin!'));
        } else {
            View::make('chef/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
//        self::check_logged_in();
//        self::check_is_admin();
        View::make('chef/new.html');
    }

    public static function edit($id) {
//        self::check_logged_in();
//        self::check_is_admin();
        $chef = Chef::find($id);
        View::make('chef/edit.html', array('attributes' => $chef));
    }

    // käyttäjän päivitys:
    public static function update($id) {
//        self::check_logged_in();
//        self::check_is_admin();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'username' => $params['username'],
            'password' => $params['password'],
            'is_admin' => $params['is_admin']
        );

        $chef = new Chef($attributes);
        $errors = $chef->errors();

        if (count($errors) > 0) {
            View::make('chef/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $chef->update();

            Redirect::to('/chef/' . $chef->id, array('message' => 'Kokkailija on päivitetty onnistuneesti!'));
        }
    }

    // käyttäjän poisto:
    public static function destroy($id) {
//        self::check_logged_in();
//        self::check_is_admin();
        $chef = new Chef(array('id' => $id));
        $chef->destroy();

        Redirect::to('/chef', array('message' => 'Kokkailija on poistettu onnistuneesti!'));
    }

    //------
    // sisään- ja uloskirjautumistoiminnot -> session/login-kontrolleriin?
    public static function login() {
        View::make('chef/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $chef = Chef::authenticate($params['username'], $params['password']);

        if (!$chef) {
            View::make('chef/login.html', array('error' => 'Väärä käyttäjätunnus'
                . ' tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['chef'] = $chef->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $chef->username . '!'));
        }
    }

    public static function logout() {
        $_SESSION['chef'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}
