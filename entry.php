
<div id="post-<?php the_ID(); ?> clearfix" <?php post_class(); ?>>

<?php

if (is_archive() || is_search()){

	get_template_part('template/entry','list');

} else {

	get_template_part('template/entry','content');

}

?>

</div> 
