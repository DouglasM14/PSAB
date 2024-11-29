<?php
require_once 'protect.php';
require_once '../classes/Operating.php';
require_once '../classes/Barber.php';

header('Content-Type: application/json');

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['barberId'])) {
            $id = $_POST['barberId'];

            $barber = new Barber();
            $operating = new Operating();

            $barberschedule = $barber->verifySchedule($id);
            $listOperating = $operating->viewOperatingHours();

            echo json_encode([
                'schedule' => $barberschedule,
                'operatingHours' => $listOperating
            ]);
        } else {
            echo json_encode(['error' => true, 'message' => 'barberId not provided']);
        }
    } else {
        echo json_encode(['error' => true, 'message' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(["error" => true, "message" => $e->getMessage()]);
}
?>
