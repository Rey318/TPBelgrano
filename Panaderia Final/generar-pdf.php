<?php
require 'fpdf/fpdf.php';
require 'vendor/autoload.php';  // Si estás usando Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generarTicket($datosCompra) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Encabezado
    $pdf->Cell(190, 10, 'Ticket de Compra', 0, 1, 'C');
    $pdf->Ln(10);

    // Detalles del cliente
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(190, 10, 'Cliente: ' . $datosCompra['cliente'], 0, 1);
    $pdf->Cell(190, 10, 'Correo: ' . $datosCompra['email'], 0, 1);
    $pdf->Ln(10);

    // Detalles de la compra
    $pdf->Cell(190, 10, 'Detalles de la Compra:', 0, 1);
    foreach ($datosCompra['productos'] as $producto) {
        $pdf->Cell(190, 10, $producto['nombre'] . ' - Cantidad: ' . $producto['cantidad'], 0, 1);
    }
    $pdf->Ln(10);

    // Total
    $pdf->Cell(190, 10, 'Total: $' . $datosCompra['total'], 0, 1, 'R');

    // Guardar el PDF en un archivo
    $nombreArchivo = 'ticket_' . time() . '.pdf';
    $pdf->Output('F', $nombreArchivo);

    return $nombreArchivo;
}

// Ejemplo de datos de compra
$datosCompra = [
    'cliente' => 'Pedro',
    'email' => 'jpedro@correo.com',
    'productos' => [
        ['nombre' => 'Pan Integral', 'cantidad' => 2],
        ['nombre' => 'Croissant', 'cantidad' => 1],
    ],
    'total' => 150.00
];

// Generar el ticket en PDF
$archivoPDF = generarTicket($datosCompra);

// Enviar el correo con el ticket adjunto
$mail = new PHPMailer(true);
try {
    // Configuración del servidor de correo
    $mail->isSMTP();
    $mail->Host = 'smtp.tucorreo.com';  // Cambia al servidor SMTP que uses
    $mail->SMTPAuth = true;
    $mail->Username = 'tu-email@dominio.com';  // Tu dirección de correo
    $mail->Password = 'tu-contraseña';  // Tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;  // O el puerto que uses (normalmente 587)

    // Remitente y destinatario
    $mail->setFrom('tu-email@dominio.com', 'Tu Nombre o Empresa');
    $mail->addAddress($datosCompra['email'], $datosCompra['cliente']);  // Destinatario

    // Asunto y cuerpo del mensaje
    $mail->Subject = 'Tu Ticket de Compra';
    $mail->Body    = 'Gracias por tu compra. Adjuntamos el ticket de la misma.';

    // Adjuntar el PDF generado
    $mail->addAttachment($archivoPDF);

    // Enviar el correo
    $mail->send();
    echo 'El ticket ha sido enviado al correo ' . $datosCompra['email'];
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}

// Opcional: eliminar el archivo PDF después de enviarlo
unlink($archivoPDF);
?>
