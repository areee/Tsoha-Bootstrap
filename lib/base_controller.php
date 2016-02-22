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
    }

}
