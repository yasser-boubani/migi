<?php
header("HTTP/1.0 419 unknown status");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Expired</title>
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
        <div class="note"><b>419</b> | Page Expired</div>
    </div>
</body>
</html>
