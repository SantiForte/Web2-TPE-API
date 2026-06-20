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

    // LISTADO + ORDENAMIENTO + FILTRO
    public function getAll($sort = 'id_jugador', $order = 'ASC', $posicion = null) {

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

        $sql = "SELECT * FROM futbolista";
        $params = [];

        if ($posicion) {
            $sql .= " WHERE posicion = ?";
            $params[] = $posicion;
        }

        $sql .= " ORDER BY $sort $order";

        $query = $this->db->prepare($sql);
        $query->execute($params);

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

    // PAGINADO + FILTRO
    public function getAllPaginated($sort, $order, $limit, $offset, $posicion = null) {

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

        $sql = "SELECT * FROM futbolista";

        if ($posicion) {
            $sql .= " WHERE posicion = ?";
        }

        $sql .= " ORDER BY $sort $order LIMIT ? OFFSET ?";

        $query = $this->db->prepare($sql);

        $bindIndex = 1;
        if ($posicion) {
            $query->bindValue($bindIndex++, $posicion, PDO::PARAM_STR);
        }
        $query->bindValue($bindIndex++, (int) $limit, PDO::PARAM_INT);
        $query->bindValue($bindIndex++, (int) $offset, PDO::PARAM_INT);

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
