
<?php global $authordata; ?>

<?php  $image = netfunktheme_catch_post_image(); ?>

<div class="large-3 small-12 columns left home-block minimal">

  <div class="home-block-content" data-equalizer-watch>

      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( __('%s', 'netfunktheme'), the_title_attribute('echo=0') ) ?>">

          <div class="home-block-img" style="background: url('<?php echo $image ?>')"></div>

	      <h4 class="home-block-title"> <?php the_title(); ?> </h4>

        </a>

        <div class="home-block-meta hide-for-small">By: <?php the_author(); ?>  On: <?php the_time( get_option( 'date_format' ) ); ?></div>

      </div>
    
     <!--a href="<?php the_permalink(); ?>" rel="bookmark" class="button tiny success round right">Read More</a-->
    
  </div>

</div> 