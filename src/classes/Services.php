<?php
require_once __DIR__ . '/../../db/Database.php';

class Services extends Database
{
    private $idService;
    private $nameService;
    private $priceService;
    private $descService;
    private $expPriceService;
    private $iconService;

    function __construct($id = '')
    {
        $this->connect();
        if ($id != '') {
            $query = $this->select("tb_service", "*", "idService = '{$id}'");
            $this->setIdService($query[0]['idService']);
            $this->setNameService($query[0]['nameService']);
            $this->setdescService($query[0]['descService']);
            $this->setPriceService($query[0]['priceService']);
            $this->setExpPriceService($query[0]['expPriceService']);
            $this->setIconService($query[0]['iconService']);
        }
    }

    public function viewAllServices()
    {
        $query = $this->select("tb_service");
        return $query;
    }

    public function insertService($name, $desc, $price, $expPrice, $icon)
    {
        try {
            $this->transaction('start');

            $data = [
                'nameService' => $name,
                'descService' => $desc,
                'priceService' => $price,
                'expPriceService' => $expPrice,
                'iconService' => $icon
            ];

            $this->insert('tb_service', $data);

            $this->transaction('commit');

            return "Serviço cadastrado com Sucesso!";
        } catch (Exception $e) {
            $this->transaction('rollBack');
            return "Erro ao cadastrar serviço: " . $e->getMessage();
        }
    }

    public function updateService($chosenId, $name, $desc, $price, $expPrice, $photo)
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

            if($photo != $this->getIconService()){
                $data['iconService'] = $photo;
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

    public function deleteService()
    {
        try {
            $this->transaction('start');

            $this->delete('tb_service', "idService = '{$this->getIdService()}'");

            $this->transaction('commit');

            return "O serviço {$this->getNameService()} foi excluido com Sucesso!";
        } catch (Exception $e) {
            $this->transaction('rollBack');
            return 'Erro ao apagar o serviço: ' . $e->getMessage();
        }
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

    public function getIconService()
    {
        return $this->iconService;
    }

    public function setIconService($iconService)
    {
        return $this->iconService = $iconService;
    }
}
