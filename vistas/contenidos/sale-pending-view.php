<div class="full-box page-header" style="background-color: #f4f6f9;">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("venta_pending","encabezado",0); ?>
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
    <div class="card" style="border: none; box-shadow:none; padding:15px">    
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="sale_rute">Filtrar por:</label>
                        <select class="form-control" name="sale_rute" id="sale_rute">
                            <option value="" selected="" >Seleccione una ruta</option>
                            <?php
                                echo $lc->generar_select(RUTA,"VACIO");
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="cliente_vendedor" class="bmd-label-floating">Vendedor asignado <?php echo CAMPO_OBLIGATORIO; ?></label>
                        <select class="form-control" name="cliente_vendedor" id="cliente_vendedor">
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
                        <button id="sale_filtro" style="background-color: #047b14; border:none; padding:10px; color:#f4f6f9; margin-top:20px; border-radius:5px">
                            <i class="fas fa-filter"></i>
                            APLICAR FILTRO
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div id="tableout">
            <table id="dtpe-pendiente" class="table table-bordered display responsive nowrap" style="border:none" cellspacing="0" width="100%">
                <thead class=" thead">
                    <tr class="text-center" style="background:#0085b2; color: white;">
                        <th style="font-weight:normal;" id="check"></th>
                        <th style="text-align: left; font-size:14px">NRO. TRACKING</th>
                        <th style="text-align: left; font-size:14px">CLIENTE</th>
                        <th style="text-align: left; font-size:14px">TELEFONO</th>
                        <th style="text-align: left; font-size:14px">DIRECCIÓN</th>
                        <th style="text-align: left; font-size:14px">MAPS</th>
                        <th style="text-align: left; font-size:14px">RUTA</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        var table = listar("", "");
    });

    $("#sale_filtro").click(function () {
        var ruta = $("#sale_rute").val();
        var vendedor = $("#cliente_vendedor").val();
        if(vendedor == "Selecciona una opción"){
            vendedor = "";
        }

        if(ruta == ""){
            ruta = "";
        }
        else{
            if(ruta == "Ruta 1"){
                ruta = 1;
            }
            else if(ruta == "Ruta 2"){
                ruta = 2;
            }
            else if(ruta == "Ruta 3"){
                ruta = 3;  
            }
            else if(ruta == "Ruta 4"){
                ruta = 4; 
            }
            else if(ruta == "Ruta 5"){
                ruta = 5;
            }
            else{
                ruta = 6;
            }
        }
        var table = listar(ruta, vendedor);
    });

    function listar(ruta, vendedor) {
        return table = $('#dtpe-pendiente').DataTable({
            'destroy': true,
            'ajax': '../ajax/ventaAjax.php?op=pendiente&vendedor='+vendedor+'&ruta='+ruta,
            'language': {
                'url': '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
            },
            'columnDefs': [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }], 
            'dom': 'Bfrtip',
            'buttons': [{
                'text': 'Aprobar entrega pendiente',
                'className': 'btn btn-default btn-xs',
                action: function(e, dt, node, config) {
                    var rows_selected = table.column(0).checkboxes.selected();
                    var id="id=";
                    $.each(rows_selected, function(index, rowId) {
                        if(index === 0){
                            id += rowId;
                        }
                        else{
                            id +=","+rowId;
                        }
                    });
                    window.location.href ="http://localhost/SVIL/sale-sending?"+id;
                }
            }],
            'responsive': true,
            'bFilter': true,
            'select': {
                'style': 'multi'
            },
            'iDisplayLength': 10,
            'paging': true,
            'info': true
        });
    }
</script>
<?php
	include "./vistas/inc/print_invoice_script.php";
?>