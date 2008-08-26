<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page extension that displays edit counts.
 *
 * This page can be accessed from Special:Editcount[/user] as well as being
 * included like {{Special:Editcount/user[/namespace]}}
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Editcount',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'description' => 'Displays [[Special:Editcount|edit count]] of a user',
);

$dir =  dirname( __FILE__ );
$wgAutoloadClasses['Editcount'] = $dir . '/SpecialEditcount_body.php';
$wgSpecialPages['editcount'] = array( /*class*/ 'Editcount', /*name*/ 'Editcount', /* permission */'', /*listed*/ true, /*function*/ false, /*file*/ false );
$wgExtensionMessagesFiles['Editcount'] = $dir . '/SpecialEditcount.i18n.php';

