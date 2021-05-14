<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("empresa_new","encabezado",0); ?>
    </h3>
    <p class="text-justify">
        En el módulo EMPRESA usted puede registrar los datos de su compañía, negocio u organización. Una vez que registre los datos de su empresa solo podrá actualizarlos en caso quiera cambiar algún dato, ya no será necesario registrarlos nuevamente.
    </p>
</div>

<div class="container-fluid">
    <?php
        $datos_empresa=$lc->datos_tabla("Normal","empresa LIMIT 1","*",0);

        if($datos_empresa->rowCount()>=1){
            $campos=$datos_empresa->fetch();
    ?>
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/empresaAjax.php" method="POST" data-form="update" autocomplete="off" style="border-top: 5px solid #00a2d9; border: none; box-shadow:none; padding:15px">
        <input type="hidden" name="empresa_id_up" value="<?php echo $lc->encryption($campos['empresa_id']); ?>" >
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Datos de la empresa</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="empresa_tipo_documento" class="bmd-label-floating">Tipo de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="empresa_tipo_documento_up" id="empresa_tipo_documento">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(DOCUMENTOS_EMPRESA,$campos['empresa_tipo_documento']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="empresa_numero_documento" class="bmd-label-floating">Numero de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9-]{7,30}" class="form-control" name="empresa_numero_documento_up" value="<?php echo $campos['empresa_numero_documento']; ?>" id="empresa_numero_documento" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="empresa_nombre" class="bmd-label-floating">Nombre <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,75}" class="form-control" name="empresa_nombre_up" value="<?php echo $campos['empresa_nombre']; ?>" id="empresa_nombre" maxlength="75">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="empresa_direccion" class="bmd-label-floating">Dirección</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}" class="form-control" name="empresa_direccion_up" value="<?php echo $campos['empresa_direccion']; ?>" id="empresa_direccion" maxlength="97">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br>
        <fieldset>
            <legend><i class="fas fa-phone-volume"></i> &nbsp; Información de contacto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="empresa_telefono_up" value="<?php echo $campos['empresa_telefono']; ?>" id="empresa_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="empresa_email_up" value="<?php echo $campos['empresa_email']; ?>" id="empresa_email" maxlength="50">
                        </div>
                    </div>               
                </div>
            </div>
        </fieldset>
        <br><br>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync"></i> &nbsp; ACTUALIZAR</button>
        </p>
        <p class="text-center">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
    </form> 
    <?php }else{ ?>
        <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/empresaAjax.php" method="POST" data-form="save" autocomplete="off" style="border-top: 5px solid #003800">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Datos de la empresa</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="empresa_tipo_documento" class="bmd-label-floating">Tipo de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="empresa_tipo_documento_reg" id="empresa_tipo_documento">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(DOCUMENTOS_EMPRESA,"VACIO");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="empresa_numero_documento" class="bmd-label-floating">Numero de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9-]{7,30}" class="form-control" name="empresa_numero_documento_reg" id="empresa_numero_documento" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="empresa_nombre" class="bmd-label-floating">Nombre <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,75}" class="form-control" name="empresa_nombre_reg" id="empresa_nombre" maxlength="75">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="empresa_direccion" class="bmd-label-floating">Dirección</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}" class="form-control" name="empresa_direccion_reg" id="empresa_direccion" maxlength="97">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br>
        <fieldset>
            <legend><i class="fas fa-phone-volume"></i> &nbsp; Información de contacto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="empresa_telefono_reg" id="empresa_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="empresa_email_reg" id="empresa_email" maxlength="50">
                        </div>
                    </div>               
                </div>
            </div>
        </fieldset>
        <br><br>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
        <p class="text-center">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
    </form>    
    <?php } ?>
</div>