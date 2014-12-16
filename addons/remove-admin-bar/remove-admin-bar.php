<?php

/* 

Plugin Name: Remove The Admin Bar 
Plugin Description: Prevents the admin menu bar from displaying on the front home page. 
Plugin Version: 1.0 
Plugin Date: 12/03/13 
Plugin Author: Phil Sanders
Plugin Author URL: http://www.netfunkdesign.com/author/pillform 
Plugin URL: http://www.netfunkdesign.com

*/

// Disable the admin bar, set to true if you want it to be visible.

add_filter('init','netfunktheme_show_admin_bar');

if (!function_exists( 'netfunktheme_show_admin_bar' )){
	
	function netfunktheme_show_admin_bar() {
		show_admin_bar(FALSE);
	}
	
}

// EOF