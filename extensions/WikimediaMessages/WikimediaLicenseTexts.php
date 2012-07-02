<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An extension that adds Wikimedia specific functionality
 *
 * @file
 * @ingroup Extensions
 *
 * @copyright Copyright © 2008-2009, Tim Starling
 * @copyright Copyright © 2009-2012, Siebrand Mazeland, Multichill
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'WikimediaLicenseTexts',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:WikimediaMessages',
	'author'         => array( 'Multichill', 'Siebrand Mazeland' ),
	'descriptionmsg' => 'wikimedialicensetexts-desc',
);

$wgExtensionMessagesFiles['WikimediaLicenseTexts'] = dirname(__FILE__) . '/WikimediaLicenseTexts.i18n.php';
$wgExtensionMessagesFiles['WikimediaCCLicenseTexts'] = dirname(__FILE__) . '/WikimediaCCLicenseTexts.i18n.php';
