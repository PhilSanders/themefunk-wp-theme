
<?php global $authordata, $netfunk_post_options; ?>

<?php 

if (isset($netfunk_post_options['show_post_meta']) && $netfunk_post_options['show_post_meta'] == 'yes') { ?>

  <div class="entry-meta hide-for-small">

    <span class="meta-prep meta-prep-author"><?php _e('By: ', 'netfunktheme'); ?> </span>
    
    <span class="author vcard"><a class="url fn n has-tip" data-tooltip href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="<?php printf( __( 'View all articles by %s', 'netfunktheme' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
    
    <span class="meta-prep meta-prep-entry-date"><?php _e('Published:', 'netfunktheme'); ?> </span>
    
    <span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>

  </div>

<?php } ?>
