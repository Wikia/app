<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page extension that displays edit counts.
 *
 * This page can be accessed from Special:Editcount[/user] as well as being
 * included like {{Special:Editcount/user[/namespace]}}
 *
 * @file
 * @ingroup Extensions
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Editcount',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'descriptionmsg' => 'editcount-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Editcount',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Editcount'] = $dir . 'Editcount.i18n.php';
$wgExtensionMessagesFiles['EditcountAliases'] = $dir . 'Editcount.alias.php';
$wgAutoloadClasses['Editcount'] = $dir . 'Editcount_body.php';
$wgSpecialPages['Editcount'] = 'Editcount';
