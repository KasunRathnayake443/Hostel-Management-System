<?php
require('essentials.php');
require('db_config.php');
include '../connection.php';
adminLogin(); // Ensure the admin is logged in

// Handle feature form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feature_name'])) {
    $feature_name = $_POST['feature_name'];

    // Insert the new feature into the database
    $stmt = $conn->prepare("INSERT INTO features (name) VALUES (?)");
    $stmt->bind_param("s", $feature_name);
    $stmt->execute();

    // Redirect back to the features and facilities page
    header('Location: features_facilities.php');
    exit();
}

// Handle facility form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['facility_name'])) {
    $facility_name = $_POST['facility_name'];
    $facility_desc = $_POST['facility_desc'];
    $facility_icon = '';

    // Handle the facility icon upload
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
            exit();
        }
    }

    // Insert the new facility into the database
    $stmt = $conn->prepare("INSERT INTO facilities (name, description, icon) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $facility_name, $facility_desc, $facility_icon);
    $stmt->execute();

    // Redirect back to the features and facilities page
    header('Location: features_facilities.php');
    exit();
}

// Fetch all features and facilities to display
$features = $conn->query("SELECT * FROM features");
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
    <?php require('header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">FEATURES & FACILITIES</h3>

                <!-- Features Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Features</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#feature-s">
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
                                <tbody>
                                    <?php while ($feature = $features->fetch_assoc()) { ?>
                                        <tr>
                                            <th scope="row"><?php echo $feature['id']; ?></th>
                                            <td><?php echo $feature['name']; ?></td>
                                            <td>
                                            <a href="delete_feature.php?id=<?php echo $feature['id']; ?>" class="btn btn-sm btn-outline-danger">Delete</a>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Facilities Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Facilities</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

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
                                <tbody>
                                    <?php while ($facility = $facilities->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $facility['id']; ?></td>
                                            <td><img src="../images/facilities/<?php echo $facility['icon']; ?>" width="50"></td>
                                            <td><?php echo $facility['name']; ?></td>
                                            <td><?php echo $facility['description']; ?></td>
                                            <td>
                                                <a href="delete_facility.php?id=<?php echo $facility['id']; ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal for Adding Features -->
                <div class="modal fade" id="feature-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="features_facilities.php">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Feature</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name</label>
                                        <input type="text" name="feature_name" class="form-control shadow-none" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal for Adding Facilities -->
                <div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="features_facilities.php" enctype="multipart/form-data">
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
                                        <input type="file" name="facility_icon" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="facility_desc" class="form-control shadow-none" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('script.php'); ?>
</body>
</html>
