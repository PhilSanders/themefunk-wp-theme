
<?php get_header(); ?>

<div id="container" class="content-padding">

  <div class="content">
    
    <div class="row">

        <div class="small-12 large-9 columns">
        
        	<h2 class="page-title"><?php printf( __( 'Search Results for: %s', 'netfunktheme' ), '<span>' . get_search_query()  . '</span>' ); ?></h2>

        	<?php netfunktheme_breadcrumbs() ?>

            <?php if ( have_posts() ) : ?>
            
            <br />

            <?php get_search_form(); ?>
            
            <hr />
            
            <?php get_template_part( 'template/nav', 'above' ); ?>
            
            <?php while ( have_posts() ) : the_post() ?>
            
            <?php get_template_part( 'entry' ); ?>
            
            <?php endwhile; ?>
            
            <?php get_template_part( 'template/nav', 'below' ); ?>
            
            <?php else : ?>
            
            <div id="post-0" class="post no-results not-found">
            
                <h2 class="entry-title"><?php _e( 'Nothing Found', 'netfunktheme' ) ?></h2>
                
                <div class="entry-content">
                
                <p><?php _e( 'Sorry, nothing matched your search. Please try again.', 'netfunktheme' ); ?></p>
                
                <?php get_search_form(); ?>
            
                </div>
            
            </div>
            
            <?php endif; ?>
        
        </div>

        <?php get_sidebar(); ?>
    
      </div>
    
    </div>

</div>

<?php get_footer(); ?>
