<?php
require_once __DIR__ . '/../../db/Database.php';

class Barber extends Database
{
    private $idBarber;
    private $idUser;
    private $nameBarber;
    private $emailBarber;
    private $passwordBarber;
    private $photoBarber;

    function __construct($id = '', $type = '')
    {
        $this->connect();
        if ($id != '') {
            if ($type === 'barber') {
                $query = $this->select("tb_barber", "*", "idBarber = '{$id}' LIMIT 1;");
            } else {
                $query = $this->select("tb_barber", "*", "idUser = '{$id}' LIMIT 1;");
            }
            $this->setIdBarber($query[0]['idBarber']);
            $this->setNameBarber($query[0]['nameBarber']);
            $this->setEmailBarber($query[0]['emailBarber']);
            $this->setPasswordBarber($query[0]['passwordBarber']);
            $this->setPhotoBarber($query[0]['photoBarber']);
            $this->setIdUser($query[0]['idUser']);
        }
    }

    public function viewSchedule()
    {
        $query = $this->selectJoin(
            "tb_schedule",
            "*",
            "JOIN tb_client ON tb_schedule.idClient = tb_client.idClient",
            "tb_schedule.idBarber = {$this->getIdBarber()} AND tb_schedule.idClient = tb_client.idClient AND tb_schedule.stateSchedule = 'on'"
        );
        return $query;
    }

    public function viewHistoricBarber(){
        return $this->selectJoin(
            "tb_schedule",
            "tb_client.nameClient, tb_schedule.dateSchedule, tb_schedule.timeSchedule, tb_schedule.stateSchedule",
            "JOIN tb_client ON tb_schedule.idClient = tb_client.idClient",
            "tb_schedule.idBarber = {$this->getIdBarber()}"
        );
    }

    public function verifySchedule($id)
    {
        $query = $this->select('tb_barber', 'unavailabilityBarber', "idBarber = $id");

        return json_encode($query);
    }

    public function getSchedule()
    {
        $query = $this->select('tb_barber', 'unavailabilityBarber', "idBarber = {$this->getIdBarber()}");

        return json_encode($query);
    }

    public function barberAlterStateSchedule($state, $hour, $day)
    {
            $this->updateSingle(
                "tb_schedule",
                "stateSchedule",
                $state,
                "tb_schedule.idBarber = {$this->getIdBarber()} AND 
                tb_schedule.timeSchedule = '$hour' AND 
                tb_schedule.dateSchedule = '$day'"
            );
    }


    public function registerBarber($name, $email, $password, $photo)
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
                'typeUser' => 'barber'
            ];

            $scheduleDefault = [
                'unavaible' => [
                    'date' => "",
                    'times' => []
                ]
            ];

            $this->insert('tb_userLogin', $dataLogin);

            $lastId = $this->getPdo()->lastInsertId();

            $dataBarber = [
                'nameBarber' => $name,
                'emailBarber' => $email,
                'passwordBarber' => $password,
                'unavailabilityBarber' => json_encode($scheduleDefault),
                'photoBarber' => $photo,
                'idUser' => $lastId
            ];

            $this->insert('tb_barber', $dataBarber);
            $this->transaction('commit');

            header("Location: admAccount.php");
        } catch (Exception $e) {
            $this->transaction('rollBack');
            return "Erro ao cadastrar Barbeiro: " . $e->getMessage();
        }
    }

    public function deleteBarber()
    {
        try {
            $appointments = $this->select("tb_schedule", "*", "idBarber = '{$this->getIdUser()}'");

            $this->transaction('start');

            if (count($appointments) > 0) {
                throw new Exception('A conta ainda tem horários marcados.');
            } else {
                $this->delete('tb_barber', "idUser = '{$this->getIdUser()}'");
                $this->delete('tb_userLogin', "idUser = '{$this->getIdUser()}'");
                $serverPath = __DIR__ . '/../../db/uploadBarber/';
                $filePath = $serverPath . $this->getPhotoBarber();
                unlink($filePath);
            }

            $this->transaction('commit');
        } catch (Exception $e) {
            $this->transaction('rollBack');
            return 'Erro ao apagar a conta: ' . $e->getMessage();
        }
    }

    public function updateBarber($n, $e, $p, $f)
    {
        try {
            $dataB = []; // dados alterados para a tabela Barber
            $dataU = []; // dados alterados para a tabela user

            if ($n != $this->getNameBarber()) {
                $dataB["nameBarber"] = $n;
            }

            if ($e != $this->getEmailBarber()) {
                $checkEmail = $this->select("tb_barber", "emailBarber", "emailBarber = '{$e}' LIMIT 1");
                if (count($checkEmail) > 0) {
                    throw new Exception('Esse E-mail já é cadastrado.');
                }
                $dataB["emailBarber"] = $e;
                $dataU["emailUser"] = $e;
            }

            if ($p != $this->getPasswordBarber()) {
                $dataB["passwordBarber"] = $p;
                $dataU["passwordUser"] = $p;
            }

            $dataB['photoBarber'] = $f;

            // $this->transaction('start');

            if (!empty($dataB)) {
                $this->update('tb_barber', $dataB, "idUser = '{$this->getIdUser()}'");

                $serverPath = __DIR__ . '/../../db/uploadBarber/';
                $filePath = $serverPath . $this->getPhotoBarber();
                unlink($filePath);

                if (!empty($dataU)) {
                    $this->update('tb_userLogin', $dataU, "idUser = '{$this->getIdUser()}'");
                }
                $this->__construct($this->getIdBarber());
            } else {
                throw new Exception('Nenhum dado foi alterado.');
            }
            // $this->transaction('commit');

            return "Dados do $n atualizados com Sucesso";
        } catch (Exception $e) {
            // $this->transaction('rollBack');
            return $e->getMessage();
        }
    }


    public function barberList()
    {
        $query = $this->select("tb_barber", "idBarber, nameBarber", "1");
        return $query;
    }

    public function getIdBarber()
    {
        return $this->idBarber;
    }

    public function setIdBarber($idBarber)
    {
        return $this->idBarber = $idBarber;
    }

    public function getNameBarber()
    {
        return $this->nameBarber;
    }

    public function setNameBarber($nameBarber)
    {
        return $this->nameBarber = $nameBarber;
    }

    public function getEmailBarber()
    {
        return $this->emailBarber;
    }

    public function setEmailBarber($emailBarber)
    {
        return $this->emailBarber = $emailBarber;
    }

    public function getPasswordBarber()
    {
        return $this->passwordBarber;
    }

    public function setPasswordBarber($passwordBarber)
    {
        return $this->passwordBarber = $passwordBarber;
    }

    public function getPhotoBarber()
    {
        return $this->photoBarber;
    }

    public function setPhotoBarber($photoBarber)
    {
        $this->photoBarber = $photoBarber;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($idUser)
    {
        return $this->idUser = $idUser;
    }
}
