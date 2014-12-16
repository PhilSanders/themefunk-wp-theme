<?php

/* 

Plugin Name: No Auto-Paragraph 
Plugin Description: Prevents wordpress from adding paragraph tags to posts automatically. 
Plugin Version: 1.0 
Plugin Date: 07/20/14 
Plugin Author: NetfunkDesign
Plugin Author URL: http://www.netfunkdesign.com
Plugin URL: http://www.netfunkdesign.com

*/

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

// EOF