<?php
require_once __DIR__ . '/../../db/Database.php';

class Adm extends Database
{
    private $idAdm;
    private $nameAdm;
    private $emailAdm;
    private $passwordAdm;

    public function __construct($idUser)
    {
        $this->connect();
        $query = $this->select("tb_adm", "*", "idUser = '{$idUser}' LIMIT 1;");
        $this->setIdAdm($query[0]['idAdm']);
        $this->setNameAdm($query[0]['nameAdm']);
        $this->setEmailAdm($query[0]['emailAdm']);
        $this->setPasswordAdm($query[0]['passwordAdm']);
    }

    public function viewBarber()
    {
        $query = $this->select("tb_barber");
        return $query;
    }

    public function getIdAdm()
    {
        return $this->idAdm;
    }
    public function setIdAdm($idAdm)
    {
        return $this->idAdm = $idAdm;
    }

    public function getNameAdm()
    {
        return $this->nameAdm;
    }

    public function setNameAdm($nameAdm)
    {
        return $this->nameAdm = $nameAdm;
    }

    public function setEmailAdm($emailAdm)
    {
        return $this->emailAdm = $emailAdm;
    }
    public function getEmailAdm()
    {
        return $this->emailAdm;
    }

    public function getPassworAdm()
    {
        return $this->passwordAdm;
    }
    public function setPasswordAdm($passwordAdm)
    {
        return $this->passwordAdm = $passwordAdm;
    }
}
