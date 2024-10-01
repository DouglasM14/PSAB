<?php
require_once __DIR__ . '/../../db/Database.php';

class User extends Database
{
    private $idUser;
    private $email;
    private $password;
    private $typeUser;

    public function __construct($e, $p)
    {
        $this->connect();
        $this->setEmail($e);
        $this->setPassword($p);
    }

    public function login()
    {
        $login = $this->select("tb_userLogin", "*", "emailUser = '{$this->getEmail()}' AND passwordUser = '{$this->getPassword()}' LIMIT 1;");

        if (count($login) == 1) {

            $this->setIdUser($login[0]['idUser']);

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['idUser'] = $this->getIdUser();
            $_SESSION['emailUser'] = $this->getEmail();
            $_SESSION['passwordUser'] = $this->getPassword();
            $_SESSION['typeUser'] = $login[0]['typeUser'];

            switch ($login[0]['typeUser']) {
                case 'client':
                    $this->setTypeUser('client');;
                    return header('location: clientAccount.php');
                    break;
                case 'barber':
                    $this->setTypeUser('barber');;
                    return header('location: barberAccount.php');
                    break;

                case 'adm':
                    $this->setTypeUser('adm');;
                    return header('location: admAccount.php');
                    break;
            };
        } else {
            return false;
        }
    }

    public function logout()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        session_unset();
        session_destroy();
    }

    public function deleteAccount()
    {
        switch ($this->getTypeUser()) {
            case 'client':
                $table = 'tb_client';
                break;
            case 'barber':
                $table = 'tb_barber';
                break;
            case 'adm':
                $table = 'tb_adm';
                break;
        };

        $deleteTypeUser = $this->delete($table, "idUser = '{$this->getIdUser()}'");

        $deleteUser = $this->delete('tb_userLogin' ,"idUser = '{$this->getIdUser()}'");
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }
    public function setIdUser($idUser)
    {
        return $this->idUser = $idUser;
    }
    
    public function getTypeUser()
    {
        return $this->typeUser;
    }

    public function setTypeUser($typeUser)
    {
        $this->typeUser = $typeUser;
    }
}
