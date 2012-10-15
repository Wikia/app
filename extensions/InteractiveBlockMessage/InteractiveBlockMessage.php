<?php
/**
 * Insert a new magic word
 *
 * @file
 * @ingroup Extensions
 * @author Petr Bena <benapetr@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:InteractiveBlockMessage Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a part of mediawiki and can't be started separately";
	die();
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Interactive block message',
	'version' => '1.0.0',
	'author' => array( 'Petr Bena' ),
	'descriptionmsg' => 'interactiveblockmessage-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:InteractiveBlockMessage',
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['InteractiveBlockMessageHooks'] = "$dir/InteractiveBlockMessageHooks.php";

$wgExtensionMessagesFiles['InteractiveBlockMessage'] = "$dir/InteractiveBlockMessage.i18n.php";
$wgExtensionMessagesFiles['InteractiveBlockMessageMagic'] = "$dir/InteractiveBlockMessage.i18n.magic.php";

$wgHooks['MagicWordwgVariableIDs'][] = 'InteractiveBlockMessageHooks::magicWordSet';
$wgHooks['ParserGetVariableValueSwitch'][] = 'InteractiveBlockMessageHooks::parserGetVariable';
