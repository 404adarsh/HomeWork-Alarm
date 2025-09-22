<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../Portal.php");
    exit();
}

require '../db.php';

if (!isset($_GET['id'])) {
    header("Location: view_teachers.php");
    exit();
}

$teacher_id = $_GET['id'];

$sql = "SELECT * FROM teachers WHERE id = $teacher_id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: viewTeacher.php");
    exit();
}

$teacher = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $aadhar_number = $_POST['aadhar_number'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $role = $_POST['role'];
    $teacher_id = $_POST['teacher_id'];

    $update_query = "UPDATE teachers SET name=?, phone_number=?, aadhar_number=?, email=?, class=?, role=?, teacher_id=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sssssssi", $name, $phone_number, $aadhar_number, $email, $class, $role, $teacher_id, $teacher_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: viewTeacher.php?success=1");
        exit();
    } else {
        $error_message = "Failed to update teacher details: " . mysqli_error($conn);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'navbar.php'; ?>
<main>
    <div class="container admin-container">
        <h1 class="text-strong">Edit Teacher</h1>
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $teacher['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $teacher['phone_number']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="aadhar_number" class="form-label">Aadhar Number</label>
                        <input type="text" class="form-control" id="aadhar_number" name="aadhar_number" value="<?php echo $teacher['aadhar_number']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $teacher['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <input type="text" class="form-control" id="class" name="class" value="<?php echo $teacher['class']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="teacher" <?php if($teacher['role'] == 'teacher') echo 'selected'; ?>>Teacher</option>
                            <option value="owner" <?php if($teacher['role'] == 'owner') echo 'selected'; ?>>Owner</option>
                            <option value="principal" <?php if($teacher['role'] == 'principal') echo 'selected'; ?>>Principal</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Teacher ID</label>
                        <input type="text" class="form-control" id="teacher_id" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Teacher</button>
                    <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
