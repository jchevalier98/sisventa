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
<div class="container-fluid" style="background-color: #f4f6f9;">
    <div class="full-box tile-container">
        <div class="row">
            <div class="col-12 col-md-7" style="background-color: #fff; margin: 0 auto; margin-top:50px;">
                <div class="card-header">
                    <h4 class="card-title" style="text-align: left;">Clientes con saldos pendientes</h4>
                </div>
                <br />
                <div id="table">
                    <table id="dtpe-cliente" class="table table-bordered display responsive nowrap" cellspacing="0" width="100%">
                        <thead class=" thead">
                            <tr class="text-center" style="background:#0085b2; color: white;">
                                <th style="text-align:left;">NRO.</th>
                                <th style="text-align:left;">COD. CLIENTE</th>
                                <th style="text-align:left;">CLIENTE</th>
                                <th style="text-align:left;">FECHA</th>
                                <th style="text-align:left;">MONTO</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div> 
            </div>

            <div class="col-12 col-md-5" style="background-color: #fff; margin: 0 auto; margin-top:50px;">
                <div class="card" style="border: none; box-shadow:none">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Realizar pagos</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="dtpe-pago" class="table table-bordered display responsive nowrap" cellspacing="0" width="100%">
                            <thead class="thead">
                                <tr class="text-center" style="background:#0085b2; color: white;">
                                    <th style="text-align:left;">NRO.</th>
                                    <th style="text-align:left;">CLIENTE</th>
                                    <th style="text-align:left;">MONTO</th>
                                </tr>
                            </thead>
                            <tbody id="pago"></tbody>
                        </table>
                        
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="producto_estado" class="bmd-label-floating" style="margin-top: 40px;">TOTAL A PAGAR:</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="total" >Total</label>
                                <input type="text" class="form-control" name="total" id="total" maxlength="30" value="0.00" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12">
                            <p class="text-right">
                                <button type="submit" class="btn btn-raised btn-info btn-sm" id="btn-total-pagar"><i class="far fa-save"></i> &nbsp; Procesar pago</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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
        $("#btn-total-pagar").click(function () {
            var idpago;
            var i = 0;
            $("#pago tr").each(function (index) {
                var campo1;
                $(this).children("td").each(function (index2) {
                    switch (index2) {
                        case 0:
                            campo1 = $(this).text().replace(" ", "");
                            break;
                    }
                })
                if(i == 0){
                    idpago = campo1;
                }
                else{
                    idpago = idpago + "," + campo1;
                }
                i++;
            });
            $.post("../ajax/ventaAjax.php?op=realizarpago", {
                    id: idpago
                },
                function(data) {
                    if (data != 'null') {
                        var table = listar("", "");
                        $("#total").val(0.00);
                        $("#total_label").val(0.00);
                        $('#pago').empty();
                        
                    } else {
                        console.log("dio error")
                    }
            });
        });

        $('#dtpe-cliente tbody').on( 'click', '.editor-active', function () {

            var data = table.row( this.closest('tr') ).data();
            var total = parseFloat(data[4].replace("$", ""));
            var total_input = parseFloat($("#total").val());
            if(this.checked==true)
            {
                $('#pago').append(`
                    <tr id="${data[0]}">
                        <td class="row-index" style="text-align: left;">
                            <span>${data[0]}</span>
                        </td>
                        <td class="row-index" style="text-align: left;">
                            <span>${data[2]}</span>
                        </td>
                        <td class="row-index" style="text-align: left;">
                            <span>${data[4]}</span>
                        </td>
                    </tr>`);

                total = total + total_input;                
                $("#total").val(total.toFixed(2));
                $("#total_label").val(total.toFixed(2));
            }
            else{
                $("#"+data[0]).remove();    
                total = total_input - total;                
                $("#total").val(total.toFixed(2)); 
                $("#total_label").val(total.toFixed(2));     
            }
        });


        function listar(fecha_ini, fecha_fin) {
            return table = $('#dtpe-cliente').DataTable({
                'destroy': true,
                'ajax': '../ajax/ventaAjax.php?op=pagospendiente&ini='+fecha_ini+'&fin='+fecha_fin,
                'language': {
                    'url': '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                },
                'columnDefs': [
                    {
                        'targets': 0,
                        render: function (data, type, row) {
                            if (type === 'display') {
                                return '<input type="checkbox" class="editor-active">';
                            }
                            return data;
                        },
                        className: "dt-body-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        targets: 1,
                        visible: false
                    }                         
                ], 
                'dom': 'Bfrtip',
                'buttons': [{
                    'text': '',
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
                    }
                }],
                'destroy': true,
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
    });
</script>
</div>