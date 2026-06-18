<?php
    class ClubModel{
        private $db;
        function __construct(){
            $this->db = $this->conect();
        }
        //conexion a la base de datos
        function conect(){
            return new PDO(
            'mysql:host=localhost;dbname=futbol_db;charset=utf8',
            'root',
            '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        }
        //obtener un club en especifico 
        function get($id){
            $query =$this->db->prepare('SELECT * FROM club WHERE id_club=?');
            $query->execute([$id]);
            $club = $query->fetch(PDO::FETCH_OBJ);
            return $club;
        }
        //obtener todos los datos de clubes
        function getAll(){
            $query =$this->db->prepare('SELECT * FROM club');
            $query->execute();
            $clubes = $query->fetchAll(PDO::FETCH_OBJ);
            return $clubes;
        }
        function getClub($id){
            $query =$this->db->prepare('SELECT * FROM club WHERE id_club=?');
            $query->execute([$id]);
            $club = $query->fetch(PDO::FETCH_OBJ);
            return $club;
        }
        function add($nombre,$pais,$ciudad,$fecha_fundacion,$imagen){
            $query =$this->db->prepare('INSERT INTO club (nombre,pais,ciudad,fecha_fundacion,foto) VALUES (?,?,?,?,?)');
            $query->execute([$nombre,$pais, $ciudad, $fecha_fundacion,$imagen]);
            return $this->db->lastInsertId();
        }
        function delete($id){
            $query =$this->db->prepare('DELETE FROM club WHERE id_club=?');
            $query->execute([$id]);
        }
        function update($id,$nombre,$pais,$ciudad,$fecha_fundacion,$imagen){
            $query =$this->db->prepare('UPDATE club SET nombre=?,pais=?,ciudad=?,fecha_fundacion=?,foto=? WHERE id_club=?');
            $query->execute([$nombre,$pais, $ciudad, $fecha_fundacion,$imagen,$id]);
        }
    }
?>