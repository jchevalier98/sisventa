<?php
// Desactivar toda notificación de error
error_reporting(0);
// Notificar solamente errores de ejecución
error_reporting(E_ERROR | E_WARNING | E_PARSE);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/Exception.php";
require_once "PHPMailer/src/SMTP.php";

class Send_Mail
{
    public function __construct(){}

    function send_email($to, $isArribe, $trackings, $factura, $imagen)
    {
        $mail = new PHPMailer(true);
        try {
            //Configure PHPMailer
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            if($isArribe == "LLEGO"){

                $mail->Username = 'facturacion@mastermarketpa.com';
                $mail->Password = 'G154rmCrPV';
                $mail->setFrom('facturacion@mastermarketpa.com');

                $tipo = "Hola! Hemos recibido productos de tu interes pronto nos comunicaremos contigo para la entrega.";
                $mensaje_cliente = "Pronto Estaremos contigo. &nbsp;";  
                $nota = utf8_decode('Nota: Esta notificacion confirma que tu producto esta en nuestras manos y será entregado en 1 o 2 dias habiles aproximadamente.
                Puedes darle seguimiento escribiendonos al numero +50768932533 o al correo <a style="color:#0000ff" href="mailto:mmarketpa@gmail.com" target="_blank">mmarketpa@gmail.com</a>');
            }
            else{
                $mail->Username = 'entregas@mastermarketpa.com';
                $mail->Password = 'MJL11ehUfh';
                $mail->setFrom('entregas@mastermarketpa.com');

                $tipo = "ENTREGA REALIZADA,";
                $mensaje_cliente = ""; 
                $nota = "";
            }

            //Configure Email
            $mail->addAddress($to);
            //Configure SMTP Server
            $mail->Host = 'gn309.whpservers.com';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	
    		$desc = utf8_decode("A continuación detalle de tu producto:");
            $subject = utf8_decode("Master market Panamá");
            $lista = ""; 
            $codigo = "";    
            $j=0;       
            foreach($trackings as $tracking){
                $lista.="<li>".$tracking."</li>";
                if($j == 0){
                    $codigo.= $tracking;
                }
                else{
                    $codigo.= ",".$tracking;
                }
                $j++; 
            }

            $message = '<!DOCTYPE html
                PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

                <head>
                <meta charset="UTF-8">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                <meta name="x-apple-disable-message-reformatting">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta content="telephone=no" name="format-detection">
                <title></title>
                <!--[if (mso 16)]>
                    <style type="text/css">
                    a {text-decoration: none;}
                    </style>
                    <![endif]-->
                <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
                <!--[if gte mso 9]>
                    <xml>
                    <o:OfficeDocumentSettings>
                    <o:AllowPNG></o:AllowPNG>
                    <o:PixelsPerInch>96</o:PixelsPerInch>
                    </o:OfficeDocumentSettings>
                    </xml>
                    <![endif]-->
                <!--[if !mso]><!-- -->
                <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet">
                <!--<![endif]-->
                </head>

                <body>
                <div class="es-wrapper-color">
                    <!--[if gte mso 9]>
                            <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                                <v:fill type="tile" color="#f4f4f4"></v:fill>
                            </v:background>
                        <![endif]-->
                    <table style="border-spacing:0;border-collapse:collapse;vertical-align:top" cellpadding="0" cellspacing="0"
                        align="center" width="100%" border="0">
                        <tbody>
                            <tr style="vertical-align:top">
                                <td
                                    style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;background-color:transparent;padding-top:15px;padding-right:0px;padding-bottom:0px;padding-left:0px;border-top:15px solid transparent;border-right:15px solid transparent;border-bottom:0px solid transparent;border-left:15px solid transparent">
                                    <table style="border-spacing:0;border-collapse:collapse;vertical-align:top" cellpadding="0"
                                        cellspacing="0" width="100%" border="0">
                                        <tbody>
                                            <tr style="vertical-align:top">
                                                <td style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;width:100%;padding-top:0px;padding-right:0px;padding-bottom:15px;padding-left:0px"
                                                    align="center">
                                                    <div style="font-size:12px" align="center"> 
                                                    	<img style="outline:none;text-decoration:none;clear:both;display:block;border:0;height:auto;line-height:100%;margin:0 auto;float:none;width:160px;max-width:260px"
                                                            align="center" border="0" src="http://mastermarketpa.com/appweb/vistas/assets/img/mmlogo.jpeg" alt="Image" title="Image" class="CToWUd"> </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br/>
                                    <table style="border-spacing:0;border-collapse:collapse;vertical-align:top" cellpadding="0"
                                        cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                    <div style="color:#555555;line-height:150%;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                        <div style="font-size:14px;line-height:18px;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif;color:#555555;text-align:left">
                                                            <p>'.$tipo.'</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                    <div style="color:#555555;line-height:150%;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                        <div style="font-size:14px;line-height:18px;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif;color:#555555;text-align:left">
                                                            <p>'.$desc.'</p>
                                                        </div>
                                                        <ul>
                                                            '.$lista.'
                                                        <ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                    <div style="color:#555555;line-height:150%;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                        <div style="font-size:14px;line-height:18px;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif;color:#555555;text-align:left">
                                                            <p>'.$mensaje_cliente.'</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="word-break:break-word;border-collapse:collapse!important;vertical-align:top; padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                    <div style="color:#555555;line-height:150%;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                        <div style="font-size:14px;line-height:18px;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif;color:#555555;text-align:left">
                                                            <p>
                                                                '.$nota.'
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table style="border-spacing:0;border-collapse:collapse;vertical-align:top" cellpadding="0"
                                        cellspacing="0" width="100%">
                                        <tbody>
                                            <tr style="vertical-align:top">
                                                <td
                                                    style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px">
                                                    <div
                                                        style="color:#e0e0e0;line-height:120%;font-family:Arial,Helvetica Neue,Helvetica,sans-serif">
                                                        <div
                                                            style="font-size:12px;line-height:14px;color:#e0e0e0;font-family:Arial,Helvetica Neue,Helvetica,sans-serif;text-align:left">
                                                            &nbsp;<br></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                </div>
                </body>
                </html>';
            
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $message;

            if($imagen != ""){
                $url = $_SERVER['DOCUMENT_ROOT'].'/SVIL/images/'.$imagen;
                $mail->addAttachment($url,'Comprobante.png');
            }

            if($factura != ""){
                $url = $_SERVER['DOCUMENT_ROOT'].'/SVIL/pdf/facturas/'.$factura.'.pdf';
                $mail->addAttachment($url,'Factura.pdf');
            }

            $mail->Send();

        } catch (Exception $e) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
?> 