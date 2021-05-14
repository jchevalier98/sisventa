<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("cliente_new","encabezado",0); ?>
    </h3>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
        <li><?php echo $lc->enrutador("cliente_list", "lista", 0); ?></li>
        <li><a class="btn btn-info">/</a></li>
        <li><?php echo $lc->enrutador("cliente_new_carga", "nuevo", 0); ?></li>
	</ul>
</div>

<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php?op=otros" method="POST" data-form="save" autocomplete="off" style="border: none; box-shadow:none; padding:15px">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_tipo" class="bmd-label-floating">Tipo de cliente <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_tipo" id="cliente_tipo">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(USUARIOS_TIPO,"VACIO");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_tipo_documento_reg" class="bmd-label-floating">Tipo de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_tipo_documento_reg" id="cliente_tipo_documento_reg">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(DOCUMENTOS_USUARIOS,"VACIO");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_numero_documento" class="bmd-label-floating">Numero de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9-]{7,30}" class="form-control" name="cliente_numero_documento_reg" id="cliente_numero_documento" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_nombre" class="bmd-label-floating">Nombres <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_nombre_reg" id="cliente_nombre" maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_cumple_reg" >Cumpleaños</label>
                            <input type="date" class="form-control" name="cliente_cumple_reg" id="cliente_cumple_reg" maxlength="30">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br>
        <fieldset>
            <legend><i class="fas fa-map-marked-alt"></i> &nbsp; Información de residencia</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_pais_reg" class="bmd-label-floating">Pais <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" class="form-control" name="cliente_pais_reg" id="cliente_pais_reg" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_direccion_reg" class="bmd-label-floating">Dirección <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" class="form-control" name="cliente_direccion_reg" id="cliente_direccion_reg" maxlength="250">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_direccion_google_reg" class="bmd-label-floating">Agegar pin de google <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" class="form-control" name="cliente_direccion_google_reg" id="cliente_direccion_google_reg" maxlength="70">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br>
        <fieldset>
            <legend><i class="far fa-address-book"></i> &nbsp; Información de contacto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_telefono" class="bmd-label-floating">Teléfono <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="cliente_telefono_reg" id="cliente_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="cliente_email_reg" id="cliente_email" maxlength="50">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_pagina_reg" class="bmd-label-floating">Pagina web</label>
                            <input type="text" class="form-control" name="cliente_pagina_reg" id="cliente_pagina_reg">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br>
        <fieldset>
            <legend><i class="far fa-address-book"></i> &nbsp; Configuración del cliente</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="cliente_metodo_pago_reg" class="bmd-label-floating">Metodo de pago<?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_metodo_pago_reg" id="cliente_metodo_pago_reg">
                                <?php
                                    echo $lc->generar_select(METODO_PAGO,"VACIO");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="cliente_precio_reg" class="bmd-label-floating">Precio asignado <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_precio_reg" id="cliente_precio_reg">
                                <?php
                                    echo $lc->generar_select(PRECIO,"VACIO");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="cliente_vendedor_reg" class="bmd-label-floating">Vendedor asignado <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_vendedor_reg" id="cliente_vendedor_reg">
                                <?php
                                    require_once "./controladores/clienteControlador.php";
                                    $ins_cliente = new clienteControlador();
                                    echo $ins_cliente->lista_usuario();
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="cliente_ruta_reg" class="bmd-label-floating">Ruta asignada <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_ruta_reg" id="cliente_ruta_reg">
                                <?php
                                    echo $lc->generar_select(RUTA,"VACIO");
                                ?>
                            </select>
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