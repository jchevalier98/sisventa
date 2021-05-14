<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";

	if(isset($_POST['producto_codigo_reg']) || isset($_POST['producto_img_id_up']) || isset($_POST['producto_img_id_del']) || isset($_POST['producto_id_up']) || isset($_POST['producto_id_del'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/productoControlador.php";
		$ins_producto = new productoControlador();
		
		/*--------- Agregar producto ---------*/
		if(isset($_POST['producto_codigo_reg'])){
			echo $ins_producto->agregar_producto_controlador();
		}

		/*--------- Actualizar producto ---------*/
        if(isset($_POST['producto_id_up'])){
			echo $ins_producto->actualizar_producto_controlador();
		}

		/*--------- Eliminar producto ---------*/
		if(isset($_POST['producto_id_del'])){
			echo $ins_producto->eliminar_producto_controlador();
		}

		/*--------- Actualizar imagen de producto ---------*/
        if(isset($_POST['producto_img_id_up'])){
			echo $ins_producto->actualizar_imagen_producto_controlador();
		}

		/*--------- Eliminar imagen de producto ---------*/
        if(isset($_POST['producto_img_id_del'])){
			echo $ins_producto->eliminar_imagen_producto_controlador();
		}

	}else{
		session_start(['name'=>'SVI']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}