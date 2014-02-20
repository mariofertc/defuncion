<?php
echo form_open('empleados/save/'.$persona_info->persona_id,array('id'=>'empleado_form'));
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
<?php echo form_label($this->lang->line('empleados_usuario').':', 'usuario',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'usuario',
		'id'=>'usuario',
		'value'=>$persona_info->usuario));?>
	</div>
</div>

<?php
$password_label_attributes = $persona_info->persona_id == "" ? array('class'=>'required'):array();
?>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('empleados_clave').':', 'clave',$password_label_attributes); ?>
	<div class='form_field'>
	<?php echo form_password(array(
		'name'=>'clave',
		'id'=>'clave'
	));?>
	</div>
</div>


<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('empleados_repeat_password').':', 'repeat_password',$password_label_attributes); ?>
	<div class='form_field'>
	<?php echo form_password(array(
		'name'=>'repeat_password',
		'id'=>'repeat_password'
	));?>
	</div>
</div>
</fieldset>

<fieldset id="empleado_permiso_info">
<legend><?php echo $this->lang->line("empleados_permiso_info"); ?></legend>
<p><?php echo $this->lang->line("empleados_permiso_desc"); ?></p>

<ul id="permission_list">
<?php
foreach($all_modulos->result() as $modulo)
{
?>
<li>	
<?php echo form_checkbox("permisos[]",$modulo->modulo_id,$this->Empleado->has_permission($modulo->modulo_id,$persona_info->persona_id)); ?>
<span class="medium"><?php echo $this->lang->line('modulo_'.$modulo->modulo_id);?>:</span>
<span class="small"><?php echo $this->lang->line('modulo_'.$modulo->modulo_id.'_desc');?></span>
</li>
<?php
}
?>
</ul>
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('comun_submit'),
	'class'=>'submit_button float_right')
);

?>
</fieldset>
<?php 
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
			
			clave:
			{
				<?php
				if($persona_info->persona_id == "")
				{
				?>
				required:true,
				<?php
				}
				?>
				minlength: 8
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
     			required: "<?php echo $this->lang->line('empleados_usuario_requerido'); ?>",
     			minlength: "<?php echo $this->lang->line('empleados_usuario_mintamaño'); ?>"
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