<?php
/**
 * AutomaticWikiAdoptionGatherData
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 * Maintenance script for gathering data - mark wikis available for adoption
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-08
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage Maintanance
 *
 */

require_once( dirname(__FILE__) . '/../commandLine.inc' );

if (isset($options['help'])) {
	die( "Usage: php AutomaticWikiAdoptionGatherData.php [--quiet] [--maxwiki=12345]

		  --help			you are reading it right now
		  --dryrun			do not perform any activity - only print it out on the screen
		  --quiet			do not print anything to output
		  --maxwiki			maximum wiki id\n\n");
}

$wgExtensionMessagesFiles['AutomaticWikiAdoption'] = $GLOBALS['IP'] . '/extensions/wikia/AutomaticWikiAdoption/AutomaticWikiAdoption.i18n.php';
require_once( $GLOBALS['IP'].'/extensions/wikia/AutomaticWikiAdoption/maintenance/AutomaticWikiAdoptionGatherData.php' );

$maintenance = new AutomaticWikiAdoptionGatherData();
$maintenance->run($options);