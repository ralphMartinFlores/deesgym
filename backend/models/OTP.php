<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //Load Composer's autoloader
   require 'PHPMailer/vendor/autoload.php';

   class Otp {

        public function __construct() {}

        public function sendOtp($dt) {
            // return array(
            //     $dt->user_email,
            //     $dt->rgn
            // );
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'vchristianvictoria@gmail.com';                     //SMTP username
                $mail->Password   = '';                                 //SMTP password
                $mail->SMTPSecure = 'tls';                           
                $mail->Port  = 587;                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('vchristianvictoria@gmail.com', 'Christian Alip');
                // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                $mail->addAddress($dt->user_email);               //Name is optional
                $mail->addReplyTo('vchristianvictoria@gmail.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Email Verification';
                $mail->Body    = "<p>OTP CODE $dt->rgn</p>";
                $mail->AltBody = 'This email is request for email verification.';

                if($mail->send()) {
                    return array(
                        "response code" => 200
                    );
                }
            } catch (Exception $e) {
                return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
   }
?>