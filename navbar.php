    <style>
        .navbar {
            background-color: #111;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: #00ff00;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s;
        }
        .navbar a:hover {
            background-color: #00ff00;
            color: #111;
        }
        .navbar a.active {
            background-color: #00ff00;
            color: #111;
        }
        @media screen and (max-width: 600px) {
            .navbar a {
                float: none;
                display: block;
                text-align: left;
            }
        }
    </style>
<div class="navbar">
    <a href="access.php" class="active">Home</a>
    <a href="coursebuyer.php">Course Buyers</a>
    <a href="logout.php">Logout</a>
</div>

