<?php
require 'db.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['name'];
    $phone = $_POST['phone_number'];
    $aadhar = $_POST['aadhar_number'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $role = $_POST['role'];
    $id = $_POST['teacher_id'];
    $password = $_POST['password'];

    // Create a prepared statement
    $stmt = $conn->prepare("INSERT INTO teachers (name, phone_number, aadhar_number, email, class, role, teacher_id, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisss", $name, $phone, $aadhar, $email, $class, $role, $id, $password);

    // Execute the statement
    if($stmt->execute()) {
        echo 'Inserted Successfully';
        echo '<script>window.location.reload()</script>'; // Reload the page after successful insertion
    } else {
        echo 'Error inserting record: ' . $conn->error;
    }

    // Close statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    require 'navbar.php';
    ?>

    <main>
    <div class="container">
        <h2>Teacher Login</h2>
        <form action="signup.php" method="post">
            <div class="form-group">
                <label for="name">Teacher Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Teacher Phone Number</label>
                <input type="tel" id="phone" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="aadhar">Teacher Aadhar Number</label>
                <input type="text" id="aadhar" name="aadhar_number" required>
            </div>
            <div class="form-group">
                <label for="email">Teacher Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="class">Teacher Class</label>
                <select id="class" name="class" required>
                    <option value="">Select Class</option>
                    <option value="1">Class 1</option>
                    <option value="2">Class 2</option>
                    <option value="3">Class 3</option>
                    <option value="4">Class 4</option>
                    <option value="5">Class 5</option>
                    <option value="6">Class 6</option>
                    <option value="7">Class 7</option>
                    <option value="8">Class 8</option>
                    <option value="9">Class 9</option>
                    <option value="10">Class 10</option>
                </select>
            </div>
            <div class="form-group">
                <label for="role">Teacher Role</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="teacher">Teacher</option>
                    <option value="principal">Principal</option>
                    <option value="vice_principal">Vice Principal</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="id">Teacher ID</label>
                <input type="text" id="id" name="teacher_id" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    </main>
</body>
</html>