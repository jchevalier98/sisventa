<?php
require_once "mail.php";
$data = array("1111",'wqewqew');
$send_email = new Mail();
$send_email->send_email("chevalier_nm@hotmail.com", true, $data);
?>