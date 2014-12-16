<br class="clear" />
<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
<br />
<div id="nav-below" class="large-12 small-12 columns navigation">
<div class="large-6 small-12 columns nav-previous text-center"><?php next_posts_link(sprintf(__( '%s', 'netfunktheme' ),'<span class="button secondary small round meta-nav">&larr; View Older Posts</span>')) ?></div>
<div class="large-6 small-12 columns nav-next text-center"><?php previous_posts_link(sprintf(__( '%s', 'netfunktheme' ),'<span class="button secondary small round meta-nav">View Newer Posts &rarr;</span>')) ?></div>
<br class="clear" />
</div>
<?php } ?>