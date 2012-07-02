<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo 'Not a valid entry point';
	exit( 1 );
}

if ( !defined( 'SMW_VERSION' ) ) {
	echo 'This extension requires Semantic MediaWiki to be installed.';
	exit( 1 );
}

#
# This is the path to your installation of SemanticTasks as
# seen from the web. Change it if required ($wgScriptPath is the
# path to the base directory of your wiki). No final slash.
# #
$stScriptPath = $wgScriptPath . '/extensions/SemanticTasks';
#

# Extension credits
$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other'][] = array(
	'path' => __FILE__,
	'name' => 'SemanticTasks',
	'author' => array(
		'Steren Giannini',
		'Ryan Lane',
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]'
	),
	'version' => '1.4.1',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Semantic_Tasks',
	'descriptionmsg' => 'semantictasks-desc',
);

// i18n
$wgExtensionMessagesFiles['SemanticTasks'] = dirname( __FILE__ ) . '/SemanticTasks.i18n.php';

// Autoloading
$wgAutoloadClasses['SemanticTasksMailer'] = dirname( __FILE__ ) . '/SemanticTasks.classes.php';

// Hooks
$wgHooks['ArticleSaveComplete'][] = 'SemanticTasksMailer::mailAssigneesUpdatedTask';
$wgHooks['ArticleSave'][] = 'SemanticTasksMailer::findOldValues';
