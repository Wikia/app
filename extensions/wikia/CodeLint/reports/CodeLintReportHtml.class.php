<?php

/**
 * CodeLintReportHtml
 *
 * HTML report class
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class CodeLintReportHtml extends CodeLintReport {

	/**
	 * Return report for a given set of results
	 *
	 * @param array $results results
	 * @return string report
	 */
	public function render($results, $tool) {
		$tmpl = new EasyTemplate(dirname(__FILE__) . '/templates');
		$totalTime = 0;

		foreach($results as &$fileEntry) {
			$fileEntry['blameUrl'] = $this->getTracBlameUrl($fileEntry['fileChecked']);

			$totalTime += $fileEntry['time'];
		}

		$stats = array(
			'generationDate' => date('r'),
			'totalTime' => $totalTime,
			'errorsCount' => 0,
			'importantErrorsCount' => 0,
		);

		if ($tool !== '') {
			$stats['tool'] = $tool;
		}

		// count errors reported in all files
		foreach($results as $entry) {
			$stats['errorsCount'] += $entry['errorsCount'];
			$stats['importantErrorsCount'] += $entry['importantErrorsCount'];
		}

		$tmpl->set('results', $results);
		$tmpl->set('stats', $stats);
		return $tmpl->render('reportHtml');
	}
}
