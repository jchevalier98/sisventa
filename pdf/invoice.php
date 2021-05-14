<?php
	$peticion_ajax=true;
	$code=(isset($_GET['code'])) ? $_GET['code'] : 0;
	require_once "../controladores/ventaControlador.php";
	$ins_venta = new ventaControlador();
	echo $ins_venta->mostrar_pdf($code);