<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";

	if(isset($_POST['movimiento_tipo_reg'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/movimientoControlador.php";
        $ins_movimiento = new movimientoControlador();
        
        /*--------- Agregar movimiento ---------*/
        if(isset($_POST['movimiento_tipo_reg'])){
            echo $ins_movimiento->agregar_movimiento_controlador();
		}
		

	}else{
		session_start(['name'=>'SVI']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}