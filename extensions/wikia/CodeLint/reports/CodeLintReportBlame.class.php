<?php

/**
 * CodeLintReportBlame
 *
 * Blame report class
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

class CodeLintReportBlame extends CodeLintReport {

	/**
	 * Return report for a given set of results
	 *
	 * @param array $results results
	 * @return array report
	 */
	public function render($results, $tool) {
		$ret = array();

		foreach($results as $fileEntry) {
			$tracUrl = $this->getTracBlameUrl($fileEntry['fileChecked']);

			if (!empty($fileEntry['errors'])) {
				foreach($fileEntry['errors'] as $entry) {
					$author = $entry['blame']['author'];

					if (!isset($ret[$author])) {
						$ret[$author] = array();
					}

					$item = array(
						'file' => $fileEntry['fileChecked'],
						'line' => reset($entry['lines']),
						'tracUrl' => $tracUrl,
						'error' => $entry['error'],
						'rev' => $entry['blame']['rev']
					);

					if (!empty($entry['isImportant'])) {
						$item['isImportant'] = true;
					}

					$ret[$author][] = $item;
				}
			}
		}

		return $ret;
	}
}
