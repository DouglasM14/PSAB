<?php
require_once __DIR__ . '/../../db/Database.php';

class Operating extends Database
{
    private $idOperating;
    private $dayOperating;
    private $startOperating;
    private $endOperating;
    private $stateOperating;

    function __construct($id = '')
    {
        $this->connect();
        if ($id != '') {
            $query = $this->select('tb_operatinghours', "*", "idOperating = {$id}");
            $this->setIdOperating($query[0]['idOperating']);
            $this->setDayOperating($query[0]['dayOperating']);
            $this->setStartOperating($query[0]['startOperating']);
            $this->setEndOperating($query[0]['endOperating']);
            $this->setStateOperating($query[0]['stateOperating']);
        }
    }

    public function viewOperatingHours($type = '')
    {
        if ($type == "all") {
            $query = $this->select("tb_operatinghours");
        } else {
            $query = $this->select("tb_operatinghours", "*", "stateOperating != 0");
        }
        return $query;
    }

    public function updateOperatingHour($id, $start, $end, $state)
    {
        $data = [];

        if ($start != $this->getStartOperating()) {
            $data['startOperating'] = $start;
        }

        if ($end != $this->getEndOperating()) {
            $data['endOperating'] = $end;
        }

        if ($state != $this->getStateOperating()) {
            $data['stateOperating'] = $state;
        }

        // $this->transaction('start');

        if (!empty($data)) {
            $this->update('tb_operatinghours', $data, "idOperating = '{$id}'");

            $this->__construct($id);



            // $this->transaction('commit');

        } else {
            throw new Exception('Nenhum Dado foi alterado.');
            // $this->transaction('rollBack');
        }
    }

    public function getIdOperating()
    {
        return $this->idOperating;
    }
    public function setIdOperating($idOperating)
    {
        return $this->idOperating = $idOperating;
    }

    public function getDayOperating()
    {
        return $this->dayOperating;
    }
    public function setDayOperating($dayOperating)
    {
        return $this->dayOperating = $dayOperating;
    }

    public function getStartOperating()
    {
        return $this->startOperating;
    }
    public function setStartOperating($startOperating)
    {
        return $this->startOperating = $startOperating;
    }

    public function getEndOperating()
    {
        return $this->endOperating;
    }
    public function setEndOperating($endOperating)
    {
        return $this->endOperating = $endOperating;
    }

    public function getStateOperating()
    {
        return $this->stateOperating;
    }
    public function setStateOperating($stateOperating)
    {
        return $this->stateOperating = $stateOperating;
    }
}
