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
        <?php echo form_label('Enfermedad:', 'enfermedad', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_textarea(array(
                'name' => 'enfermedad',
                'id' => 'enfermedad',
                'value' => $info->enfermedad,
                'rows' => 4,
                'cols' => 50)
            );
            ?>
        </div>
    </div>    
    <div class="field_row clearfix">
        <?php echo form_label('Receta:', 'receta', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_textarea(array(
                'name' => 'receta',
                'id' => 'receta',
                'value' => $info->receta,
                'rows' => 4,
                'cols' => 50)
            );
            ?>
        </div>
    </div>    
</fieldset>
<fieldset id="employee_login_info">
    <legend>Signos Vitales</legend>
     <div class="field_row clearfix">
        <?php echo form_label('Presión Arterial:', 'presion_arterial', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'presion_arterial',
                'id' => 'presion_arterial',
                'value' => $info->presion_arterial)
            );
            ?>
        </div>
    </div>
     <div class="field_row clearfix">
        <?php echo form_label('Frecuencia Cardiaca:', 'frecuencia_cardiaca', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'frecuencia_cardiaca',
                'id' => 'frecuencia_cardiaca',
                'value' => $info->frecuencia_cardiaca)
            );
            ?>
        </div>
    </div>
     <div class="field_row clearfix">
        <?php echo form_label('Temperatura:', 'temperatura', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'temperatura',
                'id' => 'temperatura',
                'value' => $info->temperatura)
            );
?>
        </div>
    </div>
     <div class="field_row clearfix">
        <?php echo form_label('Frecuencia Respiratoria:', 'frecuencia_respiratoria', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'frecuencia_respiratoria',
                'id' => 'frecuencia_respiratoria',
                'value' => $info->frecuencia_respiratoria)
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

