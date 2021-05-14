<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("movimiento_list","encabezado",0); ?>
    </h3>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
        <li class="active"><?php echo $lc->enrutador("movimiento_list", "lista", 0); ?></li>
        <li><a class="btn btn-info">/</a></li>
        <li><?php echo $lc->enrutador("movimiento_pending_list", "lista", 0); ?></li>
	</ul>
</div>
 
<div class="container-fluid">
    <div class="card" style="border: none; box-shadow:none; padding:15px">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <h4>Facturas canceladas</h4>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="fecha_inicio" >Fecha inicial (día/mes/año)</label>
                        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" maxlength="30">
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="fecha_final" >Fecha final (día/mes/año)</label>
                        <input type="date" class="form-control" name="fecha_final" id="fecha_final" maxlength="30">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <button id="date_filtro" style="background-color: #047b14; border:none; padding:10px; color:#f4f6f9; margin-top:20px; border-radius:5px">
                            <i class="fas fa-filter"></i>
                            APLICAR FILTRO
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div id="table">
            <table id="dtpe-cliente" class="table table-bordered display responsive nowrap" style="border:none" cellspacing="0" width="100%">
                <thead class=" thead">
                    <tr class="text-center" style="background:#0085b2; color: white;">
                        <th style="text-align: left;">NRO.</th>
                        <th style="text-align: left;">COD. CLIENTE</th>
                        <th style="text-align: left;">CLIENTE</th>
                        <th style="text-align: left;"># TRACKING</th>
                        <th style="text-align: left;">FECHA DE FACT.</th>
                        <th style="text-align: left;">MONTO DE FACT.</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        listar("", "");
        $("#date_filtro").click(function () {
            var fecha_ini = $("#fecha_inicio").val();
            var fecha_fin = $("#fecha_final").val();
            if(fecha_fin == "" || fecha_ini == ""){
                alert("Las fechas inicial y final no pueden ser vacias");
            }
            else{
                listar(fecha_ini, fecha_fin);
            }
        });
 
        function listar(fecha_ini, fecha_fin) {
            return table = $('#dtpe-cliente')
            .dataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                aProcessing: true,
                aServerSide: true,
                ajax: {
                    url: '../ajax/ventaAjax.php?op=pagosrealizados&ini='+fecha_ini+'&fin='+fecha_fin,
                    type: "get",
                    dataType: "json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                bDestroy: true,
                dom: 'Bfrtip',
                columnDefs: [
                    { "orderable": false, "targets": [0,1,2,3,4,5]}
                ],
                iDisplayLength: 10,
                orderable: true,
                info: true
            })
            .DataTable();
        }
    });
</script>
</div>