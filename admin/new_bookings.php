<?php
// Include essential files and database configurations
require('essentials.php');
require('db_config.php');
include '../connection.php';

// Ensure admin is logged in
adminLogin();

// Add Booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_booking'])) {
    $user_id = $_POST['user_id'];
    $room_id = $_POST['room_id'];
    $booking_date = $_POST['booking_date'];
    $duration = $_POST['duration'];

    // Insert booking query
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_id, booking_date, duration) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("iiss", $user_id, $room_id, $booking_date, $duration);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: bookings.php'); // Redirect on success
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }
}

// Delete Booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_booking'])) {
    $id = $_POST['booking_id'];

    // Delete booking query
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: bookings.php'); // Redirect on success
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all bookings
$bookings = $conn->query("SELECT bookings.*, users.name as user_name, rooms.room_number 
                          FROM bookings 
                          JOIN users ON bookings.user_id = users.id 
                          JOIN rooms ON bookings.room_id = rooms.id");

if (!$bookings) {
    die("Error fetching bookings: " . $conn->error);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - New Bookings</title>
    <?php require('links.php') ?>
</head>
<body class="bg-light">

<?php require('header.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">New Bookings</h3>

            <!-- Add Booking Button -->
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addBookingModal">Add New Booking</button>

            <!-- Booking List Table -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover border">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Room</th>
                                    <th scope="col">Booking Date</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($booking = $bookings->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $booking['id'] ?></td>
                                        <td><?= $booking['user_name'] ?></td>
                                        <td><?= $booking['room_number'] ?></td>
                                        <td><?= $booking['booking_date'] ?></td>
                                        <td><?= $booking['duration'] ?> days</td>
                                        <td>
                                            <!-- Delete Booking Action -->
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                                <button type="submit" name="delete_booking" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add Booking Modal -->
<div class="modal fade" id="addBookingModal" tabindex="-1" aria-labelledby="addBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookingModalLabel">Add New Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-select" name="user_id" required>
                            <?php
                            // Fetch users for selection
                            $users = $conn->query("SELECT id, name FROM users");
                            while ($user = $users->fetch_assoc()) {
                                echo "<option value='{$user['id']}'>{$user['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="room_id" class="form-label">Room</label>
                        <select class="form-select" name="room_id" required>
                            <?php
                            // Fetch rooms for selection
                            $rooms = $conn->query("SELECT id, room_number FROM rooms");
                            while ($room = $rooms->fetch_assoc()) {
                                echo "<option value='{$room['id']}'>{$room['room_number']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="booking_date" class="form-label">Booking Date</label>
                        <input type="date" class="form-control" name="booking_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration (Days)</label>
                        <input type="number" class="form-control" name="duration" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_booking" class="btn btn-primary">Save Booking</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require('script.php'); ?>
</body>
</html>
