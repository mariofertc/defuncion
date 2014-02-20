<?php   
/*
 Info for WordPress:
 ==============================================================================
 Plugin Name: Category Ajax Chain Selects
 Version: 3.7
 Plugin URI: http://www.peterjharrison.me/2011/11/category-ajax-chain-select-re-written-from-scratch-wordpress-plugin/
 Description: This plugin makes it easy to have chain select category/custom taxonomy drop downs in your theme using Ajax.
 Author: Peter J Harrison
 Author URI: http://www.peterjharrison.me 

 Category Ajax Chain Selects
 ==============================================================================

 This plugin makes it easy to have chain select category/custom taxonomy drop downs in your theme using Ajax.

 The plugin was created as a way for me to use chain selects on a number of websites I have built over the past few  
 months. It is my first attempt at making a Wordpress plugin so it is a little rough around the edges.

 Feel free to visit my website www.peterjharrison.me or contact me at
 me@peterjharrison.me

 Have fun!

 Installation:
 ==============================================================================
 1. Upload the full directory into your wp-content/plugins directory
 2. Activate it in the Plugin options
 3. Add the template tag: `<?php echo chainselect_getcategories('taxonomy name'); ?>` into you page template.
 4. For more options please see the plugin page.


 Contributors:
 ==============================================================================
 Developer : Plugin Development	Peter J Harrison http://www.peterjharrison.me

 Thanks in advance to all contributors and bug reporters! :)

 Release History:
 ==============================================================================
 
 = 3.7 =
 * Added compatibility for WordPress install in subfolders
 
 = 3.6 =
 * Added compatibility for category_base
 
 = 3.5 =
 * Fixed headers already sent issue
 
 = 3.4 =
 * Fixed issue with URL for default category
 
 = 3.3 =
 * Fixed issue with loading styles.
 
 = 3.0 =
 * Re-written from scratch to add new features and support for custom taxonomies.

 = 2.0 =
 * Was scrapped.

 = 1.0 =
 * First version of plugin.

 Upgrade Notice:
 ==============================================================================
 
 = 3.7 =
 * Added compatibility for WordPress install in subfolders
 
 = 3.6 =
 * Added compatibility for category_base
 
 = 3.5 =
 * Fixed headers already sent issue
 
 = 3.4 =
 * Fixed issue with URL for default category
 
 = 3.3 =
 * Fixed issue with loading styles.
 
 = 3.0 =
 * Re-written from scratch to add new features and support for custom taxonomies.

 = 2.0 =
 * Was scrapped.

 = 1.0 =
 * First version of plugin.

 License:
 ==============================================================================

    Copyright 2011  Peter J Harrison (email : me@peterjharrison.me)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-107  USA
*/

function chainselect_init($tax, $level, $titles, $labels, $btn_text, $exclude, $count) {
	 
	 echo "<div id='chainselect_wrap' class='$tax cs_count_$count'>";
		 
		 $categories = get_terms( $tax, array('parent' => 0, 'exclude' => $exclude) );
		 
		 if ($labels) {
		 	echo "<label for='chainlist_1'>$labels[0]</label>";
		 }
		 echo "<select id='chainlist_1'>";
			echo  "<option>$titles[0]</option>";
		 foreach ($categories as $cat) {
			 if ($count == 1) { $cat_count = " ($cat->count)"; } else { $cat_count = ''; }
			 echo  "<option id='$cat->slug' value='$cat->term_id'>$cat->name$cat_count</option>";
		 }
		 echo "</select>";
		 
		 if ($level > 1) {			
			
			for ($x = 1; $x < $level; $x++) {
				if ($labels) {
					echo "<label for='chainlist_". ($x + 1) ."'>$labels[$x]</label>";
				}
				echo "<select id='chainlist_". ($x + 1) ."' disabled>";			
					echo  "<option>$titles[$x]</option>";
				echo "</select>";
			}
			
		 }
		 
		 $taxurl = get_option('category_base');
		 $siteurl = get_option('siteurl');
		 
		 echo "<input type='hidden' id='chainselects_taxurl' name='chainselects_taxurl' value='$taxurl' />";
		 echo "<input type='hidden' id='chainselects_siteurl' name='chainselects_siteurl' value='$siteurl' />";
		 echo "<input type='button' id='chainselects_submit' class='$tax' value='$btn_text' /><span id='chainselects_loading'></span>";
	 
	 echo "</div>";	 
	 
} 

function chainselect_getcategories($tax = 'category', $level = 1, $titles = array('Please select...'), $labels = '', $btn_text = 'Submit', $exclude = '', $count = 1) {
	
	if (count($labels) !== $level && $labels !== '') { 
		echo 'Category Chain Select Plugin</br>Error :: Number of labels don\'t match number of levels';
	} else {
	
		if (count($titles) == $level) {
			chainselect_init($tax, $level, $titles, $labels, $btn_text, $exclude, $count);
		} else {
			echo 'Category Chain Select Plugin</br>Error :: Number of titles don\'t match number of levels';
		}
	
	}
}

function chainselect_updatecats() {
	
	$parentid = $_POST['parentid'];
	$tax = $_POST['tax'];
	$levels = $_POST['levels'];
	$current_level = $_POST['current_level'];
	$defaulttext = $_POST['defaulttext'];
	$count = $_POST['count'];
	
	$categories = get_terms( $tax, array('parent' => $parentid) );
	
	if (!empty($categories)) {
		
		echo "<option>$defaulttext</option>";
	
		foreach ($categories as $cat) {
			if ($count == 'cs_count_1') { $cat_count = " ($cat->count)"; } else { $cat_count = ''; }
			echo  "<option id='$cat->slug' value='$cat->term_id'>$cat->name$cat_count</option>";
		}
	
	}
	
}

wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'chainselects.js', array( 'jquery' ) );
wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

add_action( 'wp_ajax_the_ajax_hook', 'chainselect_updatecats' );
add_action( 'wp_ajax_nopriv_the_ajax_hook', 'chainselect_updatecats' );

wp_register_style('chainselects_css', plugin_dir_url( __FILE__ ) . 'chainselects.css');
wp_enqueue_style( 'chainselects_css');

?>