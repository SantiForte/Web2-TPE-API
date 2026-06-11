<?php

require_once __DIR__ . '/../../config.php';

class FutbolistasModel {

    private $db;

    public function __construct() {

        $this->db = $this->connect();
    }

    // CONEXIÓN
    private function connect() {

        return new PDO(
            "mysql:host=" . DB_HOST .
            ";dbname=" . DB_NAME .
            ";charset=utf8",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    // OBTENER TODOS LOS FUTBOLISTAS
    public function getAllWithClub() {

        $query = $this->db->prepare("
            SELECT futbolista.*, club.nombre AS club
            FROM futbolista
            LEFT JOIN club
            ON futbolista.id_club = club.id_club
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // OBTENER UNO POR ID
    public function getById($id) {

        $query = $this->db->prepare("
            SELECT futbolista.*, club.nombre AS club
            FROM futbolista
            LEFT JOIN club
            ON futbolista.id_club = club.id_club
            WHERE futbolista.id_jugador = ?
        ");

        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    // INSERTAR
    public function insert($nombre, $apellido, $posicion, $id_club) {

        $query = $this->db->prepare("
            INSERT INTO futbolista
            (nombre, apellido, posicion, id_club)
            VALUES (?, ?, ?, ?)
        ");

        $query->execute([
            $nombre,
            $apellido,
            $posicion,
            $id_club
        ]);
    }

    // ACTUALIZAR
    public function update($id, $nombre, $apellido, $posicion, $id_club) {

        $query = $this->db->prepare("
            UPDATE futbolista
            SET nombre = ?, apellido = ?, posicion = ?, id_club = ?
            WHERE id_jugador = ?
        ");

        $query->execute([
            $nombre,
            $apellido,
            $posicion,
            $id_club,
            $id
        ]);
    }

    // ELIMINAR
    public function delete($id) {

        $query = $this->db->prepare("
            DELETE FROM futbolista
            WHERE id_jugador = ?
        ");

        $query->execute([$id]);
    }

    // OBTENER FUTBOLISTAS POR CLUB
    public function getFutbolistaByIdClub($id) {

        $query = $this->db->prepare("
            SELECT *
            FROM futbolista
            WHERE id_club = ?
        ");

        $query->execute([$id]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}