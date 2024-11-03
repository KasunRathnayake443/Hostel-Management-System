<?php
require('essentials.php');
adminLogin();
include('../connection.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['submit_general'])) {
        $site_title = $_POST['site_title'];
        $site_about = $_POST['site_about'];

        
        $conn->query("UPDATE settings SET site_title='$site_title', site_about='$site_about' WHERE sr_no=1");
    }

    
    if (isset($_POST['submit_contacts'])) {
        $address = $_POST['address'];
        $gmap = $_POST['gmap'];
        $pn1 = $_POST['pn1'];
        $pn2 = $_POST['pn2'];
        $email = $_POST['email'];
        $fb = $_POST['fb'];
        $insta = $_POST['insta'];
        $tw = $_POST['tw'];
        $iframe = $_POST['iframe'];

        
        $conn->query("UPDATE contact_details SET address='$address', gmap='$gmap', pn1='$pn1', pn2='$pn2', email='$email', fb='$fb', insta='$insta', tw='$tw', iframe='$iframe' WHERE sr_no=1");
    }

   
    if (isset($_POST['submit_team'])) {
        $member_name = $_POST['member_name'];
        $member_picture = $_FILES['member_picture']['name'];
        $target_dir = "../images/team/";
        $target_file = $target_dir . basename($member_picture);

       
        if (move_uploaded_file($_FILES['member_picture']['tmp_name'], $target_file)) {
            
            $conn->query("INSERT INTO team_details (name, picture) VALUES ('$member_name', '$member_picture')");
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the shutdown checkbox is present in the form
        $shutdown_status = isset($_POST['shutdown']) ? 1 : 0;
    
        // Update shutdown status in the database
        $conn->query("UPDATE settings SET shutdown='$shutdown_status' WHERE sr_no=1");
    
        // Refresh the page to reflect the updated setting
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}




$generalSettings = $conn->query("SELECT * FROM settings WHERE sr_no=1")->fetch_assoc();
$contactSettings = $conn->query("SELECT * FROM contact_details WHERE sr_no=1")->fetch_assoc();
$team = $conn->query("SELECT * FROM team_details");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Settings</title>
    <?php require('links.php') ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

   
</head>
<body class="bg-light">
    
<?php require('header.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">SETTINGS</h3>

            <!-- General Settings Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">General Settings</h5>
                    </div>

                    <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                    <p class="card-text"><?php echo htmlspecialchars($generalSettings['site_title']); ?></p>
                    <h6 class="card-subtitle mb-1 fw-bold">About Us</h6>
                    <p class="card-text"><?php echo htmlspecialchars($generalSettings['site_about']); ?></p>
                    
                    <form method="POST">
                        <h5 class="mt-3">Edit General Settings</h5>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Site Title</label>
                            <input type="text" name="site_title" value="<?php echo htmlspecialchars($generalSettings['site_title']); ?>" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">About Us</label>
                            <textarea name="site_about" class="form-control shadow-none" rows="6" required><?php echo htmlspecialchars($generalSettings['site_about']); ?></textarea>
                        </div>
                        <button type="submit" name="submit_general" style="background-color: blue;" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </form>
                </div>
            </div>

            <!-- Shutdown Website Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">Shutdown Website</h5>
                        <form method="POST">
                            <input type="checkbox" name="shutdown" onchange="this.form.submit()" <?php echo ($generalSettings['shutdown'] ? 'checked' : ''); ?>>
                        </form>
                    </div>
                    <p class="card-text">
                        No students will be allowed to book hostel room when Shutdown mode is turned on.
                    </p>
                </div>
            </div>

            <!-- Contacts Settings Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title m-0">Contacts Settings</h5>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($contactSettings['address']); ?>" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Google Map Link</label>
                            <input type="text" name="gmap" value="<?php echo htmlspecialchars($contactSettings['gmap']); ?>" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone Numbers (with country code)</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="number" name="pn1" value="<?php echo htmlspecialchars($contactSettings['pn1']); ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="number" name="pn2" value="<?php echo htmlspecialchars($contactSettings['pn2']); ?>" class="form-control shadow-none">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($contactSettings['email']); ?>" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Social Links</label>
                            <input type="text" name="fb" value="<?php echo htmlspecialchars($contactSettings['fb']); ?>" class="form-control shadow-none" required>
                            <input type="text" name="insta" value="<?php echo htmlspecialchars($contactSettings['insta']); ?>" class="form-control shadow-none" required>
                            <input type="text" name="tw" value="<?php echo htmlspecialchars($contactSettings['tw']); ?>" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">iFrame Src</label>
                            <input type="text" name="iframe" value="<?php echo htmlspecialchars($contactSettings['iframe']); ?>" class="form-control shadow-none" required>
                        </div>
                        <button type="submit" style="background-color: blue;" name="submit_contacts" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </form>
                </div>
            </div>

           
            <div class="container mt-4">
    <!-- Management Team Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="card-title m-0">Management Team</h5>
                <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#team-s">
                    <i class="bi bi-plus-square"></i> Add
                </button>
            </div>

            <div class="row" id="team-data">
                <?php 
                
                while ($row = $team->fetch_assoc()): ?>
                    <div class="col-md-2 mb-3">
                        <div class="card bg-dark text-white">
                            <img src="../images/team/<?php echo htmlspecialchars($row['picture']); ?>" class="card-img" alt="Team Member">
                            <div class="card-img-overlay text-end">
                                <a href="deleteteam.php?id=<?php echo $row['sr_no']; ?>" onclick="return confirm('Are you sure you want to delete this team member?');" class="btn btn-danger btn-sm shadow-none">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </div>
                            <p class="card-text text-center px-3 py-2"><?php echo htmlspecialchars($row['name']); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- Add Team Member Modal -->
    <div class="modal fade" id="team-s" tabindex="-1" aria-labelledby="team-s-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="team-s-label">Add Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="member_name" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Picture</label>
                            <input type="file" name="member_picture" class="form-control shadow-none" accept="image/*" required>
                        </div>
                        <button type="submit" style="background-color: blue;" name="submit_team" class="btn custom-bg text-white shadow-none">Add Member</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
