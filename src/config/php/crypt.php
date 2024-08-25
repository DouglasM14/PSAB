<?php

function Crypt ($pass){
    $passCrypt = password_hash($pass, PASSWORD_DEFAULT);
    password_verify($passCrypt, $pass) ? true : false;
}