<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension install sendmail redirection and put the following line in LocalSettings.php:
require_once( "\$IP/extensions/TableMod/TableMod.php" );
EOT;
        exit( 1 );
}

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'TableMod',
	'path' => __FILE__,
	'author' => 'Jure Kajzer - freakolowsky <jure.kajzer@abakus.si>',
	'url' => 'http://www.mediawiki.org/wiki/Extension:TableMod',
	'description' => 'Wiki-table manipulation',
	'descriptionmsg' => 'tablemod-desc',
	'version' => '0.1.0',
);
 
$dir = dirname(__FILE__) . '/';
 
$wgAutoloadClasses['TableMod'] = $dir . 'TableMod.body.php';
$wgExtensionMessagesFiles['TableMod'] = $dir . 'TableMod.i18n.php';


$wgHooks['ParserFirstCallInit'][] = 'tablemodSetup';
$wgHooks['OutputPageParserOutput'][] = 'tablemodSaveAndRedirect';


$tablemodAction = FALSE;
$tablemodContent = FALSE;
$tablemodContentChanged = FALSE;

function tablemodSetup( $parser ) {
	global $wgUser, $wgTitle, $wgRequest;
	
	if (!in_array($wgRequest->getVal('action', 'view'), array('purge', 'view')))
		return true;

	$errors = $wgTitle->getUserPermissionsErrors('edit', $wgUser);
	if(count($errors)) return true;

	$parser->setHook('table-mod', 'tablemodRender');
	wfLoadExtensionMessages('TableMod');

	return true;
}

function tablemodRender( $input, $args, $parser, $frame ) {
	global $tablemodAction, $tablemodContent, $tablemodContentChanged, $wgRequest, $wgArticle;
		
	if ($tablemodAction === FALSE)
		$tablemodAction = explode('|', $wgRequest->getVal('tablemod'));

	if ($tablemodContent === FALSE)
		$tablemodContent = $wgArticle->getContent();

	try {
		$mod = new TableMod($input, $args, $parser, $frame);
	} catch (TableModException $e) {
		return $e->getMessage();
	}
	
	$mod->tableSave();

	$parser->disableCache();

	return $mod->tableOutput();
}

function tablemodSaveAndRedirect(&$out, $parser) {
	global $wgTitle, $wgArticle, $wgRequest, $tablemodContent, $tablemodContentChanged;
	
	if (!in_array($wgRequest->getVal('action', 'view'), array('purge', 'view')))
		return true;

	if ($tablemodContentChanged === TRUE) {
		$wgArticle->doEdit($tablemodContent, 'TableMod - action');
		$wgArticle->doRedirect();
	}

	return true;
}

