<?php

class Pelicula {

    private $isan;
    private $nombre;
    private $puntuacion;
    private $año;

    public function __construct($isan,$nombre,$puntuacion,$año){
        $this->isan=$isan;
        $this->nombre=$nombre;
        $this->puntuacion=$puntuacion;
        $this->año=$año;
    }

    public function getIsan(){
        return $this->isan;
    }

    public function setIsan($isan){
        $this->isan=$isan;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre=$nombre;
    }

    public function getPuntuacion(){
        return $this->puntuacion;
    }

    public function setPuntuacion($puntuacion){
        $this->puntuacion=$puntuacion;
    }

    public function getAño(){
        return $this->año;
    }

    public function setAño($año){
        $this->año=$año;
    }

}
?>