<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";

	if(isset($_POST['caja_numero_reg']) || isset($_POST['caja_id_up']) || isset($_POST['caja_id_del'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/cajaControlador.php";
        $ins_caja = new cajaControlador();
        
        /*--------- Agregar caja ---------*/
        if(isset($_POST['caja_numero_reg'])){
            echo $ins_caja->agregar_caja_controlador();
		}
		
		/*--------- Actualizar caja ---------*/
		if(isset($_POST['caja_id_up'])){
			echo $ins_caja->actualizar_caja_controlador();
		}

		/*--------- Eliminar caja ---------*/
		if(isset($_POST['caja_id_del'])){
			echo $ins_caja->eliminar_caja_controlador();
		}
	}else{
		session_start(['name'=>'SVI']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}