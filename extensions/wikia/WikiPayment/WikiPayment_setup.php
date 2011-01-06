<?php

/**
 * WikiPayment
 *
 * A WikiPayment extension for MediaWiki
 * Allows payment per wiki to disable ads
 *
 * @author Adrian 'ADi' Wieczorek <adi at wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-12-09
 * @copyright Copyright (C) 2010 Adrian Wieczorek, Wikia Inc.
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/WikiPayment/WikiPayment_setup.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named WikiPayment.\n";
	exit(1) ;
}


$wgExtensionCredits['other'][] = array(
	'author' => array('[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
	'description-msg' => 'wikipayment-desc',
	'name' => 'WikiPayment'
);


$dir = dirname(__FILE__).'/';

// autoloads
$wgAutoloadClasses['SpecialWikiPayment'] = $dir . 'SpecialWikiPayment.class.php';

// special pages
$wgSpecialPages['WikiPayment'] = 'SpecialWikiPayment';

// i18n
$wgExtensionMessagesFiles['WikiPayment'] = $dir . 'WikiPayment.i18n.php';

// messages
$wgExtensionMessagesFiles['WikiPayment'] = $dir . 'WikiPayment.i18n.php';
