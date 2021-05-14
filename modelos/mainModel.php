<?php

	if($peticion_ajax){
		require_once "../config/SERVER.php";
	}else{
		require_once "./config/SERVER.php";
	}
 
	class mainModel{

		/*----------  Funcion conectar a BD  ----------*/
		protected static function conectar(){
			date_default_timezone_set("America/Panama");
			$conexion = new PDO(SGBD,USER,PASS);
			$conexion->exec("SET CHARACTER SET utf8");
			return $conexion;
		} /*--  Fin Funcion --*/


		/*----------  Funcion desconectar de DB  ----------*/
		public function desconectar($consulta){
			global $conexion, $consulta;
			$consulta=null;
			$conexion=null;
			return $consulta;
		} /*--  Fin Funcion --*/


		/*----------  Funcion ejecutar consultas simples  ----------*/
		protected static function ejecutar_consulta_simple($consulta){
			$sql=self::conectar()->prepare($consulta);
			$sql->execute();
			return $sql;
		} /*--  Fin Funcion --*/


		/*----------  Funcion para ejecutar una consulta INSERT preparada  ----------*/
		protected static function guardar_datos($tabla,$datos){
			$query="INSERT INTO $tabla (";
			$C=0;
			foreach ($datos as $campo => $indice){
				if($C<=0){
					$query.=$campo;
				}else{
					$query.=",".$campo;
				}
				$C++;
			}
			
			$query.=") VALUES(";
			$Z=0;
			foreach ($datos as $campo => $indice){
				if($Z<=0){
					$query.=$indice["campo_marcador"];
				}else{
					$query.=",".$indice["campo_marcador"];
				}
				$Z++;
			}
			$query.=")";

			$sql=self::conectar()->prepare($query);
			foreach ($datos as $campo => $indice){
				$sql->bindParam($indice["campo_marcador"],$indice["campo_valor"]);
			}

			$sql->execute();
			return $sql;
		} /*-- Fin Funcion --*/


		/*---------- Funcion datos tabla ----------*/
        public function datos_tabla($tipo,$tabla,$campo,$id){
			//$tipo=self::limpiar_cadena($tipo);
			//$tabla=self::limpiar_cadena($tabla);
			$campo=self::limpiar_cadena($campo);
            if($tipo=="Unico"){
                $sql=self::conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
                $sql->bindParam(":ID",$id);
            }elseif($tipo=="Normal"){
                $sql=self::conectar()->prepare("SELECT $campo FROM $tabla");
            }elseif($tipo=="Sum"){
				$select_data="SELECT IFNULL(sum(pago_monto), 0) as pagado FROM pago WHERE venta_codigo='$id'";
                $sql=self::conectar()->prepare($select_data);
            }elseif($tipo=="query"){
                $sql=self::conectar()->prepare($tabla);
            }

            $sql->execute();
            return $sql;
		} /*-- Fin Funcion --*/


		/*----------  Funcion para ejecutar una consulta UPDATE preparada  ----------*/
		protected static function actualizar_datos($tabla,$datos,$condicion){
			$query="UPDATE $tabla SET ";

			$C=0;
			foreach ($datos as $campo => $indice){
				if($C<=0){
					$query.=$campo."=".$indice["campo_marcador"];
				}else{
					$query.=",".$campo."=".$indice["campo_marcador"];
				}
				$C++;
			}

			$query.=" WHERE ".$condicion["condicion_campo"]."=".$condicion["condicion_marcador"];
			$sql=self::conectar()->prepare($query);

			foreach ($datos as $campo => $indice){
				$sql->bindParam($indice["campo_marcador"],$indice["campo_valor"]);
			}

			$sql->bindParam($condicion["condicion_marcador"],$condicion["condicion_valor"]);
			$sql->execute();

			return $sql;
		} /*-- Fin Funcion --*/
		

		/*---------- Funcion eliminar registro ----------*/
        protected static function eliminar_registro($tabla,$campo,$id){
            $sql=self::conectar()->prepare("DELETE FROM $tabla WHERE $campo=:ID");

            $sql->bindParam(":ID",$id);
            $sql->execute();
            
            return $sql;
        } /*-- Fin Funcion --*/


		/*----------  Encriptar cadenas ----------*/
		public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		} /*--  Fin Funcion --*/


		/*----------  Desencriptar cadenas  ----------*/
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		} /*--  Fin Funcion --*/


		/*----------  Limitar cadenas de texto  ----------*/
		public function limitar_cadena($cadena,$limite,$sufijo){
			if(strlen($cadena)>$limite){
				return substr($cadena,0,$limite).$sufijo;
			}else{
				return $cadena;
			}
		} /*--  Fin Funcion --*/


		/*----------  Funcion generar codigos aleatorios  ----------*/
		protected static function generar_codigo_aleatorio($longitud,$correlativo){
			$codigo="";
			$caracter="Letra";
			for($i=1; $i<=$longitud; $i++){
				if($caracter=="Letra"){
					$letra_aleatoria=chr(rand(ord("a"),ord("z")));
					$letra_aleatoria=strtoupper($letra_aleatoria);
					$codigo.=$letra_aleatoria;
					$caracter="Numero";
				}else{
					$numero_aleatorio=rand(0,9);
					$codigo.=$numero_aleatorio;
					$caracter="Letra";
				}
			}
			return $codigo."-".$correlativo;
		} /*--  Fin Funcion --*/


		/*----------  Funcion limpiar cadenas  ----------*/
		protected static function limpiar_cadena($cadena){
			$cadena=trim($cadena);
			$cadena=stripslashes($cadena);
			$cadena=str_ireplace("<script>", "", $cadena);
			$cadena=str_ireplace("</script>", "", $cadena);
			$cadena=str_ireplace("<script src", "", $cadena);
			$cadena=str_ireplace("<script type=", "", $cadena);
			$cadena=str_ireplace("SELECT * FROM", "", $cadena);
			$cadena=str_ireplace("DELETE FROM", "", $cadena);
			$cadena=str_ireplace("INSERT INTO", "", $cadena);
			$cadena=str_ireplace("DROP TABLE", "", $cadena);
			$cadena=str_ireplace("DROP DATABASE", "", $cadena);
			$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
			$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
			$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
			$cadena=str_ireplace("<?php", "", $cadena);
			$cadena=str_ireplace("?>", "", $cadena);
			$cadena=str_ireplace("--", "", $cadena);
			$cadena=str_ireplace("^", "", $cadena);
			$cadena=str_ireplace("<", "", $cadena);
			$cadena=str_ireplace(">", "", $cadena);
			$cadena=str_ireplace("[", "", $cadena);
			$cadena=str_ireplace("]", "", $cadena);
			$cadena=str_ireplace("==", "", $cadena);
			$cadena=str_ireplace(";", "", $cadena);
			$cadena=str_ireplace("::", "", $cadena);
			$cadena=trim($cadena);
			$cadena=stripslashes($cadena);
			return $cadena;
		} /*--  Fin Funcion --*/


		/*---------- Funcion verificar datos (expresion regular) ----------*/
		protected static function verificar_datos($filtro,$cadena){
			if(preg_match("/^".$filtro."$/", $cadena)){
				return false;
            }else{
                return true;
            }
		} /*--  Fin Funcion --*/


		/*---------- Funcion verificar fechas ----------*/
		protected static function verificar_fecha($fecha){
			$valores=explode('-',$fecha);
			if(count($valores)==3 && checkdate($valores[1], $valores[2], $valores[0])){
				return false;
			}else{
				return true;
			}
		} /*--  Fin Funcion --*/


		/*---------- Funcion obtener nombre de mes ----------*/
		public function obtener_nombre_mes($mes){
			switch($mes){
				case 1:
					$nombre_mes="enero";
				break;
				case 2:
					$nombre_mes="febrero";
				break;
				case 3:
					$nombre_mes="marzo";
				break;
				case 4:
					$nombre_mes="abril";
				break;
				case 5:
					$nombre_mes="mayo";
				break;
				case 6:
					$nombre_mes="junio";
				break;
				case 7:
					$nombre_mes="julio";
				break;
				case 8:
					$nombre_mes="agosto";
				break;
				case 9:
					$nombre_mes="septiembre";
				break;
				case 10:
					$nombre_mes="octubre";
				break;
				case 11:
					$nombre_mes="noviembre";
				break;
				case 12:
					$nombre_mes="diciembre";
				break;
				default:
					$nombre_mes="No definido";
				break;
			}
			return $nombre_mes;
		} /*--  Fin Funcion --*/


		/*----------  Funcion paginador de tablas ----------*/
		protected static function paginador_tablas($pagina,$Npaginas,$url,$botones){
			$tabla='<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

			if($pagina==1){
				$tabla.='<li class="page-item disabled" ><a class="page-link" ><i class="fas fa-angle-double-left"></i></a></li>';
			}else{
				$tabla.='
				<li class="page-item" ><a class="page-link" href="'.$url.'1/"><i class="fas fa-angle-double-left"></i></a></li>
				<li class="page-item" ><a class="page-link" href="'.$url.($pagina-1).'/">Anterior</a></li>
				';
			}

			$ci=0;
			for($i=$pagina; $i<=$Npaginas; $i++){
				if($ci>=$botones){
					break;
				}
				if($pagina==$i){
					$tabla.='<li class="page-item" ><a class="page-link active" href="'.$url.$i.'/">'.$i.'</a></li>';
				}else{
					$tabla.='<li class="page-item" ><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>';
				}
				$ci++;
			}

			if($pagina==$Npaginas){
				$tabla.='<li class="page-item disabled" ><a class="page-link" ><i class="fas fa-angle-double-right"></i></a></li>';
			}else{
				$tabla.='
				<li class="page-item" ><a class="page-link" href="'.$url.($pagina+1).'/">Siguiente</a></li>
				<li class="page-item" ><a class="page-link" href="'.$url.$Npaginas.'/"><i class="fas fa-angle-double-right"></i></a></li>
				';
			}

			$tabla.='</ul></nav>';
			return $tabla;
		} /*--  Fin Funcion --*/


		/*----------  Funcion generar select ----------*/
		public function generar_select($datos,$campo_db){
			$check_select='';
			$text_select='';
			$count_select=1;
			$select='';
			foreach($datos as $row){

				if($campo_db==$row){
					$check_select='selected=""';
					$text_select=' (Actual)';
				}

				$select.='<option value="'.$row.'" '.$check_select.'>'.$count_select.' - '.$row.$text_select.'</option>';

				$check_select='';
				$text_select='';
				$count_select++;
			}
			return $select;
		} /*--  Fin Funcion --*/

		
		/*----------  Funcion enrutador ----------*/
		public function enrutador($clave,$tipo,$parametro){
			$rutas=[
				"dashboard"=>[
					"vista"=>"dashboard",
					"icono"=>"fas fa-tachometer-alt",
					"nombre"=>"Escritorio",
				],
				"usuario_new"=>[
					"vista"=>"user-new",
					"icono"=>"fas fa-user-tie",
					"nombre"=>"Nuevo usuario",
				],
				"usuario_list"=>[
					"vista"=>"user-list",
					"icono"=>"fas fa-clipboard-list",
					"nombre"=>"Lista de usuarios",
				],
				"usuario_search"=>[
					"vista"=>"user-search",
					"icono"=>"fas fa-search",
					"nombre"=>"Buscar usuario",
				],
				"usuario_update"=>[
					"vista"=>"user-update",
					"icono"=>"fas fa-sync",
					"nombre"=>"Actualize sus datos",
				],
				"caja_new"=>[
					"vista"=>"cashier-new",
					"icono"=>"fas fa-cash-register",
					"nombre"=>"Nueva caja",
				],
				"caja_list"=>[
					"vista"=>"cashier-list",
					"icono"=>"fas fa-clipboard-list",
					"nombre"=>"Lista de cajas",
				],
				"caja_search"=>[
					"vista"=>"cashier-search",
					"icono"=>"fas fa-search",
					"nombre"=>"Buscar caja",
				],
				"caja_update"=>[
					"vista"=>"cashier-update",
					"icono"=>"fas fa-sync",
					"nombre"=>"Actualizar caja",
				],
				"categoria_new"=>[
					"vista"=>"category-new",
					"icono"=>"fas fa-tags",
					"nombre"=>"Nueva categoría",
				],
				"categoria_list"=>[
					"vista"=>"category-list",
					"icono"=>"fas fa-clipboard-list",
					"nombre"=>"Lista de categorías",
				],
				"categoria_search"=>[
					"vista"=>"category-search",
					"icono"=>"fas fa-search",
					"nombre"=>"Buscar categoría",
				],
				"categoria_update"=>[
					"vista"=>"category-update",
					"icono"=>"fas fa-sync",
					"nombre"=>"Actualizar categoría",
				],
				"categoria_producto"=>[
					"vista"=>"product-category",
					"icono"=>"fab fa-shopify",
					"nombre"=>"Productos por categoría",
				],
				"empresa_new"=>[
					"vista"=>"company",
					"icono"=>"fas fa-store-alt",
					"nombre"=>"Datos de la empresa",
				],
				"cliente_new"=>[
					"vista"=>"client-new",
					"icono"=>"fas fa-child",
					"nombre"=>"Nuevo Cliente",
				],
				"cliente_new_carga"=>[
					"vista"=>"client-new-carga",
					"icono"=>"fas fa-child",
					"nombre"=>"Agregar cliente",
				],
				"cliente_list"=>[
					"vista"=>"client-list",
					"icono"=>"fas fa-clipboard-list",
					"nombre"=>"Lista de clientes",
				],
				"cliente_search"=>[
					"vista"=>"client-search",
					"icono"=>"fas fa-search",
					"nombre"=>"Buscar cliente",
				],
				"cliente_update"=>[
					"vista"=>"client-update",
					"icono"=>"fas fa-sync",
					"nombre"=>"Actualizar información cliente",
				],
				"cliente_detail"=>[
					"vista"=>"client-detail",
					"icono"=>"fas fa-cart-plus",
					"nombre"=>"Estado de cuenta del cliente",
				],
				"movimiento_new"=>[
					"vista"=>"movement-new",
					"icono"=>"far fa-money-bill-alt",
					"nombre"=>"Nuevo movimiento",
				],
				"movimiento_list"=>[
					"vista"=>"movement-list",
					"icono"=>"fas fa-money-check-alt",
					"nombre"=>"Facturas pagadas",
				],
				"movimiento_pending_list"=>[
					"vista"=>"movement-pending",
					"icono"=>"fas fa-money-check-alt",
					"nombre"=>"Cobros pendientes",
				],
				"movimiento_search"=>[
					"vista"=>"movement-search",
					"icono"=>"fas fa-search-dollar",
					"nombre"=>"Buscar cobros",
				],
				"producto_new"=>[
					"vista"=>"product-new",
					"icono"=>"fas fa-box",
					"nombre"=>"Nuevo producto",
				],
				"producto_list"=>[
					"vista"=>"product-list",
					"icono"=>"fas fa-boxes",
					"nombre"=>"Productos en almacen",
				],
				"producto_expiration"=>[
					"vista"=>"product-expiration",
					"icono"=>"fas fa-history",
					"nombre"=>"Productos por vencimiento",
				],
				"producto_minimum_stock"=>[
					"vista"=>"product-minimum",
					"icono"=>"fas fa-stopwatch-20",
					"nombre"=>"Productos en stock mínimo",
				],
				"producto_search"=>[
					"vista"=>"product-search",
					"icono"=>"fas fa-search",
					"nombre"=>"Buscar productos",
				],
				"producto_update"=>[
					"vista"=>"product-update",
					"icono"=>"fas fa-sync",
					"nombre"=>"Actualizar producto",
				],
				"producto_sold"=>[
					"vista"=>"product-sold",
					"icono"=>"fas fa-fire-alt",
					"nombre"=>"Lo más vendido",
				],
				"producto_info"=>[
					"vista"=>"product-info",
					"icono"=>"fas fa-box-open",
					"nombre"=>"Información del producto",
				],
				"producto_image"=>[
					"vista"=>"product-image",
					"icono"=>"far fa-image",
					"nombre"=>"Gestionar imagen",
				],
				"venta_new"=>[
					"vista"=>"sale-new",
					"icono"=>"fas fa-cart-plus",
					"nombre"=>"Nuevos pedidos",
				],
				"venta_wholesale"=>[
					"vista"=>"sale-new/wholesale",
					"icono"=>"fas fa-parachute-box",
					"nombre"=>"Venta por mayoreo",
				],
				"venta_list"=>[
					"vista"=>"sale-list",
					"icono"=>"fas fa-coins",
					"nombre"=>"Pedidos realizados",
				],
				"venta_search_date"=>[
					"vista"=>"sale-search-date",
					"icono"=>"fas fa-search-dollar",
					"nombre"=>"Buscar pedido (Fecha)",
				],
				"venta_search_code"=>[
					"vista"=>"sale-search-code",
					"icono"=>"fas fa-search-dollar",
					"nombre"=>"Buscar pedido (Código)",
				],
				"venta_detail"=>[
					"vista"=>"sale-detail",
					"icono"=>"fas fa-cart-plus",
					"nombre"=>"Detalles del pedido",
				],
				"venta_pending"=>[
					"vista"=>"sale-pending",
					"icono"=>"fab fa-creative-commons-nc",
					"nombre"=>"Pendiente por entregar",
				],
				"devolucion_list"=>[
					"vista"=>"return-list",
					"icono"=>"fas fa-people-carry",
					"nombre"=>"Devoluciones realizadas",
				],
				"devolucion_search"=>[
					"vista"=>"return-search",
					"icono"=>"fas fa-dolly-flatbed",
					"nombre"=>"Buscar devoluciones",
				],
				"reporte_sale"=>[
					"vista"=>"report-sales",
					"icono"=>"fas fa-hand-holding-usd",
					"nombre"=>"Reportes de ventas",
				],
				"sale_manual"=>[
					"vista"=>"sale-manual",
					"icono"=>"fas fa-hand-holding-usd",
					"nombre"=>"Crear venta manual",
				],
				"sale_sending"=>[
					"vista"=>"sale-sending",
					"icono"=>"fas fa-hand-holding-usd",
					"nombre"=>"Entrega de paquetes",
				],
				"sale"=>[
					"vista"=>"sale-new",
					"icono"=>"fas fa-hand-holding-usd",
					"nombre"=>"Módulos de ventas",
				],
				"movement"=>[
					"vista"=>"movement-list",
					"icono"=>"fas fa-money-check-alt",
					"nombre"=>"Módulo de cobros",
				],
				"client"=>[
					"vista"=>"client-list",
					"icono"=>"fas fa-child",
					"nombre"=>"Módulo de clientes",
				],
				"user"=>[
					"vista"=>"user-list",
					"icono"=>"fas fa-child",
					"nombre"=>"Módulo de usuarios",
				],
				"configure"=>[
					"vista"=>"company",
					"icono"=>"fas fa-store-alt",
					"nombre"=>"Datos de la empresa",
				]
			];

			if($tipo=="nuevo"){
				$enlace='<a href="'.SERVERURL.$rutas[$clave]["vista"].'/" class="btn btn-info"><i class="fas fa-plus"></i> &nbsp; '.$rutas[$clave]["nombre"].'</a>';
			}elseif($tipo=="lista"){
				$enlace='<a href="'.SERVERURL.$rutas[$clave]["vista"].'/" class="btn btn-success"><i class="fas fa-list-ul"></i> &nbsp; '.$rutas[$clave]["nombre"].'</a>';
			}elseif($tipo=="pendiente"){
				$enlace='<a href="'.SERVERURL.$rutas[$clave]["vista"].'/" class="btn btn-success"><i class="fas fa-dolly"></i> &nbsp; '.$rutas[$clave]["nombre"].'</a>';
			}elseif($tipo=="buscar"){
				$enlace='<a href="'.SERVERURL.$rutas[$clave]["vista"].'/" class="btn btn-success"><i class="far fa-calendar-alt"></i> &nbsp; '.$rutas[$clave]["nombre"].'</a>';
			}elseif($tipo=="activo"){
				$enlace='<a class="active" href="'.SERVERURL.$rutas[$clave]["vista"].'/"><i class="'.$rutas[$clave]["icono"].' fa-fw"></i> &nbsp; '.$rutas[$clave]["nombre"].'</a>';
			}elseif($tipo=="inactivo"){
				$enlace='<a href="'.SERVERURL.$rutas[$clave]["vista"].'/"><i class="'.$rutas[$clave]["icono"].' fa-fw"></i> &nbsp; '.$rutas[$clave]["nombre"].'</a>';
			}elseif($tipo=="parametro"){
				$enlace='<a href="'.SERVERURL.$rutas[$clave]["vista"].'/'.$parametro.'/"><i class="'.$rutas[$clave]["icono"].' fa-fw"></i> &nbsp; '.$rutas[$clave]["nombre"].'</a>';
			}elseif($tipo=="encabezado"){
				$enlace='<i class="'.$rutas[$clave]["icono"].' fa-fw"></i> &nbsp; '.$rutas[$clave]["nombre"];
			}elseif($tipo=="btn_update" || $tipo=="btn_info"){
				if($tipo=="btn_update"){
					$btn_class="btn-success";
				}elseif($tipo=="btn_info"){
					$btn_class="btn-info";
				}
				$enlace='<a class="btn '.$btn_class.'" href="'.SERVERURL.$rutas[$clave]["vista"].'/'.$parametro.'/"><i class="'.$rutas[$clave]["icono"].' fa-fw"></i></a>';
			}
			return $enlace;
		} /*--  Fin Funcion --*/
	}