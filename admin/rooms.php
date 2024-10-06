<?php
require('essentials.php');
require('db_config.php');
include '../connection.php';
adminLogin();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room_form'])) {
    $name = $_POST['name'];
    $area = $_POST['area'];
    $fees = $_POST['fees'];
    $quantity = $_POST['quantity'];
    $students = $_POST['students'];
    $desc = $_POST['desc'];
    $features = isset($_POST['features']) ? implode(', ', $_POST['features']) : '';
    $facilities = isset($_POST['facilities']) ? implode(', ', $_POST['facilities']) : '';

    $picture = $_FILES['picture']['name'];
    $picture_tmp = $_FILES['picture']['tmp_name'];
    $picture_name = basename($picture);
    $picture_path = "../images/rooms/" . $picture_name;
    move_uploaded_file($picture_tmp, $picture_path);


    $stmt = $conn->prepare("INSERT INTO rooms (name, area, fees, quantity, students, description, facilities, features, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisissss", $name, $area, $fees, $quantity, $students, $desc, $facilities, $features, $picture_path);
    $stmt->execute();
    $room_id = $stmt->insert_id; 

    
    $create_table_query = "CREATE TABLE room_$room_id (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT,
        booked_date DATE,
        `from` DATE,
        `to` DATE,
        availability INT DEFAULT 1
    )";
    $conn->query($create_table_query);

    
    for ($i = 1; $i <= $quantity; $i++) {
        $conn->query("INSERT INTO room_$room_id (availability) VALUES (1)");
    }

    header('Location: rooms.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_room'])) {
    $id = $_POST['room_id'];
    $name = $_POST['name'];
    $area = $_POST['area'];
    $fees = $_POST['fees'];
    $quantity = $_POST['quantity'];
    $students = $_POST['students'];
    $desc = $_POST['desc'];
    $features = isset($_POST['features']) ? implode(', ', $_POST['features']) : '';
    $facilities = isset($_POST['facilities']) ? implode(', ', $_POST['facilities']) : '';

    if (!empty($_FILES['picture']['name'])) {
        $picture = $_FILES['picture']['name'];
        $picture_tmp = $_FILES['picture']['tmp_name'];
        $picture_name = basename($picture); 
        $picture_path = "../images/rooms/" . $picture_name;
        move_uploaded_file($picture_tmp, $picture_path);
    
        
        $stmt = $conn->prepare("UPDATE rooms SET name=?, area=?, fees=?, quantity=?, students=?, description=?, facilities=?, features=?, picture=? WHERE id=?");
        $stmt->bind_param("siisissssi", $name, $area, $fees, $quantity, $students, $desc, $facilities, $features, $picture_name, $id);
    } else {
        
        $stmt = $conn->prepare("UPDATE rooms SET name=?, area=?, fees=?, quantity=?, students=?, description=?, facilities=?, features=? WHERE id=?");
        $stmt->bind_param("ssiissssi", $name, $area, $fees, $quantity, $students, $desc, $facilities, $features, $id);
    }
    
    $stmt->execute();
    

   
    $current_row_count = $conn->query("SELECT COUNT(*) FROM room_$id")->fetch_row()[0];
    if ($quantity > $current_row_count) {
       
        for ($i = $current_row_count + 1; $i <= $quantity; $i++) {
            $conn->query("INSERT INTO room_$id (availability) VALUES (1)");
        }
    } elseif ($quantity < $current_row_count) {
      
        $conn->query("DELETE FROM room_$id ORDER BY id DESC LIMIT " . ($current_row_count - $quantity));
    }

    header('Location: rooms.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_room'])) {
    $id = $_POST['room_id'];

   
    $conn->query("DROP TABLE IF EXISTS room_$id");

    $stmt = $conn->prepare("DELETE FROM rooms WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header('Location: rooms.php');
    exit();
}




$facilities = $conn->query("SELECT * FROM facilities");
$features = $conn->query("SELECT * FROM features");
$rooms = $conn->query("SELECT * FROM rooms");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Rooms</title>
    
    <?php require('links.php') ?>
    
</head>
<body class="bg-light">

<?php require('header.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">ROOMS</h3>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="text-end mb-4">
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
                            <i class="bi bi-plus-square"></i> Add
                        </button>
                    </div>

                    <div class="table-responsive-lg">
                        <table class="table table-hover border text-center">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Picture</th>
                                    <th scope="col">Area</th>
                                    <th scope="col">Students</th>
                                    <th scope="col">Hostel Fees</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Facilities</th>
                                    <th scope="col">Features</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($room = mysqli_fetch_assoc($rooms)): ?>
                                    <tr>
                                        <td><?= $room['id'] ?></td>
                                        <td><?= $room['name'] ?></td>
                                        <td><img src="../images/rooms/<?= $room['picture'] ?>" alt="Room Picture" style="width:100px;height:auto;"></td>
                                        <td><?= $room['area'] ?></td>
                                        <td><?= $room['students'] ?></td>
                                        <td><?= $room['fees'] ?></td>
                                        <td><?= $room['quantity'] ?></td>
                                        <td><?= $room['facilities'] ?></td>
                                        <td><?= $room['features'] ?></td>
                                        <td>
                                          
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit-room-<?= $room['id'] ?>">Edit</button>

                                         
                                            <form method="POST" style="display:inline-block;">
                                                <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                                                <button type="submit" name="delete_room" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this room?');">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                 
                                    <div class="modal fade" id="edit-room-<?= $room['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <form form id="edit_room" action="rooms.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Room</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="room_id" value="<?= $room['id'] ?>">

                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Name</label>
                                                                <input type="text" name="name" class="form-control shadow-none" value="<?= $room['name'] ?>" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Area</label>
                                                                <input type="text" name="area" class="form-control shadow-none" value="<?= $room['area'] ?>" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Hostel Fees</label>
                                                                <input type="number" name="fees" class="form-control shadow-none" value="<?= $room['fees'] ?>" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Quantity</label>
                                                                <input type="number" name="quantity" class="form-control shadow-none" value="<?= $room['quantity'] ?>" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Students</label>
                                                                <input type="number" name="students" class="form-control shadow-none" value="<?= $room['students'] ?>" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Picture</label>
                                                                <input type="file" name="picture" class="form-control shadow-none" accept="image/*">
                                                                <img src="../images/rooms/<?= $room['picture'] ?>" style="width:100px; height:auto;" alt="Room Image">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label fw-bold">Description</label>
                                                            <textarea name="desc" rows="4" class="form-control shadow-none" required><?= $room['description'] ?></textarea>
                                                        </div>
                                                       
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label fw-bold">Features</label>
                                                            <div class="row">
                                                                <?php
                                                                $room_features = explode(', ', $room['features']); 
                                                                $features = mysqli_query($conn, "SELECT name FROM features"); 
                                                                while ($opt = mysqli_fetch_assoc($features)) : ?>
                                                                    <div class='col-md-3 mb-1'>
                                                                        <label>
                                                                            <input type='checkbox' name='features[]' value='<?= $opt['name'] ?>' class='form-check-input shadow-none' <?= in_array($opt['name'], $room_features) ? 'checked' : '' ?>>
                                                                            <?= $opt['name'] ?>
                                                                        </label>
                                                                    </div>
                                                                <?php endwhile; ?>
                                                            </div>
                                                        </div>

                                                       
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label fw-bold">Facilities</label>
                                                            <div class="row">
                                                                <?php
                                                                $room_facilities = explode(', ', $room['facilities']); 
                                                                $facilities = mysqli_query($conn, "SELECT name FROM facilities"); 
                                                                while ($opt = mysqli_fetch_assoc($facilities)) : ?>
                                                                    <div class='col-md-3 mb-1'>
                                                                        <label>
                                                                            <input type='checkbox' name='facilities[]' value='<?= $opt['name'] ?>' class='form-check-input shadow-none' <?= in_array($opt['name'], $room_facilities) ? 'checked' : '' ?>>
                                                                            <?= $opt['name'] ?>
                                                                        </label>
                                                                    </div>
                                                                <?php endwhile; ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                                        <button type="submit" name="edit_room" class="btn  text-secondary shadow-none">UPDATE</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

           
            <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <form id="add_room_form" action="rooms.php" method="POST" enctype="multipart/form-data" autocomplete="off">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Room</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Name</label>
                                            <input type="text" name="name" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Area</label>
                                            <input type="text" min="1" name="area" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Hostel Fees</label>
                                            <input type="number" min="1" name="fees" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Quantity</label>
                                            <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Students (Max.)</label>
                                            <input type="number" min="1" name="students" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Picture</label>
                                            <input type="file" name="picture" class="form-control shadow-none" accept="image/*" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Features</label>
                                        <div class="row">
                                            <?php
                                           
                                            $features = mysqli_query($conn, "SELECT name FROM features"); 
                                            while ($opt = mysqli_fetch_assoc($features)) : ?>
                                                <div class='col-md-3 mb-1'>
                                                    <label>
                                                        <input type='checkbox' name='features[]' value='<?= $opt['name'] ?>' class='form-check-input shadow-none'>
                                                        <?= $opt['name'] ?>
                                                    </label>
                                                </div>
                                            <?php endwhile; ?>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Facilities</label>
                                        <div class="row">
                                            <?php
                                            
                                            $facilities = mysqli_query($conn, "SELECT name FROM facilities"); 
                                            while ($opt = mysqli_fetch_assoc($facilities)) : ?>
                                                <div class='col-md-3 mb-1'>
                                                    <label>
                                                        <input type='checkbox' name='facilities[]' value='<?= $opt['name'] ?>' class='form-check-input shadow-none'>
                                                        <?= $opt['name'] ?>
                                                    </label>
                                                </div>
                                            <?php endwhile; ?>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Description</label>
                                        <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                   
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>

                                   
                                    <button type="submit" name="add_room_form" class="btn text-secondary shadow-none" id="addRoomBtn">ADD</button>

                                </div>
                            </div>
                        </form>
                      </div>
            </div>


        </div>
    </div>
</div>

<?php require'script.php'; ?>
</body>
</html>