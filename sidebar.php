
<div class="large-3 small-12 columns right hide-for-small">
	
    <?php global $theme_options, $netfunk_page_options, $netfunk_post_options; ?>
    
	<?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
            
    	<div id="sidebar" class="widget-area">
            
    		<ul class="sid">

            <?php if ( is_front_page() ){?>
                   
				<?php if (isset($theme_options['show_front_page_primary_sidebar']) && $theme_options['show_front_page_primary_sidebar'] == 'yes'){ ?>
                
                    <?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>
                    <?php endif; // end primary widget area ?>
                        
                <?php } ?>
                
             <?php } else if ( is_page() ){?>
                   
				<?php if (isset($netfunk_page_options['show_page_primary_sidebar']) && $netfunk_page_options['show_page_primary_sidebar'] == 'yes'){ ?>
                
                    <?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>
                    <?php endif; // end primary widget area ?>
                        
                <?php } ?>
                
             <?php } else { ?>
                
                <?php if (isset($netfunk_post_options['show_post_primary_sidebar']) && $netfunk_post_options['show_post_primary_sidebar'] == 'yes') { ?>
                
                    <?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>
                    <?php endif; // end primary widget area ?>
                
                <?php } ?>
            
            <?php } ?>
            
            </ul>
        
    	</div>
     
    <?php endif; ?>

	<?php if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>
    	
        <div id="sidebar-secondary" class="widget-area">
        	
            <ul class="sid">

				<?php if ( is_front_page() ){?>
                
                    <?php if (isset($theme_options['show_front_page_secondary_sidebar']) && $theme_options['show_front_page_secondary_sidebar'] == 'yes'){?>
                            
                        <?php if ( ! dynamic_sidebar( 'secondary-widget-area' ) ) : ?>
                        <?php endif; // end secondary widget area ?>
                    
                    <?php } ?>
    
                <?php } else if ( is_page() ){?>
                
                    <?php if (isset($netfunk_page_options['show_page_secondary_sidebar']) && $netfunk_page_options['show_page_secondary_sidebar'] == 'yes'){?>
                            
                        <?php if ( ! dynamic_sidebar( 'secondary-widget-area' ) ) : ?>
                        <?php endif; // end secondary widget area ?>
                    
                    <?php } ?>
    
                <?php } else { ?>
    
                    <?php if (isset($netfunk_post_options['show_post_secondary_sidebar']) && $netfunk_post_options['show_post_secondary_sidebar'] == 'yes'){ ?>
                        
                        <?php if ( ! dynamic_sidebar( 'secondary-widget-area' ) ) : ?>
                        <?php endif; // end secondary widget area ?>
                        
                    <?php } ?>
                
                <?php } ?>
            
        	</ul>
            
        </div>
        
    <?php endif; ?>

</div>
