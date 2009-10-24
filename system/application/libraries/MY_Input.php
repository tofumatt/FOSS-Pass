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
 * FOSS-Pass->Libraries->Input
 *
 * Prevent CodeIgniter from destroying the $_GET array.
 * That is all.
 *
 */
class MY_Input extends CI_Input {
	
	/**
	 * Constructor
	 *
	 * Allow the $_GET array; otherwise the same as the default Input
	 * class constructor.
	 *
	 */
	function MY_Input() {
		log_message('debug', "Input Class Initialized");
		
		$CFG =& load_class('Config');
		$this->use_xss_clean = ($CFG->item('global_xss_filtering') === true) ? true : false;
		$this->allow_get_array = true;
		$this->_sanitize_globals();
	}
	
}