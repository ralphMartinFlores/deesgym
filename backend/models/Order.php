<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //Load Composer's autoloader
   require 'PHPMailer/vendor/autoload.php';

   class Order {

        public function __construct() {}

        public function manualOrdering($dt) {
            $date = date('m/d/Y');
            $purchaseOrder = $dt[0]->purchase_order;
            $grandTotal = $dt[0]->sup_delivery_fee + $dt[0]->total;
            // return array(
            //     $dt->user_email,
            //     $dt->rgn
            // );
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
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                            
                $mail->Port  = 465;             //Enable implicit TLS encryption
                                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('austinaranda27@gmail.com', 'Christian Alip');
                // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                $mail->addAddress('vchristianvictoria@gmail.com');                      //Name is optional
                $mail->addReplyTo('austinaranda27@gmail.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Your invoice from Cartridge Extra';
               
                $mail->Body = " <div style = '
                                    box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
                                    padding:2mm;
                                    margin: 0 auto;
                                    width: 120mm;
                                    background: #FFF;

                                    ::selection {background: #f31544; color: #FFF;}
                                    ::moz-selection {background: #f31544; color: #FFF;}'>
                                    
                                    <div style ='display: -webkit-box; display: -ms-flexbox; display: flex; gap: 1rem; margin-top: 2.5rem; width:100%'>
                                        <div style='width:50%'>
                                            <img src='https://www.linkpicture.com/q/coloredlogo_3.png'>
                                        </div
                                        <div style='width:50%;margin-left:2rem'>
                                            <p>
                                            Shop 2,55 Alexander Street, Crows Nest NSW	2065 <br>
                                            Telephone:02 8084 2567 <br>
                                            email: <a href='mailto:sales@cartridgeextra.com.au'>sales@cartridgeextra.com.au</a> <br>
                                            website: <a href='http://www.cartridgeextra.com.au/'>Cartridge Extra</a> 
                                            </p>
                                            <p style='font-weight:600'>ABN:66 144 527 104</p>
                                        </div>
                                        <div style='width:30%'>
                                            <h1 style='margin-bottom: -10rem'>PO-$purchaseOrder</h1>
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
                                                <p>".$dt[0]->sup_address."</p>
                                            </div>
                                            <div style='width: 20%;text-align:start'>
                                                <span style='font-weight:600'>Contact</span>
                                                <p>
                                                    ".$dt[0]->sup_name."  <br>
                                                    Tel: ".$dt[0]->sup_contactnum." <br>
                                                    ".$dt[0]->sup_contactnum."  (work)<br>
                                                    ".$dt[0]->sup_contactnum."  (mobile)<br>
                                                    <a href='mailto:".$dt[0]->sup_email."'>".$dt[0]->sup_email."</a>
                                                </p>
                                            </div>
                                            <div style='width: 20%; text-align:start'>
                                                <span style='font-weight:600'>Drop Ship To</span>
                                                <p>".$dt[0]->user_address."</p>
                                            </div>
                                            <div style='width: 20%;text-align:start'>
                                                <span style='font-weight:600'>Contact</span>
                                                <p>
                                                ".$dt[0]->user_fullname."<br>
                                                ".$dt[0]->user_address." <br>
                                                ".$dt[0]->user_contactnum." (mobile)<br>
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

                                                for ($i=0; $i < sizeof($dt) ; $i++) {
                                                    $mail->Body .= "<tr style='font-size: 0.9rem; border-bottom: 1px solid #EEE;'>
                                                        <td><p>".$dt[$i]->sup_code."</p></td>
                                                        <td><p>".$dt[$i]->brand_name." ".$dt[$i]->prod_name." ".$dt[$i]->prod_isTod." ".$dt[$i]->prod_model." ".$dt[$i]->prod_color."</p></td>
                                                        <td><p>$".$dt[$i]->prod_sell_price."</p></td>
                                                        <td><p>".$dt[$i]->cart_item_quantity."</p></td>
                                                        <td><p>$".$dt[$i]->cart_item_quantity * $dt[$i]->prod_sell_price."</p></td>
                                                    </tr>";
                                                }

                                $mail->Body .= "<div style='margin-top:2rem; line-height:0.7rem'>
                                                    <tr style='font-size: 1em;  background: #EEE;'>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><h3>Subtotal</h3></td>
                                                        <td><h2>$".$dt[0]->total."</h2></td>
                                                    </tr>
                                                   
                                                    <tr style='font-size: 1em;  background: #EEE;'>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class='Rate'><h2>Total</h2></td>
                                                        <td class='payment'><h2>$".$dt[0]->total."</h2></td>
                                                    </tr>
                                                </div>

                                            </table>
                                        </div>
                                    </div>
                                </div>";
                $mail->AltBody = '';

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