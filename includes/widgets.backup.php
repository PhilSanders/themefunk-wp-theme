<?php
/* 

Theme Name: WP-netfunktheme   
Theme by: 	Phil Sanders 

*/

/* Breaksculture - Home Page Categories Widget */

class Netfunk_Homepage_Categories extends WP_Widget {

	public function Netfunk_Homepage_Categories(){
		$widget_ops = array('classname' => 'widget_home_categories', 'description' => __( "Home Page Categories Widget") );
		$this->WP_Widget('home_categories', __('Home Categories (NetfunkTheme)'), $widget_ops);
	}
	
	public function widget( $args, $instance ) {
		extract($args);
		$cat_id =  $instance[ 'category_id' ];
		$cat_name = get_the_category_by_ID( $cat_id );
		$cat_link = get_category_link( $cat_id );
		$custom_title = $instance[ 'custom_title' ];
		$per_page = $instance[ 'per_page' ];
		$offset =  (!empty($instance[ 'offset' ]) ? $instance[ 'offset' ] : 0 );
		$grid_size = $instance[ 'grid_size' ];
		$display_type = $instance[ 'display_type' ];

		echo '<div class="small-12 widget-content">';
		echo '<a class="button tiny secondary round right show-for-medium-up" style="margin-top: 10px;" href="'. $cat_link.'">More '. $cat_name.'</a>'
		.'<h2 class="widget-title">'.$custom_title.'</h2>';
		//   per_page  |  offset  |  category_id  |  grid_size  | display_type     
		$this->netfunktheme_get_categories($per_page,$offset,$cat_id,$grid_size,$display_type);
		echo '<br clear="all" />';
		echo '</div>';
	}
	
	public function netfunktheme_get_categories($per_page,$offset,$category_id,$grid_size,$display_type){
	
		global $post,$posts;
		$args = array( 'posts_per_page' => $per_page, 'offset'=> $offset, 'category' => $category_id, 'grid_size' => $grid_size , 'display_type' => $display_type  ); // RELEASES CATEGORY - HARD CODED
		$myposts = get_posts( $args );
		
		foreach ( $myposts as $post ) : 
			$n = 0;
			setup_postdata( $post ); 
			if ($display_type != 'image'){ 
			
		?>
				<div class="large-<?php echo $grid_size ?> medium-4 small-12 left home-block">
		
			  <?php echo '<a href="';
					the_permalink();
					echo '"';
					
					if($display_type=='tall')
						echo ' class="tall"';
					
					echo ' title="';
					printf( __('%s', 'netfunktheme'), the_title_attribute('echo=0') );
					echo '" rel="bookmark">';
					$image = netfunktheme_catch_post_image();
					$content = get_the_content(); 
				?>
			
						<div class="home-block-img" style="background-image: url('<?php echo $image ?>')"></div>
						<div class="home-block-title">
						<?php the_title(); ?>
						</div>
					
					<div class="postdate">
						<strong>posted on:</strong> 
						<?php the_time('M d, Y') ?>
						<br />
						<br />
						<span class="show-for-small">
						<?php echo wp_trim_words(netfunktheme_content_strip_objects($content),25, '...');  ?>
						</span>
					</div>
					
					<button class="button success tiny radius right show-for-medium-up">Read More</button>
					<button class="button success small radius right show-for-small">Read More</button>
					
					<?php echo '</a>' ?>
		
				</div>
			
			<?php 
			
			} else {
	
			?>
				<div class="large-<?php echo $grid_size ?> left" style="margin-bottom: 30px;">
				<span data-tooltip class="has-tip [tip-bottom]" title="<?php the_title(); ?>">
				<?php 
				echo '<a href="';
				the_permalink();
				echo '" rel="bookmark" class="featuredImage">';
				$image = netfunktheme_catch_post_image();
				?>
				<div style="background-image: url('<?php echo $image ?>');">
					<!--button class="button tiny success radius right">Read More</button-->
				</div>
				<?php 
				echo '</a>'; 
				?>
				</span>
				</div>
			<?php 
	
			}
		
			$n ++;
	
		endforeach; 
		
		wp_reset_postdata();
	
	}
	
	public function form( $instance ) {
		
		// outputs the options form on admin
		
		if ( isset( $instance[ 'custom_title' ] ) ) {
			$title = $instance[ 'custom_title' ];}
		else {
			$title = __( '', 'text_domain' );}

		if ( isset( $instance[ 'category_id' ] ) ) {
			$category_id = $instance[ 'category_id' ];}
		else {
			$category_id = __( 0, 'text_domain' );}
		
		if ( isset( $instance[ 'per_page' ] ) ) {
			$per_page = $instance[ 'per_page' ];}
		else {
			$per_page = __( 6, 'text_domain' );}
		
		if ( isset( $instance[ 'offset' ] ) ) {
			$offset = $instance[ 'offset' ];}
		else {
			$offset = __( 0, 'text_domain' );}
		
		if ( isset( $instance[ 'grid_size' ] ) ) {
			$grid_size = $instance[ 'grid_size' ];}
		else {
			$grid_size = __( 2, 'text_domain' );}
		
		if ( isset( $instance[ 'display_type' ] ) ) {
			$display_type = $instance[ 'display_type' ];}
		else {
			$display_type = __( 'default', 'text_domain' );}
?>
        <p>
        <label for="<?php echo $this->get_field_id( 'category_id' ); ?>"><?php _e( 'Category:' ); ?></label> 
<?php 
		$args = array(
		'show_option_all'    => '',
		'show_option_none'   => '',
		'orderby'            => 'ID', 
		'order'              => 'ASC',
		'show_count'         => 0,
		'hide_empty'         => 1, 
		'child_of'           => 0,
		'exclude'            => '',
		'echo'               => 1,
		'selected'           => $category_id,
		'hierarchical'       => 0, 
		'name'               => $this->get_field_name( 'category_id' ),
		'id'                 => $this->get_field_id( 'category_id' ),
		'class'              => 'widefat',
		'depth'              => 0,
		'tab_index'          => 0,
		'taxonomy'           => 'category',
		'hide_if_empty'      => false,
		'walker'             => ''
		);
		
		wp_dropdown_categories( $args ); 
?>
        </p>
        
        <p>
		<label for="<?php echo $this->get_field_id( 'custom_title' ); ?>"><?php _e( 'Custom Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'custom_title' ); ?>" name="<?php echo $this->get_field_name( 'custom_title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Start Offset:' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>">
        <option value="0"<?php echo (esc_attr( $offset ) == '0' ? ' selected' : ''); ?>>0</option>
        <option value="1"<?php echo (esc_attr( $offset ) == '1' ? ' selected' : ''); ?>>1</option>
        <option value="2"<?php echo (esc_attr( $offset ) == '2' ? ' selected' : ''); ?>>2</option>
        <option value="3"<?php echo (esc_attr( $offset ) == '3' ? ' selected' : ''); ?>>3</option>
        <option value="4"<?php echo (esc_attr( $offset ) == '4' ? ' selected' : ''); ?>>4</option>
        <option value="5"<?php echo (esc_attr( $offset ) == '5' ? ' selected' : ''); ?>>5</option>
        <option value="6"<?php echo (esc_attr( $offset ) == '6' ? ' selected' : ''); ?>>6</option>
        <option value="7"<?php echo (esc_attr( $offset ) == '7' ? ' selected' : ''); ?>>7</option>
        <option value="8"<?php echo (esc_attr( $offset ) == '8' ? ' selected' : ''); ?>>8</option>
        <option value="9"<?php echo (esc_attr( $offset ) == '9' ? ' selected' : ''); ?>>9</option>
        <option value="10"<?php echo (esc_attr( $offset ) == '10' ? ' selected' : ''); ?>>10</option>
        <option value="11"<?php echo (esc_attr( $offset ) == '11' ? ' selected' : ''); ?>>11</option>
        <option value="12"<?php echo (esc_attr( $offset ) == '12' ? ' selected' : ''); ?>>12</option>
        </select>
        </p>

        <p>
		<label for="<?php echo $this->get_field_id( 'per_page' ); ?>"><?php _e( 'Max Display Count:' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'per_page' ); ?>" name="<?php echo $this->get_field_name( 'per_page' ); ?>">
        <option value="1"<?php echo (esc_attr( $per_page ) == '1' ? ' selected' : ''); ?>>1</option>
        <option value="2"<?php echo (esc_attr( $per_page ) == '2' ? ' selected' : ''); ?>>2</option>
        <option value="3"<?php echo (esc_attr( $per_page ) == '3' ? ' selected' : ''); ?>>3</option>
        <option value="4"<?php echo (esc_attr( $per_page ) == '4' ? ' selected' : ''); ?>>4</option>
        <option value="5"<?php echo (esc_attr( $per_page ) == '5' ? ' selected' : ''); ?>>5</option>
        <option value="6"<?php echo (esc_attr( $per_page ) == '6' ? ' selected' : ''); ?>>6</option>
        <option value="7"<?php echo (esc_attr( $per_page ) == '7' ? ' selected' : ''); ?>>7</option>
        <option value="8"<?php echo (esc_attr( $per_page ) == '8' ? ' selected' : ''); ?>>8</option>
        <option value="9"<?php echo (esc_attr( $per_page ) == '9' ? ' selected' : ''); ?>>9</option>
        <option value="10"<?php echo (esc_attr( $per_page ) == '10' ? ' selected' : ''); ?>>10</option>
        <option value="11"<?php echo (esc_attr( $per_page ) == '11' ? ' selected' : ''); ?>>11</option>
        <option value="12"<?php echo (esc_attr( $per_page ) == '12' ? ' selected' : ''); ?>>12</option>
        </select>
        </p>

        <p>
		<label for="<?php echo $this->get_field_id( 'grid_size' ); ?>"><?php _e( 'Block Width' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'grid_size' ); ?>" name="<?php echo $this->get_field_name( 'grid_size' ); ?>">
        <option value="1"<?php echo (esc_attr( $grid_size ) == '1' ? ' selected' : ''); ?>>1</option>
        <option value="2"<?php echo (esc_attr( $grid_size ) == '2' ? ' selected' : ''); ?>>2</option>
        <option value="3"<?php echo (esc_attr( $grid_size ) == '3' ? ' selected' : ''); ?>>3</option>
        <option value="4"<?php echo (esc_attr( $grid_size ) == '4' ? ' selected' : ''); ?>>4</option>
        <option value="5"<?php echo (esc_attr( $grid_size ) == '5' ? ' selected' : ''); ?>>5</option>
        <option value="6"<?php echo (esc_attr( $grid_size ) == '6' ? ' selected' : ''); ?>>6</option>
        <option value="7"<?php echo (esc_attr( $grid_size ) == '7' ? ' selected' : ''); ?>>7</option>
        <option value="8"<?php echo (esc_attr( $grid_size ) == '8' ? ' selected' : ''); ?>>8</option>
        <option value="9"<?php echo (esc_attr( $grid_size ) == '9' ? ' selected' : ''); ?>>9</option>
        <option value="10"<?php echo (esc_attr( $grid_size ) == '10' ? ' selected' : ''); ?>>10</option>
        <option value="11"<?php echo (esc_attr( $grid_size ) == '11' ? ' selected' : ''); ?>>11</option>
        <option value="12"<?php echo (esc_attr( $grid_size ) == '12' ? ' selected' : ''); ?>>12</option>
        </select>
        </p>

		<p>
		<label for="<?php echo $this->get_field_id( 'display_type' ); ?>"><?php _e( 'Display:' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'display_type' ); ?>" name="<?php echo $this->get_field_name( 'display_type' ); ?>">
        <option value="default"<?php echo (esc_attr( $display_type ) == '' ? ' selected' : ''); ?>>default</option>
        <option value="image"<?php echo (esc_attr( $display_type ) == 'image' ? ' selected' : ''); ?>>image only</option>
        <option value="tall"<?php echo (esc_attr( $display_type ) == 'tall' ? ' selected' : ''); ?>>tall</option>
        </select>
        </p>
<?php 
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['custom_title'] = ( ! empty( $new_instance['custom_title'] ) ) ? strip_tags( $new_instance['custom_title'] ) : '';
		$instance['per_page'] = ( ! empty( $new_instance['per_page'] ) ) ? strip_tags( $new_instance['per_page'] ) : '6';
		$instance['category_id'] = ( ! empty( $new_instance['category_id'] ) ) ? strip_tags( $new_instance['category_id'] ) : '0';
		$instance['grid_size'] = ( ! empty( $new_instance['grid_size'] ) ) ? strip_tags( $new_instance['grid_size'] ) : '2';
		$instance['display_type'] = ( ! empty( $new_instance['display_type'] ) ) ? strip_tags( $new_instance['display_type'] ) : 'default';
		return $instance;
	}
}



/* Labels Blog-Roll Page Info Widget */

class Netfunk_Labels_Info extends WP_Widget {

	function Netfunk_Labels_Info(){
		$widget_ops = array('classname' => 'widget_labels_info', 'description' => __( "Labels Blog-roll Page Information Widget") );
		$this->WP_Widget('labels_info', __('Labels Info'), $widget_ops);
	}
	
	function widget( $args, $instance ) {
		
		extract($args);
		$cat_id = $instance[ 'category_id' ];
		$custom_title = $instance[ 'custom_title' ];
		
		$bookmark_args = array(
		'orderby'        => 'rand', 
		'order'          => 'ASC',
		'limit'          => 12, 
		'category'       => $cat_id,
		'category_name'  => '', 
		'hide_invisible' => 1,
		'show_updated'   => 0,
		'show_images'    => 1, 
		'include'        => '',
		'exclude'        => '',
		'search'         => '' );
		
		$bookmarks = get_bookmarks ($bookmark_args);
		
		echo '<div class="row">';
		echo '<div class="small-12 columns">';
		echo '<a class="button tiny secondary round right show-for-medium-up" style="margin-top: 10px;" href="/labels/">More Labels</a>'
			.'<h2 class="widget-title">'.$custom_title.'</h2>';
		echo '<div class="panel radius callout">';
		echo '<br />';
		echo '<ul class="xoxo blogroll">';
		// Loop through each bookmark and print formatted output
		foreach ($bookmarks as $bookmark) { 
			printf( '<li class="small-12 medium-6 large-3"><a class="relatedlink" href="%s"><img src="%s" border="0">%s</a></li>', $bookmark->link_url, $bookmark->link_image, $bookmark->link_name);
		}
		echo '<br class="clear"/>';
		echo '</ul>';
		echo '<br />';
		echo '<div class="large-12 columns text-center hide-for-small">'
			."<h4>Breakbeat Labels... <small>Don't see your label listed here?</small> <a href='/label-contact/' class=\"button tiny success round\" id=\"default-button\">Contact us</a></h4>"
			.'</div>';
		echo '<div class="clear"></div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';

	}
	
	
	public function form( $instance ) {
		// outputs the options form on admin
		
		if ( isset( $instance[ 'custom_title' ] ) ) {
			$title = $instance[ 'custom_title' ];
		}
		else {
			$title = __( '', 'text_domain' );
		}
		
		if ( isset( $instance[ 'category_id' ] ) ) {
			$category_id = $instance[ 'category_id' ];
		}
		else {
			$category_id = __( 0, 'text_domain' );
		}
		
		
		?>
        
        <p>
        <label for="<?php echo $this->get_field_id( 'category_id' ); ?>"><?php _e( 'Category:' ); ?></label> 

        <?php 
		 
		  $taxonomy = 'link_category';
		  $args ='';
		  $terms = get_terms( $taxonomy, $args );
		  if ($terms) {
			
			echo '<select name="'.$this->get_field_name( 'category_id' ).'" id="'.$this->get_field_id( 'category_id' ).'">';
			
			foreach($terms as $term) {
			  if ($term->count > 0) {
				echo '<option value="' . $term->term_id . '">' . $term->name . '</option> ';
			  }
			}
			
			echo '</select>';
			
		  } 
		  
		?>

        
        </p>
        
         <p>
		<label for="<?php echo $this->get_field_id( 'custom_title' ); ?>"><?php _e( 'Custom Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'custom_title' ); ?>" name="<?php echo $this->get_field_name( 'custom_title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

        
		<?php 
		
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		
		$instance = array();
		$instance['category_id'] = ( ! empty( $new_instance['category_id'] ) ) ? strip_tags( $new_instance['category_id'] ) : '0';
		$instance['custom_title'] = ( ! empty( $new_instance['custom_title'] ) ) ? strip_tags( $new_instance['custom_title'] ) : '0';

		return $instance;
		
	}
	

}



/* Custom Categories Dropdown Menu Widget */

class Netfunk_Categories_Widget extends WP_Widget {

	function Netfunk_Categories_Widget(){
		
		$widget_ops = array('classname' => 'widget_netfunktheme_categories', 'description' => __( "Custom Categories Dropdown menu widget") );
		$this->WP_Widget('netfunktheme_categories', __('Categories'), $widget_ops);
	
	}
	
	function widget( $args, $instance ) {
		
		global $current_user;

		extract($args);
		
		$defaults = array(
			'show_option_all' => '', 
			'show_option_none' => '',
			'orderby' => 'id', 
			'order' => 'ASC',
			'show_last_update' => 0, 
			'show_count' => 0,
			'hide_empty' => 1, 
			'child_of' => 0,
			'exclude' => '', 
			'echo' => 1,
			'selected' => 0, 
			'hierarchical' => $instance['hierarchical'],
			'name' => 'cat', 
			'id' => '',
			'class' => 'postform', 
			'depth' => 0,
			'tab_index' => 0, 
			'taxonomy' => 'category',
			'hide_if_empty' => false
		);
	
		$defaults['selected'] = ( is_category() ) ? get_query_var( 'cat' ) : 0;
	
		// Back compat.
		if ( isset( $args['type'] ) && 'link' == $args['type'] ) {
			_deprecated_argument( __FUNCTION__, '3.0', '' );
			$args['taxonomy'] = 'link_category';
		}
	
		$r = wp_parse_args( $args, $defaults );
	
		if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] ) {
			$r['pad_counts'] = true;
		}
	
		$r['include_last_update_time'] = $r['show_last_update'];
		extract( $r );
	
		$tab_index_attribute = '';
		if ( (int) $tab_index > 0 )
			$tab_index_attribute = ' tabindex='.$tab_index;
	
		$categories = get_terms( $taxonomy, $r );
		$name = esc_attr( $name );
		$class = esc_attr( $class );
		$id = $id ? esc_attr( $id ) : $name;
	
		$output = '<form class="custom">';
	
		$output .= '<li id="netfunktheme-categories" class="widget-content widget_categories">';
		$output .= '<h3 class="widget-title">'.$instance['title'].'</h3>';
	
		if ( ! $r['hide_if_empty'] || ! empty($categories) )
			$output .= "<select name='cat' id='cat' class='postform' $tab_index_attribute>\n";
		else
			$output .= '';
	
		if ( empty($categories) && ! $r['hide_if_empty'] && !empty($show_option_none) ) {
			$show_option_none = apply_filters( 'list_cats', $show_option_none );
			$output .= "\t<option value='-1' selected='selected'>$show_option_none</option>\n";
		}
	
		if ( ! empty( $categories ) ) {
	
			if ( $show_option_all ) {
				$show_option_all = apply_filters( 'list_cats', $show_option_all );
				$selected = ( '0' === strval($r['selected']) ) ? " selected='selected'" : '';
				$output .= "\t<option value='0'$selected>$show_option_all</option>\n";
			}
	
			if ( $show_option_none ) {
				$show_option_none = apply_filters( 'list_cats', $show_option_none );
				$selected = ( '-1' === strval($r['selected']) ) ? " selected='selected'" : '';
				$output .= "\t<option value='-1'$selected>$show_option_none</option>\n";
			}
	
			if ( $hierarchical )
				$depth = $r['depth'];  // Walk the full depth.
			else
				$depth = -1; // Flat.
	
			$output .= walk_category_dropdown_tree( $categories, $depth, $r );
		}
		if ( ! $r['hide_if_empty'] || ! empty($categories) )
			$output .= "</select>";

		$output .= '</li>';
		$output .= '</form>';

		/* javascript */
		$output .= '<script type="text/javascript">';
		$output .= 'var dropdown = document.getElementById("cat");function onCatChange() {if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {location.href = "http://www.netfunkdesign.com/?cat="+dropdown.options[dropdown.selectedIndex].value;}}';
		$output .= 'dropdown.onchange = onCatChange;';
		$output .= '</script>';

		$output = apply_filters( 'wp_dropdown_cats', $output );

		if ( $echo )
			echo $output;
	
		return $output;

	}

	public function form( $instance ) {
		
		// outputs the options form on admin
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Categories', 'text_domain' );
		}
		
		if ( isset( $instance[ 'dropdown' ] ) ) {
			$dropdown = $instance[ 'dropdown' ];
		}
		else {
			$dropdown = __( 'link_category', 'text_domain' );
		}
		
		if ( isset( $instance[ 'hierarchical' ] ) ) {
			$hierarchical = $instance[ 'hierarchical' ];
		}
		else {
			$hierarchical = __( '0', 'text_domain' );
		}
		
		
		?>

        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>


		<p>
		<input id="<?php echo $this->get_field_id( 'dropdown' ); ?>" class="checkbox" name="<?php echo $this->get_field_name( 'dropdown' ); ?>"<?php echo (esc_attr( $dropdown != 'link_category' ) ? " checked='checked'" : '') ?>  value="category" type="checkbox"/>
		<label for="<?php echo $this->get_field_id( 'dropdown' ); ?>"><?php _e( 'Display as dropdown' ); ?></label>
		<br />
		<input id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" class="checkbox" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>"<?php echo (esc_attr( $hierarchical != '0' ) ? " checked='checked'" : '') ?>  value="1" type="checkbox"/>
		<label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>"><?php _e( 'Show hierarchy' ); ?></label>
        </p>
        
		<?php 
		
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Categories';
		$instance['dropdown'] = ( ! empty( $new_instance['dropdown'] ) ) ? strip_tags( $new_instance['dropdown'] ) : 'link_category';
		$instance['hierarchical'] = ( ! empty( $new_instance['hierarchical'] ) ) ? strip_tags( $new_instance['hierarchical'] ) : '0';

		return $instance;
		
	}
	

}




