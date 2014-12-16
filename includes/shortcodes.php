<?php
/* 

Theme Name: WP-netfunktheme   
Theme by: 	Phil Sanders 

*/

/* custom shortcodes */

/* BreaksCulture - Shoretcodes */

add_action( 'init', 'netfunktheme_shortcodes' );

if (!function_exists( 'netfunktheme_shortcodes')){

	function netfunktheme_shortcodes() {
		add_shortcode('wp_caption', 		'fixed_img_caption_shortcode');
		add_shortcode('caption', 			'fixed_img_caption_shortcode');
		add_shortcode( 'lb_author_img', 	'netfunktheme_author_img_shortcode' );
		add_shortcode( 'lb_author_desc', 	'netfunktheme_author_desc_shortcode' );
		add_shortcode( 'lb_company_meta', 	'netfunktheme_company_meta' );
		add_shortcode( 'lb_contact_meta', 	'netfunktheme_contact_meta' );
		add_shortcode( 'lb_author_title', 	'netfunktheme_author_title_shortcode' );
		add_shortcode( 'lb_author_name', 	'netfunktheme_author_displayname_shortcode' );
		add_shortcode( 'lb_text_label', 	'netfunktheme_text_label_shortcode' );
		add_shortcode( 'lb_contact_button', 'netfunktheme_contact_button_shortcode' );
		add_shortcode( 'lb_author_button', 	'netfunktheme_author_button_shortcode' );
		add_shortcode( 'lb_linkedin_button','netfunktheme_linkedin_button_shortcode' );
		add_filter('img_caption_shortcode', 'netfunktheme_img_caption_shortcode_filter',10,3);
		add_filter('widget_text', 			'do_shortcode');
	}
}

/* ListBargains - Author Image shortcode */

function netfunktheme_author_img_shortcode( $atts ){
	
	extract( shortcode_atts( array(
		'user_id' => '0',
		'size' => '96',
	), $atts ) );
	
	$author_avatar = get_avatar($atts['user_id'], $atts['size']);
	
	return $author_avatar;
	
}

/* ListBargains - Author Description shortcode */

function netfunktheme_author_title_shortcode( $atts ){
	
	extract( shortcode_atts( array(
		'user_id' => '0',
	), $atts ) );
	
	$author_title = '';
	
	if ($atts['user_id'] != 0) {

		$author_title = get_the_author_meta('lb_title',$atts['user_id']);

	}
	
	return $author_title;
	
}

/* ListBargains - Author company meta shortcode */

function netfunktheme_company_meta( $atts ){
	
	extract( shortcode_atts( array(
		'user_id' => '0',
	), $atts ) );
	
	$author_title_meta = '';
	
	if ($atts['user_id'] != 0) {

		$author_title_meta .= '<p class="lb-shortcode-meta lb_company_meta">';

		$author_title_meta .= '<strong><a href="';

		$author_title_meta .= home_url() . '/author/'.get_the_author_meta('user_nicename',$atts['user_id']);

		$author_title_meta .= '">';

		$author_title_meta .= get_the_author_meta('display_name',$atts['user_id']);

		$author_title_meta .= '</a></strong>';	

		$author_title_meta .= ', ';

		$author_title_meta .= '<em>';

		$author_title_meta .= get_the_author_meta('lb_title',$atts['user_id']);
		
		$author_title_meta .= '</em>';
		
		$author_title_meta .= '</p>';

	}
	
	return $author_title_meta;
	
}

/* ListBargains - Author Description shortcode */

function netfunktheme_author_desc_shortcode( $atts ){
	
	extract( shortcode_atts( array(
		'user_id' => '0'
	), $atts ) );
	
	$author_description = '';
	
	if ($atts['user_id'] != 0) {

		$author_description = get_the_author_meta('lb_about',$atts['user_id']);

	}
	
	$author_description = str_replace('/n','<br />',$author_description);
	$author_description = str_replace('/r','<br />',$author_description);
	
	return '<p class="lb-shortcode-meta lb_author_description">' . $author_description . '</p>';
	
}

/* ListBargains - Author company meta shortcode */

function netfunktheme_contact_meta( $atts ){
	
	extract( shortcode_atts( array(
		'user_id' => '0',
	), $atts ) );
	
	$html_out = '';
	
	if ($atts['user_id'] != 0) {

		$html_out = '<div class="small-12 lb-shortcode-meta lb_contact_meta">'

		//. '<div class="panel radius">'

		. '<table cellpadding="4" callspacing="0" border="0" width="100%" class="contact_meta_table">'

		. '<tr><td align="right" valign="top">'

		. '<strong>Email: </strong></td><td align="left">' 
		
		. '<a href="mailto:' . get_the_author_meta('user_email',$atts['user_id']) . '">'
		
		. get_the_author_meta('user_email',$atts['user_id']) 
		
		. '</a>'
		
		. '</td></tr><tr><td align="right" valign="top">'
		
		. '<strong>Phone: </strong></td><td align="left">' . get_the_author_meta('lb_phone',$atts['user_id']) . '</td></tr><tr><td align="right" valign="top">'
		
		. '<strong>Cell: </strong></td><td align="left">' . get_the_author_meta('lb_cell',$atts['user_id']) . '</td></tr><tr><td align="right" valign="top">'
		
		. '<strong>Fax: </strong></td><td align="left">' . get_the_author_meta('lb_fax',$atts['user_id']) . '</td></tr><tr><td align="right" valign="top">'
		
		. '<strong>Address: </strong></td><td align="left">' 
		
			. get_the_author_meta('lb_company',$atts['user_id']) . '<br />'
			
			. get_the_author_meta('lb_address',$atts['user_id']) . ', <br />'
			
			. get_the_author_meta('lb_city',$atts['user_id']) . ', ' 
			
			. get_the_author_meta('lb_state',$atts['user_id']) . ' ' 
			
			. get_the_author_meta('lb_zip',$atts['user_id']) . '<br />' 
			
			. get_the_author_meta('lb_country',$atts['user_id'])  
			

		. '</td></tr>'	
		
		. '</table>'
		
		//. '</div>'
		
		. '</div>';

	}
	
	return $html_out;
	
}


/* ListBargains - Author Displa Name shortcode */

function netfunktheme_author_displayname_shortcode( $atts ){
	
	extract( shortcode_atts( array(
		'user_id' => '0',
	), $atts ) );
	
	$author_displayname = '';
	
	if ($atts['user_id'] != 0) {

		$author_displayname = get_the_author_meta('display_name',$atts['user_id']);

	}
	
	return $author_displayname;
	
}

/* ListBargains - text label shortcode */

function netfunktheme_text_label_shortcode( $atts ){
	
	extract( shortcode_atts( array(
		'text' => '',
	), $atts ) );
	
	$lb_label_txt = '';
	
	if (!empty($atts['text'])) {

		$lb_label_txt = '<span class="label radius">'.$atts['text'].'</span>';

	}
	
	return $lb_label_txt;
	
}

/* ListBargains - contact button shortcode */

function netfunktheme_contact_button_shortcode( $atts ){
	
	extract( shortcode_atts( array(
		'text' => '',
	), $atts ) );
	
	$lb_contact_btn = '';
	
	if (!empty($atts['text'])) {

		if (get_page_by_title('Contact Us') || get_page_by_title('Contact') || get_page_by_title('contact')){  
					
			$lb_contact_btn = '<a href="' . home_url() . '/contact/" class="button small radius">';
			
			$lb_contact_btn .= $atts['text']; 
			
			$lb_contact_btn .= '</a>';
		
		}
	
	}
	
	return $lb_contact_btn;
	
}

/* ListBargains - linkedin button shortcode */

function netfunktheme_linkedin_button_shortcode( $atts ){
	
	extract( shortcode_atts( array(
		'user_id' => '',
	), $atts ) );
	
	$lb_linkedin_btn = '';
	
	if (!empty($atts['user_id'])) {
					
		$lb_linkedin_btn = '<a href="' . get_the_author_meta('lb_linkedin',$atts['user_id']) . '" class="button small radius lb_linkedin_button" target="_blank">';
		
		$lb_linkedin_btn .= '<span class="webicon small linkedin"></span>';
		
		$lb_linkedin_btn .= 'Visit '. get_the_author_meta('display_name',$atts['user_id']) .' On linkedIn';
		
		$lb_linkedin_btn .= '</a>';
	
	}
	
	return $lb_linkedin_btn;
	
}

/* ListBargains - author button shortcode */

function netfunktheme_author_button_shortcode( $atts ){
	
	extract( shortcode_atts( array(
		'user_id' => '',
	), $atts ) );
	
	$lb_author_btn = '';
	
	if (!empty($atts['user_id'])) {
					
		$lb_author_btn = '<a href="' . home_url() . '/author/'.get_the_author_meta('user_nicename',$atts['user_id']) . '" class="button small success radius lb_author_button">';
		
		$lb_author_btn .= 'More About '. get_the_author_meta('display_name',$atts['user_id']) .'';
		
		$lb_author_btn .= '</a>';
	
	}
	
	return $lb_author_btn;
	
}

/* ListBargains - Image Caption flter shortcode  --- not used ????  */

function netfunktheme_img_caption_shortcode_filter($val, $attr, $content = null) {

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> '',
		'width'	=> '',
		'caption' => ''
		), $attr));

	  if ( 1 > (int) $width || empty($caption) )
		return $val;
		
		$capid = '';
		
	  if ( $id ) {
		$id = esc_attr($id);
		$capid = 'id="figcaption_'. $id . '" ';
		$id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
	  }

	return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: '
	. (10 + (int) $width) . 'px">' . do_shortcode( $content ) . '<figcaption ' . $capid 
	. 'class="wp-caption-text">' . $caption . '</figcaption></figure>';

}

