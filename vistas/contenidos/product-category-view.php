<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php echo $lc->enrutador("categoria_producto","encabezado",0); ?>
    </h3>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <?php
            if($_SESSION['cargo_svi']=="Administrador"){
                echo '<li>'.$lc->enrutador("producto_new","inactivo",0).'</li>';
            }
        ?>
        <li><?php echo $lc->enrutador("producto_list","inactivo",0); ?></li>
        <!--<li><?php echo $lc->enrutador("producto_sold","inactivo",0); ?></li>-->
        <li><?php echo $lc->enrutador("categoria_producto","activo",0); ?></li>
        <!--<li><?php echo $lc->enrutador("producto_expiration","inactivo",0); ?></li>
        <li><?php echo $lc->enrutador("producto_minimum_stock","inactivo",0); ?></li>
        <li><?php echo $lc->enrutador("producto_search","inactivo",0); ?></li>-->
    </ul>	
</div>

<div class="container-fluid">
    <div class="product-container">
        <div class="product-category">
            <h5 class="text-uppercase text-center"><i class="fas fa-tags"></i> &nbsp; Categorías</h5>
            <ul class="list-unstyled text-center product-category-list">
                <?php
                    $datos_categorias=$lc->datos_tabla("Normal","categoria","*",0);

                    while($campos_categoria=$datos_categorias->fetch()){
                        $total_productos=$lc->datos_tabla("Normal","producto WHERE categoria_id='".$campos_categoria['categoria_id']."'","producto_id",0);

                        echo '<li><a href="'.SERVERURL.'product-category/'.$campos_categoria['categoria_id'].'/" >'.$campos_categoria['categoria_nombre'].' <span class="badge badge-pill badge-info">'.$total_productos->rowCount().'</span></a></li>';
                    }
                ?>
            </ul>
        </div>  
        <div class="product-list">
            <?php
                if(isset($pagina[1]) && $pagina[1]>0){

                    $datos_categoria=$lc->datos_tabla("Unico","categoria","categoria_id",$lc->encryption($pagina[1]));

                    if($datos_categoria->rowCount()>=1){
                        $campos=$datos_categoria->fetch();
                        echo '<h3 class="text-center text-uppercase">Productos en categoría <strong>"'.$campos['categoria_nombre'].'"</strong></h3><br>';
                    }

                    require_once "./controladores/productoControlador.php";
                    $ins_producto = new productoControlador();

                    echo $ins_producto->paginador_producto_controlador($pagina[2],15,$pagina[0],$pagina[1],$_SESSION['cargo_svi']);
                }else{
                    echo '
                        <div class="alert text-primary text-center" role="alert">
                            <p><i class="fab fa-shopify fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">Categoría no seleccionada</h4>
                            <p class="mb-0">Por favor seleccione una categoría para empezar a buscar productos.</p>
                        </div>
                    ';
                }
            ?>
            
        </div>
    </div>	
</div>