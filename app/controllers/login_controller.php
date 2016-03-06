<?php

require_once 'app/models/chef.php';

class LoginController extends BaseController {

    public static function create() {
        View::make('session/new.html');
    }

    public static function store() {
        $params = $_POST;

        $chef = Chef::authenticate($params['username'], $params['password']);

        if (!$chef) {
            View::make('session/new.html', array('error' => 'Väärä käyttäjätunnus'
                . ' tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['chef'] = $chef->id;
            Redirect::to('/', array('message' => 'Tervetuloa takaisin '
                . $chef->username . '!'));
        }
    }

    public static function destroy() {
        $_SESSION['chef'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}
