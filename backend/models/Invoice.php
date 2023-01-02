<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //Load Composer's autoloader
   require 'PHPMailer/vendor/autoload.php';

   class Invoice {

        public function __construct() {}

        public function sendInvoice($dt) {            
            $date = date('m/d/Y');
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'planthaven05@gmail.com';                     //SMTP username
                $mail->Password   = 'planthaven2021';                               //SMTP password
                $mail->SMTPSecure = 'tls';                           
                $mail->Port  = 587;            //Enable implicit TLS encryption
                                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('from@example.com', 'Mailer');
                // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                $mail->addAddress($dt[0]->supplier_mail);                      //Name is optional
                $mail->addReplyTo('binociete@gmail.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Cartridge Extra';
                $mail->Body    = "<div style = 'box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
                                    padding:2mm;
                                    margin: 0 auto;
                                    width: 120mm;
                                    background: #FFF;
                        
                                    ::selection {background: #f31544; color: #FFF;}
                                    ::moz-selection {background: #f31544; color: #FFF;}'>
                                    
                                    <div style ='display: -webkit-box; display: -ms-flexbox; display: flex; gap: 1rem; margin-top: 2.5rem; width:100%'>
                                        <div style='width:30%'>
                                            <img src='https://www.linkpicture.com/q/coloredlogo_3.png'>
                                        </div
                                        <div style='width:40%;margin-left:2rem'>
                                            <p>
                                            Shop 2,55 Alexander Street, Crows Nest NSW	2065 <br>
                                            Telephone:02 8084 2567 <br>
                                            email: <a href='mailto:sales@cartridgeextra.com.au'>sales@cartridgeextra.com.au</a> <br>
                                            website: <a href='http://www.cartridgeextra.com.au/'>Cartridge Extra</a> 
                                            </p>
                                            <p style='font-weight:600'>ABN:66 144 527 104</p>
                                        </div>
                                        <div style='width:30%'>
                                            <div>
                                            <p>
                                                Jaryie Wong<br>
                                                Created $date<br>
                                                Modified $date
                                            </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div style ='display: -webkit-box; display: -ms-flexbox; display: flex; gap: 1rem; margin-top: 2.5rem; width:100%'>
                                            <div style='width: 20%; text-align:start'>
                                                <span style='font-weight:600'>Cartridge Top</span>
                                                <p>
                                                ".$dt[0]->supplier_address."<br>
                                                ".$dt[0]->supplier_address2."<br>
                                                ".$dt[0]->supplier_address3."<br>
                                                </p>
                                            </div>
                                            <div style='width: 20%;text-align:start'>
                                                <span style='font-weight:600'>Contact</span>
                                                <p>
                                                    Christian Alip<br>
                                                    Tel: ".$dt[0]->supplier_phone."<br>
                                                    ".$dt[0]->supplier_work." (work)<br>
                                                    ".$dt[0]->supplier_home." (mobile)<br>
                                                    <a href='mailto:sales@cartridgeone.net.au'>sales@cartridgeone.net.au</a>
                                                </p>
                                            </div>
                                            <div style='width: 20%; text-align:start'>
                                                <span style='font-weight:600'>Drop Ship To</span>
                                                <p>
                                                ".$dt[0]->user_address1."<br>
                                                ".$dt[0]->user_address2."<br>
                                                ".$dt[0]->user_address3."<br>
                                                </p>
                                            </div>
                                            <div style='width: 20%;text-align:start'>
                                                <span style='font-weight:600'>Contact</span>
                                                <p>
                                                    ".$dt[0]->user_name." <br>
                                                    ".$dt[0]->user_phone." (mobile)<br>
                                                    ".$dt[0]->user_email."
                                                </p>
                                            </div>
                                            <div style='width: 20%; text-align:start'>
                                                <span style='font-weight:600'></span>
                                                <p style='margin-top: 2rem'>
                                                    AUD / COD <br>
                                                    Shipping: Australian Post
                                                </p>
                                            </div>   
                                    </div>
                                    <div style='border-bottom: 1px solid #EEE;  min-height: 50px;  margin-top: 3rem;'>
                                        <div>
                                            <table style='width: 100%; border-collapse: collapse;'>
                                                <tr style='font-size: 1em;  background: #EEE;'>
                                                    <td><h2>Supplier Code</h2></td>
                                                    <td><h2>Description</h2></td>
                                                    <td><h2>Cost</h2></td>
                                                    <td><h2>Qty</h2></td>
                                                    <td><h2>Total</h2></td>
                                                </tr>";

                                                foreach($dt as $value) {
                                                    $mail->Body .= 
                                                    "<tr style='font-size: 0.9rem; border-bottom: 1px solid #EEE;'>
                                                        <td><p>$value->supplier_code</p></td>
                                                        <td><p>$value->brand_name $value->prod_name $value->prod_isTod $value->prod_model $value->prod_color</p></td>
                                                        <td><p>$ $value->prod_sell_price</p></td>
                                                        <td><p>$value->cart_item_quantity</p></td>
                                                        <td><p>$ $value->prod_total</p></td>
                                                    </tr>";
                                                }  

                                            $mail->Body .= " <div style='margin-top:2rem; line-height:0.7rem'>
                                                        <tr style='font-size: 1em;  background: #EEE;'>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><h3>Subtotal</h3></td>
                                                            <td><h2>$ $value->order_total</h2></td>
                                                        </tr>
                                                        <tr style='font-size: 1em;  background: #EEE;'>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class='Rate'><h2>Total</h2></td>
                                                            <td class='payment'><h2>$ $value->order_grand_total </h2></td>
                                                        </tr>
                                                    </div> 
                                            </table>
                                        </div>
                                    </div>
                                </div>";
                $mail->AltBody = "";

                if($mail->send()) {
                    return array(
                        "code" => 200
                    );
                }
            } catch (Exception $e) {
                return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        public function sendInvoiceCustomer($data) {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'planthaven05@gmail.com';                     //SMTP username
                $mail->Password   = 'planthaven2021';                               //SMTP password
                $mail->SMTPSecure = 'tls';                           
                $mail->Port  = 587;            //Enable implicit TLS encryption
                                            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('from@example.com', 'Mailer');
                // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                
                for($i = 0; $i < sizeof($data->emails); $i++) {
                    $mail->addAddress($data->emails[$i]);  //Name is optional
                }                    
                $mail->addReplyTo('binociete@gmail.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                // $mail->addAttachment($data->invoice);         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                $mail->AddStringAttachment(base64_decode($data->invoice), 'invoice.pdf', 'base64', 'application/pdf');
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Your invoice from Cartridge Extra';
                $body = '<iframe src="'. $data->invoice .'"</iframe>';
                $mail->Body    = "$body";
                $mail->AltBody = "asdasdasdasdasd";

                if($mail->send()) {
                    return array(
                        "code" => 200
                    );
                }
            } catch (Exception $e) {
                return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
   }
?>