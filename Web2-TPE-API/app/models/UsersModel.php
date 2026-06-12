<?php

class UsersModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=futbol_db;charset=utf8','root','',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public function getByUser($usuario) {

        $query = $this->db->prepare("
            SELECT *
            FROM usuario
            WHERE usuario = ?
        ");

        $query->execute([$usuario]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
