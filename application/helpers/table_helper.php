<?php
/*
Gets the html table to manage categorys.
*/
function get_centro_salud_admin_table()
{
	$table='<table cellpadding="0" cellspacing="0" border="0" class="display" id="sortable_table">
		<thead>
			<tr>
				<th width="3%"><input type="checkbox" id="select_all" /></th>
				<th width="20%">Centro de Salud</th>
				<th width="30%">Dirección</th>
				<th width="20%">Orden</th>
                                <th width="10%">Acciones</th>
			</tr>
		</thead>
		<tbody>
	<!--Esto se llena con  ajax cloro -->	
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>';
	return $table;
}


function get_centro_salud_data_row($data,$controller)
{	
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();
	$height = $controller->get_form_height();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='data_$data->id' value='".$data->id."'/></td>";
	$table_data_row.='<td width="20%">'.character_limiter($data->nombre,13).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->descripcion,30).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($data->nombre_enlace,13).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($data->order,13).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$data->id?width=".$width."&height=".$height, $CI->lang->line('comun_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update')));		
	$table_data_row.='&nbsp;'.anchor("/doctor?id=$data->id&width=".$width."&height".$height, $CI->lang->line('doctor_doctores'),array('class'=>'boton_admin','title'=>$CI->lang->line($controller_name.'_muestra'))).'</td>';
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

/*
Gets the html table to manage categorys.
*/
function get_doctor_admin_table()
{
	$table='<table cellpadding="0" cellspacing="0" border="0" class="display" id="sortable_table">
		<thead>
			<tr>
				<th width="3%"><input type="checkbox" id="select_all" /></th>
				<th width="20%">Nombre</th>
				<th width="20%">Especialidad</th>
				<th width="30%">Dirección</th>
				<th width="20%">Acciones</th>
			</tr>
		</thead>
		<tbody>
	<!--Esto se llena con  ajax cloro -->	
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>';
	return $table;
}


function get_doctor_data_row($data,$controller)
{	
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();
	$height = $controller->get_form_height();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='data_$data->id' value='".$data->id."'/></td>";
	$table_data_row.='<td width="20%">'.character_limiter($data->nombre,13).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->descripcion,30).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->direccion,30).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view?id=$data->id&width=".$width."&height=".$height, $CI->lang->line('comun_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}
/*
Gets the html table to manage categorys.
*/
function get_consulta_admin_table()
{
	$table='<table cellpadding="0" cellspacing="0" border="0" class="display" id="sortable_table">
		<thead>
			<tr>
				<th width="3%"><input type="checkbox" id="select_all" /></th>
				<th width="20%">Enfermedad</th>
				<th width="20%">Motivo</th>
				<th width="30%">Fecha Consulta</th>
				<th width="20%">Acciones</th>
			</tr>
		</thead>
		<tbody>
	<!--Esto se llena con  ajax cloro -->	
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>';
	return $table;
}


function get_consulta_data_row($data,$controller)
{	
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();
	$height = $controller->get_form_height();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='data_$data->id' value='".$data->id."'/></td>";
	$table_data_row.='<td width="20%">'.character_limiter($data->enfermedad,13).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->motivo,30).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->fecha_actualizacion,30).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view?id=$data->id&width=".$width."&height=".$height, $CI->lang->line('comun_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}
/*
Gets the html table to manage categorys.
*/
function get_defuncion_admin_table()
{
	$table='<table cellpadding="0" cellspacing="0" border="0" class="display" id="sortable_table">
		<thead>
			<tr>
				<th width="3%"><input type="checkbox" id="select_all" /></th>
				<th width="20%">Motivo</th>
				<th width="20%">Observaciones</th>
				<th width="30%">Fecha Consulta</th>
				<th width="20%">Acciones</th>
			</tr>
		</thead>
		<tbody>
	<!--Esto se llena con  ajax cloro -->	
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>';
	return $table;
}


function get_defuncion_data_row($data,$controller)
{	
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();
	$height = $controller->get_form_height();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='data_$data->id' value='".$data->id."'/></td>";
	$table_data_row.='<td width="20%">'.character_limiter($data->motivo,30).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->observaciones,30).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->fecha_actualizacion,30).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view?id=$data->id&width=".$width."&height=".$height, $CI->lang->line('comun_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

/*
Gets the html table to manage categorys.
*/
function get_persona_admin_table()
{
	$table='<table cellpadding="0" cellspacing="0" border="0" class="display" id="sortable_table">
		<thead>
			<tr>
				<th width="3%"><input type="checkbox" id="select_all" /></th>
				<th width="20%">Nombres</th>
				<th width="30%">Apellido</th>
				<th width="20%">Email</th>
                                <th width="10%">Teléfono</th>
                                <th width="10%">Acciones</th>
			</tr>
		</thead>
		<tbody>
	<!--Esto se llena con  ajax cloro -->	
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>';
	return $table;
}


function get_persona_data_row($data,$controller)
{	
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();
	$height = $controller->get_form_height();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='data_$data->persona_id' value='".$data->persona_id."'/></td>";
	$table_data_row.='<td width="20%">'.character_limiter($data->nombre,13).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->apellido,30).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->email,30).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($data->telefono,13).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$data->persona_id?width=".$width."&height=".$height, $CI->lang->line('comun_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}


/*
Gets the html table to manage phptos.
*/
function get_foto_admin_table()
{
	$table='<table cellpadding="0" cellspacing="0" border="0" class="display" id="sortable_table">
		<thead>
			<tr>
				<th width="3%"><input type="checkbox" id="select_all" /></th>
				<th width="20%">Nombre</th>
				<th width="20%">Imagen</th>
				<th width="30%">Descripción</th>
				<th width="10%">Orden</th>
                                <th width="5%">Acciones</th>
			</tr>
		</thead>
		<tbody>
	<!--Esto se llena con  ajax cloro -->	
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>';
	return $table;
}


function get_foto_data_row($data,$controller)
{	
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();
	$height = $controller->get_form_height();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='data_$data->id' value='".$data->id."'/></td>";
	$table_data_row.='<td width="20%">'.character_limiter($data->nombre,13).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->imagen_path,30).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($data->descripcion,30).'</td>';
	$table_data_row.='<td width="10%">'.$data->orden.'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$data->id?width=".$width."&height=".$height, $CI->lang->line('comun_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

/*
Gets the html table to manage comments.
*/
function get_comentario_admin_table()
{
	$table='<table cellpadding="0" cellspacing="0" border="0" class="display" id="sortable_table">
		<thead>
			<tr>
				<th width="5%"><input type="checkbox" id="select_all" /></th>
				<th width="10%">Nombre</th>
				<th width="30%">Titulo</th>
				<th width="10%">Email</th>
				<th width="10%">Actions</th>
			</tr>
		</thead>
		<tbody>
	<!--Esto se llena con  ajax cloro -->	
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>';
	return $table;
}





//function get_empleado_admin_table()
//{
//	$table='<table cellpadding="0" cellspacing="0" border="0" class="display" id="sortable_table">
//		<thead>
//			<tr>
//				<th width="5%"><input type="checkbox" id="select_all" /></th>
//				<th width="30%">Nombre</th>
//				<th width="15%">Apellido</th>
//				<th width="15%">Email</th>
//				<th width="10%">Acciones</th>
//			</tr>
//		</thead>
//		<tbody>
//	<!--Esto se llena con  ajax cloro -->	
//		</tbody>
//		<tfoot>
//			
//		</tfoot>
//	</table>';
//	return $table;
//}
//function get_persona_manage_table($persona,$controller)
//{
//	$CI =& get_instance();
//	$table='<table class="tablesorter" id="sortable_table">';
//	
//	$headers = array('<input type="checkbox" id="select_all" />', 
//	'Nombre',
//	'Apellido',
//	'Email',
//	//'Tel&eacute;fono',
//	'&nbsp');
//	
//	$table.='<thead><tr>';
//	foreach($headers as $header)
//	{
//		$table.="<th>$header</th>";
//	}
//	$table.='</tr></thead><tbody>';
//	$table.=get_persona_manage_table_data_rows($persona,$controller);
//	$table.='</tbody></table>';
//	return $table;
//}
//
///*
//Gets the html data rows for the persona.
//*/
//function get_persona_manage_table_data_rows($persona,$controller)
//{
//	$CI =& get_instance();
//	$table_data_rows='';
//	
//	foreach($persona->result() as $person)
//	{
//		$table_data_rows.=get_persona_data_row($person,$controller);
//	}
//	
//	if($persona->num_rows()==0)
//	{
//		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('comun_no_persons_to_display')."</div></tr></tr>";
//	}
//	
//	return $table_data_rows;
//}
//
//function get_persona_data_row($persona,$controller)
//{
//	$CI =& get_instance();
//	$controller_name=$CI->uri->segment(1);
//	$width = $controller->get_form_width();
//	$height = $controller->get_form_height();
//
//	$table_data_row='<tr>';
//	$table_data_row.="<td width='5%'><input type='checkbox' id='persona_$persona->id' value='".$persona->id."'/></td>";
//	$table_data_row.='<td width="20%">'.character_limiter($persona->nombre,13).'</td>';
//	$table_data_row.='<td width="20%">'.character_limiter($persona->apellido,13).'</td>';
//	$table_data_row.='<td width="30%">'.mailto($persona->email,character_limiter($persona->email,22)).'</td>';
//	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$persona->id?width=$width&height=$height", $CI->lang->line('comun_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
//	$table_data_row.='</tr>';
//	
//	return $table_data_row;
//}


/*
Gets the html table to manage incidencias.
*/
function get_incidencia_admin_table()
{
	$table='<table cellpadding="0" cellspacing="0" border="0" class="display" id="sortable_table">
		<thead>
			<tr>
				<th width="3%"><input type="checkbox" id="select_all" /></th>
				<th width="10%">Usuario</th>
				<th width="10%">Email</th>
				<th width="30%">Detalle</th>
				<th width="10%">Pais</th>
				<th width="10%">Localidad</th>
				<th width="10%">Tipo</th>
				<th width="10%">Ingreso</th>
				<th width="10%">Estado</th>
				<th width="10%">Soporte</th>
				<th width="10%">Acciones</th>
			</tr>
		</thead>
		<tbody>
	<!--Esto se llena con  ajax cloro -->	
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>';
	return $table;
}
function get_incidencia_manage_table($incidencias,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	'Usuario',
	'Email',
	'Detalle',
	'Pais',
	'Localidad',
	'Tipo',
	'Ingreso',
	'Atendido',
	'Direcci&oacute;n',
	'Estado',
	'Soporte',
	'Comentario',
	'',
	// $CI->lang->line('Usuario'),
	// $CI->lang->line('Email'),
	// $CI->lang->line('Detalle'),
	// $CI->lang->line('Pais'),
	// $CI->lang->line('Ciudad'),
	// $CI->lang->line('Tipo'),
	// $CI->lang->line('Ingreso'),
	// $CI->lang->line('Atendido'),
	// $CI->lang->line('Estado'),
	// $CI->lang->line('Atendido Por'),
	// $CI->lang->line('Comentario'),
	// $CI->lang->line('Acciones'),
	);
	
	$table.='<thead><tr>';
	
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";		
	}
	
	$table.='</tr></thead><tbody>';
	$table.=get_incidencia_manage_table_data_rows($incidencias,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the incidencias.
*/
function get_incidencia_manage_table_data_rows($incidencias,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($incidencias->result() as $incidencia)
	{
		$table_data_rows.=get_incidencia_data_row($incidencia,$controller);
	}
	
	if($incidencias->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('comun_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_incidencia_data_row($incidencia,$controller)
{	
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='incidencia_$incidencia->id' value='".$incidencia->id."'/></td>";
	$table_data_row.='<td width="20%">'.character_limiter($incidencia->nombre,13).'</td>';
	$table_data_row.='<td width="30%">'.mailto($incidencia->email,character_limiter($incidencia->email,10)).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($incidencia->detalle,13).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($incidencia->pais,13).'</td>';		
	$table_data_row.='<td width="20%">'.character_limiter($incidencia->localidad,13).'</td>';		
	$table_data_row.='<td width="20%">'.character_limiter($incidencia->tipo,13).'</td>';		
	$table_data_row.='<td width="30%">'.date('Y-m-d', strtotime($incidencia->fecha)).'</td>';		
	//$table_data_row.='<td width="20%">'.date('Y-m-d', strtotime($incidencia->fechaAtencion)).'</td>';		
	//$table_data_row.='<td width="20%">'.character_limiter($incidencia->ipAddress,13).'</td>';		
	$table_data_row.='<td width="20%">'.character_limiter($incidencia->estado,13).'</td>';		
	$table_data_row.='<td width="20%">'.character_limiter($incidencia->atendidoPor,13).'</td>';		
	//$table_data_row.='<td width="20%">'.character_limiter($incidencia->comentarios,13).'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$incidencia->id?width=600&height=430", 'Atender',array('class'=>'thickbox','title'=>'Atender')).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}


function get_usuario_admin_table()
{
	$table='<table cellpadding="0" cellspacing="0" border="0" class="display" id="sortable_table">
		<thead>
			<tr>
				<th width="5%"><input type="checkbox" id="select_all" /></th>
				<th width="30%">Nombre</th>
				<th width="15%">Usuario</th>
				<th width="10%">C&eacute;dula</th>
				<th width="15%">Email</th>
				<th width="8%">Estado</th>
				<th width="5%">Activo</th>
				<th width="10%">Creacion</th>
				<th width="10%">Acciones</th>
			</tr>
		</thead>
		<tbody>
	<!--Esto se llena con  ajax cloro -->	
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>';
	return $table;
}

function get_usuario_manage_table($usuario,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	'Nombre',
	'Usuario',
	'C&eacute;dula',
	'Email',
	'Accesos',
	'Empresa',
	'Imagen',
	'Estado',
	'Activo',
	'Creacion',
	//'Tel&eacute;fono',
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_usuario_manage_table_data_rows($usuario,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the usuario.
*/

function get_usuario_manage_table_data_rows($usuario,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($usuario->result() as $person)
	{
		$table_data_rows.=get_usuario_data_row($person,$controller);
	}
	
	if($usuario->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('comun_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_usuario_data_row($usuario,$controller)
{
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();
	$height = $controller->get_form_heigth();
	// $id = (string)$usuario->id;
	// $id = mssql_guid_string($usuario->id);
	$id  = mb_strtolower($usuario->id);
	//var_dump($usuario->id);
	$table_data_row='<tr>';
	// $table_data_row.="<td width='5%'><input type='checkbox' id='persona_$usuario->username' value='".$usuario->username."'/></td>";
	$table_data_row.="<td width='5%'><input type='checkbox' id='persona_$id' value='".$id."'/></td>";
	// (string)$usuario->id -> Esto falla porque hay que convertirlo a string, antes de ocuparlo.
	$table_data_row.='<td width="20%">'.character_limiter($usuario->NombreCompleto,13).'</td>';		
	$table_data_row.='<td width="20%">'.character_limiter($usuario->Username,13).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($usuario->Cedula,13).'</td>';
	$table_data_row.='<td width="30%">'.mailto($usuario->Email,character_limiter($usuario->Email,22)).'</td>';
	// $table_data_row.='<td width="20%">'.character_limiter($usuario->Acceso,13).'</td>';		
	// $table_data_row.='<td width="20%">'.character_limiter($usuario->Empresa,13).'</td>';		
	// $table_data_row.='<td width="20%">'.character_limiter($usuario->Imagen,13).'</td>';		
	$table_data_row.='<td width="20%">'.character_limiter($usuario->Estado,13).'</td>';		
	$table_data_row.='<td width="20%">'.character_limiter($usuario->Activo,13).'</td>';		
	$table_data_row.='<td width="20%">'.date('Y-m-d H:i', strtotime($usuario->FechaCreacion)).'</td>';		
	// $table_data_row.='<td width="5%">'.anchor($controller_name."/view/$usuario->username?width:$width&height:600", $CI->lang->line('comun_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$id?width=$width&height=$height", $CI->lang->line('comun_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

function get_comentario_manage_table($comentarios,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 	'Nombre',	'Email',	'Texto',	'Fecha', 	'Pais',	'Ciudad');
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";		
	}
	$table.='</tr></thead><tbody>';
	$table.=get_comentario_manage_table_data_rows($comentarios,$controller);
	$table.='</tbody></table>';
	return $table;
}
function get_comentario_manage_table_data_rows($comentarios,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	foreach($comentarios->result() as $comentario)
	{
		$table_data_rows.=get_comentario_data_row($comentario,$controller);
	}
	if($comentarios->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('comun_no_persons_to_display')."</div></tr></tr>";
	}
	return $table_data_rows;
}
function get_comentario_data_row($comentario,$controller)
{	
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();
	$table_data_row='<tr>';
	$table_data_row.="<td><input type='checkbox' id='incidencia_$comentario->id' value='".$comentario->id."'/></td>";
	$table_data_row.='<td>'.character_limiter($comentario->nombre,13).'</td>';
	$table_data_row.='<td>'.mailto($comentario->email,character_limiter($comentario->email,10)).'</td>';
	$table_data_row.='<td>'.character_limiter($comentario->texto,100).'</td>';
	$table_data_row.='<td>'.date('Y-m-d H:i', strtotime($comentario->fecha)).'</td>';		
	$table_data_row.='<td>'.character_limiter($comentario->pais,13).'</td>';		
	$table_data_row.='<td>'.character_limiter($comentario->ciudad, 13).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}
?>