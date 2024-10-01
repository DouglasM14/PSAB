<?php
require_once __DIR__ . '/../../db/Database.php';

class Service extends Database
{
    private $idService;
    private $nameService;
    private $priceService;
    private $plusPriceService;

    function __construct()
    {
        $this->connect();
    }

    public function viewAllServices()
    {
        $query = $this->select("tb_service", "*", "1");
        return $query;
    }

    public function getIdService()
    {
        return $this->idService;
    }
    public function setIdService($idService)
    {
        return $this->idService = $idService;
    }

    public function getNameService()
    {
        return $this->nameService;
    }
    public function setNameService($nameService)
    {
        return $this->nameService = $nameService;
    }

    public function getPriceService()
    {
        return $this->priceService;
    }
    public function setPriceService($priceService)
    {
        return $this->priceService = $priceService;
    }

    public function getPlusPriceService()
    {
        return $this->plusPriceService;
    }
    public function setPlusPriceService($plusPriceService)
    {
        $this->plusPriceService = $plusPriceService;
    }
}
