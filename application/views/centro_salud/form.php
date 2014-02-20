<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<?php
//echo form_open('incidencias/find_incidencia_info/'.$incidencia_info->id,array('id'=>'incidencia_number_form'));
?>
<?php
//echo form_close();
echo form_open('centro_salud/save/'.$info->id,array('id'=>'form'));
?>
<fieldset id="basic_info">
<legend>Información del Centro de Salud</legend>


<div class="field_row clearfix">
<?php echo form_label('Nombre:', 'nombre',array('class'=>'ssmall_wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'nombre',
		'id'=>'nombre',
		'value'=>$info->nombre)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label('Dirección:', 'descripcion',array('class'=>'ssmall_wide')); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'direccion',
		'id'=>'direccion',
		'value'=>$info->descripcion,
		'rows'=>4,
		'cols'=>18)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label('Orden:', 'orden',array('class'=>'ssmall_wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'order',
		'id'=>'order',
		'value'=>$info->order)
	);?>
	</div>
</div>

</fieldset>

<br>
<br>
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>'Guardar',
	'class'=>'submit_button float_right')
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
		{			
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_item_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
			nombre:"required",
			descripcion:"required",
   		},
		messages:
		{
			nombre:"Categoria Requerido",
			direccion:"Dirección Requerido",
		}
	});
});
</script>

