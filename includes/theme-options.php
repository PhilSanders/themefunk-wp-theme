<?php

/* netfunktheme pages settings options */

/* netfunktheme admin CSS addon */
function netfunktheme_foundation_css() {
  wp_register_style( 'netfunktheme_admin_foundation', get_template_directory_uri(). '/css/foundation.custom.css' );
  wp_enqueue_style( 'netfunktheme_admin_foundation' );
  wp_register_style( 'font-awesome-admin', get_template_directory_uri() . '/css/font-awesome.min.css' );
  wp_enqueue_style( 'font-awesome-admin' );
}
add_action('admin_head', 'netfunktheme_foundation_css');

/* netfunktheme options init */
function netfunktheme_options_init(){
  register_setting( 'netfunktheme-options-general', 	'netfunktheme_options_general', 	'netfunktheme_options_general_validate' );
  register_setting( 'netfunktheme-options-frontpage', 	'netfunktheme_options_frontpage', 	'netfunktheme_options_frontpage_validate' );
  register_setting( 'netfunktheme-options-pages', 		'netfunktheme_options_pages', 		'netfunktheme_options_pages_validate' );
  register_setting( 'netfunktheme-options-posts', 		'netfunktheme_options_posts', 		'netfunktheme_options_posts_validate' );
  register_setting( 'netfunktheme-options-script', 		'netfunktheme_options_script', 		'netfunktheme_options_script_validate' );
  
  /* populate predfined settings */
  $general_options = get_option('netfunktheme_options_general');
  add_option( 'netfunktheme_options_general', $general_options,'','yes');
  $frontpage_options = get_option('netfunktheme_options_frontpage');
  add_option( 'netfunktheme_options_frontpage', $frontpage_options,'','yes');
  $page_options = get_option('netfunktheme_options_pages');
  add_option( 'netfunktheme_options_pages', $page_options,'','yes');
  $post_options = get_option('netfunktheme_options_posts');
  add_option( 'netfunktheme_options_posts', $post_options,'','yes');
  $post_options = get_option('netfunktheme_options_script');
  add_option( 'netfunktheme_options_script', $post_options,'','yes');
}
add_action( 'admin_init', 'netfunktheme_options_init' );

/* netfunktheme admin menu pages */
function netfunktheme_options_add_page() {
  add_menu_page( __( 'Theme General Settings'), __('NetfunkTheme') ,'edit_theme_options','theme_settings', 'theme_options_welcome', get_template_directory_uri() .'/images/theme-icon.png',68 );
  add_submenu_page('theme_settings',__( ' Welcome' ),			__('Welcome')			,'edit_theme_options','theme_settings', 'theme_options_welcome' );
  add_submenu_page('theme_settings',__( ' General Settings' ),	__('General Settings')	,'edit_theme_options','theme_general',	'theme_options_general');
  add_submenu_page('theme_settings',__( ' Front Page' ),		__('Front Page')		,'edit_theme_options','theme_frontpage','theme_options_frontpage');
  add_submenu_page('theme_settings',__( ' Content Pages' ),		__('Pages')				,'edit_theme_options','theme_pages', 	'theme_options_pages');
  add_submenu_page('theme_settings',__( ' Blog Posts' ),		__('Posts')				,'edit_theme_options','theme_posts', 	'theme_options_posts');
  add_submenu_page('theme_settings',__( ' CSS & JavaScript' ),	__('Scripting')			,'edit_theme_options','theme_css', 		'theme_options_css');
}
add_action( 'admin_menu', 'netfunktheme_options_add_page' );

// get the NetfunkTheme options
$netfunk_general_options 	= get_option('netfunktheme_options_general');
$theme_options       		= get_option('netfunktheme_options_frontpage');
$netfunk_page_options   	= get_option('netfunktheme_options_pages');
$netfunk_post_options   	= get_option('netfunktheme_options_posts');
$script_options       		= get_option('netfunktheme_options_script');

/* netfunkthem general settings options update */
function netfunktheme_options_general_validate( $input ) {

	if ( ! isset( $input['splash_height'] ) )
		$input['splash_height'] = '400'; 
	
	if ( ! isset( $input['show_num_features'] ) )
		$input['show_num_features'] = '4';
 
	return $input;
}

/* netfunktheme front page options update */
function netfunktheme_options_frontpage_validate( $input ) {

	global $onoff_options;

	if ( ! isset( $input['show_welcome_message'] ) )
		$input['show_welcome_message'] = 'yes';
	if ( ! array_key_exists( $input['show_welcome_message'], $onoff_options ) )
		$input['show_welcome_message'] = 'yes';
	// show featured content on front page
	if ( ! isset( $input['show_featured_content'] ) )
		$input['show_featured_content'] = 'yes';
	if ( ! array_key_exists( $input['show_welcome_message'], $onoff_options ) )
		$input['show_featured_content'] = 'yes';
	// show recent posts on front page
	if ( ! isset( $input['show_posts_on_home'] ) )
		$input['show_posts_on_home'] = 'yes';
	if ( ! array_key_exists( $input['show_posts_on_home'], $onoff_options ) )
		$input['show_posts_on_home'] = 'yes';
    // show bottom content on front page
	if ( ! isset( $input['show_front_page_bottom_content'] ) )
		$input['show_front_page_bottom_content'] = 'yes';
	if ( ! array_key_exists( $input['show_front_page_bottom_content'], $onoff_options ) )
		$input['show_front_page_bottom_content'] = 'yes';
    //show sidebars on front page
	if ( ! isset( $input['show_front_page_sidebar'] ) )
		$input['show_front_page_sidebar'] = 'yes';
	if ( ! array_key_exists( $input['show_front_page_sidebar'], $onoff_options ) )
		$input['show_front_page_sidebar'] = 'yes';
	// show front page primary sidebar
	if ( ! isset( $input['show_front_page_primary_sidebar'] ) )
		$input['show_front_page_primary_sidebar'] = 'yes';
	if ( ! array_key_exists( $input['show_front_page_primary_sidebar'], $onoff_options ) )
		$input['show_front_page_primary_sidebar'] = 'yes';
    // show front page secondadry sidebar
	if ( ! isset( $input['show_front_page_secondary_sidebar'] ) )
		$input['show_front_page_secondary_sidebar'] = 'no';
	if ( ! array_key_exists( $input['show_front_page_secondary_sidebar'], $onoff_options ) )
		$input['show_front_page_secondary_sidebar'] = 'no';
    // show front page welcome message title
    if ( ! isset( $input['welcome_title'] ) )
		$input['welcome_title'] = "<span style='color: #30b0c4'>Netfunk</span><i>Theme...</i>";
    // show front page welcome message
    if ( ! isset( $input['welcome_text'] ) )
		$input['welcome_text'] = 'Responsive, Foundation 5, HTML5 \"Smart\" theme by NetfunkDesign. Provides custom widgets for the front page and other dynamic content areas to offer a customizable layout suitable for both business and multimedia websites a-like.';
    // more about button label 
    if ( ! isset( $input['more_about_title'] ) )
       $input['more_about_title'] = 'More About NetfunkTheme';
    // more about button URL 
    if ( ! isset( $input['more_about_uri'] ) )
       $input['more_about_uri'] = '/about/'; 

	return $input;
}

/* netfunktheme pages options update */
function netfunktheme_options_pages_validate( $input ) {

	global $post_splash_options, $onoff_options;

	//posts_splash_type
	if ( ! isset( $input['page_splash_type'] ) )
		$input['page_splash_type'] = '0';
	if ( ! array_key_exists( $input['page_splash_type'], $post_splash_options ) )
		$input['page_splash_type'] = '0';
	//show_page_comments
	if ( ! isset( $input['show_page_comments'] ) )
		$input['show_page_comments'] = 'yes';
	if ( ! array_key_exists( $input['show_page_comments'], $onoff_options ) )
		$input['show_page_comments'] = 'yes';
	//show_page_author 
	if ( ! isset( $input['show_page_author'] ) )
		$input['show_page_author'] = 'yes';
	if ( ! array_key_exists( $input['show_page_author'], $onoff_options ) )
		$input['show_page_author'] = 'yes';
	
	if ( ! isset( $input['show_page_bottom_content'] ) )
		$input['show_page_bottom_content'] = 'yes';
	if ( ! array_key_exists( $input['show_page_bottom_content'], $onoff_options ) )
		$input['show_page_bottom_content'] = 'yes';
	
	if ( ! isset( $input['show_pages_sidebar'] ) )
		$input['show_pages_sidebar'] = 'yes';
	if ( ! array_key_exists( $input['show_pages_sidebar'], $onoff_options ) )
		$input['show_pages_sidebar'] = 'yes';
	
	if ( ! isset( $input['show_page_primary_sidebar'] ) )
		$input['show_page_primary_sidebar'] = 'no';
	if ( ! array_key_exists( $input['show_page_primary_sidebar'], $onoff_options ) )
		$input['show_page_primary_sidebar'] = 'no';

	if ( ! isset( $input['show_page_secondary_sidebar'] ) )
		$input['show_page_secondary_sidebar'] = 'yes';
	if ( ! array_key_exists( $input['show_page_secondary_sidebar'], $onoff_options ) )
		$input['show_page_secondary_sidebar'] = 'yes';

	return $input;
}

/* netfunktheme posts pages options update */
function netfunktheme_options_posts_validate( $input ) {
	
	global $post_splash_options, $post_nav_options, $onoff_options;
	
	//posts_splash_type
	if ( ! isset( $input['posts_splash_type'] ) )
		$input['posts_splash_type'] = '0';
	if ( ! array_key_exists( $input['posts_splash_type'], $post_splash_options ) )
		$input['posts_splash_type'] = '0';
	//show_post_meta 
	if ( ! isset( $input['show_post_meta'] ) )
		$input['show_post_meta'] = 'yes';
	if ( ! array_key_exists( $input['show_post_meta'], $onoff_options ) )
		$input['show_post_meta'] = 'yes';
	//show_post_footer_meta 
	if ( ! isset( $input['show_post_footer_meta'] ) )
		$input['show_post_footer_meta'] = 'yes';
	if ( ! array_key_exists( $input['show_post_footer_meta'], $onoff_options ) )
		$input['show_post_footer_meta'] = 'yes';
	//show_post_thumbnail 
	if ( ! isset( $input['show_post_thumbnail'] ) )
		$input['show_post_thumbnail'] = 'yes';
	if ( ! array_key_exists( $input['show_post_thumbnail'], $onoff_options ) )
		$input['show_post_thumbnail'] = 'yes';
	//show_post_comments 
	if ( ! isset( $input['show_post_comments'] ) )
		$input['show_post_comments'] = 'yes';
	if ( ! array_key_exists( $input['show_post_comments'], $onoff_options ) )
		$input['show_post_comments'] = 'yes';
	//show_post_author 
	if ( ! isset( $input['show_post_author'] ) )
		$input['show_post_author'] = 'yes';
	if ( ! array_key_exists( $input['show_post_author'], $onoff_options ) )
		$input['show_post_author'] = 'yes';
	//show_nav_above 
	if ( ! isset( $input['show_nav_above'] ) )
		$input['show_nav_above'] = 'yes';
	if ( ! array_key_exists( $input['show_nav_above'], $onoff_options ) )
		$input['show_nav_above'] = 'yes';
	//show_nav_below
	if ( ! isset( $input['show_nav_below'] ) )
		$input['show_nav_below'] = 'yes';
	if ( ! array_key_exists( $input['show_nav_below'], $onoff_options ) )
		$input['show_nav_below'] = 'yes';
	//posts_nav_type
	if ( ! isset( $input['posts_nav_type'] ) )
		$input['posts_nav_type'] = '0';
	if ( ! array_key_exists( $input['posts_nav_type'], $post_nav_options ) )
		$input['posts_nav_type'] = '0';
	//show_post_bottom_content
	if ( ! isset( $input['show_post_bottom_content'] ) )
		$input['show_post_bottom_content'] = 'yes';
	if ( ! array_key_exists( $input['show_post_bottom_content'], $onoff_options ) )
		$input['show_post_bottom_content'] = 'yes';
	//show_posts_sidebar
	if ( ! isset( $input['show_posts_sidebar'] ) )
		$input['show_posts_sidebar'] = 'yes';
	if ( ! array_key_exists( $input['show_posts_sidebar'], $onoff_options ) )
		$input['show_posts_sidebar'] = 'yes';
	//show_post_primary_sidebar
	if ( ! isset( $input['show_post_primary_sidebar'] ) )
		$input['show_post_primary_sidebar'] = 'yes';
	if ( ! array_key_exists( $input['show_post_primary_sidebar'], $onoff_options ) )
		$input['show_post_primary_sidebar'] = 'yes';
	//show_post_secondary_sidebar
	if ( ! isset( $input['show_post_secondary_sidebar'] ) )
		$input['show_post_secondary_sidebar'] = 'yes';
	if ( ! array_key_exists( $input['show_post_secondary_sidebar'], $onoff_options ) )
		$input['show_post_secondary_sidebar'] = 'yes';

	return $input;
}

/* netfunktheme sutom css options update */
function netfunktheme_options_script_validate( $input ) {
	
	if ( !isset($input['custom_css']) )
	  $input['custom_css'] = '';
	
	if ( !isset($input['javascript_top']) )
	 $input['javascript_top'] = '';

    if ( !isset($input['javascript_top']) )
	  $input['javascript_bottom'] = '';

	return $input;
}

/* netfunktheme splash image options selects */
$post_splash_options = array(
  '0' => array(
    'value' =>	'0',
    'label' => __( 'Splash Img | Hide Thumbnail', 'netfunktheme' )),
  '1' => array(
    'value' =>	'1',
    'label' => __( 'Splash Img + Show Thumbnail' )),
  '2' => array(
    'value' =>	'2',
    'label' => __( 'No Splash | Hide Thumbnail', 'netfunktheme' )),
  '3' => array(
    'value' =>	'3',
    'label' => __( 'No Splash + Show Thumbnail', 'netfunktheme' ))
);

/* netfunktheme on/off options */
$onoff_options = array(
  'yes' => array(
    'value' => 'yes',
    'label' => __( 'Yes', 'netfunktheme' )),
  'no' => array(
    'value' => 'no',
    'label' => __( 'No', 'netfunktheme' ))
);

/* netfunktheme posts navigation button options */
$post_nav_options = array(
  '0' => array(
    'value' =>	'0',
    'label' => __( 'Show Older | Newer Posts Text', 'netfunktheme' )),
  '1' => array(
    'value' =>	'1',
    'label' => __( 'Show Post Titles Text', 'netfunktheme' ))
);

/* netfunktheme options pages navi */
function theme_nav() {

  $page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : '');
?> 
  <div class="theme-settings-nav">
    <ul>
      <li> <a href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_settings" ?>" <?php echo ($page == 'theme_settings' ? 'class="current"' : '') ?>> Welcome </a> </li>
      <li> <a href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_general" ?>" <?php echo ($page == 'theme_general' ? 'class="current"' : '') ?>> General Settings </a> </li>
      <li> <a href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_frontpage" ?>" <?php echo ($page == 'theme_frontpage' ? 'class="current"' : '') ?>> Front Page </a> </li>
      <li> <a href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_pages" ?>" <?php echo ($page == 'theme_pages' ? 'class="current"' : '') ?>> Pages </a> </li>
      <li> <a href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_posts" ?>" <?php echo ($page == 'theme_posts' ? 'class="current"' : '') ?>> Posts </a> </li>
      <li> <a href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_css" ?>" <?php echo ($page == 'theme_css' ? 'class="current"' : '') ?>> Scripting </a> </li>
      <li> <a href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_addons" ?>" <?php echo ($page == 'theme_addons' ? 'class="current"' : '') ?>> Add-ons  </a> </li>
      <?php 
		/* bbPress plugin support */
		if (function_exists('netfunktheme_bbpress_plugin_init')){
          echo '<li class="plugin bbpress"> <a href="'. $_SERVER['PHP_SELF']. '?page=theme_bbpress"'. ($page == 'theme_bbpress' ? ' class="current"' : '').'> <i class="fa fa-caret-right"></i> bbPress  </a> </li> ';
		}
		/* buddyPress plugin */
		if (class_exists('BuddyPress')){
          echo '<li class="plugin"> <a href="'. $_SERVER['PHP_SELF']. '?page=theme_buddypress"'. ($page == 'theme_buddypress' ? ' class="current"' : '').'> <i class="fa fa-caret-right"> </i> buddyPress </a> </li> ';
		}
      ?>
    </ul>
  </div> 
<?php
}

/* netfunktheme welcome page */
function theme_options_welcome() {

?>
	<div class="wrap netfunktheme-admin">

		<h2>
        	<span class="dashicons dashicons-welcome-widgets-menus" data-code="f116" style="font-size: 30px"></span> &nbsp; 
			<?php echo wp_get_theme() . __( '', 'netfunktheme' ); ?>
        </h2>
        <br />
    
        <?php theme_nav() ?>
        <br />
        
        <div class="panel radius large-10 medium-10 small-10">
            <div class="large-8">
                <p><span class="fa fa-exclamation fa-4x left" style="margin-right: 20px"></span><h2 class="antialiased">
                Welcome to your <strong><span style="color:#30b0c4">Netfunk</span><i>Theme</i></strong></h2> Read here for help setting up and configuring <u>Netfunk<i>Theme</i></u>. 
                There are many display options and all configurable through this control panel. Use the menu at the top of this page to navigate the various content areas; 
                Including the <strong>Front Page</strong>, <strong>Content Pages</strong>, <strong>Blog Posts</strong>, <strong>Custom CSS / Scripting</strong> and the native 
                <strong>Plugins</strong> section to get you started.</p>
            </div>
        	<br />
            <hr />
       		<br />   

            <div class="large-6 small-12 left">
                <h2 class="left"><i class="fa fa-lightbulb-o"></i> &nbsp; Quick Walkthrough <br  /> <small>For more information click the button below each section.</small> </h2>
            	<i class="fa fa-arrow-down fa-3x netfunktheme-walkthrough show-for-large-up"></i>
            </div>

            <div class="large-6 small-12 left">
                <div class="large-6 left">
                	<h2><i class="fa fa-info-circle"></i> &nbsp; Documentation <br  /> <small>Jump to the full documentation section.</small> </h2>
                </div>
               <div class="large-6 left">
               		<br />
                	<a href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_docs" ?>" class="button-docs">NetfunkTheme Docs</a>
                </div>
            </div>
            <br clear="all" />
            <br />
            <hr />
            <br />

            <div class="large-3 medium-6 small-12 left">
                <h4>Front Page</h4>
                <p style="padding-right: 10px;">The <strong><u>Front Page</u></strong> offers features for your personallized welcome message, a designated featured content area, bottom of page widgets area and your recent posts. all of which may be enabled or disabled alike.</p>
                <a class="button-primary" href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_frontpage" ?>"> Front Page Settings </a>
            </div>

			<div class="large-3 medium-6 small-12 left">
                <h4>Content Pages</h4>
                <p style="padding-right: 10px;">To make customization easy we provide options for <strong><u>Custom CSS</u></strong> and <strong><u>JavaScript</u></strong> mark up. Use this feature to add custom styling or JavaScript such as Google Adsense or any other scripting you require.</p>
                <a class="button-primary" href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_pages" ?>"> Content Pages </a>
            </div>

            <div class="large-3 medium-6 small-12 left">
                <h4>Blog Posts</h4>
                <p style="padding-right: 10px;">To make customization easy we provide options for <strong><u>Custom CSS</u></strong> and <strong><u>JavaScript</u></strong> mark up. Use this feature to add custom styling or JavaScript such as Google Adsense or any other scripting you require.</p>
                <a class="button-primary" href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_posts" ?>"> Blogs Posts </a>
            </div>

            <div class="large-3 medium-6 small-12 left">
                <h4>CSS & JavaScript</h4>
                <p style="padding-right: 10px;">To make customization easy we provide options for <strong><u>Custom CSS</u></strong> and <strong><u>JavaScript</u></strong> mark up. Use this feature to add custom styling or JavaScript such as Google Adsense or any other scripting you require.</p>
                <a class="button-primary" href="<?php echo $_SERVER['PHP_SELF']. "?page=theme_css" ?>"> CSS & JavaScript </a>
            </div>

            <br clear="all" />
            <br />
            
        </div>
        
        <div class="panel radius large-10 medium-10 small-10">
        	<h2><i class="fa fa-ambulance"></i> &nbsp; Get Help from the Pros</h2>
			<div class="large-6">
              <p>Need some help? Head over to the forum to ask a professional. We are eager to help with any question you might have about setting up and customizing your <strong>NetfunkTheme</strong>.</p>
              <a href="http://www.netfunkdesign.com/forum" class="button-primary">NetfunkTheme Forum</a>
            </div>
        </div>
	</div>
<?php
}

/* netfunktheme general settings options page */
function theme_options_general() {

	global $onoff_options;
	
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

?>
	<div class="wrap netfunktheme-admin">
    
    	<h2>
        
        	<span class="dashicons dashicons-dashboard" data-code="f226" style="font-size: 30px"></span> &nbsp; 
			<?php echo wp_get_theme() . __( ' - General Settings', 'netfunktheme' ); ?>
        
        </h2>
    
        <br />
        
        <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'netfunktheme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
		
		<?php settings_fields( 'netfunktheme-options-general' ); ?>
        <?php $options = get_option( 'netfunktheme_options_general' ); ?>
    
    	<?php 
			
			// set default values 
			if ( ! isset( $options['splash_height'] ) )
				$options['splash_height'] = '400'; 
			
			if ( ! isset( $options['show_num_features'] ) )
				$options['show_num_features'] = '4'; 
		
		?>
    
    
        <?php theme_nav() ?>

        <br />
        
        <div class="panel callout radius">
			<p>General settings options affect content sitewide. You may also make adjustments for both Pages and Posts type content independantly. </p>
        </div>
        
        <h3 class="netfunk title">Splash Content General Settings</h3>
        
        <div class="panel radius">
            
            <span class="fa fa-tachometer hide-for-small show-for-large-up" style="z-index: 1; color: #CCC; position: absolute; left: 100%; margin-left: -200px; font-size: 150px; "></span>
            
            <h3>Splash Image Content Area Height</h3>
            
        	<table class="form-table">
              <tr valign="top"><th scope="row"><?php _e( ' Splash Height', 'netfunktheme' ); ?></th>
               <td>
                 <input type="text" id="netfunktheme_options_general[splash_height]" name="netfunktheme_options_general[splash_height]" size="5" value="<?php echo (isset($options['splash_height']) ? $options['splash_height'] : '' ); ?>"> px <br />
                 <label class="description" for="netfunktheme_options_general[splash_height]"><?php _e( 'The height of the splash image content area', 'netfunktheme' ); ?></label>
                </td>
              </tr>
            </table> 
            
            <h3>Slash Content Display Limit</h3>
            
        	<table class="form-table">
              <tr valign="top"><th scope="row"><?php _e( ' Featured Item Limit', 'netfunktheme' ); ?></th>
               <td>
                 <input type="text" id="netfunktheme_options_general[show_num_features]" name="netfunktheme_options_general[show_num_features]" size="5" value="<?php echo (isset($options['show_num_features']) ? $options['show_num_features'] : '' ); ?>"> <br />
                 <label class="description" for="netfunktheme_options_general[show_num_features]"><?php _e( 'The maximum number of featured items to display.', 'netfunktheme' ); ?></label>
                </td>
              </tr>
            </table>  

		</div>
        
        <div class="panel radius">

            <h3>Save Theme Settings </h3>
            
            <br />
            
            <p>
                <input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'netfunktheme' ); ?>" />
            </p>
            
            <br />
        
        </div>
        
        </form>
        
	</div>
<?php

}

/* netfunktheme front page options */
function theme_options_frontpage() {
	global $onoff_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
	  $_REQUEST['settings-updated'] = false;
?>

	<div class="wrap netfunktheme-admin">
    
    	<h2>
        	<span class="dashicons dashicons-admin-home" data-code="f102" style="font-size: 30px"></span> &nbsp; 
			<?php echo wp_get_theme() . __( ' - Front Page', 'netfunktheme' ); ?>
        </h2>
		<br />

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'netfunktheme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
		
		<?php settings_fields( 'netfunktheme-options-frontpage' ); ?>
        <?php $options = get_option( 'netfunktheme_options_frontpage' ); ?>

		<?php theme_nav() ?>
		<br />

        <div class="panel callout radius">
			<p>Customize what is displayed on your front page. </p>
        </div>

        <h3 class="netfunk title">Font Page Featured Content Area</h3>

		<div class="panel radius">

		<span class="fa fa-home hide-for-small show-for-large-up" style="z-index: 1; color: #CCC; position: absolute; left: 100%; margin-left: -200px; font-size: 150px; "></span>

		<h3>Welcome Message on Front Page</h3>

         <table class="form-table">
            <tr valign="top"><th scope="row"><?php _e( ' Show the welcome message', 'netfunktheme' ); ?></th>
                <td>
                	<?php
                       
					    if ( ! isset( $checked ) )
                            $checked = '';

					    foreach ( $onoff_options as $option ) {
                    
							if (!isset($options['show_welcome_message']))
								$options['show_welcome_message'] = 'yes';
					
					        $radio_setting = $options['show_welcome_message'];

                            if ( '' != $radio_setting ) {
                     
					            if ( $options['show_welcome_message'] == $option['value'] ) {
                                    $checked = "checked=\"checked\"";
                     
					            } else {
                   
				                    $checked = '';
                                }
                   
				            }

				      		?>
                 
                            <label class="description"><input type="radio" name="netfunktheme_options_frontpage[show_welcome_message]" id="netfunktheme_options_frontpage[show_welcome_message]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
                      <?php } ?>

                    </td>
                </tr>
            </table>
            
            <div class="panel radius">
            
                <table class="form-table">
                    <tr valign="top"><th scope="row"><?php _e( ' Welcome title', 'netfunktheme' ); ?></th>
                    <td>
                        <input type="text" id="netfunktheme_options_frontpage[welcome_title]" name="netfunktheme_options_frontpage[welcome_title]" size="40" value="<?php echo (isset($options['welcome_title']) ? $options['welcome_title'] : '' ); ?>"> 
                        <label class="description" for="netfunktheme_options_frontpage[welcome_title]"><?php _e( 'Your welcome title goes here', 'netfunktheme' ); ?></label>
                    </td>
                </tr>
                <tr valign="top"><th scope="row"><?php _e( ' Welcome message', 'netfunktheme' ); ?></th>
                    <td>
                        <textarea id="netfunktheme_options_frontpage[welcome_text]" cols="80" rows="10" name="netfunktheme_options_frontpage[welcome_text]"><?php echo (isset($options['welcome_text']) ? esc_textarea($options['welcome_text']) : '' ) ; ?></textarea> <br  />
                        <label class="description" for="netfunktheme_options_frontpage[welcome_text]"><?php _e( 'Your welcome message goes here', 'netfunktheme' ); ?></label>
                    </td>
                </tr>
                <tr valign="top"><th scope="row"><?php _e( ' Welcome button title', 'netfunktheme' ); ?></th>
                    <td>
                        <input type="text" id="netfunktheme_options_frontpage[more_about_title]" name="netfunktheme_options_frontpage[more_about_title]" value="<?php echo (isset($options['more_about_title']) ? $options['more_about_title'] : '' ); ?>"> 
                        <label class="description" for="netfunktheme_options_frontpage[more_about_title]"><?php _e( 'Title of the \'more about\' button. Leave empty if you dont want to display it.', 'netfunktheme' ); ?></label>
                    </td>
                </tr>
                <tr valign="top"><th scope="row"><?php _e( ' Welcome button url', 'netfunktheme' ); ?></th>
                    <td>
                        <input type="text" id="netfunktheme_options_frontpage[more_about_uri]" name="netfunktheme_options_frontpage[more_about_uri]" value="<?php echo (isset($options['more_about_uri']) ? $options['more_about_uri'] : '' ); ?>"> 
                        <label class="description" for="netfunktheme_options_frontpage[more_about_uri]"><?php _e( 'The url to you \'about\' page', 'netfunktheme' ); ?></label>
                    </td>
                </tr>
                <tr valign="top"><th scope="row"><?php _e( ' More about link', 'netfunktheme' ); ?></th>
                    <td>
                        <?php wp_dropdown_pages(); ?>
                    </td>
                </tr>
    
            </table>
        
        </div>

        <hr />
        
        <br />
        
        <h3>Show the featured content area</h3>

        <table class="form-table">
            
            <tr>
              <td colspan="2">Display the Featured Content area on the front page. This area shares a page width with the welcome message area.</td>
            </tr>
            
            <tr valign="top"><th scope="row"><?php _e( ' Show featured', 'netfunktheme' ); ?></th>
                <td>
                    <?php
                       
					    if ( ! isset( $checked ) )
                            $checked = '';
                     
					 
					    foreach ( $onoff_options as $option ) {
                    
							if (!isset($options['show_featured_content']))
								$options['show_featured_content'] = 'yes';
					
							$radio_setting = $options['show_featured_content'];

							if ( '' != $radio_setting ) {
					 
								if ( $options['show_featured_content'] == $option['value'] ) {
									$checked = "checked=\"checked\"";
					 
								} else {
				   
									$checked = '';
								}
				   
							}

				            ?>
                 
                            <label class="description"><input type="radio" name="netfunktheme_options_frontpage[show_featured_content]" id="netfunktheme_options_frontpage[show_featured_content]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
                            <?php
                
				        }
              
			        ?>
                    
                </td>
            </tr>
            
            
        </table>

		</div>
        
        <h3 class="netfunk title">Front Page General Content</h3>

		<div class="panel radius">

        <h3>Show your recent posts on the front page</h3>

        <table class="form-table">
            
            <tr valign="top"><th scope="row"><?php _e( ' Show recent posts', 'netfunktheme' ); ?></th>
                <td>
                    <?php
                       
					    if ( ! isset( $checked ) )
                            $checked = '';

					    foreach ( $onoff_options as $option ) {
                    
							if (!isset($options['show_posts_on_home']))
								$options['show_posts_on_home'] = 'yes';
					
							$radio_setting = $options['show_posts_on_home'];
							if ( '' != $radio_setting ) {
								if ( $options['show_posts_on_home'] == $option['value'] ) {
									$checked = "checked=\"checked\"";
								} else {
									$checked = '';
								}
							}
						?>
                 
                        <label class="description"><input type="radio" name="netfunktheme_options_frontpage[show_posts_on_home]" id="netfunktheme_options_frontpage[show_posts_on_home]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
                        <?php
				        }
			        ?>
                    
                </td>
            </tr>
        </table>

		</div>

        <h3 class="netfunk title">Front Page Bottom Content</h3>
        
        <div class="panel radius">
        <table class="form-table">
        
        	<tr>
              <td colspan="2">Display the Page Bottom Content widget area on the front page.</td>
            </tr>
        
            <tr valign="top"><th scope="row"><?php _e( ' Show page bottom content', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_front_page_bottom_content']))
						$options['show_front_page_bottom_content'] = 'yes';
			
					$radio_setting = $options['show_front_page_bottom_content'];
					if ( '' != $radio_setting ) {
						if ( $options['show_front_page_bottom_content'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_frontpage[show_front_page_bottom_content]" id="netfunktheme_options_frontpage[show_front_page_bottom_content]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        </div>

        <h3 class="netfunk title">Sidebars On Front Page</h3>
        
        <div class="panel radius">
        
          <h3>Display the sidebar widget area on front page</h3>
        
          <table class="form-table">
            
            <tr valign="top"><th scope="row"><?php _e( ' Show sidebars', 'netfunktheme' ); ?></th>
              <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_front_page_sidebar']))
						$options['show_front_page_sidebar'] = 'yes';
					
					$radio_setting = $options['show_front_page_sidebar'];
					if ( '' != $radio_setting ) {
						if ( $options['show_front_page_sidebar'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				?>
                 <label class="description"><input type="radio" name="netfunktheme_options_frontpage[show_front_page_sidebar]" id="netfunktheme_options_frontpage[show_front_page_sidebar]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp;
                <?php }  ?>
             </td>
          </tr>
        </table>

		<hr />
        
        <h3>Limit Sidebars On Front Page</h3>
        
        <table class="form-table">
            <tr valign="top"><th scope="row"><?php _e( ' Show primary sidebar', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_front_page_primary_sidebar']))
						$options['show_front_page_primary_sidebar'] = 'yes';
			
					$radio_setting = $options['show_front_page_primary_sidebar'];
					if ( '' != $radio_setting ) {
						if ( $options['show_front_page_primary_sidebar'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_frontpage[show_front_page_primary_sidebar]" id="netfunktheme_options_frontpage[show_front_page_primary_sidebar]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
          <tr valign="top"><th scope="row"><?php _e( ' Show secondary sidebar', 'netfunktheme' ); ?></th>
             <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_front_page_secondary_sidebar']))
						$options['show_front_page_secondary_sidebar'] = 'no';
			
					$radio_setting = $options['show_front_page_secondary_sidebar'];
					if ( '' != $radio_setting ) {
						if ( $options['show_front_page_secondary_sidebar'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_frontpage[show_front_page_secondary_sidebar]" id="netfunktheme_options_frontpage[show_front_page_secondary_sidebar]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        </div>

        <div class="panel radius">

            <h3>Save Theme Settings </h3>
            
            <br />
            
            <p>
                <input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'netfunktheme' ); ?>" />
            </p>
            
            <br />
        
        </div>

	</form>

</div>
<?php
}

/* netfunktheme pages options */
function theme_options_pages() {
	global $post_splash_options, $onoff_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
?>
	<div class="wrap netfunktheme-admin">
    	
        <h2>
        	<span class="dashicons dashicons-format-aside" data-code="f123" style="font-size: 30px"></span> &nbsp; 
			<?php echo wp_get_theme() . __( ' - Content Page Layout Options', 'netfunktheme' ); ?>
        </h2>  

        <br />
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
       		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'netfunktheme' ); ?></strong></p></div>
		<?php endif; ?>
		<form method="post" action="options.php">
		<?php settings_fields( 'netfunktheme-options-pages' ); ?>
        <?php $options = get_option( 'netfunktheme_options_pages' ); ?>
		<?php theme_nav() ?>
		
        <br />

        <div class="panel callout radius">
			<p>Customize what is displayed on your content pages. </p>
        </div>
        
        
        <h3 class="netfunk title">Page Splash Type</h3>

        <div class="panel radius">
        
        <h3>Page Splash Type</h3>
            
        <table class="form-table">
        
        	<tr>
              <td colspan="2">Display page splash image, taken from the first image in your post. Or you may disable splash images all togeather.</td>
            </tr>
        
            <tr valign="top">
              <th scope="row"><?php _e( ' Splash type', 'netfunktheme' ); ?></th>
                <td>

                <select name="netfunktheme_options_pages[page_splash_type]">
					<?php
                        
                        $p = '';
                        $r = '';
						
						if (!isset($options['page_splash_type']))
							$options['page_splash_type'] = '1';
						
						$selected = $options['page_splash_type'];

                        foreach ( $post_splash_options as $option ) {
                            $label = $option['label'];
                            if ( $selected == $option['value'] ) // Make default first in list
                                $p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
                            else
                                $r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
                        }
                        echo $p . $r;
                    ?>
                </select>

            </td>
          </tr>
        </table>
        </div>

        <h3 class="netfunk title">Page General Content</h3>
        
        <div class="panel radius">

        <h3>Display The Page Comments</h3>
        
        <table class="form-table">
        
            <tr valign="top"><th scope="row"><?php _e( ' Page comments', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_page_comments']))
						$options['show_page_comments'] = 'yes';
			
					$radio_setting = $options['show_page_comments'];
					if ( '' != $radio_setting ) {
						if ( $options['show_page_comments'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_pages[show_page_comments]" id="netfunktheme_options_pages[show_page_comments]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        
        <hr />
        
        <h3>Display The Author Info Area</h3>
        
        <table class="form-table">
        
            <tr valign="top"><th scope="row"><?php _e( 'About the author', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_page_author']))
						$options['show_page_author'] = 'yes';
			
					$radio_setting = $options['show_page_author'];
					if ( '' != $radio_setting ) {
						if ( $options['show_page_author'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_pages[show_page_author]" id="netfunktheme_options_pages[show_page_author]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>

        </div>

        <h3 class="netfunk title">Page bottom Content</h3>
        
        <div class="panel radius">
        <table class="form-table">
        
        	<tr>
              <td colspan="2">Display the Page Bottom Content widget area. This is located below the output and comments section of content pages.</td>
            </tr>
        
            <tr valign="top"><th scope="row"><?php _e( ' Page bottom content', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_page_bottom_content']))
						$options['show_page_bottom_content'] = 'yes';
			
					$radio_setting = $options['show_page_bottom_content'];
					if ( '' != $radio_setting ) {
						if ( $options['show_page_bottom_content'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_pages[show_page_bottom_content]" id="netfunktheme_options_pages[show_page_bottom_content]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        </div>

        <h3 class="netfunk title">Sidebar On Pages</h3>
        
        <div class="panel radius">
        
        <h3>Display The Sidebar Widget Area On Content Pages</h3>
        
        <table class="form-table">
           <tr valign="top">
              <th scope="row"><?php _e( ' Show sidebars', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_pages_sidebar']))
						$options['show_pages_sidebar'] = 'yes';
			
					$radio_setting = $options['show_pages_sidebar'];
					if ( '' != $radio_setting ) {
						if ( $options['show_pages_sidebar'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_pages[show_pages_sidebar]" id="netfunktheme_options_pages[show_pages_sidebar]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp;
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>

		<hr />
        
        <h3>Limit Sidebars On Content Pages</h3>

        <table class="form-table">
            <tr valign="top"><th scope="row"><?php _e( ' Show primary sidebar', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_page_primary_sidebar']))
						$options['show_page_primary_sidebar'] = 'no';
			
					$radio_setting = $options['show_page_primary_sidebar'];
					if ( '' != $radio_setting ) {
						if ( $options['show_page_primary_sidebar'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_pages[show_page_primary_sidebar]" id="netfunktheme_options_pages[show_page_primary_sidebar]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp;
                 
               <?php }  ?>
             
            </td>
          </tr>
          
          <tr valign="top"><th scope="row"><?php _e( ' Show secondary sidebar', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_page_secondary_sidebar']))
						$options['show_page_secondary_sidebar'] = 'yes';
			
					$radio_setting = $options['show_page_secondary_sidebar'];
					if ( '' != $radio_setting ) {
						if ( $options['show_page_secondary_sidebar'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_pages[show_page_secondary_sidebar]" id="netfunktheme_options_pages[show_page_secondary_sidebar]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp;
                 
               <?php }  ?>
             
            </td>
          </tr>
          
        </table>
        </div>
        
        <div class="panel radius">

            <h3>Save Theme Settings </h3>
            
            <br />
            
            <p>
                <input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'netfunktheme' ); ?>" />
            </p>
            
            <br />
        
        </div>
        
	</form>
</div>
<?php
} 

/* netfunktheme posts pages options */
function theme_options_posts() {
	global $post_splash_options, $post_nav_options, $onoff_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
?>
	<div class="wrap netfunktheme-admin">
    	<h2>
        
        	<span class="dashicons dashicons-admin-page" data-code="f105" style="font-size: 30px"></span> &nbsp; 
			<?php echo wp_get_theme() . __( ' - Blog Post Layout Options', 'netfunktheme' ); ?>
        
        </h2>
        
        <br />
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
       		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'netfunktheme' ); ?></strong></p></div>
		<?php endif; ?>
		<form method="post" action="options.php">
		<?php settings_fields( 'netfunktheme-options-posts' ); ?>
        <?php $options = get_option( 'netfunktheme_options_posts' ); ?>
		<?php theme_nav() ?>
        
        <br />

        <div class="panel callout radius">
			<p>Customize what is displayed on your blog posts pages. </p>
        </div>

        <h3 class="netfunk title">Posts Page Splash Type</h3>

        <div class="panel radius">
        
        <h3>Posts Splash Type</h3>
            
        <table class="form-table">
        
        	<tr>
              <td colspan="2">Display page splash image, taken from the first image in your post. Or you may disable splash images all togeather.</td>
            </tr>
        
            <tr valign="top">
              <th scope="row"><?php _e( ' Splash type', 'netfunktheme' ); ?></th>
                <td>

                <select name="netfunktheme_options_posts[posts_splash_type]">
					<?php
                        
						$p = '';
                        $r = '';
						
						if (!isset($options['posts_splash_type']))
							$options['posts_splash_type'] = '1';
						
						$selected = $options['posts_splash_type'];

                        foreach ( $post_splash_options as $option ) {
							$label = $option['label'];
                            if ( $selected == $option['value'] ) // Make default first in list
                                $p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
                            else
                                $r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
                        }
                        echo $p . $r;
                    ?>
                </select>

            </td>
          </tr>
        </table>
        </div>

        <h3 class="netfunk title">Posts Navigation</h3>
        <div class="panel radius">
        
        <h3>Posts navigation display type</h3>
            
            <table class="form-table">
            
            <tr valign="top"><th scope="row"><?php _e( ' Display type', 'netfunktheme' ); ?></th>
                <td>

                <select name="netfunktheme_options_posts[posts_nav_type]">
					<?php
                        $selected = $options['posts_nav_type'];
                        $p = '';
                        $r = '';

                        foreach ( $post_nav_options as $option ) {
                            $label = $option['label'];
                            if ( $selected == $option['value'] ) // Make default first in list
                                $p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
                            else
                                $r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
                        }
                        echo $p . $r;
                    ?>
                </select>

            </td>
          </tr>
        </table>
        
        <hr />

        <h3>Display the posts navigation menus</h3>
        
        <table class="form-table">        
            <tr valign="top"><th scope="row"><?php _e( ' Show top navigation', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_nav_above']))
						$options['show_nav_above'] = 'yes';
			
					$radio_setting = $options['show_nav_above'];
					if ( '' != $radio_setting ) {
						if ( $options['show_nav_above'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_posts[show_nav_above]" id="netfunktheme_options_posts[show_nav_above]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
          <tr valign="top"><th scope="row"><?php _e( ' Show bottom navigation', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_nav_below']))
						$options['show_nav_below'] = 'yes';
			
					$radio_setting = $options['show_nav_below'];
					if ( '' != $radio_setting ) {
						if ( $options['show_nav_below'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_posts[show_nav_below]" id="netfunktheme_options_posts[show_nav_below]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
            
         </table>

        </div>

        <h3 class="netfunk title">Blog Posts Content</h3>
        <div class="panel radius">
        
        <h3>Display post author meta content.</h3>
        
        <table class="form-table">
        
        	<tr>
              <td colspan="2">Including; <i>post date</i>, and <i>author name</i>.</td>
            </tr>
        
            <tr valign="top"><th scope="row"><?php _e( ' Show author meta', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_post_meta']))
						$options['show_post_meta'] = 'yes';
			
					$radio_setting = $options['show_post_meta'];
					if ( '' != $radio_setting ) {
						if ( $options['show_post_meta'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_posts[show_post_meta]" id="netfunktheme_options_posts[show_post_meta]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        
        <hr />

        <h3>Display the post meta </h3>
        
        <table class="form-table">
        
        	<tr>
              <td colspan="2">Including; <i>category name</i>, <i>tags</i>, <i>trackback url</i>, <i>permalink</i>, and <i>rss</i>.</td>
            </tr>
        
            <tr valign="top"><th scope="row"><?php _e( ' Show post meta', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_post_footer_meta']))
						$options['show_post_footer_meta'] = 'yes';
			
					$radio_setting = $options['show_post_footer_meta'];
					if ( '' != $radio_setting ) {
						if ( $options['show_post_footer_meta'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_posts[show_post_footer_meta]" id="netfunktheme_options_posts[show_post_footer_meta]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        
        <hr />

        <h3>Display The Post Thumbnail Image.</h3>
        
        <table class="form-table">
        
            <tr valign="top"><th scope="row"><?php _e( ' Show post thumbnail', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_post_thumbnail']))
						$options['show_post_thumbnail'] = 'yes';
			
					$radio_setting = $options['show_post_thumbnail'];
					if ( '' != $radio_setting ) {
						if ( $options['show_post_thumbnail'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_posts[show_post_thumbnail]" id="netfunktheme_options_posts[show_post_thumbnail]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        
        <hr />

        <h3>Display comments on blog post pages</h3>
        
        <table class="form-table">
            <tr valign="top"><th scope="row"><?php _e( ' Posts comments', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_post_comments']))
						$options['show_post_comments'] = 'yes';
			
					$radio_setting = $options['show_post_comments'];
					if ( '' != $radio_setting ) {
						if ( $options['show_post_comments'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_posts[show_post_comments]" id="netfunktheme_options_posts[show_post_comments]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        
        <hr />
        
        <h3>Display the author info area</h3>
        
        <table class="form-table">
        
            <tr valign="top"><th scope="row"><?php _e( 'About the author', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_post_author']))
						$options['show_post_author'] = 'yes';
			
					$radio_setting = $options['show_post_author'];
					if ( '' != $radio_setting ) {
						if ( $options['show_post_author'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_posts[show_post_author]" id="netfunktheme_options_posts[show_post_author]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        </div>

		<h3 class="netfunk title">Posts Bottom Content</h3>
        
        <div class="panel radius">
        <table class="form-table">
        
        	<tr>
              <td colspan="2">Display the Posts Bottom Content widget area. This is located below the output and comments section of posts pages.</td>
            </tr>
        
            <tr valign="top"><th scope="row"><?php _e( ' Posts bottom content', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_post_bottom_content']))
						$options['show_post_bottom_content'] = 'yes';
			
					$radio_setting = $options['show_post_bottom_content'];
					if ( '' != $radio_setting ) {
						if ( $options['show_post_bottom_content'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_posts[show_post_bottom_content]" id="netfunktheme_options_posts[show_post_bottom_content]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        </div>

        <h3 class="netfunk title">Sidebars On Posts</h3>
        <div class="panel radius">
        
          <h3>Display the sidebar widget area on posts pages</h3>
        
          <table class="form-table">
            
            <tr valign="top"><th scope="row"><?php _e( ' Show sidebars', 'netfunktheme' ); ?></th>
              <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_posts_sidebar']))
						$options['show_posts_sidebar'] = 'yes';
					
					$radio_setting = $options['show_posts_sidebar'];
					if ( '' != $radio_setting ) {
						if ( $options['show_posts_sidebar'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				?>
                 <label class="description"><input type="radio" name="netfunktheme_options_posts[show_posts_sidebar]" id="netfunktheme_options_posts[show_posts_sidebar]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp;
                <?php }  ?>
             </td>
          </tr>
        </table>

		<hr />
        
        <h3>Limit Sidebars On Posts</h3>
        
        <table class="form-table">
            <tr valign="top"><th scope="row"><?php _e( ' Show primary sidebar', 'netfunktheme' ); ?></th>
                <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_post_primary_sidebar']))
						$options['show_post_primary_sidebar'] = 'yes';
			
					$radio_setting = $options['show_post_primary_sidebar'];
					if ( '' != $radio_setting ) {
						if ( $options['show_post_primary_sidebar'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_posts[show_post_primary_sidebar]" id="netfunktheme_options_posts[show_post_primary_sidebar]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
          <tr valign="top"><th scope="row"><?php _e( ' Show secondary sidebar', 'netfunktheme' ); ?></th>
             <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $onoff_options as $option ) {
					if (!isset($options['show_post_secondary_sidebar']))
						$options['show_post_secondary_sidebar'] = 'yes';
			
					$radio_setting = $options['show_post_secondary_sidebar'];
					if ( '' != $radio_setting ) {
						if ( $options['show_post_secondary_sidebar'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				
				?>
                 
                <label class="description"><input type="radio" name="netfunktheme_options_posts[show_post_secondary_sidebar]" id="netfunktheme_options_posts[show_post_secondary_sidebar]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp; 
                 
               <?php }  ?>
             
            </td>
          </tr>
        </table>
        </div>

       <div class="panel radius">

            <h3>Save Theme Settings </h3>
            
            <br />
            
            <p>
                <input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'netfunktheme' ); ?>" />
            </p>
            
            <br />
        
        </div>
  
	</form>
</div>
<?php

} 

/* theme custom css options */
function theme_options_css() {
	global $select_options, $onoff_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
?>
	<div class="wrap netfunktheme-admin">
    	<h2>
        
        	<span class="dashicons dashicons-edit" data-code="f464" style="font-size: 30px"></span> &nbsp; 
			<?php echo wp_get_theme() . __( ' - Custom CSS & JavaScript', 'netfunktheme' ); ?>
        
        </h2>
        
        <br />
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
       		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'netfunktheme' ); ?></strong></p></div>
		<?php endif; ?>
		<form method="post" action="options.php">
		<?php settings_fields( 'netfunktheme-options-script' ); ?>
        <?php $options = get_option( 'netfunktheme_options_script' ); ?>
		<?php theme_nav() ?>
        <h3 class="netfunk title">Custom CSS</h3>
        <div class="panel radius">
        <span class="fa fa-pencil-square-o hide-for-small show-for-large-up" style="z-index: 1; color: #CCC; position: absolute; left: 100%; margin-left: -200px; font-size: 150px; "></span>
        <div class="large-8 medium-12 small-12">
			<p>Put your custom CSS markup here. Wordpress may already have native custom CSS fields but we give you one more for 'theme exclusive' modifications. </p>
        </div>
		<br />
        <table class="form-table">
           <tr valign="top">
            <th scope="row"><label class="description" for="netfunktheme_options_script[custom_css]"><?php _e( 'CSS Markup', 'netfunktheme' ); ?></label></th>
               <td>
                 <textarea id="netfunktheme_options_script[custom_css]" cols="80" rows="10" name="netfunktheme_options_script[custom_css]" placeholder="Put your custom CSS markup here"><?php echo (isset($options['custom_css']) ? esc_textarea( $options['custom_css']) : ''); ?></textarea>
              </td>
           </tr>
        </table>
		</div>
		<h3 class="netfunk title">Javascripts </h3>
        <div class="panel radius">
        <p>Custom Javascript markup goes here. The script will output at the page header. </p>
		<br />
         <table class="form-table">
            <tr valign="top">
            	<th scope="row"><label class="description" for="netfunktheme_options_script[javascript_top]"><?php _e( 'Javascript in Header', 'netfunktheme' ); ?></label></th>
                <td>
                    <textarea id="netfunktheme_options_script[javascript_top]" cols="80" rows="10" name="netfunktheme_options_script[javascript_top]" placeholder="Put your Javascript markup here"><?php echo (isset($options['javascript_top']) ? esc_textarea( $options['javascript_top']) : ''); ?></textarea>
                </td>
            </tr>
        </table>
        <br />
		<div class="large-8 medium-12 small-12">
        	<p>If you use Google Analytics, or would like to load any other Javascript, your code goes here. The script will output at the bottom of the page. </p>
		</div>
		<br />
         <table class="form-table">
            <tr valign="top">
            	<th scope="row"><label class="description" for="netfunktheme_options_script[javascript_bottom]"><?php _e( 'Javascript in Footer', 'netfunktheme' ); ?></label></th>
                <td>
                   <textarea id="netfunktheme_options_script[javascript_bottom]" cols="80" rows="10" name="netfunktheme_options_script[javascript_bottom]" placeholder="Put your Javascript markup here"><?php echo (isset($options['javascript_bottom']) ? esc_textarea( $options['javascript_bottom']) : ''); ?></textarea>
                </td>
            </tr>
        </table>
        </div>
        <div class="panel radius">

            <h3>Save Theme Settings </h3>
            
            <br />
            
            <p>
                <input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'netfunktheme' ); ?>" />
            </p>
            
            <br />
        
        </div>
	</form>
</div>
<?php
} 


/* Debuger ( move to end of a function to debug $options output )  */			
//echo '<h2>debug</h2>';
//echo '<pre>';
//print_r (get_option('netfunktheme_options_actions'));
//echo '</pre>';

// EOF