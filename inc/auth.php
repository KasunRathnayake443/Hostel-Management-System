<?php

include('../connection.php');
session_start(); 


if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenum = $_POST['phonenum'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

 
    if ($pass !== $cpass) {
        echo "Passwords do not match!";
        exit();
    }

   
    $profilePic = $_FILES['profile_pic']['name'];
    $targetDir = "../images/profile_pic/";  
    $targetFile = $targetDir . basename($profilePic);
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFile);

    
    $stmt = $conn->prepare("INSERT INTO user (name, email, phone_no, address, date_of_birth, password, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $phonenum, $address, $dob, $pass, $profilePic);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

   
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        
        if ($pass === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo "<script> document.location='../index.php'</script>";
        } else {
            echo "<script>alert('Invalid email or password!')</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password!')</script>";
    }

    $stmt->close();
}


if (isset($_GET['logout'])) {



    session_destroy(); 
    header("Location: ../index.php"); 
}
?>
