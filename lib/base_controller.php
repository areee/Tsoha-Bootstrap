<?php

class BaseController {

    public static function get_user_logged_in() {
        // Toteuta kirjautuneen käyttäjän haku tähän
        // Katsotaan onko user-avain sessiossa
        if (isset($_SESSION['chef'])) {
            $chef_id = $_SESSION['chef'];
            // Pyydetään User-mallilta käyttäjä session mukaisella id:llä
            $chef = Chef::find($chef_id);

            return $chef;
        }
        // Käyttäjä ei ole kirjautunut sisään
        return null;
    }

    public static function check_logged_in() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).

        if (!isset($_SESSION['chef'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

    public static function check_is_admin() {
        // metodi tarkistaa, onko kirjautuneella käyttäjällä admin-oikeudet
        if (isset($_SESSION['chef'])) {
            $chef_id = $_SESSION['chef'];
            $chef = Chef::find($chef_id);
            $is_admin = $chef->is_admin;

            if (!$is_admin) {
                Redirect::to('/', array('message' => 'Toiminto epäonnistui, sillä et ole ylläpitäjä!'));
            }
        } else {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

    public static function get_admin_status() {
        // Toteuta kirjautuneen käyttäjän haku tähän
        // Katsotaan onko user-avain sessiossa
        if (isset($_SESSION['chef'])) {
            $chef_id = $_SESSION['chef'];
            // Pyydetään User-mallilta käyttäjä session mukaisella id:llä
            $chef = Chef::find($chef_id);
            $is_admin = $chef->is_admin;
            return $is_admin;
        }
        // Käyttäjä ei ole kirjautunut sisään
        return null;
    }

}
