<?php $this->load->view("partial/header"); ?>

<div id="title_bar">
    <div id="title" class="float_left"><?php echo $this->lang->line('comun_list_of') . ' ' . $this->lang->line('module_' . $controller_name); ?></div>
    <div id="new_button">
        <?php
        echo anchor("$controller_name/view/-1?width=$form_width", "<div class='big_button' style='float: left;'><span>" . $this->lang->line($controller_name . '_new') . "</span></div>", array('class' => 'thickbox none', 'title' => $this->lang->line($controller_name . '_new')));
        ?>
        <?php
        echo anchor("$controller_name/excel_import?width=$form_width", "<div class='big_button' style='float: left;'><span>Excel Import</span></div>", array('class' => 'thickbox none', 'title' => 'Import ' . $this->lang->line('module_' . $controller_name) . ' from Excel'));
        ?>
    </div>
</div>
<div id="table_action_header">
    <ul>
        <li class="float_left"><span><?php echo anchor("$controller_name/delete", $this->lang->line("comun_borrar"), array('id' => 'delete')); ?></span></li>
        <li class="float_left"><span><?php echo anchor("$controller_name/refresh", $this->lang->line("comun_refresh"), array('id' => 'refresh')); ?></span></li>
        <li class="float_left"><span><a href="#" id="email"><?php echo $this->lang->line("comun_email"); ?></a></span></li>
    </ul>
</div>
<div id="table_holder">
    <?php echo $admin_table; ?>
</div>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">
    var oTable;
    $(document).ready(function() 
    { 
        init_table_sorting();
        enable_select_all();
        enable_row_selection();
        enable_search('<?php echo site_url("$controller_name/suggest") ?>','<?php echo $this->lang->line("comun_confirm_search") ?>');
        enable_email('<?php echo site_url("$controller_name/mailto") ?>');
        enable_delete('<?php echo $this->lang->line($controller_name . "_confirm_delete") ?>','<?php echo $this->lang->line($controller_name . "_none_selected") ?>');
    
        oTable = $('#sortable_table').dataTable( {
                    
            "bProcessing": true,
            "bServerSide": true,
            //			"bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": '<?php echo site_url("$controller_name/mis_datos") ?>',
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
                    0: { sorter: false}, 
                    5: { sorter: false} 
                } 

            }); 
        }
    }

    function post_persona_form_submit(response)
    {
        if(!response.success)
        {
            set_feedback(response.message,'error_message',true);	
        }
        else
        {
            //This is an update, just update one row
            if(jQuery.inArray(response.persona_id,get_visible_checkbox_ids()) != -1)
            {
                update_row(response.persona_id,'<?php echo site_url("$controller_name/get_row") ?>');
                set_feedback(response.message,'success_message',false);	
			
            }
            else //refresh entire table
            {
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