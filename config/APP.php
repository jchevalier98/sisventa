<?php

	/*----------  Ruta o dominio del servidor  ----------*/
	const SERVERURL="http://localhost/SVIL/";


	/*----------  Nombre de la empresa o compañia  ----------*/
	const COMPANY="MASTER MARKET - PANAMA";


	/*----------  Configuración de moneda  ----------*/
	const MONEDA_SIMBOLO="$";
	const MONEDA_NOMBRE="USD";
	const MONEDA_DECIMALES="2";
	const MONEDA_SEPARADOR_MILLAR=",";
	const MONEDA_SEPARADOR_DECIMAL=".";

 
	/*----------  Tipos de documentos  ----------*/
	const DOCUMENTOS_USUARIOS=["Cedula","Licencia","Pasaporte","Otro"];
	const ESTADO_VENTA=["Pendiente","Entregado"];
	const TIPO_CARGA=["Normal","Otro"];
	const ENTREGA=["Foto","Firma"];
	const PRECIO=["2.50","2.40","2.35"];
	const METODO_PAGO=["Contado","Transferencia"];
	const USUARIOS_TIPO=["Personal","Juridico"];
	const DOCUMENTOS_EMPRESA=["DNI","Cedula","RUC","Otro"];
	const RUTA=["Ruta 1","Ruta 2","Ruta 3","Ruta 4","Ruta 5","Ruta 6"];
	const MES=["ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];


	/*----------  Tipos de unidades de productos  ----------*/
	const PRODUCTO_UNIDAD=["Unidad","Libra","Kilogramo","Caja","Paquete","Lata","Galon","Botella","Tira","Sobre","Bolsa","Saco","Tarjeta","Otro"];

	/*----------  Garantia de productos  ----------*/
	const GARANTIA_TIEMPO=["N/A","Dias","Semanas","Mes","Meses","Año","Años"];


	/*----------  Marcador de campos obligatorios  ----------*/
	const CAMPO_OBLIGATORIO='&nbsp; <i class="fab fa-font-awesome-alt"></i> &nbsp;';



	/*----------  Tamaño de papel de impresora termica (en milimetros)  
		THERMAL_PRINT_SIZE -> 80 | 57
	----------*/
	const THERMAL_PRINT_SIZE="80";


	/*----------  Zona horaria  ----------*/
	date_default_timezone_set("America/Panama");

	/*
		Configuración de zona horaria de tu país, para más información visita
		http://php.net/manual/es/function.date-default-timezone-set.php
		http://php.net/manual/es/timezones.php
	*/