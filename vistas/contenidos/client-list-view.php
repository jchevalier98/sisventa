<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("cliente_list", "encabezado", 0); ?>
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
    <div class="card" style="border: none; box-shadow:none; padding:15px">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="card-title" style="margin-top: 10px; margin-right:15px">Lista de
                        clientes</h3>
                </div>
            </div>
        </div>
        <br />
        <div id="table">
            <table id="dtpe-cliente" class="table table-bordered display responsive nowrap" style="border:none" cellspacing="0" width="100%">
                <thead class=" thead">
                    <tr class="text-center" style="background:#0085b2; color: white;">
                        <th style="text-align: left; font-size:14px; width:70px;">NRO.</th>
                        <th style="text-align: left; font-size:14px; width:70px;">TIPO</th>
                        <th style="text-align: left; font-size:14px; width:90px;">DOCUMENTO</th>
                        <th style="text-align: left; font-size:14px">NOMBRE</th>
                        <th style="text-align: left; font-size:14px; width:55px;">PRECIO ASIG.</th>
                        <th style="text-align: left; font-size:14px; width:55px;">M. PAGO</th>
                        <th style="text-align: left; font-size:14px">PAIS</th>
                        <th style="text-align: left; font-size:14px">DIRECCIÓN FISICA</th>
                        <th style="text-align: left; font-size:14px">GOOGLE MAPS</th>
                        <th style="text-align: left; font-size:14px">TELEFONO</th>
                        <th style="text-align: left; font-size:14px; width:60px">OPCIONES</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
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
                    url: '../ajax/clienteAjax.php?op=listar',
                    type: "get",
                    dataType: "json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                bDestroy: true,
                dom: 'Bfrtip',
                columnDefs: [
                    { "orderable": false, "targets": [0,1,2,3,4,5,6,7,8,9,10]}
                ],
                iDisplayLength: 10,
                orderable: true,
                info: true,
                order: [[ 3, "asc" ]]
            }) 
            .DataTable();
    });
</script>
</div>