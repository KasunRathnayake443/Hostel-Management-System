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
    <?php require('inc/links.php') ;
    include 'connection.php';
    
    ?>
   
   <style>
    .pop:hover{
      border-top-color: var(--teal) !important;
      transform: scale(1.03);
      transition: all 0.3s;
    }
   </style>
    
</head>
<body class="bg-light">

<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
<h2 class="fw-bold h-font text-center">HOSTEL FACILITIES</h2>
<div class="h-line bg-dark"></div>
<p class="text-center mt-3">
  Lorem ipsum dolor sit amet consectetur adipisicing elit. 
  Illo, magnam doloremque! Suscipit esse <br>voluptatibus fugiat rerum illo,
   iusto aliquam error!
</p>
</div>
<div class="container">
  <div class="row">
    <?php
    $res = selectAll('facilities'); 
    $path = 'images/facilities/'; 

    while($row = mysqli_fetch_assoc($res)){
      echo<<<data
          <div class="col-lg-4 col-md-6 mb-5 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
              <div class="d-flex align-items-center mb-2">
                <img src="$path$row[icon]" width="40px" alt="Facility Icon">
                <h5 class="m-0 ms-3">{$row['name']}</h5>
              </div>
              <p>{$row['description']}</p>
            </div>
          </div>
      data;
    }
    ?>
  </div>
</div>

</div>

<?php require('inc/footer.php'); ?>

</body>
</html>