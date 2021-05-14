<?php
// Desactivar toda notificación de error
error_reporting(0);
 
// Notificar solamente errores de ejecución
error_reporting(E_ERROR | E_WARNING | E_PARSE);

    $peticion_ajax=true;
    require_once "../config/APP.php";

	if(isset($_POST['producto_codigo_add']) || isset($_POST['producto_codigo_del']) || isset($_POST['producto_codigo_up']) || isset($_POST['buscar_cliente']) 
	   || isset($_POST['cliente_id_add']) || isset($_POST['cliente_id_del']) || isset($_POST['buscar_codigo']) || isset($_POST['venta_descuento_add']) 
	   || isset($_POST['venta_descuento_del']) || isset($_POST['venta_tipo_venta_reg']) || isset($_POST['pago_codigo_reg']) || isset($_POST['venta_codigo_del']) 
	   || $_GET['op'] || isset($_POST['parameter_entrega_reg']) || isset($_POST['pedido_codigo_reg'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/ventaControlador.php";
        $ins_venta = new ventaControlador();

		if(isset($_GET['op'])){
			

			/*--------- Lista entregas ---------*/
			if($_GET['op'] == "cargarexcel"){

				$fileName ="";
				if($_FILES['excelfile']['name'] != ""){
					$fileName = time() . '_' . $_FILES['excelfile']['name'];
					$sourcePath = $_FILES['excelfile']['tmp_name'];
					$targetPath = "../upload/file.xlsx";
					move_uploaded_file($sourcePath, $targetPath);
				}	
			}
			/*--------- Lista entregas ---------*/
			if($_GET['op'] == "procesarentrega"){

				$fileName ="";
				if($_FILES['image']['name'] != ""){
					$fileName = time() . '_' . $_FILES['image']['name'];
					$sourcePath = $_FILES['image']['tmp_name'];
					$targetPath = "../images/" . $fileName;
					move_uploaded_file($sourcePath, $targetPath);
				}	
				echo $ins_venta->procesar_entrega($_POST['parameter_entrega_reg'], $fileName, $_POST['draw-dataUrl'], $_POST['venta_cliente_nombre']);
			}

			/*--------- Lista entregas ---------*/
			if($_GET['op'] == "entregar"){
				echo $ins_venta->lista_entrega($_GET['parameter']);
			}

			if($_GET['op'] == "realizarpago"){
				echo $ins_venta->realizar_pago($_POST['id']);
			}

			/*--------- Lista usuarios ---------*/
			if($_GET['op'] == "listar"){
				echo $ins_venta->lista_cliente();
			}

			/*--------- Busca usuarios ---------*/
			if($_GET['op'] == "buscarcliente"){
				echo $ins_venta->busca_cliente($_POST['id']);
			}

			/*--------- Lista usuarios ---------*/
			if($_GET['op'] == "salvarventa"){
				echo $ins_venta->salvar_venta($_POST['carga'], $_POST['tracking'], 
											$_POST['peso'], $_POST['precio'], 
											$_POST['precio_cliente'],  $_POST['precio_venta'], 
											$_POST['cliente'], $_POST['vendedor_id'], 
											$_POST['fecha'], $_POST['delivery']);
			} 
	
			if($_GET['op'] == "realizados"){
				echo $ins_venta->lista_realizados($_GET['ini'], $_GET['fin']);
			}

			if($_GET['op'] == "pendiente"){
				echo $ins_venta->lista_pendiente($_GET['vendedor'], $_GET['ruta']);
			}

			if($_GET['op'] == "pagos"){
				echo $ins_venta->lista_pagos();
			}

			if($_GET['op'] == "pagospendiente"){
				echo $ins_venta->lista_pagos_detalle("Pendiente", $_GET['ini'], $_GET['fin']);
			}

			if($_GET['op'] == "pagosrealizados"){
				echo $ins_venta->lista_pagos_detalle("Cancelado", $_GET['ini'], $_GET['fin']);
			}

			if($_GET['op'] == "enviarcorreo"){
				echo $ins_venta->envia_correo();
			}
		}
		
		/*--------- Eliminar producto a carrito ---------*/
		if(isset($_POST['pedido_codigo_reg'])){
			echo $ins_venta->agregar_pedido_controlador();
		}

        /*--------- Eliminar producto a carrito ---------*/
		if(isset($_POST['producto_codigo_del'])){
			echo $ins_venta->eliminar_producto_carrito_controlador();
		}

		/*--------- Buscar cliente ---------*/
		if(isset($_POST['buscar_cliente'])){
			echo $ins_venta->buscar_cliente_venta_controlador();
		}

		/*--------- Aplicar descuento ---------*/
		if(isset($_POST['venta_descuento_add'])){
			echo $ins_venta->aplicar_descuento_venta_controlador();
		}

		/*--------- Buscar codigo ---------*/
		if(isset($_POST['buscar_codigo'])){
			echo $ins_venta->buscar_codigo_venta_controlador();
		}

		/*--------- Registrar pago de venta---------*/
		if(isset($_POST['pago_codigo_reg'])){
			echo $ins_venta->agregar_pago_venta_controlador();
		} 

		/*--------- Eliminar venta---------*/
		if(isset($_POST['venta_codigo_del'])){
			echo $ins_venta->eliminar_venta_controlador();
		}
	}else{
		echo "Error falta algun parametro";
	}