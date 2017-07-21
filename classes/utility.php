<?php

/**
 * Check if current screen is the mediapicker
 *
 * @since     0.1
 */
function cp_is_screen_mediapicker() 
{
	global $current_screen;
	
	if( isset($current_screen->id) && 'media-upload' == $current_screen->id && isset($_GET['tab']) && 'library' == $_GET['tab'] )
		return true;
	
	return false;
}