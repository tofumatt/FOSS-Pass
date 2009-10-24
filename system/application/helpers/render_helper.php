<?php if (!defined('BASEPATH')) exit; // Prevent direct file access
/**
 * FOSS-Pass
 *
 * Link to your license.
 *
 * @package     FOSS-Pass
 * @author      Matthew Riley MacPherson
 * @copyright   Copyright (c) 2009, Matthew Riley MacPherson
 * @license     http://fosspass.org/license/bsd?author=Matthew+Riley+MacPherson&organization=The+Lonely+Web&year=2009
 * @link        http://fosspass.org/about
 */

// ------------------------------------------------------------------------

/**
 * FOSS-Pass->Helpers->Render
 *
 * Helper functions to allow view files to render additional files
 * on-demand.
 *
 */

// --------------------------------------------------------------------

/**
 * Render a file
 *
 * Render a file as a view and return the result.
 *
 * @access	public
 * @param	string		$file			File to render
 * @return	string
 */
function render($file) {
	// Get access to CodeIgniter
	$CI =& get_instance();
	
	// Load the render library if we haven't already
	$CI->load->library('render');
	
	// Render the file and return the string
	return $CI->render->view($file, true);
}