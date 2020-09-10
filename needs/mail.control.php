<?php

// include PHPMailer Library
require _LIBRARIES_ . "PHPMailer" . DS . "PHPMailerAutoload.php";

define("MAIL_HOST", "smtp"); // smtp.gmail.com
define("MAIL_PORT", 587); // 587
define("MAIL_SMTP_SECURE", "tls"); // tls
define("MAIL_SMTP_AUTH", TRUE); // true

// Default Sender
define("SENDER_NAME", "Sender name");
define("SENDER_EMAIL", "sender email");
define("SENDER_PASSWORD", "sender pass");
