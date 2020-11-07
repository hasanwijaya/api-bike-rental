<?php 
    require('database.php');

    $sql = "SELECT * FROM bikes";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        $bikes = array();
        while ($row = $result->fetch_assoc()) {
            array_push($bikes, $row);
        }

        echo json_encode([
            "status" => "success",
            "result" => $bikes
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "tidak ditemukan"
        ]);
    }

    $mysqli->close();
?>