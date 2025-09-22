    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="http://localhost/ACC/admin/index.php">Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="http://localhost/ACC/admin/index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Add
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="addStudent.php">Add Student</a></li>
            <li><a class="dropdown-item" href="addTeacher.php">Add Teacher</a></li>
            <li><a class="dropdown-item" href="addOwner.php">Add Owner</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            View
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="viewStudent.php">View Student</a></li>
            <li><a class="dropdown-item" href="viewTeacher.php">View Teacher</a></li>
            <li><a class="dropdown-item" href="#">View Owner</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Manage
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Manage Attendence</a></li>
            <li><a class="dropdown-item" href="#">Manage Fee</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Notification
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="enrollment.php">Enrollment</a></li>
            <li><a class="dropdown-item" href="getContact.php">Contact</a></li>
            <li><a class="dropdown-item" href="#">Student</a></li>
            <li><a class="dropdown-item" href="#">Teacher</a></li>
            </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="logout.php" role="button" aria-expanded="false">
            Logout
          </a></li>
        </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>