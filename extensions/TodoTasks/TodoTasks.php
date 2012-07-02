<?php

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation, version 2
of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if (!defined('MEDIAWIKI')) die();

$wgTodoTasksExtensionVersion = '0.10.0';

$wgExtensionCredits['parserhook'][]    = array(
	'path'           => __FILE__,
	'version'        => $wgTodoTasksExtensionVersion,
	'name'           => 'Todo Tasks',
	'author'         => 'Paul Grinberg',
	'email'          => 'gri6507 at yahoo dot com',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Todo_Tasks',
	'descriptionmsg' => 'tasklist-parser-desc',
);
	$wgExtensionCredits['specialpage'][] = array(
	'path'        => __FILE__,
	'name'        => 'Todo Tasks',
	'version'     => $wgTodoTasksExtensionVersion,
	'author'      => 'Paul Grinberg',
	'email'       => 'gri6507 at yahoo dot com',
	'url'         => 'https://www.mediawiki.org/wiki/Extension:Todo_Tasks',
	'descriptionmsg' => 'tasklist-special-desc',
);

$wgUseProjects = true;
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['TaskList'] = $dir . 'TodoTasks_body.php';
$wgExtensionMessagesFiles['TaskList'] = $dir . 'TodoTasks.i18n.php';
$wgExtensionMessagesFiles['TaskListMagic'] = $dir . 'TodoTasks.i18n.magic.php';
$wgExtensionMessagesFiles['TaskListAlias'] = $dir . 'TodoTasks.alias.php';
$wgSpecialPages['TaskList'] = 'TaskList';

if ($wgUseProjects) {
	$wgAutoloadClasses['TaskListByProject'] = $dir . 'TodoTasks_body.php';
	$wgSpecialPages['TaskListByProject']   = 'TaskListByProject';
}
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efTodoTasksSchemaUpdates';

require_once($dir . 'TodoTasks_body.php');

$wgHooks['PersonalUrls'][]             = 'addPersonalUrl';
$wgHooks['AlternateEdit'][]            = 'todoPreviewAction';
$wgHooks['EditPage::attemptSave'][]    = 'todoSavePreparser';
$wgHooks['ParserFirstCallInit'][]      = 'wfTodoParserFunction_Setup';

function efTodoTasksSchemaUpdates( $updater = null ) {
	$base = dirname(__FILE__);

	if ( $updater === null ) {
		global $wgExtNewTables;
		$wgExtNewTables[] = array( 'todo', "$base/todotasks.sql" ); // Initial install tables
	} else {
		$updater->addExtensionUpdate( array( 'addTable', 'todo', "$base/todotasks.sql", true ) );
	}

	return true;
}
