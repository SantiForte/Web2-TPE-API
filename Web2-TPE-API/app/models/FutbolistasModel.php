<?php

class FutbolistasModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=futbol_db;charset=utf8','root','',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    // LISTADO + ORDENAMIENTO
    public function getAll($sort = 'id_jugador', $order = 'ASC') {

        $camposPermitidos = [
            'id_jugador',
            'nombre',
            'apellido',
            'fecha_nacimiento',
            'nacionalidad',
            'posicion',
            'id_club'
        ];

        if (!in_array($sort, $camposPermitidos)) {
            $sort = 'id_jugador';
        }

        $order = strtoupper($order);

        if ($order != 'ASC' && $order != 'DESC') {
            $order = 'ASC';
        }

        $query = $this->db->prepare("
            SELECT *
            FROM futbolista
            ORDER BY $sort $order
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id) {

        $query = $this->db->prepare("
            SELECT *
            FROM futbolista
            WHERE id_jugador = ?
        ");

        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    // UPDATE (PUT)
    public function update(
        $id,
        $nombre,
        $apellido,
        $fecha_nacimiento,
        $nacionalidad,
        $posicion,
        $id_club
    ) {

        $query = $this->db->prepare("
            UPDATE futbolista
            SET nombre = ?,
                apellido = ?,
                fecha_nacimiento = ?,
                nacionalidad = ?,
                posicion = ?,
                id_club = ?
            WHERE id_jugador = ?
        ");

        $query->execute([
            $nombre,
            $apellido,
            $fecha_nacimiento,
            $nacionalidad,
            $posicion,
            $id_club,
            $id
        ]);
    }
}
