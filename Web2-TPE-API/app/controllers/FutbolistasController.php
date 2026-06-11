<?php

require_once __DIR__ . '/../models/FutbolistasModel.php';
require_once __DIR__ . '/../models/ClubModel.php';

class FutbolistasController {

    private $model;
    private $clubModel;

    public function __construct() {

        $this->model = new FutbolistasModel();
        $this->clubModel = new ClubModel();
    }

    // LISTADO
    public function showAll() {

        $futbolistas = $this->model->getAllWithClub();

        require __DIR__ . '/../views/futbolistas.phtml';
    }

    // DETALLE
    public function show($id) {

        if (!is_numeric($id)) {
            exit("ID inválido");
        }

        $f = $this->model->getById($id);

        if (!$f) {
            exit("Futbolista no encontrado");
        }

        require __DIR__ . '/../views/futbolista_detalle.phtml';
    }

    // FORMULARIO ALTA
    public function addForm() {

        $this->checkAdmin();

        $clubes = $this->clubModel->getAll();

        require __DIR__ . '/../views/futbolista_form.phtml';
    }

    // INSERT
    public function add() {

        $this->checkAdmin();

        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $posicion = trim($_POST['posicion'] ?? '');
        $id_club = (int) ($_POST['id_club'] ?? 0);

        if (
            empty($nombre) ||
            empty($apellido) ||
            empty($posicion) ||
            $id_club <= 0
        ) {
            exit("Datos inválidos");
        }

        $this->model->insert(
            $nombre,
            $apellido,
            $posicion,
            $id_club
        );

        header('Location: ' . BASE_URL . 'futbolistas');
        exit();
    }

    // FORMULARIO EDIT
    public function editForm($id) {

        $this->checkAdmin();

        if (!is_numeric($id)) {
            exit("ID inválido");
        }

        $futbolista = $this->model->getById($id);

        if (!$futbolista) {
            exit("Futbolista no encontrado");
        }

        $clubes = $this->clubModel->getAll();

        require __DIR__ . '/../views/futbolista_form.phtml';
    }

    // UPDATE
    public function update($id) {

        $this->checkAdmin();

        if (!is_numeric($id)) {
            exit("ID inválido");
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $posicion = trim($_POST['posicion'] ?? '');
        $id_club = (int) ($_POST['id_club'] ?? 0);

        if (
            empty($nombre) ||
            empty($apellido) ||
            empty($posicion) ||
            $id_club <= 0
        ) {
            exit("Datos inválidos");
        }

        $this->model->update(
            $id,
            $nombre,
            $apellido,
            $posicion,
            $id_club
        );

        header('Location: ' . BASE_URL . 'futbolistas');
        exit();
    }

    // DELETE
    public function delete($id) {

        $this->checkAdmin();

        if (!is_numeric($id)) {
            exit("ID inválido");
        }

        $this->model->delete($id);

        header('Location: ' . BASE_URL . 'futbolistas');
        exit();
    }

    // SEGURIDAD
    private function checkAdmin() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (
            !isset($_SESSION['ROLE']) ||
            $_SESSION['ROLE'] !== 'admin'
        ) {
            exit("Acceso denegado");
        }
    }
}