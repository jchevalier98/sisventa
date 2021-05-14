<?php
    if($_SESSION['cargo_svi']!="Administrador"){
        echo $lc->forzar_cierre_sesion_controlador();
		exit();
    }