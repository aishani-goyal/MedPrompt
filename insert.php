<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

/*require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php'; */

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get SMTP credentials securely from .env
$smtpUser = $_ENV['SMTP_USERNAME'];
$smtpPass = $_ENV['SMTP_PASSWORD'];

$dbHost = $_ENV['DB_HOST'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];
$dbName = $_ENV['DB_NAME'];


$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName) or die("Connection failed");


$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$doctor = $_POST['doctor'];
$service = $_POST['service'];


$sql = "INSERT INTO form (id, name, email, phone, date, doctor, service) 
        VALUES (NULL, '$name', '$email', '$phone', '$date', '$doctor', '$service')";

$qry = mysqli_query($conn, $sql);


if ($qry) {

   
    $mail = new PHPMailer(true);

    try {
       
                             
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                      
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = $smtpUser;              
        $mail->Password   = $smtpPass;                     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
        $mail->Port       = 587;                                    

       
        $mail->setFrom($smtpUser, 'MedPrompt');
        $mail->addAddress($email, $name);                           
        $mail->addReplyTo($smtpUser, 'MedPrompt');

       
        $mail->isHTML(true);                                       
        $mail->Subject = 'Form Submission Confirmation';
        $mail->Body    = "Dear $name,<br><br>Thank you for submitting the form. Your appointment has been scheduled successfully with Dr. $doctor on $date for $service.<br><br>Regards,<br>MedPrompt 24x7 Team";
        $mail->AltBody = "Dear $name,\n\nThank you for submitting the form. Your appointment has been scheduled successfully with Dr. $doctor on $date for $service.\n\nRegards,\nMedPrompt 24x7 Team";

        $mail->send();
        echo "Appointment booked successfully! Confirmation email sent.";
    } catch (Exception $e) {
        echo "\n\nFailed to send email to $email. Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Error: " . mysqli_error($conn);
}


mysqli_close($conn);
?>