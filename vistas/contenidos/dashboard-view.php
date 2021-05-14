<?php

$fecha_inicial = new DateTime();
$fecha_inicial->modify('first day of this month');

$fecha_final = new DateTime();
$fecha_final->modify('last day of this month');

$inicial = $fecha_inicial->format('Y/m/d');
$final = $fecha_final->format('Y/m/d');

$fecha = new DateTime();
$fecha_dia = $fecha->format('Y/m/d');

$fecha_anterior_inicial = new DateTime();
$fecha_anterior_inicial->modify('first day of last month');
$inicial_anterior = $fecha_anterior_inicial->format('Y/m/d');

$fecha_anterior_final = new DateTime();
$fecha_anterior_final->modify('last day of last month');
$final_anterior = $fecha_anterior_final->format('Y/m/d');

$f_diario = "select IFNULL(sum(venta_total_final), 0) as f_diario from venta where venta_fecha = '$fecha_dia'";
?>
<div class="full-box page-header" style="background-color: #f4f6f9;">
    <h3 class="text-left">
        <i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
    </h3>
    <p class="text-justify">
        ¡Bienvenido <strong><?php echo $_SESSION['nombre_svi'] . " " . $_SESSION['apellido_svi']; ?></strong>! Este es el
        panel principal del sistema aqui podra encontrar del estado actual de su empresa.
    </p>
</div>
<div class="container-fluid" style="background-color: #f4f6f9;">
    <div class="full-box tile-container">
        <div class="row">
            <div class="col-xxl-3 col-lg-3">
                <div class="card bg-warning text-white mb-4" style="border: none; border-radius:30px; box-shadow:none; background: rgb(36,125,202); background: radial-gradient(circle, rgba(36,125,202,1) 0%, rgba(32,109,176,1) 87%, rgba(28,98,159,1) 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small" style="font-size: 18px;">Facturado hoy</div>
                                <div class="text-lg font-weight-bold" style="font-size: 22px;">
                                    <?php
                                    $facturado_d = 0.00;
                                    $facturado = $lc->datos_tabla("query", $f_diario, "", "");
                                    if ($facturado->rowCount() == 1) {
                                        $facturado = $facturado->fetchAll();
                                        foreach ($facturado as $rows) {
                                            $facturado_d = $rows['f_diario'];
                                        }
                                    }
                                    echo "$" . $facturado_d;
                                    ?>
                                </div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign feather-xl text-white-50">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-3">
                <div class="card bg-warning text-white mb-4" style="border: none; border-radius:30px; box-shadow:none; background: rgb(36,125,202); background: radial-gradient(circle, rgba(36,125,202,1) 0%, rgba(32,109,176,1) 87%, rgba(28,98,159,1) 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small" style="font-size: 18px;">Facturado este mes</div>
                                <div class="text-lg font-weight-bold" style="font-size: 22px;">
                                    <?php
                                    $f_mensual = 0;
                                    $fact_mensual = $lc->datos_tabla("query", "select IFNULL(sum(venta_total_final), 0) as f_mensual from venta where venta_fecha between '$inicial' and '$final'", null, null);
                                    if ($fact_mensual->rowCount() == 1) {
                                        $fact_mensual = $fact_mensual->fetchAll();
                                        foreach ($fact_mensual as $rows) {
                                            $f_mensual = $rows['f_mensual'];
                                        }
                                    }
                                    echo "$" . $f_mensual;
                                    ?>
                                </div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign feather-xl text-white-50">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-3">
                <div class="card bg-warning text-white mb-4" style="border: none; border-radius:30px; box-shadow:none; background: rgb(36,125,202); background: radial-gradient(circle, rgba(36,125,202,1) 0%, rgba(32,109,176,1) 87%, rgba(28,98,159,1) 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small" style="font-size: 18px;">Facturado mes anterior</div>
                                <div class="text-lg font-weight-bold" style="font-size: 22px;">
                                    <?php
                                    $f_mes_anterior = 0;
                                    $pago_diario = $lc->datos_tabla("query", "select IFNULL(sum(venta_total_final), 0) as f_mensual_anterior from venta where venta_fecha between '$inicial_anterior' and '$final_anterior'", null, null);
                                    if ($pago_diario->rowCount() == 1) {
                                        $pago_diario = $pago_diario->fetchAll();
                                        foreach ($pago_diario as $rows) {
                                            $f_mes_anterior = $rows['f_mensual_anterior'];
                                        }
                                    }
                                    echo "$" . $f_mes_anterior;
                                    ?>
                                </div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign feather-xl text-white-50">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-3">
                <div class="card bg-warning text-white mb-4" style="border: none; border-radius:30px; box-shadow:none; background: rgb(36,125,202); background: radial-gradient(circle, rgba(36,125,202,1) 0%, rgba(32,109,176,1) 87%, rgba(28,98,159,1) 100%);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small" style="font-size: 18px;">Mes anterior vs Mes actual</div>
                                <div class="text-lg font-weight-bold" style="font-size: 22px;">
                                    <?php
                                    $diferencia = $f_mensual - $f_mes_anterior;
                                    echo "$" . number_format($diferencia,2);
                                    ?>
                                </div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign feather-xl text-white-50">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <hr style="margin:15px 0; ">
            <div class="col-12 col-md-6" style="margin-top:50px;">
                <div class="card" style="border: none; box-shadow:none">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Facturado vs cobrado</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="200"></canvas>
                        </div>
                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Facturado
                            </span>
                            <span>
                                <i class="fas fa-square text-gray"></i> Cobrado
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6" style="background-color: #fff; margin: 0 auto; margin-top:50px;">
                <div class="card-header">
                    <h4 class="card-title" style="text-align: left;">Clientes con saldos pendientes</h4>
                </div>
                <br />
                <table id="dtpe-pendientepago" class="table table-bordered display responsive nowrap" style="border:none" cellspacing="0" width="100%">
                    <thead class=" thead">
                        <tr class="text-center" style="background:#00a2d9; color: white;">
                            <th style="text-align: left; font-size:14px">NRO.</th>
                            <th style="text-align: left; font-size:14px">NOMBRE COMPLETO</th>
                            <th style="text-align: left; font-size:14px">SALDO</th>
                            <th style="text-align: left; font-size:14px">CANT. DE PAQUETES</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: left;"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Chart-->
<script src="<?php echo SERVERURL; ?>vistas/js/Chart.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/js/dashboard.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        tabla = $('#dtpe-pendientepago')
            .dataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                aProcessing: true,
                aServerSide: true,
                responsive: true,
                ajax: {
                    url: '../ajax/clienteAjax.php?op=porpagar',
                    type: "get",
                    dataType: "json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                bDestroy: true,
                dom: 'Bfrtip',
                columnDefs: [{
                    "orderable": false,
                    "targets": [0, 1, 2, 3]
                }],
                iDisplayLength: 4,
                orderable: true,
                info: false,
                order: [[ 2, "desc" ]]
            })
            .DataTable();
    });
</script>