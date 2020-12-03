<?php
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        require('database.php');

        if (!isset($_POST['id']) || !isset($_POST['code']) || !isset($_POST['color']) || !isset($_POST['price']) || !isset($_POST['merk'])) {
            die(json_encode([
                "status" => "error",
                "message" => "parameter kurang lengkap"
            ]));
        }
        
        $id = $_POST['id'];
        $code = $_POST['code'];
        $color = $_POST['color'];
        $price = $_POST['price'];
        $merk = $_POST['merk'];

        if(isset($_FILES['image'])) {
            $name = $_FILES['image']['name'];
            $path = $_FILES['image']['tmp_name'];
            $size = $_FILES['image']['size'];
            $format = $_FILES['image']['type'];
            $error = $_FILES['image']['error'];

            if ($error == 0) {
                if ($size <= 5000000) {
                    if (($format == 'image/png') || ($format == 'image/jpeg')) {
                        $sql = "SELECT image FROM bikes WHERE id = '$id'";

                        $result = $mysqli->query($sql);

                        if ($result->num_rows > 0) {
                            $bike = $result->fetch_object();
                            unlink('upload/' . $bike->image);
                
                            $fileName = time() . strstr($name, '.');
                            move_uploaded_file($path, 'upload/' . $fileName);

                            $sql = "UPDATE bikes SET code = '$code', color = '$color', image = '$fileName', price = '$price', merk = '$merk' WHERE id = '$id'";
                            if ($mysqli->query($sql)) {
                                echo json_encode([
                                    "status" => "success",
                                    "message" => "update sepeda berhasil"
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
        } else {
            $sql = "UPDATE bikes SET code = '$code', color = '$color', price = '$price', merk = '$merk' WHERE id = '$id'";
            if ($mysqli->query($sql)) {
                echo json_encode([
                    "status" => "success",
                    "message" => "update sepeda berhasil"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => $mysqli->error
                ]);
            } 
        }

        $mysqli->close();
    }
?>