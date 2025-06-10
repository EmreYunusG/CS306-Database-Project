<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CS306 – Main Entry</title>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2c3e50;
            text-align: center;
            padding-top: 80px;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .menu {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 40px;
        }

        .menu a {
            display: inline-block;
            padding: 20px 30px;
            background-color: #3498db;
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: #2ecc71;
        }

        .footer {
            margin-top: 100px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>

    <h1>🛠️ CS306 Web-Integrated Database Project</h1>
    <p>Please select a user type:</p>

    <div class="menu">
        <a href="admin/index.php">🔑 Admin Panel</a>
        <a href="user/index.php">👤 User Panel</a>
    </div>

    <div class="footer">
        © <?php echo date("Y"); ?> Sabancı University – CS306 Final Project
    </div>

</body>
</html>
