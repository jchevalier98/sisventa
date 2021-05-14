<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";

	if(isset($_POST['devolucion_venta']) || isset($_POST['devolucion_compra'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/devolucionControlador.php";
        $ins_devolucion = new devolucionControlador();
        
		/*--------- Devolucion de venta ---------*/
		if(isset($_POST['devolucion_venta'])){
			echo $ins_devolucion->devolucion_venta_controlador();
		}
		
        
	}else{
		session_start(['name'=>'SVI']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}