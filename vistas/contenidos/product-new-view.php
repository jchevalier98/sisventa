<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("producto_new","encabezado",0); ?>
    </h3>
    <?php include "./vistas/desc/desc_producto.php"; ?>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
        <li class="active"><?php echo $lc->enrutador("producto_new", "nuevo", 0); ?></li>
        <li><a class="btn btn-info">/</a></li>
        <li><?php echo $lc->enrutador("producto_list", "lista", 0); ?></li>
	</ul>
</div>

<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productoAjax.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data" style="border: none; box-shadow:none; padding:15px">
        <fieldset> 
            <legend><i class="fas fa-box"></i> &nbsp; Información del producto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="producto_codigo_reg" class="bmd-label-floating">Código</label>
                            <input type="text" pattern="[a-zA-Z0-9- ]{1,70}" class="form-control input-barcode" name="producto_codigo_reg" id="producto_codigo_reg" maxlength="70" >
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="form-group">
                            <label for="producto_nombre" class="bmd-label-floating">Nombre <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\- ]{1,97}" class="form-control input-barcode" name="producto_nombre_reg" id="producto_nombre" maxlength="97" >
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="producto_stock_total" class="bmd-label-floating">Existencias <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9]{1,20}" class="form-control" name="producto_stock_total_reg" id="producto_stock_total" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="producto_unidad" class="bmd-label-floating">Presentación del producto <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="producto_unidad_reg" id="producto_unidad">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(PRODUCTO_UNIDAD,"VACIO");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="producto_peso" class="bmd-label-floating">Peso <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" class="form-control" name="producto_peso" id="producto_peso" maxlength="9">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_precio_compra" class="bmd-label-floating">Precio de compra (Con impuesto incluido) <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="producto_precio_compra_reg" value="0.00" id="producto_precio_compra" maxlength="25">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_precio_venta" class="bmd-label-floating">Precio de venta (Con impuesto incluido) <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="producto_precio_venta_reg" value="0.00" id="producto_precio_venta" maxlength="25">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_descuento" class="bmd-label-floating">Descuento (%) en venta <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9]{1,2}" class="form-control" name="producto_descuento_reg" value="0" id="producto_descuento" maxlength="2">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_marca" class="bmd-label-floating">Marca</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}" class="form-control input-barcode" name="producto_marca_reg" id="producto_marca" maxlength="30" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="producto_modelo" class="bmd-label-floating">Modelo</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}" class="form-control input-barcode" name="producto_modelo_reg" id="producto_modelo" maxlength="30" >
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
                                        <input type="radio" name="producto_vencimiento_reg" value="Si" >
                                        <i class="far fa-check-circle fa-fw"></i> &nbsp; Si vence
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="producto_vencimiento_reg" value="No" checked >
                                        <i class="far fa-times-circle fa-fw"></i> &nbsp; No vence
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="producto_fecha_vencimiento" >Fecha de vencimiento (día/mes/año)</label>
                                <input type="date" class="form-control" name="producto_fecha_vencimiento_reg" id="producto_fecha_vencimiento" maxlength="30" value="<?php echo date("Y-m-d"); ?>" >
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
                                <input type="text" pattern="[0-9]{1,2}" class="form-control input-barcode" name="producto_garantia_unidad_reg" id="producto_garantia_unidad" maxlength="2" value="0" >
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="producto_garantia_tiempo" class="bmd-label-floating">Tiempo de garantía <?php echo CAMPO_OBLIGATORIO; ?></label>
                                <select class="form-control" name="producto_garantia_tiempo_reg" id="producto_garantia_tiempo">
                                    <?php
                                        echo $lc->generar_select(GARANTIA_TIEMPO,"VACIO");
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
                            <select class="form-control" name="producto_estado_reg" id="producto_estado">
                                <option value="Habilitado" selected="" >Habilitado</option>
                                <option value="Deshabilitado">Deshabilitado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br>
        <fieldset>
            <legend><i class="far fa-image"></i> &nbsp; Foto o imagen del producto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="file" class="form-control-file" name="producto_foto" id="producto_foto" accept=".jpg, .png, .jpeg">
                            <small class="text-muted">Tipos de archivos permitidos: JPG, JPEG, PNG. Tamaño máximo 3MB. Resolución recomendada 300px X 300px o superior manteniendo el aspecto cuadrado (1:1)</small>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
        <p class="text-center">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
    </form>
</div>