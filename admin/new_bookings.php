<?php

require('essentials.php');
require('db_config.php');
include '../connection.php';


adminLogin();

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

<?php
$booking = $conn->query("SELECT * From user WHERE book_status = 1");


?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">New Bookings</h3>

            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addBookingModal">Add New Booking</button>

            <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover border">
                <thead>
                    <tr class="bg-dark text-light">
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Room Type</th>
                        <th scope="col">Room ID</th>
                        <th scope="col">Booking Date</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Total Fee</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1; 
                    
                    while ($user = $booking->fetch_assoc()) {
                        $name = $user['name'];
                        $table_name = $user['table_name'];

                        
                        $booking_details = $conn->query("SELECT id, booked_date, `from`, `to`, fee_status FROM $table_name LIMIT 1");

                        if ($booking_details && $details = $booking_details->fetch_assoc()) {
                            $room_Id = $details['id'];
                            $booked_date = $details['booked_date'];
                            $start_date = $details['from'];
                            $end_date = $details['to'];
                            $payment_status = $details['fee_status'];
                            

                            $room_name_query = "SELECT name, fees FROM rooms WHERE table_name = ?";
                            $stml = $conn->prepare($room_name_query);
                            $stml->bind_param("s", $table_name);
                            $stml->execute();
                            $stml->bind_result($room_name, $room_fees);
                            $stml->fetch();
                           

                            $start = new DateTime($start_date);
                            $end = new DateTime($end_date);

                            $interval = $start->diff($end);
                            $days_difference = $interval->days;

                            $months = ceil($days_difference / 30);
                            $total_fee = $room_fees * $months;



                           


                            
                            echo "<tr>
                                    <th scope='row'>{$index}</th>
                                    <td>" . htmlspecialchars($name) . "</td>
                                    <td>" . htmlspecialchars($room_name) . "</td>
                                    <td>" . htmlspecialchars($room_Id) . "</td>
                                    <td>" . htmlspecialchars($booked_date) . "</td>
                                    <td>" . htmlspecialchars($start_date) . "</td>
                                    <td>" . htmlspecialchars($end_date) . "</td>
                                    <td>" . htmlspecialchars($total_fee) . "</td>
                                    <td>" . htmlspecialchars($payment_status) . "</td>
                                    <td><a href='#' class='btn btn-sm btn-primary'>View</a></td>
                                  </tr>";
                            $index++;
                        }
                    }
                    ?>
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
