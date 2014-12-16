 <?php 

	if ( is_single() ) {
	
		get_template_part( 'template', 'entry-footer-single' ); 
	
	} else {
	
		get_template_part( 'entry-footer' ); 
	
	}
	
?>
