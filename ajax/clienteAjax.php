<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";

	if(isset($_POST['cliente_tipo_documento_reg']) || isset($_POST['cliente_id_up']) || isset($_POST['cliente_id_del']) || isset($_GET['op'])){
 
		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/clienteControlador.php";
        $ins_cliente = new clienteControlador();

        /*--------- Agregar cliente ---------*/
        if(isset($_POST['cliente_tipo_documento_reg'])){
            echo $ins_cliente->agregar_cliente_controlador();
		}
		
		/*--------- Actualizar cliente ---------*/
        if(isset($_POST['cliente_id_up'])){
            echo $ins_cliente->actualizar_cliente_controlador();
        }

		/*--------- Eliminar cliente ---------*/
        if(isset($_POST['cliente_id_del'])){
			echo $ins_cliente->eliminar_cliente_controlador();
		}

		/*--------- Listar cliente ---------*/
		if(isset($_GET['op'])){
			if($_GET['op'] == "listar"){
				echo $ins_cliente->listar_cliente();
			}

			if($_GET['op'] == "obtenerid"){
				echo $ins_cliente->obtener_id();
			}
	
			/*--------- Listar cliente ---------*/
			if($_GET['op'] == "porpagar"){
				echo $ins_cliente->pendiente_pago();
			}

			/*--------- Listar cliente ---------*/
			if($_GET['op'] == "cargar"){
				echo $ins_cliente->carga_cliente_manual_controlador($_POST['cliente_id'], $_POST['cedula'], $_POST['nombre'],
																	$_POST['direccion'], $_POST['telefono'],
																	$_POST['estado'], $_POST['website'],
																	$_POST['cumpleano'], $_POST['mail'],
																	$_POST['vendedor'], $_POST['precio']);
			}
		}

	}else{
		session_start(['name'=>'SVI']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}