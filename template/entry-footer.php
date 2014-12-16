
<?php global $post; if ( 'post' == $post->post_type ) : ?>

<div class="large-12 entry-footer">

<?php 

	if ( is_category() && $catz = netfunktheme_catz(', ') ) : // ?>
	
	<span class="cat-links"><?php printf( __( 'Also posted in %s', 'netfunktheme' ), $catz ); ?></span>
	
	<span class="meta-sep"> | </span>
	
	<?php else : ?>
	
	<span class="cat-links"><span class="entry-footer-prep entry-footer-prep-cat-links">
	
	<?php _e( 'Posted in ', 'netfunktheme' ); ?></span><?php echo get_the_category_list(', '); ?></span>
	
	<span class="meta-sep"> | </span>
	
	<?php endif; ?>
	
	<?php if ( is_tag() && $tag_it = netfunktheme_tag_it(', ') ) : // ?>
	
	<span class="tag-links"><?php printf( __( 'Also tagged %s', 'netfunktheme' ), $tag_it ); ?></span>
	
	<?php else : ?>
	
	<?php the_tags( '<span class="tag-links"><span class="entry-footer-prep entry-footer-prep-tag-links">' . __('Tagged ', 'netfunktheme' ) . '</span>', ", ", "</span>\n\t\t\t\t\t\t<span class=\"meta-sep\"> | </span>\n" ); ?>
	
	<?php endif; ?>
	
	
	<br />
	
	<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'netfunktheme' ), __( '1 Comment', 'netfunktheme' ), __( '% Comments', 'netfunktheme' ) ); ?></span>
	
	<?php edit_post_link( __( 'Edit', 'netfunktheme' ), "<span class=\"meta-sep\"> | </span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ); ?>

</div>

<?php endif; ?>