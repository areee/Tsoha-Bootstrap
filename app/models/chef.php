<?php

class Chef extends BaseModel {

    public $id, $username, $password, $is_admin, $added, $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Chef');
        $query->execute();
        $rows = $query->fetchAll();
        $chefs = array();

        foreach ($rows as $row) {
            $chefs[] = new Chef(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password'],
                'is_admin' => $row['is_admin'],
                'added' => $row['added'],
                'updated' => $row['updated']
            ));
        }
        return $chefs;
    }

    public static function find($id) {
        $query = DB::connection()->prepare(
                'SELECT * FROM Chef WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
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
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare(
                'INSERT INTO Chef ('
                . 'username, password, is_admin, added, updated)'
                . 'VALUES (:username, :password, :is_admin, CURRENT_DATE,'
                . 'CURRENT_DATE) RETURNING id');
        $query->execute(array(
            'username' => $this->username,
            'password' => $this->password,
            'is_admin' => $this->is_admin));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare(
                'UPDATE Chef SET username = :username, password = :password,'
                . 'is_admin = :is_admin, updated = CURRENT_DATE WHERE id = :id');
        $query->execute(array(
            'username' => $this->username,
            'password' => $this->password,
            'is_admin' => $this->is_admin,
            'id' => $this->id));
        $row = $query->fetch();
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Chef WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    // validointimetodit:
    public function validate_name() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ($this->name, strlen($this->name));
        return $errors;
    }

    public function validate_string_length($string, $length) {
        $errors = array();
        if ($string == '' || $string == null) {
            $errors[] = 'Merkkijono ei saa olla tyhjä!';
        }
        if ($length < 3) {
            $errors[] = 'Merkkijonon "' . $string .
                    '" pituuden tulee olla vähintään kolme merkkiä!';
        }
        return $errors;
    }

    //sisään- ja uloskirjautumistoiminnot:
    public static function authenticate($username, $password) {
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

}
