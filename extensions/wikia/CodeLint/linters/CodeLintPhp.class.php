<?php

/**
 * CodeLintPhp
 *
 * Class used for linting PHP code
 *
 * Requires PHP Storm local installation
 *
 * UNDER DEVELOPMENT
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class CodeLintPhp extends CodeLint {

	// file name pattern - used when linting directories
	protected $filePattern = '*.php';

	/**
	 * Run PHP Storm's Code Inspect for a given file
	 *
	 * Actually, PHP storm will be run for a given directory.
	 * XML reports will then be parsed to get issues for given file.
	 *
	 * @param string $fileName file to run Code Inspect for
	 * @return string output from Code Inspect
	 */
	protected function runCodeInspect($fileName) {
		global $wgPHPStormPath;

		$start = microtime(true);

		$lintProfile = dirname(__FILE__) . '/php/profiles/phplint.xml';
		$projectMetaData = dirname(__FILE__) . '/php/project';

		// create a temporary directory for Code Inspect results
		$tmpDir = wfTempDir() . '/phpstorm/' . uniqid('lint');
		wfMkdirParents($tmpDir);

		// code directory to check
		$dir = dirname($fileName);

		$cmd = sprintf('/bin/sh %s/inspect.sh %s %s %s -d %s -v2',
			$wgPHPStormPath,
			$projectMetaData, // PHP Storm project directory
			$lintProfile, // XML file with linting profile
			$tmpDir, // output directory
			$dir // directory to check
		);

		echo "Running PHP storm <{$cmd}>...";

		$retval = 0;
		$output = array();
		exec($cmd, $output, $retVal);

		// get the version of PhpStorm
		$tool = '';

		foreach($output as $line) {
			if (strpos($line, 'Starting up JetBrains PhpStorm') !== false) {
				preg_match('#JetBrains PhpStorm [\\d\\.]+#', $line, $matches);
				$tool = $matches[0];
			}
		}

		echo implode("\n", $output); // debug
		echo " [ok]\n";

		// format results
		$output = array(
			'time' => microtime(true) - $start,
			'tool' => $tool,
		);

		return $output;
	}

	/**
	 * Get issues for a given fle
	 *
	 * @param string $fileName file to get issues for
	 * @return string output from Code Inspect
	 */
	protected function getFileIssues($fileName) {
		$output = $this->runCodeInspect($fileName);

		if (!empty($output)) {
			$output = array(
				'errors' => array(), //$output['output'],
				'tool' => $output['tool'],
				'time' => $output['time'],
			);
		}

		return $output;
	}

	/**
	 * Filter out message we don't really want in the report
	 *
	 * @param array $error error entry reported by phplint
	 * @return boolean returns true if the entry should be kept
	 */
	public function filterErrorsOut($error) {
		$remove = true;

		switch($error['error']) {
			// keep the following
			case "ERROR: unreachable statement":
				$remove = false;
				break;
		}

		// notice: in the last function, variable `$foo' declared global but not used
		if (startsWith($error['error'], 'notice: in the last function, variable')) {
			$remove = false;
		}

		// FATAL ERROR: expected `;', found symbol sym_variable
		if (startsWith($error['error'], 'FATAL ERROR')) {
			$remove = false;
		}

		// Variable `$wgHooks' assigned but never used
		if (strpos($error['error'], 'variable `$wg') !== false && endsWith($error['error'], ' assigned but never used')) {
			$remove = true;
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
		// remove entry type (error / warning / notice)
		if (isset($entry['error'])) {
			list($type, $msg) = explode(': ', $entry['error'], 2);
			$entry['error'] = ucfirst($msg);

			if ($type === 'FATAL ERROR') {
				$entry['error'] = "FATAL ERROR: {$entry['error']}";
			}
		}

		return $entry;
	}

	/**
	 * Perform lint on a file and return list of errors
	 *
	 * @param string $fileName file to be checked
	 * @return array list of reported warnings
	 */
	public function internalCheckFile($fileName) {
		$output = $this->getFileIssues($fileName);

		// parse raw output
		if (!empty($output['errors'])) {
			foreach($output['errors'] as &$entry) {
				list($fileName, $lineNo, $msg) = explode(':', $entry, 3);

				$entry = array(
					'error' => ltrim($msg),
					'line' => intval($lineNo),
				);
			}
		}

		return $output;
	}

	/**
	 * Decide whether given error is important and should be eventaully marked in the report
	 *
	 * @param string $errorMsg error message
	 * @return boolean is it an important error
	 */
	protected function isImportantError($errorMsg) {
		$ret = false;

		switch($errorMsg) {
			case 'Unreachable statement':
				$ret = true;
				break;
		}

		if (endsWith($errorMsg, 'declared global but not used')) {
			$ret = true;
		}

		if (startsWith($errorMsg, 'FATAL ERROR') && strpos($errorMsg, 'old-style syntax') === false) {
			#$ret = true; // TODO
		}

		return $ret;
	}
}
