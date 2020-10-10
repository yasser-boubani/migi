<?php

// include PHPMailer Library
require _LIBRARIES_ . "PHPMailer" . DS . "PHPMailerAutoload.php";

define("MAIL_HOST", ""); // smtp.gmail.com
define("MAIL_PORT", 587); // 587
define("MAIL_ENCRYPTION", "tls"); // tls
define("MAIL_SMTP_AUTH", TRUE); // true

// Default Sender
define("MAIL_NAME", "");
define("MAIL_USERNAME", "");
define("MAIL_PASSWORD", "");
