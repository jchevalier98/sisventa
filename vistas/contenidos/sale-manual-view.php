<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php
            echo $lc->enrutador("venta_new","encabezado",0);
        ?>
    </h3>
</div> 
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
        <li><?php echo $lc->enrutador("venta_new", "nuevo", 0); ?></li>
        <li><a class="btn btn-info">/</a></li>
        <li class="active"><?php echo $lc->enrutador("venta_list", "lista", 0); ?></li>
        <li><a class="btn btn-info">/</a></li>
        <li class="active"><?php echo $lc->enrutador("venta_pending", "pendiente", 0); ?></li>
	</ul>
</div>

<div class="container-fluid">
    <?php
        include "./vistas/inc/btn_go_back.php";
    ?>
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/ventaAjax.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data" style="border: none; box-shadow:none; padding:15px">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información del cliente</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="pedido_cliente_reg" class="bmd-label-floating">Cliente <?php echo CAMPO_OBLIGATORIO; ?></label>
                                <select class="form-control" name="pedido_cliente_reg" id="pedido_cliente_reg">
                                    <?php
                                        require_once "./controladores/ventaControlador.php";
                                        $ins_cliente = new ventaControlador();
                                        echo $ins_cliente->lista_cliente();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="pedido_precio_asig_reg" >Precio asignado al cliente</label>
                                <input type="text" pattern="[0-9]{1,20}" class="form-control" name="pedido_precio_asig_reg" id="pedido_precio_asig_reg" maxlength="20" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="pedido_vendedor_reg" >Vendedor</label>
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" class="form-control input-barcode" name="pedido_vendedor_reg" id="pedido_vendedor_reg" maxlength="20" readonly>
                                <input type="hidden" name="pedido_vendedor_id_reg" id="pedido_vendedor_id_reg" readonly>
                                <input type="hidden" name="pedido_fecha_reg" id="pedido_fecha_reg" readonly>
                                <input type="hidden" name="pedido_correo_reg" id="pedido_correo_reg" readonly>
                            </div>
                        </div>
                    </div>
                </div>
        </fieldset>
        <br><br>
        <fieldset> 
            <legend><i class="fas fa-box"></i> &nbsp; Detalle de venta</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="form-group">
                            <label for="pedido_codigo_reg" class="bmd-label-floating">Numero de tracking</label>
                            <input type="text" pattern="[a-zA-Z0-9- ]{1,70}" class="form-control input-barcode" name="pedido_codigo_reg" id="pedido_codigo_reg" maxlength="70" >
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="pedido_peso_reg" class="bmd-label-floating">Cantidad <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" class="form-control" name="pedido_peso_reg" id="pedido_peso_reg" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="pedido_peso_reg" class="bmd-label-floating">Precio del paquete <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" class="form-control" name="pedido_precio_reg" id="pedido_precio_reg" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="pedido_utilidad_reg" class="bmd-label-floating">Utilidad del paquete <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" class="form-control" name="pedido_utilidad_reg" id="pedido_utilidad_reg" maxlength="20" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset> 
        <br><br>
        <fieldset>
            <legend><i class="fas fa-map-marked-alt"></i> &nbsp; Información de entrega</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="pedido_pais_reg" class="bmd-label-floating">Pais <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" class="form-control" name="pedido_pais_reg" id="pedido_pais_reg" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="form-group">
                            <label for="pedido_direccion_reg" class="bmd-label-floating">Dirección <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" class="form-control" name="pedido_direccion_reg" id="pedido_direccion_reg" maxlength="30">
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
<script>
    $(document).ready(function() {

        $("#pedido_precio_reg").change(function(){
            
            var cantidad = $("#pedido_peso_reg").val();
            var precio = $("#pedido_precio_reg").val();
            var total = cantidad * precio;

            $("#pedido_utilidad_reg").val(total);
        });

        $("#pedido_peso_reg").change(function(){
            
            var cantidad = $("#pedido_peso_reg").val();
            var precio = $("#pedido_precio_reg").val();
            var total = cantidad * precio;

            $("#pedido_utilidad_reg").val(total);
        });

        var today = new Date();
        var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
        var fecha = date;
        $("#pedido_fecha_reg").val(fecha);

        $(document).on('change','select',function(){
            var id = this.id;
            var value = $(this).val();
            if(id === "pedido_cliente_reg"){
                $.post("../ajax/ventaAjax.php?op=buscarcliente", {
                    id: $(this).val()
                    },
                    function(data) {
                        if (data != 'null') {
                            var val = JSON.parse(data);
                            $("#pedido_precio_asig_reg").val(val[7]);
                            $("#pedido_vendedor_reg").val(val[6]);
                            $("#pedido_vendedor_id_reg").val(val[5]);
                            $("#pedido_correo_reg").val(val[4]);

                            var peso = $('#pedido_peso_reg').val();
                            
                        } else {
                            console.log("dio error")
                        }
                    } 
                );
            }
        });
    });
</script>