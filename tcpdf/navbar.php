    <style>
        body {
            background-color: #000;
            color: #0f0;
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #111;
            padding: 15px 20px;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: #0f0;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
            background-color: #0f0;
            color: #000;
        }

        .navbar .brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .warning {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: #f00;
            font-size: 1.2rem;
            font-style: italic;
        }

        .warning:before {
            content: "WARNING: Unauthorized access detected!";
            animation: flicker 1s infinite alternate;
        }

        @keyframes flicker {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0.5;
            }
        }
    </style>
    <div class="navbar">
        <a href="#" class="brand">Hacker Zone</a>
        <a href="list.php">Main Page</a>
        <a href="hackedstudent.php">Student Data</a>
        <a href="hackedteacher.php">Teacher Data</a>
        <a href="viewadmin.php">Admin Data</a>
    </div>
    <div class="warning"></div>
