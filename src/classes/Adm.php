<?php
require_once __DIR__ . '/Barber.php';

class Adm extends Barber
{
    private $idAdm;
    private $nameAdm;

    public function __construct($idUser)
    {
        $this->connect();
        $query = $this->select("tb_adm", "*", "idUser = '{$idUser}' LIMIT 1;");
        $this->setIdBarber($query[0]['idAdm']);
        $this->setNameBarber($query[0]['nameAdm']);
    }

    public function viewBarber(){
        $query = $this->select("tb_barber", "*", "1");
      return $query;
    }

    public function getIdAdm(){
        return $this->idAdm;
    }
    public function setIdAdm($idAdm){
        return $this->idAdm = $idAdm;
    }
    
    public function getNameAdm(){
        return $this->nameAdm;
    }
    public function setNameAdm($nameAdm){
        return $this->nameAdm = $nameAdm;
    }
}