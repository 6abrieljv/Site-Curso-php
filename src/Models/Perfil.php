<?php

namespace App\Models;


class Perfil
{
    private $id =  null;
    private $id_usuario = null;
    private $nome = '';
    private $sobrenome = '';
    private $data_nascimento = null;
    private $bio = '';
    private $foto = '';
    private $cargo = '';



    private $instagram = '';
    private $facebook = '';
    private $twitter = '';
    private $linkedin = '';
    private $github = '';
    private $youtube = '';
    private $tiktok = '';


    public function getId() {
      return $this->id;
    }
    public function setId($value) {
      $this->id = $value;
    }

    public function getIdUsuario() {
      return $this->id_usuario;
    }
    public function setIdUsuario($value) {
      $this->id_usuario = $value;
    }

    public function getNome() {
      return $this->nome;
    }
    public function setNome($value) {
      $this->nome = $value;
    }

    public function getSobrenome() {
      return $this->sobrenome;
    }
    public function setSobrenome($value) {
      $this->sobrenome = $value;
    }

    public function getDataNascimento() {
      return $this->data_nascimento;
    }
    public function setDataNascimento($value) {
      $this->data_nascimento = $value;
    }

    public function getBio() {
      return $this->bio;
    }
    public function setBio($value) {
      $this->bio = $value;
    }

    public function getFoto() {
      return $this->foto;
    }
    public function setFoto($value) {
      $this->foto = $value;
    }

    public function getInstagram() {
      return $this->instagram;
    }
    public function setInstagram($value) {
      $this->instagram = $value;
    }

    public function getFacebook() {
      return $this->facebook;
    }
    public function setFacebook($value) {
      $this->facebook = $value;
    }

    public function getTwitter() {
      return $this->twitter;
    }
    public function setTwitter($value) {
      $this->twitter = $value;
    }

    public function getLinkedin() {
      return $this->linkedin;
    }
    public function setLinkedin($value) {
      $this->linkedin = $value;
    }

    public function getGithub() {
      return $this->github;
    }
    public function setGithub($value) {
      $this->github = $value;
    }

    public function getYoutube() {
      return $this->youtube;
    }
    public function setYoutube($value) {
      $this->youtube = $value;
    }

    public function getTiktok() {
      return $this->tiktok;
    }
    public function setTiktok($value) {
      $this->tiktok = $value;
    }

    public function getCargo(){
      return $this->cargo;
    }

    public function setCargo($value){
      $this->cargo = $value;
    }
}
