<?php

/**
 * CodeLintReportText
 *
 * Text report class
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class CodeLintReportText extends CodeLintReport {

	const FORMAT = "%3d | %-80s %3s | %20s | %s @ r%d\n";

	/**
	 * Return report for a given set of results
	 *
	 * @param array $results results
	 * @return string report
	 */
	public function render($results, $tool) {
		$report = '';
		$line = str_repeat('-', 140) . "\n";
		$totalTime = 0;

		foreach($results as $fileEntry) {
			$tracUrl = $this->getTracBlameUrl($fileEntry['fileChecked']);

			$report .= $line;
			$report .= "File: {$fileEntry['fileChecked']}\n";
			$report .= "Blame: <{$tracUrl}>\n";
			$report .= sprintf("Number of errors: %d (important: %d) / checked in %.4f s\n",
				$fileEntry['errorsCount'],
				$fileEntry['importantErrorsCount'],
				$fileEntry['time']
			);
			$report .= $line;

			if ($fileEntry['errorsCount'] == 0) {
				$report .= "Yay! No issues found!\n";
			}
			else {
				foreach($fileEntry['errors'] as $n => $entry) {
					$report .= sprintf(self::FORMAT,
						$n+1,
						$entry['error'],
						(!empty($entry['isImportant']) ? '!!!' : ''),
						implode(',', $entry['lines']),
						$entry['blame']['author'],
						$entry['blame']['rev']
					);
				}
			}

			$report .= "\n";

			$totalTime += $fileEntry['time'];
		}

		$report .= $line;
		$report .= sprintf("Generated on %s in %.4f s using %s\n",
			date('r'),
			$totalTime,
			$tool
		);
		$report .= $line;

		return $report;
	}
}
