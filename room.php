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

        <?php $sql = "SELECT COUNT(*) FROM room_$room[id] WHERE availability = 1"; 
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
      </div>

      <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
         <a href="book_room.php?room_id=<?php echo $room['id']; ?>" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Book Now</a>
         <a href="room_details.php?room_id=<?php echo $room['id']; ?>" class="btn btn-sm w-100 btn-outline-dark shadow-none">More Details</a>
      </div>
   </div>
</div>
<?php
} 
?>
</div>


  </div>
</div>

<?php require('inc/footer.php'); ?>

</body>
</html>