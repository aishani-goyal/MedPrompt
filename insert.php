<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


$conn = mysqli_connect("localhost", "id22268516_doctor_admin", "Docadmin@2024", "id22268516_doctor_info") or die("Connection failed");


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
        $mail->Username   = 'medprompt24x7@gmail.com';              
        $mail->Password   = 'xsznbnsenkcictgu';                     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
        $mail->Port       = 587;                                    

       
        $mail->setFrom('medprompt24x7@gmail.com', 'MedPrompt');
        $mail->addAddress($email, $name);                           
        $mail->addReplyTo('medprompt24x7@gmail.com', 'MedPrompt');

       
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