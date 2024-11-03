<?php
session_start();
include 'connection.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System</title>
    <?php require('inc/links.php') ?>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
   
    
    <style>
        .availability-form{
        margin-top: -50px;
        z-index: 2;
        position: relative;
       }

       @media screen and (max-width: 575px) {
        .availability-form{
        margin-top: 25px;
        padding: 0 35px;
       }
       }

        </style>
</head>

<body class="bg-light">

<?php require('inc/header.php'); 
include 'connection.php'; ?>

<div class="container-fluid px-lg-3 mt-4">
  <div class="swiper swiper-container">
    <div class="swiper-wrapper">
      <?php 
        $res = selectAll('carousel'); 
        while($row = mysqli_fetch_assoc($res)){
          $path = 'images/carousel/';
  
          echo <<<HTML
          <div class="swiper-slide">
            <img src="{$path}{$row['image']}" class="w-100 d-block" alt="Carousel Image" style="height: 500px; object-fit: cover;">
          </div>
          HTML;
        }    
      ?>
    </div>
  </div>
</div>



<div class="container availability-form">
  <div class="row">
    <div class="col-lg-12 bg-white shadow p-4 rounded">
      <h5 class="mb-4">Check booking Availability</h5>
      <form>
        <div class="row align-items-end">
          <div class="col-lg-3 mb-3">
          <label  class="form-label" style="font-weight: 500;">Check-in</label>
          <input type="date" class="form-control shadow-none">
          </div>
          <div class="col-lg-3 mb-3">
          <label  class="form-label" style="font-weight: 500;">Check-out</label>
          <input type="date" class="form-control shadow-none">
         </div>
         <div class="col-lg-3 mb-3">
         <label  class="form-label" style="font-weight: 500;">Villa & Room no</label>
         <select class="form-select shadow-none">
          <option selected>Open this select menu</option>
          <option value="1">villa 2 Room no 4</option>
          <option value="2">villa 5 Room no 47</option>
          <option value="3">villa 3 Room no 85</option>
         </select>
         </div>
         <div class="col-lg-3 mb-3">
         <label  class="form-label" style="font-weight: 500;">No of roommates</label>
         <select class="form-select shadow-none">
          <option selected>Open this select menu</option>
          <option value="1">one</option>
          <option value="2">two</option>
          <option value="3">three</option>
         </select>
         </div>
         <div class="col-lg-1 mb-lg-3 mt-2">
          <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
         </div>
        </div>
      </form>
    </div>
  </div>
</div>

<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">HOSTEL ROOMS</h2>
<div class="container">
  <div class="row">
    <?php
    
    $result = $conn->query("SELECT * FROM rooms LIMIT 3");

   
    while ($room = $result->fetch_assoc()) {
    ?>
      <div class="col-lg-4 col-md-6 my-3">
        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
          <img src="images/rooms/<?php echo $room['picture']; ?>" height="200px" class="card-img-top">

          <div class="card-body">
            <h5><?php echo $room['name']; ?></h5>
            <h6 class="mb-4">For <?php echo $room['students']; ?> Students</h6>
            
            <div class="features mb-4">
              <h6 class="mb-1">Features</h6>
              <?php
              $features = explode(', ', $room['features']);
              foreach ($features as $feature) {
                echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $feature . '</span>';
              }
              ?>
            </div>

            <div class="facilities mb-4">
              <h6 class="mb-1">Facilities</h6>
              <?php
              $facilities = explode(', ', $room['facilities']);
              foreach ($facilities as $facility) {
                echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $facility . '</span>';
              }
              ?>
            </div>

            <div class="rating mb-4">
              <h6 class="mb-1">Rating</h6>
              <span class="badge rounded-pill bg-light">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
              </span>
            </div>

            <div class="d-flex justify-content-evenly mb-2">
              <a href="room.php?room_id=<?php echo $room['id']; ?>" class="btn btn-sm text-white custom-bg shadow-none">Book Now</a>
              <a href="room.php" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
            </div>
          </div>
        </div>
      </div>
    <?php
    } 
    ?>
    
    <div class="col-lg-12 text-center mt-5">
      <a href="room.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
    </div>
  </div>
</div>


<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">HOSTEL FACILITIES</h2>

<div class="container">
  <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
    <?php
    
    $result = $conn->query("SELECT * FROM facilities LIMIT 5");

   
    while ($facility = $result->fetch_assoc()) {
    ?>
      <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
        <img src="images/facilities/<?php echo $facility['icon']; ?>" width="80px">
        <h5 class="mt-3"><?php echo $facility['name']; ?></h5>
      </div>
    <?php
    } 
    ?>
    
    <div class="col-lg-12 text-center mt-5">
      <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities >>></a>
    </div>
  </div>
</div>



<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">HOSTEL TESTIMONIALS</h2>

<div class="container">
  <div class="swiper swiper-testimonials">
    <div class="swiper-wrapper mb-5">

      <div class="swiper-slide bg-white p-4">
       <div class="profile d-flex align-items-center mb-3">
        <img src="profile.png" width="30px">
        <h6 class="m-0 ms-2">Warden</h6>
       </div>
       <p>
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
        Velit suscipit quod beatae aut, iusto quisquam consectetur tempora est sint ratione?
       </p>
       <div class="rating">
        <i class="bi bi-star-fill text-warning"></i>
        <i class="bi bi-star-fill text-warning"></i>
        <i class="bi bi-star-fill text-warning"></i>
        <i class="bi bi-star-fill text-warning"></i>
       </div>
      </div>
      
      <div class="swiper-slide bg-white p-4">
        <div class="profile d-flex align-items-center mb-3">
         <img src="profile.png" width="30px">
         <h6 class="m-0 ms-2">Sub Warden</h6>
        </div>
        <p>
         Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
         Velit suscipit quod beatae aut, iusto quisquam consectetur tempora est sint ratione?
        </p>
        <div class="rating">
         <i class="bi bi-star-fill text-warning"></i>
         <i class="bi bi-star-fill text-warning"></i>
         <i class="bi bi-star-fill text-warning"></i>
         <i class="bi bi-star-fill text-warning"></i>
        </div>
       </div>
       
      <div class="swiper-slide bg-white p-4">
        <div class="profile d-flex align-items-center mb-3">
         <img src="profile.png" width="30px">
         <h6 class="m-0 ms-2">Sub Warden</h6>
        </div>
        <p>
         Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
         Velit suscipit quod beatae aut, iusto quisquam consectetur tempora est sint ratione?
        </p>
        <div class="rating">
         <i class="bi bi-star-fill text-warning"></i>
         <i class="bi bi-star-fill text-warning"></i>
         <i class="bi bi-star-fill text-warning"></i>
         <i class="bi bi-star-fill text-warning"></i>
        </div>
       </div>
      
    </div>
    <div class="swiper-pagination"></div>
  </div>
  <div class="col-lg-12 text-center mt-5">
    <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know More >>></a>
  </div>
</div>



<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>

<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
      <iframe class="w-100 rounded" height="320px" src="<?php echo $contact_r['iframe'] ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="col-lg-4 col-md-4">
<div class="bg-white p-4 rounded mb-4">
  <h5>Call Us</h5>
  <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
    <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
    </a>
    <br>
    <?php 
    if($contact_r['pn2']!=''){
        echo<<<data
         <a href="tel: +$contact_r[pn2]" class="d-inline-block text-decoration-none text-dark">
         <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
         </a>
        data;
    }
    ?>
   
</div>
<div class="bg-white p-4 rounded mb-4">
  <h5>Follow Us</h5>
  <?php 
  if($contact_r['tw']!=''){
   echo<<<data
   <a href="$contact_r[tw]" class="d-inline-block mb-3">
      <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-twitter me-1"></i>Twitter</span>
       </a>
       <br>
   data;
  }
  ?>
  
    <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-3">
      <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-facebook me-1"></i>Facebook</span>
      </a>
      <br>
      <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block">
        <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-instagram me-1"></i>Instagram</span>
        </a>
    <br>
   
</div>
    </div>
  </div>
</div>

<?php require('inc/footer.php'); ?>


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      }
     
    });

    var swiper = new Swiper(".swiper-testimonials", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      slidesPerView: "3",
      loop: true,
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: false,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      }
    });
  </script>
</body>
</html>