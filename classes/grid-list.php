<?php

/**
 * Codepress_Mediapicker_Grid
 *
 * @since     0.1
 *
 */
class Codepress_Mediapicker_Grid
{	
	/**
	 * Constructor
	 *
	 * @since     0.1
	 */
	function __construct()
	{
		// styling & scripts
		add_action( 'admin_print_styles', array( $this, 'admin_styles') );
		add_action( 'admin_print_scripts', array( $this, 'admin_scripts') );
	}
	
	/**
	 * Register admin css
	 *
	 * @since     0.1
	 */
	public function admin_styles()
	{
		wp_enqueue_style( 'cpem-grid-list', CPEM_URL.'/assets/css/grid-list.css', array(), CPEM_VERSION, 'all' );	
	}
	
	/**
	 * Register admin scripts
	 *
	 * @since     0.1
	 */
	public function admin_scripts() 
	{
		wp_enqueue_script( 'cpem-grid-list', CPEM_URL.'/assets/js/grid-list.js', array('jquery'), CPEM_VERSION );
	}
}

new Codepress_Mediapicker_Grid;
