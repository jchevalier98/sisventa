<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("cliente_detail","encabezado",0); ?>
    </h3>
</div>
<div class="container-fluid form-neon">
    <?php
        include "./vistas/inc/btn_go_back.php";
    ?>
    <h4 class="text-center">Datos de venta</h4>
    <div class="container-fluid">
        <div class="row"> 
            <div class="col-12 col-lg-4">
                <p class="text-center text-uppercase font-weight-bold" style="background:#00a2d9; color: white;">Datos del
                    pedido</p>
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
                <p class="text-center text-uppercase font-weight-bold " style="background:#00a2d9; color: white;">Vendedor
                    & usuario</p>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Vendedor
                        <span><?php echo $datos_venta['usuario_nombre']." ".$datos_venta['usuario_apellido']; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cliente
                        <span><?php echo $datos_venta['cliente_nombre']; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Telefono del cliente
                        <span><a href='https://api.whatsapp.com/send?phone=+507'
                                .<?php echo $datos_venta['cliente_telefono'];?>.'&text=Hola!%20Quiero%20generar%20mas%20ventas'
                                target="_blank"><?php echo $datos_venta['cliente_telefono'];?></a></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Dirección
                        <span><?php echo $datos_venta['cliente_direccion']; ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-lg-4">
                <p class="text-center text-uppercase font-weight-bold " style="background:#00a2d9; color: white;">Totales &
                    estado</p>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Estado
                        <?php
                            echo '<span class="badge badge-warning" style="font-size:15px">'.$datos_venta['venta_estado'].'</span>';
                        ?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Peso del paquete
                        <span><?php echo number_format($datos_venta['venta_peso'],).' LB'; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Precio de cliente
                        <span><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_precio_cliente'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Costo base
                        <span><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total a pagar
                        <span><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_precio_venta'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Utilidad
                        <span class="badge badge-warning"
                            style="font-size:15px"><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_precio_venta'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>