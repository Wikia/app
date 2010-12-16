<?php

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "Not a valid entry point";
    exit( 1 );
}

#
# This is the path to your installation of SemanticTasks as
# seen from the web. Change it if required ($wgScriptPath is the
# path to the base directory of your wiki). No final slash.
# #
$stScriptPath = $wgScriptPath . '/extensions/SemanticTasks';
#

# Informations
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'SemanticTasks',
	'author' => 'Steren Giannini, Ryan Lane',
	'version' => '1.3',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Semantic_Tasks',
	'description' => 'E-mail notifications for assigned or updated tasks',
	'descriptionmsg' => 'semantictasks-desc',
);

// Do st_SetupExtension after the mediawiki setup, AND after SemanticMediaWiki setup
// FIXME: only hook added is ArticleSaveComplete. There appears to be no need for this.
$wgExtensionFunctions[] = 'SemanticTasksSetupExtension';

// i18n
$wgExtensionMessagesFiles['SemanticTasks'] = dirname( __FILE__ ) . '/SemanticTasks.i18n.php';

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['SemanticTasksMailer'] = $dir . 'SemanticTasks.classes.php';

function SemanticTasksSetupExtension() {
        global $wgHooks;
        $wgHooks['ArticleSaveComplete'][] = 'SemanticTasksMailer::mailAssigneesUpdatedTask';
	$wgHooks['ArticleSave'][] = 'SemanticTasksMailer::findOldValues';
        return true;
}
