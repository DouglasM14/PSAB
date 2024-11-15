<?php
require_once __DIR__ . '/../../db/Database.php';

class Client extends Database
{
    private $idClient;
    private $nameClient;
    private $emailClient;
    private $passwordClient;

    public function __construct($idUser = '')
    {
        $this->connect();
        if ($idUser != '') {
            $query = $this->select("tb_client", "*", "idUser = '{$idUser}' LIMIT 1;");
            $this->setIdClient($query[0]['idClient']);
            $this->setNameClient($query[0]['nameClient']);
            $this->setEmailClient($query[0]['emailClient']);
            $this->setPasswordClient($query[0]['passwordClient']);
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

    public function registerClient($name, $email, $password)
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

            header("location: clientAccount.php");
        } catch (Exception $e) {
            $this->transaction('rollBack');
            return "Erro ao cadastrar cliente: " . $e->getMessage();
        }
    }

    public function deleteClient($id)
    {
        try {
            $appointments = $this->select("tb_schedule", "*", "idClient = '{$this->getIdClient()}'");

            $this->transaction('start');
            
            if (count($appointments) > 0) {
                throw new Exception('A conta ainda tem horários marcados.');
            } else {
                $this->delete('tb_client', "idUser = '{$id}'");
                $this->delete('tb_userLogin', "idUser = '{$id}'");
            }

            $this->transaction('commit');
            
            header("location: ../../public/index2.php");
        } catch (Exception $e) {
            $this->transaction('rollBack');
            return 'Erro ao apagar a conta: ' . $e->getMessage();
        }
    }

    public function updateClient($n, $e, $p, $id)
    {
        try {
            
            $dataC = []; // dados alterados para a tabela client
            $dataU = []; // dados alterados para a tabela user
            
            if ($n != $this->getNameClient()) {
                $dataC["nameClient"] = $n;
            }
            
            if ($e != $this->getEmailClient()) {
                $checkEmail = $this->select("tb_client", "emailClient", "emailClient = '{$e}' LIMIT 1");
                if (count($checkEmail) > 0) {
                    throw new Exception('Esse E-mail já é cadastrado.');
                }
                $dataC["emailClient"] = $e;
                $dataU["emailUser"] = $e;
            }

            if ($p != $this->getPasswordClient()) {
                $dataC["passwordClient"] = $p;
                $dataU["passwordUser"] = $p;
            }

            // $this->transaction('start');
            
            if (!empty($dataC)) {
                $this->update('tb_client', $dataC, "idUser = '{$id}'");
                if (!empty($dataU)) {
                    $this->update('tb_userLogin', $dataU, "idUser = '{$id}'");
                }
                $this->__construct($id);
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

    public function getEmailClient()
    {
        return $this->emailClient;
    }

    public function getPasswordClient()
    {
        return $this->passwordClient;
    }

    public function setEmailClient($emailClient)
    {
        $this->emailClient = $emailClient;
    }

    public function setPasswordClient($passwordClient)
    {
        $this->passwordClient = $passwordClient;
    }
}
