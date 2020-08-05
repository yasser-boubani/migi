<?php
header("HTTP/1.1 501 Not Implemented");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Maintenance</title>
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            color: #B0BEC5;
            font-family: Tahoma;
            padding: 0;
            margin: 0;
        }

        .container {
            width: 100vw;
            height: 100vh;            
        }

        .note {
            font-size: 2em;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
        }

        .error {
            width: 90%;
            background: #333;
            color: #fff;
            border-radius: 8px;
            padding: 10px;
            position: fixed;
            left: 10px;
            bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="note">Failed to connect to database</div>
    </div>
    <div class="error"><?= $error ?></div>
</body>
</html>
