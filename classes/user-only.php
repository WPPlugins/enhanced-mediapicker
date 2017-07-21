<?php

/**
 * Codepress_Mediapicker_User_Only
 *
 * @since     0.1
 *
 */
class Codepress_Mediapicker_User_Only
{
	private $user_id;
	
	/**
	 * Constructor
	 *
	 * @since     0.1
	 */
	function __construct()
	{		
		$this->user_id 	= get_current_user_id();
		
		add_action('parse_query', array( $this, 'show_user_uploads_only') );
		
		// handle requests
		add_action('parse_request', array( $this, 'request_handler') );
		
		// styling & scripts
		add_action( 'admin_print_styles', array( $this, 'admin_styles') );
		add_action( 'admin_print_scripts', array( $this, 'admin_scripts') );
		
		// set row limit variable for javascript
		add_action( 'admin_print_footer_scripts', array( $this, 'admin_footer_scripts') );
		
		// set new attachment count for more-rows.php
		add_filter('cpem-count-attachments', array( $this, 'new_count_attachments') ); 
	}	
	
	/**
	 * Save new limit to database
	 *
	 * @since     0.1
	 */
	function request_handler($request)
	{	
	 	if( !cp_is_screen_mediapicker() )
			return false;
		
		$user_only = false;
		if ( isset($request->extra_query_vars['useruploadsonly']) )
			$user_only = $request->extra_query_vars['useruploadsonly'];
		
		// save the new limit to the db		
		if ( $this->get_user_uploads_only() != $user_only ) {			
			$this->set_user_uploads_only($user_only);
		}
	}
	
	/**
	 * Set User Uploads Only
	 *
	 * Limit is saved to the current user, so every user can set it's own preference
	 *
	 * @since     0.1
	 */
	private function set_user_uploads_only( $state )
	{		
		$options = get_option('cpem_options');
		$options['user_uploads_only_'.$this->user_id] = $state;
		update_option('cpem_options', $options);	
	}
	
	/**
	 * Get User Uploads Only
	 *
	 * @since     0.1
	 */
	private function get_user_uploads_only()
	{
		$options 	= get_option('cpem_options');
		
		$value 		= false; // default	
		if ( isset($options['user_uploads_only_'.$this->user_id]) ) {
			$value = trim( esc_attr( $options['user_uploads_only_'.$this->user_id] ) );
		}
		
		$value = apply_filters( 'cp_user_uploads_only_', $value );
		$value = apply_filters( 'cp_user_uploads_only_'.$this->user_id, $value );
		
		return $value;
	}
	
	/**
	 * Filter WP Query for user uploads only
	 *
	 * @since     0.1
	 */
	public function show_user_uploads_only( $query )
	{
		$author = get_userdata($this->user_id);		
		
		if( cp_is_screen_mediapicker() && 'on' == $this->get_user_uploads_only() ) {
			$query->query_vars['author_name'] = $author->data->user_nicename;
		}
	}
	
	/**
	 * New Value for attachment count
	 *
	 * The new value is used for limiting the number of dropdown options for pagination
	 * The filter which is used can be found in more-rows.php.
	 *
	 * @since     0.1
	 */
	function new_count_attachments( $count )
	{
		if ( 'on' == $this->get_user_uploads_only() ) {
			global $wpdb;
			$count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_author = {$this->user_id} AND post_type = 'attachment' AND post_status = 'inherit'" );
		}

		return $count;
	}
	
	/**
	 * Register admin css
	 *
	 * @since     0.1
	 */
	public function admin_styles()
	{
		wp_enqueue_style( 'cpem-user-only', CPEM_URL.'/assets/css/user-only.css', array(), CPEM_VERSION, 'all' );	
	}
	
	/**
	 * Register admin scripts
	 *
	 * @since     0.1
	 */
	public function admin_scripts() 
	{
		wp_enqueue_script( 'cpem-user-only', CPEM_URL.'/assets/js/user-only.js', array('jquery'), CPEM_VERSION );
	}
	
	/**
	 * Makes variables available for jQuery
	 *
	 * @since     0.1
	 */
	public function admin_footer_scripts() 
	{
		$user_only = $this->get_user_uploads_only();
	
		echo "
		<script type='text/javascript'>
			var cpem_useruploadsonly = '{$user_only}';
		</script>";
	}
}

new Codepress_Mediapicker_User_Only;