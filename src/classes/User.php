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

    public function login($pass)
    {
        $login = $this->select("tb_userLogin", "*", "emailUser = '{$this->getEmail()}' LIMIT 1");
        password_verify($pass, $login[0]['passwordUser']);
        if (count($login) == 1) {
            if (password_verify($pass, $login[0]['passwordUser'])) {
                $this->setIdUser($login[0]['idUser']);

                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['idUser'] = $this->getIdUser();
                $_SESSION['emailUser'] = $this->getEmail();
                // $_SESSION['passwordUser'] = $this->getPassword();
                $_SESSION['typeUser'] = $login[0]['typeUser'];

                switch ($login[0]['typeUser']) {
                    case 'client':
                        $this->setTypeUser('client');
                        return header('location: clientAccount.php');
                    case 'barber':
                        $this->setTypeUser('barber');
                        return header('location: barberAccount.php');
                    case 'adm':
                        $this->setTypeUser('adm');
                        return header('location: admAccount.php');
                }
            } else {
                return false;
            }
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
        $passCrypt = password_hash($password, PASSWORD_BCRYPT);
        $this->password = $passCrypt;
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

    //     public function insertAdm()
    //     {
    //         $pass = password_hash("A#karrar0#e#a#melh0r#barbearia", PASSWORD_BCRYPT);

    //         $dataA = [
    //             "nameAdm" => "Tiko",
    //             "passwordAdm" => $pass,
    //             "emailAdm" => "karraroAdm@gmail.com",
    //             "idUser" => 1
    //         ];
    //         $dataU = [
    //             "passwordUser" => $pass,
    //             "emailUser" => "karraroAdm@gmail.com",
    //             "typeUser" => 'adm'
    //         ];

    //         $this->insert("tb_userlogin", $dataU);
    //         $this->insert("tb_adm", $dataA);
    //     }
}
