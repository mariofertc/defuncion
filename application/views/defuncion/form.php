<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<?php
//echo form_open('incidencias/find_incidencia_info/'.$incidencia_info->id,array('id'=>'incidencia_number_form'));
?>
<?php
echo form_open_multipart('consulta/save/' . $info->id, array('id' => 'form'));
?>

<fieldset id="employee_basic_info">
    <legend>Información</legend>
    <div class="field_row clearfix">
        <?php echo form_label('Doctores:', 'doctores', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_dropdown('doctor',$doctores,$doctor );
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Motivo Consulta:', 'motivo', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'motivo',
                'id' => 'motivo',
                'value' => $info->motivo)
            );
            ?>
        </div>
    </div>
  
    <div class="field_row clearfix">
        <?php echo form_label('Accidente:', 'accidente', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_multiselect('accidente',$accidentes,$accidente_db );
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Observaciones:', 'observaciones', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_textarea(array(
                'name' => 'observaciones',
                'id' => 'observaciones',
                'value' => $info->observaciones,
                'rows' => 4,
                'cols' => 50)
            );
            ?>
        </div>
    </div>     
</fieldset>
<fieldset id="employee_login_info">
    <legend>Agravantes</legend>
     <div class="field_row clearfix">
        <?php echo form_label('Valor Alcochek:', 'valor_alcochek', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'valor_alcochek',
                'id' => 'valor_alcochek',
                'value' => $info->valor_alcochek)
            );
            ?>
        </div>
    </div>
     <div class="field_row clearfix">
        <?php echo form_label('Factores Agravantes:', 'factores_agravantes', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'factores_agravantes',
                'id' => 'factores_agravantes',
                'value' => $info->factores_agravantes)
            );
            ?>
        </div>
    </div>
</fieldset>
    <?php echo form_hidden('paciente_id', $paciente_id) ?>
<br>
<br>
<?php
echo form_submit(array(
    'name' => 'submit',
    'id' => 'submit',
    'value' => 'Guardar',
    'class' => 'submit_button float_right')
);
?>

<?php
echo form_close();
?>


<script type='text/javascript'>
    //validation and submit handling
    $(document).ready(function()
    {	
        //$("#category").autocomplete("<?php // echo site_url('incidencia/suggest_category');     ?>",{max:100,minChars:0,delay:10});
        //$("#category").result(function(event, data, formatted){});
        //$("#category").search();

        $('#form').validate({
            submitHandler:function(form)
            {			
                $(form).ajaxSubmit({
                    success:function(response)
                    {
                        tb_remove();
                        post_lugar_form_submit(response);
                    },
                    dataType:'json'
                });

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:
                {
                lugar:"required",
                descripcion:"required",
                enlace:"required"
            },
            messages:
                {
                lugar:"Lugar Requerido",
                descripcion:"Descripción Requerida",
                enlace:"Enlace Requerido"
            }
        });
    });
</script>

