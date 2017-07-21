<?php

/**
 * Codepress_Mediapicker_Preview
 *
 * @since     0.1
 *
 */
class Codepress_Mediapicker_Preview
{	
	/**
	 * Constructor
	 *
	 * @since     0.1
	 */
	function __construct()
	{
		add_filter( 'media_meta', array( $this, 'src_image_full'), 10, 2 );
		
		// styling & scripts
		add_action( 'admin_print_styles', array( $this, 'admin_styles') );
		add_action( 'admin_print_scripts', array( $this, 'admin_scripts') );		
	}
	
	/**
	 * Full image of the thumbnail
	 *
	 * We need to set the the full image path for the preview
	 *
	 * @since     0.1
	 */
	public function src_image_full( $media_dims, $post )
	{
		if ( !cp_is_screen_mediapicker() )
			return false;
		
		$src = wp_get_attachment_image_src( $post->ID, 'full' );

		if ( !empty($src[0]) && !empty($src[1]) && !empty($src[2]) ) {
				
			$h = $src[1];
			$w = $src[2];			
			
			$new_height = 350;
			$new_width 	= 350;
			
			// fixed dimensions
			if ( $h < $new_height ) $new_height = $h;
			if ( $w < $new_width ) 	$new_width 	= $w;
			
			// aspect ratio
			if ( $h / $w > $new_height / $new_width ) {
                $new_width = ceil($w * $new_height / $h);
            } else {
                $new_height = ceil($h * $new_width / $w);
            }			
			
			$media_dims .= "
				<span class='preview-full-src hidden'>{$src[0]}</span>
				<span class='preview-full-width hidden'>{$new_width}</span>
				<span class='preview-full-height hidden'>{$new_height}</span>
			";

		}

		return $media_dims;		
	}
	
	/**
	 * Register admin css
	 *
	 * @since     0.1
	 */
	public function admin_styles()
	{
		wp_enqueue_style( 'cpem-preview', CPEM_URL.'/assets/css/preview.css', array(), CPEM_VERSION, 'all' );	
	}
	
	/**
	 * Register admin scripts
	 *
	 * @since     0.1
	 */
	public function admin_scripts() 
	{
		wp_enqueue_script( 'cpem-preview', CPEM_URL.'/assets/js/preview.js', array('jquery', 'hoverIntent'), CPEM_VERSION );
	}
}

new Codepress_Mediapicker_Preview;