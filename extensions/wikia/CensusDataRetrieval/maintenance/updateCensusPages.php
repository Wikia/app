<?php
/**
 * Updates infoboxes of Pages with Census data enabled
 *
 * @author Lucas TOR Garczewski <tor@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @since Nov 2012 | MediaWiki 1.19
 *
 */
require __DIR__ . '/../../../../maintenance/commandLine.inc';
$wgUser = User::newFromName('Wikia');

$updatePages = new CensusEnabledPagesUpdate();
$updatePages->updatePages();
exit( 0 );
