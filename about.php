<?php
session_start();
include 'connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System - ABOUT</title> 
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
   <?php require('inc/links.php') ?>
  
</head>
<body class="bg-light">

<?php require('inc/header.php'); 
include 'connection.php'; ?>

<style>
  .box{
    border-top-color: var(--teal) !important;
  }
</style>

<div class="my-5 px-4">
<h2 class="fw-bold h-font text-center">ABOUT US</h2>
<div class="h-line bg-dark"></div>
<p class="text-center mt-3">
  Lorem ipsum dolor sit amet consectetur adipisicing elit. 
  Illo, magnam doloremque! Suscipit esse <br>voluptatibus fugiat rerum illo,
   iusto aliquam error!
</p>
</div>

<div class="container">
  <div class="row justify-content-between align-items-center">
    <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
      <h3 class="mb-3">Lorem ipsum dolor sit.</h3>
      <p>
         Lorem ipsum, dolor sit amet consectetur adipisicing elit.
         Assumenda nostrum impedit ipsam officiis veniam. Tenetur, culpa?
         Lorem ipsum, dolor sit amet consectetur adipisicing elit.
         Assumenda nostrum impedit ipsam officiis veniam. Tenetur, culpa?
      </p>
    </div>
    <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
       <img src="about.jpg" class="w-100">
    </div>
  </div>
</div>

<div class="container mt-5">
   <div class="row">
    <div class="col-lg-3 col-md-6 mb-4 px-4">
         <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="a.png" width="70px">
          <h4 class="mt-3">100+ ROOMS</h4>
         </div>
         
       
     
         
         
    </div>
    <div class="col-lg-3 col-md-6 mb-4 px-4">
         <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="stu.webp" width="70px">
          <h4 class="mt-3">200+ STUDENTS</h4>
         </div>
           
    </div>
    <div class="col-lg-3 col-md-6 mb-4 px-4">
         <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="rating.png" width="70px">
          <h4 class="mt-3">150+ REVIEWS</h4>
         </div>
         
    </div>
    <div class="col-lg-3 col-md-6 mb-4 px-4">
         <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="staff.webp" width="70px">
          <h4 class="mt-3">200+ STAFFS</h4>
         </div>
         
       
     
         
         
    </div>
   </div>
</div>

<h3 class="my-5 fw-bold h-font text-center">MANAGEMENT TEAM</h3>
<div class="container px-4">
  <div class="swiper mySwiper">
    <div class="swiper-wrapper mb-5">
      <?php 
      $about_r = selectAll('team_details');
      $path = "images/team/"; 

      
      while ($row = mysqli_fetch_assoc($about_r)) {
        echo <<<HTML
        <div class="swiper-slide bg-white text-center overflow-hidden rounded">
          <img src="{$path}{$row['picture']}" class="w-100" alt="{$row['name']}">
          <h5 class="mt-2">{$row['name']}</h5>
        </div>
        HTML;
      }
      ?> 
    </div>
    <div class="swiper-pagination"></div>
  </div>
</div>


<?php require('inc/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  var swiper = new Swiper(".mySwiper", {
  
    spaceBetween: 40,
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
          slidesPerView: 3,
        },
        1024: {
          slidesPerView: 3,
        },
      }
  });
</script>

</body>
</html>