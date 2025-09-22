<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php");
    exit();
}

$alert = FALSE;
$alertContent = '';

require '../db.php';

$CoachingId = isset($_COOKIE['CoachingId']) ? $_COOKIE['CoachingId'] : '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $userid = $_POST['userid'];

    // Check if the user ID already exists in the database
    $check_stmt = $conn->prepare("SELECT userid FROM students WHERE userid = ?");
    $check_stmt->bind_param("s", $userid);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // User ID already exists, display error message
        $alert = TRUE;
        $strong = "User ID Already Exists!";
        $message = "Please Choose A Different One...";
        // Constructing the success alert content
        $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
        $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $alertContent .= '</div>';
        echo $alertContent;
        // After 4 seconds, redirect to admin panel
        echo "<script>setTimeout(function() { window.location.href = '../admin/addStudent.php'; }, 2000);</script>";

    } else {
        // User ID does not exist, proceed with inserting the new record
        $fullname = $_POST['full_name'];
        $class = $_POST['class'];
        $fathername = $_POST['father_name'];
        $mothername = $_POST['mother_name'];
        $school = $_POST['school'];
        $subjects = $_POST['subjects'];
        $subject = implode(", ", $subjects);  // Convert array to string
        $aadharNumber = $_POST['aadhar_number'];
        $phonenumber = $_POST['phone_number'];
        $alternatenumber = $_POST['alternate_number'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $bloodGroup = $_POST['blood_group'];
        $allergy = $_POST['allergy'];
        $userid = $_POST['userid'];
        $password = $_POST['password'];
        $CoachingId = $_POST['CoachingId'];
        $created_by = $_SESSION['admin_username'];

        $insert_stmt = $conn->prepare("INSERT INTO `students` (`full_name`, `class`, `father_name`, `mother_name`, `school`, `subject`, `aadhar_number`, `phone_number`, `alternate_number`, `address`, `state`, `city`, `blood_group`, `allergy`, `userid`, `password`, `CoachingId`, `created_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("ssssssssssssssssss", $fullname, $class, $fathername, $mothername, $school, $subject, $aadharNumber, $phonenumber, $alternatenumber, $address, $state, $city, $bloodGroup, $allergy, $userid, $password, $CoachingId, $created_by);

        if ($insert_stmt->execute()) {
            $alert = TRUE;
            $strong = "Added Successfully!";
            $message = "Refreshing The Page...";
            // Constructing the success alert content
            $alertContent = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $alertContent .= '<strong>' . $strong . '</strong> ' . $message;
            $alertContent .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $alertContent .= '</div>';
            echo $alertContent;
            // After 4 seconds, redirect to admin panel
            echo "<script>setTimeout(function() { window.location.href = '../admin/addStudent.php'; }, 2000);</script>";

        } else {
            echo "Something Went Wrong " . $conn->error . mysqli_error();
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
       canvas {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none; /* Prevent canvas from intercepting mouse events */
        }
    </style>
</head>
<body>

<?php require 'navbar.php'; ?>
<canvas id="canvas" style="position: absolute; top: 0; left: 0; pointer-events: none;"></canvas>

<div class="container my-5">
    <h2>Add Student</h2>
    <form action="addStudent.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="full_name" required>
        </div>
        <div class="mb-3">
            <label for="class" class="form-label">Class</label>
            <select class="form-select" id="class" name="class" required>
                <option value="">Select Class</option>
                <option value="Class 1">Class 1</option>
                <option value="Class 2">Class 2</option>
                <option value="Class 3">Class 3</option>
                <option value="Class 4">Class 4</option>
                <option value="Class 5">Class 5</option>
                <option value="Class 6">Class 6</option>
                <option value="Class 7">Class 7</option>
                <option value="Class 8">Class 8</option>
                <option value="Class 9">Class 9</option>
                <option value="Class 10">Class 10</option>
                <option value="Class 11">Class 11</option>
                <option value="Class 12">Class 12</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fathername" class="form-label">Father Name</label>
            <input type="text" class="form-control" id="fathername" name="father_name" required>
        </div>
        <div class="mb-3">
            <label for="mothername" class="form-label">Mother Name</label>
            <input type="text" class="form-control" id="mothername" name="mother_name" required>
        </div>
        <div class="mb-3">
            <label for="subjects" class="form-label">Subjects</label>
            <select id="subjects" name="subjects[]" class="form-select" multiple="multiple" required>
                <option value="Maths">Maths</option>
                <option value="Science">Science</option>
                <option value="English">English</option>
                <option value="Computer">Computer</option>
                <option value="SST">SST</option>
                <option value="English Spoken">English Spoken</option>
                <option value="Physics">Physics</option>
                <option value="Chemistry">Chemistry</option>
                <option value="Biology">Biology</option>
                <!-- Add more subjects as needed -->
            </select>
        </div>
        <div class="mb-3">
            <label for="phonenumber" class="form-label">PhoneNumber</label>
            <input type="number" class="form-control" id="phonenumber" name="phone_number" required>
        </div>
        <div class="mb-3">
            <label for="alternatenumber" class="form-label">Alternate Phone Number</label>
            <input type="number" class="form-control" id="alternatenumber" name="alternate_number">
        </div>
        <div class="mb-3">
            <label for="aadharnumber" class="form-label">Aadhar Number</label>
            <input type="text" class="form-control" id="aadharnumber" name="aadhar_number" required>
        </div>
        <div class="mb-3">
            <label for="school" class="form-label">School</label>
            <input type="text" class="form-control" id="school" name="school" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" required>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <div class="mb-3">
            <label for="bloodgroup" class="form-label">Blood Group</label>
            <input type="text" class="form-control" id="bloodgroup" name="blood_group">
        </div>
        <div class="mb-3">
            <label for="allergy" class="form-label">Allergy (if any)</label>
            <input type="text" class="form-control" id="allergy" name="allergy">
        </div>
        <div class="mb-3">
            <label for="userid" class="form-label">User ID</label>
            <input type="text" class="form-control" id="userid" name="userid" required>
        </div>
        <input type="hidden" class="form-control" id="CoachingId" name="CoachingId" value="<?php echo $CoachingId; ?>" readonly required>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Student</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#subjects').select2({
            placeholder: "Select Subjects",
            allowClear: true
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGz1U1GSOzUz8GPCp28vF2N8e5rC5JiR50yK2hkd7uUR6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12WmPpYP5TQbW8b8Pv5lF6LGFPz5a9EFVF5yTajp6E8Z8R1p" crossorigin="anonymous"></script>
<script src="particles.js"></script>
<script>
    particlesJS("particles-js", {
        "particles": {
            "number": {
                "value": 80,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#ffffff"
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                },
                "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                }
            },
            "opacity": {
                "value": 0.5,
                "random": false,
                "anim": {
                    "enable": false,
                    "speed": 1,
                    "opacity_min": 0.1,
                    "sync": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 40,
                    "size_min": 0.1,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 6,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 1200
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "repulse"
                },
                "onclick": {
                    "enable": true,
                    "mode": "push"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 400,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 400,
                    "size": 40,
                    "duration": 2,
                    "opacity": 8,
                    "speed": 3
                },
                "repulse": {
                    "distance": 200,
                    "duration": 0.4
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true
    });
</script>
</body>
</html>
