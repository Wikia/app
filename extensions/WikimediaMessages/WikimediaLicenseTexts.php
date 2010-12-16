<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An extension that adds Wikimedia specific functionality
 *
 * @addtogroup Extensions
 *
 * @copyright Copyright © 2008-2009, Tim Starling
 * @copyright Copyright © 2009, Siebrand Mazeland, Multichill
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'WikimediaLicenseTexts',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:WikimediaMessages',
	'author'         => array( 'Multichill', 'Siebrand Mazeland' ),
	'description'    => 'Wikimedia license texts',
	'descriptionmsg' => 'wikimedialicensetexts-desc',
);

$wgExtensionMessagesFiles['WikimediaLicenseTexts'] = dirname(__FILE__) . '/WikimediaLicenseTexts.i18n.php';
