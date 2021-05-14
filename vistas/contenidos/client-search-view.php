<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("cliente_search","encabezado",0); ?>
    </h3>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li><?php echo $lc->enrutador("cliente_new","inactivo",0); ?></li>
        <li><?php echo $lc->enrutador("cliente_list","inactivo",0); ?></li>
        <li><?php echo $lc->enrutador("cliente_search","activo",0); ?></li>
    </ul>	
</div>
<?php
	if(!isset($_SESSION['busqueda_cliente']) && empty($_SESSION['busqueda_cliente'])){
?>
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" method="POST" autocomplete="off" style="border-top: 5px solid #003800">
        <input type="hidden" name="modulo" value="cliente">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">¿Qué cliente estas buscando?</label>
                        <input type="text" class="form-control" name="busqueda_inicial" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" id="inputSearch" maxlength="30">
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
<div class="container-fluid">
    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="search" method="POST" autocomplete="off">
        <input type="hidden" name="modulo" value="cliente">
        <input type="hidden" name="eliminar_busqueda" value="eliminar">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                    Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_cliente']; ?>”</strong>
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

<div class="container-fluid">
    <?php
        require_once "./controladores/clienteControlador.php";
        $ins_cliente = new clienteControlador();

        echo $ins_cliente->paginador_cliente_controlador($pagina[1],15,$pagina[0],$_SESSION['busqueda_cliente']);
    ?>
</div>
<?php } ?>