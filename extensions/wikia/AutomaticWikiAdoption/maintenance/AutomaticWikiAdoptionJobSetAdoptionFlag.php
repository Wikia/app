<?php
/**
 * AutomaticWikiAdoptionJobSetAdoptionFlag
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 * Maintenance script - helper class
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-08
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage Maintanance
 *
 */

class AutomaticWikiAdoptionJobSetAdoptionFlag {
	function execute($commandLineOptions, $jobOptions, $wikiId, $wikiData) {
		//let wiki to be adopted
		$jobOptions['dataMapper']->setFlags($wikiId, WikiFactory::FLAG_ADOPTABLE);

		//print info
		if (!isset($commandLineOptions['quiet'])) {
			echo "Wiki (id:$row->wiki_id) set as adoptable.\n";
		}
	}
}