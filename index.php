<?php
/*
 theme default index
*/

?>

<?php get_header(); ?>

<div id="container">

<?php 

  if (!isset($_GET['action'])):

	$category_id = (isset($category_id) ? $category_id : 0);
	netfunktheme_get_large_featured($netfunk_general_options['show_num_features'],$offset=0,$category_id,$netfunk_general_options['splash_height']); 

  endif;

?>

<?php if ( (isset($theme_options['show_welcome_message']) && $theme_options['show_welcome_message'] == 'yes') or (isset($theme_options['show_featured_content']) && $theme_options['show_featured_content'] == 'yes') ){ ?>

<div class="content clearfix">

    <div class="row">

        <div class="small-12 frontpage-content clearfix">

          <?php if ( isset($theme_options['show_welcome_message']) && $theme_options['show_welcome_message'] == 'yes' ){ ?>

            <div class="small-12 large-<?php echo (isset($theme_options['show_featured_content']) && $theme_options['show_featured_content'] == 'yes' ? '4' : '12') ?> columns welcome-message">

                <div class="small-12">
                   
                    <h1><?php echo ( isset($theme_options['welcome_title']) ? $theme_options['welcome_title'] : '' ) ?></h1>
                    
                    <p class="welcome-text">
                        <?php echo ( isset($theme_options['welcome_text']) ? $theme_options['welcome_text'] : '' ) ?>
                    </p>
                
                </div>

                <?php if (isset($theme_options['more_about_title']) && isset($theme_options['more_about_uri'])){ ?>
                    
                    <div class="small-12 text-center">
                    
                        <a href="<?php echo home_url() . $theme_options['more_about_uri'] ?>" class="button success small round"><?php echo (isset($theme_options['more_about_title']) ? $theme_options['more_about_title'] : ''); ?></a>
                    
                    </div>
				
				<?php } ?>

            </div>

          <?php } ?>

        <?php if ( isset($theme_options['show_featured_content']) && $theme_options['show_featured_content'] == 'yes'){ ?>

            <div class="small-12 large-<?php echo (isset($theme_options['show_welcome_message']) && $theme_options['show_welcome_message'] == 'yes' ? '8' : '12') ?> right featured-content">
                <div class="small-12 columns" data-equalizer>
                <?php if ( is_active_sidebar( 'home-primary-widget-area' ) ) : ?>
                    <?php if ( ! dynamic_sidebar( 'home-primary-widget-area' ) ) : ?>
                        <h4> You need to add some widgets... </h4>
                     <?php endif; // end primary widget area ?>
                    <br class="clear" />
                <?php else: ?>
                	<div class="small-12 columns">
						<h2 class="widget-title">Featured Content Area</h2>
                    	<h4> You may want to add one of our featured content widgets here</h4> 
                    	<p class="first-text">You might also wish to remove the area all togeather. This area and the welcome message  share the content width. Removing one or the other makes the other one take over the full width of the area. </p>
                    	<a href="<?php echo home_url().'/wp-admin/widgets.php' ?>">Add Widgets</a> | <a href="<?php echo home_url() .'/wp-admin/admin.php?page=theme_frontpage#featured-contet' ?>">Modify Settings</a>
                    </div>
                    <div class="small-12 columns">
                    	<br class="clear"/>
                        <br />
                        <a href="#docs" class="button radius">NetfunkTheme Docs</a>
                    </div>
                    <br class="clear" />
				<?php endif; ?>
                </div>
            </div><!-- featured content -->

        <?php } ?>

        </div>

    </div>
   
</div><!-- content -->

<?php } ?>

<div class="page-bottom-content clearix">

	<div class="row">

		<div class="small-12 <?php do_action('netfunktheme_sidenoside', 'frontpage') ?> columns">
        
		<?php if (isset($theme_options['show_posts_on_home']) && $theme_options['show_posts_on_home'] == 'yes'){ ?>
			
            <div class="small-12 clearfix recent-posts">
            
              <h2 class="widget-title">Recent Posts</h2>
          
              <?php while ( have_posts() ) : the_post() ?>
              
			    <?php  get_template_part( 'template/entry-list', get_post_format() ); ?>
            
			  <?php endwhile; ?>
            
            </div>

    	<?php } ?>

		<?php if (isset($theme_options['show_front_page_bottom_content']) && $theme_options['show_front_page_bottom_content'] == 'yes') { ?>

			<div class="small-12 clearfix bottom-content">

            <?php if ( is_active_sidebar( 'home-bottom-widget-area' ) ) : ?>
             
                <?php if ( ! dynamic_sidebar( 'home-bottom-widget-area' ) ) { ?>
                <h4> You need to add some widgets... </h4>
                <br class="clear" />
                <?php } ?>
            
			<?php else: ?>
            
                <h2 class="widget-title">Page bottom Content Area</h2>
                <h4> You can add Widgets to the bottom of pages or disable this area completely.</h4>
                <a href="<?php echo home_url().'/wp-admin/widgets.php' ?>">Add Widgets</a> | <a href="<?php echo home_url() .'/wp-admin/admin.php?page=theme_frontpage#page-bottom' ?>">Modify Front Page Settings</a>
            	<br class="clear"/>
                <br />
                <hr />
                <h2 class="widget-title">Recommended Plugins</h2>
                <p> We have worked hard to make NetfunkTheme compatible with a lot of popular addons. Here are a few addons we highly recommended, to help you manage your content better.</p>
                <div class="small-12">
                	<h4 style="color: #BBB">A few suggestions</h4>
                    <br />
                    <ul class="large-5 columns left">
                    	<li><i class="fa fa-plus-circle"></i> &nbsp; Jetpack</li>
                        <li><i class="fa fa-plus-circle"></i> &nbsp; Dynamic Widgets</li>
                        <li><i class="fa fa-plus-circle"></i> &nbsp; Link Manager</li>
                    </ul>
                    <ul class="large-5 columns left">
                    	<li><i class="fa fa-plus-circle"></i> &nbsp; Contact Form 7</li>
                        <li><i class="fa fa-plus-circle"></i> &nbsp; Advanced Most Recent Posts Mod</li>
                        <li><i class="fa fa-plus-circle"></i> &nbsp; Soundcloud Connect by Netfunk</li>
                    </ul>
                    <br class="clear" />
                </div>
                <br />
                <a href="<?php echo home_url().'/wp-admin/widgets.php' ?>">Go To Plugins Settings</a> 
                <br class="clear"/>
                <br />
                <hr />
                <div class="small-12 columns">
                	<div class="panel radius">To get ride of this conent add some widgets or disable Page Bottom content in <a href="<?php echo home_url() .'/wp-admin/admin.php?page=theme_frontpage#page-bottom' ?>">Theme settings</a></div>
				</div>

			<?php endif; ?>
            
            </div> 

        <?php } ?>

		</div>

        <?php if ( isset($theme_options['show_front_page_sidebar']) && $theme_options['show_front_page_sidebar'] == 'yes' ){
        
		if ( (isset($theme_options['show_front_page_primary_sidebar']) && $theme_options['show_front_page_primary_sidebar'] == 'yes') or (isset($theme_options['show_front_page_secondary_sidebar']) && $theme_options['show_front_page_secondary_sidebar'] == 'yes') )
		
			get_sidebar(); 
		
		} ?>

    </div>
    
  </div><!-- page bottom content -->

</div><!-- container -->

<?php get_footer(); ?>
