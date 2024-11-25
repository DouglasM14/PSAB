<?php
require_once '../../src/php/protect.php';
require_once '../../src/classes/Client.php';
require_once '../../src/classes/Barber.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
    }
} catch (Exception $e) {
    return json_encode(["error" => true, "messagee" => $e->getMessage()]);
}
