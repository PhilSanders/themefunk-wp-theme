<?php 

  /* get the author id */
  $user_id = get_the_author_meta( 'ID' );

  get_header(); 

?>
<div id="container" class="content-padding">

  <div class="content clearfix">

    <div class="row">

      <div class="large-9 small-12 columns left">

        <div class="small-12 author-info">
          <?php do_action( 'netfunktheme_author_page_info'); ?>
        </div>

        <?php the_post(); ?>

        <br class="clear" />

        <h4><?php printf( __( 'Posts by %s', 'netfunktheme' ), $authordata->display_name ) ?></h4>

        <?php rewind_posts(); ?>

        <div class="panel radius">

          <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'template/entry-list', get_post_format() ); ?>

          <?php endwhile; ?>

          <br />

        </div>
        
		<?php get_template_part( 'template/nav-below', get_post_format() ); ?>

      </div>

      <?php get_sidebar(); ?>

    </div>

  </div>

</div>

<?php get_footer(); ?>

