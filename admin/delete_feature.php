<?php
require('db_config.php'); 
include '../connection.php'; 



if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $stmt = $conn->prepare("DELETE FROM features WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
       
        header('Location: features_facilities.php'); 
        exit();
    } else {
        echo "Error deleting record: " . $conn->error; 
    }

    $stmt->close();
} else {
    echo "No ID specified."; 
}

$conn->close(); 
?>
