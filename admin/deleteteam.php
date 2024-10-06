<?php
include '../connection.php';


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);  

    
    $sql = "DELETE FROM team_details WHERE sr_no = ?";
    
   
    if ($stmt = $conn->prepare($sql)) {
        
        $stmt->bind_param("i", $id);

       
        if ($stmt->execute()) {
           
            header("Location: setting.php?message=deleted");
            exit();  
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

 
    $stmt->close();
} else {
    echo "No ID provided to delete.";
}


$conn->close();
?>
