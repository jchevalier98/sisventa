<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php
            echo $lc->enrutador("venta_new","encabezado",0);
        ?>
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
    <div class="form-neon" style="border: none; box-shadow:none; padding:15px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="alert alert-light text-center" role="alert" style="font-size: 14px;">
                        <p>Está utilizando la <strong class="text-uppercase">configuración de carga automática</strong> de clientes </p>
                        <hr>
                    </div> 
                    <label>Nota: Para realizar la carga manual de clientes, favor seguir las siguientes indicaciones: </label>
                    <ul>
                        <li>El formato del archivo a cargar debe ser .csv <span><a href='<?php echo SERVERURL; ?>archivos/Formulario_de_clientes.csv' download="FormularioClientes.csv"> &nbsp; <i class="fas fa-download"></i> &nbsp; Clic para descargar un ejemplo</a></span></li>
                        <li>El archivo debe estar delimitado por coma (,) y debe seguir el mismo formato de columnas</li>
                        <li>Una ves seleccionado el archivo le da en procesar archivo y podra visializar la información</li>
                    </ul>
                    <div class="row">
                        <div class="col-6 col-lg-6">
                            <input name="file" type="file" id="fileUpload" accept=".csv"/>
                            <button type="submit" class="btn btn-raised btn-info btn-sm" id="venta_procesar"><i class="far fa-save"></i> &nbsp; PROCESAR ARCHIVO</button>
                        </div>
                        <div class="col-6 col-lg-6">
                            <p class="text-right">
                                <a href="<?php echo SERVERURL."client-new/";?>" class="btn btn-raised btn-info">
                                    <i class="fas fa-save"></i> &nbsp; AGREGAR CLIENTE MANUAL 
                                </a>
                            </p>
                        </div>
                    </div>
                    <br/>
                    <div id="content"></div>
                    <div class="table-responsive">
                        <div id="tablefail">
                            <table id="dtpe-cliente" class="table" cellspacing="0" width="100%">
                                <thead class=" thead">
                                    <tr class="text-center" style="background:#00a2d9; color: white;">
                                        <th style="text-align: left;">Cedula</th>
                                        <th style="text-align: left;">Nombre</th>
                                        <th style="text-align: left;">Dirección</th>
                                        <th style="text-align: left;">Telefono</th>
                                        <th style="text-align: left;">Estado</th>
                                        <th style="text-align: left;">WebSite</th>
                                        <th style="text-align: left;">Precio Asig.</th>
                                        <th style="text-align: left;">Cumpleaños</th>
                                        <th style="text-align: left;">Email</th>
                                        <th style="text-align: left;">Venedor</th>
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
<script>
    
    $(document).ready(function() {
        //$('#content').html('<div style="display: table; margin: 0 auto;" class="loading"><img src="../vistas/assets/icons/spin.gif" alt="loading" /><br/>Un momento, por favor...</div>');
        $("#venta_procesar").hide();
        $("#cargar_venta").hide();
        $("#fileUpload").show();
        $("#tablefail").show();

        $('input[name=file]').change(function() {
            $("#venta_procesar").show();
        });

        var id_client = $.ajax({type: "POST", url: "../ajax/clienteAjax.php?op=obtenerid", async: false}).responseText;
        $("#cargar_venta").click(function () {
            var campo1, campo2, campo3, campo4, campo5, campo6, campo7, campo8, campo9, campo10;
            var i = 0;
            $("#tableid tr").each(function (index) {
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
                    }
                })
                if(i > 0){
                    var codigo = "";
                    id_client++;
                    if(id_client <= 9){
                        codigo = "C000" + id_client;
                    }
                    else if(id_client > 9 && id_client <= 99){
                        codigo = "C00" + id_client;
                    }
                    else if(id_client > 99 && id_client <= 999){
                        codigo = "C0" + id_client;
                    }
                    else if(id_client > 999 && id_client <= 9999){
                        codigo = "C" + id_client;
                    }

                    $.post("../ajax/clienteAjax.php?op=cargar", {
                        cliente_id: codigo,
                        cedula: campo1,
                        nombre: campo2,
                        direccion: campo3,
                        telefono: campo4,
                        estado: campo5,
                        website: campo6,
                        precio: campo7,
                        cumpleano: campo8,
                        mail: campo9,
                        vendedor: campo10
                    },
                    function(data) {
                        if (data != 'null') {
                            console.log("-> " + data);
                        } else {
                            console.log("dio error")
                        }
                    });
                }
                i++;
            })
            window.location.href ="http://localhost/SVIL/client-list/";
        })

        $("#venta_procesar").click(function(e) { 
            $("#cargar_venta").show();
            $("#venta_procesar").hide();
            $("#fileUpload").hide();
            $("#tablefail").hide();

            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt|.xlsx)$/;
            if (regex.test($("#fileUpload").val().toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var tbody = $("<table class='table table-sm table-striped'/>");
                        var rows = e.target.result.split("\n");
                        for (var i = 0; i < rows.length; i++) {
                            var selectinput = "";
                            if(i == 0){
                                var row = $("<tr id="+i+" style='background:#00a2d9; color: white; text-align: left;' />");
                            }
                            else{
                                var row = $("<tr id="+i+"/>");
                            }
                            var cells = rows[i].split(",");
                            if (cells.length > 1) {
                                for (var j = 0; j < cells.length; j++) {
                                    var cell = $("<td class='colum_"+i+"' style='text-align: left; font-size: 14px;'/>");
                                    cell.html(cells[j]);
                                    row.append(cell);
                                }
                                tbody.append(row);
                            }
                        }
                        $("#tableid").html('');
                        $("#tableid").append(tbody);
                    }
                    reader.readAsText($("#fileUpload")[0].files[0]);
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid CSV file.");
            }
        });
    });
</script>
<?php
	include "./vistas/inc/print_invoice_script.php";
?>