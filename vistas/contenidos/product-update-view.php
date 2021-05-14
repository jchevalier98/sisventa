<?php
    include "./vistas/inc/admin_security.php";
?>

<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("producto_update","encabezado",0); ?>
    </h3>
    <?php include "./vistas/desc/desc_producto.php"; ?>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li><?php echo $lc->enrutador("producto_new","inactivo",0); ?></li>
        <li><?php echo $lc->enrutador("producto_list","inactivo",0); ?></li>
    </ul>	
</div>

<div class="container-fluid">
    <?php
        include "./vistas/inc/btn_go_back.php";
        
        $datos_producto=$lc->datos_tabla("Unico","producto","producto_id",$pagina[1]);

        if($datos_producto->rowCount()==1){
            $campos=$datos_producto->fetch();
    ?>
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productoAjax.php" method="POST" data-form="update" autocomplete="off" style="border-top: 5px solid #003800">
        <h3 class="text-center text-info"><?php echo $campos['producto_nombre']; ?></h3>
        <hr>
        <input type="hidden" name="producto_id_up" value="<?php echo $pagina[1]; ?>">
        <fieldset>
            <legend><i class="fas fa-barcode"></i> &nbsp; Código</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="producto_codigo" class="bmd-label-floating">Código: <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9- ]{1,70}" class="form-control" name="producto_codigo_up" value="<?php echo $campos['producto_codigo']; ?>" id="producto_codigo" maxlength="70" readonly >
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br>
        <fieldset>
            <legend><i class="fas fa-box"></i> &nbsp; Información del producto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="producto_nombre" class="bmd-label-floating">Nombre <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\- ]{1,97}" class="form-control" name="producto_nombre_up" value="<?php echo $campos['producto_nombre']; ?>" id="producto_nombre" maxlength="97" >
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="producto_stock_total" class="bmd-label-floating">Stock o existencias <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9]{1,20}" class="form-control" name="producto_stock_total_up" value="<?php echo $campos['producto_stock_total']; ?>" id="producto_stock_total" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="producto_peso" class="bmd-label-floating">Peso <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9]{1,9}" class="form-control" name="producto_peso" value="<?php echo $campos['producto_peso']; ?>" id="producto_peso" maxlength="9">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="producto_unidad" class="bmd-label-floating">Presentación del producto <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="producto_unidad_up" id="producto_unidad">
                                <?php
                                    echo $lc->generar_select(PRODUCTO_UNIDAD,$campos['producto_tipo_unidad']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_precio_compra" class="bmd-label-floating">Precio de compra (Con impuesto incluido) <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="producto_precio_compra_up" value="<?php echo number_format($campos['producto_precio_compra'],MONEDA_DECIMALES,'.',''); ?>" id="producto_precio_compra" maxlength="25">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_precio_venta" class="bmd-label-floating">Precio de venta (Con impuesto incluido) <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="producto_precio_venta_up" value="<?php echo number_format($campos['producto_precio_venta'],MONEDA_DECIMALES,'.',''); ?>" id="producto_precio_venta" maxlength="25">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_precio_venta_mayoreo" class="bmd-label-floating">Precio de venta por mayoreo (Con impuesto incluido) <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="producto_precio_venta_mayoreo_up" value="<?php echo number_format($campos['producto_precio_mayoreo'],MONEDA_DECIMALES,'.',''); ?>" id="producto_precio_venta_mayoreo" maxlength="25">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_descuento" class="bmd-label-floating">Descuento (%) en venta <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9]{1,2}" class="form-control" name="producto_descuento_up" value="<?php echo $campos['producto_descuento']; ?>" id="producto_descuento" maxlength="2">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_marca" class="bmd-label-floating">Marca</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}" class="form-control input-barcode" name="producto_marca_up" value="<?php echo $campos['producto_marca']; ?>" id="producto_marca" maxlength="30" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_modelo" class="bmd-label-floating">Modelo</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}" class="form-control input-barcode" name="producto_modelo_up" value="<?php echo $campos['producto_modelo']; ?>" id="producto_modelo" maxlength="30" >
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br>
        <fieldset>
            <legend><i class="fas fa-calendar-alt"></i> &nbsp; Vencimiento del producto</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="producto_vencimiento_up" value="Si" <?php if($campos['producto_vencimiento']=="Si"){ echo "checked"; } ?> >
                                        <i class="far fa-check-circle fa-fw"></i> &nbsp; Si vence
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="producto_vencimiento_up" value="No" <?php if($campos['producto_vencimiento']=="No"){ echo "checked"; } ?> >
                                        <i class="far fa-times-circle fa-fw"></i> &nbsp; No vence
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="producto_fecha_vencimiento" >Fecha de vencimiento (día/mes/año)</label>
                                <input type="date" class="form-control" name="producto_fecha_vencimiento_up" id="producto_fecha_vencimiento" maxlength="30" value="<?php echo $campos['producto_fecha_vencimiento']; ?>" >
                            </div>
                        </div>
                    </div>
                </div>
        </fieldset>
        <br><br>
        <fieldset>
            <legend><i class="fas fa-history"></i> &nbsp; Garantía de fabrica</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="producto_garantia_unidad" class="bmd-label-floating">Unidad de tiempo <?php echo CAMPO_OBLIGATORIO; ?></label>
                                <input type="text" pattern="[0-9]{1,2}" class="form-control input-barcode" name="producto_garantia_unidad_up" id="producto_garantia_unidad" maxlength="2" value="<?php echo $campos['producto_garantia_unidad']; ?>" >
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="producto_garantia_tiempo" class="bmd-label-floating">Tiempo de garantía <?php echo CAMPO_OBLIGATORIO; ?></label>
                                <select class="form-control" name="producto_garantia_tiempo_up" id="producto_garantia_tiempo">
                                    <?php
                                        echo $lc->generar_select(GARANTIA_TIEMPO,$campos['producto_garantia_tiempo']);
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
        </fieldset>
        <br><br>
        <fieldset>
            <legend><i class="fas fa-truck-loading"></i> &nbsp; Categoría & estado</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="producto_estado" class="bmd-label-floating">Estado del producto</label>
                            <select class="form-control" name="producto_estado_up" id="producto_estado">
                                <?php
                                    $array_estado=["Habilitado","Deshabilitado"];
                                    echo $lc->generar_select($array_estado,$campos['producto_estado']);
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync"></i> &nbsp; ACTUALIZAR</button>
        </p>
        <p class="text-center">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
    </form>
    <?php 
        }else{
            include "./vistas/inc/error_alert.php";
        } 
    ?>
</div>