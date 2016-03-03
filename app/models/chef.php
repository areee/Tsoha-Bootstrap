<?php

class Chef extends BaseModel {

    public $id, $username, $password, $password_verification, $is_admin, $added, $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_username', 'validate_password',
        'validate_password_verification', 'validate_passwords');
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

    public function validate_string_length($method, $string, $length) {
        $errors = array();
        if ($string == '' || $string == null) {
            $errors[] = $method . ' ei saa olla tyhjä!';
        }
        if ($length < 3) {
            $errors[] = $method . ' "' . $string .
                    '": pituuden tulee olla vähintään kolme merkkiä!';
        }
        return $errors;
    }



    public function validate_username() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Käyttäjätunnus', $this->username, strlen($this->username));
        return $errors;
    }

    public function validate_password() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Salasana', $this->password, strlen($this->password));
        return $errors;
    }

    public function validate_password_verification() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Salasanavahvistus', $this->password_verification, strlen($this->password_verification));
        return $errors;
    }

    public function validate_passwords() {
        $errors = array();
        if(strcmp($this->password,$this->password_verification)!==0){
          $errors[] = 'Salasanat eivät täsmää!';
        }
        return $errors;
    }

    //sisään- ja uloskirjautumistoiminnot:
    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Chef WHERE
           username = :username AND password = :password LIMIT 1');
        $query->execute(array(
          'username' => $username,
          'password' => $password));
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
