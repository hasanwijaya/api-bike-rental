<?php 
    header('Content-Type: application/json');
    
    $mysqli = new mysqli('localhost', 'hasan', 'kopiko', 'bike_rental');

    if ($mysqli->connect_errno) {
        header('Content-Type: application/json');
        die(json_encode([
            "status" => "error",
            "message" => $mysqli->connect_error
        ]));
    }
?>