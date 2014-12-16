<?php

/*
Template Name: Page (No Sidebar)
*/

?>

<?php get_header(); ?>

<div id="container" class="content-padding">

  <div class="content">
    
    <div class="row">
    
		<div class="small-12 columns">

			<?php the_post(); ?>
            
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			  <h1 class="entry-title"><?php the_title(); ?></h1>

              <div class="entry-content">
            
                <?php 
                if ( has_post_thumbnail() )
            		the_post_thumbnail();
                ?>
            
                <?php the_content(); ?>
            
                <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'netfunktheme' ) . '&after=</div>') ?>

              </div>
            
            </div>

        </div>

	</div>

  </div>

</div>

<?php get_footer(); ?>
