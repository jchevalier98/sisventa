<?php
    $peticion_ajax=true;
    require_once "../config/APP.php";

	if(isset($_POST['categoria_nombre_reg']) || isset($_POST['categoria_id_up']) || isset($_POST['categoria_id_del'])){

		/*--------- Instancia al controlador ---------*/
		require_once "../controladores/categoriaControlador.php";
        $ins_categoria = new categoriaControlador();

        /*--------- Agregar categoria ---------*/
        if(isset($_POST['categoria_nombre_reg'])){
            echo $ins_categoria->agregar_categoria_categoria();
        }
        
        /*--------- Actualizar categoria ---------*/
        if(isset($_POST['categoria_id_up'])){
            echo $ins_categoria->actualizar_categoria_controlador();
		}
        
        /*--------- Eliminar categoria ---------*/
        if(isset($_POST['categoria_id_del'])){
            echo $ins_categoria->eliminar_categoria_controlador();
		}

	}else{
		session_start(['name'=>'SVI']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}