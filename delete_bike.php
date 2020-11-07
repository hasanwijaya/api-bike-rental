<?php 
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        require('database.php');

        if (!isset($_POST['id'])) {
            die(json_encode([
                "status" => "error",
                "message" => "parameter kurang lengkap"
            ]));
        }

        $id = $_POST['id'];

        $sql = "DELETE FROM bikes WHERE id = '$id'";

        if ($mysqli->query($sql)) {
            echo json_encode([
                "status" => "success",
                "message" => "hapus sepeda berhasil"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => $mysqli->error
            ]);
        }

        $mysqli->close();
    }
?>