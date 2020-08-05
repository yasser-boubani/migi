<?php
header("HTTP/1.1 200 Fix Mode");
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
            font-size: 2em;
            padding: 0;
            margin: 0;
        }

        .container {
            width: 100vw;
            height: 100vh;            
        }

        .note {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="note">The site is undergoing maintenance, we'll back soon.</div>
    </div>
</body>
</html>
