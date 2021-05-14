<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/Exception.php";
require_once "PHPMailer/src/SMTP.php";
require_once "../pdf/send-fact.php";


class Mail
{
    public function __construct(){}

    function send_email($to, $isArribe, $trackings)
    {
        $mail = new PHPMailer(true);

        try {
            //Configure PHPMailer
            $mail->isSMTP();
            //$mail->SMTPDebug = true;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Configure SMTP Server
            $mail->Host = 'smtp.live.com';
            $mail->Username = 'chevalier_nm@hotmail.com';
            $mail->Password = 'isabel89';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            //Configure Email
            $mail->setFrom('chevalier_nm@hotmail.com');
            $mail->addAddress('jaimchevalier@gmail.com');
            
            $tipo = "Entrega de paquetes";
            $mensaje_cliente = "Estimado cliente reciba un cordial saludo y a su vez queremos hacer llegar su factura con los producto entregados.&nbsp;"; 
            if($isArribe == "LLEGO"){
                $tipo = "Llegada de paquetes";
                $mensaje_cliente = "Estimado cliente reciba un cordial saludo y a su vez queremos informarle que sus paquetes han llegado a nuestras bodegas.&nbsp;";  
            }

            $subject = "Master market - ". $tipo;
            $lista = "";
            foreach($trackings as $tracking){
                $lista.="<li>".$tracking."</li>";
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
                                                            align="center" border="0"
                                                            src="https://ci6.googleusercontent.com/proxy/fdwXN7G7MUh7UHbHrSBnbs9grYYg4URAQXH6aWXIZLFrO5gxFfh07xt3wLadRHOU1GVeJhIDbebu0MSJxXmfP-xaTVyfQ66H5YIt6M6oSIvOXb5qnxHO6ZX5DCRWB6QB-6cUjEK9zzVHc_3sqk3EI9MKuJJ1sY0VRjJ3GKHQshXs=s0-d-e1-ft#https://appz.interfuerza.com//S7_files/COMPANIES/20200519IF000000029710O3S4CHGT/logo-mm-turques_1591664870.png"
                                                            alt="Image" title="Image" class="CToWUd"> </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br/>
                                    <table style="border-spacing:0;border-collapse:collapse;vertical-align:top" cellpadding="0"
                                        cellspacing="0" width="100%">
                                        <tbody>
                                            <tr style="vertical-align:top">
                                                <td
                                                    style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;padding-top:0px;padding-right:30px;padding-bottom:0px;padding-left:30px">
                                                    <div
                                                        style="color:#237ae5;line-height:120%;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                        <div
                                                            style="font-size:12px;line-height:14px;color:#237ae5;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left">
                                                            <p style="margin:0;font-size:12px;line-height:14px;text-align:center">
                                                                <span style="font-size:28px;line-height:33px">'.$tipo.' - MASTER MARKET</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br/>
                                    <table style="border-spacing:0;border-collapse:collapse;vertical-align:top" cellpadding="0"
                                        cellspacing="0" width="100%">
                                        <tbody>
                                            <tr">
                                                <td style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                    <div style="color:#555555;line-height:150%;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                        <div style="font-size:14px;line-height:18px;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif;color:#555555;text-align:left">
                                                            <p>'.$mensaje_cliente.'</p>
                                                        </div>
                                                        <ul>
                                                            '.$lista.'
                                                        <ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                    <div style="color:#555555;line-height:150%;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                        <div style="font-size:14px;line-height:18px;font-family:Open Sans,Helvetica Neue,Helvetica,Arial,sans-serif;color:#555555;text-align:left">
                                                            <p>
                                                                Esperamos que sea de su agrado y tenga plena confianza en consultar con nosotros para cualquier decisión final.
                                                                <br><br>
                                                                Nos puede contactar al correo <a style="color:#0000ff" href="mailto:mmarketpa@gmail.com" target="_blank">mmarketpa@gmail.com</a></p>
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

            $pdf = new PdfEmail();
            $response = $pdf->create_pdf("12323435tfdvxvf", "12323435tfdvxvf");
            $mail->AddAttachment($response,$response);

            //send mail
            $mail->Send();
            echo 'Message has been sent using SMTP Server';
        } catch (Exception $e) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
?> 