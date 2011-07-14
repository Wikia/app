<?php

/**
 * CodeLint
 *
 * Generic class providing interface for jslint.js library using nodejs
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class CodeLint {

	/**
	 * Check whether nodejs is installed
	 *
	 * @return boolean is nodejs installed
	 */
	public function isNodeJsInstalled() {
		return !is_null(`which node`);
	}

	/**
	 * Get nodejs is version
	 *
	 * @return string nodejs version
	 */
	public function getNodeJsVersion() {
		return trim(`node --version`);
	}

	/**
	 * Run jslint for a given file
	 *
	 * @param string $fileName file to run jslint for
	 * @return string output from jslint
	 */
	protected function runJsLint($fileName) {
		// generate path to script which will run jslint
		$runScript = escapeshellcmd(dirname(__FILE__) . '/js/run-lint.js');

		// generate path to jslint.js
		$libDirectory = F::app()->getGlobal('IP') . '/lib';
		$jsLint = escapeshellcmd("{$libDirectory}/jslint/jslint.js");

		$fileName = escapeshellcmd($fileName);

		$cmd = "node {$runScript} --jslint={$jsLint} --file={$fileName}"; var_dump($cmd);
		exec($cmd, $output, $retVal);

		if ($retVal == 0 ) {
			// success!
			$output = implode("\n", $output);
			$res = json_decode($output, true /* $assoc */);
		}
		else {
			$res = null;
		}

		return $res;
	}

	/**
	 * Check given file and return list of warnings
	 *
	 * @param string $fileName file to be checked
	 * @return array list of reported warnings
	 */
	public function checkFile($fileName) {}

	/**
	 * Check all files in a given directory recursively
	 *
	 * @param string $directoryName directory to be checked
	 * @return array list of reported warnings
	 */
	public function checkDirectory($directoryName) {

	}
}