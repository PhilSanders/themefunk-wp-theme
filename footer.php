
  </div><!-- wrapper -->

<footer>

  <div class="row">

    <div class="small-12 columns">

      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/logo1.png" alt="" border="0"/></a>

    </div>

    <div class="small-12 columns hide-for-small">

      <?php get_sidebar( 'footer' ) ?>

    </div><!--footer widget end-->

    <br class="clear"/>

    <div class="small-12 columns copyright">

      <?php echo sprintf( __( '%1$s %2$s %3$s. All Rights Reserved.', 'netfunktheme' ), '&copy; 2008-', date('Y'), esc_html(get_bloginfo('name')) ); ?>

    </div>

    </div>

</footer>

<?php wp_footer(); ?>

<!-- end off-canvas-code -->
  </section>  </div> </div>
<!-- off-canvas-code-end -->

</body>

</html>