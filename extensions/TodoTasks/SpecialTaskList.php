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
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Todo_Tasks',
	'description'    => 'adds <nowiki>{{#todo:}}</nowiki> parser function for assigning tasks',
	'descriptionmsg' => 'tasklist-parser-desc',
);
	$wgExtensionCredits['specialpage'][] = array(
	'path'        => __FILE__,
	'name'        => 'Todo Tasks',
	'version'     => $wgTodoTasksExtensionVersion,
	'author'      => 'Paul Grinberg',
	'email'       => 'gri6507 at yahoo dot com',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:Todo_Tasks',
	'description' => 'Adds a special page for reviewing tasks assignments',
	'descriptionmsg' => 'tasklist-special-desc',
);

$wgUseProjects = true;
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['TaskList'] = $dir . 'SpecialTaskList_body.php';
$wgExtensionMessagesFiles['TaskList'] = $dir . 'SpecialTaskList.i18n.php';
$wgExtensionMessagesFiles['TaskListMagic'] = $dir . 'TodoTasks.i18n.magic.php';
$wgExtensionAliasesFiles['TaskList'] = $dir . 'SpecialTaskList.alias.php';
$wgSpecialPages['TaskList'] = 'TaskList';

if ($wgUseProjects) {
	$wgAutoloadClasses['TaskListByProject'] = $dir . 'SpecialTaskList_body.php';
	$wgSpecialPages['TaskListByProject']   = 'TaskListByProject';
}
$wgHooks['LoadAllMessages'][] = 'TaskList::loadMessages';
$wgHooks['LoadAllMessages'][] = 'TaskListByProject::loadMessages';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efTodoTasksSchemaUpdates';

require_once($dir . 'SpecialTaskList_body.php');

$wgHooks['PersonalUrls'][]             = 'addPersonalUrl';
$wgHooks['AlternateEdit'][]            = 'todoPreviewAction';
$wgHooks['EditPage::attemptSave'][]    = 'todoSavePreparser';
$wgHooks['ParserFirstCallInit'][]      = 'wfTodoParserFunction_Setup';

function efTodoTasksSchemaUpdates() {
	global $wgExtNewTables;

	$base = dirname(__FILE__);

	$wgExtNewTables[] = array( 'todo', "$base/todotasks.sql" ); // Initial install tables

	return true;
}
