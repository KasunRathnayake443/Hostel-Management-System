<?php 
require('admin/db_config.php');
require('admin/essentials.php');
include 'connection.php';

$contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
$values = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));

?>

<nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
    <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">South Eastern University</a>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link me-2" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="room.php">Rooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="facilities.php">Facilities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="contact.php">Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        
      </ul>

      

      <div class="d-flex align-items-center">
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="dropdown">
            <?php
                
                $sql = "SELECT profile_pic FROM `user` WHERE `id` = {$_SESSION['user_id']}";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
            ?>
            <img src="images/profile_pic/<?php echo $row['profile_pic']; ?>" alt="Profile" class="profile-pic" id="profilePicture" onclick="toggleDropdown()">
            <div id="profileDropdown" class="dropdown-menu" style="display: none;">
                <a href="my_account.php" class="dropdown-item">My Account</a>
                <a href="inc/auth.php?logout=true" style="color: red;" onclick="confirmLogout()" class="dropdown-item">Logout</a>
            </div>
        </div>
    <?php else: ?>
        <button type="button" class="btn btn-outline-dark shadow-none me-lg-3" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
    <?php endif; ?>
</div>


    </div>
  </div>
</nav>
      
    

<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="inc/auth.php" method="POST">
    <div class="modal-header">
        <h5 class="modal-title display-flex align-items-center">
        <i class="bi bi-person-circle fs-3 me-2"></i>User Login
        </h5>
        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input name="email" type="email" class="form-control shadow-none" required>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input name="pass" type="password" class="form-control shadow-none" required>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-2">
            <button type="submit" name="login" class="btn btn-dark shadow-none">LOGIN</button>
            <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
        </div>
    </div>
</form>

      
    </div>
  </div>
</div>


<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form action="inc/auth.php" method="POST" id="register" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title display-flex align-items-center">
        <i class="bi bi-person-lines-fill fs-3 me-2"></i>User Registration
        </h5>
        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
            Note: Your details must match with your ID (Identity Card, Passport, driving license, etc.) that will be required during check-in.
        </span>
        <div class="container fluid">
            <div class="row">
                <div class="col-md-6 ps-0 mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" type="text" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 p-0 mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 ps-0 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input name="phonenum" type="number" class="form-control shadow-none" required>
                </div>
                <div class="col-md-12 p-0 mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
                </div>
                <div class="col-md-6 p-0 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input name="dob" type="date" class="form-control shadow-none" required>
                </div>
                <div class="col-md-12 p-0 mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input name="profile_pic" type="file" class="form-control shadow-none" accept="image/*" required>
                </div>
                <div class="col-md-6 ps-0 mb-3">
                    <label class="form-label">Password</label>
                    <input name="pass" type="password" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 p-0 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input name="cpass" type="password" class="form-control shadow-none" required>
                </div>
            </div>
        </div>

        <div class="text-center my-1">
            <button type="submit" name="register" class="btn btn-dark shadow-none">REGISTER</button>
        </div>
    </div>
</form>

      
    </div>
  </div>
</div>

<script>
function confirmLogout() {
    var confirmation = confirm("Are you sure you want to logout?");
    if (confirmation) {
        window.location.href = "your_php_file.php?logout=true";
    }
}
</script>

<script>
function toggleDropdown() {
    var dropdown = document.getElementById("profileDropdown");
    dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
}


window.onclick = function(event) {
    if (!event.target.matches('#profilePicture')) {
        var dropdown = document.getElementById("profileDropdown");
        if (dropdown && dropdown.style.display === "block") {
            dropdown.style.display = "none";
        }
    }
}
</script>

<style>
.profile-pic {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
}

#profileDropdown {
    position: absolute;
    left: -70px; 
    top: 50px;   
    display: none;
    background-color: rgba(255, 255, 255); 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    z-index: 1000;
    min-width: 130px;
}

#profileDropdown a {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: black;
}

#profileDropdown a:hover {
    background-color: #f1f1f1;
}
</style>

