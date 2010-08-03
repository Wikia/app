<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An extension that adds Wikimedia specific functionality
 *
 * @addtogroup Extensions
 *
 * @copyright Copyright © 2008, Tim Starling
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'name'           => 'WikimediaMessages',
	'author'         => array( 'Tim Starling', 'Siebrand Mazeland' ),
	'svn-date'       => '$LastChangedDate: 2008-08-10 20:32:10 +0200 (ndz, 10 sie 2008) $',
	'svn-revision'   => '$LastChangedRevision: 39077 $',
	'description'    => 'Wikimedia specific messages',
	'descriptionmsg' => 'wikimediamessages-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WikimediaMessages'] = $dir .'WikimediaMessages.i18n.php';
$wgExtensionFunctions[] = 'wfSetupWikimediaMessages';

include_once ( $dir .'WikimediaGrammarForms.php' );

function wfSetupWikimediaMessages() {
	wfLoadExtensionMessages('WikimediaMessages');
}
