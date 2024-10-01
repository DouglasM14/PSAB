<?php
require_once __DIR__ . '/User.php';

class Barber extends User
{
    private $nameBarber;
    private $idBarber;
    private $imageBarber;
    private $dirImageBarber;

    function __construct($idUser)
    {
        $this->connect();
        $query = $this->select("tb_barber", "*", "idUser = '{$idUser}' LIMIT 1;");
        $this->setIdBarber($query[0]['idBarber']);
        $this->setNameBarber($query[0]['nameBarber']);
    }

    public function viewSchedule()
    {
        $query = $this->selectJoin(
            "tb_schedule", 
            "nameClient, dateSchedule, timeSchedule", 
            "JOIN tb_client ON tb_schedule.idClient = tb_client.idClient", 
            "tb_schedule.idBarber = {$this->getIdBarber()} AND tb_schedule.idClient = tb_client.idClient"
        );
      return $query;
    }

    public function getNameBarber()
    {
        return $this->nameBarber;
    }
    public function setNameBarber($nameBarber)
    {
        return $this->nameBarber = $nameBarber;
    }

    public function getIdBarber()
    {
        return $this->idBarber;
    }
    public function setIdBarber($idBarber)
    {
        return $this->idBarber = $idBarber;
    }

    public function getImageBarber()
    {
        return $this->imageBarber;
    }

    public function setImageBarber($imageBarber)
    {
        $this->imageBarber = $imageBarber;
    }

    public function getDirImageBarber()
    {
        return $this->dirImageBarber;
    }

    public function setDirImageBarber($dirImageBarber)
    {
        $this->dirImageBarber = $dirImageBarber;
    }
}
