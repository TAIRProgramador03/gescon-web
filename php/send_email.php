<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Asegúrate de haber cargado el autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $usuario = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['pass']; // Usar encriptación o validación para contraseñas

    // Crear la instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP(); // Usar SMTP
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true; // Habilitar autenticación SMTP
        $mail->Username = 'asis.ti.tair@gmail.com'; // Tu dirección de correo
        $mail->Password = 'nevu xzgq lnem pvwi'; // Tu contraseña de correo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usar STARTTLS
        $mail->Port = 587; // Puerto SMTP

        // Destinatarios
        $mail->setFrom('programador@tair.pe', $usuario); // Dirección del remitente
        $mail->addAddress('programador@tair.pe', $usuario); // Dirección del destinatario

        // Contenido del correo
        $mail->isHTML(true); // Enviar como HTML
        $mail->Subject = 'Solicitud de Recuperacion de Password';
        $mail->Body    = "
        <p>Estimado equipo de soporte,</p>
        <p>Me encuentro con dificultades para acceder a mi cuenta debido a que he olvidado mi password.</p>
        <p>Los detalles de mi cuenta son los siguientes:</p>
        <ul>
            <li>Usuario: <strong>$usuario</strong></li>
        </ul>
        <p>Agradeceria mucho su asistencia para restablecer mi password o indicarme los pasos necesarios para hacerlo.</p>
        <p>Quedo atento a su respuesta. Muchas gracias por su tiempo y apoyo.</p>
        <p>Saludos.</p>
        ";
        $mail->AltBody = "Estimado equipo de soporte, he olvidado mi password. Mi usuario es $usuario. Agradecería su asistencia para restablecerla."; 

        // Enviar el correo

        if ($mail->send()) {
            echo 'Correo enviado con éxito';
        } else {
            echo 'No se pudo enviar el correo.';
        }

    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
} else {
    echo "No se ha enviado el formulario correctamente.";
}
?>