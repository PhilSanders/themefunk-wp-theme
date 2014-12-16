<?php

echo '<div class="entry-title">';

	echo '<h3>';

	echo '<a href="';
	
	the_permalink();
	
	echo '" rel="bookmark">';

	the_title();
	
	echo '</a>';
	
	echo '</h3>';
	
	echo '</div>';

	get_template_part( 'template/entry', 'meta' );

?>

<div class="entry-summary clearfix">

  <div class="large-2 columns">
    <?php if ( has_post_thumbnail() ) { 
		 the_post_thumbnail('thumbnail', array('class' => 'left'));
      }
    ?>
  </div>

  <div class="large-10 columns">
    <?php the_excerpt( sprintf(__( 'continue reading %s', 'netfunktheme' ), '<span class="meta-nav">&rarr;</span>' )  ); ?>
  </div>
  
  

  <?php  if ( is_search() ) { wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'netfunktheme' ) . '&after=</div>'); } ?>

</div> 

<hr />

<br />