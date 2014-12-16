
<?php get_header(); ?>

<div id="container" class="content-padding">

  <div class="content clearfix">

    <div class="row">

      <div class="small-12 large-9 columns">

        <div id="post-0" class="post error404 not-found">

          <h1 class="entry-title"><?php _e('Page Not Found', 'netfunktheme'); ?></h1>

          <div class="entry-content">

            <p><?php _e('Nothing found for the requested page. Try a search instead?', 'netfunktheme'); ?></p>

            <div class="large-6 columns">

              <?php get_search_form(); ?>

            </div>

          </div>

        </div>

      </div>

      <?php get_sidebar(); ?>

    </div>

  </div>

</div>

<?php get_footer(); ?>