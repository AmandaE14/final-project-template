<?php

namespace app\models;

abstract class Model {
    private function connect() {
        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        return new \PDO($string, DBUSER, DBPASS);
    }

    public function query($query, $data = []) {
        $con = $this->connect();
        $stm = $con->prepare($query);
        $stm->execute($data);
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }
}