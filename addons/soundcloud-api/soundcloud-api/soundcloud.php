<?php
/*
Plugin Name: netfunkdesign.com Soundcloud
Plugin URI: http://netfunkdesign.com
Description: netfunkdesign.com Soundcloud.com Intigration.
Version: 1.0
Author: netfunkdesign.com
Author URI: http://netfunkdesign.com
License: pending.... 
*/

require 'Soundcloud/Soundcloud.php';

if (!class_exists('bc_soundcloud_integration')) {

class bc_soundcloud_integration {

	public $user_ID;
	private $token;

	function soundcloud_connection(){
		$soundcloud = new Services_Soundcloud('6ad4755963f3868e450d98da516942b7', '8414f1ffd99affd1ccd0dac37492dc4d', site_url('/?action=soundcloud-auth'));
		$soundcloud->setDevelopment(false);
		return $soundcloud; }

	function soundcloud_auth_link(){  global $soundcloud;
		$authorizeUrl = $soundcloud->getAuthorizeUrl();
		$bloginfo = get_bloginfo( 'name' );
		echo "Connect your Soundcloud.com user profile with ".$bloginfo.". Share and comments on your sounds right from your profile.";
		echo "<a href=\"".$authorizeUrl
		."&scope=non-expiring&display=popup\" style=\"padding: 0px; margin: 0px 0px 0px -5px; border: 0px;\"><img src=\"" 
		. get_template_directory_uri() 
		. "/addons/soundcloud-api/soundcloud-api/images/btn-connect-sc-s.png\" class=\"soundcloud_connect\" border=\"0\"/></a>"; }

	function soundcloud_auth_link_mini(){  global $soundcloud;
		$authorizeUrl = $soundcloud->getAuthorizeUrl();
		echo "<a href=\""
		.$authorizeUrl
		."&scope=non-expiring&display=popup\" style=\"float: right; padding: 0px; margin: 0px 20px 0px 0px; border: 0px;\"><img src=\"" 
		. get_template_directory_uri() 
		. "/addons/soundcloud-api/soundcloud-api/images/btn-connect-s.png\" class=\"soundcloud_connect\" border=\"0\"/></a>"; }

	function soundcloud_disconnect_link(){ 
		echo "<form name=\"soundcloud_disconnect_form\" id=\"soundcloud_disconnect_form\" action=\"\" method=\"post\">";
		echo "<input name=\"soundcloud_disconnect\" type=\"submit\" id=\"soundcloud_disconnect\" class=\"soundcloud_connect\" value=\"\" style=\"background: url(" 
		. get_template_directory_uri() 
		. "/addons/soundcloud-api/soundcloud-api/images/btn-disconnect-l.png) no-repeat top left; margin: -10px 0px 0px 20px; width: 140px; height: 29px; border: none;\">";
		echo "<input type=hidden name=action value=delete_token>";
		echo "</form>"; }

	function soundcloud_disconnect_link_mini(){ 
		echo '<a href="'
		.site_url('/?action=soundcloud')
		.'&action=delete_token" class="soundcloud_connect_mini" style="background: url('
		. get_template_directory_uri()
		.'/addons/soundcloud-api/soundcloud-api/images/btn-disconnect-s.png) no-repeat top left; float: right; margin: 0px 20px 0px 20px; width: 109px; height: 21px; border: none;"></a>';
		echo '<label style=\"float: right;\">[ <a href="'
		.site_url('/?action=soundcloud').'">settings</a> ]</label>'; }

		function my_plugin_install() {

			global $wpdb;
		
			$the_page_title = 'Soundcloud Settings';
			$the_page_name = 'soundcloud-settings';
		
			// the menu entry...
			delete_option("my_plugin_page_title");
			add_option("my_plugin_page_title", $the_page_title, '', 'yes');
			// the slug...
			delete_option("my_plugin_page_name");
			add_option("my_plugin_page_name", $the_page_name, '', 'yes');
			// the id...
			delete_option("my_plugin_page_id");
			add_option("my_plugin_page_id", '0', '', 'yes');
		
			$the_page = get_page_by_title( $the_page_title );
		
			if ( ! $the_page ) {
		
				// Create post object
				$_p = array();
				$_p['post_title'] = $the_page_title;
				$_p['post_content'] = "This text may be overridden by the plugin. You shouldn't edit it.";
				$_p['post_status'] = 'publish';
				$_p['post_type'] = 'page';
				$_p['comment_status'] = 'closed';
				$_p['ping_status'] = 'closed';
				$_p['post_category'] = array(1); // the default 'Uncatrgorised'
		
				// Insert the post into the database
				$the_page_id = wp_insert_post( $_p );
		
			}
			else {
				// the plugin may have been previously active and the page may just be trashed...
		
				$the_page_id = $the_page->ID;
		
				//make sure the page is not trashed...
				$the_page->post_status = 'publish';
				$the_page_id = wp_update_post( $the_page );
		
			}
		
			delete_option( 'my_plugin_page_id' );
			add_option( 'my_plugin_page_id', $the_page_id );
		
		}
		
		function my_plugin_remove() {
		
			global $wpdb;
		
			$the_page_title = get_option( "my_plugin_page_title" );
			$the_page_name = get_option( "my_plugin_page_name" );
		
			//  the id of our page...
			$the_page_id = get_option( 'my_plugin_page_id' );
			if( $the_page_id ) {
		
				wp_delete_post( $the_page_id ); // this will trash, not delete
		
			}
		
			delete_option("my_plugin_page_title");
			delete_option("my_plugin_page_name");
			delete_option("my_plugin_page_id");
		
		}
		
		
	} //endclass 
	
} //endif 


// EOF