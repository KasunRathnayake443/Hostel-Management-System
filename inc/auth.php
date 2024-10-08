<?php

include('../connection.php');
session_start(); 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $profile_pic = $_FILES['profile_pic']['name'];
        $temp_name = $_FILES['profile_pic']['tmp_name'];
        
       
        $upload_dir = '../images/profile_pic/';
        
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        
        move_uploaded_file($temp_name, $upload_dir . $profile_pic);
        
    } else {
        echo "Error: Unable to upload profile picture.";
        $profile_pic = ''; 
    }

    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenum = $_POST['phonenum'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $pass = $_POST['pass'];  

   
    $sql = "INSERT INTO `user` (name, email, phone_no, address, date_of_birth, password, profile_pic) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $phonenum, $address, $dob, $pass, $profile_pic);
    
   
    if ($stmt->execute()) {
        echo "<script>alert('User Registration Success'); document.location='../index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
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
        echo "<script>alert('Invalid email or password!'); document.location='../index.php';</script>";
    }

    $stmt->close();
}


if (isset($_GET['logout'])) {



    session_destroy(); 
    header("Location: ../index.php"); 
}
?>
