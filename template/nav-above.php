
<?php if ( is_paged() ) { ?>

<div id="nav-above" class="large-12 small-12 columns navigation">

<div class="large-6 small-6 columns nav-previous text-left"><?php next_posts_link(sprintf(__( '%s', 'netfunktheme' ),'<span class="button secondary small round meta-nav">&larr; View Older Posts</span>')) ?></div>

<div class="large-6 small-6 columns nav-next text-right"><?php previous_posts_link(sprintf(__( '%s', 'netfunktheme' ),'<span class="button secondary small round meta-nav">View Newer Posts &rarr;</span>')) ?></div>

<br class="clear" />

</div>

<hr />

<?php } ?>