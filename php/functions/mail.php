<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function testMail($data){
    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    $mail_body = '';
    $mail_body .= '<b>Good day, '.$data->first_name.'!</b><br><br>';
    $mail_body .= 'This is to confirm that you have successfully created an account. Kindly click <a href="'.$data->reset_password_link.'">HERE</a> to login into your account.<br><br>';
    $mail_body .= 'Have a great day.<br><br>';
    $mail_body .= 'From the DIY team';

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'glennjosephdl@gmail.com';                     //SMTP username
        $mail->Password   = 'kxxolggtktdpeqsv';                               //SMTP password
        $mail->SMTPSecure = 'ssl';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('glennjosephdl@gmail.com', 'Mailer');
        $mail->addAddress($data->email, $data->first_name .' '. $data->last_name);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('glennjosephdl@gmail.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Sample DIY';
        $mail->Body    = $mail_body;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->CharSet = 'UTF-8';

        $mail->send();
        return ["status"=>true,"response"=>"Message has been sent","request"=>__FUNCTION__];
    } catch (Exception $e) {
        return ["status"=>false,"response"=>"Message could not be sent. Mailer Error: {$mail->ErrorInfo}","request"=>__FUNCTION__];
    }
}

?>