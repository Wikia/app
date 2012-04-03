<?php

/**
 * CodeLintPhp
 *
 * Class used for linting PHP code
 *
 * Requires "phplint" binary - <http://www.icosaedro.it/phplint/download.html>
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class CodeLintPhp extends CodeLint {

	// file name pattern - used when linting directories
	protected $filePattern = '*.php';
	private $phpLintVersion = null;

	private function getPhpLintVersion() {
		if (is_null($this->phpLintVersion)) {
			exec('phplint --version', $lines);

			// take the first line
			$this->phpLintVersion = reset($lines);
		}

		return $this->phpLintVersion;
	}

	/**
	 * Run phplint for a given file
	 *
	 * @param string $fileName file to run phplint for
	 * @return string output from phplint
	 */
	protected function runPhpLint($fileName) {
		$output = $this->runCommand('phplint', array(
			'--no-overall',
			 '--no-print-source',
			 '--no-print-context',
			 '--no-print-file-name',
			$fileName
		));

		if (!empty($output)) {
			$output = array(
				'errors' => $output['output'],
				'tool' => $this->getPhpLintVersion(),
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
		$output = $this->runPhpLint($fileName);

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