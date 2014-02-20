<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('comun_nombre').':', 'nombre',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'nombre',
		'id'=>'nombre',
		'value'=>$persona_info->nombre)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('comun_apellido').':', 'apellido',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'apellido',
		'id'=>'apellido',
		'value'=>$persona_info->apellido)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('comun_email').':', 'email'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'email',
		'id'=>'email',
		'value'=>$persona_info->email)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('comun_telefono').':', 'telefono'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'telefono',
		'id'=>'telefono',
		'value'=>$persona_info->telefono));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('comun_direccion').':', 'direccion'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'direccion',
		'id'=>'direccion',
		'value'=>$persona_info->direccion));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('comun_ciudad').':', 'ciudad'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'ciudad',
		'id'=>'ciudad',
		'value'=>$persona_info->ciudad));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('comun_pais').':', 'pais'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'pais',
		'id'=>'pais',
		'value'=>$persona_info->pais));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('comun_comentarios').':', 'comentarios'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'comentarios',
		'id'=>'comentarios',
		'value'=>$persona_info->comentarios,
		'rows'=>'5',
		'cols'=>'17')		
	);?>
	</div>
</div>