<?php
require('essentials.php');
adminLogin();
include '../connection.php';

if (isset($_GET['id'])) {
    $facility_id = $_GET['id'];

 
    $query = "DELETE FROM facilities WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $facility_id);
    
    if ($stmt->execute()) {
        
        header("Location: features_facilities.php?message=Facility deleted successfully");
    } else {
        echo "Error deleting facility.";
    }
    
    $stmt->close();
}
?>
