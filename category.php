<?php get_header(); ?>

<?php the_post(); ?>

<div id="container"<?php echo (isset($_GET['action']) ? ' class="content-padding"' : '') ?>>

<?php 

  $category_id = get_cat_ID( single_cat_title("",false) ); 
  $category_link = get_category_link( $category_id );

?>

<?php 

  if (!isset($_GET['action'])):

	echo '<div class="slideshow large-12 show-for-medium-up">';
	
	  netfunktheme_get_large_featured($per_page=4,$offset=0,$category_id,$netfunk_general_options['splash_height']); 
	
	echo '</div>';

  endif;

?>

  <div class="content clearfix">

    <div class="row">

      <div class="<?php echo (!isset($_GET['action']) ? "large-12" : "large-9") ?> small-12 columns">

        <div class="display-mode-menu clearfix">

          <div class="large-6 left">
    
            <h1 class="page-title"><?php single_cat_title() ?></h1>
    
          </div>
    
          <div class="large-6 hide-for-small right display-mode">
        
              <dl class="sub-nav right">
                <dt>View:</dt>
                <dd <?php echo (!isset($_GET['action']) ? ' class="active"' : '') ?>><a href="<?php echo $category_link ?>">Minimal</a></dd>
                <dd <?php echo (isset($_GET['action']) && $_GET['action'] == 'list' ? ' class="active"' : '') ?>><a href="<?php echo $category_link . "?action=list" ?>">List</a></dd>
                <dd <?php echo (isset($_GET['action']) && $_GET['action'] == 'expand' ? ' class="active"' : '') ?>><a href="<?php echo $category_link . "?action=expand" ?>">Expand</a></dd>
                <!--dd><a href="#" data-dropdown="moreDropdown1" data-options="is_hover:true">More</a>
                <ul id="moreDropdown1" class="f-dropdown" data-dropdown-content>
                  <li><a href="/archives/">Archives</a></li>
                  <li><a href="/search/">Search</a></li>
                  <li><a href="/category/">More Categories</a></li>
                </ul>
                </dd-->
              </dl>
    
            </div>

          </div><!-- sort menu -->

          <?php 
		  
		    // add an HR tag
		    echo ( !isset($_GET['action']) ? "" : "<hr />" );
		  
		  ?>

          <a name="middle"></a>

          <?php echo (isset($_GET['action']) ? "" : "") ?>

          <?php $categorydesc = category_description(); 

          if ( !empty($categorydesc) ) 

          echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>

          <?php rewind_posts(); ?>

          <?php 

          if (isset($_GET['action']))
            get_template_part( 'template/nav', 'above' ); 

          ?>

          <?php while ( have_posts() ) : the_post(); ?>

            <?php 

            switch((isset($_GET['action']) ? $_GET['action'] : 'default')) {
            
            default: 
              get_template_part( 'template/entry-minimal', get_post_format() );
              break;
    
            case "expand":
              get_template_part( 'template/entry-expand', get_post_format() );
              break;
    
            case "list":
              get_template_part( 'template/entry-list', get_post_format() );
              break;
            } 
            
            ?>

          <?php endwhile; ?>

          <?php get_template_part( 'template/nav', 'below' ); ?>

      </div>

      <?php 
    
      switch((isset($_GET['action']) ? $_GET['action'] : 'default')) {
            
        default: 
			//get_sidebar();
            break;
    
        case "expand":
        
           get_sidebar();
           break;
    
        case "list":
    
            get_sidebar();
            break;
      } 

      ?>
  
    </div>

  </div><!-- content-->

  <?php if ( is_active_sidebar( 'home-bottom-widget-area' ) ) : ?>
    
    <div class="page-bottom-content clearfix">
    
      <div class="row">
        
	    <?php if ( ! dynamic_sidebar( 'home-bottom-widget-area' ) ) : ?>
            
          <h4> You need to add some widgets... </h4>
            
        <?php endif; // end primary widget area ?>
            
        <br class="clear" />
        
      <div class="row">
    
    </div><!-- page bottom content -->
    
  <?php endif; ?>

</div><!-- container -->

<?php get_footer(); ?>
