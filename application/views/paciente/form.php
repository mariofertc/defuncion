<?php
echo form_open('paciente/save/'.$persona_info->persona_id,array('id'=>'empleado_form'));
?>
<div id="required_fields_message"><?php echo $this->lang->line('comun_campos_requeridos_mensaje'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="employee_basic_info">
<legend><?php echo $this->lang->line("empleados_basic_information"); ?></legend>
<?php $this->load->view("personas/form_basic_info"); ?>
</fieldset>

<fieldset id="employee_login_info">
<legend><?php echo $this->lang->line("empleados_login_info"); ?></legend>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('empleados_carnet').':', 'usuario',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'usuario',
		'id'=>'usuario',
		'value'=>$persona_info->usuario));?>
	</div>
</div>
</fieldset>

<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('comun_submit'),
	'class'=>'submit_button float_right')
);
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	$('#empleado_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_persona_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			nombre: "required",
			apellido: "required",
			usuario:
			{
				required:true,
				minlength: 5
			},	
			repeat_password:
			{
 				equalTo: "#clave"
			},
    		email: "email"
   		},
		messages: 
		{
     		nombre: "<?php echo $this->lang->line('comun_nombre_requerido'); ?>",
     		apellido: "<?php echo $this->lang->line('comun_apellido_requerido'); ?>",
     		usuario:
     		{
     			required: "<?php echo $this->lang->line('empleados_carnet_requerido'); ?>",
     			minlength: "<?php echo $this->lang->line('empleados_carnet_mintamaño'); ?>"
     		},
     		
			clave:
			{
				<?php
				if($persona_info->persona_id == "")
				{
				?>
				required:"<?php echo $this->lang->line('empleados_clave_requerida'); ?>",
				<?php
				}
				?>
				minlength: "<?php echo $this->lang->line('empleados_clave_mintamaño'); ?>"
			},
			repeat_password:
			{
				equalTo: "<?php echo $this->lang->line('empleados_clave_debe_coincidir'); ?>"
     		},
     		email: "<?php echo $this->lang->line('comun_email_formato_invalido'); ?>"
		}
	});
});
</script>