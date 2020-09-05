<?php 
    require('database.php');

    $sql = "SELECT * FROM users WHERE role = 2";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        $customers = array();
        while ($row = $result->fetch_assoc()) {
            array_push($customers, $row);
        }

        echo json_encode([
            "status" => "success",
            "result" => $customers
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "tidak ditemukan"
        ]);
    }

    $mysqli->close();
?>