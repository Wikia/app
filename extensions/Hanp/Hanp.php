<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * This exension provides a parser function that aids in choosing the correct
 * particle that is attached to the words.
 *
 * @ingroup Extensions
 * @file
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Hangul particle chooser',
	'version' => '2012-01-15',
	'author' => 'Niklas Laxström',
	'url' => 'https://bugzilla.wikimedia.org/show_bug.cgi?id=13712',
	'descriptionmsg' => 'hanp-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Hanp'] = $dir . 'Hanp.i18n.php';
$wgExtensionMessagesFiles['HanpMagic'] = $dir . 'Hanp.i18n.magic.php';
$wgAutoloadClasses['Hanp'] = $dir . 'Hanp.body.php';
$wgHooks['ParserFirstCallInit'][] = 'efHanpInit';

function efHanpInit( &$parser ) {
	$parser->setFunctionHook( 'hanp', array( 'Hanp', 'hangulParticle' ) );
	return true;
}
