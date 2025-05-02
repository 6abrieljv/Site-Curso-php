<?php

class Perfil {
    private $id;
    private $bio;
    private $foto;
    private $id_usuario;
    

    public function __construct($id_usuario, $bio, $foto) {
        $this->id = $id_usuario;
        $this->bio = $bio;
        $this->foto = $foto;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getBio() {
        return $this->bio;
    }

    public function setBio($bio) {
        $this->bio = $bio;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }
    public function getIdUsuario() {
        return $this->id_usuario;
    }
    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
}
?>