
<?php global $netfunk_page_options, $netfunk_post_options; ?>

<div class="nav-below-single">

    <div id="nav-below" class="navigation">
    
        <div class="large-6 columns nav-previous left text-center">
		
        <?php 
        
            if (isset($netfunk_post_options['posts_nav_type']) && $netfunk_post_options['posts_nav_type'] == 0) {

				// short hand text display type

                previous_post_link( '%link', '<span class="button secondary small round meta-nav">&larr; View Older Posts</span>' );
            
            } else if (isset($netfunk_post_options['posts_nav_type']) && $netfunk_post_options['posts_nav_type'] == 1){
                
                // title text display type
                
                previous_post_link( '%link', '<span class="meta-nav">&larr; %title</span>' );
            
            } else if (!isset($netfunk_post_options['posts_nav_type'])){
                
                // option not yet set. falls back to defaut: 'yes'
                
                previous_post_link( '%link', '<span class="button secondary small round meta-nav">&larr; View Older Posts</span>' );
            
            }
        
        ?>
        
        </div>
        
        <div class="large-6 columns nav-next right text-center">
		
        <?php 
        
            if (isset($netfunk_post_options['posts_nav_type']) && $netfunk_post_options['posts_nav_type'] == 0) {

				// short hand text display type

                next_post_link( '%link', '<span class="button secondary small round meta-nav">View Newer Posts &rarr;</span>' );
            
            } else if (isset($netfunk_post_options['posts_nav_type']) && $netfunk_post_options['posts_nav_type'] == 1){
                
                // title text display type
                
                next_post_link( '%link', '<span class="meta-nav">%title &rarr;</span>' );
            
            } else if (!isset($netfunk_post_options['posts_nav_type'])){
                
                // option not yet set. falls back to defaut: 'yes'
                
                next_post_link( '%link', '<span class="button secondary small round meta-nav">View Newer Posts &rarr;</span>' );
            
            }
        
        ?>

        </div>
        
        <br clear="all" />
        
    </div>

</div>