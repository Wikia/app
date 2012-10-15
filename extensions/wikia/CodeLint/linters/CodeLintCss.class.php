<?php

/**
 * CodeLintCss
 *
 * Class used for linting CSS style sheets
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class CodeLintCss extends CodeLint {

	// file name pattern - used when linting directories
	protected $filePattern = '*.css';

	/**
	 * Run csslint for a given file
	 *
	 * @param string $fileName file to run csslint for
	 * @param array $params additional params to be passed to JS
	 * @return string output from csslint
	 */
	protected function runCssLint($fileName, $params = array()) {
		// generate path to "wrapper" script running csslint
		$runScript = dirname(__FILE__) . '/../js/run-csslint.js';

		// generate path to csslint.js
		$libDirectory = F::app()->getGlobal('IP') . '/lib';
		$params['csslint'] = "{$libDirectory}/csslint/csslint-node.js";

		// file to perform lint on
		$params['file'] = $fileName;

		$output = $this->runUsingNodeJs($runScript, $params);

		return $output;
	}

	/**
	 * Filter out message we don't really want in the report
	 *
	 * @param array $error error entry reported by csslint
	 * @return boolean returns true if the entry should be kept
	 */
	public function filterErrorsOut($error) {
		return true;
	}

	/**
	 * Simplify error report to match the generic format
	 *
	 * @param array $entry single entry from error report
	 * @return array modified entry
	 */
	public function internalFormatReportEntry($entry) {
		return array(
			'error' => $entry['message'],
			'line' => isset($entry['line']) ? $entry['line'] : 1
		);
	}

	/**
	 * Perform lint on a file and return list of errors
	 *
	 * @param string $fileName file to be checked
	 * @return array list of reported warnings
	 */
	public function internalCheckFile($fileName) {
		$output = $this->runCssLint($fileName);

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
			//case "Use of !important":
			case "Rule is empty.":

			// * html #foo (IE6 specific fix)
			case "IE6 specific fix found.":

			// enforce special comment is SASS files when defining background images
			case "Background image defined, but /* \$wgCdnStylePath */ comment is missing":
				$ret = true;
				break;

			default:
				$ret = false;
		}

		// Duplicate property 'XXX' found.
		if (strpos($errorMsg, 'Duplicate property ') === 0) {
			$ret = true;
		}

		// Syntax error (Expected LBRACE / Unexpected token)
		if (strpos($errorMsg, 'Expected ') === 0 || strpos($errorMsg, 'Unexpected token ') === 0) {
			$ret = true;
		}

		// Too many !important declarations
		if (strpos($errorMsg, 'Too many !important declarations ') === 0) {
			$ret = true;
		}

		// Unknown CSS property
		if (strpos($errorMsg, 'Unknown property ') === 0) {
			$ret = true;
		}

		return $ret;
	}
}