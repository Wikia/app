<?php

/**
 * CodeLintPhp
 *
 * Class used for linting PHP code
 *
 * Requires PHP Storm local installation
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class CodeLintPhp extends CodeLint {

	// file name pattern - used when linting directories
	protected $filePattern = '*.php';

	// per-directory results cache
	// subdirectories will get these results from cache
	private $cache = array(
		'directory' => '',
		'output' => array()
	);

	/**
	 * Run PHP Storm's Code Inspect for a given directory
	 *
	 * Actually, PHP storm will be run for a given directory.
	 * XML reports will then be parsed to get issues for given file.
	 *
	 * @param string $dirName file to run Code Inspect for
	 * @return string output from Code Inspect
	 * @throws Exception
	 */
	protected function inspectDirectory($dirName) {
		global $wgPHPStormPath, $IP;
		$start = microtime(true);

		$isCached = ($this->cache['directory'] !== '') && (strpos($dirName, $this->cache['directory']) === 0);

		if (!$isCached) {
			$lintProfile = dirname(__FILE__) . '/php/profiles/phplint.xml';
			$projectMetaData = dirname(__FILE__) . '/php/project';

			// copy project meta data to trunk root
			$copyCmd = "cp -rf {$projectMetaData}/.idea {$IP}";

			#echo "Copying project meta data <{$copyCmd}>...";
			exec($copyCmd);
			#echo " [done]\n";

			// create a temporary directory for Code Inspect results
			$resultsDir = wfTempDir() . '/phpstorm/' . uniqid('lint');
			echo "Creating temporary directory for results <{$resultsDir}>...";
			wfMkdirParents($resultsDir);
			echo " [done]\n";

			$cmd = sprintf('/bin/sh %s/inspect.sh %s %s %s -d %s -v2',
				$wgPHPStormPath,
				$IP, // PHP Storm project directory
				$lintProfile, // XML file with linting profile
				$resultsDir, // output directory
				$dirName // directory to check
			);

			echo "Running PHP storm <{$cmd}>...";
			//echo "Running PhpStorm for <{$dirName}>...";

			$retVal = 0;
			$output = array();
			exec($cmd, $output, $retVal);

			if ($retVal !== 0) {
				throw new Exception("$cmd ended with code #{$retVal}");
			}

			// get the version of PhpStorm
			$tool = '';

			foreach($output as $line) {
				if (strpos($line, 'Starting up JetBrains PhpStorm') !== false) {
					preg_match('#JetBrains PhpStorm [\\d\\.]+#', $line, $matches);
					$tool = $matches[0];
				}
			}

			echo implode("\n", $output); // debug
			echo " [done]\n";

			// format results
			$output = array(
				'problems' => $this->parseResults($resultsDir),
				'tool' => $tool,
			);

			// update the cache
			$this->cache = array(
				'directory' => $dirName,
				'output' => $output,
			);
		}
		else {
			//echo "Got results from cache for <{$this->cache['directory']}>\n";
			$output = $this->cache['output'];
		}

		$output['time'] = round(microtime(true) - $start, 4);

		return $output;
	}

	/**
	 * Parse XML files in resuls directory and return list of problems found
	 *
	 * @param string $resultsDir results directory with XML files
	 * @return array with list of problems found
	 * @throws Exception
	 */
	private function parseResults($resultsDir) {
		global $IP;

		$files = glob($resultsDir . '/*.xml');
		$problems = array();

		foreach($files as $file) {
			// parse each XML file and add <problem> nodes to $problems array
			$xml = simplexml_load_file($file);
			if ($xml instanceof SimpleXMLElement) {
				/* @var $xml SimpleXMLElement */
				$nodes = $xml->xpath('//problem');

				if ($nodes === false) {
					continue;
				}

				foreach($nodes as $node) {
					$entry = array(
						// make a path relative to code checkout
						'file' => realpath(str_replace('file://$PROJECT_DIR$', $IP, $node->file)),
						'line' => intval($node->line),
						'error' => (string) $node->description
					);

					// group problems by files
					if (!isset($problems[ $entry['file'] ])) {
						$problems[ $entry['file'] ] = array();
					}

					$problems[ $entry['file'] ][] = $entry;
				}
			}
			else {
				throw new Exception("Parsing {$file} failed!");
			}
		}

		return $problems;
	}

	/**
	 * Performs addiitonal reg-exp based check of a single file
	 *
	 * @param $fileName string file name to check
	 * @param $errors array already reported errors
	 * @return array with list of problems found
	 */
	private function additionalFileCheck($fileName, Array $errors) {
		$problems = array();

		$content = file_get_contents($fileName);
		$lines = explode("\n", $content);

		foreach($lines as $lineNo => $line) {
			// check for deprecated skins (BugId:45705)
			if (preg_match( '#[\'"](awesome|SkinAwesome|monaco|SkinMonaco|quartz|SkinQuartz)[\'"]#', $line) > 0) {
				$problems[] = array(
					'file' => $fileName,
					'line' => $lineNo + 1,
					'error' => 'Check for no longer existing skin found'
				);
			}
		}

		// create a list of unused local variables and parameters (BugId:46888)
		$unusedParams = array();
		$unusedVars = array();
		$linesVars = array(); // mapping of variable to line number

		foreach($errors as $error) {
			if (startsWith($error['error'], 'Unused parameter ')) {
				$var = trim(substr($error['error'], strlen('Unused parameter ')));
				$unusedParams[] = $var;
				$linesVars[$var] = $error['line'];
			}

			if (startsWith($error['error'], 'Unused local variable ')) {
				$unusedVars[] = trim(substr($error['error'], strlen('Unused local variable ')));
			}
		}

		// add error reports
		$intersect = array_intersect($unusedParams, $unusedVars);

		foreach($intersect as $var) {
			$problems[] = array(
				'file' => $fileName,
				'line' => $linesVars[$var],
				'error' => "{$var} parameter should be marked as a reference in function definition"
			);
		}

		return $problems;
	}

	/**
	 * Filter out message we don't really want in the report
	 *
	 * @param array $error error entry reported by phplint
	 * @return boolean returns true if the entry should be kept
	 */
	public function filterErrorsOut($error) {
		$keep = true;

		if (isset($error['error'])) {
			// heavily used in controllers to pass data to a template
			if (preg_match('#^Field \'(.*)\' not found in class$#', $error['error'])) {
				$keep = false;
			}

			switch($error['error']) {
				case "Undefined variable 'IP'":
					$keep = false;
					break;
			}
		}

		return $keep;
	}

	/**
	 * Simplify error report to match the generic format
	 *
	 * @param array $entry single entry from error report
	 * @return array modified entry
	 */
	public function internalFormatReportEntry($entry) {
		return $entry;
	}

	/**
	 * Perform lint on a file and return list of errors
	 *
	 * @param string $fileName file to be checked
	 * @return array list of reported warnings
	 */
	public function internalCheckFile($fileName) {
		// run PhpStorm for the whole directory
		$output = $this->inspectDirectory(dirname($fileName));

		// use the same directory structure as parseResults() method
		$fileName = realpath($fileName);

		// take issues for just the current file
		$errors = isset($output['problems'][$fileName]) ? $output['problems'][$fileName] : array();

		// perform additional (reg-exp based) checks
		// add a check for parameters not being marked as a reference (Bugid:46888)
		$errors  = array_merge($errors , $this->additionalFileCheck($fileName, $errors));

		if (!empty($output)) {
			$output = array(
				'errors' => $errors,
				'tool' => $output['tool'],
				'time' => $output['time'],
			);
		}

		return $output;
	}

	/**
	 * Decide whether given error is important and should be eventually marked in the report
	 *
	 * @param string $errorMsg error message
	 * @return boolean is it an important error
	 */
	protected function isImportantError($errorMsg) {
		$ret = false;

		switch($errorMsg) {
			case 'Unreachable statement':
			case 'Redundant closing tag':
			case 'Call-time pass-by-reference has been removed in PHP 5.4':
			case 'Check for no longer existing skin found':
				$ret = true;
				break;
		}

		if (startsWith($errorMsg, 'Undefined variable')) {
			$ret = true;
		}

		if (startsWith($errorMsg, 'Undefined function')) {
			$ret = true;
		}

		if (startsWith($errorMsg, 'Undefined constant')) {
			$ret = true;
		}

		if (startsWith($errorMsg, 'Member has private access') || startsWith($errorMsg, 'Member has protected access')) {
			$ret = true;
		}

		// Constant 'INSERT' not found in class
		if (startsWith($errorMsg, 'Constant ') || startsWith($errorMsg, 'not found in class')) {
			$ret = true;
		}

		// Non-static method Foo::bar() should not be called statically
		if (startsWith($errorMsg, 'Non-static method')) {
			$ret = true;
		}

		// Method foo is deprecated
		if (endsWith($errorMsg, ' is deprecated')) {
			$ret = true;
		}

		if (endsWith($errorMsg, ' parameter should be marked as a reference in function definition')) {
			$ret = true;
		}

		return $ret;
	}
}
