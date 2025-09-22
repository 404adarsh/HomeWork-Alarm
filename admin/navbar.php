<style>
  .v-class-resp{
    display: none;
  }
  /* Navbar styles */
  .navbar {
  background-color: #333;
  color: #fff;
  padding: 10px 20px;
  font-family: Arial, sans-serif;
  display: flex;
  justify-content: space-between;
  align-items: center; /* Align items vertically */
  position: relative; /* Ensure navbar stays on top of other elements */
  z-index: 1000; /* Set a high z-index to ensure navbar appears above other elements */
}

  .navbar-brand {
    font-size: 24px;
    text-decoration: none;
    color: #fff;
  }

  .navbar-nav {
    flex-direction: unset;
    display: flex;
    align-items: center;
    text-align: center;
    justify-content: center;
    list-style-type: none;
    margin: 0;
    padding: 0;
  }

  .nav-item {
    margin-left: 20px;
  }

  .nav-link {
    text-decoration: none;
    color: #fff;
    font-size: 18px;
  }

  .nav-link:hover {
    text-decoration: underline;
  }

  .dropdown {
    position: relative;
  }

  .dropdown-menu {
    display: none;
    position: absolute;
    background-color: #333;
    padding: 10px;
    top: 100%;
    left: 0;
    z-index: 1;
  }

  .dropdown:hover .dropdown-menu {
    display: block;
  }

  .dropdown-item {
    display: block;
    margin-top: 5px;
    color: #fff;
    text-decoration: none;
    font-size: 16px;
  }

  .dropdown-item:hover {
    text-decoration: underline;
  }

  /* Search form styles */
  .search-form {
    display: flex;
    align-items: center;
  }

  .search-input {
    border: 1px solid #fff;
    border-radius: 5px;
    padding: 5px;
  }

  .search-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    margin-left: 10px;
    cursor: pointer;
  }

  .search-button:hover {
    background-color: #0056b3;
  }
  @media (max-width: 768px) {
    .v-class-resp{
      display: block;
    }
  .navbar-nav {
    display: none;
    flex-direction: column;
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: #333;
  }

  .navbar-nav.show {
    display: flex;
  }

  .nav-item {
    margin: 10px 0;
  }

  .navbar-toggle {
    display: block;
  }
  
}
@media (max-width: 768px) {
  .navbar-nav {
    display: none;
    flex-direction: column;
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: #333;
  }

  .navbar-nav.show {
    display: flex;
  }

  .nav-item {
    margin: 10px 0;
  }

  .navbar-toggle {
    display: block;
  }
}


</style>

<nav class="navbar">
  <a class="navbar-brand" href="index.php">Admin</a>
  <button class="navbar-toggle v-class-resp">&#9776;</button>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="../admin/index.php">Home</a>
    </li>
    <li class="nav-item dropdown">
      <span class="nav-link">Add</span>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="addStudent.php">Add Student</a></li>
        <li><a class="dropdown-item" href="addTeacher.php">Add Teacher</a></li>
        <li><a class="dropdown-item" href="attendence.php">Add Attendance</a></li>
        <li><a class="dropdown-item" href="addpayments.php">Add Payments</a></li>
      </ul>
    </li>
    <li class="nav-item dropdown">
      <span class="nav-link">View</span>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="viewStudent.php">View Student</a></li>
        <li><a class="dropdown-item" href="viewTeacher.php">View Teacher</a></li>
        <li><a class="dropdown-item" href="viewattendece.php">View Attendance</a></li>
        <li><a class="dropdown-item" href="viewpayments.php">View Payments</a></li>
      </ul>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="chat.php">Chat</a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="logout.php">Logout</a>
    </li>
  </ul>
</nav>

<script>
  // Toggle the visibility of navbar links on small screens
  const navbarToggle = document.querySelector('.navbar-toggle');
  const navbarNav = document.querySelector('.navbar-nav');

  navbarToggle.addEventListener('click', () => {
    navbarNav.classList.toggle('show');
  });
</script>