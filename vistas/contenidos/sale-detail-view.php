<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("venta_detail", "encabezado", 0); ?>
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
        <div class="container-fluid form-neon" style="border: none; box-shadow:none; padding:15px">
        <?php
            include "./vistas/inc/btn_go_back.php";
            $datos_venta = $lc->datos_tabla("Normal", "venta INNER JOIN cliente ON venta.cliente_codigo=cliente.cliente_codigo INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id INNER JOIN caja ON venta.caja_id=caja.caja_id WHERE (venta_codigo='" . $pagina[1] . "')", "*", 0);
            if ($datos_venta->rowCount() == 1) {
                $datos_venta = $datos_venta->fetch();
            ?>
            <h4 class="text-center">Datos de venta</h4>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <p class="text-center text-uppercase font-weight-bold" style="background:#00a2d9; color: white; padding:5px;">Datos del pedido</p>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tipo de carga
                                <span><?php echo $datos_venta['venta_carga_tipo']; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Fecha de llegada
                                <span><?php echo date("d-m-Y", strtotime($datos_venta['venta_fecha'])); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Nro. de factura
                                <span><?php echo $datos_venta['venta_id']; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Nro. de tracking
                                <span><?php echo $datos_venta['venta_codigo']; ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-4">
                        <p class="text-center text-uppercase font-weight-bold " style="background:#00a2d9; color: white; padding:5px;">Vendedor & usuario</p>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Vendedor
                                <span><?php echo $datos_venta['usuario_nombre'] . " " . $datos_venta['usuario_apellido']; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Cliente
                                <span><?php echo $datos_venta['cliente_nombre']; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Telefono del cliente
                                <span><a href='https://api.whatsapp.com/send?phone=+507' .<?php echo $datos_venta['cliente_telefono']; ?>.'&text=Hola!%20Quiero%20generar%20mas%20ventas' target="_blank"><?php echo $datos_venta['cliente_telefono']; ?></a></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Dirección
                                <span><?php echo $datos_venta['cliente_direccion']; ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-4">
                        <p class="text-center text-uppercase font-weight-bold " style="background:#00a2d9; color: white; padding:5px;">Totales & estado</p>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Estado del pedido
                                <?php
                                $estado_pedido = "Entregado";
                                if ($datos_venta['venta_estado_pedido'] == "Pendiente") {
                                    $estado_pedido = "Por entregar";
                                }
                                echo '<span class="badge badge-warning" style="font-size:15px">' . $estado_pedido . '</span>';
                                ?>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Estado del pago
                                <?php
                                $estado_pagado = "Pagado";
                                if ($datos_venta['venta_estado_pagado'] == "Pendiente") {
                                    $estado_pagado = "Pendiente de pago";
                                }
                                echo '<span class="badge badge-warning" style="font-size:15px">' . $estado_pagado . '</span>'; ?>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Peso del paquete
                                <span>
                                    <?php 
                                        echo $datos_venta['venta_peso'].' LB'; 
                                    ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Precio de cliente
                                <span><?php echo MONEDA_SIMBOLO . number_format($datos_venta['venta_precio_cliente'], MONEDA_DECIMALES, MONEDA_SEPARADOR_DECIMAL, MONEDA_SEPARADOR_MILLAR) . ' ' . MONEDA_NOMBRE; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Precio de venta
                                <span><?php echo MONEDA_SIMBOLO . number_format($datos_venta['venta_precio_venta'], MONEDA_DECIMALES, MONEDA_SEPARADOR_DECIMAL, MONEDA_SEPARADOR_MILLAR) . ' ' . MONEDA_NOMBRE; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Delivery
                                <span class="badge badge-warning" style="font-size:15px"><?php echo MONEDA_SIMBOLO . number_format($datos_venta['venta_delivery'], MONEDA_DECIMALES, MONEDA_SEPARADOR_DECIMAL, MONEDA_SEPARADOR_MILLAR) . ' ' . MONEDA_NOMBRE; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total
                                <span class="badge badge-warning" style="font-size:15px"><?php echo MONEDA_SIMBOLO . number_format($datos_venta['venta_total_final'], MONEDA_DECIMALES, MONEDA_SEPARADOR_DECIMAL, MONEDA_SEPARADOR_MILLAR) . ' ' . MONEDA_NOMBRE; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr style="margin:15px 0; ">
            <h4 class="text-center">Pagos realizados</h4>
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="bg-primary">
                            <tr class="text-center text-uppercase" style="background:#00a2d9; color: white;">
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Referencia</th>
                                <th scope="col">Vendedor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $datos_pago = $lc->datos_tabla("Normal", "pago INNER JOIN usuario ON pago.usuario_id=usuario.usuario_id INNER JOIN caja ON pago.caja_id=caja.caja_id WHERE (pago.venta_codigo='" . $datos_venta['venta_codigo'] . "')", "*", 0);
                            if ($datos_pago->rowCount() >= 1) {
                                $datos_pago = $datos_pago->fetchAll();
                                $cc = 1;
                                foreach ($datos_pago as $pago) {
                                    echo '
                                    <tr class="text-center text-uppercase">
                                        <th style="font-size:14px;" scope="row">' . $cc . '</th>
                                        <td style="font-size:14px;" >' . date("d-m-Y", strtotime($pago['pago_fecha'])) . '</td>
                                        <td style="font-size:14px;" >' . MONEDA_SIMBOLO . number_format($pago['pago_monto'], MONEDA_DECIMALES, MONEDA_SEPARADOR_DECIMAL, MONEDA_SEPARADOR_MILLAR) . ' ' . MONEDA_NOMBRE . '</td>
                                        <td style="font-size:14px;" >' . $pago['pago_referencia'] . '</td>,
                                        <td style="font-size:14px;" >' . $pago['usuario_nombre'] . " " . $pago['usuario_apellido'] . '</td>
                                    </tr>
                                    ';
                                    $cc++;
                                }
                            } else {
                                echo '<tr class="text-center text-uppercase"><td colspan="7">No hay datos para mostrar</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($datos_venta['venta_estado_pagado'] == "Pendiente") { ?>
                    <p class="text-center">
                        <button type="button" class="btn btn-primary btn-raised" href="#" data-toggle="modal" data-target="#ModalAddPayment" style="background:#047b14; color: white;">
                            <i class="fas fa-money-bill-wave fa-fw"></i> &nbsp; Agregar un nuevo pago
                        </button>
                    </p>
                <?php } ?>
            </div>

            <!-- Modal AddPayment -->
            <div class="modal fade" id="ModalAddPayment" tabindex="-1" role="dialog" aria-labelledby="ModalAddPayment" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form class="modal-content FormularioAjax" action="<?php echo SERVERURL; ?>ajax/ventaAjax.php" method="POST" data-form="save" autocomplete="off">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalAddPayment">Realizar pago de venta Nro.<?php echo $datos_venta['venta_id'] . " (" . $datos_venta['venta_codigo']; ?>)</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="pago_codigo_reg" value="<?php echo $datos_venta['venta_codigo']; ?>">
                            <input type="hidden" id="pago_total_pendiente" value="<?php echo number_format(($venta_saldo_pendiente), MONEDA_DECIMALES, '.', ''); ?>">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="pago_caja">Metodo de pago</label>
                                            <select class="form-control" name="pago_metodo" id="pago_metodo" required>
                                                <option value="" selected="">Seleccione una opción</option>
                                                <?php
                                                    echo $lc->generar_select(METODO_PAGO, "VACIO");
                                                ?>
                                            </select>
                                            <input type="text" id="pago_cliente" name="pago_cliente" value="<?php echo $datos_venta['cliente_codigo']; ?>" hidden />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="pago_pendiente">Pendiente</label>
                                            <?php
                                                error_reporting(0);
                                                error_reporting(E_ERROR | E_WARNING | E_PARSE);
                                                $pagado = 0;
                                                $saldo_venta = $lc->datos_tabla("Sum", "pago", "venta_codigo", $datos_venta['venta_codigo']);
                                                if ($saldo_venta->rowCount() == 1) {
                                                    $saldo_venta = $saldo_venta->fetch();
                                                    $pagado = $saldo_venta['pagado'];
                                                }
                                                $pendiente = number_format($datos_venta['venta_total_final'],2) - number_format($pagado,2);
                                            ?>
                                            <input type="text" class="form-control" value="<?php echo number_format(($pendiente), MONEDA_DECIMALES, '.', ''); ?>" name="pago_pendiente" id="pago_pendiente" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="pago_monto">Monto</label>
                                            <input type="text" class="form-control" id="pago_monto" name="pago_monto_reg" pattern="[0-9.]{1,25}" maxlength="25" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="pago_referencia">Referencia</label>
                                            <input type="text" class="form-control" id="pago_referencia" name="pago_referencia_reg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> &nbsp; Cancelar</button>
                            <button type="submit" class="btn btn-info"><i class="fas fa-money-bill-wave fa-fw"></i> &nbsp; Agregar pago</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                /*----------  Calcular cambio  ----------*/
                let pago_abono_input = document.querySelector("#pago_monto");

                pago_abono_input.addEventListener('keyup', function(event) {
                    event.preventDefault();

                    let abono = document.querySelector('#pago_monto').value;
                    abono = abono.trim();
                    abono = parseFloat(abono);

                    let total = document.querySelector('#pago_total_pendiente').value;
                    total = total.trim();
                    total = parseFloat(total);

                    if (abono >= total) {
                        cambio = abono - total;
                        cambio = parseFloat(cambio).toFixed(2);
                        document.querySelector('#pago_cambio').value = cambio;
                    } else {
                        document.querySelector('#pago_cambio').value = "0.00";
                    }
                });


                /*----------  Hacer devolucion  ----------*/
                function devolucion_producto(producto, descripcion) {
                    producto.trim();
                    descripcion.trim();

                    document.querySelector('#devolucion_producto').value = producto;
                    document.querySelector('#devolucion_descripcion').innerHTML = descripcion;

                    $('#ModalReturn').modal('show');
                }
            </script>
        <?php
    } else {
        include "./vistas/inc/error_alert.php";
        echo '<p class="text-center">*** Es posible que la venta haya sido eliminada del sistema ***</p>';
    }
        ?>
        </div>
</div>