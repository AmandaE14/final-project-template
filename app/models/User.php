<?php

namespace app\models;

class User extends Model {
    protected $table = 'users';

    public function create($data) {
        $query = "INSERT INTO $this->table (username, password) VALUES (:username, :password)";
        $this->query($query, $data);
    }
}
