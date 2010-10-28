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

require_once('../commandLine.inc');

if (isset($options['help'])) {
	die( "Usage: php AutomaticWikiAdoptionGatherData.php [--quiet]

		  --help     you are reading it right now
		  --quiet    do not print anything to output\n\n");
}

require_once( $GLOBALS['IP'].'/extensions/wikia/AutomaticWikiAdoption/maintenance/AutomaticWikiAdoptionGatherData.php' );

$maintenance = new AutomaticWikiAdoptionGatherData();
$maintenance->run($options);