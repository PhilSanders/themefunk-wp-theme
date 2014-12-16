
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( has_post_thumbnail() ){ ?>

        <div class="small-3 large-2 columns">
    
        <?php 
			
			echo '<a href="';
			
			the_permalink();
			
			
			echo '" title="';
            
            printf( __('Read %s', 'netfunktheme'), the_title_attribute('echo=0') );
            
            echo '" rel="bookmark">';
			
			if ( has_post_thumbnail() ) {
    
                the_post_thumbnail('medium');
                
            } 
			
			echo '</a>';
		?>
        
        </div>
        
        <?php } ?>
        
        <div class="small-9 large-<?php echo ( has_post_thumbnail() ? '10' : '12' ) ?> <?php echo ( has_post_thumbnail() ? 'right' : '' ) ?>">

            <h5 class="entry-title paneltitle">
            
            <?php edit_post_link( __( '<i class="fa fa-pencil"></i>', 'netfunktheme' ), "<span class=\"button tiny round secondary edit-link right\">", "</span>" ) ?>
    
            <?php 
    
                echo '<a href="';
                
                the_permalink();
                
                echo '" rel="bookmark">';
    
                the_title();
                
                echo '</a>';
                
                ?>
                
             </h5>
			
			<?php get_template_part( 'template/entry', 'meta' );
			
			$content = '';
			
			if ( is_category() || is_archive() ) {
				
				$content =  get_the_excerpt();
				
			} else {
				
				$content = get_the_content();
			}

			?>
			
			<p> <?php echo $content; ?></p>
            
            <?php
			
			echo '<a href="';
		
			the_permalink();
			
			echo '" class="button tiny round right">';
			
			echo 'Read More';
			
			echo '</a>';
			
			?>

        </div>
        
        <br clear="all" />

    </div><!-- post -->
	
    <hr />
