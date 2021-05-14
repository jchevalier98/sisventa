<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("usuario_list","encabezado",0); ?>
    </h3>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
        <li><?php echo $lc->enrutador("usuario_list", "lista", 0); ?></li>
        <li><a class="btn btn-info">/</a></li>
        <li class="active"><?php echo $lc->enrutador("usuario_new", "nuevo", 0); ?></li>
	</ul>
</div>

<div class="container-fluid">
    <div class="card" style="border: none; box-shadow:none; padding:15px">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="card-title" style="margin-top: 10px; margin-right:15px">Lista de
                        usuarios</h3>
                </div>
            </div>
        </div>
        <br />
        <div id="table">
            <table id="dtpe-cliente" class="table table-bordered display responsive nowrap" style="border:none" cellspacing="0" width="100%">
                <thead class="thead" style="border:none">
                    <tr class="text-center" style="background:#0085b2; color: white; border:none">
                        <th style="text-align: left;">NRO.</th>
						<th style="text-align: left;">DOCUMENTO</th>
						<th style="text-align: left;">NOMBRE</th>
						<th style="text-align: left;">USUARIO</th>
						<th style="text-align: left;">TELEFONO</th>
                        <th style="text-align: left;">CARGO</th>
                        <th style="text-align: left;">ESTADO</th>
						<th style="text-align: center; width:40px">ACT.</th>
                    </tr>
                </thead>
                <tbody style="border:none"></tbody>
            </table>
        </div>
    </div>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        tabla = $('#dtpe-cliente')
            .dataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                aProcessing: true,
                aServerSide: true,
                responsive: true,
                ajax: {
                    url: '../ajax/usuarioAjax.php?op=listar',
                    type: "get",
                    dataType: "json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                bDestroy: true,
                dom: 'Bfrtip',
                columnDefs: [
                    { "orderable": false, "targets": [0,1,2,3,4,5,6,7]}
                ],
                iDisplayLength: 10,
                orderable: true,
                info: true
            })
            .DataTable();
    });
</script>
</div>