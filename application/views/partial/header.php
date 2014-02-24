<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Defunción-Inicio</title>

        <link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico" />
        <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url(); ?>css/admin/rm.css" />
        <!--<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />-->
    </head>
    <body>
        <div id="menubar">
            <div id="menubar_container">
                <div id="menubar_company_info">
                <img src="<?php echo base_url(); ?>images/logo.png"/>
                <!--<span id="company_title"><?php echo $this->config->item('company'); ?></span><br />-->

                    <span id="company_title">Administraci&oacute;n</span>
                    <br/>
                    <span style='font-size:8pt;'>Defunción</span>
                    <!--</div>-->
                </div>
                <div id="menubar_navigation">
                    <div class="menu_item">
                        <a href="<?php echo base_url().'index.php'; ?>">
                            <img src="<?php echo base_url() . 'images/administracion/home.png'; ?>" border="0" alt="Menubar Image" /></a><br />
                        <a href="<?php echo base_url().'index.php'; ?>">Inicio</a>
                    </div>

                    <?php
                    if (isset($allowed_modules)) {
                        foreach ($allowed_modules->result() as $modulo) {
                            if ($modulo->modulo_id == 'consulta' || $modulo->modulo_id == 'defuncion')
                                continue;
                            ?>

                            <div class="menu_item">
                                <a href="<?php echo site_url("$modulo->modulo_id"); ?>">
                                    <img src="<?php echo base_url() . 'images/administracion/' . $modulo->modulo_id . '.png'; ?>" border="0" alt="Menubar Image" /></a><br />
                                <a href="<?php echo site_url("$modulo->modulo_id"); ?>"><?php echo $this->lang->line("modulo_" . $modulo->modulo_id) ?></a>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="menu_item">
                        <a href="<?php echo site_url('home'); ?>">
                            <img src="<?php echo base_url() . 'images/administracion/administraciones.png'; ?>" border="0" alt="Menubar Image" /></a><br />
                        <a href="<?php echo site_url("home"); ?>">Administración</a>
                    </div>
                    
                </div>
<?php if (isset($allowed_modules)) { ?>
                <div id="menubar_footer">
                    <?php echo $this->lang->line('comun_welcome') . " $user_info->nombre $user_info->apellido! | "; ?>
                    <?php echo anchor("home/logout", 'Salir'); ?>
                </div>
<?php }?>
                <div id="menubar_date">
                    <span style='font-size:8pt;'>
                        <?php echo strftime("%d de %B del %Y %H:%M"); //echo date('F d, Y h:i a'); ?>
                        <?php //echo strftime("%A %d de %B del %Y %H:%M"); //echo date('F d, Y h:i a'); ?>
                        <?php //echo date('d-m-Y h:i a') ?>
                    </span>
                </div>

            </div>
        </div>
        <?php //echo getCwd(); ?>
        <div id="content_area_wrapper">
            <div id="content_area">