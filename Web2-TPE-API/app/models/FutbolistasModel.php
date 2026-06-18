<?php

class FutbolistasModel {

    private $db;

    public function __construct() {
        $this->db = new PDO(
            'mysql:host=localhost;dbname=futbol_db;charset=utf8',
            'root',
            '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
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

    // GET POR ID
    public function getById($id) {

        $query = $this->db->prepare("
            SELECT *
            FROM futbolista
            WHERE id_jugador = ?
        ");

        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    // UPDATE
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

    // PAGINADO
    public function getAllPaginated($sort, $order, $limit, $offset) {

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
            LIMIT ? OFFSET ?
        ");

        $query->bindValue(1, (int) $limit, PDO::PARAM_INT);
        $query->bindValue(2, (int) $offset, PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
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
        return $this->db->lastInsertId();
    }
}
