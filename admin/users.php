<?php
// Include essential files and database configurations
require('essentials.php');
require('db_config.php');
include '../connection.php';

// Ensure admin is logged in
adminLogin();

// Add User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];
    $date_of_birth = $_POST['date_of_birth'];
    $profile_pic = $_POST['profile_pic'];
    

    // Insert user query
    $stmt = $conn->prepare("INSERT INTO user (name, email, phone_no, address, date_of_birth, profile_pic,) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssss", $name, $email, $phone_no, $address, $date_of_birth, $profile_pic);
        $stmt->execute();
        $stmt->close();
        header('Location: users.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Delete User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $id = $_POST['user_id'];

    // Delete user query
    $stmt = $conn->prepare("DELETE FROM user WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header('Location: users.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Edit User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];
    $dob = $_POST['date_of_birth'];
    $profile_pic = $_POST['profile_pic'];
   

    // Update user query
    $stmt = $conn->prepare("UPDATE user SET name=?, email=?, phone_no=?, address=?, date_of_birth=?, profile_pic=? WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("ssssssi", $name, $email, $phone_no, $address, $date_of_birth, $profile_pic, $id);
        $stmt->execute();
        $stmt->close();
        header('Location: users.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all users
$users = $conn->query("SELECT * FROM user");

if (!$users) {
    die("Error fetching users: " . $conn->error);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Users</title>
    <?php require('links.php') ?>
</head>
<body class="bg-light">

<?php require('header.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">USERS</h3>

            <!-- Add User Button -->
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>

            <!-- User List Table -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover border text-center" style="min-width: 1300px">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone no.</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">DOB</th>
                                    <th scope="col">Profile Pic</th>
                              
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user = mysqli_fetch_assoc($users)): ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= $user['name'] ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td><?= $user['phone_no'] ?></td>
                                        <td><?= $user['address'] ?></td>
                                        <td><?= $user['date_of_birth'] ?></td>
                                        <td><?= $user['profile_pic'] ?></td>
                                        
                                        <td>
                                            <!-- Edit Button -->
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit-user-<?= $user['id'] ?>">Edit</button>

                                            <!-- Delete Form -->
                                            <form method="POST" style="display:inline-block;">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <button type="submit" name="delete_user" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit User Modal -->
                                    <div class="modal fade" id="edit-user-<?= $user['id'] ?>" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" class="form-control" name="name" value="<?= $user['name'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="phone_no" class="form-label">Phone</label>
                                                            <input type="text" class="form-control" name="phone_no" value="<?= $user['phone_no'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Address</label>
                                                            <input type="text" class="form-control" name="address" value="<?= $user['address'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="date_of_birth" class="form-label">DOB</label>
                                                            <input type="date" class="form-control" name="date_of_birth" value="<?= $user['date_of_birth'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                           <label class="form-label fw-bold">Profile Pic</label>
                                                           <input type="file" name="profile_pic" class="form-control shadow-none" accept="image/*" required>
                                                         </div>
                                                         <div class="mb-3">
                                                          <label for="role" class="form-label">Role</label>
                                                          <select class="form-control" name="role" required>
                                                         <option value="user">User</option>
                                                         <option value="admin">Admin</option>
                                                          </select>
                                                           </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="edit_user" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add User Modal -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone_no" class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone_no" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">DOB</label>
                                    <input type="date" class="form-control" name="date_of_birth" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">profile Pic</label>
                                    <input type="file" name="profile_pic" class="form-control shadow-none" accept="image/*" required>
                                        </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-control" name="role" required>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require('script.php'); ?>

</body>
</html>
