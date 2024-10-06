

<?php
require('essentials.php');
adminLogin();
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['carousel_picture']) && $_FILES['carousel_picture']['error'] == 0) {
       
        $target_dir = "../images/carousel/";

       
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES['carousel_picture']['name']);
        $target_file = $target_dir . $file_name;

       
        $allowed_types = ['jpg', 'png', 'jpeg', 'webp'];
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($file_type, $allowed_types)) {
         
            if (file_exists($target_file)) {
                $error_message = "File already exists.";
            } else {
              
                if (move_uploaded_file($_FILES['carousel_picture']['tmp_name'], $target_file)) {
                    
                    $stmt = $conn->prepare("INSERT INTO carousel (image) VALUES (?)");
                    $stmt->bind_param('s', $file_name);
                    $stmt->execute();
                    $stmt->close();

                    $success_message = "Image uploaded successfully.";
                } else {
                    $error_message = "There was an error uploading the file.";
                }
            }
        } else {
            $error_message = "Invalid file type. Only JPG, PNG, JPEG, and WEBP are allowed.";
        }
    } else {
        $error_message = "No file uploaded or file upload error.";
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_image'])) {
    $delete_id = $_POST['delete_id'];

   
    $stmt = $conn->prepare("SELECT image FROM carousel WHERE sr_no = ?");
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    $stmt->bind_result($image_path);
    $stmt->fetch();
    $stmt->close();

  
    $file_path = "../images/carousel/" . $image_path;
    if (file_exists($file_path)) {
        unlink($file_path);  
    }

    
    $stmt = $conn->prepare("DELETE FROM carousel WHERE sr_no = ?");
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    $stmt->close();

    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Carousel</title>
    <?php require('links.php') ?>
</head>
<body class="bg-light">
    
<?php require('header.php')?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">CAROUSEL</h3>

            <?php
            if (isset($success_message)) {
                echo "<div class='alert alert-success'>$success_message</div>";
            }
            if (isset($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>

            <!-- Carousel Image Upload Form -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">Images</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#carousel-s">
                            <i class="bi bi-plus-square"></i> Add
                        </button>
                    </div>

                    <div class="row">
    <?php
    $result = $conn->query("SELECT * FROM carousel");
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="../images/carousel/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="Carousel Image">
                <div class="card-body text-center">
                    <!-- Delete Button -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="delete_id" value="' . $row['sr_no'] . '">
                        <button type="submit" name="delete_image" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this image?\')">Delete</button>
                    </form>
                </div>
            </div>
        </div>';
    }
    ?>
    </div>
  </div>
</div>






            <!-- Modal for Image Upload -->
            <div class="modal fade" id="carousel-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Image</h5>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Picture</label>
                                    <input type="file" name="carousel_picture" id="carousel_picture_inp" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                            </div>
                        </div>
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
