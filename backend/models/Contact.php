<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //Load Composer's autoloader
    require 'PHPMailer/vendor/autoload.php';

    function sendEmail($dt) {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        // http_response_code(200);
        // return array("status"=>"success", "message"=>"Successfully sent email", "remarks"=>"success");

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                      //Enable SMTP authentication
            $mail->Username   = 'planthaven05@gmail.com';                     //SMTP username
            $mail->Password   = 'planthaven2021';                                 //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
            //Recipients
            $mail->setFrom($dt->email, $dt->name);
            // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
            $mail->addAddress('vchristianvictoria@gmail.com', 'Cartridge Extra');               //Name is optional
            $mail->addReplyTo($dt->email, 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
    
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Cartridge Extra Contact Form';
            $mail->Body    = "You have received a new message from Cartridge Extra Website contact form.\n\nHere is the Details: \n\nName: $dt->name \nEmail: $dt->email \nPhone: $dt->phone \nMessage: $dt->message";
            $mail->AltBody = 'This email is from Cartridge Extra Website contact form.';
    
            if($mail->send()) {
                http_response_code(200);
                return array("code"=>200, "status"=>"success", "message"=>"Successfully sent email", "remarks"=>"success");
            }
        } catch (Exception $e) {
            http_response_code(404);
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";+http_response_code(200);
            return array("code"=>200, "status"=>"failed", "message"=>"Failed to send email", "remarks"=>"failed");
        }
    }
    
?>