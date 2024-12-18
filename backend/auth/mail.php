<?php
require_once __DIR__ . '/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendConfirmationEmail($email, $fullname, $activation_token) {
    $mail = new PHPMailer(true);
    try {
        // Paramètres SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sae462387@gmail.com'; // Adresse e-mail
        $mail->Password = 'kjrv qhyp kxaf ykey'; // Mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Expéditeur et destinataire
        $mail->setFrom('siyadiarra@gmail.com', 'SAE502');
        $mail->addAddress($email, $fullname);

        // Contenu de l'email
        $activation_link = "http://localhost:8080/backend/auth/activate.php?token=" . urlencode($activation_token);
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de votre inscription';
        $mail->Body = "
            <p>Bonjour $fullname,</p>
            <p>Merci de vous être inscrit ! Cliquez sur le lien pour activer votre compte :</p>
            <p><a href='$activation_link'>$activation_link</a></p>
        ";

        // Envoi de l'email
        $mail->send();
        return true; // Succès
    } catch (Exception $e) {
        error_log("Erreur d'envoi d'e-mail : {$mail->ErrorInfo}"); // Loguer l'erreur
        return false; // Échec
    }
}
?>
