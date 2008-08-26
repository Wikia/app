<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page Randomly shows one of the root pages (in contrast to subpages) from ns=0
 *
 * @addtogroup Extensions
 *
 * @author Hojjat (aka Huji) <huji.huji@gmail.com>
 * @copyright Copyright © 2008, Hojjat (aka Huji)
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Random root page',
	'version'        => '1.0',
	'author'         => 'Hojjat (aka Huji)',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Randomrootpage',
	'descriptionmsg' => 'randomrootpage-desc',
);

$wgSpecialPages['Randomrootpage'] = 'SpecialRandomrootpage';
$wgSpecialPageGroups['Randomrootpage'] = 'pages';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Randomrootpage'] = $dir . 'Randomrootpage.i18n.php';
$wgAutoloadClasses['SpecialRandomrootpage'] = $dir . 'Randomrootpage_body.php';
