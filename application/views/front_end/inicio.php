<?php $this->load->view("partial/header"); ?>
<br />
<h3><?php echo $this->lang->line('common_welcome_message'); ?></h3>
<div id="home_module_list">
        <div class="module_item">
            <a href="<?php echo site_url('reportes')?>">
                <img src="<?php echo base_url() . 'images/administracion/reportes.png'; ?>" border="0" alt="Menubar Image" /></a><br />
            <a href="<?php echo site_url('reportes')?>">Reportes</a>
            Reportes de Defunción
        </div>
</div>
<?php $this->load->view("partial/footer"); ?>