<?php
/**
 * A Special Page extension that displays Wiki Google Webtools stats.
 *
 * This page can be accessed from Special:Webtools
 *
 * @addtogroup Extensions
 *
 * @author Andrew Yasinsky <nadrewy@wikia.com>
 */

if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/wikia/Webtools/SpecialWebtools.php" );
EOT;
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Webtools',
	'author' => 'Andrew Yasinsky',
	'description' => 'Displays wiki position and clicks statistics',
);

$dir = dirname(__FILE__);
$wgAutoloadClasses['Webtools'] = $dir . '/SpecialWebtools_body.php';
$wgSpecialPages['webtools'] = array( /*class*/ 'Webtools', /*name*/ 'Webtools', /* permission */'', /*listed*/ true, /*function*/ false, /*file*/ false );
$wgExtensionMessagesFiles['Webtools'] = $dir . '/SpecialWebtools.i18n.php';
$wgSpecialPageGroups['Webtools'] = 'wiki';
