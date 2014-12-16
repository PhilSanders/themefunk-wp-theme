<?php
/* 

Plugin Name: Soundcloud API Package 
Plugin Description: Soundcloud.com API package. Needed for all Soundcloud addon addons for Breaksculture Theme. Includes the soundcloud PHP API SDK distribution kit. 
Plugin Version: 1.0 
Plugin Date: 12/03/13 
Plugin Author: Phil Sanders 
Plugin Author URL: http://www.netfunkdesign.com/author/pillform 
Plugin URL: http://www.netfunkdesign.com 

*/

require_once ( get_template_directory() .'/addons/soundcloud-api/soundcloud-api/soundcloud.php');

if (class_exists('bc_soundcloud_integration')){


	$bcSoundcloudClass = new bc_soundcloud_integration();

	// Initialize Soundcloud Services with AccessToken from User Meta
	
	$soundcloud = $bcSoundcloudClass->soundcloud_connection();
	


	// action hooks 
	
	add_action('soundcloud_authorize', array($bcSoundcloudClass, 'soundcloud_connection'));
	add_action('soundcloud_auth_link', array($bcSoundcloudClass, 'soundcloud_auth_link'));
	add_action('soundcloud_auth_link_mini', array($bcSoundcloudClass, 'soundcloud_auth_link_mini'));
	add_action('soundcloud_disconnect_link', array($bcSoundcloudClass, 'soundcloud_disconnect_link'));
	add_action('soundcloud_disconnect_link_mini', array($bcSoundcloudClass, 'soundcloud_disconnect_link_mini'));



} // noclass


else {


	die('<h3> Soundcloud API plugin required </h3>');


}


// EOF