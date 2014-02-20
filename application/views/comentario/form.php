<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<?php
//echo form_open('incidencias/find_incidencia_info/'.$incidencia_info->id,array('id'=>'incidencia_number_form'));
?>
<?php
//echo form_close();
echo form_open('', array('id' => 'form'));
?>
<fieldset id="basic_info">
    <legend>Información</legend>


    <div class="field_row clearfix">
        <?php echo form_label('Titulo:', 'titulo', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'titulo',
                'id' => 'titulo',
                'value' => $info->titulo)
            );
            ?>
        </div>
    </div>

    <div class="field_row clearfix">
        <?php echo form_label('Mensaje:', 'mensaje', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_textarea(array(
                'name' => 'mensaje',
                'id' => 'mensaje',
                'value' => $info->mensaje,
                'rows' => 4,
                'cols' => 18)
            );
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Usuario:', 'nombre_comentario', array('class' => 'ssmall_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'nombre_comentario',
                'id' => 'nombre_comentario',
                'value' => $info->nombre_comentario)
            );
            ?>
        </div>
    </div>
</fieldset>
<br>
<br>
<?php
echo form_submit(array(
    'name' => 'submit',
    'id' => 'submit',
    'value' => 'Cerrar',
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
        $('#form').validate({
            submitHandler:function(form)
            {		tb_remove();	
//                $(form).ajaxSubmit({
//                    success:function(response)
//                    {
//                        tb_remove();
//                        post_comentario_form_submit(response);
//                    },
//                    dataType:'json'
//                });

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