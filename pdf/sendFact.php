<?php
	$peticion_ajax=true;
	require "code128.php";

	class PdfEmail extends mainModel
	{	
    	public function __construct(){}

		public function create_pdf($code_unico, $codes, $salida, $tipo){

			//$ins_venta = new cajaControlador();
			$datos_venta=mainModel::ejecutar_consulta_simple("select * from venta INNER JOIN cliente ON venta.cliente_codigo=cliente.cliente_codigo INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE venta_codigo = '$code_unico'","*",0);
			if($datos_venta->rowCount()==1){

				/*---------- Datos de la venta ----------*/
				$datos_venta=$datos_venta->fetch();
				/*---------- Seleccion de datos de la empresa ----------*/
				$datos_empresa=mainModel::ejecutar_consulta_simple("select * from empresa LIMIT 1","*",0);
				$datos_empresa=$datos_empresa->fetch();
 
				$pdf = new PDF_Code128('P','mm','Letter');
				$pdf->SetMargins(17,17,17);
				$pdf->AddPage();
				$pdf->Image($_SERVER['DOCUMENT_ROOT'].'/SVIL/vistas/assets/img/mmlogo.jpeg',165,12,35,35,'jpeg');

				if($tipo == "ENTREGA"){
					$pdf->SetFont('Arial','',40);
					$pdf->SetTextColor(52,52,51);
					$pdf->Cell(150,10,utf8_decode(strtoupper("CONFIRMACIÓN DE")),0,0,'L');
					$pdf->Ln(18);
					$pdf->Cell(150,10,utf8_decode(strtoupper("ENTREGA")),0,0,'L');
				}
				else{
					$pdf->SetFont('Arial','',40);
					$pdf->SetTextColor(52,52,51);
					$pdf->Cell(150,10,utf8_decode(strtoupper("FACTURA DE")),0,0,'L');
					$pdf->Ln(18);
					$pdf->Cell(150,10,utf8_decode(strtoupper("VENTA")),0,0,'L');
				}

				$pdf->Ln(12);
				$pdf->SetFont('Arial','',10);
				$pdf->SetTextColor(97,96,95);
				$pdf->Cell(150,10,utf8_decode(strtoupper("DOCUMENTO NO FISCAL")),0,0,'L');
				$pdf->Cell(50,10,utf8_decode(strtoupper("RUC: ". $datos_empresa['empresa_numero_documento'])),0,0,'L');

				$pdf->Ln(15);
				$pdf->SetFont('Arial','',10);
				$pdf->SetTextColor(97,96,95);
				$pdf->Cell(80,10,utf8_decode('Facturado a:'),0,0);

				if($tipo == "ENTREGA"){
					$pdf->Cell(80,10,utf8_decode("Entrega:"),0,0,'L');
					$pdf->Cell(100,10,utf8_decode(''),0,0,'L');
				}
				else{
					$pdf->Cell(80,10,utf8_decode("Factura:"),0,0,'L');
					$pdf->Cell(100,10,utf8_decode('Balance:'),0,0,'L');
				}
				
				$pdf->Ln(6);
				$pdf->SetFont('Arial','',10);
				$pdf->SetTextColor(97,96,95);
				$pdf->Cell(66,8,utf8_decode($datos_venta['cliente_nombre']),0,0,'L');
				$pdf->Cell(35,8,utf8_decode(strtoupper($datos_venta['venta_id'])),0,0,'C');

				$pdf->Ln(6);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(80,8,utf8_decode($datos_venta['cliente_tipo_documento'].": ".$datos_venta['cliente_numero_documento']),0,0,'L');
				$pdf->Cell(116,8,utf8_decode("Fecha: ".date("d/m/Y", strtotime($datos_venta['venta_fecha']))),0,0,'L');

				$pdf->Ln(6);
				$pdf->Cell(80,8,utf8_decode("Teléfono: ".$datos_venta['cliente_telefono']),0,0,'L');
				$pdf->Cell(134,8,utf8_decode("Vendedor: " . $datos_venta['usuario_nombre']." ".$datos_venta['usuario_apellido']),0,0,'L');

				$pdf->Ln(6);
				$pdf->Cell(150,8,utf8_decode($datos_venta['cliente_direccion']),0,0);
				
				$pdf->Ln(15);
				$pdf->SetFillColor(173,173,173);
				$pdf->SetDrawColor(173,173,173);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell(90,8,utf8_decode('Descripción'),1,0,'C',true);
				$pdf->Cell(15,8,utf8_decode('Unidades'),1,0,'C',true);
				$pdf->Cell(25,8,utf8_decode('Precio'),1,0,'C',true);
				$pdf->Cell(25,8,utf8_decode('Delivery'),1,0,'C',true);
				$pdf->Cell(30,8,utf8_decode('Total'),1,0,'C',true);

				$pdf->Ln();
				$pdf->SetFillColor(255,255,255);
				$pdf->SetDrawColor(255,255,255);
				$pdf->SetTextColor(255,255,255);

				$total = 0;
				$select = "select * from venta WHERE venta_codigo in (".$codes.")";
				$venta_detalle=mainModel::ejecutar_consulta_simple($select,"",0);
				$venta_detalle=$venta_detalle->fetchAll();
				foreach($venta_detalle as $detalle){
					
					$pdf->SetTextColor(97,96,95);
					$pdf->Cell(90,10,utf8_decode($detalle['venta_codigo']),'L',0,'C');
					$pdf->Cell(15,10,utf8_decode($detalle['venta_peso']." Lb."),'L',0,'C');
					
					if($tipo != "ENTREGA"){
					
						$pdf->Cell(25,10,utf8_decode("$ ".number_format($detalle['venta_precio_cliente'],2)),'L',0,'C');
						$pdf->Cell(25,10,utf8_decode("$ ".number_format($detalle['venta_delivery'],2)),'L',0,'C');
						$pdf->Cell(30,10,utf8_decode("$ ".number_format($detalle['venta_precio_venta'],2)),'LR',0,'C');

						$total += $detalle['venta_precio_venta'];
					}

					$pdf->Ln(6);
				}
				
				if($tipo != "ENTREGA"){
					$pdf->Ln(5);
					$pdf->SetFont('Arial','',10);
					$pdf->SetTextColor(39,39,51);
					$pdf->Cell(94,10,utf8_decode(''),'',0,'C');
					$pdf->Cell(14,10,utf8_decode(''),'',0,'C');
					$pdf->Cell(32,10,utf8_decode('Sub-Total:'),'T',0,'C');
					$pdf->Cell(61,10,utf8_decode("$ ".number_format($total,2).' '),'T',0,'C');

					$pdf->Ln(7);
					$pdf->Cell(95,10,utf8_decode(''),'',0,'C');
					$pdf->Cell(14,10,utf8_decode(''),'',0,'C');
					$pdf->Cell(32,10,utf8_decode('Descuento:'),'',0,'C');
					$pdf->Cell(59,10,utf8_decode("$ ".number_format("0.00",2).' '),'',0,'C');

					$pdf->Ln(7);
					$pdf->Cell(91,10,utf8_decode(''),'',0,'C');
					$pdf->Cell(14,10,utf8_decode(''),'',0,'C');
					$pdf->Cell(32,10,utf8_decode('Otros:'),'',0,'C');
					$pdf->Cell(67,10,utf8_decode("$ ".number_format("0.00",2).' '),'',0,'C');

					$pdf->Ln(7);
					$pdf->Cell(100,10,utf8_decode(''),'',0,'C');
					$pdf->Cell(15,10,utf8_decode(''),'',0,'C');
					$pdf->Cell(32,10,utf8_decode('Impuestos (ITBMS):'),'',0,'C');
					$pdf->Cell(47,10,utf8_decode("$ ".number_format("0.00",2).' '),'',0,'C');

					$pdf->Ln(10);
					$pdf->SetFont('Arial','',10);
					$pdf->SetTextColor(39,39,51);
					$pdf->Cell(90,10,utf8_decode(''),1,0,'C',true);
					$pdf->Cell(14,10,utf8_decode(''),1,0,'C',true);
					$pdf->SetFillColor(189,189,189);
					$pdf->SetDrawColor(189,189,189);
					$pdf->Cell(32,10,utf8_decode('Total:'),'T',0,'C');
					$pdf->Cell(70,10,utf8_decode("$ ".number_format($total, 2).' '),'T',0,'C');

					$pdf->Ln(12);
					$pdf->SetTextColor(39,39,51);
					$pdf->MultiCell(0,9,utf8_decode("*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar esta factura ***"),0,'C',false);
					
				}
				
				if($datos_venta['venta_cliente_firma'] != ""){
					$pdf->Ln(12);
					$pdf->SetTextColor(39,39,51);
					$pdf->Cell(32,60,utf8_decode('Confirmación de entrega'),'',0,'C');				
					$pdf->Image($datos_venta['venta_cliente_firma'],20,230,35,35,'png');
				}

				if($salida != "I"){
					$uuid = time() . "-".$code_unico;
					$folder = $_SERVER['DOCUMENT_ROOT'].'/SVIL/pdf/facturas/'.$uuid.'.pdf';
					$pdf->Output($folder, 'F');
					return $uuid;
				}
				else{
					$pdf->Output("I","Factura_Nro".$datos_venta['venta_id'].".pdf",true);
				}	
		}

		function base64_to_jpeg($base64_string, $output_file) {
			$ifp = fopen( $output_file, 'wb' ); 
			$data = explode( ',', $base64_string );		
			fwrite( $ifp, base64_decode( $data[ 1 ] ) );		
			fclose( $ifp ); 
			return $output_file; 
		}
	}
}