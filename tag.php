
<?php get_header(); ?>

<div id="container" class="content-padding">

	<div class="content">

        <div class="row">

            <div class="small-12 large-9 columns left">

              <?php the_post(); ?>

              <h1 class="page-title"><?php _e( 'Tag Archives:', 'netfunktheme' ) ?> <span><?php single_tag_title() ?></span></h1>

              <?php rewind_posts(); ?>

              <?php get_template_part( 'template/nav', 'above' ); ?>

              <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'entry' ); ?>

              <?php endwhile; ?>

              <?php get_template_part( 'template/nav', 'below' ); ?>

            </div>

            <?php get_sidebar(); ?>

       </div>
 
    </div>

  </div>

<?php get_footer(); ?>
