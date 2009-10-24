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
 * FOSS-Pass->Controllers->License
 *
 * Interacts with the licenses on the site (displays all/individual licenses,
 * etc.).
 *
 */

class License extends MY_Controller {
	
	/**
	 * Constructor
	 *
	 * Load common classes and set class variables.
	 *
	 */
	function License() {
		parent::MY_Controller();
		
		$this->load->library('render');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Load a generic page from a view
	 *
	 * Load a view.
	 *
	 * @access	public
	 * @author	tofumatt (Matthew Riley MacPherson)
	 * @param	string		$view		Page to load
	 * @return	void
	 */
	public function page($view='main') {
		// Cache the output of this page
		$this->output->cache(CACHE_EXPIRY);
		
		$this->data['title'] = $this->page_name($view);
		
		// Render the page from the view file
		$this->render->content("page-$view");
		$this->render->page();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Load a specific license with optional info
	 *
	 * Load a license (specified in the first argument), then use
	 * GET parameters to add optional info (like author, year, etc.)
	 *
	 * @access	public
	 * @author	tofumatt (Matthew Riley MacPherson)
	 * @param	string		$license		License to load
	 * @param	string		$format			Output format (HTML, plaintext, etc.)
	 * @return	void
	 */
	public function view($license, $format=null) {
		// Cache the output of this page
		$this->output->cache(CACHE_EXPIRY);
		
		// The default output format is HTML
		if ($format == null)
			$format = 'html';
		
		// Setup some view variables
		$this->data['license'] = isset($this->data['licenses'][$license]) ? $license : null;
		$this->data['license_attributes'] = isset($this->data['licenses'][$license]['attributes']) ? $this->data['licenses'][$license]['attributes'] : null;
		$this->data['license_page'] = isset($this->data['licenses'][$license]) ? true : false;
		$this->data['title'] = $this->license_name($license);
		
		// Grab any license parameters from $_GET and use them in the license text
		if (!empty($this->data['license_attributes'])) {
			foreach ($this->data['license_attributes'] as $param) {
				if ($this->input->get($param))
					$this->data[$param] = $this->input->get($param);
			}
		}
		
		// Render the license from the view file
		$this->render->content("$license.$format", 'licenses/');
		$this->render->page("page.$format");
	}
	
}