<?php

include('../connection.php');
session_start(); 




if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    
    $picture = $_FILES['profile_pic']['name'];
    $picture_tmp = $_FILES['profile_pic']['tmp_name'];
    $picture_name = basename($picture);
    
  
    $upload_dir = '../images/profile_pic/';
    
   
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $picture_path = $upload_dir . $picture_name;
    move_uploaded_file($picture_tmp, $picture_path);
    

   
    


    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenum = $_POST['phonenum'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $pass = $_POST['pass'];

    
    $sql = "INSERT INTO `user` (name, email, phone_no, address, date_of_birth, password, profile_pic) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $phonenum, $address, $dob, $pass, $picture_name);
    
    
    if ($stmt->execute()) {
        echo "<script>alert('User Registration Success');document.location='../index.php'; </script>";
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
