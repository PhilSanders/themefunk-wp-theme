<?php

/* 

Plugin Name: Advanced Member Profile Page 
Plugin Description: Provides frontside member profile page settings for expanded user profile information and content management. Incorporates modern socials networking features including facebook, twitter, soundcloud, youtube and more.
Plugin Version: 1.0 
Plugin Date: 12/03/13 
Plugin Author: Phil Sanders
Plugin Author URL: http://www.netfunkdesign.com
Plugin URL: http://www.netfunkdesign.com

*/

//define('ACTION_PAGE','/?action=edit-member');

/* action page hooks  */ 
// custom, on-the-fly settings pages by netfunk

//profile_action_page('edit-member', 'edit-member', 'netfunktheme_edit_profile_page','Profile Settings');


/* action page handler   
function profile_action_page($action, $pageclass, $function, $action_page_title) {
	global $request_action;
	if ($request_action == $action) {
	  add_filter('body_class', 'profile_action_page_slug',1,1);
	  add_filter('profile_action_page_title', 'profile_action_page_title',1,1);
	  add_filter('profile_action_page_sidebar', 'profile_action_page_sidebar',1,4);
	  add_filter('the_content',$function,1,1);
	  add_action('template_redirect','profile_action_page_template');
	}
}*/

/* action page <body> class
function profile_action_page_slug($classes) {
	if (!empty($classes)){
		$new_classes = array();
		foreach ($classes as $class){
			// remove the 'home' body element class
			if ( $class != 'home' )
			$new_classes[] = $class;
		}
		$new_classes[] = 'action-page';
		return $new_classes;
	}
} */

/* action page content
function profile_action_page_content($content) {
	return $content;
} */

/* action page <h1> title class
function profile_action_page_title() {
	global $action_page_title;
	echo $action_page_title;
} */

/*
function profile_action_page_template() {
	get_header(); 
?>
	<div id="container" class="row">
	<div class="content row">
		<div class="large-12 small-12 columns">
			<br />
			<div class="large-6 small-12 columns left">
				<h1><?php do_action('profile_action_page_title'); ?></h1>
			</div>
			<br class="clear" />
			<div class="large-9 columns">
				<?php 
					// place holder for additional action page footer information via 
					do_action('profile_action_page_header'); 
				?>
				<div class="entry-content">
					<?php 
						if ( has_post_thumbnail() ) {
							//the_post_thumbnail();
						}
					?>
					<?php the_content(); ?>
					<br class="clear" />
				</div>
				<?php 
					// place holder for additional action page footer information via 
					do_action('profile_action_page_footer'); 
				?>
			</div>
			<?php // place holder for action page sidebar content   
				do_action('profile_action_page_sidebar'); 
			?>
		</div>
	</div><!--content-->
	</div><!--container-->
	<?php 
	get_footer(); 
	exit;
} */


/* link added to theme user menu
function netfunktheme_member_edit_link( ) {
?><li><a href="<?php echo ACTION_PAGE ?>" class="members">Profile Settings
   	 <div>Edit your profile, upload a user image, manage personal <br />preferences.</div></a></li>
<?php 
}
add_filter('netfunktheme_user_dropdown_menu', 'netfunktheme_member_edit_link', 1, 0);
 */



/* netfunk - Profile - About You

add_action( 'show_user_profile', 'netfunktheme_profile_about_fields' );
add_action( 'edit_user_profile', 'netfunktheme_profile_about_fields' );

function netfunktheme_profile_about_fields ( $user ) { ?>

	<br />
    
    <hr />
    
    <div class="panel radius">

    <h2>Advanced Member Profile (Netfunk)</h2>
    
    <br />

	<h3>About You</h3>

	<table class="form-table">

		<tr>
			<th><label for="netfunktheme_about">About You</label></th>

			<td>
				<textarea name="netfunktheme_about" id="netfunktheme_about" cols="30" rows="5"/><?php echo esc_attr( get_the_author_meta( 'netfunktheme_about', $user->ID ) ); ?></textarea><br />
				<span class="description">Your personal information. Keep it short and simple.</span>
			</td>
		</tr>

	</table>
    
    <br />
    
    <h3>More About</h3>

	<table class="form-table">

		<tr>
			<th><label for="netfunktheme_more_about">More About You</label></th>

			<td>
				<textarea name="netfunktheme_more_about" id="netfunktheme_more_about" cols="30" rows="5"/><?php echo esc_attr( get_the_author_meta( 'netfunktheme_more_about', $user->ID ) ); ?></textarea><br />
				<span class="description">Your personal information. Describe your work experience or history.</span>
			</td>
		</tr>

	</table>
    
    <br />
    
    </div>

<?php }  */


/*
add_action( 'personal_options_update', 'netfunktheme_profile_about_fields_update' );
add_action( 'edit_user_profile_update', 'netfunktheme_profile_about_fields_update' );

function netfunktheme_profile_about_fields_update( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_user_meta( $user_id, 'netfunktheme_about', $_POST['netfunktheme_about'] );
	update_user_meta( $user_id, 'netfunktheme_more_about', $_POST['netfunktheme_more_about'] );

} */


/* netfunk - Profile - Company Information

add_action( 'show_user_profile', 'netfunktheme_profile_title_fields' );
add_action( 'edit_user_profile', 'netfunktheme_profile_title_fields' );

function netfunktheme_profile_title_fields ( $user ) { ?>

	<br />

	<hr style=" border: solid #DDD 1px;"/>
    
    <br />

	<h3>Company Information</h3>

	<table class="form-table">

		<tr>
			<th><label for="netfunktheme_company">Company Name</label></th>

			<td>
				<input type="text" name="netfunktheme_company" id="netfunktheme_company" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_company', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Company's name.</span>
			</td>
		</tr>

		<tr>
			<th><label for="netfunktheme_title">Company Title</label></th>

			<td>
				<input type="text" name="netfunktheme_title" id="netfunktheme_title" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_title', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Your company title.</span>
			</td>
		</tr>
        
        <tr>
			<th><label for="netfunktheme_phone">Company Phone</label></th>

			<td>
				<input type="text" name="netfunktheme_phone" id="netfunktheme_phone" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_phone', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Company phone number.</span>
			</td>
		</tr>
        
        <tr>
			<th><label for="netfunktheme_ext">Company Phone Ext</label></th>

			<td>
				<input type="text" name="netfunktheme_ext" id="netfunktheme_ext" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_ext', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Company phone extension.</span>
			</td>
		</tr>
        
        <tr>
			<th><label for="netfunktheme_cell">Cell Phone</label></th>

			<td>
				<input type="text" name="netfunktheme_cell" id="netfunktheme_cell" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_cell', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Company cell phone number.</span>
			</td>
		</tr>
        
        <tr>
			<th><label for="netfunktheme_fax">Fax Number</label></th>

			<td>
				<input type="text" name="netfunktheme_fax" id="netfunktheme_fax" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_fax', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Company fax number.</span>
			</td>
		</tr>
        
        
        <tr>
			<th><label for="netfunktheme_address">Address</label></th>

			<td>
				<input type="text" name="netfunktheme_address" id="netfunktheme_address" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_address', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Company street address.</span>
			</td>
		</tr>
        
       
        <tr>
			<th><label for="netfunktheme_city">City</label></th>

			<td>
				<input type="text" name="netfunktheme_city" id="netfunktheme_city" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_city', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Company city.</span>
			</td>
		</tr>
        
        <tr>
			<th><label for="netfunktheme_state">State</label></th>

			<td>
				<input type="text" name="netfunktheme_state" id="netfunktheme_state" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_state', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Company state.</span>
			</td>
		</tr>
        
         <tr>
			<th><label for="netfunktheme_zip">Zip</label></th>

			<td>
				<input type="text" name="netfunktheme_zip" id="netfunktheme_zip" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_zip', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Company zip/postal code.</span>
			</td>
		</tr>
        
        <tr>
			<th><label for="netfunktheme_country">Country</label></th>

			<td>
				<input type="text" name="netfunktheme_country" id="netfunktheme_country" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_country', $user->ID ) ); ?>" class="regular-text" /><br />
                
                <span class="description">Company country.</span>
			</td>
		</tr>

	</table>

    
    <br />

<?php }  */

/*
add_action( 'personal_options_update', 'netfunktheme_profile_title_fields_update' );
add_action( 'edit_user_profile_update', 'netfunktheme_profile_title_fields_update' );

function netfunktheme_profile_title_fields_update( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	// Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID.
	update_user_meta( $user_id, 'netfunktheme_company', $_POST['netfunktheme_company'] );
	update_user_meta( $user_id, 'netfunktheme_title', $_POST['netfunktheme_title'] );
	update_user_meta( $user_id, 'netfunktheme_phone', $_POST['netfunktheme_phone'] );
	update_user_meta( $user_id, 'netfunktheme_ext', $_POST['netfunktheme_ext'] );
	update_user_meta( $user_id, 'netfunktheme_cell', $_POST['netfunktheme_cell'] );
	update_user_meta( $user_id, 'netfunktheme_fax', $_POST['netfunktheme_fax'] );
	update_user_meta( $user_id, 'netfunktheme_address', $_POST['netfunktheme_address'] );
	update_user_meta( $user_id, 'netfunktheme_city', $_POST['netfunktheme_city'] );
	update_user_meta( $user_id, 'netfunktheme_state', $_POST['netfunktheme_state'] );
	update_user_meta( $user_id, 'netfunktheme_zip', $_POST['netfunktheme_zip'] );
	update_user_meta( $user_id, 'netfunktheme_country', $_POST['netfunktheme_country'] );
}
*/



/* netfunk - Profile - LinkedIn Information

add_action( 'show_user_profile', 'netfunktheme_profile_linkedin_fields' );
add_action( 'edit_user_profile', 'netfunktheme_profile_linkedin_fields' );

function netfunktheme_profile_linkedin_fields ( $user ) { ?>

	<br />

	<hr style=" border: solid #DDD 1px;"/>
    
    <br />

	<h3>LinkedIn Profile Information</h3>

	<table class="form-table">

		<tr>
			<th><label for="netfunktheme_company">LinkedIn User Profile</label></th>

			<td>
				<input type="text" name="netfunktheme_linkedin" id="netfunktheme_linkedin" value="<?php echo esc_attr( get_the_author_meta( 'netfunktheme_linkedin', $user->ID ) ); ?>" placeholder="http://" class="regular-text" /><br />
				<span class="description">Enter the URL your LinkedIn profile.</span>
			</td>
		</tr>

	</table>
    
    <br />

	<hr style=" border: solid #DDD 1px;"/>
    
    <br />

<?php }  */


/*
add_action( 'personal_options_update', 'netfunktheme_profile_linkedin_fields_update' );
add_action( 'edit_user_profile_update', 'netfunktheme_profile_linkedin_fields_update' );

function netfunktheme_profile_linkedin_fields_update( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	//* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. *
	update_user_meta( $user_id, 'netfunktheme_linkedin', $_POST['netfunktheme_linkedin'] );

}*/






/* remove author image  

function avatar_delete( $user_id ) {

	$old_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );
	$upload_path = wp_upload_dir();
	
	if ( is_array($old_avatars) ) {
	
		foreach ($old_avatars as $old_avatar ){
	
			$old_avatar_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $old_avatar );
			@unlink( $old_avatar_path );	
		} 
	}

	delete_user_meta( $user_id, 'simple_local_avatar' );


}*/


/* netfunk edit profile page

function netfunktheme_edit_profile_page() {

	//* Get user info. *
	global $current_user, $wp_roles;
	get_currentuserinfo();

?>


	<?php if ( !is_user_logged_in() ) : ?>
    


        <div class="large-12 alert-box alert" data-alert>
        
            <?php _e('You must be logged in to edit your profile.', 'netfunktheme'); ?>
        
        </div><!-- .warning -->


   
    <?php else : ?>


        <?php if ( isset($error) and $error != '' ) echo '<p class="error">' . $error . '</p>'; ?>
        

        <form method="post" id="edituser" class="user-forms custom" action="">

        <!-- AVATAR MOD -->

        <hr />
        

        <h4><?php _e( 'Avatar','netfunktheme' ); ?></h4>


		<br />

        <div class="row">

        
            <?php $options = get_option('simple_local_avatars_caps');

              if ( empty($options['simple_local_avatars_caps']) || current_user_can('upload_files') ) {

                    do_action( 'simple_local_avatar_notices' ); 
                    wp_nonce_field( 'simple_local_avatar_nonce', '_simple_local_avatar_nonce', false ); 

            ?>

            <div class="large-3 columns">
                
                <?php do_action('netfunktheme_author_image', $atts = array('user_id'=>$current_user->ID,'size'=>100)); ?>
                
                <br />
                
                <br />
                
                <label for="simple-local-avatar" class="left inline"><?php _e('Upload Avatar','netfunktheme'); ?></label>
                
                <input type="file" name="simple-local-avatar" id="simple-local-avatar" />
                
            </div>
            

            <div class="large-9 columns">

                    <div class="row">

                        <div class="large-12 columns">

                            <p>
                           
                             <?php _e('Replace the local avatar by uploading a new avatar, or erase the local avatar (falling back to a gravatar) by checking the delete option.', 'netfunktheme'); ?> 
                            
                            <p>
                    
                        </div>
                    
                    </div>
                    

					<?php if (class_exists('WpPhpBB')){ ?>

                    <div class="row">

                        <div class="large-12 columns">
                            
                            <div class="panel radius notice">
                            
                                <strong>NOTICE:</strong> Avatar images are edited here 
                             
                                as well as your <strong><a href="/forum/ucp.php?i=profile&amp;mode=avatar">forum</a></strong> user profile. You should upload avatars for both 
                             
                                profiles to ensure branding visibility. In this respect you may have 2 different 
                             
                                avatar images =) 
                                
                            </div>
                        
                        </div>
                    
                    </div>
                    
                    <?php } ?>
                    
                    
                    <div class="row">

                        
                        <div class="large-8 columns">

                            <input name="updateuser" type="submit" id="updateuser" class="button small blue radius expand" value="<?php _e('Save Avatar', 'netfunktheme'); ?>" />

                        </div>
                        
                        
                        
                        <div class="large-4 columns">
                        
                        <br />
                        
                        <?php
    
                            if ( empty( $current_user->simple_local_avatar ) )
                                echo '<span class="description">' . __('No local avatar is set. Use the upload field to add a local avatar.','simple-local-avatars') . '</span>';
        
                            else 
        
                                echo '<label for="simple-local-avatar-erase" class="right inline pull-5">'. 
                                    __('Delete local avatar','simple-local-avatars').'</label>'
                                    .'<input type="checkbox" name="simple-local-avatar-erase" value="1" /> ';		
                        ?>
                        
                        </div>

                    </div>
                
            </div>
            
            <?php 
            
            
                } else {

                    echo '<div class="large-12 columns">';
                    
                    if ( empty( $current_user->simple_local_avatar ) )
                        echo '<span class="description">' . __('No local avatar is set. Set up your avatar at Gravatar.com.','simple-local-avatars') . '</span>';

                    else 
                        echo '<span class="description">' . __('You do not have media management permissions. To change your local avatar, contact the blog administrator.','simple-local-avatars') . '</span>';
                
                    echo '</div>';
                }

            ?>
                
                
                

        </div>

        <script type="text/javascript">
    
            var form = document.getElementById('edituser');
    
            form.encoding = 'multipart/form-data';
    
            form.setAttribute('enctype', 'multipart/form-data');
    
        </script>

        
        <hr />
        
        
        
        <h4> <?php _e( 'Name','netfunktheme' ); ?> </h4>

		<br />

        <div class="row"><!-- real name -->
        
            <div class="large-12">
                
                <div class="large-3 columns left">
                    <label for="first_name"><?php _e('First Name', 'netfunktheme'); ?></label>
                </div>
                
                <div class="large-4 pull-5 columns right">
                    <input class="text-input" name="first_name" type="text" id="first_name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
                </div>
            
            </div>
        
        </div>
        
            
        <div class="row"><!-- real name -->
            
            <div class="large-12">
            
                <div class="large-3 columns left">
                    <label for="last_name"><?php _e('Last Name', 'netfunktheme'); ?></label>
                </div>
                
                <div class="large-4 pull-5 columns right">
                    <input class="text-input" name="last_name" type="text" id="last_name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
                </div>
            
            </div>
      
        </div>   
            
            
          <div class="row">  
            
                <div class="large-12">
                
                    <div class="large-3 columns left">
                        <label for="nickname" class="left inline"><?php _e('Nickname <span class="round alert label">(required)</span>', 'netfunktheme'); ?></label>
                    </div>

                    <div class="large-4 pull-5 columns right">
                        <input class="text-input" name="nickname" type="text" id="nickname" value="<?php the_author_meta( 'nickname', $current_user->ID ); ?>" />
                    </div>
                
                </div>
            
           </div>
            
           <div class="row">
            
                <div class="large-12">
                
                    <div class="large-3 columns left">
                        <label for="display_name" class="left inline"><?php _e('Display Name', 'netfunktheme'); ?></label>
                    </div>
                
                   
                    <div class="large-4 pull-5 columns right">
                    <select name="display_name" id="display_name">
                
                    <?php
                        $public_display = array();
                        $public_display['display_nickname']  = $current_user->nickname;
                        $public_display['display_username']  = $current_user->user_login;
                        if ( !empty($current_user->first_name) )
                            $public_display['display_firstname'] = $current_user->first_name;
                        if ( !empty($current_user->last_name) )
                            $public_display['display_lastname'] = $current_user->last_name;
                        if ( !empty($current_user->first_name) && !empty($current_user->last_name) ) {
                            $public_display['display_firstlast'] = $current_user->first_name . ' ' . $current_user->last_name;
                            $public_display['display_lastfirst'] = $current_user->last_name . ' ' . $current_user->first_name;
                        }
                        if ( !in_array( $current_user->display_name, $public_display ) )// Only add this if it isn't duplicated elsewhere
                            $public_display = array( 'display_displayname' => $current_user->display_name ) + $public_display;
                        $public_display = array_map( 'trim', $public_display );
                        foreach ( $public_display as $id => $item ) {
                    ?>
                    
                        <option id="<?php echo $id; ?>" value="<?php echo esc_attr($item); ?>"<?php selected( $current_user->display_name, $item ); ?>><?php echo $item; ?></option>
                    
                    <?php
                    
                        }
                    
                    ?>
                    
                    </select>
                    </div>
                
                </div>
            
            </div>


        <hr />
        
        
        <h4> <?php _e( 'Contact Info','netfunktheme' ); ?>  </h4>

		<br />

        <div class="row">
        
            <div class="large-12">

                <div class="large-3 columns left">
                    <label for="user_email class="left inline""><?php _e('E-mail <span class="round alert label">(required)</span>', 'netfunktheme'); ?></label>
                    
                </div>
                
                <div class="large-4 pull-5 columns right">
                    <input class="text-input" name="user_email" type="text" id="user_email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
                    
                </div>
        
            </div>
        
        </div>
        
        
        <div class="row">
        
            <div class="large-12">        

                <div class="large-3 columns left">
                    <label for="website" class="left inline"><?php _e('Website', 'netfunktheme'); ?></label>
                    
                </div>
                
                <div class="large-4 pull-5 columns right">
                    <input class="text-input" name="website" type="text" id="website" value="<?php the_author_meta( 'website', $current_user->ID ); ?>" />
                    
                </div>

            </div>
        
        </div>
        
       <hr />
        
        
        
        
        <h4> <?php _e( 'Password','netfunktheme' ); ?> </h4>
        
        <br />
        
        <div class="row">
        
            <div class="large-12">
            
                <div class="large-3 columns left">
                    <label for="pass1" class="left inline"><?php _e('New Password', 'netfunktheme'); ?></label>
                    
                </div>
                
                <div class="large-4 pull-5 columns right">
                    <input class="text-input" name="pass1" type="password" id="pass1" autocomplete="off" />
                    
                </div>

         </div>
        
        </div>


         <div class="row">
        
            <div class="large-12">

                <div class="large-3 columns left">
                    <label for="pass2" class="left inline"><?php _e('Confirm Password', 'netfunktheme'); ?></label>
                    
                </div>
                
                <div class="large-4 pull-5 columns right">
                    <input class="text-input" name="pass2" type="password" id="pass2" autocomplete="off" />
                    
                </div>

            </div>
        
        </div>
        
        
        
        <hr />
        


        <h4> <?php _e( 'About Yourself','netfunktheme' ); ?> </h4>
        
        <br />
        
        <div class="row">
        
            <div class="large-12">
        
                <div class="large-3 columns left">
                    <label for="description"><?php _e('Biographical Info', 'netfunktheme'); ?></label>
                
                </div>
                
                <div class="large-7 pull-2 columns right">
                    <textarea class="text-input" name="description" id="description" rows="8" cols="50"><?php echo the_author_meta( 'description', $current_user->ID ); ?></textarea>
                    
                </div>
                
                 <br class="clear"/>

            </div>
        
        </div>
       
       
       <hr />



       <h4> <?php _e( 'Social Network','netfunktheme' ); ?> </h4>
        
        
        <br />
 
        <?php if (class_exists('soundcloud_init')):?>
         
        <div class="row">
        
            <div class="large-12">
        
                <div class="large-2 columns left">
                    <label for="_soundcloud" class="left inline"><?php _e('Soundcloud', 'netfunktheme'); ?></label>
                
                </div>
                
                <div class="large-5 pull-5 columns right">
                   
            
                    <?php	
                    
                        if (!get_user_meta($current_user->ID,'soundcloud_token')):
                            do_action('soundcloud_auth_link_mini');
                            
                        else: 
                            do_action('soundcloud_disconnect_link_mini');
							
						endif;
                        
                    ?>	
                        
                    
                </div>

            </div>
        
        </div>
        
        
        <?php endif; ?>
        
        
        <?php if (class_exists('flb_twitter_api_integration')): ?>
        
        <div class="row">
        
            <div class="large-12">
        
                <div class="large-2 columns left">
                    <label for="twitter" class="left inline"><?php _e('Twitter', 'netfunktheme'); ?></label>
                
                </div>
                
                <div class="large-5 pull-5 columns right">
                    <?php 
            
                        if (!get_user_meta($current_user->ID,'flb_twitter_token'))
                            do_action('twitter_auth_link');
                        
                        else 
                            do_action('twitter_disconnect_link');
                        
                        
                     ?>	
                    
                </div>

            </div>
        
        </div>
        
     <?php endif; ?>
        
        
    <?php if (class_exists('flb_facebook_api_integration')):  ?>


        <div class="row">
        
            <div class="large-12">
        
                <div class="large-2 columns left">
                    <label for="facebook" class="left inline"><?php _e('Facebook', 'netfunktheme'); ?></label>
                
                </div>
                
                <div class="large-5 pull-5 columns right">
                    
                    <?php 
                
                        $flbFacebookClass = new flb_facebook_api_integration();
            
                        echo $flbFacebookClass->facebook_auth_link_mini();

                    ?>

                </div>

            </div>
        
        </div>
        
        
        <?php endif; ?>
        
        
        <div class="row">
        
            <div class="large-12">
        
                <div class="large-4 columns left">
                    <label for="_aim" class="left inline"><?php _e('AIM', 'netfunktheme'); ?></label>
                
                </div>
                
                <div class="large-3 pull-5 columns right">
                    <input class="text-input" name="_aim" type="text" id="_aim" value="<?php the_author_meta( '_aim', $current_user->ID ); ?>" />
                    
                </div>

            </div>
        
        </div>

        
        <div class="row">
        
            <div class="large-12">
        
                <div class="large-4 columns left">
                    <label for="_yim" class="left inline"><?php _e('Yahoo IM', 'netfunktheme'); ?></label>
                
                </div>
                
                <div class="large-3 pull-5 columns right">
                    <input class="text-input" name="_yim" type="text" id="_yim" value="<?php the_author_meta( '_yim', $current_user->ID ); ?>" />
                    
                </div>
                
                <br class="clear"/>

            </div>
            
        
        </div>


        <div class="row">
        
            <div class="large-12">
        
                <div class="large-4 columns left">
                    <label for="_jabber" class="left inline"><?php _e('Jabber / Google Talk', 'netfunktheme'); ?></label>
                
                </div>
                
                <div class="large-3 pull-5 columns right">
                    <input class="text-input" name="_jabber" type="text" id="_jabber" value="<?php the_author_meta( '_jabber', $current_user->ID ); ?>" />
                    
                </div>
                
                <br class="clear"/>

            </div>
        
        </div>


        <div class="row">
        
            <div class="large-12">
        
                <div class="large-4 columns left">
                    <label for="_youtube" class="left inline"><?php _e('Youtube', 'netfunktheme'); ?></label>
                
                </div>
                
                <div class="large-3 pull-5 columns right">
                    <input class="text-input" name="_youtube" type="text" id="_youtube" value="<?php the_author_meta( '_youtube', $current_user->ID ); ?>" />
                    
                </div>
                
                <br class="clear"/>

            </div>
        
        </div>    
        
        
       <hr />


        <h4> <?php _e( 'More About You','netfunktheme' ); ?> </h4>
       
        <br />


        <!--p class="form-birth">
            <label for="birth"><?php _e('Year of birth', 'netfunktheme'); ?></label>
            <?php
                for($i=1900; $i<=2000; $i++)
                    $years[]=$i;
                
                echo '<select name="birth">';
                    echo '<option value="">' . __("Select Year", 'netfunktheme' ) . '</option>';
                    foreach($years as $year){
                        $the_year = get_the_author_meta( 'birth', $current_user->ID );
                        if($year == $the_year ) $selected = 'selected="slelected"';
                        else $selected = '';
                        echo '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
                    }
                echo '</select>';
            ?>
        </p --><!-- .form-birth -->
        
        
        <div class="row">

            <div class="large-8 push-4">
        
                <p><?php _e('What are your interests? What brings you here?', 'netfunktheme'); ?></p>
                
                <?php
                    $hobbies = get_the_author_meta( 'hobbies', $current_user->ID );
                ?>
                
                <ul class="inline-list">
                
                    <li><label class="left inline"><input value="producing"        	name="hobbies[]" <?php if (is_array($hobbies)) { 		if (in_array("producing",       $hobbies)) { ?>checked="checked"<?php } }?> type="checkbox" /> <?php _e('Music Production',           		'netfunktheme'); ?></label></li>
                
                    <li><label class="left inline"><input value="mixing" 			name="hobbies[]" <?php if (is_array($hobbies)) { 		if (in_array("mixing", 			$hobbies)) { ?>checked="checked"<?php } }?> type="checkbox" /> <?php _e('Djing / Mixing', 					'netfunktheme'); ?></label></li>
                
                    <li><label class="left inline"><input value="promoting"        	name="hobbies[]" <?php if (is_array($hobbies)) { 		if (in_array("promoting",       $hobbies)) { ?>checked="checked"<?php } }?> type="checkbox" /> <?php _e('Promoting Music / Events',         'netfunktheme'); ?></label></li>
                
                </ul>
            
        
            </div> 

        </div> 



        <hr />


		<h4>Save Settings</h4>
        
		<br />

        <div class="row">
        

            <div class="large-8 push-2 text-center">
        
                <?php if (isset($referer))
					 echo $referer; ?>
            
                <input name="updateuser" type="submit" id="updateuser" class="button expand radius blue" value="<?php _e('Update Profile', 'netfunktheme'); ?>" />
            
                <?php wp_nonce_field( 'update-user' ) ?>
            
                <input name="action" type="hidden" id="action" value="update-user" />

            </div>
            
        
        </div>

        </form> 
        

    <?php endif; ?>

<?php

} */

/* theme plugin sidebar hook 
		
function profile_action_page_sidebar() {

	global $plugin_widget_sidebar;
	
?>
		
	<div class="large-3 small-12 columns right">

		<div id="sidebar" class="widget-area theme-action-sidebar">

			<ul class="sid">

			<?php
			
			
			dynamic_sidebar('action-widget-area');
			
			?> 
			
			</ul>

		</div>

	</div>

<?php

}*/
		
// EOF