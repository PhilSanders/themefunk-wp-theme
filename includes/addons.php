<?php 

/* 

netfunktheme theme addons system 

*/

add_action( 'admin_init', 'theme_addon_options_init' );
add_action( 'admin_menu', 'theme_addon_options_add_page' );

$request_action = (!empty($_REQUEST['action']) ? $_REQUEST['action'] : '');

// register theme addon settings
function theme_addon_options_init(){
	register_setting( 'netfunktheme-options-addons', 'netfunktheme_options_addons', 'netfunktheme_options_addons_validate' );
	/* populate predfined settings */
    $options = get_option('netfunktheme_options_addons');
    add_option( 'netfunktheme_options_addons', $options,'','yes');
}

// add addon submenu to netfunktheme theme menu
function theme_addon_options_add_page() {
	add_submenu_page('theme_settings',__( 'NetfunkTheme Theme Add-ons' ),__('Add-ons' ),'edit_theme_options','theme_addons', 'theme_addons_options_page' );
}

// missing addon admin notices 
add_action( 'admin_notices', 'theme_addon_notices' );
function theme_addon_notices(){
	
     global $current_screen;
	 
     if ( $current_screen->parent_base == 'theme_addons' )
          echo '<div><p>Warning - changing settings on these pages may cause problems with your website\'s design!</p></div>';
}

/* theme addon shortcode generator */
if (!function_exists( 'netfunktheme_member_profile_shortcode')){

	// netfunktheme_theme_addon_shortcode ( $shortcode , $function ) 
	// netfunktheme_theme_addon_shortcode ( 'netfunktheme_member_edit_page', 'netfunktheme_edit_profile_page' ) 
	// shortcode would be '[netfunktheme_member_edit_page]'

	function netfunktheme_theme_addon_shortcode ( $shortcode, $function ) {
		add_shortcode ($shortcode, $function);
	}
}

add_action( 'netfunktheme_theme_addon_shortcode', 'netfunktheme_theme_addon_shortcode' );


// validate theme addon options
function netfunktheme_options_addons_validate( $input ) {
	
	$options = get_option( 'netfunktheme_options_addons' );

	if (isset($input) && !empty($input)){

		foreach ( $input as $addon ){

			if (isset($input['action']) && $input['action'] != 'delete-selected'){

				// activate addon
				if (isset($input['action']) && $input['action'] == 'activate-selected')
					
					$activate = 1;
				
				// deactivate addon
				else if (isset($input['action']) && $input['action'] == 'deactivate-selected')
				
					$activate = 0;
		
				// addon options
				if ( $addon != 'action')
					$options[$addon] = wp_filter_nohtml_kses( $activate );

			} else {
				
				// delete addon
				//remove_addon($addon);
			}
		}
	}
	return $options;
}


/* remove addon */

function remove_addon($addon) {

	$options = get_option( 'netfunktheme_options_addons' );

	$addon_file = get_template_directory() . '/addons/'.$addon.'/';

	// does addon exist?
	if (is_dir($addon_file)) {

		$objects = scandir($addon_file);

		// delete files recursivly 

		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($addon_file."/".$object) == "dir") remove_addon($addon_file."/".$object); else unlink($addon_file."/".$object);
			}
		}
		
		reset($objects);

		rmdir($addon_file);

		// purge addons settings 
		
		/*
		
		foreach ($options as $input => $value){
		
			if ( $input != $addon)
				$options[$input] = $value;
			
		}
		
		// update option array
		
		update_option('netfunktheme_options_addons', $options);
		
		//return $options;
		
		*/
	}
}


/* 

addon file headers must contain a addon name, 
description, version, authr, author url and addon url. 

*/

function validate_theme_addon($file){

	$slug = basename($file, ".php");
	$addon = file_get_contents( $file );
	
	// addon name
	$title = 'Plugin Name:';
	$title_pattern = preg_quote($title, '/');
	$title_pattern = "/^.*$title_pattern.*\$/m";
	
	// addon description
	$description = 'Plugin Description:';
	$description_pattern = preg_quote($description, '/');
	$description_pattern = "/^.*$description_pattern.*\$/m";
	
	// addon version
	$version = 'Plugin Version:';
	$version_pattern = preg_quote($version, '/');
	$version_pattern = "/^.*$version_pattern.*\$/m";
	
	// addon description
	$author = 'Plugin Author:';
	$author_pattern = preg_quote($author, '/');
	$author_pattern = "/^.*$author_pattern.*\$/m";
	
	// addon author website
	$author_url = 'Plugin Author URL:';
	$author_url_pattern = preg_quote($author_url, '/');
	$author_url_pattern = "/^.*$author_url_pattern.*\$/m";
	
	// addon website
	$addon_url = 'Plugin URL:';
	$addon_url_pattern = preg_quote($addon_url, '/');
	$addon_url_pattern = "/^.*$addon_url_pattern.*\$/m";

	// addon arguments array
	$addon_args = array();
	

	// validate addon config header

	if ( 
	
		preg_match_all( $title_pattern, $addon, $addon_name ) /* check name */ 
			
		&& preg_match_all( $description_pattern, $addon, $addon_description )  /* check description */
				
		&& preg_match_all( $version_pattern, $addon, $addon_version ) /* check version  */
				
		&& preg_match_all( $author_pattern, $addon, $addon_author )  /* check author */
				
		&& preg_match_all( $author_url_pattern, $addon, $addon_author_url )  /* check author url */
				
		&& preg_match_all( $addon_url_pattern, $addon, $addon_url ) /* check addon url  */ ) {
		
		// sanitize addon args
		
		$addon_name = str_replace('Plugin Name:','',implode("\n", $addon_name[0]));
		$addon_description = str_replace('Plugin Description:','',implode("\n", $addon_description[0]));
		$addon_version = str_replace('Plugin Version:','',implode("\n", $addon_version[0]));
		$addon_author = str_replace('Plugin Author:','',implode("\n", $addon_author[0]));
		$addon_author_url = str_replace('Plugin Author URL:','',implode("\n", $addon_author_url[0]));
		$addon_url = str_replace('Plugin URL:','',implode("\n", $addon_url[0]));
		

		// build addon arguments
		
		array_push($addon_args,$slug,$addon_name,$addon_description,$addon_version,$addon_author,$addon_author_url,$addon_url);
		
		return $addon_args;
		
	}

}

/* display valid addons list */
				
//get validated theme addons 

function get_valid_theme_addons(){

	settings_fields( 'netfunktheme-options-addons' ); 
	
	$options = get_option( 'netfunktheme_options_addons' );
	
	$folder_paths = glob (get_template_directory() . '/addons/*/*.php');

	foreach ( $folder_paths as $file ) {

		if ($args = validate_theme_addon($file)){
		
			// 0 - addon slug
			// 1 - addon name
			// 2 - addon description
			// 3 - addon version
			// 4 - addon author
			// 5 - addon author url 
			// 6 - addon url 
			// 7 - addon active
		
			echo '<tr id="addon-name" class="'.(isset($options[$args[0]]) && $options[$args[0]] == 1 ? 'active' : 'inactive').'">'
			
				.'<th scope="row"> <input type="checkbox" name="netfunktheme_options_addons['.$args[0].']" id="netfunktheme_options_addons['.$args[0].']" value="1"> </th>'
				
				.'<td class="addon-title"> <strong>' . $args[1] . '</strong> '
				
					.'<div class="row-actions visible">'

						.'<span class="'.(isset($options[$args[0]]) && $options[$args[0]] == 1 ? 'deactivate' : 'activate').'"> <a title="'.(isset($options[$args[0]]) && $options[$args[0]] == 1 ? 'Deactivate' : 'Activate').' this addon" href="'. $_SERVER['PHP_SELF'] . '?page=theme_addons&action='.(isset($options[$args[0]]) && $options[$args[0]] == 1 ? 'deactivate' : 'activate').'&addon='.$args[0].'"> '.(isset($options[$args[0]]) && $options[$args[0]] == 1 ? 'Deactivate' : 'Activate').' </a> </span>'
						
						.' | '
						
						.'<span class="delete"> <a class="edit" title="Delete this addon" href="#"> Delete </a> </span>'
					
					.'</div>'
				
				.'</td>'
			
				.'<td class="column-description desc"> <div class="addon-description"> <p>' . $args[2] . '</p> </div> <div class="addon-version-author-uri"> <p> Version ' . $args[3] . ' | By <a href="'.$args[5].'" target="_blank">'.$args[4].'</a> | <a href="'.$args[6].'" target="_blank">Visit addon site</a> </p> </div> </td>'
			 
			  .'</tr>';

		}
		
	}
	
}

/* theme addons options page */

function theme_addons_options_page() {

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	?>
	
	<div class="wrap">
	
	
		<h2>
        
        	<span class="dashicons dashicons-admin-addons" data-code="f106" style="font-size: 30px"></span> &nbsp; 
			<?php echo wp_get_theme() . __( ' - Plugins', 'netfunktheme' ); ?>
        
        </h2>
		
		<br />

		<?php theme_nav() ?>
		

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		
			<div class="updated fade"><p><strong><?php _e( 'Options saved', 'netfunktheme' ); ?></strong></p></div>

        	<hr style=" border: solid #DDD 1px;"/>

		<?php endif; ?>
		

		<form method="post" action="options.php">

		<h3 class="netfunk title">NetfunkTheme Add-ons</h3>

		<div class="panel radius">

            <span class="fa fa-plus-square hide-for-small show-for-large-up" style="z-index: 1; color: #CCC; position: absolute; left: 100%; margin-left: -200px; font-size: 150px; "></span>
        
        	<div class="large-8 medium-12 small-12">
                
                <p><strong class="label">NetfunkTheme</strong> addons are designed to add extened support for popular WP-Plugins, content services including Facebook, Twitter, Soundlcoud, Beatport, Instagram as well as advanced style and layout options this Netfunktheme itself. 
                
                 These addons are ready to ready to and work seamlessly with all NetfunkTheme products. That means no coding skills required. </p>
            
            </div>
            
            <hr />
            
            <div class="large-8 medium-12 small-12">
            
                <h4>Where do I get more Netfunk Add-ons?</h4>
                
                <p>This theme comes with only a few addons, though more may be purchased for a reasonable price. 
                
                If you would like the full suite of <strong>Netfunk Plugins</strong> you may also purchase the <a href="http://www.netfunkdesign.com" target="_blank">Expanded Theme Package</a> at our website.
        
                <br />
                
                <br />
                
                    <a href="http://www.netfunkdesign.com" target="_blank" class="aligncenter button-primary">Visit NetfunkDesign.com</a>
                
                
                </p>
            
            </div>
        
        </div>

		<h3 class="title">Installed Plugins</h3>

		<div class="panel radius">

		<h3> <i class="fa fa-wrench"></i> &nbsp; Enable or disable addons below to expand, or simplify your horizons. </h3>

		<br />
		<hr />

		<div class="tablenav top">

			<div class="actions bulkactions">
	
				<select name="netfunktheme_options_addons[action]" id="netfunktheme_options_addons[action]">
				
					<option selected="selected" value="-1"> Bulk Actions </option>
					
					<option value="activate-selected"> Activate </option>
					
					<option value="deactivate-selected"> Deactivate </option>
					
					<option value="delete-selected"> Delete </option>
					
					<!--option value="update-selected"> Update </option-->

				</select>
				
				<input id="doaction" class="button action" type="submit" value="Apply" name="">
		
			</div>

		</div>
        
		<br />
		
		<table class="wp-list-table widefat addons" cellspacing="0">
	 
		 <thead>
	  
		  <tr>
	 
			<th id="cb" class="manage-column column-cb check-column" style="" scope="col"> <input type="checkbox" name="checkall" id="checkall" value="1"> </th>
	 
			<th id="name" class="manage-column column-name" style="" scope="col"> Plugin </th>
	 
			<th id="description" class="manage-column column-description" style="" scope="col"> Description </th>
	
		  </tr>
	  
		</thead>
		
		<tbody id="the-list">
		  
		  <?php 
		
			get_valid_theme_addons();

		 ?>
		  
		  </tbody>
		  
		  <tfoot>
		  
		  <tr>
		
			<th id="cb" class="manage-column column-cb check-column" style="" scope="col"> <input type="checkbox" name="checkall" id="checkall" value="1"> </th>
		
			<th id="name" class="manage-column column-name" style="" scope="col"> Plugin </th>
		
			<th id="description" class="manage-column column-description" style="" scope="col"> Description </th>
		
		  </tr>
	  
		</tfoot>
	 
		</table>
        
        </div>

		<br />

		<hr style=" border: solid #DDD 1px;"/>
		
		<br />
		
		<!--h3>Save settings </h3>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?php //_e( 'Save Options', 'netfunktheme' ); ?>" />
		</p-->

	</form>

	</div>

	<?php

	/* Debug  */
				
		//$options = get_option( 'netfunktheme_options_addons' );
					
		//echo '<pre>';
		//echo '<h6>debug</h6>';
		//print_r ($options);
		//echo '</pre>';

}


/* activate theme addon */
if ( $request_action == 'activate' && !empty( $_REQUEST['addon'] ) ) {

	$options = get_option( 'netfunktheme_options_addons' );

	$addon = $_REQUEST['addon'];
	
	$options[$addon] = wp_filter_nohtml_kses( 1 );

	update_option('netfunktheme_options_addons', $options); //update option array

}

/* deactivate theme addon */
if ( $request_action == 'deactivate' && !empty( $_REQUEST['addon'] ) ) {

	$options = get_option( 'netfunktheme_options_addons' );

	$addon = $_REQUEST['addon'];
	
	$options[$addon] = wp_filter_nohtml_kses( 0 );

	update_option('netfunktheme_options_addons', $options); //update option array

}

/* include valid theme addon files */
$folder_paths = glob (get_template_directory() . '/addons/*/*.php');
		
$active_addons = get_option( 'netfunktheme_options_addons' );

foreach ($folder_paths as $file) {
	
	// check for active addons 
	if ($args = validate_theme_addon($file)){
		
		if (isset($active_addons[$args[0]]) && $active_addons[$args[0]] == 1)
			require_once($file);
	}
}

// EOF