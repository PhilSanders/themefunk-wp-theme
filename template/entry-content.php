<div class="entry-content">

<?php global $authordata, $splash_image, $netfunk_post_options; ?>

<?php 

/* Posts Page Spash Image display

  # 	0 = Splash Img | Hide Thumbnail
  # 	1 = Splash Img + Show Thumbnail 
  # 	2 = No Splash | Hide Thumbnail 
  # 	3 = No Splash + Show Thumbnail 
  */

	if (isset($netfunk_post_options['posts_splash_type']) && $netfunk_post_options['posts_splash_type'] == 0) {
		// Splash Image 
		// do not display thumbnail image

	} else if (isset($netfunk_post_options['posts_splash_type']) && $netfunk_post_options['posts_splash_type'] == 1) {
		// Splash Image 
		// also show thumbnail image
		if ( has_post_thumbnail() ) { 
		  the_post_thumbnail('thumbnail', array('class' => 'left'));
		}

	} else if (isset($netfunk_post_options['posts_splash_type']) && $netfunk_post_options['posts_splash_type'] == 2) {
		// hide thumbnail 

    } else if (isset($netfunk_post_options['posts_splash_type']) && $netfunk_post_options['posts_splash_type'] == 3) {
		// thumbnail only
		if ( has_post_thumbnail() ) { 
		  the_post_thumbnail('thumbnail', array('class' => 'left'));
		}

	} else if (!isset($netfunk_post_options['posts_splash_type'])){
		// option not yet set. falls back to defaut: 'yes'
		// Splash Image 
		// do not show thumbnail
	}

?>	
	
<?php the_content(); ?>

<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'netfunktheme' ) . '&after=</div>') ?>

<div class="clear"></div>

</div>
