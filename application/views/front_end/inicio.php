<?php $this->load->view("partial/header"); ?>
<br />
<h3><?php echo $this->lang->line('common_welcome_message'); ?></h3>
<div id="home_module_list">
        <div class="module_item">
            <a href="inicio">
                <img src="<?php echo base_url() . 'images/administracion/reportes.png'; ?>" border="0" alt="Menubar Image" /></a><br />
            <a href="inicio">Reportes</a>
            Reportes de Defunción
        </div>
</div>
<?php $this->load->view("partial/footer"); ?>