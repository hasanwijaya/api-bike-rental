<?php 
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        require('database.php');

        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            die(json_encode([
                "status" => "error",
                "message" => "parameter kurang lengkap"
            ]));
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        $sql = "SELECT * FROM users WHERE email = '$email' AND role = '$role'";
        $result = $mysqli->query($sql);
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_object();
            
            if (password_verify($password, $row['password'])) {
                echo json_encode([
                    "status" => "success",
                    "message" => "login berhasil",
                    "id" => $user->id
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "email atau password tidak valid"
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "email atau password tidak valid"
            ]);
        }

        $mysqli->close();
    }
?>