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
 * FOSS-Pass->Libraries->Controller
 *
 * Extends the CodeIgniter Controller, provides a system-wide data array,
 * and initializes some classes and variables.
 *
 */

class MY_Controller extends Controller {
	
	// The data array used throughout FOSS-Pass. Controllers inherit the
	// array, and each key becomes a variable available to theme/view
	// files (through PHP's extract() function)
	public $data = array(
		'author' => '[author]',
		'content' => '',
		'lang' => 'en',
		'licenses' => array( // Honestly, this is already insane; I'll probably put it in a DB soon...
			'apache-2.0' => array(
				'name' => "Apache License (Version 2.0)",
				'attributes' => array()
			),
			'bsd' => array(
				'name' => "New BSD License",
				'attributes' => array('author', 'organization', 'year')
			),
			'codeigniter' => array(
				'name' => "CodeIgniter License Agreement",
				'attributes' => array()
			),
			'epl-1.0' => array(
				'name' => "Eclipse Public License (Version 1.0)",
				'attributes' => array()
			),
			'gpl-2' => array(
				'name' => "GNU Public License (Version 2)",
				'attributes' => array()
			),
			'lgpl-2.1' => array(
				'name' => "Lesser GNU Public License (Version 2.1)",
				'attributes' => array()
			),
			'mit' => array(
				'name' => "MIT License",
				'attributes' => array('author', 'year')
			),
			'mpl-1.1' => array(
				'name' => "Mozilla Public License (Version 1.1)",
				'attributes' => array()
			)
		),
		'organization' => '[organization]',
		'pages' => array(
			'about' => "About This Site",
			'all-licenses' => "All Licenses",
			'main' => "Permalinks for FOSS Licenses",
			'popular-licenses' => "Popular Licenses"
		),
		'popular_licenses' => array('bsd', 'gpl-2', 'lgpl-2.1', 'mit'),
		'title' => 'PAGE TITLE',
		'year' => '[year]'
	);
	
	/**
	 * Constructor
	 *
	 * Setup query string variables (mostly for templates).
	 *
	 */
	function MY_Controller() {
		// Load the CodeIgniter Controller constructor
		parent::Controller();
		
		// Use as a base URL for items in the "public" folder (JavaScript, stylesheets, etc.)
		$this->data['base_url'] = $this->config->item('base_url');
		
		// Make the GET string available to views
		$this->data['get_string'] = $this->uri->get_string();
		$this->data['encoded_get_string'] = $this->uri->get_string_encoded();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get the name of a license
	 *
	 * Return the name of a license based on the URL => license name mapping.
	 *
	 * @access	public
	 * @author	tofumatt (Matthew Riley MacPherson)
	 * @param	string		$url		URL of the license
	 * @return	void
	 */
	public function license_name($url) {
		$key = preg_replace('/\//', '-', $url);
		return (isset($this->data['licenses'][$key])) ? $this->data['licenses'][$key]['name'] : false;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get the name of this page
	 *
	 * Return the name of this page based on the URL => page name mapping.
	 *
	 * @access	public
	 * @author	tofumatt (Matthew Riley MacPherson)
	 * @param	string		$url		URL of page
	 * @return	void
	 */
	public function page_name($url) {
		$key = preg_replace('/\//', '-', $url);
		return (isset($this->data['pages'][$key])) ? $this->data['pages'][$key] : false;
	}
	
}