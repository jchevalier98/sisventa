<?php

	if($peticion_ajax){
		require_once "../modelos/mainModel.php";
        require_once "../pdf/mail.php";
        require_once "../pdf/sendFact.php";
	}else{
		require_once "./modelos/mainModel.php";
        require_once "./pdf/mail.php";
        require_once "./pdf/sendFact.php";
	}
    
	class ventaControlador extends mainModel{
         
        /*--------- Agregar producto a carrito ---------*/
        public function lista_pagos_detalle($estado,$ini, $fin){
            $data = array();
            $select = "select * from venta venta, cliente cliente where venta.cliente_codigo = cliente.cliente_codigo and venta_estado_pagado = '".$estado."';";
            if($ini != ""){
                $select = "select * from venta venta, cliente cliente where venta.cliente_codigo = cliente.cliente_codigo and venta_estado_pagado = '".$estado."' and venta.venta_fecha between '".$ini."' and '".$fin."' ORDER BY venta.venta_id ASC";
            }

            $datos_pendiente=mainModel::ejecutar_consulta_simple($select);
            if($datos_pendiente->rowCount()>=1){
				$datos_pendiente=$datos_pendiente->fetchAll();
				foreach($datos_pendiente as $rows){

                    if($estado == "Pendiente"){
                        $data[] = array(
                            "0" => $rows['venta_id'],
                            "1" => $rows['cliente_codigo'],
                            "2" => $rows['cliente_nombre'],
                            "3" => date("d/m/Y", strtotime($rows['venta_fecha'])),
                            "4" => MONEDA_SIMBOLO.number_format($rows['venta_total_final'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)
                        );
                    }
                    else{
                        $data[] = array(
                            "0" => $rows['venta_id'],
                            "1" => $rows['cliente_codigo'],
                            "2" => $rows['cliente_nombre'],
                            "3" => $rows['venta_codigo'],
                            "4" => date("d/m/Y", strtotime($rows['venta_fecha'])),
                            "5" => MONEDA_SIMBOLO.number_format($rows['venta_total_final'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)
                        );
                    }
                    
                }
                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
			}else{
				$results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
			}
        }

        /*--------- Agregar producto a carrito ---------*/
        public function lista_pagos(){
            $data = array();

            $select = "SELECT * FROM pago pago, cliente cliente where pago.cliente_codigo = cliente.cliente_codigo";
            $datos_pendiente=mainModel::ejecutar_consulta_simple($select);
            if($datos_pendiente->rowCount()>=1){
				$datos_pendiente=$datos_pendiente->fetchAll();
				foreach($datos_pendiente as $rows){
                    $data[] = array(
                        "0" => '<span style="font-size:15px">'.$rows['pago_id'].'</span>',
                        "1" => '<span style="font-size:15px">'.$rows['pago_fecha'].'</span>',
                        "2" => '<span style="font-size:15px">'.$rows['cliente_nombre'].'</span>',
                        "3" => '<span style="font-size:15px">'.$rows['venta_codigo'].'</span>',
                        "4" => '<span style="font-size:15px">'.$rows['pago_monto'].'</span>',
                        "5" => '<span style="font-size:15px">'.$rows['cliente_metodo_pago'].'</span>'
                    );
                }
                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
			}else{
				$results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
			}
        }

        /*--------- Agregar producto a carrito ---------*/
        public function lista_entrega($parameter){
            $data = array();

            $select = "SELECT venta.venta_id,venta.venta_codigo,venta.venta_estado_pagado,cliente.cliente_nombre FROM venta venta, cliente cliente WHERE venta.cliente_codigo =  cliente.cliente_codigo AND venta_id in (".$parameter.")";
            $datos_pendiente=mainModel::ejecutar_consulta_simple($select);
            if($datos_pendiente->rowCount()>=1){
				$datos_pendiente=$datos_pendiente->fetchAll();
				foreach($datos_pendiente as $rows){

                    $estado_pagado = "Pagado";
                    if($rows['venta_estado_pagado'] == "Pendiente"){
                        $estado_pagado = "Pendiente de pago";
                    }

                    $data[] = array(
                        "0" => '<span style="font-size:14px">'.$rows['venta_id'].'</span>',
                        "1" => '<span style="font-size:14px">'.$rows['venta_codigo'].'</span>',
                        "2" => '<span style="font-size:14px">'.$rows['cliente_nombre'].'</span>',
                        "3" => '<span style="font-size:14px">'.$estado_pagado.'</span>'
                    );
                }
                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
			}else{
				$results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
			}
        }

        /*--------- Agregar producto a carrito ---------*/
        public function mostrar_pdf($code){
            $pdf = new PdfEmail();
            $pdf->create_pdf($code, "'".$code."'","I", "FAC");            
        }

        /*--------- Agregar producto a carrito ---------*/
        public function procesar_entrega($parameter, $fileName, $firma, $cliente_nombre){
            
            $select = "SELECT * FROM venta venta, cliente cliente WHERE cliente.cliente_codigo = venta.cliente_codigo and venta.venta_id in (".$parameter.")";
            $datos_pendiente=mainModel::ejecutar_consulta_simple($select);
            $datos_entrega=[
                "venta_estado_pedido"=>[
                    "campo_marcador"=>":Estado",
                    "campo_valor"=>"Entregado"
                ],
                "venta_cliente_firma"=>[
                    "campo_marcador"=>":Firma",
                    "campo_valor"=>$firma
                ],
                "venta_entrega_foto"=>[
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$fileName
                ],
                "cliente_firma_nombre"=>[
                    "campo_marcador"=>":ClienteNombre",
                    "campo_valor"=>$cliente_nombre
                ]
            ];
 
            $data = array();
            $correo = "";
            $codes = null;
            $j=0; 
            if($datos_pendiente->rowCount()>=1){
                $datos_pendiente=$datos_pendiente->fetchAll();
                foreach($datos_pendiente as $rows){
                    
                    $condicion=[
                        "condicion_campo"=>"venta_id",
                        "condicion_marcador"=>":Codigo",
                        "condicion_valor"=>$rows['venta_id']
                    ];
                    mainModel::actualizar_datos("venta",$datos_entrega,$condicion);
                    $data[] = $rows['venta_codigo'];
                    $correo = $rows['cliente_email'];

                    if($j == 0){
                        $codes.= "'".trim($rows['venta_codigo'])."'";
                    }
                    else{
                        $codes.= ",'".trim($rows['venta_codigo'])."'";
                    }
                    $j++; 
                }

                $pdf = new PdfEmail();
                $response = $pdf->create_pdf($data[0], $codes, "E","ENTREGA");
                $send_email = new Send_Mail();
                $send_email->send_email($correo, "ENTREGA", $data, $response, $fileName);
                echo json_encode("ok");
            }
        }

        /*--------- Agregar producto a carrito ---------*/
        public function realizar_pago($parameter){
            
            /*== Iniciando la sesion ==*/
            session_start(['name'=>'SVI']);

            $select = "SELECT * FROM venta WHERE venta_id in (".$parameter.")";
            $datos_pendiente=mainModel::ejecutar_consulta_simple($select);

            if($datos_pendiente->rowCount()>=1){
                $datos_pendiente=$datos_pendiente->fetchAll();
                foreach($datos_pendiente as $rows){
                    
                    /*== Generando fecha y hora ==*/
                    $pago_fecha=date("Y-m-d");
                    /*== Preparando datos para enviarlos al modelo ==*/
                    $datos_pago=[
                        "pago_fecha"=>[
                            "campo_marcador"=>":Fecha",
                            "campo_valor"=>$pago_fecha
                        ],
                        "pago_monto"=>[
                            "campo_marcador"=>":Monto",
                            "campo_valor"=>$rows['venta_total_final']
                        ],
                        "venta_codigo"=>[
                            "campo_marcador"=>":Codigo",
                            "campo_valor"=>$rows['venta_codigo']
                        ],
                        "usuario_id"=>[
                            "campo_marcador"=>":Usuario",
                            "campo_valor"=>$_SESSION['id_svi']
                        ],
                        "caja_id"=>[
                            "campo_marcador"=>":Caja",
                            "campo_valor"=>1
                        ],
                        "cliente_codigo"=>[
                            "campo_marcador"=>":Cliente",
                            "campo_valor"=>$rows['cliente_codigo']
                        ],
                        "cliente_metodo_pago"=>[
                            "campo_marcador"=>":MetodoPago",
                            "campo_valor"=>'Contado'
                        ],
                        "pago_referencia"=>[
                            "campo_marcador"=>":Referencia",
                            "campo_valor"=>""
                        ]
                    ]; 

                    $agregar_pago=mainModel::guardar_datos("pago",$datos_pago);
                    echo "respuesta " . $agregar_pago->rowCount();
                    if($agregar_pago->rowCount()>=1){

                        echo "Se agrego el pago con exito";
                        $datos_pago_update=[
                            "venta_estado_pagado"=>[
                                "campo_marcador"=>":Estado",
                                "campo_valor"=>"Cancelado"
                            ],
                            "venta_pagado"=>[
                                "campo_marcador"=>":Pagado",
                                "campo_valor"=>$rows['venta_total_final']
                            ]
                        ];
    
                        $condicion=[
                            "condicion_campo"=>"venta_id",
                            "condicion_marcador"=>":Codigo",
                            "condicion_valor"=>$rows['venta_id']
                        ];
                        mainModel::actualizar_datos("venta",$datos_pago_update,$condicion);
                    }            
                }
                echo json_encode("ok");
            }
        }
 
        /*--------- Agregar producto a carrito ---------*/
        public function lista_cliente(){

            $datos_cliente=mainModel::ejecutar_consulta_simple("SELECT cliente_codigo, cliente_nombre FROM cliente order by cliente_nombre ASC");
            if($datos_cliente->rowCount()>=1){
				$datos_cliente=$datos_cliente->fetchAll();
                $select='';
				foreach($datos_cliente as $rows){
					$select.='<option value='.$rows['cliente_codigo'].'>'.$rows['cliente_nombre'].'</option>';
				}
				$select.='</select>';
				return $select;
			}else{
				echo "No se encontraron resultados";
			}
        }

        /*--------- Agregar producto a carrito ---------*/
        public function busca_cliente($id){
 
            $select = "SELECT cliente_numero_documento, cliente_nombre, cliente_estado, cliente_telefono, cliente_email, cliente_vendedor_id, cliente_vendedor_nombre, cliente_precio FROM cliente where cliente_codigo = '$id' LIMIT 1";
            $datos_cliente=mainModel::ejecutar_consulta_simple($select);
            $cliente=$datos_cliente->fetch();
            return json_encode($cliente);

            $datos_cliente->closeCursor();
			$datos_cliente=mainModel::desconectar($datos_cliente);
        }

        /*--------- Agregar producto a carrito ---------*/
        public function envia_correo(){
 
            $select = "select v.cliente_codigo, c.cliente_email from venta v, cliente c where v.cliente_codigo = c.cliente_codigo and v.venta_envio_email = 'N' group by v.cliente_codigo, c.cliente_email";
            $datos_cliente=mainModel::ejecutar_consulta_simple($select);
            $datos_cliente=$datos_cliente->fetchAll();
            foreach($datos_cliente as $rows){

                $correo = $rows['cliente_email'];
                $codes = null;
                $j=0;       
                $data = array();
                $datos_codigo=mainModel::ejecutar_consulta_simple("select venta_codigo from venta where venta_envio_email = 'N' and cliente_codigo = '".$rows['cliente_codigo']."'");
                $datos_codigo=$datos_codigo->fetchAll();
                foreach($datos_codigo as $rows_code){
                    $data[] = $rows_code['venta_codigo'];

                    if($j == 0){
                        $codes.= "'".trim($rows_code['venta_codigo'])."'";
                    }
                    else{
                        $codes.= ",'".trim($rows_code['venta_codigo'])."'";
                    }
                    $j++; 

                    $datos_venta=[
                        "venta_envio_email"=>[
                            "campo_marcador"=>":Email",
                            "campo_valor"=>'S'
                        ]
                    ]; 
        
                    $condicion=[
                        "condicion_campo"=>"venta_codigo",
                        "condicion_marcador"=>":Codigo",
                        "condicion_valor"=>$rows_code['venta_codigo']
                    ];
                    mainModel::actualizar_datos("venta",$datos_venta,$condicion);
                }
 
                $pdf = new PdfEmail();
                $response = $pdf->create_pdf($data[0], $codes, "E","FAC");

                $send_email = new Send_Mail();
                $send_email->send_email($correo, "LLEGO", $data, $response, "");
            }
        }

        /*--------- Agregar producto a carrito ---------*/
        public function salvar_venta($carga_tipo, $tracking, $peso, $precio, $precio_cliente, $precio_venta, $cliente, $vendedor_id, $fecha, $delivery ){

            $tracking=mainModel::limpiar_cadena($tracking);
            $peso=mainModel::limpiar_cadena($peso);
            $precio=mainModel::limpiar_cadena($precio);
            $precio_cliente=mainModel::limpiar_cadena($precio_cliente);
            $cliente=mainModel::limpiar_cadena($cliente);
            $precio_venta=mainModel::limpiar_cadena($precio_venta);
            $vendedor_id=mainModel::limpiar_cadena($vendedor_id);
            $fecha=mainModel::limpiar_cadena($fecha);
 
            $total = number_format($delivery,2) + number_format($precio_venta,2);
            $datos_venta_reg=[
                "venta_carga_tipo"=>[
					"campo_marcador"=>":Carga",
					"campo_valor"=>"Normal"
				],
				"venta_codigo"=>[
					"campo_marcador"=>":Tracking",
					"campo_valor"=>trim($tracking)
				],
				"venta_fecha"=>[
					"campo_marcador"=>":Fecha",
					"campo_valor"=>$fecha
				],
				"venta_peso"=>[
					"campo_marcador"=>":Peso",
					"campo_valor"=>$peso
				],
                "venta_precio_cliente"=>[
					"campo_marcador"=>":PrecioCliente",
					"campo_valor"=>$precio_cliente
				],
				"venta_precio_paquete"=>[
					"campo_marcador"=>":Total",
					"campo_valor"=>$precio
				],
				"venta_precio_venta"=>[
					"campo_marcador"=>":Precio",
					"campo_valor"=>number_format($precio_venta,2)
				],
                "venta_total_final"=>[
					"campo_marcador"=>":Preciofinal",
					"campo_valor"=>number_format($total,2)
				],
				"usuario_id"=>[
					"campo_marcador"=>":Usuario",
					"campo_valor"=>number_format($vendedor_id)
				],
				"cliente_codigo"=>[
					"campo_marcador"=>":Cliente",
					"campo_valor"=>$cliente
                ],
                "venta_estado_pedido"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>'Pendiente'
				],
                "venta_estado_pagado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>'Pendiente'
				],
                "caja_id"=>[
					"campo_marcador"=>":Caja",
					"campo_valor"=>1
				],
                "venta_delivery"=>[
					"campo_marcador"=>":Delivery",
					"campo_valor"=>$delivery
				],
                "venta_envio_email"=>[
					"campo_marcador"=>":EnvioEmail",
					"campo_valor"=>'N'
				]
			];

			$agregar_venta=mainModel::guardar_datos("venta",$datos_venta_reg);
			if($agregar_venta->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"¡Registrado!",
					"Texto"=>"Los datos de la venta se registraron con éxito en el sistema",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar la venta, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}

			$agregar_venta->closeCursor();
			$agregar_venta=mainModel::desconectar($agregar_venta);
			echo json_encode($alerta);

        }
        
        public function agregar_pedido_controlador(){

            //$carga_tipo=mainModel::limpiar_cadena($_POST['pedido_tipo_carga']);
            $tracking=mainModel::limpiar_cadena($_POST['pedido_codigo_reg']);
            $peso=mainModel::limpiar_cadena($_POST['pedido_peso_reg']);
            $precio=mainModel::limpiar_cadena($_POST['pedido_precio_reg']);
            $cliente=mainModel::limpiar_cadena($_POST['pedido_cliente_reg']); 
            $vendedor_id=mainModel::limpiar_cadena($_POST['pedido_vendedor_id_reg']);
            $fecha=mainModel::limpiar_cadena($_POST['pedido_fecha_reg']);
            $correo=mainModel::limpiar_cadena($_POST['pedido_correo_reg']);
            $precio_venta=mainModel::limpiar_cadena($_POST['pedido_utilidad_reg']);

            $datos_venta_reg=[
                "venta_carga_tipo"=>[
					"campo_marcador"=>":Carga",
					"campo_valor"=>"Normal"
				],
				"venta_codigo"=>[
					"campo_marcador"=>":Tracking",
					"campo_valor"=>trim($tracking)
				],
				"venta_fecha"=>[
					"campo_marcador"=>":Fecha",
					"campo_valor"=>$fecha
				],
				"venta_peso"=>[
					"campo_marcador"=>":Peso",
					"campo_valor"=>$peso
				],
                "venta_precio_cliente"=>[
					"campo_marcador"=>":PrecioCliente",
					"campo_valor"=>$precio
				],
				"venta_precio_paquete"=>[
					"campo_marcador"=>":Total",
					"campo_valor"=>$precio
				],
				"venta_precio_venta"=>[
					"campo_marcador"=>":Precio",
					"campo_valor"=>$precio_venta
				],
                "venta_total_final"=>[
					"campo_marcador"=>":Preciofinal",
					"campo_valor"=>$precio_venta
				],
				"usuario_id"=>[
					"campo_marcador"=>":Usuario",
					"campo_valor"=>number_format($vendedor_id)
				],
				"cliente_codigo"=>[
					"campo_marcador"=>":Cliente",
					"campo_valor"=>$cliente
                ],
                "venta_estado_pedido"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>'Pendiente'
				],
                "venta_estado_pagado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>'Pendiente'
				],
                "caja_id"=>[
					"campo_marcador"=>":Caja",
					"campo_valor"=>1
				],
                "venta_delivery"=>[
					"campo_marcador"=>":Delivery",
					"campo_valor"=>0.00
				],
			];

			$agregar_venta=mainModel::guardar_datos("venta",$datos_venta_reg);
			if($agregar_venta->rowCount()==1){

                $track = "'".$tracking."'";
                $data = array(); 
                $data[] =  $track;
                $pdf = new PdfEmail();
                $response = $pdf->create_pdf($tracking, $track, "E","FAC");

                $send_email = new Send_Mail();
                $send_email->send_email($correo, "LLEGO", $data, $response, "");
 
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"¡Registrado!",
					"Texto"=>"Los datos de la venta se registraron con éxito en el sistema",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar la venta, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}

			$agregar_venta->closeCursor();
			$agregar_venta=mainModel::desconectar($agregar_venta);
			echo json_encode($alerta);
        } 

        /*--------- Agregar producto a carrito ---------*/
        public function lista_realizados($ini, $fin){
            $select = "SELECT * FROM venta INNER JOIN cliente ON venta.cliente_codigo=cliente.cliente_codigo INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id ORDER BY venta.venta_id DESC LIMIT 2500";
            if($ini != ""){
                $select = "SELECT * FROM venta INNER JOIN cliente ON venta.cliente_codigo=cliente.cliente_codigo INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE venta.venta_fecha between '".$ini."' and '".$fin."' ORDER BY venta.venta_id DESC";
            }

            $data = array();
            $datos_realizados=mainModel::ejecutar_consulta_simple($select);
            if($datos_realizados->rowCount()>=1){
				$datos_realizados=$datos_realizados->fetchAll();
                $count = 0;
				foreach($datos_realizados as $rows){
                    $opciones = ""; 
                    $opciones.='<div class="btn-group" role="group" aria-label="Options" style="margin: 0;" >
                        <a style="background-color:#06ca20; border:none; width:30px; height:30px" class="btn btn-primary btn-sale-options" href="'.SERVERURL.'sale-detail/'.$rows['venta_codigo'].'/" data-toggle="popover" data-trigger="hover" title="Detalle venta Nro. '.$rows['venta_id'].'" data-content="Detalles, pagos & devoluciones de venta Nro.'.$rows['venta_id'].' - código: '.$rows['venta_codigo'].'">
                            <i class="fas fa-cart-plus fa-fw" style="color:#fff;"></i>
                        </a>&nbsp;&nbsp;
                        <button style="background-color:#f39c12; border:none; width:30px; height:30px" type="button" class="btn btn-info btn-sale-options" onclick="print_invoice(\''.SERVERURL.'pdf/invoice.php?code='.$rows['venta_codigo'].'\')" data-toggle="popover" data-trigger="hover" title="Imprimir factura Nro. '.$rows['venta_id'].'" data-content="CÓDIGO: '.$rows['venta_codigo'].'">
                            <i class="fas fa-file-invoice-dollar fa-fw" style="color:#fff"></i>
                        </button>&nbsp;&nbsp;';
                    $opciones.='</div>';

                    $estado_pedido = '<span class="label" style="padding:2px; border-radius:2px; font-size:14px; background:#047b14; color:white;">Entregado</span>';
                    if ($rows['venta_estado_pedido'] == "Pendiente") {
                        $estado_pedido = '<span class="label" style="padding:2px; border-radius:2px; font-size:14px; background:#e34525; color:white;">Por entrega</span>';
                    }

                    $estado_pagado = "Pagado";
                    if($rows['venta_estado_pagado'] == "Pendiente"){
                        $estado_pagado = "Pend. de pago";
                    }

                    $mes_fact = date("m", strtotime($rows['venta_fecha']));
                    
                    $mes = "Diciembre";
                    if($mes_fact == "01"){
                        $mes = "Enero";
                    }
                    elseif ($mes_fact == "02"){
                        $mes = "Febrero";
                    }
                    elseif ($mes_fact == "03"){
                        $mes = "Marzo";
                    }
                    elseif ($mes_fact == "04"){
                        $mes = "Abril";
                    }
                    elseif ($mes_fact == "05"){
                        $mes = "Mayo";
                    }
                    elseif ($mes_fact == "06"){
                        $mes = "Junio";
                    }
                    elseif ($mes_fact == "07"){
                        $mes = "Julio";
                    }
                    elseif ($mes_fact == "08"){
                        $mes = "Agosto";
                    }
                    elseif ($mes_fact == "09"){
                        $mes = "Septiembre";
                    }
                    elseif ($mes_fact == "10"){
                        $mes = "Octubre";
                    }
                    elseif ($mes_fact == "11"){
                        $mes = "Noviembre";
                    }

                    $data[] = array(
                        "0" => '<span style="font-size:14px">'.$rows['venta_id'].'</span>',
                        "1" => '<span style="font-size:14px">'.$rows['venta_codigo'].'</span>',
                        "2" => '<span style="font-size:14px">'.$rows['cliente_nombre'].'</span>',
                        "3" => '<span style="font-size:14px">'.$rows['venta_peso'].'</span>',
                        "4" => '<span style="font-size:14px">'.MONEDA_SIMBOLO.number_format($rows['venta_precio_cliente'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).'</span>',
                        "5" => '<span style="font-size:14px">'.MONEDA_SIMBOLO.number_format($rows['venta_precio_venta'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).'</span>',
                        "6" => '<span style="font-size:14px">'.MONEDA_SIMBOLO.number_format($rows['venta_delivery'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).'</span>',
                        "7" => '<span style="font-size:14px">'.MONEDA_SIMBOLO.number_format($rows['venta_total_final'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).'</span>',
                        "8" => '<span style="font-size:14px">'.date("d/m/Y", strtotime($rows['venta_fecha'])).'</span>',
                        "9" => $estado_pedido,
                        "10" => '<span style="font-size:14px">'.$estado_pagado.'</span>',
                        "11" => '<center><span style="font-size:14px">'.$opciones.'</span></center>',
                        "12" => '<center><span style="font-size:14px">'.$mes.'</span></center>'
                    );

                    $count++;
                }
                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                ); 
                echo json_encode($results);
			}else{
				$results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
			}
        }

        /*--------- Agregar producto a carrito ---------*/
        public function lista_pendiente($vendedor, $ruta){
            if($ruta != ""){ 
                $ruta = "Ruta " .$ruta;
            }
            $select = "SELECT * FROM venta INNER JOIN cliente ON venta.cliente_codigo=cliente.cliente_codigo INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE (venta.venta_estado_pedido='Pendiente') ORDER BY venta.venta_id DESC";
            if($vendedor != "" && $ruta == ""){
                $select = "SELECT * FROM venta INNER JOIN cliente ON venta.cliente_codigo=cliente.cliente_codigo INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE venta.venta_estado_pedido='Pendiente' and cliente.cliente_vendedor_id =".$vendedor." ORDER BY venta.venta_id DESC";
            }
            if($vendedor == "" && $ruta != ""){
                $select = "SELECT * FROM venta INNER JOIN cliente ON venta.cliente_codigo=cliente.cliente_codigo INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE venta.venta_estado_pedido='Pendiente' and cliente.cliente_ruta ='".$ruta."' ORDER BY venta.venta_id DESC";
            }
            if($vendedor != "" && $ruta != ""){
                $select = "SELECT * FROM venta INNER JOIN cliente ON venta.cliente_codigo=cliente.cliente_codigo INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE venta.venta_estado_pedido='Pendiente' and cliente.cliente_ruta = '".$ruta."' and cliente.cliente_vendedor_id =".$vendedor." ORDER BY venta.venta_id DESC";
            }
            
            $data = array();
            $datos_realizados=mainModel::ejecutar_consulta_simple($select);
            if($datos_realizados->rowCount()>=1){
				$datos_realizados=$datos_realizados->fetchAll();
				foreach($datos_realizados as $rows){
                    $opciones = "";
                    $whasap = '<a href="https://api.whatsapp.com/send?phone=+507'.$rows['cliente_telefono'].'&text=" target="_blank">'.$rows['cliente_telefono'];
                    $opciones.='<div class="btn-group" role="group" aria-label="Options" style="margin: 0;" >
                        <a style="background-color:#00a2d9; border:none; width:30px; height:35px" class="btn btn-primary btn-sale-options" href="'.SERVERURL.'sale-detail/'.$rows['venta_codigo'].'/" data-toggle="popover" data-trigger="hover" title="Detalle venta Nro. '.$rows['venta_id'].'" data-content="Detalles, pagos & devoluciones de venta Nro.'.$rows['venta_id'].' - código: '.$rows['venta_codigo'].'">
                            <i class="fas fa-cart-plus fa-fw" style="color:#fff"></i>
                        </a> &nbsp;&nbsp;
                        <button style="background-color:#f39c12; border:none; width:30px; height:35px" type="button" class="btn btn-info btn-sale-options" onclick="print_invoice(\''.SERVERURL.'pdf/invoice.php?code='.$rows['venta_codigo'].'\')" data-toggle="popover" data-trigger="hover" title="Imprimir factura Nro. '.$rows['venta_id'].'" data-content="CÓDIGO: '.$rows['venta_codigo'].'">
                            <i class="fas fa-file-invoice-dollar fa-fw" style="color:#fff"></i>
                        </button> &nbsp;&nbsp;';
                    $opciones.='</div>';

                    $map = "";
                    if($rows['cliente_cordenada'] != ""){
                        $map = '<a href="'.$rows['cliente_cordenada'].'" target="_blank"><i class="fas fa-map-marked-alt" ></i></a>';
                    }
                    
                    $data[] = array(
                        "0" => $rows['venta_id'],
                        "1" => '<span style="font-size:13px">'.$rows['venta_codigo'].'</span>',
                        "2" => '<span style="font-size:13px">'.$rows['cliente_nombre'].'</span>',
                        "3" => '<span style="font-size:13px">'.$whasap.'</span>',
                        "4" => '<span style="font-size:13px">'.$rows['cliente_direccion'].'</span>',
                        "5" => '<span style="font-size:13px">'.$map.'</span>',
                        "6" => '<span style="font-size:13px">'.$rows['cliente_ruta'].'</span>'
                    );
                }
                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
			}else{
				$results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
			}
        }

        /*---------- Controlador eliminar producto a venta ----------*/
        public function eliminar_producto_carrito_controlador(){
            /*== Iniciando la sesion ==*/
            session_start(['name'=>'SVI']);

            /*== Recuperando codigo del producto ==*/
            $codigo=mainModel::limpiar_cadena($_POST['producto_codigo_del']);

            unset($_SESSION['datos_producto_venta'][$codigo]);
            if(empty($_SESSION['datos_producto_venta'][$codigo])){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Producto removido!",
					"Texto"=>"El producto se ha removido de la venta.",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido remover el producto, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
            }
            echo json_encode($alerta);
        } /*-- Fin controlador --*/

        /*---------- Controlador buscar cliente ----------*/
        public function buscar_cliente_venta_controlador(){

            /*== Recuperando termino de busqueda ==*/
			$cliente=mainModel::limpiar_cadena($_POST['buscar_cliente']);

			/*== Comprobando que no este vacio el campo ==*/
			if($cliente==""){
				return '<div class="alert alert-warning" role="alert">
					<p class="text-center mb-0">
						<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						Debes de introducir el Numero de documento, Nombre, Apellido o Teléfono del cliente
					</p>
				</div>';
				exit();
            }
            
            /*== Seleccionando clientes en la DB ==*/
            $datos_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE (cliente_id!='1') AND (cliente_numero_documento LIKE '%$cliente%' OR cliente_nombre LIKE '%$cliente%' OR cliente_apellido LIKE '%$cliente%' OR cliente_telefono LIKE '%$cliente%') ORDER BY cliente_nombre ASC");
            
            if($datos_cliente->rowCount()>=1){

				$datos_cliente=$datos_cliente->fetchAll();

				$tabla='<div class="table-responsive" ><table class="table table-hover table-bordered table-sm"><tbody>';

				foreach($datos_cliente as $rows){
					$tabla.='
					<tr class="text-center">
                        <td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].' ('.$rows['cliente_tipo_documento'].': '.$rows['cliente_numero_documento'].')</td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="agregar_cliente('.$rows['cliente_codigo'].')"><i class="fas fa-user-plus"></i></button>
                        </td>
                    </tr>
                    ';
				}

				$tabla.='</tbody></table></div>';
				return $tabla;
			}else{
				return '<div class="alert alert-warning" role="alert">
					<p class="text-center mb-0">
						<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						No hemos encontrado ningún cliente en el sistema que coincida con <strong>“'.$cliente.'”</strong>
					</p>
				</div>';
				exit();
			}
        } /*-- Fin controlador --*/


        /*---------- Controlador buscar codigo de producto ----------*/
        public function buscar_codigo_venta_controlador(){

            session_start(['name'=>'SVI']);

            /*== Recuperando codigo de busqueda ==*/
			$producto=mainModel::limpiar_cadena($_POST['buscar_codigo']);

			/*== Comprobando que no este vacio el campo ==*/
			if($producto==""){
				return '<div class="alert alert-warning" role="alert">
					<p class="text-center mb-0">
						<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						Debes de introducir el Nombre, Marca o Modelo del producto
					</p>
				</div>';
				exit();
            }

            /*== Seleccionando productos en la DB ==*/
            $datos_productos=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE (producto_nombre LIKE '%$producto%' OR producto_marca LIKE '%$producto%' OR producto_modelo LIKE '%$producto%') ORDER BY producto_nombre ASC");
            
            if($datos_productos->rowCount()>=1){

                if($_SESSION['lector_codigo_svi']=="Barras"){
                    $campo_codigo="producto_codigo";
                }else{
                    $campo_codigo="producto_sku";
                }

				$datos_productos=$datos_productos->fetchAll();

				$tabla='<div class="table-responsive" ><table class="table table-hover table-bordered table-sm"><tbody>';

				foreach($datos_productos as $rows){
					$tabla.='
					<tr class="text-center">
                        <td>'.$rows['producto_nombre'].'</td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="agregar_codigo(\''.$rows[$campo_codigo].'\')"><i class="fas fa-plus-circle"></i></button>
                        </td>
                    </tr>
                    ';
				}

				$tabla.='</tbody></table></div>';
				return $tabla;
			}else{
				return '<div class="alert alert-warning" role="alert">
					<p class="text-center mb-0">
						<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						No hemos encontrado ningún producto en el sistema que coincida con <strong>“'.$producto.'”</strong>
					</p>
				</div>';
				exit();
			}
        } /*-- Fin controlador --*/


        /*---------- Controlador aplicar descuento a venta ----------*/
        public function aplicar_descuento_venta_controlador(){
            /*== Iniciando la sesion ==*/
            session_start(['name'=>'SVI']);

            /*== Recuperando descuento ==*/
            $descuento=mainModel::limpiar_cadena($_POST['venta_descuento_add']);
            
            /*== Comprobando que no este vacio el campo y que sea mayor a 0 ==*/
			if($descuento=="" || $descuento<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Debe de ingresar una cantidad mayor a 0.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando formato de descuento ==*/
            if(mainModel::verificar_datos("[0-9]{1,2}",$descuento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El descuento no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando que se hayan agregado productos y que la venta sea mayor a 0 ==*/
            if($_SESSION['venta_precio_paquete']<=0 || (!isset($_SESSION['datos_producto_venta']) && count($_SESSION['datos_producto_venta'])<=0)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos aplicar el descuento ya que no ha agregado productos a esta venta.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            $_SESSION['venta_descuento']=$descuento;

            if($_SESSION['venta_descuento']==$descuento){
                $alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Descuento aplicado!",
					"Texto"=>"El descuento ha sido aplicado con éxito en la venta.",
					"Tipo"=>"success"
				];
            }else{
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos aplicar el descuento debido a un error, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
            }
            echo json_encode($alerta);
        } /*-- Fin controlador --*/

        /*---------- Controlador agregar pagos de ventas ----------*/
        public function agregar_pago_venta_controlador(){

            /*== Iniciando la sesion ==*/
            session_start(['name'=>'SVI']);

            /*== Recuperando el codigo de la venta y monto ==*/
            $venta_codigo=mainModel::limpiar_cadena($_POST['pago_codigo_reg']);
            $pago_monto=mainModel::limpiar_cadena($_POST['pago_monto_reg']);
            $pago_metodo=mainModel::limpiar_cadena($_POST['pago_metodo']);
            $pago_pendiente=mainModel::limpiar_cadena($_POST['pago_pendiente']);
            $pago_cliente=mainModel::limpiar_cadena($_POST['pago_cliente']);
            $pago_referencia=mainModel::limpiar_cadena($_POST['pago_referencia_reg']);

            /*== Comprobando venta ==*/
			$check_venta=mainModel::ejecutar_consulta_simple("SELECT * FROM venta WHERE venta_codigo='$venta_codigo' AND venta_estado_pagado='Pendiente'");
			if($check_venta->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado en la base de datos la venta seleccionada para realizar el pago. También es posible que la venta ya haya sido cancelada o no es una venta al crédito por lo tanto no podemos agregar pagos",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }else{
                $datos_venta=$check_venta->fetch();
            }
            $check_venta->closeCursor();
            $check_venta=mainModel::desconectar($check_venta);
            
            /*== Comprobando pago ==*/
            if($pago_monto=="" || $pago_monto<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Debes de introducir una cantidad (monto) que sea mayor a 0 para poder realizar el pago.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando integridad de los datos ==*/
            if(mainModel::verificar_datos("[0-9.]{1,25}",$pago_monto)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El monto no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Calculando total pendiente ==*/
            $venta_pendiente=$datos_venta['venta_precio_venta']-$datos_venta['venta_pagado'];
            $venta_pendiente=number_format($venta_pendiente,MONEDA_DECIMALES,'.','');

            /*== Calculando el cambio ==*/
            $venta_estado="Cancelado";
            if($pago_monto<$pago_pendiente){
                $venta_estado="Pendiente";
            }

            /*== Generando fecha y hora ==*/
            $pago_fecha=date("Y-m-d");
            /*== Preparando datos para enviarlos al modelo ==*/
            $datos_pago=[
                "pago_fecha"=>[
                    "campo_marcador"=>":Fecha",
                    "campo_valor"=>$pago_fecha
                ],
                "pago_monto"=>[
                    "campo_marcador"=>":Monto",
                    "campo_valor"=>$pago_monto
                ],
                "venta_codigo"=>[
                    "campo_marcador"=>":Codigo",
                    "campo_valor"=>$venta_codigo
                ],
                "usuario_id"=>[
                    "campo_marcador"=>":Usuario",
                    "campo_valor"=>$_SESSION['id_svi']
                ],
                "caja_id"=>[
                    "campo_marcador"=>":Caja",
                    "campo_valor"=>1
                ],
                "cliente_codigo"=>[
                    "campo_marcador"=>":Cliente",
                    "campo_valor"=>$pago_cliente
                ],
                "cliente_metodo_pago"=>[
                    "campo_marcador"=>":MetodoPago",
                    "campo_valor"=>$pago_metodo
                ],
                "pago_referencia"=>[
                    "campo_marcador"=>":Referencia",
                    "campo_valor"=>$pago_referencia
                ]
            ]; 

            $agregar_pago=mainModel::guardar_datos("pago",$datos_pago);
            if($agregar_pago->rowCount()<1){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido agregar el pago, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
            $agregar_pago->closeCursor();
            $agregar_pago=mainModel::desconectar($agregar_pago);

            /*== Preparando datos para enviarlos al modelo ==*/
            $datos_venta=[
                "venta_pagado"=>[
                    "campo_marcador"=>":Pagado",
                    "campo_valor"=>$pago_monto
                ],
                "venta_estado_pagado"=>[
                    "campo_marcador"=>":Estado",
                    "campo_valor"=>$venta_estado
                ]
            ]; 

            $condicion=[
                "condicion_campo"=>"venta_codigo",
                "condicion_marcador"=>":Codigo",
                "condicion_valor"=>$venta_codigo
            ];

            /*== Reestableciendo DB debido a errores ==*/
            if(!mainModel::actualizar_datos("venta",$datos_venta,$condicion)){
                
                /*== Eliminando pago ==*/
                $check_pago=mainModel::ejecutar_consulta_simple("SELECT pago_id FROM pago WHERE pago_fecha='$pago_fecha' AND venta_codigo='$venta_codigo' AND usuario_id='".$_SESSION['id_svi']."' ORDER BY pago_id DESC LIMIT 1");
                $datos_pago=$check_pago->fetch();

                mainModel::eliminar_registro("pago","pago_id",$datos_pago['pago_id']);

                $check_pago->closeCursor();
                $check_pago=mainModel::desconectar($check_pago);

                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar algunos datos de la venta para poder agregar el pago.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Pago registrado!",
                "Texto"=>"El pago se registró con éxito en el sistema",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
        } /*-- Fin controlador --*/

        /*---------- Controlador eliminar venta ----------*/
        public function eliminar_venta_controlador(){

            /*== Recuperando codigo de venta ==*/
			$codigo=mainModel::decryption($_POST['venta_codigo_del']);
            $codigo=mainModel::limpiar_cadena($codigo);
            
            /*== Comprobando venta en la BD ==*/
			$check_venta=mainModel::ejecutar_consulta_simple("SELECT venta_id FROM venta WHERE venta_codigo='$codigo'");
			if($check_venta->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La venta que intenta eliminar no existe en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_venta->closeCursor();
            $check_venta=mainModel::desconectar($check_venta);
            
            /*== Comprobando privilegios ==*/
			session_start(['name'=>'SVI']);
			if($_SESSION['cargo_svi']!="Administrador"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Eliminado pagos ==*/
            $check_pago=mainModel::ejecutar_consulta_simple("SELECT * FROM pago WHERE venta_codigo='$codigo'");
			if($check_pago->rowCount() >= 1){
                $eliminar_pago=mainModel::eliminar_registro("pago","venta_codigo",$codigo);
                if($eliminar_pago->rowCount()<=0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No hemos podido eliminar los pagos asociados a esta venta, no podemos continuar. Por favor intente nuevamente..",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $eliminar_pago->closeCursor();
                $eliminar_pago=mainModel::desconectar($eliminar_pago);
            }
            
            /*== Eliminado venta ==*/
            $eliminar_venta=mainModel::eliminar_registro("venta","venta_codigo",$codigo);
			if($eliminar_venta->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Venta eliminada!",
					"Texto"=>"La venta ha sido eliminada del sistema exitosamente.",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido eliminar la venta del sistema, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
			}

			$eliminar_venta->closeCursor();
			$eliminar_venta=mainModel::desconectar($eliminar_venta);
			echo json_encode($alerta);
        } /*-- Fin controlador --*/

        /*---------- Controlador paginador ventas ----------*/
		public function paginador_venta_controlador($pagina,$registros,$url,$fecha_inicio,$fecha_final){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

            $url=mainModel::limpiar_cadena($url);
            $tipo=$url;
            
			$url=SERVERURL.$url."/";
            
			$fecha_inicio=mainModel::limpiar_cadena($fecha_inicio);
			$fecha_final=mainModel::limpiar_cadena($fecha_final);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
            
            if($tipo=="sale-search-date"){
				if(mainModel::verificar_fecha($fecha_inicio) || mainModel::verificar_fecha($fecha_final)){
					return '
						<div class="alert alert-danger text-center" role="alert">
							<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
							<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
							<p class="mb-0">Lo sentimos, no podemos realizar la búsqueda ya que al parecer a ingresado una fecha incorrecta.</p>
						</div>
					';
					exit();
				}
            } 
            
            $campos_tablas="venta.venta_id,venta.venta_carga_tipo,venta.venta_codigo,venta.venta_fecha,venta.venta_peso,venta.venta_precio_paquete,venta.venta_precio_venta,venta.venta_total_final,venta.usuario_id,venta.cliente_codigo,venta.venta_estado_pagado,venta.venta_estado_pedido,usuario.usuario_id,usuario.usuario_nombre,usuario.usuario_apellido,cliente.cliente_codigo,cliente.cliente_nombre, cliente.cliente_precio, cliente.cliente_telefono, cliente.cliente_direccion";
			$consulta="SELECT SQL_CALC_FOUND_ROWS $campos_tablas FROM venta INNER JOIN cliente ON venta.cliente_codigo=cliente.cliente_codigo INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE (venta.venta_fecha BETWEEN '$fecha_inicio' AND '$fecha_final') ORDER BY venta.venta_id DESC LIMIT $inicio,$registros";
			
			$conexion = mainModel::conectar();
			$datos = $conexion->query($consulta);
			$datos = $datos->fetchAll();
			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();
			$Npaginas =ceil($total/$registros);

			### Cuerpo de la tabla ###
			$tabla.='
				<div class="table-responsive">
				<table class="table table-sm table-striped" style="border: 1px solid #dbdbdb;">
					<thead style="padding:40px">
                        <tr class="text-center" style="background:#00a2d9; color: white;">
                            <th>NRO.</th>
                            <th>CODIGO</th>
                            <th>FECHA</th>
                            <th>CLIENTE</th>
                            <th>TELEFONO</th>
                            <th>DIRECCIÓN</th>
							<th>VENDEDOR</th>
                            <th>PESO</th>
                            <th>PRECIO LB.</th>
                            <th>TOTAL</th>
                            <th>PRECIO VENTA</th>
                            <th>ESTADO</th> 
                            <th><i class="fas fa-tools"></i>&nbsp; OPCIONES</th>
                        </tr>
					</thead>
					<tbody>
			';

			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
                        <tr class="text-center" >
                            <td>'.$rows['venta_id'].'</td>
                            <td style="text-align: left;">'.$rows['venta_codigo'].'</td>
                            <td>'.date("d-m-Y", strtotime($rows['venta_fecha'])).'</td>
                            <td style="text-align: left;">'.$rows['cliente_nombre'].'</td>
                            <td style="text-align: left;"><a href="https://api.whatsapp.com/send?phone=+507'.$rows['cliente_telefono'].'&text=Hola!%20Quiero%20generar%20mas%20ventas" target="_blank">'.$rows['cliente_telefono'].'</td>
                            <td style="text-align: left;">'.$rows['cliente_direccion'].'</td>
                            <td>'.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'</td>
                            <td>Lb. '.$rows['venta_peso'].'</td>
                            <td>$'.$rows['cliente_precio'].'</td>
                            <td>$'.$rows['venta_precio_paquete'].'</td>
                            <td>'.MONEDA_SIMBOLO.number_format($rows['venta_precio_venta'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                            <td>'.$rows['venta_estado_pagado'].'</td>';
                        
                        $tabla.='
                            <td>
                                <div class="btn-group" role="group" aria-label="Options" style="margin: 0;" >
                                    <a class="btn btn-primary btn-sale-options" href="'.SERVERURL.'sale-detail/'.$rows['venta_codigo'].'/" data-toggle="popover" data-trigger="hover" title="Detalle venta Nro. '.$rows['venta_id'].'" data-content="Detalles, pagos & devoluciones de venta Nro.'.$rows['venta_id'].' - código: '.$rows['venta_codigo'].'">
                                        <i class="fas fa-cart-plus fa-fw"></i>
                                    </a>
                                    <button type="button" class="btn btn-info btn-sale-options" onclick="print_invoice(\''.SERVERURL.'pdf/invoice.php?code='.$rows['venta_codigo'].'\')" data-toggle="popover" data-trigger="hover" title="Imprimir factura Nro. '.$rows['venta_id'].'" data-content="CÓDIGO: '.$rows['venta_codigo'].'">
                                        <i class="fas fa-file-invoice-dollar fa-fw"></i>
                                    </button>';
                                    if($_SESSION['cargo_svi']=="Administrador"){
                                        $tabla.='<form class="FormularioAjax" action="'.SERVERURL.'ajax/ventaAjax.php" method="POST" data-form="delete" enctype="multipart/form-data" autocomplete="off" >
                                            <input type="hidden" name="venta_codigo_del" value="'.mainModel::encryption($rows['venta_codigo']).'">
                                            <button type="submit" class="btn btn-warning btn-sale-options" data-toggle="popover" data-trigger="hover" title="Eliminar venta Nro. '.$rows['venta_id'].'" data-content="CÓDIGO: '.$rows['venta_codigo'].'">
                                                    <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>';
                                    }
                        $tabla.='</div>
                            </td>
                        </tr>
                    ';
                    $contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="text-center" >
							<td colspan="11">
								<a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr class="text-center" >
							<td colspan="11">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}
			$tabla.='</tbody></table></div>';
			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<p class="text-right">Mostrando ventas <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}
			### Paginacion ###
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);
			}
			return $tabla;
        } /*-- Fin controlador --*/
    }