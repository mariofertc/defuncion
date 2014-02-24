<?php $this->load->view("partial/header"); ?>
<br />
<h3>Reporte de Defunción</h3>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<?php
//echo form_open('incidencias/find_incidencia_info/'.$incidencia_info->id,array('id'=>'incidencia_number_form'));
?>
<?php
echo form_open_multipart('reportes/buscar/', array('id' => 'form'));
?>
    <fieldset id="employee_basic_info">
    <legend>Buscar Paciente</legend>
    
        <div class="field_row clearfix">
            <div id='error_message_box' class='form_field'>
            </div>
        </div>

        <div class="field_row clearfix">
            <?php echo form_label('Número de Carnet:', 'reportes', array('class' => 'small_wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'carnet',
                    'id' => 'carnet')
                );
                ?>
            </div>
        </div>
        <?php
echo form_submit(array(
    'value' => 'Buscar',
    'class' => 'submit_button float_right')
);
?>
    </fieldset>
<?php
echo form_close();
?>
<?php $this->load->view("partial/footer"); ?>


<script type='text/javascript'>
    //validation and submit handling
    $(document).ready(function()
    {	
        $('#form').validate({
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:
                {
                carnet:"required"
            },
            messages:
                {
                carnet:"Número de Carnet es un campo Requerido",
            }
        });
    });
</script>