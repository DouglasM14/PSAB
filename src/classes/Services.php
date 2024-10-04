<?php
require_once __DIR__ . '/../../db/Database.php';

class Services extends Database
{
    private $idService;
    private $nameService;
    private $priceService;
    private $descService;
    private $expPriceService;

    function __construct($id = '')
    {
        $this->connect();
        if ($id != '') {
            $query = $this->select("tb_service", "*", "idService = '{$id}'");
            $this->setNameService($query[0]['nameService']);
            $this->setdescService($query[0]['descService']);
            $this->setPriceService($query[0]['priceService']);
            $this->setExpPriceService($query[0]['expPriceService']);
        }
    }

    public function viewAllServices()
    {
        $query = $this->select("tb_service");
        return $query;
    }

    // public function detailService($id)
    // {
    //     $query = $this->select("tb_service", "*", "idService = '{$id}'");
    //     $this->setNameService($query[0]['nameService']);
    //     $this->setdescService($query[0]['descService']);
    //     $this->setPriceService($query[0]['priceService']);
    //     $this->setExpPriceService($query[0]['expPriceService']);
    // }

    public function updateService($chosenId, $name, $desc, $price, $expPrice)
    {
        try {
            $data = []; // dados alterados para a tabela client

            if ($name != $this->getNameService()) {
                $data["nameService"] = $name;
            }

            if ($desc != $this->getdescService()) {
                $data["descService"] = $desc;
            }

            if ($price != $this->getPriceService()) {
                $data["priceService"] = $price;
            }

            if ($expPrice != $this->getExpPriceService()) {
                $data["expPriceService"] = $expPrice;
            }

            // $this->transaction('start');

            if (!empty($data)) {
                $this->update('tb_service', $data, "idService = '{$chosenId}'");

                $this->__construct($chosenId);
            } else {
                throw new Exception('Nenhum Dado foi alterado.');
            }
            // $this->transaction('commit');

            return 'Dados atualizados com Sucesso';
        } catch (Exception $e) {
            // $this->transaction('rollBack');
            return $e->getMessage();
        }
    }

    public function deleteService($id){

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

    public function getExpPriceService()
    {
        return $this->expPriceService;
    }
    public function setExpPriceService($expPriceService)
    {
        $this->expPriceService = $expPriceService;
    }

    public function getdescService()
    {
        return $this->descService;
    }

    public function setdescService($descService)
    {
        return $this->descService = $descService;
    }
}
