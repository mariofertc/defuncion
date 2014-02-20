// JavaScript Document
jQuery(document).ready(function() {
	
	jQuery('#chainselect_wrap #chainselects_submit').click(function() {
		
		var tax 		= jQuery(this).attr('class');		
		var levels 		= jQuery('#chainselect_wrap').children('select').length;
		var tax_url 	= jQuery('#chainselects_taxurl').val();
		var site_url 	= jQuery('#chainselects_siteurl').val();
		var term 		= '';
		
		jQuery('#chainselect_wrap select').each(function(index) {
			var option = jQuery(this).children('option:selected').attr('id');
			if (typeof option != 'undefined') {
				if (tax == 'category') {
					term += option + "/";
					if (tax_url !== '') {
						taxurl = tax_url;
					} else {
						taxurl = tax;
					}
				} else {
					term = option + "/";
					taxurl = tax;
				}
			}
		});
		
		if (term) {
			window.location.href = site_url + "/" + taxurl + "/" + term;
		}
	
	});
	
	jQuery('#chainselect_wrap select').change(function() {
		
		jQuery('#chainselect_wrap #chainselects_loading').css('display', 'inline-block');
		
		var parent = jQuery(this).val();
		var levels = jQuery(this).parent('div').children('select').length;
		var current_level = jQuery(this).attr('id').split('_');
		var defaulttext = jQuery(this).next('select').children('option:first-child').val();
		
		var divclass = jQuery(this).parent('div').attr('class').split(' ');
		var tax = divclass[0];
		var count = divclass[1];
		
		reset_dropdowns(levels, current_level[1]);
		
		submit_me(parent, tax, levels, current_level[1], defaulttext, count);
	});
	
});

function reset_dropdowns(levels, current_level) {
	
	for (x=(parseInt(current_level)+1); x<(levels+1); x++) {
		var defaulttext = jQuery('#chainselect_wrap select#chainlist_' + x).children('option:first-child').text();;
		jQuery('#chainselect_wrap select#chainlist_' + x).html('<option>' + defaulttext + '</option>').attr('disabled', 'disabled');
	}
	
}

function submit_me(parent, tax, levels, current_level, defaulttext, count){
	
	jQuery.post(
		the_ajax_script.ajaxurl,
		{ 'action': 'the_ajax_hook', 'parentid' : parent, 'tax' : tax, 'levels' : levels, 'current_level' : current_level, 'defaulttext' : defaulttext, 'count' : count } ,
		function(response_from_the_action_function){
			var next_level = parseInt(current_level) + 1;
			if (response_from_the_action_function == 0) {
				jQuery('#chainselect_wrap select#chainlist_' + next_level).html('<option>' + defaulttext + '</option>').attr('disabled', 'disabled');
			} else {
				jQuery('#chainselect_wrap select#chainlist_' + next_level).html(response_from_the_action_function).removeAttr('disabled');
			}
			jQuery('#chainselect_wrap #chainselects_loading').css('display', 'none');
		}
	);
	
}