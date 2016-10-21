<?php
    
    $connect = mysqli_connect(+,_,_,_);
    
    $username = $_POST["username"];
    $password = $_POST["password"];

     function registerUser() {
        global $connect, $username, $password;
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $statement = mysqli_prepare($connect, "INSERT INTO users (username, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($statement, "ss", $username, $passwordHash);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);     
    }

    function usernameAvailable() {
        global $connect, $username;
        $statement = mysqli_prepare($connect, "SELECT * FROM users WHERE username = ?"); 
        mysqli_stmt_bind_param($statement, "s", $username);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        mysqli_stmt_close($statement); 
        if ($count < 1){
            return true; 
        }else {
            return false; 
        }
    }

    $response = array();
    $response["success"] = false;  

    if (usernameAvailable()){
        registerUser();
        $response["success"] = true;  
    }
    
    echo json_encode($response);
?>