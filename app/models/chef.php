<?php

class Chef extends BaseModel {

    public $id, $username, $password, $password_verification, $is_admin, $added, $updated;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_username', 'validate_password',
            'validate_password_verification', 'validate_passwords',
            'validate_username_not_in_use');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Chef ORDER BY username ASC');
        $query->execute();
        $rows = $query->fetchAll();
        $chefs = array();

        foreach ($rows as $row) {
            $chefs[] = self::new_chef_basic($row);
        }
        return $chefs;
    }

    public static function find($id) {
        $query = DB::connection()->prepare(
                'SELECT * FROM Chef WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $chef = self::new_chef_basic($row);
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

    //sisään- ja uloskirjautumistoiminnot:
    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Chef WHERE
           username = :username AND password = :password LIMIT 1');
        $query->execute(array(
            'username' => $username,
            'password' => $password));
        $row = $query->fetch();
        if ($row) {
            // Kokkailija löytyi, palautetaan löytynyt kokkailija oliona
            $chef = self::new_chef_basic($row);
            return $chef;
        }
        // Kokkailijaa ei löytynyt, palautetaan null
        return null;
    }

    private static function new_chef_basic($row) {
        return new Chef(array(
            'id' => $row['id'],
            'username' => $row['username'],
            'password' => $row['password'],
            'is_admin' => $row['is_admin'],
            'added' => $row['added'],
            'updated' => $row['updated']
        ));
    }

    // validointimetodit:
    public function validate_string_length($method, $required, $string, $length) {
        $errors = array();
        if ($required == true && ($string == '' || $string == null)) {
            $errors[] = $method . ' ei saa olla tyhjä!';
        }
        if ($required == true && $length < 3) {
            $errors[] = $method . ' "' . $string .
                    '": pituuden tulee olla vähintään kolme merkkiä!';
        }
        if (preg_match("/[^A-Za-z0-9åäöÅÄÖ]/", $string)) {
            $errors[] = 'Kentässä "' . $method . '" on kiellettyjä merkkejä!';
        }
        return $errors;
    }

    public function validate_username() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Käyttäjätunnus', true, $this->username, strlen($this->username));
        return $errors;
    }

    public function validate_password() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Salasana', true, $this->password, strlen($this->password));
        return $errors;
    }

    public function validate_password_verification() {
        $errors = array();
        $validate_string_length = 'validate_string_length';
        $errors = $this->{$validate_string_length}
                ('Salasanavahvistus', true, $this->password_verification, strlen($this->password_verification));
        return $errors;
    }

    public function validate_passwords() {
        $errors = array();
        if (strcmp($this->password, $this->password_verification) !== 0) {
            $errors[] = 'Salasanat eivät täsmää!';
        }
        return $errors;
    }

    public function validate_username_not_in_use() {
        $chefs = Chef::all();
        $chefnames = array();
        foreach ($chefs as $chef) {
            $chefnames[] = $chef->username;
        }
        $errors = array();
        if (in_array($this->username, $chefnames)) {
            $errors[] = 'Käyttäjänimi on jo varattu, valitse jokin muu!';
        }
        return $errors;
    }

}
