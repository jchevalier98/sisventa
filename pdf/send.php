<?php
require_once "mail.php";
$data = array("4561980253JJD014600008369652530");
$send_email = new Send_Mail();
$send_email->send_email("chevalier_nm@hotmail.com", "ENTREGA", $data, "", "1619205162_Captura de Pantalla 2021-03-08 a la(s) 8.43.02 a. m..png");
?>