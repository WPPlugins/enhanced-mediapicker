<?php

/**
 * Codepress_Mediapicker_Limit
 *
 * @since     0.1
 *
 */
class Codepress_Mediapicker_Limit
{
	private $limit, $user_id;
	
	/**
	 * Constructor
	 *
	 * @since     0.1
	 */
	function __construct()
	{		
		$this->user_id 	= get_current_user_id();
		
		// set row limit
		add_filter( 'post_limits', array( $this, 'set_row_limit_mediapicker' ), 999, 1 );
		
		// set pagination limit
		add_filter( 'media_upload_mime_type_links', array( $this, 'set_paginate_limit_mediapicker' ), 1 );
		
		// handle requests
		add_action('parse_request', array( $this, 'request_handler') );		
		
		// styling & scripts
		add_action( 'admin_print_styles', array( $this, 'admin_styles') );
		add_action( 'admin_print_scripts', array( $this, 'admin_scripts') );
		
		// set row limit variable for javascript
		add_action( 'admin_print_footer_scripts', array( $this, 'admin_footer_scripts') );
	}
	
	/**
	 * Save new limit to database
	 *
	 * @since     0.1
	 */
	function request_handler($request)
	{		
	 	if( !cp_is_screen_mediapicker() || !isset($request->extra_query_vars['rowlimit']) )
			return false;
		
		$request_limit = $request->extra_query_vars['rowlimit'];
		
		// save the new limit to the db		
		if ( $this->get_limit() != $request_limit && false !== $this->validate_input($request_limit) ) {			
			$this->set_limit($request_limit);			
		}
	}
	
	/**
	 * Set paginate to new limit
	 *
	 * We use the media_upload_mime_type_links-hook to change the 
	 * global $wp_query->found_posts variable.
	 * The actual $type_links variable has no purpose here.
	 *
	 * @since     0.1
	 */
	public function set_paginate_limit_mediapicker( $type_links )
	{
		global $wp_query;		
				
		if( cp_is_screen_mediapicker() ) {
			
			$limit = $this->get_limit();
			
			// used to show ALL items
			if ( $limit == 0 ) $limit = 999999;
			
			$wp_query->found_posts = $wp_query->found_posts / ( $limit / 10 );			
		}
		
		return $type_links;
	}	
	
	/**
	 * Set row limit mediapicker
	 *
	 * @since     0.1
	 */
	public function set_row_limit_mediapicker($limits)
	{
		if( cp_is_screen_mediapicker() ) {
		
			$limit = $this->get_limit();
			
			// used to show ALL items
			if ( $limit == 0 ) $limit = 999999;
			
			$paged 		= isset($_GET['paged']) ? $_GET['paged'] : 1;			
			$sql_limit 	= $limit * ($paged - 1);
			
			// new limit
			$limits = "LIMIT {$sql_limit}, {$limit}";			
		}

		return $limits;
	}
	
	/**
	 * Validate input field
	 *
	 * @since     0.1
	 */
	public function validate_input( $input )
	{
		if ( isset($input) && is_numeric($input) ) {
			$input = abs($input);
			return $input;
		}
		
		return false;
	}
	
	/**
	 * Set limit
	 *
	 * Limit is saved to the current user, so every user can set it's own preference
	 *
	 * @since     0.1
	 */
	private function set_limit( $limit )
	{		
		$options = get_option('cpem_options');
		$options['mediapicker_limit_'.$this->user_id] = $limit;
		update_option('cpem_options', $options);	
	}
	
	/**
	 * Get limit
	 *
	 * @since     0.1
	 */
	private function get_limit()
	{
		$options 	= get_option('cpem_options');
		
		$value 		= 10; // default	
		if ( isset($options['mediapicker_limit_'.$this->user_id]) ) {
			$value = trim( esc_attr( $options['mediapicker_limit_'.$this->user_id] ) );
		}
		
		$value = apply_filters( 'cp_mediapicker_limit', $value );
		$value = apply_filters( 'cp_mediapicker_limit_'.$this->user_id, $value );
		
		return $value;
	}
	
	/**
	 * Count total attachments
	 *
	 * @since     0.1
	 */
	private function count_attachments()
	{
		$attachment_count = wp_count_posts('attachment');
		
		if ( !empty($attachment_count->inherit) )
			return apply_filters('cpem-count-attachments', $attachment_count->inherit);
		
		return false;
	}
	
	/**
	 * Register admin css
	 *
	 * @since     0.1
	 */
	public function admin_styles()
	{
		wp_enqueue_style( 'cpem-more-rows', CPEM_URL.'/assets/css/more-rows.css', array(), CPEM_VERSION, 'all' );	
	}
	
	/**
	 * Register admin scripts
	 *
	 * @since     0.1
	 */
	public function admin_scripts() 
	{
		wp_enqueue_script( 'cpem-more-rows', CPEM_URL.'/assets/js/more-rows.js', array('jquery'), CPEM_VERSION );
	}
	
	/**
	 * Makes variables available for jQuery
	 *
	 * @since     0.1
	 */
	public function admin_footer_scripts() 
	{
		$limit = $this->get_limit();
		$count = $this->count_attachments();
		
		echo "
		<script type='text/javascript'>
			var cpem_rowlimit = '{$limit}';			
			var cpem_attachment_count = '{$count}';
		</script>";
	}
}

new Codepress_Mediapicker_Limit;