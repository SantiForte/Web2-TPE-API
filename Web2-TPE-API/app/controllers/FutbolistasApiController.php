<?php

require_once __DIR__ . '/../models/FutbolistasModel.php';
require_once __DIR__ . '/../models/ClubModel.php';

class FutbolistasApiController {

    private $model;
    private $modelClub;

    public function __construct() {
        $this->model = new FutbolistasModel();
        $this->modelClub= new ClubModel();
    }

    /*GET listado + paginado + filtrado*/
    public function getFutbolistas($req, $res) {
        $sort = $req->query->sort ?? 'id_jugador';
        $order = $req->query->order ?? 'ASC';
        $posicion = $req->query->posicion ?? null; // Atrapamos el filtro

        $page = $req->query->page ?? null;
        $limit = $req->query->limit ?? null;

        if ($page !== null && $limit !== null) {
            if (!is_numeric($page) || $page <= 0 || !is_numeric($limit) || $limit <= 0) {
                return $res->json('Los parametros page y limit deben ser numeros positivos', 400);
            }

            $offset = ($page - 1) * $limit;
            $futbolistas = $this->model->getAllPaginated($sort, $order, $limit, $offset, $posicion);
        } else {
            $futbolistas = $this->model->getAll($sort, $order, $posicion);
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
    //POST
    function addFutbolista($req,$res){
        if (!$req->user) {
            return $res->json("No autorizado", 401);
        }

        $nombre=$req->body->nombre ?? null;
        $apellido=$req->body->apellido ?? null;
        $posicion=$req->body->posicion ?? null;
        $id_club=$req->body->id_club ?? null;

        if(empty($nombre)||empty($apellido)||empty($posicion)||empty($id_club)){
            return $res->json('Error al enviar datos del futbolistas', 400);
        }
        $club=$this->modelClub->get($id_club);
        if(!$club){
            return $res->json('Error el club no existe', 404);
        }
        $id=$this->model->insert($nombre,$apellido,$posicion,$id_club);
        if(!$id){
            return $res->json('Error al insertar', 500);
        }
        $futbolista = $this->model->getById($id);
        return $res->json($futbolista,201);
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

    if ($id_club) {
        $club = $this->modelClub->get($id_club);
        if (!$club) {
            return $res->json("El club no existe", 404);
        }
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
