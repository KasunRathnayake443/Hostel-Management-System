<?php
require('essentials.php');
require('db_config.php');
include '../connection.php';
adminLogin();?>
<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['facility_name'])) {
    $facility_name = $_POST['facility_name'];
    $facility_desc = $_POST['facility_desc'];

   
    $facility_icon = '';
    if (isset($_FILES['facility_icon']['name']) && $_FILES['facility_icon']['name'] != '') {
        $icon_name = $_FILES['facility_icon']['name'];
        $icon_tmp = $_FILES['facility_icon']['tmp_name'];
        $icon_ext = strtolower(pathinfo($icon_name, PATHINFO_EXTENSION)); 
    
        
        $allowed_extensions = ['svg', 'jpg', 'jpeg', 'png', 'webp', 'gif'];
    
        if (in_array($icon_ext, $allowed_extensions)) {
            $facility_icon = time() . '_' . $icon_name;
            move_uploaded_file($icon_tmp, "../images/facilities/" . $facility_icon);
        } else {
            echo "Invalid file type. Please upload a valid image file.";
        }
    }

 
    $stmt = $conn->prepare("INSERT INTO facilities (name, description, icon) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $facility_name, $facility_desc, $facility_icon);
    $stmt->execute();
    header('Location: features_facilities.php');
    exit();
}


$facilities = $conn->query("SELECT * FROM facilities");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Features & Facilities</title>
    <?php require('links.php') ?>
</head>
<body class="bg-light">
    
<?php require('header.php');?>



<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">FEATURES & FACILITIES</h3>


<div class="card border-0 shadow-sm mb-4">
  <div class="card-body">

  <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="card-title m-0">Features</h5>
        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#features-s">
        <i class="bi bi-plus-square"></i> Add
        </button>
    </div>
  
   
  
  <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
  <table class="table table-hover border">
  <thead>
    <tr class="bg-dark text-light">
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody id="features-data">

</table>
  </div>
 
   </div>
   
        </div>

        



        <div class="card border-0 shadow-sm mb-4">
  <div class="card-body">

  <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="card-title m-0">Facilities</h5>
        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
        <i class="bi bi-plus-square"></i> Add
        </button>


        
    </div>
    
  

    
    <!-- Facilities Table -->
    <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
    <table class="table table-hover border">
        <thead>
            <tr class="bg-dark text-light">
                <th scope="col">#</th>
                <th scope="col">Icon</th>
                <th scope="col">Name</th>
                <th scope="col" width="40%">Description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="facilities-data">
            <?php
            $facilities = selectAll('facilities'); 
            foreach ($facilities as $facility) {
                echo '<tr>
                        <td>' . htmlspecialchars($facility['id']) . '</td>
                        <td><img src="../images/facilities/' . htmlspecialchars($facility['icon']) . '" alt="Facility Icon" width="50"></td>
                        <td>' . htmlspecialchars($facility['name']) . '</td>
                        <td>' . htmlspecialchars($facility['description']) . '</td>
                        <td>
                            <a href="delete_facility.php?id=' . htmlspecialchars($facility['id']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this facility?\');">Delete</a>
                        </td>
                    </tr>';
            }
            ?>
        </tbody>
    </table>
</div>



   
   

</div>



<div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="facility_s_form" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Facility</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" name="facility_name" class="form-control shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Icon</label>
                        <input type="file" name="facility_icon"  class="form-control shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="facility_desc" class="form-control shadow-none" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
</div>







<?php require('script.php'); ?>

<script>
   let feature_s_form = document.getElementById('feature_s_form');
   let facility_s_form = document.getElementById('facility_s_form');

   feature_s_form.addEventListener('submit', function(e){
      e.preventDefault();
      add_feature();
    });
    
    function add_feature(){
      let data = new FormData();
      data.append('name',feature_s_form.elements['feature_name'].value);
      data.append('add_feature','');

      let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/features_facilities.php", true);

        xhr.onload = function(){

          var myModal = document.getElementById('feature-s');
          var modal = bootstrap.Modal.getInstance(myModal)
          modal.hide();

        if(this.responseText == 1){
          alert('success','New feature added!');
          feature_s_form.elements['feature_name'].value='';
          get_features();

        }
        else{
          alert('Error','Server Down!');

        }

        }

        xhr.send(data);
    }

    function get_features(){
      let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/features_facilities.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('features-data').innerHTML = this.responseText;
        }

        xhr.send('get_features');
    }
       
    function rem_feature(val){
      let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/features_facilities.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
           if(this.responseText==1){
            alert('success','Feature removed!');
            get_features();
           }
           else if(this.responseText == 'room_added'){
            alert('error','Feature is added in room!');

           }
           else{
            alert('error','Server down!');
           }
        }

        xhr.send('rem_feature='+val);
    }


    facility_s_form.addEventListener('submit', function(e){
      e.preventDefault();
      add_facility();
    });
    
    function add_facility(){
      let data = new FormData();
      data.append('name',facility_s_form.elements['facility_name'].value);
      data.append('icon',facility_s_form.elements['facility_icon'].files[0]);
      data.append('desc',facility_s_form.elements['facility_desc'].value);
      data.append('add_facility','');

      let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/features_facilities.php", true);

        xhr.onload = function(){

          var myModal = document.getElementById('facility-s');
          var modal = bootstrap.Modal.getInstance(myModal)
          modal.hide();

          if(this.responseText == 'inv_img'){
          alert('Error','Only SVG images are allowed!');
        }
        else if(this.responseText == 'inv_size'){
          alert('Error','Image should be less than 1MB!');
        }
        else if(this.responseText == 'upd_failed'){
          alert('Error','Image upload failed. Server Down!');
        }
        else{
          alert('success','New facility added!');
          facility_s_form.reset();
          get_facilities();

        }
        }

        xhr.send(data);
    }


    function get_facilities(){
      let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/features_facilities.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('facilities-data').innerHTML = this.responseText;
        }

        xhr.send('get_facilities');
    }
    

    function rem_facility(val){
      let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/features_facilities.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
           if(this.responseText==1){
            alert('success','Facility removed!');
            get_facilities();
           }
           else if(this.responseText == 'room_added'){
            alert('error','Facility is added in room!');

           }
           else{
            alert('error','Server down!');
           }
        }

        xhr.send('rem_facility='+val);
    }


    window.onload =function(){
      get_features();
      get_facilities();
    }

</script>

</body>
</html>