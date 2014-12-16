
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php 

	echo '<div class="entry-title">';

	echo '<h5>';

	echo '<a href="';
	
	the_permalink();
	
	echo '" rel="bookmark">';

	the_title();
	
	echo '</a>';
	
	echo '</h5>';
	
	get_template_part( 'template/entry', 'meta' );
	
	echo '</div>';
	
	echo '<div class="entry-content">';
	
	echo '<p>';
	
	//$content = get_the_content();
	
	//echo netfunktheme_content_strip_objects($content);
	
	the_content();
	
	echo '<br /><br />';
	
	echo '<a href="';
	
	the_permalink();
	
	echo '" class="button success small radius">';
	
	echo 'Read More';
	
	echo '</a>';
	
	echo '</p>';
	
	echo '</div>';

?>

</div>

