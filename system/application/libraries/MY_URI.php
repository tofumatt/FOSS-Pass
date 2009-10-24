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
 * FOSS-Pass->Libraries->URI
 *
 * Add GET parameter functionality to the URI Class.
 *
 */
class MY_URI extends CI_URI {
	
	/**
	 * Constructor
	 *
	 * Rebuild the $_GET array.
	 *
	 */
	function MY_URI() {
		// Call the parent constructor
		parent::CI_URI();
		
		// On some server setups (including fosspass.org's own lighttpd 1.4 +
		// FastCGI), $_GET variables are a pain to get at. If $_GET isn't set,
		// try to rebuild it. This seems to happen especially when using
		// REQUEST_URI for URL routing
		if (!$_GET) {
			if (isset($_SERVER['QUERY_STRING']) and $_SERVER['QUERY_STRING'] != '')
				// Get the query string from the $_SERVER array; simple enough
				$query_string = $_SERVER['QUERY_STRING'];
			elseif (strpos($_SERVER['REQUEST_URI'], '?') !== false)
				// Filter out what should be the query string from the full REQUEST_URI
				$query_string = substr(strstr($_SERVER['REQUEST_URI'], '?'), 1);
			else
				$query_string = null; // There's probably no GET data to begin with...
			
			// Rebuild the $_GET array
			parse_str($query_string, $_GET);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Build a GET string
	 *
	 * Load the GET parameters into a string.
	 *
	 * @access	public
	 * @return	string
	 */
	public function get_string() {
		$string = '?';
		foreach($_GET as $key => $val)
			$string .= "$key=$val&";
		
		return ($string != '?') ? substr($string, 0, -1) : '';
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Build a url-encoded GET string
	 *
	 * Load the GET parameters into a string, encoding all of the values
	 * so they can be placed into a URL.
	 *
	 * @access	public
	 * @return	string
	 */
	public function get_string_encoded() {
		$string = '?';
		foreach($_GET as $key => $val)
			$string .= "$key=" . urlencode($val) . "&amp;";
		
		return ($string != '?') ? substr($string, 0, -5) : '';
	}
	
	// --------------------------------------------------------------------

	/**
	 * Parse the REQUEST_URI
	 *
	 * Due to the way REQUEST_URI works it usually contains path info
	 * that makes it unusable as URI data.  We'll trim off the unnecessary
	 * data, hopefully arriving at a valid URI that we can use.
	 * Modified to destroy the query string part of the URI for URL routing.
	 *
	 * @access	private
	 * @return	string
	 */
	function _parse_request_uri() {
		if (!isset($_SERVER['REQUEST_URI']) or $_SERVER['REQUEST_URI'] == '')
			return '';
		
		$request_uri = preg_replace("|/(.*)|", "\\1", str_replace("\\", "/", $_SERVER['REQUEST_URI']));
		
		if ($request_uri == '' or $request_uri == SELF)
			return '';
		
		$fc_path = FCPATH . SELF;
		if (strpos($request_uri, '?') !== false)
			$fc_path .= '?';
		
		$parsed_uri = explode("/", $request_uri);
		
		$i = 0;
		foreach(explode("/", $fc_path) as $segment) {
			if (isset($parsed_uri[$i]) && $segment == $parsed_uri[$i])
				$i++;
		}
		
		$parsed_uri = implode("/", array_slice($parsed_uri, $i));
		
		if ($parsed_uri != '')
			$parsed_uri = '/' . $parsed_uri;
		
		// Get rid of the query string for routing purposes
		$pos = strpos($parsed_uri, '?');
		if ($pos !== false)
			$parsed_uri = substr($parsed_uri, 0, $pos);
		
		return $parsed_uri;
	}

}