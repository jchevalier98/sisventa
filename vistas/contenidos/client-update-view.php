<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("cliente_update","encabezado",0); ?>
    </h3>
</div>

<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
        <li class="active"><?php echo $lc->enrutador("cliente_list", "lista", 0); ?></li>
        <li><a class="btn btn-info">/</a></li>
        <li><?php echo $lc->enrutador("cliente_new_carga", "nuevo", 0); ?></li>
	</ul>
</div>

<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="update" autocomplete="off" style="border:none; ">
        <?php
            include "./vistas/inc/btn_go_back.php";
            $datos_cliente=$lc->datos_tabla("Unico","cliente","cliente_id",$pagina[1]);
            if($datos_cliente->rowCount()==1){
                $campos=$datos_cliente->fetch();
        ?>
        <input type="hidden" name="cliente_id_up" value="<?php echo $pagina[1]; ?>">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_codigo" >Codigo</label>
                            <input type="text" class="form-control" name="cliente_codigo" id="cliente_codigo" value="<?php echo $campos['cliente_codigo']; ?>" maxlength="30" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_tipo" class="bmd-label-floating">Tipo de cliente <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_tipo" id="cliente_tipo">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(USUARIOS_TIPO,$campos['cliente_tipo']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_tipo_documento_up" class="bmd-label-floating">Tipo de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_tipo_documento_up" id="cliente_tipo_documento_up">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(DOCUMENTOS_USUARIOS,$campos['cliente_tipo_documento']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_numero_documento" class="bmd-label-floating">Numero de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9-]{7,30}" class="form-control" name="cliente_numero_documento_up" value="<?php echo $campos['cliente_numero_documento']; ?>" id="cliente_numero_documento" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_nombre" class="bmd-label-floating">Nombres <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_nombre_up" value="<?php echo $campos['cliente_nombre']; ?>" id="cliente_nombre" maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_cumple_up" >Cumpleaños</label>
                            <input type="date" class="form-control" name="cliente_cumple_up" id="cliente_cumple_up" value="<?php echo $campos['cliente_cumpleaños']; ?>" maxlength="30">
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
                            <label for="cliente_pais_up" class="bmd-label-floating">Pais <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" class="form-control" name="cliente_pais_up" value="<?php echo $campos['cliente_estado']; ?>" id="cliente_pais_up" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_direccion_up" class="bmd-label-floating">Dirección <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" class="form-control" name="cliente_direccion_up" value="<?php echo $campos['cliente_direccion']; ?>" id="cliente_direccion_up" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_direccion_google_up" class="bmd-label-floating">Pin de google<?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" class="form-control" name="cliente_direccion_google_up" value="<?php echo $campos['cliente_cordenada']; ?>" id="cliente_direccion_google_up" maxlength="70">
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
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="cliente_telefono_up" value="<?php echo $campos['cliente_telefono']; ?>" id="cliente_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="cliente_email_up" value="<?php echo $campos['cliente_email']; ?>" id="cliente_email" maxlength="50">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_pagina_reg" class="bmd-label-floating">Pagina web</label>
                            <input type="text" class="form-control" name="cliente_pagina_reg" id="cliente_pagina_reg" value="<?php echo $campos['cliente_sitioweb']; ?>">
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
                            <label for="cliente_metodo_pago_up" class="bmd-label-floating">Metodo de pago<?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_metodo_pago_up" id="cliente_metodo_pago_up">
                                <?php
                                    echo $lc->generar_select(METODO_PAGO,$campos['cliente_metodo_pago']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="cliente_precio_up" class="bmd-label-floating">Precio asignado <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_precio_up" id="cliente_precio_up">
                                <?php
                                    echo $lc->generar_select(PRECIO,$campos['cliente_precio']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="cliente_vendedor_up" class="bmd-label-floating">Vendedor asignado <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_vendedor_up" id="cliente_vendedor_up">
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
                            <label for="cliente_ruta_up" class="bmd-label-floating">Ruta asignada <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_ruta_up" id="cliente_ruta_up">
                                <?php
                                    echo $lc->generar_select(RUTA, $campos['cliente_ruta']);
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