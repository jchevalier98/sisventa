<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("sale_sending", "encabezado", 0); ?>
    </h3>
</div>

<div class="container-fluid">
    <div class="card" style="border: none; box-shadow:none; padding:15px">
        <?php
        include "./vistas/inc/btn_go_back.php";
        ?>
        <div class="card-header">
            <h3 class="card-title">Se realizara la entrega de los siguientes paquetes</h3>
        </div>
        <br />
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="loading" style="display: table; margin:auto"><img src="<?php echo SERVERURL; ?>vistas/assets/icons/Pulse200px.gif" alt="loading" /><br/>Cargando información, por favor...</div>
                    <div id="table" style="display: none;">
                        <table id="dtpe-entregar" class="table table-bordered display responsive nowrap" style="border:none" cellspacing="0" width="100%">
                            <thead class=" thead">
                                <tr class="text-center" style="background:#0085b2; color: white;">
                                    <th style="text-align: left; font-size:14px">NRO.</th>
                                    <th style="text-align: left; font-size:14px">NRO. TRACKING</th>
                                    <th style="text-align: left; font-size:14px">CLIENTE</th>
                                    <th style="text-align: left; font-size:14px">ESTADO PAGO</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br />
            <form class="form-neon" method="POST" id="fupForm">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="entrega_tipo_confirmacion" class="bmd-label-floating">Confirmación de la entrega <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="entrega_tipo_confirmacion" id="entrega_tipo_confirmacion" required>
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(ENTREGA,"VACIO");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="col-12 col-md-12" id="archivos" style="display: none;">
                            <label>Por favor suba los archivos para validar la entrega</label>
                            <br />
                            <input type="file" name="fileToUpload" id="fileToUpload" class="fileToUpload" />
                            <input type="text" id="parameter_entrega_reg" name="parameter_entrega_reg" hidden />
                        </div>
                        <div class="col-md-12" style="margin-top:20px">
                            <div class="form-group" id="firma_label" style="display: none;">
                                <label for="venta_cliente_nombre" class="bmd-label-floating">Nombre del cliente</label>
                                <input type="text" class="form-control" name="venta_cliente_nombre" id="venta_cliente_nombre">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:10px">
                            <canvas id="draw-canvas" height="150" style="display: none; background-color: #e5e5e5; margin-right:0px; width:100%">
                                No tienes un buen navegador.
                            </canvas>
                        </div>
                        <div class="col-md-12" style="margin-top:20px">
                            <input type="button" class="button" id="draw-clearBtn" value="Limpiar" style="display: none;"></input>
                            <input type="color" id="color" hidden>
                            <input type="range" id="puntero" min="1" default="1" max="5" width="10%" hidden>
                        </div>
                        <div class="col-md-12">
                            <textarea id="draw-dataUrl" class="form-control" hidden></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <hr style="margin:20px 0;">
                    </div>
                    <div class="col-12 col-lg-12">
                        <p class="text-right">
                            <button type="submit" class="btn btn-raised btn-info btn-sm" id="draw-submitBtn"><i class="far fa-save"></i> &nbsp; Realizar entrega</button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/js/canvas.js?v=<?php echo time(); ?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

<style>
    #draw-canvas {
        border: 2px dotted #CCCCCC;
        border-radius: 5px;
        cursor: crosshair;
    }

    #draw-dataUrl {
        width: 100%;
    }

    .instrucciones {
        width: 90%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
    }


    input[type=range] {
        -webkit-appearance: none;
        margin: 18px 0;

    }

    input[type=range]:focus {
        outline: none;
    }
 
    input[type=range]::-webkit-slider-runnable-track {
        width: 100%;
        height: 8.4px;
        cursor: pointer;
        animate: 0.2s;
        box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        background: #3071a9;
        border-radius: 1.3px;
        border: 0.2px solid #010101;
    }

    input[type=range]::-webkit-slider-thumb {
        box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        border: 1px solid #000000;
        height: 36px;
        width: 16px;
        border-radius: 3px;
        background: #ffffff;
        cursor: pointer;
        -webkit-appearance: none;
        margin-top: -14px;
    }

    input[type=range]:focus::-webkit-slider-runnable-track {
        background: #367ebd;
    }
</style>
<script>
    $(document).ready(function() {
        $('.loading').fadeOut(function() {
            $('#table').fadeIn();
        });
        
        $(document).on('change','select',function(){
            var value = $(this).val();

            if(value == "Foto"){
                $("#archivos").show();

                $("#draw-clearBtn").hide();
                $("#draw-canvas").hide();
                $("#firma_label").hide();
            }
            if(value == "Firma"){
                $("#archivos").hide();
                
                $("#draw-clearBtn").show();
                $("#draw-canvas").show();
                $("#firma_label").show();
            }
        });

        const valores = window.location.search;
        if (valores == "" || valores == "?id=") {
            window.location.href = "http://localhost/SVIL/sale-pending/";
        }
        var res = valores.split("?");
        var parameter = res[1].split("id");
        var parameterFinal = res[1].split("=");
        $("#parameter_entrega_reg").val(parameterFinal[1]);

        $("#fupForm").on('submit', function(e) {
            event.preventDefault();
            var canvas = document.getElementById("draw-canvas");
            var dataUrl = canvas.toDataURL();

            $("#draw-dataUrl").val(dataUrl);
            $('#table').fadeOut();
            $('.loading').fadeIn();
            e.preventDefault();

            var formData = new FormData();
            formData.append('draw-dataUrl', dataUrl);
            formData.append('venta_cliente_nombre', $("#venta_cliente_nombre").val());
            formData.append('parameter_entrega_reg', $("#parameter_entrega_reg").val());
            formData.append('image', $('input[type=file]')[0].files[0]); 
            
            $.ajax({
                type: 'POST',
                url: 'http://localhost/SVIL/ajax/ventaAjax.php?op=procesarentrega&parameter=' + parameterFinal[1],
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(msg) {
                    window.location.href = "http://localhost/SVIL/sale-pending/";
                }
            });
        });

        $('#dtpe-entregar')
            .dataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                aProcessing: true,
                aServerSide: true,
                responsive: true,
                ajax: {
                    url: 'http://localhost/SVIL/ajax/ventaAjax.php?op=entregar&parameter=' + parameterFinal[1],
                    type: "get",
                    dataType: "json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                bDestroy: true,
                dom: 'Bfrtip',
                searching: false,
                columnDefs: [{
                    "orderable": false,
                    "targets": [0, 1, 2, 3]
                }],
                iDisplayLength: 10,
                orderable: true,
                info: true
            })
            .DataTable();
    });
</script>