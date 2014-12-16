<?php
/* 

	Theme Name: WP-netfunktheme 
	Theme URI: http://netfunkdesign.com
	Description: netfunkdesign.com Soundcloud.com Intigration.
	Version: Beta 0.9.1
	Author: Phil Sanders
	Author URI: http://netfunkdesign.com

	License: GPL2 

	Copyright 2012 Phil Sanders  (email : philsanders79@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/* breakculture include files  */
require_once (get_template_directory() .'/includes/theme-options.php');
require_once (get_template_directory() .'/includes/actions.php');
require_once (get_template_directory() .'/includes/addons.php');
require_once (get_template_directory() .'/includes/widgets.php');
require_once (get_template_directory() .'/includes/shortcodes.php');


/* breakculture themes */
$file_paths = glob(get_template_directory() . '/layouts/*/*.php');

foreach ($file_paths as $file) {
    require_once($file);
}


/* NetfunkTheme Config */
if (!function_exists( 'netfunktheme_setup')){
	function netfunktheme_setup() {
		global $content_width, $options, $onoff_options;
		
		if (!isset($content_width))
			$content_width = 1000;
		
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		
		//add_theme_support( 'infinite-scroll', array(
		//	'container' => 'container',
		//	'footer' => 'page'));
			
		// Add support for custom backgrounds
		$args = array(
		'default-color' => '#FFF',
		'wp-head-callback' => '_custom_background_cb');
		add_theme_support( 'custom-background', $args );

		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'netfunktheme', get_template_directory() . '/languages' );
		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/".$locale.".php";
	
		if (is_readable($locale_file))
			require_once($locale_file);

		// This theme uses wp_nav_menu() in two location.	
		register_nav_menus( array(
				'primary' => __( 'Main Navigation', 'netfunktheme' ),
				'footer' => __( 'Footer Navigation', 'netfunktheme' )
		));
	}
}
add_action('after_setup_theme', 'netfunktheme_setup');


/* netfunktheme theme header */
if (!function_exists( 'netfunktheme_theme_header')){

	function netfunktheme_theme_header() {
		$args = array(
			'default-image' => get_stylesheet_directory_uri() . '/images/logo.png',
			'default-text-color' => '#000',
			'width' => 400,
			'height' => 100,
			'flex-height' => true,
			'uploads' => true,
			'wp-head-callback' => '',
			'admin-head-callback' => '',
			'admin-preview-callback' => ''
		);
		$args = apply_filters( 'netfunktheme_theme_header_args', $args );
	
		if ( function_exists( 'wp_get_theme' ) ) {
			add_theme_support( 'custom-header', $args );
	
		} else {
			// Compat: Versions of WordPress prior to 3.4.
			define( 'HEADER_TEXTCOLOR', $args['default-text-color'] );
			define( 'HEADER_IMAGE', $args['default-image'] );
			define( 'HEADER_IMAGE_WIDTH', $args['width'] );
			define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
			
			add_custom_image_header( $args['wp-head-callback'], 
			$args['admin-head-callback'], $args['admin-preview-callback']);
		}
	}
}


if (!function_exists('netfunktheme_custom_header')){
	function netfunktheme_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}
add_action( 'after_setup_theme', 'netfunktheme_theme_header' );


function netfunktheme_custom_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
	<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
	<div class="comment-author">
      <?php printf(__('By %1$s on %2$s at %3$s', 'netfunktheme'),
            get_comment_author_link(),
            get_comment_date(),
            get_comment_time() );
            edit_comment_link(__('Edit', 'netfunktheme'), ' <span class="meta-sep"> | </span> <span class="edit-link">', '</span>');
      ?>
    </div>
	<?php 
      if ($comment->comment_approved == '0') {
          echo '\t\t\t\t\t<span class="unapproved">'; _e('Your trackback is awaiting moderation.', 'netfunktheme'); echo '</span>\n';
      }
	?>
    <div class="comment-content">
		<?php comment_text() ?>
    </div>
	<?php 
}


/* netfunktheme page title */
if (!function_exists( 'netfunktheme_page_title')){ 
	function netfunktheme_page_title($title) {
		if ($title == '') {
			return 'Untitled';
		} else {
			return $title;
		}
	}
}
add_filter('the_title', 'netfunktheme_page_title');


/* netfunktheme blog name */
if (!function_exists( 'netfunktheme_title_blogname')){
	function netfunktheme_title_blogname($title) {
		return $title . esc_attr(get_bloginfo('name')); }
}
add_filter('wp_title', 'netfunktheme_title_blogname');


/* netfunktheme default navigation menu */ 
if (!function_exists( 'netfunktheme_default_navigation')){
	function netfunktheme_default_navigation(){
	?><ul id="nav">
        <li <?php if (is_front_page()) { echo " class=\"current_page_item\""; } ?>><a href="<?php echo esc_url(home_url()); ?>" title="Home">Home</a></li>				
        <?php wp_list_pages('title_li=&sort_column=menu_order'); ?>
	  </ul>
	<?php
	
	}
}
add_action('netfunktheme_default_navigation','netfunktheme_default_navigation',1,0);


/* netfunktheme navigation menu */ 
if (!function_exists( 'netfunktheme_navigation_menu')){
	function netfunktheme_navigation_menu(){
		
		$is_nav = '' ;
		
		$defaults = array(
			'theme_location'  => 'primary',
			'menu'            => '',
			'container'       => false,
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'left',
			'menu_id'         => 'nav',
			'echo'            => false,
			'fallback_cb'     => '',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		);

		$is_nav = wp_nav_menu( $defaults );
		if ($is_nav == '') { 
			netfunktheme_default_navigation();
		 } else {
        	echo ($is_nav); 
		}
		
		/*  menu hack to support foundation .top-bar */
		echo '<script>
          (function($){
            $("#nav.left .menu-item-has-children").addClass(\'has-dropdown\');
            $("#nav.left .menu-item-has-children").addClass(\'not-click\');
            $("#nav.left .menu-item-has-children .sub-menu").addClass(\'dropdown\');
          });
	    </script>';
	}
}
add_action('netfunktheme_navigation_menu','netfunktheme_navigation_menu',1,0);


/* netfunktheme navigation menu */
if (!function_exists( 'netfunktheme_user_menu')){
	function netfunktheme_user_menu(){
	global $current_user;
	?>		
	
    <ul id="user" class="right">
	<?php  
		
		if ( is_user_logged_in()) { 
			printf( __('<li><a href="%1$s" data-tooltip class="user1 has-tip tip-bottom radius" title="Click to view your author page"><i class="fa fa-asterisk"></i> &nbsp; %2$s</a></li>', 'netfunktheme'), home_url() . '/?author='.$current_user->ID, $current_user->display_name ); 
	?>
        <li class="has-dropdown"><a href="#" class="link" title="Click here to view the blog control panel"><i class="fa fa-cog"></i> &nbsp; Control Panel</a>
            <ul class="user-nav-dropdown text-left dropdown">
                <?php $menu_list = do_action('netfunktheme_user_dropdown_menu'); ?>
            </ul>
        </li>

<?php } else { ?>
    <?php if (class_exists('WpPhpBB')){ ?>
        <li><a href="<?php echo home_url() ?>/forum/ucp.php?mode=register" class="signup" title="Click here to Sign-Up">Sign-Up</a></li>
     <?php } else { ?>
        <li><a href="<?php echo home_url() ?>/wp-signup.php" class="signup" title="Click here to Sign-Up">Create an Account</a></li>
     <?php }?>
     	<li class="has-dropdown"><a href="#" class="link">Sign In</a>
          <ul class="dropdown user-login-dropdown">
            <?php netfunktheme_login_form(); ?>
          </ul>
        </li>
	<?php } ?>
    </ul><?php
	}	
}
add_action('netfunktheme_user_menu','netfunktheme_user_menu',1,0);


/* netfunktheme user menu dropdown menu panel */
if (!function_exists( 'netfunktheme_user_dropdown_menu')){
	function netfunktheme_user_dropdown_menu(){
	
	if (!function_exists( 'netfunktheme_member_edit_link')){
	  if (!function_exists( 'netfunk_member_edit_link')){ ?>
        <li><a href="<?php echo home_url() ?>/wp-admin/profile.php" class="members"><i class="fa fa-user"></i> &nbsp; Profile Settings</a></li>
<?php }
	} ?>
    
    <li><a href="<?php echo home_url() ?>/wp-admin/" class="blog"><i class="fa fa-wordpress"></i> &nbsp; Control Panel</a></li>
    
	<?php if (class_exists('WpPhpBB')) {  
        $admin_url = wpbb_get_admin_link(); // currently logged in ?>	
        <li><a href="<?php echo home_url() ?>/forum/ucp.php" class="forum">Forum Control Panel</a></li>
        
     <?php if ( !empty( $admin_url ) )  ?>
        <li><a href="<? echo $admin_url ?>">phpBB Administration</a></li>
    <?php } ?>
    
    <li><a href="<?php echo home_url() ?>/wp-login.php?action=logout&redirect_to=<?php echo home_url() ?>" class="signup" title="Click here to Log-Out">Logout</a></li>

<?php }	
}
add_action('netfunktheme_user_dropdown_menu','netfunktheme_user_dropdown_menu',1,0);


/* netfunktheme top navigation login dropdown */
function netfunktheme_login_form( $args = array() ) {
	$defaults = array( 'echo' => true,
		'redirect' => site_url( $_SERVER['REQUEST_URI'] ), // Default redirect is back to the current page
		'form_id' => 'loginform',
		'label_username' => __( 'Username' ),
		'label_password' => __( 'Password' ),
		'label_remember' => __( 'Remember Me' ),
		'label_log_in' => __( 'Log In' ),
		'id_username' => 'user_login',
		'id_password' => 'user_pass',
		'id_remember' => 'rememberme',
		'id_submit' => 'wp-submit',
		'remember' => true,
		'value_username' => '',
		'value_remember' => false, // Set this to true to default the "Remember me" checkbox to checked
	);
	$args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );

	$form = '
		<form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . site_url( 'wp-login.php', 'login' ) . '" method="post">
			' . apply_filters( 'login_form_top', '' ) . '
			<div class="login-username">
				<label for="' . esc_attr( $args['id_username'] ) . '">' . esc_html( $args['label_username'] ) . '</label>
				<input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="input" value="' . esc_attr( $args['value_username'] ) . '" size="20" tabindex="10" />
			</div>
			<div class="login-password">
				<label for="' . esc_attr( $args['id_password'] ) . '">' . esc_html( $args['label_password'] ) . '</label>
				<input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="input" value="" size="20" tabindex="20" />
			</div>
			' . apply_filters( 'login_form_middle', '' ) . '
			' . ( $args['remember'] ? '<div class="login-remember"><label><input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever" tabindex="90"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . '</label></div>' : '' ) . '
			<div class="login-submit">
				<input type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="button small success radius right" value="' . esc_attr( $args['label_log_in'] ) . '" tabindex="100" />
				<input type="hidden" name="redirect_to" value="' . esc_attr( $args['redirect'] ) . '" />
			</div>
			' . apply_filters( 'login_form_bottom', '' ) . '
		</form>';

	if ( $args['echo'] )
		echo $form;
	else
		return $form;
}
add_action('netfunktheme_login_form','netfunktheme_login_form',1,0);


/* netfunktheme post-type sidebar options  */
if (!function_exists( 'netfunktheme_sidenoside')){
/* called to determine if the theme is using sidebars on the current post type */
  function netfunktheme_sidenoside( $type ) {

	global $theme_options,$netfunk_page_options,$netfunk_post_options;
	$class = 'large-';
	if ($type == 'frontpage')
	  $class .= (isset($theme_options['show_front_page_sidebar']) && $theme_options['show_front_page_sidebar'] == 'yes' ? '9' : '12');
	else if ($type == 'page')
	  $class .= (isset($netfunk_page_options['show_pages_sidebar']) && $netfunk_page_options['show_pages_sidebar'] == 'yes' ? '9' : '12');
	else if ($type == 'post')
	  $class .= (isset($netfunk_post_options['show_posts_sidebar']) && $netfunk_post_options['show_posts_sidebar'] == 'yes' ? '9' : '12');
	else
	  $class .= '9';

	echo $class;
	
  }
}
add_action('netfunktheme_sidenoside', 'netfunktheme_sidenoside');

/* netfunktheme comment reply javascript */
if (!function_exists( 'netfunktheme_comment_reply_js')){
  function netfunktheme_comment_reply_js() {
    if(get_option('thread_comments')) { 
      wp_enqueue_script('comment-reply');
    }
  }
}
add_action('comment_form_before', 'netfunktheme_comment_reply_js');

/* netfunktheme comment form defaults */
if (!function_exists( 'netfunktheme_comment_form_defaults')){
  function netfunktheme_comment_form_defaults( $args ) {
    $req = get_option( 'require_name_email' );
    $required_text = sprintf( ' ' . __('Required fields are marked %s', 'netfunktheme'), '<span class="required">*</span>' );
    $args['comment_notes_before'] = '<p class="comment-notes">' . __('Your email is kept private.', 'netfunktheme') . ( $req ? $required_text : '' ) . '</p>';
    $args['title_reply'] = __('Post a Comment', 'netfunktheme');
    $args['title_reply_to'] = __('Post a Reply to %s', 'netfunktheme');
    return $args;
	}
}
add_filter('comment_form_defaults', 'netfunktheme_comment_form_defaults');


/* netfunktheme page numbers */
function netfunktheme_get_page_number() {
  if (get_query_var('paged')) {
    print ' | ' . __( 'Page ' , 'netfunktheme') . get_query_var('paged');
  }
}

/* netfunktheme category lists */
function netfunktheme_catz($glue) {
	$current_cat = single_cat_title( '', false );
	$separator = "\n";
	$cats = explode( $separator, get_the_category_list($separator) );
	foreach ( $cats as $i => $str ) {
		if ( strstr( $str, ">$current_cat<" ) ) {
			unset($cats[$i]);
			break;
		}
	}
	if ( empty($cats) )
		return false;
	return trim(join( $glue, $cats ));
}

/* netfunktheme tags */
function netfunktheme_tag_it($glue) {
	$current_tag = single_tag_title( '', '',  false );
	$separator = "\n";
	$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );

	foreach ( $tags as $i => $str ) {
		if ( strstr( $str, ">$current_tag<" ) ) {
			unset($tags[$i]);
			break;
		}
	}
	
	if ( empty($tags) )
		return false;
	
	return trim(join( $glue, $tags ));
}

/* netfunktheme custom comments  */
function netfunktheme_custom_comments($comment, $args, $depth) {

	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
	
?>
	<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
    <div class="comment-author vcard"><?php netfunktheme_commenter_link() ?></div>
    <div class="comment-meta"><?php printf(__('Posted %1$s at %2$s', 'netfunktheme' ), get_comment_date(), get_comment_time() ); ?><span class="meta-sep"> | </span> <a href="#comment-<?php echo get_comment_ID(); ?>" title="<?php _e('Permalink to this comment', 'netfunktheme' ); ?>"><?php _e('Permalink', 'netfunktheme' ); ?></a>

	<?php edit_comment_link(__('Edit', 'netfunktheme'), ' <span class="meta-sep"> | </span> <span class="edit-link">', '</span>'); ?></div>
	<?php if ($comment->comment_approved == '0') { echo '\t\t\t\t\t<span class="unapproved">'; _e('Your comment is awaiting moderation.', 'netfunktheme'); echo '</span>\n'; } ?>
	
    <div class="comment-content">
		<?php comment_text() ?>
	</div>

	<?php

	if ($args['type'] == 'all' || get_comment_type() == 'comment') :
	
		comment_reply_link(array_merge($args, array(
		'reply_text' => __('Reply','netfunktheme'),
		'login_text' => __('Login to reply.', 'netfunktheme'),
		'depth' => $depth,
		'before' => '<div class="comment-reply-link">',
		'after' => '</div>'
		)));
	endif;
}


/* netfunktheme commenter link */
function netfunktheme_commenter_link() {

	$commenter = get_comment_author_link();

	if ( preg_match( '/<a[^>]* class=[^>]+>/', $commenter ) ) {
		$commenter = preg_replace( '/(<a[^>]* class=[\'"]?)/', '\\1url ' , $commenter );
	} 
	else {
		$commenter = preg_replace( '/(<a )/', '\\1class="url "' , $commenter );
	}
	
	$avatar_email = get_comment_author_email();
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}




/* "SMART" Stuff  

# What we mean by "smart" is that we attempt to take information 
# from the post content and format it in a more exciting way and 
# without much need for shortcodes or additional programming.

# If the post contains any number of the objects indcluding: 
# images, urls, video links, soundcloud or audio urls; we attempt 
# to manage content acordingy, formattnig and re-arranging,
# the page in a unified and ultimatly more expressive way.

# note: we hope to add smart "icons" for content previews
# to display any contained content from the post.

*/

/* netfunktheme "smart" capture page image */
function netfunktheme_catch_page_image($content) {
  global $page, $pages;
  $splash_img = '';
  ob_start();
  ob_end_clean();

  if ( has_post_thumbnail() ) {
	$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($page->ID), 'full');
    $splash_img = $image_url[0];
  } else {
    //$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
    //if (isset($matches [1][0]))
    //  $splash_img = $matches [1][0];
    if (empty($splash_img)) //Defines a default image
      $splash_img = get_stylesheet_directory_uri() . "/images/default-splash.jpg";
  }

  return $splash_img;
}

/* netfunktheme "smart" capture post image */
function netfunktheme_catch_post_image($post="") {

  global $post, $posts;
  $splash_img = '';
  ob_start();
  ob_end_clean();

  if ( has_post_thumbnail() ) {
      $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
      $splash_img = $image_url[0];
  } else {
      $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
      if (isset($matches [1][0]))
          $splash_img = $matches [1][0];
      if (empty($splash_img)) //Defines a default image
          $splash_img = get_stylesheet_directory_uri() . "/images/default-splash.jpg";
  }
  return $splash_img;
}


/* netfunktheme "smart" content stipper */
function netfunktheme_content_strip_objects( $postOutput ) {
   $postOutput = preg_replace('/<a[^>]+./','', $postOutput);
   $postOutput = preg_replace('/<img[^>]+./','', $postOutput);
   $postOutput = preg_replace('/<iframe[^>]+./','', $postOutput);
   $postOutput = preg_replace('/\[soundcloud[^\]]+./','', $postOutput);
   return $postOutput;
}


/* netfunktheme "smart" image stipper */
function netfunktheme_remove_image( $content ) {
   $postOutput = preg_replace('/<img[^>]+./','', $content);
   return $postOutput;
}


/* netfunktheme "smart" length */
function netfunktheme_get_words($text, $limit) {
	$array = explode(" ", $text, $limit+1);
	if (count($array) > $limit) {
		unset($array[$limit]);
	}
	return implode(" ", $array);
}


/* netfunktheme "smart" featured content */
/* netfunk splash image shortcode */
//add_shortcode( 'myshortcode', 'my_shortcode_handler' );  ~ helper comment
function splash_img_callback( $atts, $content = null  ) {
	extract( shortcode_atts( array(
		'top' => 'top',
		'align' => 'center',
	), $atts ) );
	
	return '<span class="splash '.$top.' '.$align.'">' . $content . '</span>';
}
add_shortcode( 'splash', 'splash_img_callback' );


/* netfunktheme splash image disaply */
function netfunktheme_get_pages_splash($per_page=4,$offset=0,$page_id,$height=400){
	global $page, $pages;
?>
<div class="slideshow-wrapper"<?php echo ' style="height:' . $height .'px; min-height:' . $height .'px;" ' ?>>
        <!--div class="preloader"></div-->
        <ul data-orbit data-options="
            animation:fade;
            animation_speed:1000;
            pause_on_hover:false;
            resume_on_mouseout:false;
            slide_number:false;
            navigation_arrows:false;
            bullets:true;
            variable_height:true;">
     
        <?php
        $mypages = get_pages();
		$n = 1;

        foreach ( $mypages as $page ) :
            $image = netfunktheme_catch_page_image( $page->post_content );
			if ($page_id == $page->ID){
        ?>
		<li data-orbit-slide="headline-<?php echo $n ?>" style="background-image:url('<?php echo $image ?>'); height: <?php echo $height ?>px; min-height: <?php echo $height ?>px;"> </li>
    <?php
			}
			$n ++;
        endforeach; 
    ?>
    </ul>
</div>
<?php
}


/* netfunktheme "smart" featured content */
function netfunktheme_get_large_featured($per_page=4,$offset=0,$category_id=0,$height=400){
	global $post, $posts, $page, $pages;
?>
<div class="slideshow-wrapper"<?php echo ' style="height:' . $height .'px; min-height:' . $height .'px;" ' ?>>
	<div class="preloader"></div>
    	<ul data-orbit data-options="
        animation:fade;
        animation_speed:1000;
        pause_on_hover:false;
        resume_on_mouseout:false;
        slide_number:false;
        navigation_arrows:false;
        bullets:true;
        variable_height:true;">
     
      <?php
        $args = array( 'posts_per_page' => $per_page, 'offset'=> $offset, 'category' => $category_id ); // FEATURED CATEGORY - HARD CODED
        $myposts = get_posts( $args );
		$n = 1;
	
        foreach ( $myposts as $post ) :
			setup_postdata( $post );
            $image = netfunktheme_catch_post_image();
            $content = get_the_content();
      ?>
            <li data-orbit-slide="headline-<?php echo $n ?>" style="background-image:url('<?php echo $image ?>'); height: <?php echo $height ?>px; min-height: <?php echo $height ?>px;">
                <div class="orbit-caption">
					<div class="row">
						<div class="large-12">
                            <h2><?php the_title() ?></h2>
                            <p><?php echo wp_trim_words(netfunktheme_content_strip_objects($content),30, '...') ?></p>
                            <a href="<?php the_permalink(); ?>" class="">Read More</a>
                        </div>
                    </div>
                </div>
            </li>
    <?php
		    $n ++;
        endforeach;
        wp_reset_postdata();
    ?>
    </ul>
</div>
<?php
}


/* netfunktheme author page info */
function netfunktheme_author_page_info() {
	$user_id = get_the_author_meta( 'ID' );
	if ( get_the_author_meta( 'description' ) || get_the_author_meta( 'netfunktheme_about' ) ) { 
		$user_description1 = ( get_the_author_meta('netfunktheme_about') != '' ? get_the_author_meta('netfunktheme_about') : get_the_author_meta('description') );
		$user_description2 = ( get_the_author_meta('netfunktheme_more_about') != '' ? get_the_author_meta('netfunktheme_more_about') : '' );
	?>
    	<div class="large-3 small-12 left author-avatar">
		<?php
            /* Author Image */
			do_action('netfunktheme_author_image', $atts = array('user_id'=>$user_id,'size'=>240));
        ?>
        </div>
        <br class="clear" /> 
        <br />
        <br />
        <div class="author-description">
            <h4><?php printf( __( 'About %s', 'netfunktheme' ), get_the_author() ); ?></h4>
			<div class="panel radius">
            <p><?php echo $user_description1 ?></p>
            <?php echo ($user_description2 != '' ? '<p>'.$user_description2.'</p>' : '') ?>
            <?php if (get_page_by_title('Contact Us') || get_page_by_title('Contact') || get_page_by_title('contact')){  ?>
                <br />
                <a href="<?php echo home_url() . '/contact/' ?>" class="button small radius success right">
                <?php printf( __( ' Contact %s', 'netfunktheme' ), get_the_author() ); ?>
                </a>
            <?php } ?>
			<br class="clear" />
			</div>
        </div>
    <?php
	}
}
add_action('netfunktheme_author_page_info', 'netfunktheme_author_page_info',1,0);


/* netfunktheme author avatar */
function netfunktheme_author_avatar($atts){
	extract( shortcode_atts( array(
		'user_id' => '0',
		'size' => '96'
	), $atts ) );
	
	$default = '/images/avatar.jpg';
	echo get_avatar( $atts['user_id'], $atts['size'], $default );
}
add_action('netfunktheme_author_image','netfunktheme_author_avatar',1,1);


/* netfunktheme about the author panel */
function netfunktheme_about_the_author (){
  $user_id = get_the_author_meta( 'ID' );
  $user_description1 = ( get_the_author_meta('netfunktheme_about') ? get_the_author_meta('netfunktheme_about') : get_the_author_meta('description') );
?>
    
    <div class="panel callout hide-for-small clearfix about-author">
        <div class="small-12 large-2 left center-for-small netfunktheme_author_avatar">
		    <?php do_action('netfunktheme_author_image', $atts = array('user_id'=>$user_id,'size'=>150));  ?>
        </div><!-- .author-avatar -->

        <div class="small-12 large-10 right author-description netfunktheme_about_card">
            <div class="small-12 columns clearfix">
                <h6>About The Author</h6>
                <h4 class="author-title"><?php printf( __( '%s', 'netfunktheme' ), get_the_author() ); ?></h4>
                <p><?php echo $user_description1 ?></p>

                <?php if (get_page_by_title('Contact Us') || get_page_by_title('Contact') || get_page_by_title('contact')){  ?>
                    <a href="<?= home_url() . '/contact/' ?>">
                    <?php
                        printf( __( ' Contact %s', 'netfunktheme' ), get_the_author() );
                    ?>
                    </a>
                <?php } ?>
             </div>
             <a href="<?php echo home_url() . '/author/'.get_the_author_meta('user_nicename',$user_id) ?>" class="button tiny round secondary right">More About the Author</a>
        </div>
    </div>
    <br />
<?php
}
add_action('netfunktheme_about_the_author','netfunktheme_about_the_author',1,0);


/* register themfunk javascript  */
function themefunk_register_js( ){
    //wp_dequeue_script( 'jquery');
    //wp_deregister_script( 'jquery');
    //wp_register_script('jquery2', get_template_directory_uri() . '/assets/js/jquery/jquery.js', array('jquery'), 'jquery', '', false);
    wp_register_script('foundation', get_template_directory_uri() . '/assets/js/foundation/foundation.js', array('jquery'), 'jquery', '', false);
    wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr.js', array('jquery'), 'jquery', '', false);
    wp_register_script('fastclick', get_template_directory_uri() . '/assets/js/fastclick/fastclick.js', array('jquery'), 'jquery', '', false);
    wp_register_script('fastclick', get_template_directory_uri() . '/assets/js/fastclick/fastclick.js', array('jquery'), 'jquery', '', false);
    //wp_enqueue_script('jquery2');
    wp_enqueue_script('foundation');
    wp_enqueue_script('modernizr');
    wp_enqueue_script('fastclick');
}
add_filter( 'wp_enqueue_scripts', 'themefunk_register_js', PHP_INT_MAX );


/* Init Foundation 5 */
function netfunktheme_foundation_init() {
  if ( !is_admin() ) {
    echo '<script>
    (function($){
      $(document).ready(function($) {

        $(document).foundation();

        $(window).trigger("resize");

         // var thumbWidth = $(".home-block-content a").width() - 2;
         // $(".home-block-content .home-block-img").height(thumbWidth)

      });
    });
  
  </script>';
  }
}
add_action( 'wp_footer', 'netfunktheme_foundation_init');


/* netfunktheme custom javascript (header) */
if (!function_exists( 'netfunktheme_custom_javascript_top')){
	function netfunktheme_custom_javascript_top() {
		global $script_options;
		if (!empty($script_options['javascript_top']))
		echo '<script type="text/javascript">'
		. $script_options['javascript_top']
		. '</script>';
	}
}
add_action('wp_head', 'netfunktheme_custom_javascript_top');


/* netfunktheme custom javascript (footer) */
if (!function_exists( 'netfunktheme_custom_javascript_bottom')){
	function netfunktheme_custom_javascript_bottom() {
		global $script_options;
		if (!empty($script_options['javascript_bottom']))
		echo '<script type="text/javascript">'
		. $script_options['javascript_bottom']
		. '</script>';
	}
}
add_action('wp_footer', 'netfunktheme_custom_javascript_bottom');


/* register netfunktheme style sheets  */
function netfunktheme_theme_styles() {
    wp_register_style( 'normalize', get_template_directory_uri() . '/assets/css/foundation/normalize.css' );
	wp_register_style( 'foundation', get_template_directory_uri(). '/assets/css/foundation/foundation.css' );
	wp_register_style( 'fontawesome', get_template_directory_uri() . '/assets/css/fontawesome/font-awesome.css' );
	//wp_register_style( 'webicons', get_template_directory_uri() . '/css/webicons.css' );
	wp_enqueue_style( 'normalize' );
	wp_enqueue_style( 'foundation' );
	wp_enqueue_style( 'fontawesome' );
	//wp_enqueue_style( 'webicons' );
}
add_action('wp_print_styles', 'netfunktheme_theme_styles');


/* register netfunktheme css  */
function netfunktheme_theme_css() {
	wp_register_style( 'netfunktheme-style', get_stylesheet_uri() );
	wp_enqueue_style( 'netfunktheme-style' );
	
}
add_action('wp_print_styles', 'netfunktheme_theme_css');


/* netfunktheme cutom css action */
if (!function_exists( 'netfunktheme_custom_css')){
	function netfunktheme_custom_css() {
		global $script_options;
		if (!empty($script_options['custom_css']))
		echo '<style type="text/css">'
		. $script_options['custom_css']
		. '</style>';
	}
}
add_action('wp_head', 'netfunktheme_custom_css');


/* register netfunktheme widgets (widgets.php) */
function netfunktheme_widgets_addon() {
	register_widget('Netfunk_Featured_Pages');
	register_widget('Netfunk_Labels_Info');
	register_widget('Netfunk_Homepage_Categories');
	register_widget('Netfunk_Categories_Widget');
}
add_action('widgets_init', 'netfunktheme_widgets_addon', 1);


/* register netfunktheme sidebars */
function netfunktheme_widgets_init() {
	// LEFT SIDEBAR
	register_sidebar( array(
		'name' => __( 'Primary Sidebar', 'netfunktheme' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'netfunktheme' ),
		'before_widget' => '<li id="%1$s" class="widget-content %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',));
	register_sidebar( array(
		'name' => __( 'Secondary Sidebar', 'netfunktheme' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'netfunktheme' ),
		'before_widget' => '<li id="%1$s" class="widget-content %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',));
	register_sidebar( array(
		'name' => __( 'Action Page Sidebar', 'netfunktheme' ),
		'id' => 'action-widget-area',
		'description' => __( 'Action pages widget area', 'netfunktheme' ),
		'before_widget' => '<li id="%1$s" class="widget-content %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',));
	// CONTENT SIDEBARS
	register_sidebar( array(
		'name' => __( 'Front Page Content Widgets', 'netfunktheme' ),
		'id' => 'home-primary-widget-area',
		'description' => __( 'Front page content widget area.', 'netfunktheme' ),
		'before_widget' => '<div id="%1$s" class="widget-content %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="home-title"><div class="row"><h2 class="widget-title">',
		'after_title' => '</h2></div></div>',));
	register_sidebar( array(
		'name' => __( 'Page Bottom Content Widgets', 'netfunktheme' ),
		'id' => 'home-bottom-widget-area',
		'description' => __( 'Bottom of page content widget area', 'netfunktheme' ),
		'before_widget' => '<div id="%1$s" class="widget-content %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',));
	// FOOTER SIDEBARS
	register_sidebar( array(
		'name' => __( 'Footer Widget Area', 'netfunktheme' ),
		'id' => 'footer-widget-area',
		'description' => __( 'Footer widget area', 'netfunktheme' ),
		'before_widget' => '<li id="%1$s" class="small-4 left widget-content %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',));
}
add_action( 'widgets_init', 'netfunktheme_widgets_init' );

// EOF
