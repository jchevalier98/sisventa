<div class="full-box page-header" style="background-color: #f4f6f9;">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("venta_search_code","encabezado",0); ?>
    </h3>
</div>

<div class="container-fluid" style="background-color: #f4f6f9;">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li><?php echo $lc->enrutador("venta_new","inactivo",0); ?></li>
        <li><?php echo $lc->enrutador("venta_list","inactivo",0); ?></li>
        <li><?php echo $lc->enrutador("venta_pending","inactivo",0); ?></li>
        <li><?php echo $lc->enrutador("venta_search_date","inactivo",0); ?></li>
        <li><?php echo $lc->enrutador("venta_search_code","activo",0); ?></li>
    </ul>	
</div>
<?php
	if(!isset($_SESSION['busqueda_venta']) && empty($_SESSION['busqueda_venta'])){
?>
<div class="container-fluid" style="background-color: #f4f6f9;">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" method="POST" autocomplete="off" >
        <input type="hidden" name="modulo" value="venta">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">Introduzca el numero de tracking</label>
                        <input type="text" class="form-control" name="busqueda_inicial" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ- ]{1,30}" id="inputSearch" maxlength="30">
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
<?php }else{ ?>
<div class="container-fluid" style="background-color: #f4f6f9;">
    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="search" method="POST" autocomplete="off">
        <input type="hidden" name="modulo" value="venta">
        <input type="hidden" name="eliminar_busqueda" value="eliminar">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                    Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_venta']; ?>”</strong>
                    </p>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="container-fluid" style="background-color: #f4f6f9;">
    <?php
        require_once "./controladores/ventaControlador.php";
        $ins_venta = new ventaControlador();
        echo $ins_venta->paginador_venta_controlador($pagina[1],15,$pagina[0],$_SESSION['busqueda_venta'],"");
    ?>
</div>
<?php
		include "./vistas/inc/print_invoice_script.php";
	}
?>