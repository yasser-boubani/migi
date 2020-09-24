<?php

namespace Workers;

class Mailer
{
    protected $receiver_name;
    protected $receiver_email;
    protected $subject;
    protected $message;
    protected $attachments;

    protected $type;

    protected $sender_name;
    protected $sender_email;
    protected $sender_password;

    /*
    $to : Receiver email address
    $subject : subject
    $message : message

    $options : must be an array like this:
        [
            "type" => "text", // "text" as default or "html"
            "sender_name" => "Sender Name", // 
            "sender_email" => "Sender Email",
            "sender_password" => "Sender Password",
        ]
    */
    public function
    __construct(String $receiver_name,
                String $receiver_email,
                String $subject,
                $message,
                Array $attachments = [],
                Array $options = []
    ) {
        if (!USE_MAILER) {
            exit("Error: When you need to use Mailer, you have to set the constant USE_MAILER to TRUE first.");
        }

        $this->receiver_name = $receiver_name;
        $this->receiver_email = $receiver_email;
        $this->subject = $subject;
        $this->message = $message;
        $this->attachments = $attachments;

        $this->type = (isset($options["type"])) ? $options["type"] : "text";
        $this->sender_name = (isset($options["sender_name"])) ? $options["sender_name"] : SENDER_NAME;
        $this->sender_email = (isset($options["sender_email"])) ? $options["sender_email"] : SENDER_EMAIL;
        $this->sender_password = (isset($options["sender_password"])) ? $options["sender_password"] : SENDER_PASSWORD;
    }

    public function send() {

        $mail = new \PHPMailer;
        $mail->isSMTP();

        /*
        * Server Configuration
        */

        $mail->Host = MAIL_HOST; // Which SMTP server to use.
        $mail->Port = MAIL_PORT; // Which port to use, 587 is the default port for TLS security.
        $mail->SMTPSecure = MAIL_SMTP_SECURE; // Which security method to use. TLS is most secure.
        $mail->SMTPAuth = MAIL_SMTP_AUTH; // Whether you need to login. This is almost always required.
        $mail->Username = $this->sender_email; // Your Gmail address.
        $mail->Password = $this->sender_password; // Your Gmail login password or App Specific Password.

        /*
        * Message Configuration
        */

        $mail->setFrom($mail->Username, $this->sender_name); // Set the sender of the message.
        $mail->addAddress($this->receiver_email, $this->receiver_name); // Set the recipient of the message.
        $mail->Subject = $this->subject; // The subject of the message.

        /*
        * Message Content - Choose simple text or HTML email
        */
        
        // Choose to send either a simple text email...
        if ($this->type == "html") {
            $mail->msgHTML($this->message);
        } else {
            $mail->Body = $this->message;
        }

        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $mail->addAttachment($attachment);
            }
        }

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}
