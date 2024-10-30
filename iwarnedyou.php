<?php 
/*
Plugin Name: I Warned You
Plugin URI: http://www.jeremysmeltzer.net
Description: Displays a message above post content warning visitors of potential hazards of reading your content
Author: Jeremy Smeltzer
Version: 1.0.0
Author URI: http://www.jeremysmeltzer.net
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

// add warning to content
function warn_them($content) {
	//$warningtext ="Content maybe hazardous to your health. Read at your own risk!";
	$warningtext = get_option('iwarnedyou_data');
	$newcontent = "<p style='font-weight:bold';><span style='color:red;'>Warning:</span> ".$warningtext."<p>".$content;
	return $newcontent;
}
add_filter('the_content', 'warn_them');



// on activation
register_activation_hook(__FILE__,'iwarnedyou_install'); 

// on deactivation
register_deactivation_hook( __FILE__, 'iwarnedyou_remove' );

// activation function
function iwarnedyou_install() {
add_option("iwarnedyou_data", 'Content maybe hazardous to your health. Read at your own risk!', '', 'yes');
}

// deactivation function
function iwarnedyou_remove() {
delete_option('iwarnedyou_data');
}


// creat admin page
if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'iwarnedyou_menu');

function iwarnedyou_menu() {
//add_options_page('I Warned You', 'I Warned You', 'administrator', 'i-warned-you', 'iwarnedyou_html_page');
add_submenu_page( 'edit.php', 'I Warned You', 'I Warned You', 'manage_options', 'i-warned-you', 'iwarnedyou_html_page');
}
}
?>
<?php
function iwarnedyou_html_page() {
?>
<div>
<h2>I Warned You Options</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table width="500" cellspacing="0" cellpadding="0"  class="form-table">
  <tr>
    <td align="left"><strong>Enter Warning Text</strong><br />
      <textarea name="iwarnedyou_data" cols="50" id="iwarnedyou_data"><?php echo get_option('iwarnedyou_data'); ?></textarea></td>
  </tr>
</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="iwarnedyou_data" />

<p>
<input type="submit" value="<?php _e('Save Changes'); ?>" />
</p>

</form>
</div>
<?php
}
?>