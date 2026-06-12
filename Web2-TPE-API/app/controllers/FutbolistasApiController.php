<?php

require_once __DIR__ . '/../models/FutbolistasModel.php';

class FutbolistasApiController {

    private $model;

    public function __construct() {
        $this->model = new FutbolistasModel();
    }

    /*GET listado + paginado*/
    public function getFutbolistas($req, $res) {
    $sort = $req->query->sort ?? 'id_jugador';
    $order = $req->query->order ?? 'ASC';

    $page = $req->query->page ?? null;
    $limit = $req->query->limit ?? null;

    if ($page && $limit) {
        $offset = ($page - 1) * $limit;
        $futbolistas = $this->model->getAllPaginated($sort,$order,$limit,$offset);

    } else {
        $futbolistas = $this->model->getAll($sort,$order);
    }

    return $res->json($futbolistas, 200);
}

    function getFutbolistaById($req,$res) {
        $id=$req->params->id;
        if(empty($id)){
            return $res->json('Error al enviar id de futbolista', 400);
        }
        $futbolista = $this->model->getById($id);

        if(empty($futbolista)){
            return $res->json('Error el futbolista no existe', 404);
        }else{
            return $res->json($futbolista,200);
        }
    }   

    /*PUT*/
public function updateFutbolista($req, $res) {

    // Verifica que haya un usuario autenticado
    if (!$req->user) {
        return $res->json(
            "No autorizado",
            401
        );
    }

    $id = $req->params->id;

    $futbolista = $this->model->getById($id);

    if (!$futbolista) {
        return $res->json(
            "El futbolista con id=$id no existe",
            404
        );
    }

    $nombre = $req->body->nombre ?? null;
    $apellido = $req->body->apellido ?? null;
    $fecha_nacimiento = $req->body->fecha_nacimiento ?? null;
    $nacionalidad = $req->body->nacionalidad ?? null;
    $posicion = $req->body->posicion ?? null;
    $id_club = $req->body->id_club ?? null;

    if (
        empty($nombre) ||
        empty($apellido) ||
        empty($posicion)
    ) {
        return $res->json(
            "Faltan completar datos obligatorios",
            400
        );
    }

    $this->model->update(
        $id,
        $nombre,
        $apellido,
        $fecha_nacimiento,
        $nacionalidad,
        $posicion,
        $id_club
    );

    $futbolistaActualizado = $this->model->getById($id);

    return $res->json(
        $futbolistaActualizado,
        200
    );
}
}
