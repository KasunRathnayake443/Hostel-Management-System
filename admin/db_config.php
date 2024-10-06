<?php

$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'hmwebsite';

// Create a connection to the database
$con = mysqli_connect($hname, $uname, $pass, $db);

if (!$con) {
    die("Cannot Connect to Database: " . mysqli_connect_error());
}

// Function to sanitize input data
function filteration($data) {
    foreach($data as $key => $value) {
        $value = trim($value);              
        $value = stripslashes($value);         
        $value = htmlspecialchars($value);     
        $value = strip_tags($value);    
        
        $data[$key] = $value;
    }
    return $data;
}

function selectAll($table){
    $con = $GLOBALS['con'];
    $res = mysqli_query($con,"SELECT * FROM $table");
    return $res;
}

// Function to execute SELECT queries securely
function select($sql, $values, $datatypes) {
    $con = $GLOBALS['con'];  // Access global database connection

    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);  // Bind parameters

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);  // Get the result set from the executed statement
            mysqli_stmt_close($stmt);  // Close the prepared statement
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Select");
        }

    } else {
        die("Query cannot be prepared - Select");
    }
}

// Example usage for an admin login
if(isset($_POST['login'])) {
    $frm_data = filteration($_POST);

    $query = "SELECT * FROM `admin_cred` WHERE `admin_name` = ? AND `admin_pass` = ?";
    $values = [$frm_data['admin_name'], $frm_data['admin_pass']];
    $datatypes = "ss"; // Both are strings

    $result = select($query, $values, $datatypes);

    if ($result->num_rows == 1) {
        // Handle successful login
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['adminLogin'] = true;
        $_SESSION['adminId'] = $row['sr_no'];
        redirect('dashboard.php');
    } else {
        // Handle login failure
        alert('error', 'Login failed - Invalid Credentials!');
    }

}

function update($sql, $values, $datatypes) {
    $con = $GLOBALS['con'];  // Access global database connection

    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);  // Bind parameters

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);  // Get the result set from the executed statement
            mysqli_stmt_close($stmt);  // Close the prepared statement
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Update");
        }

    } else {
        die("Query cannot be prepared - Update");
    }
}


function insert($sql, $values, $datatypes) {
    $con = $GLOBALS['con'];  // Access global database connection

    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);  // Bind parameters

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);  // Get the result set from the executed statement
            mysqli_stmt_close($stmt);  // Close the prepared statement
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Insert");
        }

    } else {
        die("Query cannot be prepared - Insert");
    }
}

function delete($sql, $values, $datatypes) {
    $con = $GLOBALS['con'];  // Access global database connection

    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);  // Bind parameters

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);  // Get the result set from the executed statement
            mysqli_stmt_close($stmt);  // Close the prepared statement
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Delete");
        }

    } else {
        die("Query cannot be prepared - Delete");
    }
}
?>
