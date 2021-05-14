<section class="full-box nav-lateral">
    <div class="full-box nav-lateral-content">
        <div class="logo full-reset all-tittles" style="color:#fff; text-align: center; background:#0085b2">
            <i class="visible-xs zmdi zmdi-close pull-left mobile-menu-button" style="line-height: 50px; cursor: pointer;"></i> 
            <?php echo COMPANY; ?>
        </div>
        <figure class="full-box nav-lateral-avatar">
            <i class="far fa-times-circle show-nav-lateral"></i>
            <img src="<?php echo SERVERURL; ?>vistas/assets/avatar/<?php echo $_SESSION['foto_svi']; ?>" class="img-fluid" alt="Avatar">
            <figcaption class="roboto-medium text-center">
            <?php echo $_SESSION['nombre_svi']; ?><br><small class="roboto-condensed-light"><?php echo $_SESSION['cargo_svi']; ?></small>
            </figcaption>
        </figure>
        <div class="full-box nav-lateral-bar" style="background-color: #fff;"></div>
        <nav class="full-box nav-lateral-menu">
            <ul>
                <li style="border-bottom: 1px solid #0094c6;">
                    <?php echo $lc->enrutador("dashboard","inactivo",0); ?>
                </li>
                <li style="border-bottom: 1px solid #0094c6;">
                    <?php echo $lc->enrutador("sale","inactivo",0); ?>
                </li>
                <?php if($_SESSION['cargo_svi'] == "Administrador"){ ?>
                    <li style="border-bottom: 1px solid #0094c6;">
                        <?php echo $lc->enrutador("movement","inactivo",0); ?>
                    </li>
                    <li style="border-bottom: 1px solid #0094c6;">
                        <?php echo $lc->enrutador("client","inactivo",0); ?>
                    </li>
                    <li style="border-bottom: 1px solid #0094c6;">
                        <?php echo $lc->enrutador("user","inactivo",0); ?>
                    </li>
                    <li style="border-bottom: 1px solid #0094c6;">
                        <?php echo $lc->enrutador("configure","inactivo",0); ?>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</section>