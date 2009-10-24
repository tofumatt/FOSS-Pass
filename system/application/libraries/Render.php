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
 * FOSS-Pass->Libraries->Render
 *
 * Renders data to partials and full pages from template files.
 *
 */

class Render {
	
	/**
	 * Constructor
	 *
	 * Load the render library for template files to use.
	 *
	 */
	function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('render');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Assign content
	 *
	 * Load content from a template and add it to the FristPost
	 * data array's 'content' variable.
	 *
	 * @access	public
	 * @param	string		$template			Filename of the template
	 * @param	string		$folder				Folder container the template
	 * @return	bool
	 */
	public function content($template, $folder=null) {
		$content = $this->view($folder . $template, true);
		
		// We add the template data we've created to the content
		// theme variable, in case we want to make multiple calls
		// to this method
		$this->CI->data['content'] = $content;
		return true;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Send HTML output to the client
	 *
	 * Load a content wrapper from a template and send the output
	 * to the client.
	 *
	 * @access	public
	 * @param	string		$template			Filename of the template
	 * @return	bool
	 */
	public function page($template='page') {
		if (isset($this->CI->force_html))
			$template = 'page.html';
		
		// Send out the correct Content-Type
		if (preg_match('/\.(.*)$/', $template, $format)) {
			switch ($format[1]) {
				case 'txt':
					$this->CI->output->set_header('Content-Type: text/plain');
					break;
			}
		}
		
		// Load up the final view!
		$this->view($template);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create and return a partial
	 *
	 * Create a partial from a template and return it.
	 *
	 * @access	public
	 * @param	string		$template			Filename of the template
	 * @param	string		$folder				Folder container the template
	 * @return	bool
	 */
	public function partial($template, $folder=null) {
		return $this->view($folder . $template, true);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Render a view from a template file
	 *
	 * Performs actual rendering of template files.
	 * Rendered content can be sent to the browser or returned as a
	 * partial (a string). This method should rarely be called directly;
	 * instead, call one of the abstracted rendering functions.
	 *
	 * @access	public
	 * @param	string		$template			Filename of the template
	 * @param	bool		$partial			Return the view or send it to the client
	 * @return	string
	 */
	public function view($template, $partial=false) {
		// If we omitted the template extension in the call, add it now
		if (strpos($template, '.') === false)
			$template .= '.html';
		
		// We're basically just rendering from files; if the file isn't
		// found, it's a 404
		if (!file_exists(APPPATH . "views/$template")) {
			$this->CI->force_html = true;
			$this->CI->data['title'] = 'Page not found!';
			return $this->CI->load->view("error-404.html", $this->CI->data, $partial);
		}
		
		// Render the actual template file with the appropriate data
		return $this->CI->load->view("$template", $this->CI->data, $partial);
	}
	
}