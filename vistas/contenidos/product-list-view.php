<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("producto_list","encabezado",0); ?>
    </h3>
    <?php include "./vistas/desc/desc_producto.php"; ?>
</div>

<!--<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <?php
            if($_SESSION['cargo_svi']=="Administrador"){
                echo '<li>'.$lc->enrutador("producto_new","inactivo",0).'</li>';
            }
        ?>
        <li><?php echo $lc->enrutador("producto_list","activo",0); ?></li>
    </ul>	
</div>-->
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
        <li class="active"><?php echo $lc->enrutador("producto_new", "nuevo", 0); ?></li>
        <li><a class="btn btn-info">/</a></li>
        <li><?php echo $lc->enrutador("producto_list", "lista", 0); ?></li>
	</ul>
</div>

<div class="container-fluid" style="background-color: #FFF; padding-bottom: 20px;">
    <?php
        require_once "./controladores/productoControlador.php";
        $ins_producto = new productoControlador();

        echo $ins_producto->paginador_producto_controlador($pagina[1],15,$pagina[0],"",$_SESSION['cargo_svi']);
    ?>
</div>