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
    <div class="form-neon" style="border: none; box-shadow:none; padding:15px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="alert alert-light text-center" role="alert" style="font-size: 14px;">
                        <p>Está utilizando la <strong class="text-uppercase">configuración de carga automática</strong> de ventas </p>
                        <hr>
                    </div>
                    <label>Nota: Para realizar la carga manual de clientes, favor seguir las siguientes indicaciones: </label>
                    <ul>
                        <li>El formato del archivo a cargar debe ser .csv <span><a href='<?php echo SERVERURL; ?>archivos/Formulario_de_pedidos.xlsx' download="FormularioPedido.csv"> &nbsp; <i class="fas fa-download"></i> &nbsp; Clic para descargar un ejemplo</a></span></li>
                        <li>El archivo debe estar delimitado por coma (,) y debe seguir el mismo formato de columnas</li>
                        <li>Una ves seleccionado el archivo le da en procesar archivo y podra visializar la información</li>
                    </ul>
                    <br/>
                    <div class="row">
                        <div class="col-6 col-lg-6">
                            <input name="file" type="file" id="fileUpload" accept=".xlsx"/>
                            <button type="submit" class="btn btn-raised btn-info btn-sm" id="venta_procesar"><i class="far fa-save"></i> &nbsp; PROCESAR ARCHIVO</button>
                        </div>
                        <div class="col-6 col-lg-6">
                            <p class="text-right">
                                <a href="<?php echo SERVERURL."sale-manual/";?>" class="btn btn-raised btn-info">
                                    <i class="fas fa-save"></i> &nbsp; AGREGAR VENTA MANUAL 
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="progress" style="display:none; height: 15px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; background-color:#29b016" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                    <br/>
                    <div class="information" style="display:none;">              
                        <div class="alert alert-info">Se realizo la carga con exito</div>
                    </div>
                    <div class="table-responsive">
                        <div id="tablefail">
                            <table id="dtpe-cliente" class="table" cellspacing="0" width="100%">
                                <thead class=" thead">
                                    <tr class="text-center" style="background:#0085b2; color: white;">
                                        <th style="text-align: left;">Cliente</th>
                                        <th style="text-align: left;">ID Cliente</th>
                                        <th style="text-align: left;">Tracking</th>
                                        <th style="text-align: left;">Peso</th>
                                        <th style="text-align: left;">Precio</th>
                                        <th style="text-align: left;">P. Cliente</th>
                                        <th style="text-align: left;">P. Venta</th>
                                        <th style="text-align: left;">ID Vendedor</th>
                                        <th style="text-align: left;">Vendedor</th>
                                        <th style="text-align: left;">Delivery</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="tableid"></div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <p class="text-right">
                                <button type="submit" class="btn btn-raised btn-info btn-sm" id="cargar_venta"><i class="far fa-save"></i> &nbsp; Cargar información</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
<script src="<?php echo SERVERURL; ?>vistas/js/xlsx.full.min.js?v=<?php echo time(); ?>"></script>
<script>
    $(document).ready(function() {

        $("#venta_procesar").hide();
        $("#cargar_venta").hide();
        $("#fileUpload").show();
        $("#tablefail").show();

        $('input[name=file]').change(function() {
            $("#venta_procesar").show();
        });

        $("#cargar_venta").click(function () {
            $("#table-new").hide();
            $("#cargar_venta").hide();
            $(".progress").show();

            var today = new Date();
            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            var fecha = date;
            var campo1, campo2, campo3, campo4, campo5, campo6, campo7, campo8, campo9, campo10, campo11;
            var i = 0;
            $("#table-new tr").each(function (index) {
                 $(this).children("td").each(function (index2) {
                     switch (index2) {
                        case 0:
                             campo1 = $(this).text();
                             break;
                        case 1:
                            campo2 = $(this).text();
                            break;
                        case 2:
                            campo3 = $(this).text();
                            break;
                        case 3:
                            campo4 = $(this).text();
                            break;
                        case 4:
                            campo5 = $(this).text();
                            break;
                        case 5:
                            campo6 = $(this).text();
                            break;
                        case 6:
                            campo7 = $(this).text();
                            break;
                        case 7:
                            campo8 = $(this).text();
                            break;
                        case 8:
                            campo9 = $(this).text();
                            break;
                        case 9:
                            campo10 = $(this).text();
                            break;
                        case 10:
                            campo11 = $(this).find("input").get().map(function(input) {
                                return input.value
                            })
                            break;    
                    }
                })

                var percent = 0;
                timerId = setInterval(function() {
                    percent += 5;
                    $('.progress-bar').css('width', percent+'%');
                    $('.progress-bar').attr('aria-valuenow', percent);
                    $('.progress-bar').text(percent+'%');        
                    if (percent == 100) {
                        clearInterval(timerId);
                        $('.information').show();
                        $(".progress").hide();
                    }
                }, 1000);

                if(i > 0){
                    $.post("../ajax/ventaAjax.php?op=salvarventa", {
                            carga: campo3, 
                            tracking: campo4,
                            peso: campo5,
                            precio: campo6,
                            precio_cliente: campo7,
                            precio_venta: campo8,
                            cliente: campo2,
                            vendedor_id: campo9,
                            fecha: fecha,
                            delivery: campo11[0]
                        },
                        function(data) {
                            if (data != 'null') {
                                console.log(data);
                            } else {
                                console.log("dio error")
                            }
                        }
                    );
                }
                i++;
            })
            $.post("../ajax/ventaAjax.php?op=enviarcorreo",
                function(data) {
                    if (data != 'null') {
                        console.log(data);
                    } else {
                        console.log("dio error")
                    }
                }
            );
        })

        $(document).on('change','select',function(){
            var id = this.id;
            var value = $(this).val();
            $.post("../ajax/ventaAjax.php?op=buscarcliente", {
                id: $(this).val()
                },
                function(data) {
                    if (data != 'null') {
                        var val = JSON.parse(data);
                        $('#tableid').each(function() { 
                            var total = 0;
                            var peso = $(this).find('#peso_'+id).text();
                            total = peso * val[7];

                            var totalfinal = parseFloat(Math.round(total * 100) / 100).toFixed(2);
                            $("#precio_venta_"+id).html(totalfinal);
                        });

                        $("#precio_cliente_"+id).html(val[7]);
                        $("#nombre_"+id).html(val[1]);
                        $("#cliente_id_"+id).html(value);
                        $("#vendedor_id_"+id).html(val[5]);
                        $("#vendedor_"+id).html(val[6]);
                    } else {
                        console.log("dio error")
                    }
                } 
            );
        });

        var _select = $.ajax({type: "POST", url: "../ajax/ventaAjax.php?op=listar", async: false}).responseText;
        $("#venta_procesar").click(function(e) { 
            $("#cargar_venta").show();
            $("#venta_procesar").hide();
            $("#fileUpload").hide();
            $("#tablefail").hide();

            e.preventDefault();

            var formData = new FormData();
            formData.append('excelfile', $('input[type=file]')[0].files[0]); 
            
            var file = $.ajax({
                type: 'POST',
                url: 'http://localhost/SVIL/ajax/ventaAjax.php?op=cargarexcel',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                async: false
            }).responseText;

            var percent = 0;
            timerId = setInterval(function() {
                percent += 5;
                if (percent == 100) {
                    clearInterval(timerId);
                }
            }, 1000);
            
            var url = "http://localhost/SVIL/upload/file.xlsx";
            var oReq = new XMLHttpRequest();
            oReq.open("GET", url, true);
            oReq.responseType = "arraybuffer";

            oReq.onload = function(e) {
                var arraybuffer = oReq.response;

                var data = new Uint8Array(arraybuffer);
                var arr = new Array();
                for(var i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
                var bstr = arr.join("");

                var workbook = XLSX.read(bstr, {type:"binary"});
                var first_sheet_name = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[first_sheet_name];
                console.log(XLSX.utils.sheet_to_json(worksheet,{raw:true}));
                
                var i = 0;
                var tbody = $("<table id='table-new' class='table table-sm table-striped'/>");
                
                $.each(XLSX.utils.sheet_to_json(worksheet,{raw:true}), function(index, item) {

                    
                    if (i == 0){ 
                        var row = $("<tr id="+i+" style='background:#00a2d9; color: white; text-align: left;' />");
                        var cell = $("<td id='cliente' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                        cell.html("Cliente");
                        row.append(cell);

                        var cell = $("<td id='cliente_id' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                        cell.html("ID Cliente");
                        row.append(cell);

                        var cell = $("<td id='carga' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                        cell.html("Tracking");
                        row.append(cell);

                        var cell = $("<td id='tracking' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                        cell.html("Tracking");
                        row.append(cell);

                        var cell = $("<td id='peso' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                        cell.html("Peso");
                        row.append(cell);

                        var cell = $("<td id='precio' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                        cell.html("Precio");
                        row.append(cell);

                        var cell = $("<td id='precio_cliente' class='"+i+"' style='text-align: left; font-size: 14px;' />");
                        cell.html("P. Cliente");
                        row.append(cell);

                        var cell = $("<td id='precio_venta' class='"+i+"' style='text-align: left; font-size: 14px;' />");
                        cell.html("P. Venta");
                        row.append(cell);

                        var cell = $("<td id='vendedor_id' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                        cell.html("ID Vendedor");
                        row.append(cell);

                        var cell = $("<td id='vendedor' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                        cell.html("Vendedor");
                        row.append(cell);

                        var cell = $("<td id='delivery' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                        cell.html("Delivery");
                        row.append(cell);

                        tbody.append(row);
                        $("#tableid").html('');
                        $("#tableid").append(tbody);
                    }

                    var selectinput = "";
                    var selectinput = '<select id='+i+' class="form-control select '+i+' selectpicker"><option>Seleccione</option>';
                    var row = $("<tr id="+i+"/>");

                    var cell = $("<td id='cliente_"+i+"' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                    cell.html(selectinput + _select);
                    row.append(cell);

                    var cell = $("<td id='cliente_id_"+i+"' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                    cell.html("");
                    row.append(cell);

                    var cell = $("<td id='carga_"+i+"' class='"+i+"' style='text-align: left; font-size: 14px;'/>");
                    cell.html(item['TipoCarga']);
                    row.append(cell);

                    var cell = $("<td id='tracking_"+i+"' class='"+i+"' style='text-align: left; font-size: 14px;'/>");
                    cell.html(item['Tracking']);
                    row.append(cell);

                    var cell = $("<td id='peso_"+i+"' class='"+i+"' style='text-align: left; font-size: 14px;'/>");
                    cell.html(item['Peso']);
                    row.append(cell);

                    var cell = $("<td id='precio_"+i+"' class='"+i+"' style='text-align: left; font-size: 14px;'/>");
                    cell.html(item['Precio']);
                    row.append(cell);

                    var cell = $("<td id='precio_cliente_"+i+"' class='"+i+"' style='text-align: left; font-size: 14px;' />");
                    cell.html("");
                    row.append(cell);

                    var cell = $("<td id='precio_venta_"+i+"' class='"+i+"' style='text-align: left; font-size: 14px;' />");
                    cell.html("");
                    row.append(cell);

                    var cell = $("<td id='vendedor_id_"+i+"' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                    cell.html("");
                    row.append(cell);

                    var cell = $("<td id='vendedor_"+i+"' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                    cell.html("");
                    row.append(cell); 

                    var cell = $("<td id='delivery_"+i+"' style='text-align: left; font-size: 14px;' class='"+i+"'/>");
                    cell.html("<input type='number' style=' width:100px' value='0.00'/>");
                    row.append(cell); 
                    
                    tbody.append(row);
                    i++;
                }); 
                $("#tableid").html('');
                $("#tableid").append(tbody);

            }
            oReq.send();
        });
    });
</script>