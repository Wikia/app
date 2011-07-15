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

abstract class CodeLint {

	// file name pattern - used when linting directories
	protected $filePattern = null;

	/**
	 * Check whether nodejs is installed
	 *
	 * @return boolean is nodejs installed
	 */
	static public function isNodeJsInstalled() {
		return !is_null(`which node`);
	}

	/**
	 * Get nodejs is version
	 *
	 * @return string nodejs version
	 */
	static public function getNodeJsVersion() {
		return trim(`node --version`);
	}

	/**
	 * Find files matching a pattern using PHP "glob" function and recursion
	 *
	 * @see http://www.redips.net/php/find-files-with-php/
	 *
	 * @return array containing all pattern-matched files
	 *
	 * @param string $dir     - directory to start with
	 * @param string $pattern - pattern to glob for
	 */
	protected function findFiles($dir, $pattern) {
		// escape any character in a string that might be used to trick
		// a shell command into executing arbitrary commands
		$dir = escapeshellcmd($dir);
		// get a list of all matching files in the current directory
		$files = glob("$dir/$pattern");
		// find a list of all directories in the current directory
		// directories beginning with a dot are also included
		foreach (glob("$dir/{.[^.]*,*}", GLOB_BRACE|GLOB_ONLYDIR) as $sub_dir) {
		    $arr   = $this->findFiles($sub_dir, $pattern);  // resursive call
		    $files = array_merge($files, $arr); // merge array with files from subdirectory
		}
		// return all found files
	    return $files;
	}

	/**
	 * Run jslint for a given file
	 *
	 * @param string $fileName file to run jslint for
	 * @param array $params additional params to be passed to JS
	 * @return string output from jslint
	 */
	protected function runJsLint($fileName, $params = array()) {
		// generate path to "wrapper" script running jslint
		$runScript = escapeshellcmd(dirname(__FILE__) . '/js/run-lint.js');

		// generate path to jslint.js
		$libDirectory = F::app()->getGlobal('IP') . '/lib';
		$params['jslint'] = "{$libDirectory}/jslint/jslint.js";

		// file to perform lint on
		$params['file'] = $fileName;

		// format additional params for JS script
		$extraParams = '';

		foreach($params as $key => $value) {
			$extraParams .= " --{$key}=" . escapeshellcmd(trim($value));
		}

		$cmd = "node {$runScript}{$extraParams}";
		exec($cmd, $output, $retVal);

		// concatenate script output
		$output = implode("\n", $output);

		if ($retVal == 0 ) {
			// success!
			$res = json_decode($output, true /* $assoc */);
		}
		else {
			throw new Exception($output);
		}

		return $res;
	}

	/**
	 * Filter out message we don't really want in the report
	 *
	 * @param array $error error entry reported by jslint
	 * @return boolean returns true if entry should be removed
	 */
	abstract public function filterErrorsOut($error);

	/**
	 * Simplify error report to match the generic format
	 *
	 * @param array $entry single entry from error report
	 * @return array modified entry (it should contain 'error' and 'line' keys)
	 */
	abstract public function internalFormatReportEntry($entry);

	/**
	 * Perform lint on a file and return list of errors
	 *
	 * @param string $fileName file to be checked
	 * @return array list of reported warnings
	 */
	abstract public function internalCheckFile($fileName);

	/**
	 * Decide whether given error is important and should be eventaully marked in the report
	 *
	 * @param string $errorMsg error message
	 * @return boolean is it an important error
	 */
	abstract protected function isImportantError($errorMsg);

	/**
	 * Check given file and return list of warnings
	 *
	 * @param string $fileName file to be checked
	 * @return array list of reported warnings
	 */
	public function checkFile($fileName) {
		$output = $this->internalCheckFile($fileName);

		// cleanup the list of errors reported
		if (isset($output['errors'])) {
			$output['errors'] = array_filter($output['errors'], array($this, 'filterErrorsOut'));
			$output['errors'] = array_values($output['errors']);

			// keep the original number of errors
			$output['errorsCount'] = count($output['errors']);

			// simplify the report and fold multiple occurances of the same error
			$errorsFolded = array();

			foreach($output['errors'] as $entry) {
				$entry = $this->internalFormatReportEntry($entry);

				if (!isset($errorsFolded[ $entry['error'] ])) {
					$errorsFolded[ $entry['error'] ] = array();
				}

				$errorsFolded[ $entry['error'] ][] = $entry['line'];
			}

			$output['errors'] = array();
			ksort($errorsFolded);

			foreach($errorsFolded as $msg => $lines) {
				$entry = array(
					'error' => $msg,
					'lines' => $lines,
				);

				// mark important errors
				if ($this->isImportantError($msg)) {
					$entry['isImportant'] = true;
				}

				$output['errors'][] = $entry;
			}
		}

		return $output;
	}

	/**
	 * Check all files in a given directory recursively
	 *
	 * @param string $directoryName directory to be checked
	 * @return array list of reported warnings
	 */
	public function checkDirectory($directoryName) {
		$files = $this->findFiles(rtrim($directoryName, '/'), $this->filePattern);
		$results = array();

		if (!empty($files)) {
			foreach($files as $fileName) {
				// skip minified versions
				if (strpos($fileName, '.min.') !== false || strpos($fileName, '-min.') !== false) {
					continue;
				}

				echo "Linting {$fileName}...";
				$results[] = $this->checkFile($fileName);
				echo " [done]\n";
			}
		}

		return $results;
	}

	/**
	 * Generate report from given results
	 *
	 * @param array $results results returned by checkFile / checkDirectory method
	 * @param string $format report format
	 * @return string report
	 */
	public function formatReport($results, $format = 'text') {
		$report = CodeLintReport::factory($format);

		return $report->render($results);
	}
}