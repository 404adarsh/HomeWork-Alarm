<style>

.portal-dropdown {
    position: relative;
}

.portal-dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.portal-dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.portal-dropdown-content a:hover {
    background-color: #ddd;
}

.portal-dropdown:hover .portal-dropdown-content {
    display: block;
}

</style>
<link rel="stylesheet" href="css/Style.css">
<nav class="top-navbar">
    <ul class="top-list">
        <li><span class="icon"><i class="bi bi-geo-alt-fill"></i></span>Build Your Coaching</li>
    </ul>
    <ul class="top-right-list d-flex">
        <li><span><i class="bi bi-instagram"></i></span></li>
        <li><span><i class="bi bi-facebook"></i></span></li>
        <li><span><i class="bi bi-twitter"></i></span></li>
    </ul>
</nav>
<nav class="navbar">
    <div class="left-nav-list">
        <h1 class="logo">Ideal Builder</h1>
    </div>
    <ul class="nav-list v-class-resp">
        <li><a href="index.php">Home</a></li>
        <li class="portal-dropdown">
            <a href="#">Portal</a>
            <div class="portal-dropdown-content">
                <a href="student-login.php">Student Login</a>
                <a href="teacher-login.php">Teacher Login</a>
                <a href="admin-login.php">Admin Login</a>
            </div>
        </li>
        <li><a href="enroll.php" hidden>Enroll Now</a></li>
    </ul>
    <div class="burger" onclick="burgerClass()">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
</nav>
