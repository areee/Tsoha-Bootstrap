<?php

class Chef extends BaseModel {

    public $id, $username, $password, $is_admin, $added, $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function authenticate() {
        $query = DB::connection()->prepare('SELECT * FROM Chef WHERE username = :username AND password = :password LIMIT 1');
        $query->execute(array('username' => $username, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            // Käyttäjä löytyi, palautetaan löytynyt käyttäjä oliona
            $chef = new Chef(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password'],
                'is_admin' => $row['is_admin'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
            return $chef;
        }
        // Käyttäjää ei löytynyt, palautetaan null
        return null;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Chef WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $chef = new User(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password'],
                'is_admin' => $row['is_admin'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
            return $chef;
        }
        return null;
    }

}
