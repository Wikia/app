<?php

/**
 * CodeLintReportJson
 *
 * JSON report class
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class CodeLintReportJson extends CodeLintReport {

	/**
	 * Return report for a given set of results
	 *
	 * @param array $results results
	 * @return string report
	 */
	public function render($results, $tool) {
		return json_encode($results);
	}
}
