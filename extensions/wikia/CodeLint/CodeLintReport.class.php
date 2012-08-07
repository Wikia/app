<?php

/**
 * CodeLintReport
 *
 * Generic class providing interface for reports
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

abstract class CodeLintReport {

	/**
	 * Return an instance of given type of report
	 *
	 * @param string $format report format
	 * @return CodeLintReport report instance
	 */
	public static function factory($format) {
		$className = 'CodeLintReport' . ucfirst($format);

		// fallback to default report format
		if (!class_exists($className)) {
			$className = 'CodeLintReportText';
		}

		return new $className();
	}

	/**
	 * Return report for a given set of results
	 *
	 * @param array $results results
	 * @param string $tool info from the tool that returned results
	 * @return string report
	 */
	abstract public function render($results, $tool);

	/**
	 * Get blame trac link for given file
	 *
	 * @param string $fileName file to generate link for
	 * @return string trac link
	 */
	protected function getTracBlameUrl($fileName) {
		$root = realpath('../../');
		$file = realpath($fileName);

		if (substr($file, 0, strlen($root)) != $root) {
			return false;
		}

		// assume we're working on trunk
		$url = 'http://trac.wikia-code.com/browser/wikia/trunk';
		$url .= substr($file, strlen($root));
		$url .= '?annotate=blame';

		return $url;
	}
}
