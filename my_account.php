<?php
session_start();
include 'connection.php';
require('inc/links.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please log in to view your account.');
            window.location.href='login.php';
          </script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$update_message = '';


$user_sql = "SELECT name, email, phone_no, address, book_status, table_name FROM user WHERE id = ?";
$stmt = $conn->prepare($user_sql);
if (!$stmt) {
    die("Prepared statement failed: " . $conn->error); 
}
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $phone_no, $address, $book_status, $table_name);
$stmt->fetch();
$stmt->close();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
 
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];
    $new_phone = $_POST['phone'];
    $new_address = $_POST['address'];

    
    if (empty($new_name) || empty($new_email) || empty($new_phone) || empty($new_address)) {
        $update_message = "All fields are required.";
    } else {
        
        $update_sql = "UPDATE user SET name = ?, email = ?, phone_no = ?, address = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        if (!$stmt) {
            die("Prepared statement failed: " . $conn->error); 
        }
        
        $stmt->bind_param('sssii', $new_name, $new_email, $new_phone, $new_address, $user_id);

        if ($stmt->execute()) {
            $update_message = "Profile updated successfully.";
            $name = $new_name;
            $email = $new_email;
            $phone_no = $new_phone;
            $address = $new_address;
        } else {
            $update_message = "Failed to update profile. Please try again.";
        }

        $stmt->close();
    }
}


$has_booking = false;
if ($book_status == 1 && !empty($table_name)) {
    $booking_sql = "SELECT id, booked_date, `from`, `to`, fee_status FROM $table_name WHERE student_id = ? LIMIT 1";
    $stmt = $conn->prepare($booking_sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($room_id, $booked_date, $start_date, $end_date, $fee_status);
    $has_booking = $stmt->fetch();
    $stmt->close();

    $room_name_query = "SELECT name, fees FROM rooms WHERE table_name = ?";
    $stml = $conn->prepare($room_name_query);
    $stml->bind_param("s", $table_name);
    $stml->execute();
    $stml->bind_result($room_name, $room_fees);
    $stml->fetch();
    $stml->close();
}

$start = new DateTime($start_date);
$end = new DateTime($end_date);


$interval = $start->diff($end);
$days_difference = $interval->days;


$months = ceil($days_difference / 30);  


$total_fee = $room_fees * $months;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f7f8fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .main-container {
            max-width: 1000px;
            width: 100%;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            font-size: 2em;
            color: #333;
        }
        .back-button {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
            font-size: 0.9em;
        }
        .content {
            display: flex;
            gap: 20px;
        }
        .card {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
        }
        .card h3 {
            margin-bottom: 15px;
            font-size: 1.3em;
            color: #555;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        .form-group button {
            width: 100%;
            padding: 12px;
            font-size: 1em;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .update-message {
            color: #28a745;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }
        .no-booking {
            color: #888;
        }
    </style>
</head>
<body>

    <div class="main-container">
        <div class="header">
            <h2>My Account</h2>
            <a href="index.php" class="back-button">&larr; Back to Site</a>
        </div>

        <?php if ($update_message): ?>
            <p class="update-message"><?php echo $update_message; ?></p>
        <?php endif; ?>

        <div class="content">
        
            <div class="card">
                <h3>Update Profile</h3>
                <form method="POST" action="my_account.php">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($phone_no); ?>">
                    </div>
                    <div class="form-group">
                        <label>Address:</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update_profile">Update Profile</button>
                    </div>
                </form>
            </div>

       
            <div class="card">
                <h3>Booking Details</h3>
                <?php if ($has_booking): ?>
                    <p><strong>Room Type:</strong> <?php echo htmlspecialchars($room_name); ?></p>
                    <p><strong>Room ID:</strong> <?php echo htmlspecialchars($room_id); ?></p>
                    <p><strong>Booked Date:</strong> <?php echo htmlspecialchars($booked_date); ?></p>
                    <p><strong>Start Date:</strong> <?php echo htmlspecialchars($start_date); ?></p>
                    <p><strong>End Date:</strong> <?php echo htmlspecialchars($end_date); ?></p>
                    <p><strong>Total Fee:</strong> Rs. <?php echo htmlspecialchars(number_format($total_fee, 2)); ?></p>
                    <p><strong>Payment Status : </strong><?php echo htmlspecialchars($fee_status); ?></p>
                <?php else: ?>
                    <p class="no-booking">No booking details found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
