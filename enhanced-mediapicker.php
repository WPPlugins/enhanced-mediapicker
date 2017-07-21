<?php
/*
Plugin Name: 		Enhanced Mediapicker
Version: 			0.2
Description: 		Enhances the mediapicker with some nice features. It will add a grid-list view, the option to show more then 10 items and a preview.
Author: 			Codepress
Author URI: 		http://www.codepress.nl
Plugin URI: 		http://wordpress.org/extend/plugins/enhanced-mediapicker/
Text Domain: 		enhanced-mediapicker
Domain Path: 		/languages
License:			GPLv2

Copyright 2012  Codepress  info@codepress.nl

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License version 2 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'CPEM_VERSION', 	'0.2' );
define( 'CPEM_URL', 		plugins_url('', __FILE__) );
define( 'CPEM_TEXTDOMAIN', 'enhanced-mediapicker' );

// only run plugin in the admin interface
if ( !is_admin() )
	return false;

// translations
load_plugin_textdomain( CPEM_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );	

/**
 * Codepress_Mediapicker_User_Only
 *
 * @since     0.1
 *
 */
class Codepress_Enhanced_Mediapicker
{
	/**
	 * Constructor
	 *
	 * @since     0.1
	 */
	function __construct()
	{		
		// wp is loaded
		add_action( 'wp_loaded', array( $this, 'init') );
		
		// javascript. todo: use wp_localize_script()
		add_action( 'admin_print_footer_scripts', array( $this, 'admin_footer_scripts') );
	}
	
	/**
	 * Initialize plugin.
	 *
	 * @since     0.1
	 */
	function init()
	{
	
		/**
		 * Utility Functions
		 *
		 * @since     0.1
		 */
		require_once dirname( __FILE__ ) . '/classes/utility.php';

		/**
		 * Initialize Codepress_Mediapicker_Limit
		 *
		 * @since     0.1
		 */
		require_once dirname( __FILE__ ) . '/classes/more-rows.php';

		/**
		 * Initialize Codepress_Mediapicker_Grid
		 *
		 * @since     0.1
		 */
		require_once dirname( __FILE__ ) . '/classes/grid-list.php';

		/**
		 * Initialize Codepress_Mediapicker_Preview
		 *
		 * @since     0.1
		 */
		require_once dirname( __FILE__ ) . '/classes/preview.php';

		/**
		 * Initialize Codepress_Mediapicker_User_Only
		 *
		 * @since     0.1
		 */
		require_once dirname( __FILE__ ) . '/classes/user-only.php';
		
	}
	
	/**
	 * Translations for Javascript
	 *
	 * todo: use wp_localize_script()
	 *
	 * @since     0.1
	 */
	public function admin_footer_scripts() 
	{		
		echo "
		<script type='text/javascript'>
			var cpem_L10n = {
				'all'		 : '".__('All', CPEM_TEXTDOMAIN)."',
				'items'		 : '".__('Media items ', CPEM_TEXTDOMAIN)."',
				'my_uploads' : '".__('Show my uploads only', CPEM_TEXTDOMAIN)."'
			};
		</script>";
	}
}
new Codepress_Enhanced_Mediapicker;