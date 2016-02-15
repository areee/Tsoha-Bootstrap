<?php

class BaseController {

    public static function get_user_logged_in() {
        // Toteuta kirjautuneen käyttäjän haku tähän
        // Katsotaan onko user-avain sessiossa
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];
            // Pyydetään User-mallilta käyttäjä session mukaisella id:llä
            $user = Chef::find($user_id);

            return $user;
        }

        return null;
    }

    public static function check_logged_in() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

}
