<?php $this->load->view("partial/header"); ?>
<br />
<h3><?php echo $this->lang->line('common_welcome_message'); ?></h3>
<div id="home_module_list">
    <?php
    foreach ($allowed_modules->result() as $modulo) {
        echo $modulo->modulo_id;
        if ($modulo->modulo_id == 'lugares' ||$modulo->modulo_id=='fotos')
            continue;
        ?>
        <div class="module_item">
            <a href="<?php echo site_url("$modulo->modulo_id"); ?>">
                <img src="<?php echo base_url() . 'images/administracion/' . $modulo->modulo_id . '.png'; ?>" border="0" alt="Menubar Image" /></a><br />
            <a href="<?php echo site_url("$modulo->modulo_id"); ?>"><?php echo $this->lang->line("modulo_" . $modulo->modulo_id) ?></a>
            - <?php echo $this->lang->line('modulo_' . $modulo->modulo_id . '_desc'); ?>
        </div>
        <?php
    }
    ?>
</div>
<?php $this->load->view("partial/footer"); ?>