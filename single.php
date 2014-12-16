<?php 
/*
 	netfunktheme single post
*/
?>

<?php get_header(); ?>

<div id="container">

<?php global $netfunk_post_options; ?>

<?php

  /* Posts Page Spash Image display
  # 	0 = Splash Img | Hide Thumbnail
  # 	1 = Splash Img + Show Thumbnail 
  # 	2 = No Splash | Hide Thumbnail 
  # 	3 = No Splash + Show Thumbnail 
  */

  // determine if we are using splash images

  if ( isset( $netfunk_post_options['posts_splash_type'] ) && ( $netfunk_post_options['posts_splash_type'] <= 1 ) ) { 

    $splash_image = netfunktheme_catch_post_image();

?>

  <div class="large-12 featured-entry hide-for-small">

    <div class="featured-image-bg" style="background-image: url('<?php echo $splash_image ?>'); "></div>

  </div>

<?php } ?>


<?php 

  if ( have_posts() ): 
	 
    while ( have_posts() ): 
	 
      the_post();
 
?>
	<div class="content clearfix">

      <div class="row">

	    <div class="small-12 <?php do_action('netfunktheme_sidenoside', 'post') ?> columns">
          
          <h3> <?php the_title(); ?>  </h3>
                
          <?php edit_post_link( __( '<i class="fa fa-pencil"></i> &nbsp; Edit this post', 'netfunktheme' ), '<div class="button secondary round tiny right edit-link">', '</div>' ) ?>
                
           <?php  get_template_part( 'template/entry', 'meta' ); ?>

		  <h2 class="show-for-small"> <?php echo the_title(); ?> </h2>

    	  <?php 
            
			if ( (isset($netfunk_post_options['show_nav_above']) && $netfunk_post_options['show_nav_above'] == 'yes') or (!isset($netfunk_post_options['show_nav_above'])) ) {

				get_template_part( 'template/nav', 'above-single' );
			
			}

		  ?>

          <hr />
		
		  <?php  get_template_part( 'entry' );  ?>

		  <?php 
                
            if ( (isset($netfunk_post_options['show_post_footer_meta']) && $netfunk_post_options['show_post_footer_meta'] == 'yes') or (!isset($netfunk_post_options['show_post_footer_meta'])) ) {

                get_template_part( 'template/entry-footer-single', get_post_format() );
            
            }
        
          ?>


        <div class="small-12 clearfix">   

		 <?php 
        
            if ( (isset($netfunk_post_options['show_nav_below']) && $netfunk_post_options['show_nav_below'] == 'yes') or (!isset($netfunk_post_options['show_nav_below'])) ) {

                get_template_part( 'template/nav', 'below-single' );
            
            }
        
        ?>

        </div>

          <div class="small-12 entry-comments">

              <?php 
					
				if ( (isset($netfunk_post_options['show_post_comments']) && $netfunk_post_options['show_post_comments'] == 'yes') or (!isset($netfunk_post_options['show_post_comments'])) ) {
					
					comments_template( '', true ); 
					
				}
				
			  ?>
        
            </div>
          
 
          <?php 
					
			if ( (isset($netfunk_post_options['show_post_author']) && $netfunk_post_options['show_post_author'] == 'yes') or (!isset($netfunk_post_options['show_post_author']))) {

				do_action( 'netfunktheme_about_the_author');
			
			}
		
		  ?>

      </div>


    <?php 
        
      if ( (isset($netfunk_post_options['show_posts_sidebar']) && $netfunk_post_options['show_posts_sidebar'] == 'yes') or (!isset($netfunk_post_options['show_posts_sidebar'])) ){
		get_sidebar(); 
	  } 
	
    ?>

    </div>

  </div>

<?php if ( is_active_sidebar( 'home-bottom-widget-area' ) ) : ?>
		
 <?php if ( (isset($netfunk_post_options['show_post_bottom_content']) && $netfunk_post_options['show_post_bottom_content'] == 'yes') or (!isset($netfunk_post_options['show_post_bottom_content']))) { ?>

   <div class="page-bottom-content clearix">

    <div class="row">
    
      <div class="class-12 columns">

        <?php if ( ! dynamic_sidebar( 'home-bottom-widget-area' ) ) : ?>
    
          <h4> You need to add some widgets... </h4>
    
        <?php endif; // end primary widget area ?>
    
      </div>
    
     </div>
   
  </div>

  <?php } ?>
        
 <?php endif; ?>

<?php endwhile; ?>

<?php endif; ?>

</div>

<?php get_footer(); ?>
