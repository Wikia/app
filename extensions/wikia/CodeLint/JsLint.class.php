<?php

/**
 * JsLint
 *
 * Class used for linting JS code
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class JsLint extends CodeLint {

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
			'addOnloadHook',
			'AjaxLogin',
			'CKEDITOR',
			'FB',
			'insertTags',
			'jQuery',
			'GlobalTriggers',
			'Liftium',
			'Observable',
			'RTE',
			'skin',
			'stylepath',
			'Timer',
			'YAHOO',
			'WET',
		);
	}

	/**
	 * Filter out message we don't really want in the report
	 *
	 * @param array $error error entry reported by jslint
	 * @return boolean returns true if entry should be removed
	 */
	public function filterErrorsOut($error) {
		$remove = is_null($error) || !isset($error['id']);

		if (isset($error['raw'])) {
			switch($error['raw']) {
				// ignore wgSomethingSomething JS globals
				case "'{a}' was used before it was defined.":
					$varName = $error['a'];

					if ((substr($varName, 0, 2) == 'wg')) {
						$remove = true;
					}
					break;

				// allow var in for loops
				case "Move 'var' declarations to the top of the function.":
					$remove = true;
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
			case "eval is evil.":
			case "Empty block.":
			case "'alert' was used before it was defined.":
			case "'console' was used before it was defined.":
			case "Expected '{' and instead saw 'return'.":
			// don't define functions within other functions
			case "Function statements should not be placed in blocks. Use a function expression or move the statement to the top of the outer function.":
				$ret = true;
				break;

			default:
				$ret = false;
		}

		return $ret;
	}
}