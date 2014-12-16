<?php

/* 

Plugin Name: Advanced Author Image 
Plugin Description: Test avatar plugin example. Nothing here yet, only a blank plugin page. 
Plugin Version: 1.0 
Plugin Date: 12/03/13 
Plugin Author: Phil Sanders
Plugin Author URL: http://www.netfunkdesign.com
Plugin URL: http://www.netfunkdesign.com

*/


/* netfunktheme "smart" avatar / author image */

// depending what plugin you may be using for your avatar management 
// we attempt to merge information to provide options for all of them.
// including the locoal avatar, Gravatar, Easy Author Image, 
// even from your forum if you are using WP phpBB Bridge to connect
// with phpBB3 (might also work with phpBB2 but is untested). 
 
 
// filter local avatars

remove_filter( 'get_avatar', 'get_simple_local_avatar' );


/* get custom avatar / local avatars / phpbb3 integration */

add_filter('get_avatar', 'netfunktheme_custom_avatar', 1, 5);

function netfunktheme_custom_avatar( $avatar = '', $id_or_email , $size = 100 , $default = '', $alt = false ) {

	$user_id = get_the_author_meta( 'ID' );

	if ( is_numeric($id_or_email) ) 
			$user_id = (int) $id_or_email;

	elseif ( is_string($id_or_email) ) {

		if ( $user = get_user_by( 'email', $id_or_email ) )
			$user_id = $user->user_id;	
	} 
	
	elseif ( is_object($id_or_email) && !empty($id_or_email->user_id) )
		
		$user_id = (int) $id_or_email->user_id;

		//if ( !empty($user_id) )
			$local_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );

		if ( !isset($local_avatars) || empty($local_avatars) || !isset($local_avatars['full']) ){

			if ( !empty($avatar) ) 	// if called by filter
				return $avatar;

			$default_avatar = '/forum/images/avatars/gallery/avatar.jpg';
			$avatar = "<img alt='" . esc_attr($alt) . "' src='" . $default_avatar . "' class='avatar avatar-{$size}{$author_class} photo avatar-default' height='{$size}' width='{$size}' /> [custom1]";
			return $avatar;
		
		}

		if ( !is_numeric($size) )		// ensure valid size
			$size = '96';

		if ( empty($alt) )
			$alt = get_the_author_meta( 'display_name', $user_id );

		// generate a new size

		if ( empty( $local_avatars[$size] ) ){

			$upload_path = wp_upload_dir();
			$avatar_full_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $local_avatars['full'] );
			$image_sized = image_resize( $avatar_full_path, $size, $size, true );

			if ( is_wp_error($image_sized) ) // deal with original being >= to original image (or lack of sizing ability)
				$local_avatars[$size] = $local_avatars['full'];

			else
				$local_avatars[$size] = str_replace( $upload_path['basedir'], $upload_path['baseurl'], $image_sized );	

			update_user_meta( $user_id, 'simple_local_avatar', $local_avatars );
		}

		elseif ( substr( $local_avatars[$size], 0, 4 ) != 'http' )
			$local_avatars[$size] = site_url( $local_avatars[$size] );

		$author_class = is_author( $user_id ) ? ' current-author' : '' ;
		$avatar = "<img alt='" . esc_attr($alt) . "' src='" . $local_avatars[$size] . "' class='avatar avatar-{$size}{$author_class} photo' height='{$size}' width='{$size}' />";

		return apply_filters('get_custom_avatar', $avatar, $id_or_email, $size, $default, $alt);

}


// EOF