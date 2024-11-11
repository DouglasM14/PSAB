<?php
require_once __DIR__ . '/../../db/Database.php';

class Barber extends Database
{
    private $idBarber;
    private $idUser;
    private $nameBarber;
    private $emailBarber;
    private $passwordBarber;
    private $imageBarber;
    private $dirImageBarber;

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
            $this->setIdUser($query[0]['idUser']);
        }
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

    public function verifySchedule() {
        $query = $this->select('tb_barber','idBarber, unavailabilityBarber','1');

        return json_encode($query);
        // return $query;
    }

    public function registerBarber($name, $email, $password)
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

            $this->insert('tb_userLogin', $dataLogin);

            $lastId = $this->getPdo()->lastInsertId();

            $dataBarber = [
                'nameBarber' => $name,
                'emailBarber' => $email,
                'passwordBarber' => $password,
                'idUser' => $lastId
            ];

            $this->insert('tb_barber', $dataBarber);
            $this->transaction('commit');
        } catch (Exception $e) {
            $this->transaction('rollBack');
            return "Erro ao cadastrar Barbeiro: " . $e->getMessage();
        }
    }

    public function deleteBarber($id)
    {
        try {
            $appointments = $this->select("tb_schedule", "*", "idBarber = '{$this->getIdBarber()}'");

            $this->transaction('start');

            if (count($appointments) > 0) {
                throw new Exception('A conta ainda tem horários marcados.');
            } else {
                $this->delete('tb_barber', "idUser = '{$id}'");
                $this->delete('tb_userLogin', "idUser = '{$id}'");
            }

            $this->transaction('commit');

            header("location: ../../public/index2.php");
        } catch (Exception $e) {
            $this->transaction('rollBack');
            return 'Erro ao apagar a conta: ' . $e->getMessage();
        }
    }

    public function updateBarber($n, $e, $p)
    {
        try {
            $dataB = []; // dados alterados para a tabela Barber
            $dataU = []; // dados alterados para a tabela user

            //Eduardo da o cu neide sem calcinha PAAAAAAAAAAAAAAAAA!!!!!

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



            $datas = [$dataB, $dataU];
            // return $datas;

            // $this->transaction('start');

            if (!empty($dataB)) {
                $this->update('tb_barber', $dataB, "idUser = '{$this->getIdUser()}'");
                // return $this->select('tb_barber', "*","idUser = '{$this->getIdUser()}'");

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

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($idUser)
    {
        return $this->idUser = $idUser;
    }
}
