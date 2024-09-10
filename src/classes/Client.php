<?php
// require_once '../../db/database.php';

class User
{
    private $email;
    private $password;
    private $userType;

    public function __construct($e, $p) {
        $this->setEmail($e);
        $this->setPassword($p);
        $this->setUserType();
    }
    
    //Métodos Especiais
    public function login() {
        
    }
    // public function logout() {}
    // public function register() {}
    // public function schedule() {}

    //Métodos
    private function setUserType() {
        if (strpos($this->email, '@karraro.com')) {
            $this->userType = 'barber';
        } else {
            $this->userType = 'client';
        }
    }

    public function getUserType() {
        return $this->userType;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($e)
    {
        $this->email = $e;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($p)
    {
        $this->password = $p;
    }
}
