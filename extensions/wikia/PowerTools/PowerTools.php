<?php
/**
 * PowerTools
 *
 * This extension enables users with access rights to delete and protect articles in one
 * action (and potentially perform other power-user actions easier in the future).
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2011-11-22
 * @copyright Copyright © 2011 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named PowerTools.\n";
        exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
        'name' => 'PowerTools',
        'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
        'descriptionmsg' => 'powertools-desc',
		'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PowerTools'
);

//i18n
$wgExtensionMessagesFiles['PowerTools'] = __DIR__ . '/PowerTools.i18n.php';

$wgAutoloadClasses['PowerTools'] = dirname( __FILE__ ) . '/PowerTools.class.php';

$wgHooks['UnknownAction'][] = 'PowerTools::onPowerDelete';
