<?php

class ChefController extends BaseController {

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
            $_SESSION['user'] = $chef->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $chef->name . '!'));
        }
    }

}
