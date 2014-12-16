<?php

/* 

Plugin Name: Soundcloud Author Page Plugin 
Plugin Description: Soundcloud.com member integration plugin for Breakculture Theme. Add support to show soundcloud content on your wordpress author page. Including a user's sounds, playlists, followers, groups and more. This is a plugin for Breakscultre.com theme only. Not a normal Wordpress plugin. 
Plugin Version: 1.0 
Plugin Date: 12/03/13 
Plugin Author: Phil Sanders
Plugin Author URL: http://www.netfunkdesign.com/author/pillform 
Plugin URL: http://www.netfunkdesign.com

*/

if (class_exists('bc_soundcloud_integration')){

	/* member settings action page init */ 
	// theme_plugin_action_page_init ( $action, $class, $function); 

	/* soundcloud settings action page title */ 
	$action_page_title = 'Edit Your Settings';
	
	theme_plugin_action_page_init ('soundcloud', 'soundcloud', 'netfunktheme_soundcloud_settings_page');
	theme_plugin_action_page_init ('soundcloud-auth', 'soundcloud-auth', 'netfunktheme_soundcloud_auth_page');
	theme_plugin_action_page_init ('soundcloud-tracks', 'soundcloud-tracks', 'netfunktheme_soundcloud_tracks_page');
	theme_plugin_action_page_init ('soundcloud-followers', 'soundcloud-followers', 'netfunktheme_soundcloud_followers_page');
	theme_plugin_action_page_init ('soundcloud-groups', 'soundcloud-groups', 'netfunktheme_soundcloud_groups_page');
	theme_plugin_action_page_init ('soundcloud-playlists', 'soundcloud-playlists', 'netfunktheme_soundcloud_playlists_page');

	/* register netfunktheme soundcloud plugin css  */
	
	function netfunktheme_soundcloud_plugin_styles() {
		$myStyleFile = get_template_directory() . '/addons/soundcloud-api/soundcloud-api/style.css';
		if ( file_exists($myStyleFile) ) {
		$theme_url = get_template_directory_uri();
		wp_register_style('myStyleSheets', $theme_url .'/addons/soundcloud-api/soundcloud-api/style.css');
		wp_enqueue_style( 'myStyleSheets');}
	}
	
	add_action('wp_enqueue_scripts', 'netfunktheme_soundcloud_plugin_styles');

	//netfunktheme action page sidebar widgets array 

	function soundcloud_widget_menu(){ 
			
		global $current_user, $soundcloud;
		get_currentuserinfo();
		
		if (get_user_meta($current_user->ID,'soundcloud_token')){
			$soundcloud_menu = '<ul>';
			$soundcloud_menu .= '<li><a href="'.site_url('/?action=soundcloud-tracks').'">My Tracks</a></li>';
			$soundcloud_menu .= '<li><a href="'.site_url('/?action=soundcloud-playlists').'">My Playlists</a></li>';
			$soundcloud_menu .= '<li><a href="'.site_url('/?action=soundcloud-followers').'">My Followers</a></li>';
			$soundcloud_menu .= '<li><a href="'.site_url('/?action=soundcloud-groups').'">My Groups</a></li>';
			$soundcloud_menu .= '<li><a href="'.site_url('/?action=soundcloud').'">Settings</a></li>';
			$soundcloud_menu .= '</ul>';
			return $soundcloud_menu;
			
		} else {
			$authorizeUrl = $soundcloud->getAuthorizeUrl();
			$bloginfo = get_bloginfo( 'name' );
			//echo "Connect your Soundcloud.com user profile with ".$bloginfo.". Share and comments on your sounds right from your profile.";
			//echo "<a href=\"".$authorizeUrl."&scope=non-expiring&display=popup\" style=\"padding: 0px; margin: 0px 0px 0px -5px; border: 0px;\"><img src=\"" . get_template_directory_uri() . "/addons/soundcloud-api/soundcloud-api/images/btn-connect-sc-s.png\" class=\"soundcloud_connect\" border=\"0\"/></a>";
		}
	}

	$plugin_widget_sidebar = array(
	'Soundcloud-Settings-Menu' => array(
	'widget_id' => 'soundcloud-connect-widget',
	'widget_class' => 'soundcloud_menu_widget',
	'widget_title' => '<span class="webicon soundcloud small"></span>Soundcloud Intigration',
	'widget_content' => soundcloud_widget_menu() ));

if (!function_exists( 'netfunktheme_soundcloud_options_validate')){

	function netfunktheme_soundcloud_options_validate() {

		/* Get user info. */
		global $current_user, $wp_roles;
		get_currentuserinfo();
		
		// delete token / close connection to api

		if (isset($_POST['action'])){

			if ($_POST['action'] == "delete_token" or $_REQUEST['action'] == "delete_token"){
			delete_user_meta($current_user->ID, "soundcloud_play_first");
			delete_user_meta($current_user->ID, "soundcloud_show_artwork");
			delete_user_meta($current_user->ID, "soundcloud_show_comments");
			delete_user_meta($current_user->ID, "soundcloud_token");
			delete_user_meta($current_user->ID, "soundcloud_refresh");
			header ("location: /edit-member"); }
			
			// save settings
			if ($_POST['action'] == "save_soundcloud_meta"){
			update_user_meta($current_user->ID, "soundcloud_default_image", $_POST['soundcloud_default_image']);
			update_user_meta($current_user->ID, "soundcloud_show_sounds", $_POST['soundcloud_show_sounds']);
			update_user_meta($current_user->ID, "soundcloud_show_followers", $_POST['soundcloud_show_followers']);
			update_user_meta($current_user->ID, "soundcloud_show_playlists", $_POST['soundcloud_show_playlists']);
			update_user_meta($current_user->ID, "soundcloud_show_groups", $_POST['soundcloud_show_groups']);
			update_user_meta($current_user->ID, "soundcloud_html5", $_POST['soundcloud_html5']);
			update_user_meta($current_user->ID, "soundcloud_play_first", $_POST['soundcloud_play_first']);
			update_user_meta($current_user->ID, "soundcloud_show_artwork", $_POST['soundcloud_show_artwork']);
			update_user_meta($current_user->ID, "soundcloud_show_comments", $_POST['soundcloud_show_comments']);
			$sc_update_settings = true;  }
		}
	}
	
	add_action( 'init', 'netfunktheme_soundcloud_options_validate' );

}

/* netfunktheme edit profile page */

function netfunktheme_soundcloud_auth_page() {

	/* Get user info. */
	global $soundcloud, $current_user, $wp_roles;
	get_currentuserinfo();

	if ( !is_user_logged_in() ) : ?>
		<p class="warning"><?php _e('You must be logged in to be here!', 'frontendprofile'); ?></p>
		<p><a href="/forum/ucp.php?mode=login">login here</a></p>
<?php 

	else : 
		
		if ( isset($_GET['error'])) 
			echo '<p class="error">' . $_GET['error'] . '</p>'; 
		
		// if no Soundcloud Token in User Meta
		if (isset($_GET['code']) and !get_user_meta($current_user->ID,'soundcloud_token')){
	
			try {
				$accessToken = $soundcloud->accessToken($_GET['code']);
				// Add Soundcloud Accesss Token to User Meta Data
				add_user_meta($current_user->ID, "soundcloud_token", $accessToken['access_token'], true);		// soundcloud api token
				add_user_meta($current_user->ID, "soundcloud_refresh", $accessToken['refresh_token'], true);	// soundcloud api refresh token (cached)
				// initial user settings setup
				add_user_meta($current_user->ID, "soundcloud_default_image", "", true);							// use soundcloud image as default
				add_user_meta($current_user->ID, "soundcloud_html5", "true", true);								// use new HTML5 player
				add_user_meta($current_user->ID, "soundcloud_play_first", "", true);							// play first song on page
				add_user_meta($current_user->ID, "soundcloud_show_artwork", "true", true);						// show art work in player (html5 only)
				add_user_meta($current_user->ID, "soundcloud_show_comments", "true", true);						// show comments in player 
				// initial audio track settings setup
				add_user_meta($current_user->ID, "soundcloud_my_filter", "", true);								// filter tracks to not be displayed (?)
				add_user_meta($current_user->ID, "soundcloud_my_playlists", "", true);							// user playlist names / ids
				add_user_meta($current_user->ID, "soundcloud_my_playlist_meta", "", true);						// user playlist meta data
			} catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
				exit($e->getMessage());
			}
		}
		
		$soundcloud->setAccessToken(get_user_meta($current_user->ID,'soundcloud_token',true));
	
		/* Display Some Data From SoundCloud */
		
		# name 							# description 							# example value
		// id 							integer ID 								123
		// permalink 					permalink of the resource 				"summer-of-69"
		// username 					username 								"Doctor Wilson"
		// uri 							API resource URL 						http://api.soundcloud.com/comments/32562
		// permalink_url 				URL to the SoundCloud.com page 	"		http://soundcloud.com/bryan/summer-of-69"
		// avatar_url 					URL to a JPEG image 					"http://i1.sndcdn.com/avatars-000011353294-n0axp1-large.jpg"
		// country 						country 								"Germany"
		// full_name 					first and last name 					"Tom Wilson"
		// city 						city 									"Berlin"
		// description 					description 							"Another brick in the wall"
		// discogs-name 				Discogs name 							"myrandomband"
		// myspace-name 				MySpace name 							"myrandomband"
		// website 						a URL to the website 					"http://facebook.com/myrandomband"
		// website-title 				a custom title for the website 			"myrandomband on Facebook"
		// online 						online status (boolean) 				true
		// track_count 					number of public tracks 				4
		// playlist_count 				number of public playlists 				5
		// followers_count 				number of followers 					54
		// followings_count 			number of followed users 				75
		// public_favorites_count 		number of favorited public tracks 		7
		// avatar_data 					binary data of user avatar 				(only for uploading)
		// plan 						subscription plan of the user 			Pro Plus
		// private_tracks_count 		number of private tracks 				34
		// private_playlists_count 		number of private playlists 			6
		// primary_email_confirmed 		boolean if email is confirmed 			true
		
		$me = json_decode($soundcloud->get('me'), true);
		$bloginfo = get_bloginfo( 'name' );
		//$my_music = json_decode($soundcloud->get('tracks',array('user_id' => $me['id'])), true);			/* not using this */
		echo '<h4>Authentication Successful</h4>';
		echo '<p><img src="'.get_template_directory_uri().'/addons/soundcloud-api/soundcloud-api/images/soundcloud-icon.png" style="float: right; margin: -50px 50px 10px 10px;"></p>';
		echo '<p>You are now fully connected between your soundcloud.com account and ' . $bloginfo . '.</p> ';
		echo '<p>';
		echo '<strong>Account Name:</strong> ' . $me [ 'username' ] . '<br /><br />';
		//echo '<strong>Email Address:</strong> " . $me [ 'email' ] . "<br /><br />';
		echo '<strong>Soundcloud URL:</strong> <a href="' . $me [ 'permalink_url' ] . '" target="_blank">' . $me [ 'permalink_url' ] . '</a><br />';
		echo '</p>';
		echo '<hr />';
		echo '<h4>Soundcloud Integration Features & Settings:</h4> ';
		echo '<br />';
		echo '<div class="large-6 small-12 columns left">';
		echo '<div class="push-2">';
		echo soundcloud_widget_menu();
		echo '</div>';
		echo '</div>';
		echo '<div class="large-6 small-12 columns right text-right">';
		echo '<div>Did you connect here by mistake?</div>';
		do_action('soundcloud_disconnect_link');
		echo "</div>";
		echo '<br class="clear" \>';
		echo'<hr />';
		echo '<div class="text-center"><strong><a href="'.site_url('/?action=edit-member').'">Return to your account settings</a></strong></div>';
	endif;
} 

/* netfunktheme soundcloud settings page */

function netfunktheme_soundcloud_settings_page() {

	/* Get user info. */
	global $soundcloud, $current_user, $wp_roles;
	get_currentuserinfo();

	if ( !is_user_logged_in() ) : ?>
		<p class="warning"><?php _e('You must be logged in to be here!', 'frontendprofile'); ?></p>
		<p><a href="/forum/ucp.php?mode=login">login here</a></p>
<?php 
     else : 
		
		if ( isset($error) and $error != "" ) 
			echo '<p class="error">' . $error . '</p>'; 
        
        if (class_exists('bc_soundcloud_integration')) :

        try {
		   $soundcloud->setAccessToken(get_user_meta($current_user->ID,'soundcloud_token',true));
		   $me = json_decode($soundcloud->get('me'), true);

			// show update notice
			echo ($sc_update_settings == true ? '<div class="small-12 columns text-center"><div class="panel radius success">Settings Updated!</div></div><br class="clear"/><br />' : '');
			// soundcloud authentication icon
			echo '<div class="small-12 columns">';
			echo '<div class="large-6 small-12 columns left">';
			echo '<h5 class="entry-title">Soundcloud API Authorization:</h5>';
			do_action('soundcloud_disconnect_link');
			echo '</div>';
			echo '<div class="large-6 small-12 columns right">'
			. '<div class="panel radius notice">'
			. '<strong style="display:block; margin-bottom: 8px;">Notice:</strong>Discconnecting will remove your saved settings. This will not remove soundcloud players you posted in the blog or forum.'
			. '</div>'
			. '</div>';
			echo '<br class="clear" />';
			echo '<hr />';
			// settings form
			echo '<form class="custom" name="form_soundcloud_settings" id="form_soundcloud_settings" action="" method="POST">';
			echo '<div class="large-6 small-12 columns left">';
			echo '<div class="large-3 small-12 columns left">';
			echo '<img src="'. $me['avatar_url'] .'">';
			echo '</div>';
			echo '<div class="large-9 small-12 columns right">';
			echo '<br />';
			echo '<h5>'. $me['username'] .' Profile Settings:</h5>';
			echo '<br />';
			// soundcloud default image
			echo '<label><input type="checkbox" name="soundcloud_default_image" id="soundcloud_default_image" value="true"' . (get_user_meta($current_user->ID,'soundcloud_default_image',true) == "true" ? ' checked' : '') . '/> &nbsp; Use my soundcloud default image.</label>';
			echo '<br />';
			// show my sounds on my author page 
			echo '<label><input type="checkbox" name="soundcloud_show_sounds" id="soundcloud_show_sounds" value="true"' . (get_user_meta($current_user->ID,'soundcloud_show_sounds',true) == "true" ? ' checked' : '') . '/> &nbsp; Show sounds on my author page [<a href="'.site_url('/?action=soundcloud-tracks').'"> edit </a>]</label>';
			echo '<br />';
			// show my followers on my author page 
			echo '<label><input type="checkbox" name="soundcloud_show_followers" id="soundcloud_show_followers" value="true"' . (get_user_meta($current_user->ID,'soundcloud_show_followers',true) == "true" ? ' checked' : '') . '/> &nbsp; Show followers on my author page [<a href="'.site_url('/?action=soundcloud-followers').'"> edit </a>]</label>';
			echo '<br />';
			// show my playlists on my author page 
			echo '<label><input type="checkbox" name="soundcloud_show_playlists" id="soundcloud_show_playlists" value="true"' . (get_user_meta($current_user->ID,'soundcloud_show_playlists',true) == "true" ? ' checked' : '') . '/> &nbsp; Show playlists on my author page [<a href="'.site_url('/?action=soundcloud-playlists').'"> edit </a>]</label>';
			echo '<br />';
			// show my groups on my author page 
			echo '<label><input type="checkbox" name="soundcloud_show_groups" id="soundcloud_show_groups" value="true"' . (get_user_meta($current_user->ID,'soundcloud_show_groups',true) == "true" ? ' checked' : '') . '/> &nbsp; Show user groups on my author page [<a href="'.site_url('/?action=soundcloud-groups').'"> edit </a>]</label>';
			echo '</div>';
			echo '</div>';
			echo '<div class="large-6 small-12 columns right">';
			echo '<div class="panel radius">';
			echo '<h5>Player Settings:</h5>';
			echo '<br />';
			echo '<label><input type="checkbox" name="soundcloud_html5" id="soundcloud_html5" value="true"' . (get_user_meta($current_user->ID,'soundcloud_html5',true) == "true" ? " checked" : "") . '/> &nbsp; Use the HTML5 player (recommended).</label><br />';
			echo '<label><input type="checkbox" name="soundcloud_play_first" id="soundcloud_play_first" value="true"' . (get_user_meta($current_user->ID,'soundcloud_play_first',true) == "true" ? " checked" : "") . '/> &nbsp; Play first track on page load.</label><br />';
			echo '<label><input type="checkbox" name="soundcloud_show_artwork" id="soundcloud_show_artwork" value="true"' . (get_user_meta($current_user->ID,'soundcloud_show_artwork',true) == "true" ? " checked" : "") . '/> &nbsp; Show Artwork (HTML5 only).</label><br />';
			echo '<label><input type="checkbox" name="soundcloud_show_comments" id="soundcloud_show_comments" value="true"' . (get_user_meta($current_user->ID,'soundcloud_show_comments',true) == "true" ? " checked" : "") . '/> &nbsp; Show Comments.</label><br /><br />';
			echo '<input type="hidden" name="action" value="save_soundcloud_meta">';
			echo '</div>';
			echo '</div>';
			echo '<br class="clear" />';
			echo '<hr />';
			echo '<h5>Save Settings</h5>';
			echo '<br />';
			echo '<div class="small-12 columns text-center">';
			echo '<input type="submit" name="sc_save_settings" id="sc_save_settings" value="save settings" class="button radius">';
			echo '</div>';
			echo '</form>';
			echo '</div>';
			echo '<br class="clear" />';
		} catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
			//echo $current_user->ID;
			exit($e->getMessage());
		}
        endif;
	endif; 
} 

/* netfunktheme soundcloud sounds page */

function netfunktheme_soundcloud_tracks_page() {

	/* Get user info. */
	global $soundcloud, $current_user, $wp_roles;
	get_currentuserinfo();

	if ( !is_user_logged_in() ) : ?>
		<p class="warning"><?php _e('You must be logged in to be here!', 'frontendprofile'); ?></p><!-- .warning -->
		<p><a href="/forum/ucp.php?mode=login">login here</a></p>
<?php 
    else: 
		if (isset($error)) 
		echo '<p class="error">' . $error . '</p>';
		// display the users soundcloud tracks
		netfunktheme_soundcloud_my_tracks($current_user->ID);
	endif; 
	
} 

/* netfunktheme soundcloud edit my sounds */
	
if (!function_exists('netfunktheme_soundcloud_my_tracks')){
	
  function netfunktheme_soundcloud_my_tracks() {
	global $soundcloud, $current_user;
	// save settings on post
	if (isset($_POST['action'])){
	if ($_POST['action'] == 'netfunktheme_save_soundcloud_options'){
	update_user_meta($current_user->ID, 'soundcloud_soundstoshow', $_POST['soundcloud_soundstoshow']);
	$sc_update_settings = true; }}
	
	if (class_exists('bc_soundcloud_integration')){

		if (get_user_meta($current_user->ID,'soundcloud_token',true)){
			$soundcloud->setAccessToken(get_user_meta($current_user->ID,'soundcloud_token',true));
			$me = json_decode($soundcloud->get('me'), true);
			$my_music = json_decode($soundcloud->get('tracks',array('user_id' => $me['id'])), true);
			echo ($sc_update_settings == true ? '<div class="small-12 columns text-center"><div class="panel radius success">Settings Updated!</div></div><br class="clear"/><br />' : '');
			// show soundcloud groups
?>
			<div class="small-12 sound_cloud_content">
			<h4>My Soundcloud Sounds</h4>
			<hr />
<?php
			if (!empty($my_music)){
				echo '<form class="custom" name="form_soundcloud_settings" id="form_soundcloud_settings" method="POST" action="">';
				$options = get_user_meta($current_user->ID,'soundcloud_soundstoshow',true); 
				$sc_auto_play = (get_user_meta($current_user->ID,'soundcloud_play_first',true) == "true" ? true : false);
				foreach ($my_music as &$value) {
					echo '<div class="panel'.($options[$value['permalink']] == "1" ? ' alt' : '').' radius">';
					echo '<div class="large-6 small-12 left">';
					echo '<h6>'.$value['title'].'</h6>';
					echo '</div>';
					echo '<div class="large-6 small-12 text-right right">';
					echo '<strong>Show on author page</strong> &nbsp; &nbsp; <input type="radio" name="soundcloud_soundstoshow['.$value['permalink'].']" id="soundcloud_soundstoshow['.$value['permalink'].']" value="1"' . ($options[$value['permalink']] == "1" ? ' checked' : '') . '/> Yes &nbsp; <input type="radio" name="soundcloud_soundstoshow['.$value['permalink'].']" id="soundcloud_soundstoshow['.$value['permalink'].']" value="0"' . ($options[$value['permalink']] == "1" ? '' : ' checked') . '/> No ';
					echo '</div>';
					echo '<hr />';
					echo '<div class="small-12 ">';
					echo soundcloud_shortcode(
					array('url' => $value['uri'],
					  'iframe' => ''.(get_user_meta($current_user->ID,'soundcloud_html5',true) == "true" ? "true" : "false").'',
					  'params' => 'auto_play='.($sc_auto_play != false ? "true" : "false").'&amp;show_user=true&amp;show_artwork='
						.(get_user_meta($current_user->ID,'soundcloud_show_artwork',true) == "true" ? "true" : "false")
						.'&amp;show_comments='
						.(get_user_meta($current_user->ID,'soundcloud_show_comments',true) == "true" ? "true" : "false").'&amp;color=283636&amp;theme_color=272b2c',
					  'height' => '',
					  'width'  => ''
					));
					$sc_auto_play = false;
					echo '</div>';
					echo '<br class="clear"/>';
					echo '</div>';
				} // endforeach
				echo '<hr />';
				echo '<h5>Save Settings</h5>';
				echo '<br />';
				echo '<div class="small-12 columns text-center">';
				echo '<input type="hidden" name="action" value="netfunktheme_save_soundcloud_options">';
				echo '<input type="submit" class="button radius button-primary" value="Save Options" />';
				echo '</div>';
				echo '</form>';	
			} else {
				echo '<p>No sounds yet.</p>';
			}
?>		
			</div>
<?php
		}
	} else {
	echo 'Sounddcloud API Required'; }
	
	/* Debug  */	
	//echo '<pre>';
	//echo '<h6>debug</h6>';
	//print_r ($options);
	//echo '</pre>';
	//echo get_user_meta($current_user->ID,'soundcloud_soundstoshow['.$value['permalink'].']',true);
	}		
}

/* netfunktheme soundcloud groups page */

	function netfunktheme_soundcloud_groups_page() {
		/* Get user info. */
		global $soundcloud, $current_user, $wp_roles;
		get_currentuserinfo();
		if ( !is_user_logged_in() ) : ?>
			
			<p class="warning">
			
				<?php _e('You must be logged in to be here!', 'frontendprofile'); ?>
			
			</p><!-- .warning -->
			
			<p><a href="/forum/ucp.php?mode=login">login here</a></p>
	
		<?php 
			
			else : if ( $error ) echo '<p class="error">' . $error . '</p>'; 
			
			// display the users soundcloud tracks
			netfunktheme_soundcloud_my_groups($current_user->ID);
	
			?>
	
	
		<?php endif; ?>	
	
	
	<?php } 
	
	
	
	/* netfunktheme soundcloud edit my groups */
	
	if (!function_exists('netfunktheme_soundcloud_my_groups')){
	
		function netfunktheme_soundcloud_my_groups() {
	
			global $soundcloud, $current_user;
	
			// save settings on post
	
			if ($_POST['action'] == "netfunktheme_save_soundcloud_options"){
				
				update_user_meta($current_user->ID, "soundcloud_groupstoshow", $_POST['soundcloud_groupstoshow']);
				
				$sc_update_settings = true; 
			
			}
	
			if (class_exists('bc_soundcloud_integration')){
		
				if (get_user_meta($current_user->ID,'soundcloud_token',true)){
		
					$soundcloud->setAccessToken(get_user_meta($current_user->ID,'soundcloud_token',true));
					
					$me = json_decode($soundcloud->get('me'), true);
					
					$my_groups = json_decode($soundcloud->get('groups',array('user_id' => $me['id'])), true);
					
					echo ($sc_update_settings == true ? '<div class="small-12 columns text-center"><div class="panel radius success">Settings Updated!</div></div><br class="clear"/><br />' : '');
					
					// show soundcloud groups
					
					?>
	
					<div class="small-12 sound_cloud_content">
					
					<h4>My Soundcloud Groups</h4>
					
					<hr />
		
					<?php
						
					if (!empty($my_groups)){
		
		
						echo '<form class="custom" name="form_soundcloud_settings" id="form_soundcloud_settings" method="POST" action="">';
		 
			 
						$options = get_user_meta($current_user->ID,'soundcloud_groupstoshow',true); 
	
						echo '<div class="panel radius">';
	
	
	
						echo '<div class="small-12 columns text-right">';
							
							echo '<strong>Show on my author page</strong>';
		
	
						
						echo '</div>';
						
						echo '<br />';
						
						echo '<br />';
	
						echo '<ul>';
		
							foreach ($my_groups as &$value) :
		
								echo '<li'.($options[$value['permalink']] == "1" ? ' class="" style="background: #242628;"' : '').'>';
		
								echo '<br />';
		
								echo '<div class="small-9 columns left">';
		
								echo '<h6><a href="' 
								. $value['permalink_url'] . '" target="_blank"><strong>' 
								. $value['name'] . '</strong></a> </h6>'
								. $value['short_description'] . '&nbsp;-&nbsp;'
								. '<a href="'.$value['creator']['permalink_url'].'" target="_blank">' . $value['creator']['username'] . '</a><br /><br />';
								
								echo '</div>';
								
								// edit options 
			
								echo '<div class="small-2 columns right">';
			
								echo '<br />';
		
								//$value['permalink'];
								
								echo '<span'.($options[$value['permalink']] != "1" ? ' class="" style="color: #555;"' : '').'>';
								
								echo '<input type="radio" name="soundcloud_groupstoshow['.$value['permalink'].']" id="soundcloud_groupstoshow['.$value['permalink'].']" value="1"' . ($options[$value['permalink']] == "1" ? ' checked' : '') . '/> Yes &nbsp; <input type="radio" name="soundcloud_groupstoshow['.$value['permalink'].']" id="soundcloud_groupstoshow['.$value['permalink'].']" value="0"' . ($options[$value['permalink']] == "1" ? '' : ' checked') . '/> No ';
		
								echo '</span>';
		
								echo '</div>';
								
								echo '<br class="clear" />';
								
								echo '</li>';
			
							endforeach;
						
						echo '</ul>';
						
						
	
						echo '</div>';
		
						echo '<h5>Save Settings</h5>';
						
						echo '<br />';
		
						echo '<div class="small-12 columns text-center">';
						
						 echo '<input type="hidden" name="action" value="netfunktheme_save_soundcloud_options">';
						
						echo '<input type="submit" class="button radius button-primary" value="Save Options" />';
		
						echo '</div>';
		
						echo '</form>';
						
					} else {
					
						echo '<p>No groups yet.</p>';
						
					}
					
					?> </div> <?php
					
					/* Debug  */
					
					//echo '<pre>';
					//echo '<h6>debug</h6>';
					//print_r ($options);
					//echo '</pre>';
					//echo get_user_meta($current_user->ID,'soundcloud_groupstoshow['.$value['permalink'].']',true);
					
				}
				
			}
		}
	}
	
	
	
	/* netfunktheme soundcloud playlists page */

	function netfunktheme_soundcloud_playlists_page() {
	
		/* Get user info. */
		global $soundcloud, $current_user, $wp_roles;
		get_currentuserinfo();
	
		if ( !is_user_logged_in() ) : ?>
			
			<p class="warning">
			
				<?php _e('You must be logged in to be here!', 'frontendprofile'); ?>
			
			</p><!-- .warning -->
			
			<p><a href="/forum/ucp.php?mode=login">login here</a></p>
	
		<?php 
			
			else : if ( isset($error) and $error != '' ) echo '<p class="error">' . $error . '</p>'; 
			
			// display the users soundcloud tracks
			netfunktheme_soundcloud_my_playlists($current_user->ID);
	
			?>
	
	
		<?php endif; ?>	
	
	
	<?php } 
	
	
	/* netfunktheme soundcloud edit my playlists */
	
	if (!function_exists('netfunktheme_soundcloud_my_playlists')){
	
		function netfunktheme_soundcloud_my_playlists() {
	
			global $soundcloud, $current_user;
	
			// save settings on post
	
			if (isset($_POST['action'])){
	
				if ($_POST['action'] == "netfunktheme_save_soundcloud_options"){
					
					update_user_meta($current_user->ID, "soundcloud_liststoshow", $_POST['soundcloud_liststoshow']);
					
					$sc_update_settings = true; 
				
				}
			
			}
	
			if (class_exists('bc_soundcloud_integration')){
		
				if (get_user_meta($current_user->ID,'soundcloud_token',true)){
		
					$soundcloud->setAccessToken(get_user_meta($current_user->ID,'soundcloud_token',true));
					
					$me = json_decode($soundcloud->get('me'), true);
					
					$my_playlists = json_decode($soundcloud->get('playlists',array('user_id' => $me['id'])), true);
					
					echo ($sc_update_settings == true ? '<div class="small-12 columns text-center"><div class="panel radius success">Settings Updated!</div></div><br class="clear"/><br />' : '');
					
					// show soundcloud groups
					
					?>
	
					<div class="small-12 sound_cloud_content">
					
					<br />
					
					<br />
					
					<h4>My Soundcloud Groups</h4>
					
					<hr />
		
					<?php
						
					if (!empty($my_playlists)){
		
		
						echo '<form class="custom" name="form_soundcloud_settings" id="form_soundcloud_settings" method="POST" action="">';
		 
			 
						$options = get_user_meta($current_user->ID,'soundcloud_liststoshow',true); 
	
						echo '<div class="panel radius">';
	
						echo '<div class="small-12 columns text-right">';
							
							echo '<strong>Show on my author page</strong>';
						
						echo '</div>';
	
						echo '<ul>';
							
						echo '<li>';
	
						foreach ($my_playlists as &$value) {
				
							echo '<div class="small-9 columns left">';
				
							echo '<h6 class="paneltitle"><a href="' . $value['permalink_url'] . '" target="_blank">' . $value['title'] . '</a></h6> ';
	
							$n = 1;
	
							foreach ($value['tracks'] as &$track){
	
								echo $n . ' - ' . $track['title'] . ' - <a href="'.$track['permalink_url'].'" target="_blank">' . $track['user']['username'] . '</a><br />';
	
								$n++;
							}
	
							echo '<br />';
	
							echo '</div>';
							
							echo '<br />';
							
							echo '<br />';
							
							// options
							
							echo '<div class="small-3 columns text-center right">';
							
								echo '<span'.($options[$value['permalink']] != "1" ? ' class="" style="color: #555;"' : '').'>';
							
								echo '<input type="radio" name="soundcloud_liststoshow['.$value['permalink'].']" id="soundcloud_liststoshow['.$value['permalink'].']" value="1"' . ($options[$value['permalink']] == "1" ? ' checked' : '') . '/> Yes &nbsp; <input type="radio" name="soundcloud_liststoshow['.$value['permalink'].']" id="soundcloud_liststoshow['.$value['permalink'].']" value="0"' . ($options[$value['permalink']] == "1" ? '' : ' checked') . '/> No ';
		
								echo '</span>';
	
							echo '</div>';
						
						}
						
						echo '<br class="clear"/>';
						
						echo '</li>';
							
						echo '</ul>';
	
						echo '<br class="clear"/>';
	
						echo '</div>';
		
						echo '<hr />';
		
						echo '<h5>Save Settings</h5>';
						
						echo '<br />';
		
						echo '<div class="small-12 columns text-center">';
						
						 echo '<input type="hidden" name="action" value="netfunktheme_save_soundcloud_options">';
						
						echo '<input type="submit" class="button radius button-primary" value="Save Options" />';
		
						echo '</div>';
		
						echo '</form>';
						
					} else {
					
						echo '<p>No groups yet.</p>';
						
					}
					
					?> </div> <?php
					
					/* Debug  */
					
					//echo '<pre>';
					//echo '<h6>debug</h6>';
					//print_r ($options);
					//echo '</pre>';
					//echo get_user_meta($current_user->ID,'soundcloud_liststoshow['.$value['permalink'].']',true);
					
				}
				
			}
		}
	}
	
	
	
	/* netfunktheme soundcloud followers page */

	function netfunktheme_soundcloud_followers_page() {
	
		/* Get user info. */
		global $soundcloud, $current_user, $wp_roles;
		get_currentuserinfo();
	
		if ( !is_user_logged_in() ) : ?>
			
			<p class="warning">
			
				<?php _e('You must be logged in to be here!', 'frontendprofile'); ?>
			
			</p><!-- .warning -->
			
			<p><a href="/forum/ucp.php?mode=login">login here</a></p>
	
		<?php 
			
			else : if ( isset($error) and $error != '') echo '<p class="error">' . $error . '</p>'; 
			
			// display the users soundcloud tracks
			netfunktheme_soundcloud_my_followers($current_user->ID);
	
			?>
	
	
		<?php endif; ?>	
	
	
	<?php } 
	
	
	
	/* netfunktheme soundcloud edit my followers */
	
	add_action('theme_author_space','netfunktheme_soundcloud_my_followers');
	
	if (!function_exists('netfunktheme_soundcloud_my_followers')){
	
		function netfunktheme_soundcloud_my_followers() {
	
			global $soundcloud, $current_user;
	
			// save settings on post
	
			if (isset($_POST['action'])){
			
				if ($_POST['action'] == "netfunktheme_save_soundcloud_options"){
					
					update_user_meta($current_user->ID, "soundcloud_show_followers", $_POST['soundcloud_show_followers']);
					
					$sc_update_settings = true; 
				
				}
			
			}
	
			if (class_exists('bc_soundcloud_integration')){
	
				if (get_user_meta($current_user->ID,'soundcloud_token',true)){
	
					$soundcloud->setAccessToken(get_user_meta($current_user->ID,'soundcloud_token',true));
					$me = json_decode($soundcloud->get('me'), true);
					
					$my_followers = json_decode($soundcloud->get('me/followers',array('user_id' => $me['id'],'limit' => '48')), true);
					
					$total_followers =  $me['followers_count'];
					
					
					echo ($sc_update_settings == true ? '<div class="small-12 columns text-center"><div class="panel radius success">Settings Updated!</div></div><br class="clear"/><br />' : '');
					
					// show soundcloud groups
					
					?>
	
					<div class="small-12 sound_cloud_content">
					
					<br />
					
					<br />
					
					<h4>My Soundcloud Followers</h4>
					
					<hr />
		
					<?php
					
						
					if (!empty($my_followers)){
		
		
						echo '<form class="custom" name="form_soundcloud_settings" id="form_soundcloud_settings" method="POST" action="">';
	
						$option = get_user_meta($current_user->ID,'soundcloud_show_followers',true); 
	
						$display_followers = count($my_followers);
	
						echo '<div class="panel radius">';
	
						echo '<div class="small-6 columns text-left">';
							
							echo '<strong>Total Followers:</strong> ('.$total_followers .') &nbsp; - <a href="'.$me['permalink_url'].'/followers" target="_blank">view all</a>';
						
						echo '</div>';
						
						
						// option
						
						echo '<div class="small-6 columns text-right">';
							
						echo '<strong>Show on my author page:</strong> &nbsp; <input type="radio" name="soundcloud_show_followers" id="soundcloud_show_followers" value="true"' . (get_user_meta($current_user->ID,'soundcloud_show_followers',true) == "true" ? ' checked' : '') . '/> Yes &nbsp; <input type="radio" name="soundcloud_show_followers" id="soundcloud_show_followers" value=""' . (get_user_meta($current_user->ID,'soundcloud_show_followers',true) != "true" ? ' checked' : '') . '/> No ';
	
						echo '</div>';
						
						
						
						echo '<br class="clear"/>';
						
						echo '<br />';
						
						echo '<hr />';
	
						echo '<div class="small-12 columns">';
	
						// randomize list of followers
	
						shuffle ($my_followers);
	
						foreach ($my_followers as &$value) {
				
							echo '<div class="small-1 left">';
				
							echo '<a href="' . $value['permalink_url'] . '" title="' . $value['username'] . '" target="_blank"><img src="' . $value['avatar_url'] . '" border="0" /></a>';
	
							echo '<br />';
	
							echo '</div>';
	
						}
						
						echo '<br class="clear"/>';
							
						echo '</div>';
	
						echo '<br class="clear"/>';
	
						echo '</div>';
		
						echo '<hr />';
		
						echo '<h5>Save Settings</h5>';
						
						echo '<br />';
		
						echo '<div class="small-12 columns text-center">';
						
						 echo '<input type="hidden" name="action" value="netfunktheme_save_soundcloud_options">';
						
						echo '<input type="submit" class="button radius button-primary" value="Save Options" />';
		
						echo '</div>';
		
						echo '</form>';
						
					} else {
					
						echo '<p>No followers yet.</p>';
						
					}
					
					?> </div> <?php
					
					/* Debug  */
					
					//echo '<pre>';
					//echo '<h6>debug</h6>';
					//print_r ($options);
					//echo '</pre>';
					//echo get_user_meta($current_user->ID,'soundcloud_show_followers',true);
					
				}
				
			}
		}
	}
	
	
	
	/* netfunktheme soundcloud show author sounds */
	
	if (!function_exists('netfunktheme_soundcloud_author_sounds')){
	
		function netfunktheme_soundcloud_author_sounds($user_id) {
		
			global $soundcloud;
			
			//$user_id = get_the_author_meta( 'ID' );     // DEBUG LINE
		
			//echo $user_id;
		
			if (class_exists('bc_soundcloud_integration')){
		
				if (get_user_meta($user_id,'soundcloud_token',true)){
		
					if (get_user_meta($user_id,'soundcloud_show_sounds',true)  == "true"){
		
						$soundcloud->setAccessToken(get_user_meta($user_id,'soundcloud_token',true));
						$me = json_decode($soundcloud->get('me'), true);
						$my_music = json_decode($soundcloud->get('tracks',array('user_id' => $me['id'])), true);
	
					?>
						
					<div class="small-12 sound_cloud_content">
					
					<br />
					
					<h4>Soundcloud Sounds</h4>
						
					<?php
	
					if (!empty($my_music)){ 
				
						$options = get_user_meta($user_id,'soundcloud_soundstoshow',true); 
				
						$sc_auto_play = (get_user_meta($user_id,'soundcloud_play_first',true) == "true" ? true : false);
	
						echo '<div class="panel radius">';
	
						foreach ($my_music as &$value) {
							
							if ( $options[$value['permalink']] == 1 ){
		
								echo '<br />';
		
								echo '<h6 class="paneltitle"><a href="'.$value['permalink_url'].'" target="_blank">'.$value['title'].'</a></h6>';
								
								echo soundcloud_shortcode(
								
									array('url' => $value['uri'],
										  'iframe' => ''.(get_user_meta($user_id,'soundcloud_html5',true) == "true" ? "true" : "false").'',
										  'params' => 'auto_play='.($sc_auto_play != false ? "true" : "false").'&amp;show_user=true&amp;show_artwork='
												.(get_user_meta($user_id,'soundcloud_show_artwork',true) == "true" ? "true" : "false")
												.'&amp;show_comments='
												.(get_user_meta($user_id,'soundcloud_show_comments',true) == "true" ? "true" : "false").'&amp;color=283636&amp;theme_color=272b2c',
										  'height' => '',
										  'width'  => ''
								));
								
								echo "<br /><br />";
		
								$sc_auto_play = false;
	
							} //endif
						
						} //endforeach
						
						echo '</div>';
						
					} else {
					
						echo "<p>No sounds yet.</p>";
						
					}
					
					
					//echo '<pre>';
					//echo '<h6>debug</h6>';
					//print_r ($options);
					//echo '</pre>';
					//echo get_user_meta($user_id,'soundcloud_groupstoshow['.$value['permalink'].']',true);
	
						
					?>
					
					
					
					</div>
			
					<?php
					
					}
	
				}
			
			} else {
			
				echo "Sounddcloud API Required";
	
			}
		}
	}
	
	
	
	/* netfunktheme soundcloud author followers */

	if (!function_exists('netfunktheme_soundcloud_author_followers')){

		function netfunktheme_soundcloud_author_followers($user_id) {
	
			global $soundcloud, $current_user;
		
			if (class_exists('bc_soundcloud_integration')){
		
				if (get_user_meta($user_id,'soundcloud_token',true)){
		
					if (get_user_meta($user_id,'soundcloud_show_followers',true)  == "true"){
	
						$soundcloud->setAccessToken(get_user_meta($user_id,'soundcloud_token',true));
						$my_followers = json_decode($soundcloud->get('me/followers',array('user_id' => $user_id,'limit' => '48')), true);
						
						$me = json_decode($soundcloud->get('me',array('user_id' => $user_id)), true);
						$total_followers =  $me['followers_count'];
						$display_followers = count($my_followers);
						
						?>
						
						<div class="large-12 small-12 columns soundcloud_followers_content">
						
						
						<?php
	
						if (!empty($my_followers)){
	
							$options = get_user_meta($user_id,'soundcloud_show_followers',true); 
	
							//echo '<div class="panel radius">';
	
							
	
							shuffle ($my_followers);
	
							foreach ($my_followers as &$value) {
					
								echo '<div class="small-1 left">';
					
								echo '<a href="' . $value['permalink_url'] . '" title="' . $value['username'] . '" target="_blank"><img src="' . $value['avatar_url'] . '" border="0" /></a>';
		
								echo '<br />';
		
								echo '</div>';
		
							}
							
							//echo '</div>';
						
						?> 
                        
                        <br class="clear" />
                        
                        <br />
                        
                        <h6 class="text-right"><span class="webicon soundcloud small"></span> Soundcloud Fans | 
						
						<?php echo '<small><strong>Total Followers:</strong> ('.$total_followers .') &nbsp; - <a href="'.$me['permalink_url'].'/followers" target="_blank">view all</a></small>'; ?></h6>
		
						
						<?php 
						
						} else {
						
							echo '<p>No followers yet.</p>';
							
						}
						
					?> </div> <?php
						
					}
				}
			}
		}
	}
	
	
	/* netfunktheme soundcloud author groups */
	
	if (!function_exists('netfunktheme_soundcloud_author_groups')){
	
		function netfunktheme_soundcloud_author_groups($user_id) {
	
			global $soundcloud;
		
			if (class_exists('bc_soundcloud_integration')){
		
				if (get_user_meta($user_id,'soundcloud_token',true)){
		
					if (get_user_meta($user_id,'soundcloud_show_groups',true)  == "true"){
	
						$soundcloud->setAccessToken(get_user_meta($user_id,'soundcloud_token',true));
						$me = json_decode($soundcloud->get('me'), true);
						$my_groups = json_decode($soundcloud->get('groups',array('user_id' => $me['id'])), true);
						
						?>
						
						<div class="small-12 sound_cloud_content">
						
                        <br />
                        
						<h4>Soundcloud Groups</h4>
		
						<?php
						
						if (!empty($my_groups)){
	
							$options = get_user_meta($user_id,'soundcloud_groupstoshow',true); 
	
							echo '<div class="panel radius">';
	
							foreach ($my_groups as &$value) {
							
								if ( $options[$value['permalink']] == 1 ){
								
									echo '<h4 class="paneltitle"><a href="'. $value['permalink_url'] . '" target="_blank">'. $value['name'] . '</a></h4>'
									. $value['short_description'] . '<br />' 
									. '<span style="color: #888">Created By:</span> '. '<a href="'.$value['creator']['permalink_url'].'" target="_blank">' . $value['creator']['username'] . '</a><br /><br />';
									
									echo '<hr />';
									
								} //endif
							
							} //endforeach
							
							echo '</div>';
						
						} else {
						
							echo '<p>No groups yet.</p>';
							
						}
						
					?> </div> <?php
						
					}
				}
			}
		}
	}
	
	
	/* netfunktheme soundcloud author playlists */
	
	if (!function_exists('netfunktheme_soundcloud_author_playlists')){
	
		function netfunktheme_soundcloud_author_playlists($user_id) {
	
			global $soundcloud;
		
			if (class_exists('bc_soundcloud_integration')){
		
				if (get_user_meta($user_id,'soundcloud_token',true)){
		
					if (get_user_meta($user_id,'soundcloud_show_playlists',true)  == "true"){
	
						$soundcloud->setAccessToken(get_user_meta($user_id,'soundcloud_token',true));
						$me = json_decode($soundcloud->get('me'), true);
						$my_playlists = json_decode($soundcloud->get('playlists',array('user_id' => $me['id'])), true);
						
						?>
						
						<div class="small-12 sound_cloud_content">
						
                        <br />
                        
						<h4>Soundcloud Playlists</h4>

						<?php
						
						if (!empty($my_playlists)){
	
							$options = get_user_meta($user_id,'soundcloud_liststoshow',true); 
							
							echo '<div class="panel radius">';
	
							foreach ($my_playlists as &$value) {
					
								if ( $options[$value['permalink']] == 1 ){
					
									echo '<h6 class="paneltitle"><a href="' . $value['permalink_url'] . '" target="_blank">' . $value['title'] . '</a></h6> ';
		
									$n = 1;
		
									echo '<ul>';
									
									echo '<li>';
		
									foreach ($value['tracks'] as &$track){
		
										echo $n . ' - ' . $track['title'] . ' - <a href="'.$track['permalink_url'].'" target="_blank">' . $track['user']['username'] . '</a><br />';
		
										$n++;
									}
		
									echo '<br />';
									
									echo '</li>';
									
									echo '</ul>';
								
								}
							
							}
							
							echo '</div>';
	
						} else {
						
							echo '<p>No playlists yet.</p>';
							
						}
						
					?> </div> <?php
						
					}
				}
			}
		}
	}
	
	
	
	
	/* netfunktheme home player soundcloud contributors */
	
	if (!function_exists('netfunktheme_soundcloud_home_contributors')){
		function netfunktheme_soundcloud_home_contributors($group_id) {
			global $current_user, $soundcloud;
			if (class_exists('bc_soundcloud_integration')){
			if (!empty($group_id)){
			$soundcloud_user_id = 'PillFORM';
			$soundcloud->setAccessToken(get_user_meta($soundcloud_user_id,'soundcloud_token',true));
			//$me = json_decode($soundcloud->get('me'), true);
			//$my_groups = json_decode($soundcloud->get('groups',array('group_id' =>  $group_id)), true);
			$my_groups = json_decode($soundcloud->get('groups/'.$group_id.'/contributors'), true);
			if (!empty($my_groups)){
			$n = 1;
			$limit = 28; 
			foreach ($my_groups as &$value) {
			if ($n <= $limit) {
			echo '<a href="' . $value['permalink_url'] . '" title="' . $value['username'] . '" target="_blank">'
			.'<img src="'. $value['avatar_url'] . '" alt="' . $value['username'] . '" border="0" width="54" height="54" /></a>';
			$n ++; } }
			} else {
				echo "<p>No contributors.</p>";}
			} else {
				echo "Soundcloud API Error: Group Empty!";}
			} else {
				echo "Netfunk Theme Soundcloud Plugin Required!";
			}
		}
	}

	/* Sound Cloud Contributors */
	
	class Breaksculture_Soundcloud_Widget extends WP_Widget {
		function Breaksculture_Soundcloud_Widget(){
		$widget_ops = array('classname' => 'widget_soundcloud_panel', 'description' => __( "Soundcloud Home Page Panel") );
		$this->WP_Widget('widget_soundcloud_panel', __('Soundcloud Home Page Panel'), $widget_ops);}
		
		function widget( $args, $instance ) {
		extract($args);
		$custom_title = $instance[ 'custom_title' ];
		$soundcloud_id = $instance[ 'soundcloud_id' ];
		$soundcloud_name = $instance[ 'soundcloud_name' ];
		$soundcloud_desc = $instance[ 'soundcloud_desc' ];
		$soundcloud_dropbox = $instance[ 'soundcloud_dropbox' ];
		echo '<div class="large-12 show-for-medium-up widget-content widget_links">';
		echo '<div class="home-title">';
		echo '<a href="http://soundcloud.com/groups/'.$soundcloud_name.'" class="button secondary tiny round right" style="margin-right: 40px;">More Soundcloud</a>';
		echo '<div class="row featured soundcloud_panel_widget">'
		.'<div class="page-title">'
		.'<a href="http://soundcloud.com/groups/'.$soundcloud_name.'" target="_blank">'.$custom_title.'</a><br />'
		.'</div></div></div>';
		echo '<div class="large-8 columns left" style="margin-bottom: 20px;">'
		.'<iframe style="width: 100%; height: 480px; margin-left: 20px; margin-right: 20px;" scrolling="no" frameborder="no" src="http://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Fgroups%2F'.$soundcloud_id.'&amp;auto_play=false&amp;show_artwork=true&amp;color=4a5257"></iframe>'
		.'</div>';
?>
        <div class="large-4 columns right" style="margin-bottom: 0px;">
        <div style="height: 480px;" class="panel radius">
        <div class="large-6 left">
        <img width="160" height="42" alt="netfunkdesign.com" src="/wp-content/themes/netfunktheme/images/logo1.png" style="margin-top: 10px;"></img>
        </div>
        <?php if ($soundcloud_dropbox != 0): ?>
        <div class="large-6 right">
        <a class="soundcloud-dropbox" style="display: block; margin: 10px auto; background: transparent url(http://a1.sndcdn.com/images/dropbox_small_white.png?d0e45d5) top left no-repeat; color: #888888; font-size: 10px; height: 50px; padding: 26px 60px 0 12px; width: 190px; text-decoration: none; font-family: 'CalibriRegular', 'TahomaNormal', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; line-height: 1.3em" target="_blank" href="http://soundcloud.com/groups/<?php echo $soundcloud_name ?>/dropbox">Send us your sounds</a>
        </div>
        <?php endif; ?>
        <br class="clear" />
        <br />
        <?php echo $soundcloud_desc ?>
        <br class="clear" />
        <br />
        <br />
        <div class="small-6 left">
        <h4>Contributors</h4>
        </div>
        <div class="small-6 right text-right" style="padding-top: 10px;">
        <a href="<?php echo 'http://soundcloud.com/groups/'.$soundcloud_name.'/contributors'; ?>" target="_blank">view all</a>
        </div>
        <br class="clear" />
        <div class="small-12">
        <?php netfunktheme_soundcloud_home_contributors($soundcloud_id); ?>
        </div>
        </div>
        </div>
        <br class="clear" />
        <?php
        echo '</div>';}
		
		public function form( $instance ) {
		// outputs the options form on admin
		if ( isset( $instance[ 'custom_title' ] ) ) {
			$title = $instance[ 'custom_title' ];
		} else {
			$title = __( '', 'text_domain' ); }
		if ( isset( $instance[ 'soundcloud_id' ] ) ) {
			$soundcloud_id = $instance[ 'soundcloud_id' ];
		} else {
			$soundcloud_id = __( '', 'text_domain' ); }
		if ( isset( $instance[ 'soundcloud_name' ] ) ) {
			$soundcloud_name = $instance[ 'soundcloud_name' ];
		} else {
			$soundcloud_name = __( '', 'text_domain' ); }
		if ( isset( $instance[ 'soundcloud_desc' ] ) ) {
			$soundcloud_desc = $instance[ 'soundcloud_desc' ];
		} else {
			$soundcloud_desc = __( ''); }
		if ( isset( $instance[ 'soundcloud_dropbox' ] ) ) {
			$soundcloud_dropbox = $instance[ 'soundcloud_dropbox' ];
		} else {
			$soundcloud_dropbox = __( '0', 'text_domain' ); }
?>
		<p>
		<label for="<?php echo $this->get_field_id( 'custom_title' ); ?>"><?php _e( 'Widget Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'custom_title' ); ?>" name="<?php echo $this->get_field_name( 'custom_title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'soundcloud_id' ); ?>"><?php _e( 'Soundcloud Group ID:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'soundcloud_id' ); ?>" name="<?php echo $this->get_field_name( 'soundcloud_id' ); ?>" type="text" value="<?php echo esc_attr( $soundcloud_id ); ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'soundcloud_name' ); ?>"><?php _e( 'Soundcloud Group Name:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'soundcloud_name' ); ?>" name="<?php echo $this->get_field_name( 'soundcloud_name' ); ?>" type="text" value="<?php echo esc_attr( $soundcloud_name ); ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'soundcloud_desc' ); ?>"><?php _e( 'Soundcloud Group Description:' ); ?></label> 
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'soundcloud_desc' ); ?>" name="<?php echo $this->get_field_name( 'soundcloud_desc' ); ?>"><?php echo esc_attr( $soundcloud_desc ); ?></textarea>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'soundcloud_dropbox' ); ?>"><?php _e( 'Show Your Dropbox Link:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'soundcloud_dropbox' ); ?>" name="<?php echo $this->get_field_name( 'soundcloud_dropbox' ); ?>" type="text" value="<?php echo esc_attr( $soundcloud_dropbox ); ?>" />
		</p>
<?php 
		}
	
		public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['soundcloud_id'] = ( ! empty( $new_instance['soundcloud_id'] ) ) ? strip_tags( $new_instance['soundcloud_id'] ) : '';
		$instance['custom_title'] = ( ! empty( $new_instance['custom_title'] ) ) ? strip_tags( $new_instance['custom_title'] ) : '';
		$instance['soundcloud_name'] = ( ! empty( $new_instance['soundcloud_name'] ) ) ? strip_tags( $new_instance['soundcloud_name'] ) : '';
		$instance['soundcloud_desc'] = ( ! empty( $new_instance['soundcloud_desc'] ) ) ? strip_tags( $new_instance['soundcloud_desc'] ) : '';
		$instance['soundcloud_dropbox'] = ( ! empty( $new_instance['soundcloud_dropbox'] ) ) ? strip_tags( $new_instance['soundcloud_dropbox'] ) : '0';
		return $instance;}
	}
	
	/* netfunktheme widget */
	
	class Breaksculture_Widget_BC_Soundcloud extends WP_Widget {
	
		function Breaksculture_Widget_BC_Soundcloud(){
		$widget_ops = array('classname' => 'widget_soundcloud', 'description' => __( "Soundcloud.com Integration") );
		$this->WP_Widget('soundcloud', __('Soundcloud'), $widget_ops);}
		
		function widget( $args, $instance ) { global $current_user;
		extract($args);
		echo '<li id="soundcloud-connect-widget" class="widgetcontent soundcloud_menu_widget">';
		echo '<h5 class="widgettitle"><span class="webicon soundcloud small"></span>Soundcloud Integration</h5>';
		if (class_exists('bc_soundcloud_integration')) { 
			if (!get_user_meta($current_user->ID,'soundcloud_token')){
				soundcloud_auth_link();
			} else {
				do_action('soundcloud_widget_menu');
			}
		} else { 
			echo '<span class="error">Soundcloud Integration Plugin Required!</span>';
		}
		echo '</li>';}
	
	}
	
	/* register netfunktheme widgets (widgets.php) */
	
	add_action('widgets_init', 'netfunktheme_soundcloud_widgets', 1);	
	
	function netfunktheme_soundcloud_widgets() {
	register_widget('Breaksculture_Soundcloud_Widget');
	register_widget('Breaksculture_Widget_BC_Soundcloud');}

	/* author page plugin hooks */

	if (function_exists('netfunktheme_author_page_info')){

		function soundcloud_author_followers_filter(){
		/* Soundcloud Followers */
		$user_id = get_the_author_meta('ID');
		echo '<div class="large-9 small-12 right show-for-small-up">';
		echo netfunktheme_soundcloud_author_followers($user_id);
		echo '</div>';}
	
		add_action('netfunktheme_author_page_info', 'soundcloud_author_followers_filter',1,0);
	
		function soundcloud_author_sounds_filter(){
		$user_id = get_the_author_meta('ID');
		netfunktheme_soundcloud_author_sounds($user_id);}
		
		add_action('netfunktheme_author_page_info', 'soundcloud_author_sounds_filter',2,0);
	
		function soundcloud_author_playlists_filter(){
		$user_id = get_the_author_meta('ID');
		netfunktheme_soundcloud_author_playlists($user_id);}
		
		add_action('netfunktheme_author_page_info', 'soundcloud_author_playlists_filter',3,0);

		function soundcloud_author_groups_filter(){
		$user_id = get_the_author_meta('ID');
		netfunktheme_soundcloud_author_groups($user_id);}
	
		add_action('netfunktheme_author_page_info', 'soundcloud_author_groups_filter',4,0);
	
	}

} // noclass

?>