<?php $this->load->view("partial/header"); ?>

<div id="title_bar">
	<div id="title" class="float_left"><?php echo $this->lang->line('comun_list_of') . ' ' . $this->lang->line('modulo_' . $controller_name); ?></div>
	<?php
	if ($_SERVER['HTTP_HOST'] == 'localhost') {
		?>
		<div id="new_button'style='height:0px;''">
			<div class='small_button' style='height:0px; left:70px'><span>
					<a href="javascript:(function()%20{var%20url%20=%20'http://www.sprymedia.co.uk/VisualEvent/VisualEvent_Loader.js';if(%20typeof%20VisualEvent!='undefined'%20)%20{if%20(%20VisualEvent.instance%20!==%20null%20)%20{VisualEvent.close();}else%20{new%20VisualEvent();}}else%20{var%20n=document.createElement('script');n.setAttribute('language','JavaScript');n.setAttribute('src',url+'?rand='+new%20Date().getTime());document.body.appendChild(n);}})();">Visual Event</a>
				</span>
			</div>
		</div>
		<h3>Desarrollo</h3>
		<?php
	}
	?>
	<div id="new_button">
		<?php
		echo anchor("$controller_name/view/-1/$id_categoria?width=$form_width&height=$form_height", "<div class='big_button' style='float: right;margin-right: 0;'><span>" . $this->lang->line($controller_name . '_new') . "</span></div>", array('class' => 'thickbox none', 'title' => $this->lang->line($controller_name . '_new')));
		?>
	</div>
	<div id="new_buttond">
		<?php
		echo anchor("categorias", "<div class='big_button' style='float: right;margin-right: 14%;'><span>" . $this->lang->line('categorias_categoria') . "</span></div>", array('title' => $this->lang->line('categorias_categoria')));
		?>
	</div>
</div>
<div id="table_action_header">
	<ul>
		<li class="float_left"><span><?php echo anchor("$controller_name/delete", $this->lang->line("comun_borrar"), array('id' => 'delete')); ?></span></li>
		<li class="float_left"><span><?php echo anchor("$controller_name/refresh", $this->lang->line("comun_refresh"), array('id' => 'refresh')); ?></span></li>
	</ul>
</div>
<div class="demo_jui">
<?php echo $admin_table ?>
	<div class="spacer"></div>
</div>
<div id="feedback_bar"></div>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">
	var oTable;
	$(document).ready(function()
	{
		init_table_sorting();
		enable_select_all();
		enable_checkboxes();
		enable_row_selection();
		enable_search('<?php echo site_url("$controller_name/suggest") ?>','<?php echo $this->lang->line("comun_confirm_search") ?>');	
		enable_delete('<?php echo $this->lang->line($controller_name."_confirm_delete")?>','<?php echo $this->lang->line($controller_name."_none_selected")?>');		
		//enable_bulk_edit("Favor seleccione un usuario para editar","?width=580&height=450");
	
		oTable = $('#sortable_table').dataTable( {
                    
			"bProcessing": true,
			"bServerSide": true,
//			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"sAjaxSource": '<?php echo site_url("$controller_name/mis_datos/$id_categoria") ?>',
			/*"aoColumns": [
											{ "asSorting": [ "asc" ] },
											{ "asSorting": [ "desc", "asc", "asc" ] },
											{ "asSorting": [ "asc" ] },
											{ "asSorting": [ "asc" ] },
											{ "asSorting": [ "asc" ] },
											{ "asSorting": [ "asc" ] },
											{ "asSorting": [ "asc" ] },
											{ "asSorting": [ "asc" ] },
											{ "asSorting": [ "asc" ] },
										],*/
			"fnDrawCallback": function() {
				//tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
				tb_init('#sortable_table a.thickbox');
				imgLoader = new Image();// preload image
				imgLoader.src = tb_pathToImage;
				enable_row_selection();
			}
		} );
		$('#refresh').click(refresca);
	});


	function refresca(event,on_complete)
	{
        if(event != null)
		event.preventDefault();
		oTable.fnDraw();
	}

	function init_table_sorting()
	{
		//Only init if there is more than one row
		if($('.tablesorter tbody tr').length >1)
		{
			$("#sortable_table").tablesorter(
			{
				sortList: [[1,0]],
				headers:
					{
					0: { sorter: false}
				}
			})
			.tablesorterPager({container: $("#pager")});
		}
	}




	function post_lugar_form_submit(response)
	{
		if(!response.success)
		{
			set_feedback(response.message,'error_message',false);
		}
		else
		{
			//This is an update, just update one row
			if(jQuery.inArray(response.id, get_visible_checkbox_ids()) != -1)
			{
				update_row(response.id, "<?php echo site_url("doctor/get_row") ?>");
				set_feedback(response.message,'success_message',false);

			}
			else //refresca toda la tabla.
			{
				//set_feedback(response.message,'error_message',true);
				refresca(null,function()
				{
					//highlight new row
					hightlight_row(response.id);
					set_feedback(response.message,'success_message',false);
				});
			}
		}
	}
</script>