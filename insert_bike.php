<?php
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        require('database.php');

        if (!isset($_POST['code']) || !isset($_POST['color']) || !isset($_POST['price']) || !isset($_POST['merk'])) {
            die(json_encode([
                "status" => "error",
                "message" => "parameter kurang lengkap"
            ]));
        }
        
        $code = $_POST['code'];
        $color = $_POST['color'];
        $price = $_POST['price'];
        $merk = $_POST['merk'];

        $name = $_FILES['image']['name'];
        $path = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $format = $_FILES['image']['type'];
        $error = $_FILES['image']['error'];

        if ($error == 0) {
            if ($size <= 5000000) {
                if (($format == 'image/png') || ($format == 'image/jpeg')) {
                    $fileName = time() . strstr($name, '.');
                    move_uploaded_file($path, 'upload/' . $fileName);

                    $sql = "INSERT INTO bikes (code, color, image, price, merk) VALUES ('$code', '$color', '$fileName', '$price', '$merk')";
                    if ($mysqli->query($sql)) {
                        echo json_encode([
                            "status" => "success",
                            "message" => "insert sepeda berhasil"
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
                        "message" => "format image harus png atau jpeg"
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "size image max 5MB"
                ]);
            }
        }

        $mysqli->close();
    }
?>