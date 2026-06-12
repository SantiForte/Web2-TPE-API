<?php

require_once __DIR__ . '/../models/UsersModel.php';
require_once __DIR__ . '/../../libs/jwt/jwt.php';

class AuthApiController {

    private $model;

    public function __construct() {
        $this->model = new UsersModel();
    }

    public function getToken($req, $res) {

        $usuario = $req->body->usuario ?? null;
        $password = $req->body->password ?? null;

        if (empty($usuario) || empty($password)) {
            return $res->json(
                'Faltan completar datos',
                400
            );
        }

        $user = $this->model->getByUser($usuario);

        if (!$user) {
            return $res->json(
                'Usuario o contraseña incorrectos',
                401
            );
        }

        if (!password_verify($password, $user->password)) {
            return $res->json(
                'Usuario o contraseña incorrectos',
                401
            );
        }

        $payload = [
            'id_usuario' => $user->id_usuario,
            'usuario' => $user->usuario,
            'rol' => $user->rol,
            'exp' => time() + 3600
        ];

        $token = createJWT($payload);

        return $res->json([
            'token' => $token
        ], 200);
    }
}