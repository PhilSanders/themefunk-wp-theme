<?php

/* NetfunkTheme Action Pages */

/* action page examples */
# netfunktheme_action_page_init ($action, $class, $function);
# netfunktheme_action_page_init ('edit-member', 'edit-member', 'member_profile_function'); 

$request_action = (!empty($_REQUEST['page_id']) ? $_REQUEST['page_id'] : '');

if(!function_exists('netfunktheme_action_page_init')){
  function netfunktheme_action_page_init ($action, $class, $function) {
	global $request_action;
	if ($request_action == $action) {
	  add_filter('body_class','netfunktheme_action_page_slug',1,1);
	  add_filter('netfunktheme_action_page_title','netfunktheme_action_page_title',1,1);
	  add_filter('the_content',$function,1,1);
	  add_action('template_redirect', 'netfunktheme_action_page_template');
	}
  }
}

/* plugin action page <body> class */
if(!function_exists('netfunktheme_action_page_slug')){
  function netfunktheme_action_page_slug($classes) {
	$new_classes = array();
	foreach ($classes as $class){
	  // remove the 'home' body element class
	  if ( $class != 'home' )
	  $new_classes[] = $class;
	}
	$new_classes[] = 'action-page';
	return $new_classes;
  }
}

/* plugin plugin action page shortcode */
if(!function_exists('netfunktheme_action_page_content')){
  function netfunktheme_action_page_content($content) {
	return $content;
  }
}

/* plugin action page <h1> title class */
if(!function_exists('netfunktheme_action_page_title')){
  function netfunktheme_action_page_title () {
	global $action_page_title;
	echo $action_page_title;
  }
}

/* switch the side bar from left to right side */
if(!function_exists('netfunktheme_action_side_leftright')){
  function netfunktheme_action_side_leftright(){
    
  }
}

if(!function_exists('netfunktheme_action_page_template')){
  function netfunktheme_action_page_template() {
  	$action_page_root = get_template_directory().'/action.php';
	$action_page_theme = get_template_directory().'/action.php';
	if (file_exists($action_page_root)) {
		// if file exists, use it
		include ($action_page_root);
	} else if (file_exists($action_page_theme)) {
		// if file exists, use it
		include ($action_page_theme);
	} else {
		// otherwise use template function output
		netfunktheme_action_page_tpl_function();
	}
  	exit;
  }
}

if(!function_exists('netfunktheme_action_page_tpl_function')){
  function netfunktheme_action_page_tpl_function() {
  ?>
  <?php get_header(); ?>
  <div id="container">
	<div class="content">
      <div class="row">
	    <div class="large-12 small-12 columns">
	      <br />
		  <div class="large-6 small-12 columns left">
		    <h1><?php do_action('netfunktheme_action_page_title'); ?></h1>
		  </div>
		  <br class="clear" />
          <br />
		  <div class="large-9 columns">
		    <div class="entry-content">
		    <?php 
		      if ( has_post_thumbnail() ) {
			    //the_post_thumbnail();
			  } 
		    ?>
		    <?php the_content(); ?>
		    <br class="clear" />
		  </div>
	    </div>
	    <?php // place holder for action page sidebar content   
          do_action('netfunktheme_action_page_sidebar'); 
        ?>
        </div>
      </div>
    </div>
  </div>
  <?php get_footer();?> 
  <?php
  }
}

/* NetfunkTheme 'Acton Page' sidebar hook */
if(!function_exists('netfunktheme_action_page_sidebar')){
  function netfunktheme_action_page_sidebar() {
	global $plugin_widget_sidebar;
?>
	<div class="large-3 small-12 columns right">
		<div id="sidebar" class="widget-area theme-action-sidebar">
			<ul class="sid">
			<?php dynamic_sidebar('action-widget-area'); ?> 
			</ul>
		</div>
	</div>
<?php
  }
  add_filter ('netfunktheme_action_page_sidebar','netfunktheme_action_page_sidebar');
}

//EOF