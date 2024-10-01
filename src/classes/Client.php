<?php
require_once __DIR__ . '/User.php';

class Client extends User
{
    private $idClient;
    private $nameClient;

    public function __construct($idUser = '')
    {
        $this->connect();
        if ($idUser != '') {
            $query = $this->select("tb_client", "*", "idUser = '{$idUser}' LIMIT 1;");
            $this->setIdClient($query[0]['idClient']);
            $this->setNameClient($query[0]['nameClient']);
        }
    }

    public function register($name, $email, $password)
    {
        try {
            $this->transaction('start');

            $checkEmail = $this->select("tb_userLogin", "emailUser", "emailUser = '{$email}' LIMIT 1");

            if (count($checkEmail) > 0) {
                throw new Exception('Esse E-mail já é cadastrado.');
            }

            $dataLogin = [
                'emailUser' => $email,
                'passwordUser' => $password,
                'typeUser' => 'client'
            ];
            
            $this->insert('tb_userLogin', $dataLogin);
            
            $lastId = $this->getPdo()->lastInsertId();
    
            $dataClient = [
                'nameClient' => $name,
                'emailClient' => $email,
                'passwordClient' => $password,
                'idUser' => $lastId
            ];
    
            $this->insert('tb_client', $dataClient);

            $this->transaction('commit');

        } catch (Exception $e) {
            $this->transaction('rollBack');
            return "Erro ao cadastrar cliente: " . $e->getMessage();
        }

    }

    public function toSchedule($barber, $time, $date)
    {
        $data = [
            'dateSchedule' => $date,
            'timeSchedule' => $time,
            'idClient' => $this->getIdClient(),
            'idBarber' => $barber
        ];
        $this->insert('tb_schedule', $data);
    }

    public function viewSchedule()
    {
        $query = $this->selectJoin(
            "tb_schedule",
            "nameBarber, dateSchedule, timeSchedule",
            "INNER JOIN tb_barber ON tb_schedule.idBarber = tb_barber.idBarber",
            "idClient = '{$this->getIdClient()}'"
        );
        return $query;
    }

    public function getNameClient()
    {
        return $this->nameClient;
    }
    public function setNameClient($nameClient)
    {
        return $this->nameClient = $nameClient;
    }

    public function getIdClient()
    {
        return $this->idClient;
    }
    public function setIdClient($idClient)
    {
        return $this->idClient = $idClient;
    }
}
