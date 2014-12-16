<?php

/* 

Plugin Name: Remove Generator Meta info 
Plugin Description: Prevents wordpress from displayingthe content generator information. Helps to hide yourself from wordpress blog vulnrabilities and attacks. 
Plugin Version: 1.0 
Plugin Date: 12/03/13 
Plugin Author: Phil Sanders
Plugin Author URL: http://www.netfunkdesign.com
Plugin URL: http://www.netfunkdesign.com

*/


// Disable WordPress version reporting as a basic protection against attacks

add_filter('the_generator','netfunktheme_remove_generators');

if (!function_exists( 'netfunktheme_remove_generators' )){

	function netfunktheme_remove_generators() {
		return '';
	}

}

// EOF