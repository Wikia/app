<?php
/*
To activate, put something like this in your LocalSettings.php:
	define( 'TASKS_CSS' , 'http://yourhost.com/name/wiki/extensions/Tasks/tasks.css' );
	require_once( "$IP/extensions/Tasks/Tasks.php" );
	$wgTasksNamespace = 200;
	$wgExtraNamespaces[$wgTasksNamespace] = "Task";
	$wgExtraNamespaces[$wgTasksNamespace+1] = "Task_Talk";

The TASKS_CSS define is only needed if you use a 'non-standard' extensions
directory.

Known bugs:
* FIXME: sidebar task list for Monobook only?

*/

if( !defined( 'MEDIAWIKI' ) ) die();

/** Default path to the stylesheet */
global $wgScriptPath ;
if( !defined( 'TASKS_CSS' ) ) define('TASKS_CSS', $wgScriptPath.'/extensions/Tasks/tasks.css' );

/**@+ Task state constants */
define( 'MW_TASK_INVALID',  0 );
define( 'MW_TASK_OPEN',     1 );
define( 'MW_TASK_ASSIGNED', 2 );
define( 'MW_TASK_CLOSED',   3 );
define( 'MW_TASK_WONTFIX',  4 );
/**@-*/

/**
 * The namespace to use needs to be assigned in $wgExtraNamespaces also.
 * Task discussion pages will go here...
 * and... there's a talk namespace also. :P
 */
$wgTasksNamespace = null;

/**
 * Global variable to cache tasks for a page, so sidebar and header check only have to read them once
*/
$wgTaskExtensionTasksCache = array ();
$wgTaskExtensionTasksCachedTitle = '';

# Integrating into the MediaWiki environment
$wgExtensionCredits['Tasks'][] = array(
	'path'           => __FILE__,
	'name'           => 'Tasks',
	'author'         => 'Magnus Manske',
	'descriptionmsg' => 'tasks_desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Tasks',
);

$wgExtensionMessagesFiles['Tasks'] = dirname( __FILE__ ) . '/Tasks.i18n.php';

$wgAutoloadClasses['SpecialTasks'] = dirname( __FILE__ ) . '/Tasks.body.php';
$wgAutoloadClasses['TasksHooks'] = dirname( __FILE__ ) . '/Tasks.hooks.php';

# Special page
$wgSpecialPages['Tasks'] = 'SpecialTasks';

# Misc hooks
$wgHooks['EditPage::showEditForm:initial'][] = 'TasksHooks::onEditPageShowEditFormInitial';
$wgHooks['ArticleViewHeader'][] = 'TasksHooks::onArticleViewHeader';
$wgHooks['SkinTemplateToolboxEnd'][] = 'TasksHooks::onSkinTemplateToolboxEnd';
$wgHooks['SpecialMovepageAfterMove'][] = 'TasksHooks::onSpecialMovepageAfterMove';
$wgHooks['ArticleDeleteComplete'][] = 'TasksHooks::onArticleDeleteComplete';
$wgHooks['ArticleInsertComplete'][] = 'TasksHooks::onArticleInsertComplete';
$wgHooks['SkinTemplatePreventOtherActiveTabs'][] = 'TasksHooks::onSkinTemplatePreventOtherActiveTabs';
$wgHooks['SkinTemplateNavigation'][] = 'TasksHooks::onSkinTemplateNavigation';
$wgHooks['UnknownAction'][] = 'TasksHooks::onUnknownAction';
$wgHooks['ParserTestTables'][] = 'TasksHooks::onParserTestTables';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'TasksHooks::onLoadExtensionSchemaUpdates';
$wgHooks['GetPreferences'][] = 'TasksHooks::onGetPreferences';

# Logging
$wgLogTypes[] = 'tasks';
$wgLogNames['tasks'] = 'tasks_logpage';
$wgLogHeaders['tasks'] = 'tasks_logpagetext';
$wgLogActions['tasks/tasks'] = 'tasks_logentry';


