<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit(1);
}

$dir = dirname(__FILE__);
$wgExtensionCredits['antispam'][] = array(
	'path'           => __FILE__,
	'name'           => 'AutoProxyBlock',
	'author'         => 'Cryptocoryne',
	'version'        => '1.0',
	'descriptionmsg' => 'autoproxyblock-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:AutoProxyBlock',
);
 
$wgExtensionMessagesFiles['AutoProxyBlock'] =  "$dir/AutoProxyBlock.i18n.php";
$wgAutoloadClasses['AutoProxyBlock'] = "$dir/AutoProxyBlock.body.php";
 
// protect special accounts from tagging proxy edits
$wgAvailableRights[] = 'notagproxychanges';
 
// set hooks
$wgHooks['getUserPermissionsErrorsExpensive'][] = 'AutoProxyBlock::checkProxy';
$wgHooks['RecentChange_save'][] = 'AutoProxyBlock::tagProxyChange';
$wgHooks['ListDefinedTags'][] = 'AutoProxyBlock::addProxyTag';
$wgHooks['AbuseFilter-filterAction'][] = 'AutoProxyBlock::AFSetVar';
$wgHooks['AbuseFilter-builder'][] = 'AutoProxyBlock::AFBuilderVars';
 
// array of actions, allowed to perform by proxy users
$wgProxyCanPerform = array( 'read', 'edit', 'upload' );
 
// add "proxy" tag to all edits, matched by this extension
$wgTagProxyActions = true;
 
// api is mediawiki api url, raw is local path to file with raw proxylist
// key is regexp to check reason of block, retrieved from api
$wgAutoProxyBlockSources = array();
$wgAutoProxyBlockSources['api'][] = 'http://en.wikipedia.org/w/api.php';
$wgAutoProxyBlockSources['raw'][] = '/var/www/mediawiki/proxy.list';
$wgAutoProxyBlockSources['key'] = '/blocked proxy/i';
 
// if set to true, log all blocked actions in Special:Log/proxyblock
$wgAutoProxyBlockLog = false;

if( $wgAutoProxyBlockLog ) {
	$wgAvailableRights[] = 'autoproxyblock-log';
	$wgGroupPermissions['bureaucrat']['autoproxyblock-log'] = true;
	$wgLogTypes[] = 'proxyblock';
	$wgLogNames['proxyblock']             = 'proxyblock-log-name';
	$wgLogHeaders['proxyblock']           = 'proxyblock-log-header';
	$wgLogActions['proxyblock/proxyblock'] = 'proxyblock-logentry';
	$wgLogActions['proxyblock/blocked']   = 'proxyblock-logentry-blocked';
	$wgLogRestrictions['proxyblock'] = 'autoproxyblock-log';
}