<?php

/**
 * CodeLintJs
 *
 * Class used for linting JS code
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class CodeLintJs extends CodeLint {

	// array of known JS globals
	private $knownGlobals;

	// file name pattern - used when linting directories
	protected $filePattern = '*.js';

	/**
	 * Initialize list of known JS globals
	 */
	function __construct() {
		$this->knownGlobals = array(
			'$',
			'$G',
			'CKEDITOR',
			'define',
			'FB',
			'Geo',
			'BannerNotifications',
			'GlobalTriggers',
			'jQuery',
			'mw',
			'mediaWiki',
			'Modernizr',
			'Mustache',
			'Node',
			'Observable',
			'require',
			'RTE',
			'skin',
			'stylepath',
			'ThemeDesigner',
			'Timer',
			'WET',
			'Wikia',
			'YAHOO',
		);
	}

	/**
	 * Run jslint for a given file
	 *
	 * @param string $fileName file to run jslint for
	 * @param array $params additional params to be passed to JS
	 * @return string output from jslint
	 */
	protected function runJsLint($fileName, Array $params = array()) {
		global $IP;

		// generate path to "wrapper" script running jslint
		$runScript = __DIR__ . '/../js/run-jslint.js';

		// file to perform lint on
		$params['file'] = $fileName;

		$output = $this->runUsingNodeJs($runScript, $params); //var_dump($output);

		return $output;
	}

	/**
	 * Filter out message we don't really want in the report
	 *
	 * @param array $error error entry reported by jslint
	 * @return boolean returns true if the entry should be kept
	 */
	public function filterErrorsOut($error) {
		/*
		 * Error entry:
		 *
		array(7) {
		  ["id"]=>
		  string(7) "(error)"
		  ["raw"]=>
		  string(37) "'{a}' was used before it was defined."
		  ["evidence"]=>
		  string(68) "		if( confirm( 'Are you sure you want to delete this element?' ) ) {"
		  ["line"]=>
		  int(10)
		  ["character"]=>
		  int(13)
		  ["a"]=>
		  string(7) "confirm"
		  ["reason"]=>
		  string(41) "'confirm' was used before it was defined."
		}
		*/

		$remove = is_null($error) || !isset($error['id']);

		if (isset($error['raw'])) {
			switch($error['raw']) {
				// ignore wgSomethingSomething global variables and wfFoo global functions
				case "'{a}' was used before it was defined.":
					$varName = $error['a'];
					$varPrefix = substr($varName, 0, 2);

					if (in_array($varPrefix, array('wg', 'wf'))) {
						$remove = true;
					}
					break;

				// ignore errors about missing semicolons after {} blocks
				case "Expected '{a}' and instead saw '{b}'.":
					$remove = ($error['a'] == ';') && (substr($error['evidence'], -1, 1) == '}');
					break;

				// ignore errors about missing radix parameter in parseInt()
				case "Missing radix parameter.":
				// ignore mixed whitespaces
				case "Mixed spaces and tabs.":
				// ignore (function(){...})()
				case "Move the invocation into the parens that contain the function.":
				// ignore strings defined in multiple lines
				case "This is an ES5 feature.":
				// function() {foo()} -> foo();
				case "Expected ';' and instead saw '}'.":
				// allow var in for loops
				case "Move 'var' declarations to the top of the function.":
				// 'd' was used before it was defined.
				case "'{a}' was used before it was defined.":
				case "Unexpected '++'.":
				// allow for in loops
				case "Bad for in variable '{a}'.":
				// don't be so restrictive about whitespaces
				case "Missing space between '{a}' and '{b}'.":
				case "Unexpected space between '{a}' and '{b}'.":
				case "Expected '{a}' at column {b}, not column {c}.":
				// allow object['foo'] notation
				case "['{a}'] is better written in dot notation.":
				// remove noise
				case "Unexpected 'else' after 'return'.":
				case "Unexpected 'in'. Compare with undefined, or use the hasOwnProperty method instead.":
					$remove = true;
					break;
			}
		}

		return !$remove;
	}

	/**
	 * Simplify error report to match the generic format
	 *
	 * @param array $entry single entry from error report
	 * @return array modified entry
	 */
	public function internalFormatReportEntry($entry) {
		return array(
			'error' => $entry['reason'],
			'line' => $entry['line'],
		);
	}

	/**
	 * Perform lint on a file and return list of errors
	 *
	 * @param string $fileName file to be checked
	 * @return array list of reported warnings
	 */
	public function internalCheckFile($fileName) {
		$output = $this->runJsLint($fileName, array(
			'knownGlobals' => implode(',', $this->knownGlobals),
		));

		return $output;
	}

	/**
	 * Decide whether given error is important and should be eventaully marked in the report
	 *
	 * @param string $errorMsg error message
	 * @return boolean is it an important error
	 */
	protected function isImportantError($errorMsg) {
		switch($errorMsg) {
			case "Missing 'break' after 'case'.":
			case "Empty block.":
			case "'alert' was used before it was defined.":
			case "'console' was used before it was defined.":
			// if blocks should be wrapped in {}
			//case "Expected '{' and instead saw 'return'.":
			// don't define functions within other functions
			case "Function statements should not be placed in blocks. Use a function expression or move the statement to the top of the outer function.":
			// unsafe UTF character (usually it's BOM)
			case "Unsafe character.":
			// there's no such thing as global FCK object in JS :)
			case "'FCK' was used before it was defined.":
			// return statement followed by the object in the next line (but this will return undefined)
			case "Unreachable '{' after 'return'.":
			// use [] and {} literals, instead of new Array() and new Object()
			case "Use the array literal notation [].":
			case "Use the object literal notation {}.":
			// Trailing Comma Of Death
			case "Unexpected ','.":
			case "Don't make functions within a loop.":
			// use encodeURIComponent instead
			case "'escape' was used before it was defined.":
			// enforce new when constructing things
			case "Missing 'new'.":
			// eval is evil !!!1111
			case "eval is evil.":
			case "The Function constructor is eval.":
			case "Implied eval is evil. Pass a function instead of a string.":
			case 'jQuery.live() is deprecated':
			case 'Use $.show or $.hide':
			case 'Deprecated skin check found':
			case 'Deprecated JSON handling function called (use native JSON object)':
			case 'Use of deprecated Oasis module API (use $.nirvana)':
			case 'Use of direct call to wikia.php (use $.nirvana)':
			case 'debugger statement found':
			case 'Use of YUI library (migrate to jQuery)':
				$ret = true;
				break;

			default:
				$ret = false;
		}

		// Unreachable 'XXX' after 'return'.
		if (strpos($errorMsg, 'Unreachable ') === 0 && strpos($errorMsg, "after 'return'.") !== false) {
			$ret = true;
		}

		// hardcoded values (BugId:12757)
		if (strpos($errorMsg, 'Found hardcoded value') === 0) {
			$ret = true;
		}

		// Don't pass a string to setInterval/setTimeout (implied eval)
		if (strpos($errorMsg, 'implied eval') !== false) {
			$ret = true;
		}

		// 'fixalpha' is deprecated in MW 1.19
		if (strpos($errorMsg, 'is deprecated in MW 1.19') !== false) {
			$ret = true;
		}

		//  Not cached jQuery selector found - $('#foo')
		if (strpos($errorMsg, 'Not cached jQuery selector found') !== false) {
			$ret = true;
		}

		return $ret;
	}
}
