<?php

/* 

Plugin Name: buddyPress Plugin Support
Plugin Description: buddyPress plugin support for NetfunkTheme. 
Plugin Version: 1.0 
Plugin Date: 12/03/13 
Plugin Author: NetfunkDesign
Plugin Author URL: http://www.netfunkdesign.com
Plugin URL: http://www.netfunkdesign.com

*/

/* netfunktheme options init */
function netfunktheme_buddypress_plugin_init(){
  if(class_exists('BuddyPress')){
    register_setting( 'netfunktheme-options-actions', 'netfunktheme_options_actions', 'netfunktheme_options_buddypress_validate' );
    $options = get_option('netfunktheme_options_actions');
    add_option( 'netfunktheme_options_actions', $options,'','yes');
  }
}
add_action( 'admin_init', 'netfunktheme_buddypress_plugin_init' );


/* netfunktheme buddypress plugin options menu */
function netfunktheme_buddypress_options_add_page() {
  if(class_exists('BuddyPress')) 
    add_submenu_page('theme_settings',__( ' buddyPress Support' ), __('- buddyPress'), 'edit_theme_options','theme_buddypress', 'theme_options_buddypress_page');
}
add_action( 'admin_menu', 'netfunktheme_buddypress_options_add_page' );


/* action pages */

/* netfunkthem action page hook  */ 
netfunktheme_action_page_init ('community', 'netfunktheme-buddypress', 'netfunktheme_buddypress_forum_frontpage');

/* netfunkthem action page title  */ 
$action_page_title = 'Community'; /* make plugin option */

/* buddypress index */
function netfunktheme_buddypress_forum_frontpage() { /* buddypress action page */
  /* display forum index */
  //echo do_shortcode('[bbp-forum-index]');
}


/* get nefunktheme buddyPress plugin options */
$netfunktheme_buddypress_options = get_option('netfunktheme_options_actions');

/* netfunktheme buddypress plugin on/off options */
$netfunktheme_buddypress_onoff_options = array(
  'yes' => array(
    'value' => 'yes',
    'label' => __( 'Yes', 'netfunktheme-buddypress' )),
  'no' => array(
    'value' => 'no',
    'label' => __( 'No', 'netfunktheme-buddypress' ))
);

/* netfunktheme on/off options */
$netfunktheme_buddypress_leftright_options = array(
  'left' => array(
    'value' => 'left',
    'label' => __( 'left', 'netfunktheme-buddypress' )),
  'right' => array(
    'value' => 'right',
    'label' => __( 'right', 'netfunktheme-buddypress' ))
);

/* netfunkthem buddyPress plugin options validation */
function netfunktheme_options_buddypress_validate( $input ) {

  global $netfunktheme_buddypress_onoff_options, $netfunktheme_buddypress_leftright_options;

   /* get the action page options array */
  $options = get_option('netfunktheme_options_actions');

   /* up the options array */
  $options['buddypress']['actionpage_slug'] = (isset($input['actionpage_slug']) ? $input['actionpage_slug'] : 'community');
  $options['buddypress']['show_actionpage_sidebar'] = (isset( $input['show_actionpage_sidebar']) ? $input['show_actionpage_sidebar'] : 'yes');
  $options['buddypress']['actionpage_sidebar_side'] = (isset( $input['actionpage_sidebar_side']) ? $input['actionpage_sidebar_side'] : 'left');

  return $options;

}

/* netfunkthemebuddypress options page */
function theme_options_buddypress_page() {

  global $netfunktheme_buddypress_onoff_options, $netfunktheme_buddypress_leftright_options;

  if (! isset( $_REQUEST['settings-updated']) )
    $_REQUEST['settings-updated'] = false;

?>
    <div class="wrap netfunktheme-admin">
      <h2>
        <span class="dashicons dashicons-dashboard" data-code="f226" style="font-size: 30px"></span> &nbsp; 
	    <?php echo wp_get_theme() . __( ' - buddyPress Settings', 'netfunktheme-buddypress' ); ?>
      </h2>
      <br />
      <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
       <div class="updated fade"><p><strong><?php _e( 'Options saved', 'netfunktheme-buddypress' ); ?></strong></p></div>
      <?php endif; ?>

      <form method="post" action="options.php">
        
		<?php settings_fields( 'netfunktheme-options-actions' ); ?>
        <?php $options = get_option( 'netfunktheme_options_actions' ); ?>
        
        <?php theme_nav() ?>
        
        <br />

        <div class="panel callout radius">
			<p>Customized ppPress plugin support options </p>
        </div>

        <h3 class="netfunk title">buddyPress Action Page Setup</h3>

        <div class="panel radius">

          <h3>Give your buddyPress action page a name or 'slug'</h3>

          <table class="form-table">
              <tr valign="top"><th scope="row"><?php _e( ' Actionpage Slug', 'netfunktheme-buddypress' ); ?></th>
               <td>
                 <input type="text" id="netfunktheme_options_actions[actionpage_slug]" name="netfunktheme_options_actions[actionpage_slug]" size="30" value="<?php echo (isset($options['buddypress']['actionpage_slug']) ? $options['buddypress']['actionpage_slug'] : 'community' ); ?>"> <label class="description" for="netfunktheme_options_actions[actionpage_slug]"><?php _e( 'The name of the action page ( /?action=whatever )', 'netfunktheme' ); ?></label>
                </td>
              </tr>
            </table> 
      </div>


        <h3 class="netfunk title">buddyPress Sidebars</h3>

        <div class="panel radius">

          <h3>Display the sidebar widget area on forum pages</h3>

          <table class="form-table">
            
            <tr valign="top"><th scope="row"><?php _e( ' Show sidebars', 'netfunktheme-buddypress' ); ?></th>
              <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $netfunktheme_buddypress_onoff_options as $option ) {
					$radio_setting = $options['buddypress']['show_actionpage_sidebar'];
					if ( '' != $radio_setting ) {
						if ( $options['buddypress']['show_actionpage_sidebar'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				?>
                 <label class="description"><input type="radio" name="netfunktheme_options_actions[show_actionpage_sidebar]" id="netfunktheme_options_actions[show_actionpage_sidebar]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp;
                <?php }  ?>
             </td>
          </tr>
          
          <tr valign="top"><th scope="row"><?php _e( ' Left Side / Right Side', 'netfunktheme-buddypress' ); ?></th>
              <td>
				<?php
				
				if ( ! isset( $checked ) )
					$checked = '';

				foreach ( $netfunktheme_buddypress_leftright_options as $option ) {
					
					$radio_setting = $options['buddypress']['actionpage_sidebar_side'];
					if ( '' != $radio_setting ) {
						if ( $options['buddypress']['actionpage_sidebar_side'] == $option['value'] ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = '';
						}
					}
				?>
                 <label class="description"><input type="radio" name="netfunktheme_options_actions[actionpage_sidebar_side]" id="netfunktheme_options_actions[actionpage_sidebar_side]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label> &nbsp;&nbsp;
                <?php }  ?>
             </td>
          </tr>
          
        </table>
      </div>

      <div class="panel radius">
        <h3>Save Theme Settings </h3>
        <br />
        <p>
          <input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'netfunktheme-buddypress' ); ?>" />
        </p>
        <br />
      </div>

    </form>
 
  </div>
<?php

}

// EOF