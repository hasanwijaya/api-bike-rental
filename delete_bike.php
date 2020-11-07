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
        
        $sql = "SELECT image FROM bikes WHERE id = '$id'";

        $result = $mysqli->query($sql);
    
        if ($result->num_rows > 0) {
            $bike = $result->fetch_object();
            unlink('upload/' . $bike->image);

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
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "tidak ditemukan"
            ]);
        }

        $mysqli->close();
    }
?>