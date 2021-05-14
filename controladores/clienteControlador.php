<?php
	if($peticion_ajax){
		require_once "../modelos/mainModel.php";
	}else{
		require_once "./modelos/mainModel.php";
	}

	class clienteControlador extends mainModel{

		/*--------- Agregar producto a carrito ---------*/
        public function pendiente_pago(){

			$data = array();
            $datos_cliente=mainModel::ejecutar_consulta_simple("select cliente.cliente_codigo, 
					cliente.cliente_nombre,  
					sum(venta.venta_total_final) as facturado, 
					count(1) as paquetes,
					(select IFNULL(sum(pago.pago_monto), 0) from pago pago where pago.cliente_codigo = venta.cliente_codigo) as pagado
				from venta venta, 
					cliente cliente
				where cliente.cliente_codigo = venta.cliente_codigo
				group by cliente.cliente_codigo, cliente.cliente_nombre;");

			if($datos_cliente->rowCount()>=1){
				$datos_cliente=$datos_cliente->fetchAll();
				foreach($datos_cliente as $rows){

					$total = number_format($rows['facturado'],2) - number_format($rows['pagado'],2);
					$data[] = array(
						"0" => '<span style="font-size:15px">'.$rows['cliente_codigo'].'</span>',
						"1" => '<span style="font-size:15px">'.$rows['cliente_nombre'].'</span>',
						"2" => '<span style="font-size:15px">'.MONEDA_SIMBOLO.number_format($total ,MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).'</span>',
						"3" => '<span style="font-size:15px">'.$rows['paquetes'].'</span>'
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
        public function lista_usuario(){
            $datos_usuario=mainModel::ejecutar_consulta_simple("SELECT usuario_id, usuario_nombre FROM usuario where usuario_id <> 1 order by usuario_nombre ASC");
            if($datos_usuario->rowCount()>=1){
				$datos_usuario=$datos_usuario->fetchAll();
                $select='<option>Selecciona una opción</option>';
				foreach($datos_usuario as $rows){
					$select.='<option value='.$rows['usuario_id'].'>'.$rows['usuario_nombre'].'</option>';
				}
				return $select;
			}else{
				echo "No se encontraron resultados";
			}
            $datos_usuario->closeCursor();
			$datos_usuario=mainModel::desconectar($datos_usuario);
        }

		/*--------- Listar cliente ---------*/
        public function listar_cliente(){

            $data = array();
            $datos_realizados=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id != 1 ORDER BY cliente_nombre ASC");
            if($datos_realizados->rowCount()>=1){
				$datos_realizados=$datos_realizados->fetchAll();
				foreach($datos_realizados as $rows){

					$whasap = '<a href="https://api.whatsapp.com/send?phone=+507'.$rows['cliente_telefono'].'&text=" target="_blank">'.$rows['cliente_telefono'];
					$opciones = "";
					$opciones.='<div class="btn-group" role="group" aria-label="Options" style="margin: 0;" >
                        <a style="background-color:#00a2d9; border:none; width:30px; height:35px" class="btn btn-primary btn-sale-options" href="'.SERVERURL.'client-detail/'.$rows['cliente_id'].'/" data-toggle="popover" data-trigger="hover">
                            <i class="fas fa-eye fa-fw" style="color:#fff"></i>
                        </a>&nbsp;&nbsp;'.mainModel::enrutador("cliente_update","btn_update",$rows['cliente_id']);
					$opciones.='</div>';
 
                    $data[] = array(
                        "0" => '<span style="text-align: left; font-size:14px">'.$rows['cliente_codigo'].'</span>',
						"1" => '<span style="text-align: left; font-size:14px">'.$rows['cliente_tipo'].'</span>',
                        "2" => '<span style="text-align: left; font-size:14px">'.$rows['cliente_tipo_documento'].': '.$rows['cliente_numero_documento'].'</span>',
                        "3" => '<span style="text-align: left; font-size:14px">'.$rows['cliente_nombre'].'</span>',
                        "4" => '<span style="text-align: left; font-size:14px; width:65px;">'.$rows['cliente_precio'].'</span>',
                        "5" => '<span style="text-align: left; font-size:14px; width:65px;">'.$rows['cliente_metodo_pago'].'</span>',
                        "6" => '<span style="text-align: left; font-size:14px">'.$rows['cliente_estado'].'</span>',
                        "7" => '<span style="text-align: left; font-size:14px">'.$rows['cliente_direccion'].'</span>',
						"8" => '<span style="text-align: left; font-size:14px"></span>',
						"9" => '<span style="text-align: left; font-size:14px">'.$whasap.'</span>',
						"10" => '<span style="text-align: left; font-size:14px">'.$opciones.'</span>'
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
		
		/*---------- Controlador agregar cliente ----------*/
        public function obtener_id(){

			$id = 0;
			$check_cliente_id=mainModel::ejecutar_consulta_simple("select IFNULL(cliente_id, 0) as cliente_id from cliente order by cliente_id desc limit 1");
			if($check_cliente_id->rowCount()>=1){
				$check_cliente_id=$check_cliente_id->fetchAll();
				foreach($check_cliente_id as $rows){

					$id = intval($rows['cliente_id']) + 1; 
				}
			}
			echo json_encode($id);
		}
		/*---------- Controlador agregar cliente ----------*/
        public function carga_cliente_manual_controlador($codigo_cliente, $cedula, $nombre, $direccion, $telefono, $pais, $webpage, $cumple, $email, $vendedor, $precio){

            $tipo_documento = "Cedula";
            $numero_documento= $cedula;
			$cliente_tipo= "Personal";
			$metodo_pago="Efectivo";

			if($tipo_documento == null || $tipo_documento == ""){
				$tipo_documento = "Cedula";
			}

			if($pais == null || $pais == ""){
				$pais = "PANAMA";
			}

			$precio_valor = "2.50";
			if($precio == "1 Precio Platinum"){
				$precio_valor = "2.35";
			}
			elseif ($precio == "2 Precio de Gold"){
				$precio_valor = "2.40";
			}
			/*== Buscando el nombre del vendedor ==*/
			if(isset($vendedor) || $vendedor != "" || $vendedor != null){
				$check_usuario=mainModel::ejecutar_consulta_simple("SELECT ifnull(usuario_nombre, 'Sin vendedor') as usuario_nombre FROM usuario WHERE usuario_id=$vendedor");
				$usuario=$check_usuario->fetch();
				$usuario_nombre = $usuario['usuario_nombre'];

				$check_usuario->closeCursor();
				$check_usuario=mainModel::desconectar($check_usuario);
			}
			else{
				$vendedor = "";
				$usuario_nombre = "";
			}
            
            /*== Preparando datos para enviarlos al modelo ==*/
			$datos_cliente_reg=[
            	"cliente_codigo"=>[
					"campo_marcador"=>":Codigo",
					"campo_valor"=>$codigo_cliente
                ],
				"cliente_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
                ],
                "cliente_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
                ],
                "cliente_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>utf8_decode($nombre)
                ],
                "cliente_estado"=>[
					"campo_marcador"=>":Pais",
					"campo_valor"=>utf8_decode($pais)
                ],
                "cliente_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>utf8_decode($direccion)
                ],
                "cliente_cordenada"=>[
					"campo_marcador"=>":Coordenada",
					"campo_valor"=>""
                ],
                "cliente_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
                ],
                "cliente_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"cliente_tipo"=>[
					"campo_marcador"=>":TipoCliente",
					"campo_valor"=>$cliente_tipo
				],
				"cliente_sitioweb"=>[
					"campo_marcador"=>":Webpage",
					"campo_valor"=>$webpage
				],
				"cliente_vendedor_id"=>[
					"campo_marcador"=>":VendedorId",
					"campo_valor"=>$vendedor
				],
				"cliente_vendedor_nombre"=>[
					"campo_marcador"=>":VendedorNombre",
					"campo_valor"=>$usuario_nombre
				],
				"cliente_metodo_pago"=>[
					"campo_marcador"=>":MetodoPago",
					"campo_valor"=>$metodo_pago
				],
				"cliente_precio"=>[
					"campo_marcador"=>":Precio",
					"campo_valor"=>$precio_valor
				],
				"cliente_cumpleaños"=>[
					"campo_marcador"=>":Cumpleano",
					"campo_valor"=>$cumple
				],
				"cliente_ruta"=>[
					"campo_marcador"=>":Ruta",
					"campo_valor"=>""
				]
            ];

            $agregar_cliente=mainModel::guardar_datos("cliente",$datos_cliente_reg);
			if($agregar_cliente->rowCount()==0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el cliente, por favor intente nuevamente ".$codigo_cliente,
					"Datos"=>"tipo_documento: ".$tipo_documento." numero_documento: ".$numero_documento." nombre: ".$nombre." pais: ".$pais." direccion: ".$direccion." telefono: ".$telefono." email: ".$email." cliente_tipo".$cliente_tipo." vendedor: ".$vendedor." usuario_nombre: ".$usuario_nombre." precio_valor: ".$precio_valor." cumple: ".$cumple,
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
			}

			$agregar_cliente->closeCursor();
			$agregar_cliente=mainModel::desconectar($agregar_cliente);
        } /*-- Fin controlador --*/

        /*---------- Controlador agregar cliente ----------*/
        public function agregar_cliente_controlador(){

            $tipo_documento=mainModel::limpiar_cadena($_POST['cliente_tipo_documento_reg']);
            $numero_documento=mainModel::limpiar_cadena($_POST['cliente_numero_documento_reg']);
            $nombre=mainModel::limpiar_cadena($_POST['cliente_nombre_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_reg']);
            $email=mainModel::limpiar_cadena($_POST['cliente_email_reg']);
			$webpage=mainModel::limpiar_cadena($_POST['cliente_pagina_reg']);
			$cliente_tipo=mainModel::limpiar_cadena($_POST['cliente_tipo']);
			$pais=mainModel::limpiar_cadena($_POST['cliente_pais_reg']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_reg']);
            $direccion_google=mainModel::limpiar_cadena($_POST['cliente_direccion_google_reg']);
			$vendedor=mainModel::limpiar_cadena($_POST['cliente_vendedor_reg']);
			$metodo_pago=mainModel::limpiar_cadena($_POST['cliente_metodo_pago_reg']);
			$precio=mainModel::limpiar_cadena($_POST['cliente_precio_reg']);
			$cumple=mainModel::limpiar_cadena($_POST['cliente_cumple_reg']);
			$ruta=mainModel::limpiar_cadena($_POST['cliente_ruta_reg']);

            /*== comprobar campos vacios ==*/
            if($nombre=="" || $pais=="" || $direccion=="" || $telefono=="" || $cliente_tipo=="" || $vendedor =="" || $precio=="" || $metodo_pago==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }
 			  
            /*== Verificando integridad de los datos ==*/
			if(mainModel::verificar_datos("[a-zA-Z0-9-]{7,30}",$numero_documento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El número de documento no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El teléfono no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            } 
			
			/*== Comprobando documento ==*/
            $check_documento=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_tipo_documento='$tipo_documento' AND cliente_numero_documento='$numero_documento'");
			if($check_documento->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El número y tipo de documento ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_documento->closeCursor();
			$check_documento=mainModel::desconectar($check_documento);

            /*== Comprobando email ==*/
			if($email!=""){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Ha ingresado un correo electrónico no valido.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
            }

			if($tipo_documento == null || $tipo_documento == ""){
				$tipo_documento = "Cedula";
			}

			$codigo_cliente = "C0001";
			$check_cliente_id=mainModel::ejecutar_consulta_simple("select IFNULL(cliente_id, 0) as cliente_id from cliente order by cliente_id desc limit 1");
			if($check_cliente_id->rowCount()>=1){
				$check_cliente_id=$check_cliente_id->fetchAll();
				foreach($check_cliente_id as $rows){

					$secuencial = number_format($rows['cliente_id']) + 1; 
					if(number_format($rows['cliente_id']) < 9){
						$codigo_cliente = "C000".$secuencial;
					}
					elseif(number_format($rows['cliente_id']) > 9 and number_format($rows['cliente_id']) < 99){
						$codigo_cliente = "C00".$secuencial;
					}
					elseif(number_format($rows['cliente_id']) > 99 and number_format($rows['cliente_id']) < 999){
						$codigo_cliente = "C0".$secuencial;
					}
					else{
						$codigo_cliente = "C".$secuencial;
					}
				}
			}

			/*== Buscando el nombre del vendedor ==*/
            $check_usuario=mainModel::ejecutar_consulta_simple("SELECT usuario_nombre FROM usuario WHERE usuario_id=$vendedor ");
            $usuario=$check_usuario->fetch();
			$check_usuario->closeCursor();
			$check_usuario=mainModel::desconectar($check_usuario);
            
            /*== Preparando datos para enviarlos al modelo ==*/
			$datos_cliente_reg=[
            	"cliente_codigo"=>[
					"campo_marcador"=>":Codigo",
					"campo_valor"=>$codigo_cliente
                ],
				"cliente_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
                ],
                "cliente_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
                ],
                "cliente_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
                ],
                "cliente_estado"=>[
					"campo_marcador"=>":Pais",
					"campo_valor"=>$pais
                ],
                "cliente_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
                ],
                "cliente_cordenada"=>[
					"campo_marcador"=>":Coordenada",
					"campo_valor"=>$direccion_google
                ],
                "cliente_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
                ],
                "cliente_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"cliente_tipo"=>[
					"campo_marcador"=>":TipoCliente",
					"campo_valor"=>$cliente_tipo
				],
				"cliente_sitioweb"=>[
					"campo_marcador"=>":Webpage",
					"campo_valor"=>$webpage
				],
				"cliente_vendedor_id"=>[
					"campo_marcador"=>":VendedorId",
					"campo_valor"=>$vendedor
				],
				"cliente_vendedor_nombre"=>[
					"campo_marcador"=>":VendedorNombre",
					"campo_valor"=>$usuario['usuario_nombre']
				],
				"cliente_metodo_pago"=>[
					"campo_marcador"=>":MetodoPago",
					"campo_valor"=>$metodo_pago
				],
				"cliente_precio"=>[
					"campo_marcador"=>":Precio",
					"campo_valor"=>$precio
				],
				"cliente_cumpleaños"=>[
					"campo_marcador"=>":Cumpleano",
					"campo_valor"=>$cumple
				],
				"cliente_ruta"=>[
					"campo_marcador"=>":Ruta",
					"campo_valor"=>$ruta
				]
            ];

            $agregar_cliente=mainModel::guardar_datos("cliente",$datos_cliente_reg);
			if($agregar_cliente->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"¡Cliente registrado!",
					"Texto"=>"Los datos del cliente se registraron con éxito en el sistema",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el cliente, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}

			$agregar_cliente->closeCursor();
			$agregar_cliente=mainModel::desconectar($agregar_cliente);

			echo json_encode($alerta);
        } /*-- Fin controlador --*/

		/*----------  Controlador actualizar cliente  ----------*/
		public function actualizar_cliente_controlador(){

			/*== Recibiendo id del cliente ==*/
			$id=mainModel::limpiar_cadena($_POST['cliente_id_up']);

			/*== Comprobando cliente por defecto ==*/
			if($id==1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos actualizar los datos de este cliente ya que es el definido por defecto (Publico en general).",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando cliente en la DB ==*/
			$check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id'");
			if($check_cliente->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el cliente en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos=$check_cliente->fetch();
			}
			$check_cliente->closeCursor();
			$check_cliente=mainModel::desconectar($check_cliente);

			/*== Recibiendo datos del cliente ==*/
			$tipo_documento=mainModel::limpiar_cadena($_POST['cliente_tipo_documento_up']);
            $numero_documento=mainModel::limpiar_cadena($_POST['cliente_numero_documento_up']);
            $nombre=mainModel::limpiar_cadena($_POST['cliente_nombre_up']);
            $pais=mainModel::limpiar_cadena($_POST['cliente_pais_up']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_up']);
            $direccion_google=mainModel::limpiar_cadena($_POST['cliente_direccion_google_up']);
            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_up']);
            $email=mainModel::limpiar_cadena($_POST['cliente_email_up']);
			$webpage=mainModel::limpiar_cadena($_POST['cliente_pagina_reg']);
			$cliente_tipo=mainModel::limpiar_cadena($_POST['cliente_tipo']);
			$vendedor=mainModel::limpiar_cadena($_POST['cliente_vendedor_up']);
			$metodo_pago=mainModel::limpiar_cadena($_POST['cliente_metodo_pago_up']);
			$precio=mainModel::limpiar_cadena($_POST['cliente_precio_up']);
			$cumple=mainModel::limpiar_cadena($_POST['cliente_cumple_up']);
			$ruta=mainModel::limpiar_cadena($_POST['cliente_ruta_up']);

            /*== comprobar campos vacios ==*/
            if($numero_documento=="" || $nombre=="" || $pais=="" || $direccion=="" || $telefono=="" || $metodo_pago=="" || $precio=="" || $vendedor==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Verificando integridad de los datos ==*/
			if(mainModel::verificar_datos("[a-zA-Z0-9-]{7,30}",$numero_documento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El número de documento no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El teléfono no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando tipo de documento ==*/
			if(!in_array($tipo_documento, DOCUMENTOS_USUARIOS)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tipo de documento no es correcto.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Comprobando documento ==*/
			if($tipo_documento!=$campos['cliente_tipo_documento'] || $numero_documento!=$campos['cliente_numero_documento']){
				$check_documento=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_tipo_documento='$tipo_documento' AND cliente_numero_documento='$numero_documento'");
				if($check_documento->rowCount()>0){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El número y tipo de documento ingresado ya se encuentra registrado en el sistema",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
				$check_documento->closeCursor();
				$check_documento=mainModel::desconectar($check_documento);
			}  

            /*== Comprobando email ==*/
			if($email!=""){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Ha ingresado un correo electrónico no valido.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			/*== Buscando el nombre del vendedor ==*/
            $check_usuario=mainModel::ejecutar_consulta_simple("SELECT usuario_nombre FROM usuario WHERE usuario_id=$vendedor");
            $usuario=$check_usuario->fetch();
			$check_usuario->closeCursor();
			$check_usuario=mainModel::desconectar($check_usuario);
			
			/*== Preparando datos para enviarlos al modelo ==*/
			$datos_cliente_up=[
                "cliente_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
                ],
                "cliente_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
                ],
                "cliente_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
                ],
                "cliente_estado"=>[
					"campo_marcador"=>":Pais",
					"campo_valor"=>$pais
                ],
                "cliente_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
                ],
                "cliente_cordenada"=>[
					"campo_marcador"=>":Cordenada",
					"campo_valor"=>$direccion_google
                ],
                "cliente_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
                ],
                "cliente_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"cliente_tipo"=>[
					"campo_marcador"=>":TipoCliente",
					"campo_valor"=>$cliente_tipo
				],
				"cliente_sitioweb"=>[
					"campo_marcador"=>":Webpage",
					"campo_valor"=>$webpage
				],
				"cliente_vendedor_id"=>[
					"campo_marcador"=>":VendedorId",
					"campo_valor"=>$vendedor
				],
				"cliente_vendedor_nombre"=>[
					"campo_marcador"=>":VendedorNombre",
					"campo_valor"=>$usuario['usuario_nombre']
				],
				"cliente_metodo_pago"=>[
					"campo_marcador"=>":MetodoPago",
					"campo_valor"=>$metodo_pago
				],
				"cliente_precio"=>[
					"campo_marcador"=>":Precio",
					"campo_valor"=>$precio
				],
				"cliente_cumpleaños"=>[
					"campo_marcador"=>":Cumpleano",
					"campo_valor"=>$cumple
				],
				"cliente_ruta"=>[
					"campo_marcador"=>":Ruta",
					"campo_valor"=>$ruta
				]
			];
			
			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if(mainModel::actualizar_datos("cliente",$datos_cliente_up,$condicion)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Cliente actualizado!",
					"Texto"=>"Los datos del cliente se actualizaron con éxito en el sistema",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos del cliente, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador --*/


		/*----------  Controlador eliminar cliente  ----------*/
		public function eliminar_cliente_controlador(){

			/*== Recuperando id del cliente ==*/
			$id=mainModel::decryption($_POST['cliente_id_del']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando cliente principal ==*/
			if($id==1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar los datos de este cliente ya que es el definido por defecto (Publico en general)",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando cliente en la BD ==*/
			$check_cliente=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_id='$id'");
			if($check_cliente->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El cliente que intenta eliminar no existe en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_cliente->closeCursor();
			$check_cliente=mainModel::desconectar($check_cliente);

			/*== Comprobando ventas ==*/
			$check_ventas=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM venta WHERE cliente_id='$id' LIMIT 1");
			if($check_ventas->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar el cliente debido a que tiene ventas asociadas.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_ventas->closeCursor();
			$check_ventas=mainModel::desconectar($check_ventas);

			$eliminar_cliente=mainModel::eliminar_registro("cliente","cliente_id",$id);

			if($eliminar_cliente->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Cliente eliminado!",
					"Texto"=>"El cliente ha sido eliminado del sistema exitosamente.",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido eliminar el cliente del sistema, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
			}

			$eliminar_cliente->closeCursor();
			$eliminar_cliente=mainModel::desconectar($eliminar_cliente);

			echo json_encode($alerta);
		} /*-- Fin controlador --*/
    }