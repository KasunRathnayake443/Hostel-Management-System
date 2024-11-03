<?php
session_start();
include 'connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System - ROOMS</title>
    <?php require('inc/links.php');
    include "connection.php";
    ?>
   
    
</head>
<body class="bg-light">

<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
<h2 class="fw-bold h-font text-center">HOSTEL ROOMS</h2>
<div class="h-line bg-dark"></div>

</div>

<div class="container-fluid">
  <div class="row">
   <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
   <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
  <div class="container-fluid flex-lg-column align-items-stretch">
    <h4 class="mt-2">FILTERS</h4>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
    <div class="border bg-light p-3 rounded mb-3">
     <h5 class="mb-3" style="font-size: 18px;">CHECK AVAILABILITY</h5>
          <label  class="form-label">Check-in</label>
          <input type="date" class="form-control shadow-none mb-3">
          <label  class="form-label">Check-out</label>
          <input type="date" class="form-control shadow-none">
    </div>
    <div class="border bg-light p-3 rounded mb-3">
     <h5 class="mb-3" style="font-size: 18px;">FACILITIES</h5>
     <div class="mt-2">
     <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
     <label  class="form-check-label" for="f1">Facility one</label>
     </div>
     <div class="mt-2">
     <input type="checkbox" id="f2" class="form-check-input shadow-none me-1">
     <label  class="form-check-label" for="f2">Facility two</label>
     </div>
     <div class="mt-2">
     <input type="checkbox" id="f3" class="form-check-input shadow-none me-1">
     <label  class="form-check-label" for="f3">Facility three</label>
     </div>
         
    </div>
    
    </div>
  </div>
</nav>
   </div>

   <div class="col-lg-9 col-md-12 px-4">

   <?php


$result = $conn->query("SELECT * FROM rooms");

while ($room = $result->fetch_assoc()) {
?>
<div class="card mb-4 border-0 shadow">
   <div class="row g-0 p-3 align-items-center">
      <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
         <img src="images/rooms/<?php echo $room['picture']; ?>" height="200px"  width="400px" class="img-fluid rounded" alt="Room Image">
      </div>
      <div class="col-md-5 px-lg-3 px-md-3 px-0">
         <h5 class="mb-3"><?php echo $room['name']; ?></h5>
         <p class="mb-2"><strong>Area:</strong> <?php echo $room['area']; ?></p>
         <p class="mb-2"><strong>Price:</strong> <?php echo $room['fees']; ?> per month</p>

         <?php 
         $sql = "SELECT COUNT(*) FROM room_$room[id] WHERE availability = 1"; 
         $available = $conn->query($sql)->fetch_row()[0];
         ?>
         <p class="mb-2"><strong>Available Rooms:</strong> <?php echo $available.'/'. $room['quantity']; ?></p>
         <p class="mb-2"><strong>Max Students:</strong> <?php echo $room['students']; ?></p>
         <p class="mb-3"><strong>Description:</strong> <?php echo $room['description']; ?></p>

         <div class="features mb-3">
            <h6 class="mb-1">Features</h6>
            <?php
            $features = explode(', ', $room['features']);
            foreach ($features as $feature) {
               echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $feature . '</span> ';
            }
            ?>
         </div>

         <div class="facilities mb-3">
            <h6 class="mb-1">Facilities</h6>
            <?php
            $facilities = explode(', ', $room['facilities']);
            foreach ($facilities as $facility) {
               echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $facility . '</span> ';
            }
            ?>
         </div>

        
         <div>
            <?php if (isset($_SESSION['user_id'])) { ?>
                
               <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookRoomModal" 
                  data-room-id="<?php echo $room['id']; ?>" 
                  data-room-name="<?php echo $room['name']; ?>" 
                  data-room-area="<?php echo $room['area']; ?>"
                  data-room-fees="<?php echo $room['fees']; ?>"
                  data-room-description="<?php echo $room['description']; ?>"
                  data-room-available="<?php echo $available; ?>">
                  Book Now
               </button>

            <?php } else { ?>
                
                <p class="text-danger">You need to<span style="color:blue;"> log in </span>to book a room.</p>
            <?php } ?>
         </div>
      </div>
   </div>
</div>
<?php
}
?>

</div>


            <div class="modal fade" id="bookRoomModal" tabindex="-1" aria-labelledby="bookRoomModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="bookRoomModalLabel">Book Room</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <p><strong>Room Name:</strong> <span id="roomName"></span></p>
                           <p><strong>Room Area:</strong> <span id="roomArea"></span> sq. ft.</p>
                           <p><strong>Price:</strong> <span id="roomFees"></span> per month</p>
                           <p><strong>Description:</strong> <span id="roomDescription"></span></p>
                           <p><strong>Available Rooms:</strong> <span id="roomAvailable"></span></p>

                          
                           <form method="POST" action="room.php" id="bookingForm">
                              <input type="hidden" name="room_id" id="roomId">

                             
                              <div class="mb-3">
                                 <label for="startDate" class="form-label">Start Date</label>
                                 <input type="date" name="start_date" id="startDate" class="form-control" required>
                              </div>

                             
                              <div class="mb-3">
                                 <label for="endDate" class="form-label">End Date</label>
                                 <input type="date" name="end_date" id="endDate" class="form-control" required>
                              </div>

                              <button type="submit" name="book" class="btn btn-success">Confirm Booking</button>
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                           </form>

                        </div>
                  </div>
               </div>
            </div>




  </div>
</div>

<?php require('inc/footer.php'); ?>

<script>
    var bookRoomModal = document.getElementById('bookRoomModal');
    bookRoomModal.addEventListener('show.bs.modal', function (event) {
        
        var button = event.relatedTarget;
        
       
        var roomId = button.getAttribute('data-room-id');
        var roomName = button.getAttribute('data-room-name');
        var roomArea = button.getAttribute('data-room-area');
        var roomFees = button.getAttribute('data-room-fees');
        var roomDescription = button.getAttribute('data-room-description');
        var roomAvailable = button.getAttribute('data-room-available');
        
        
        document.getElementById('roomName').textContent = roomName;
        document.getElementById('roomArea').textContent = roomArea;
        document.getElementById('roomFees').textContent = roomFees;
        document.getElementById('roomDescription').textContent = roomDescription;
        document.getElementById('roomAvailable').textContent = roomAvailable;
        
       
        document.getElementById('roomId').value = roomId;

        
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('startDate').setAttribute('min', today);
    });

    
    document.getElementById('startDate').addEventListener('change', function() {
        var startDate = this.value;
        document.getElementById('endDate').setAttribute('min', startDate);
    });
</script>



</body>
</html>


<?php


if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('You need to log in to book a room.');
            window.location.href='room.php';
          </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book'])) {
    $room_id = intval($_POST['room_id']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $user_id = $_SESSION['user_id'];

    
    $status_check_sql = "SELECT book_status FROM user WHERE id = ?";
    $stmt = $conn->prepare($status_check_sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($book_status);
    $stmt->fetch();
    $stmt->close();

    if ($book_status == 1) {
        echo "<script>
                alert('You have already booked a room.');
                window.location.href='room.php';
              </script>";
        exit;
    }

    $today = date('Y-m-d');
    if ($start_date < $today) {
        echo "<script>
                alert('Start date cannot be earlier than today.');
                window.location.href='room.php';
              </script>";
        exit;
    }

    if ($end_date < $start_date) {
        echo "<script>
                alert('End date cannot be earlier than the start date.');
                window.location.href='room.php';
              </script>";
        exit;
    }


    $check_sql = "SELECT id FROM room_$room_id WHERE availability = 1 LIMIT 1";
    $stmt = $conn->prepare($check_sql);
    $stmt->execute();
    $stmt->bind_result($available_room_id);
    $stmt->fetch();
    $stmt->close();

    if (!$available_room_id) {
        echo "<script>
                alert('No available rooms for the selected period.');
                window.location.href='room.php';
              </script>";
        exit;
    }

 
    $book_sql = "UPDATE room_$room_id SET student_id = ?, booked_date = NOW(), `from` = ?, `to` = ?, availability = 0 WHERE id = ?";
    $stmt = $conn->prepare($book_sql);
    $stmt->bind_param('issi', $user_id, $start_date, $end_date, $available_room_id);

    if ($stmt->execute()) {
      
        $update_status_sql = "UPDATE user SET book_status = 1 , table_name = room_$  WHERE id = ?";
        $update_stmt = $conn->prepare($update_status_sql);
        $update_stmt->bind_param('i', $user_id);
        $update_stmt->execute();
        $update_stmt->close();

        echo "<script>
                alert('Room booked successfully!');
                window.location.href='room.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to book the room. Please try again.');
                window.location.href='room.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
