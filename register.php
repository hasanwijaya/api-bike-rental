<?php 
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        require('database.php');

        if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['name']) || !isset($_POST['phone']) || !isset($_POST['address']) || !isset($_POST['noktp'])) {
            die(json_encode([
                "status" => "error",
                "message" => "parameter kurang lengkap"
            ]));
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $noKtp = $_POST['noktp'];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, password, name, phone, address, no_ktp) VALUES ('$email', '$passwordHash', '$name', '$phone', '$address', '$noKtp')";

        if ($mysqli->query($sql)) {
            echo json_encode([
                "status" => "success",
                "message" => "register berhasil"
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