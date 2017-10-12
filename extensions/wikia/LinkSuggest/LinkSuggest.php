<?php
/**
 * LinkSuggest
 *
 * This extension provides the users with article title suggestions as he types
 * a link in wikitext.
 *
 * @file
 * @ingroup Extensions
 * @author Inez Korczyński <inez@wikia-inc.com>
 * @author Bartek Łapiński <bartek@wikia-inc.com>
 * @author Lucas Garczewski (TOR) <tor@wikia-inc.com>
 * @author Sean Colombo <sean@wikia.com>
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @author Robert Elwell <robert@wikia-inc.com>
 * @copyright Copyright (c) 2008-2012, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
if( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

$wgExtensionCredits['other'][] = [
	'path' => __FILE__,
	'name' => 'LinkSuggest',
	'version' => '2.0',
	'author' => [
		'Inez Korczyński', 'Bartek Łapiński', 'Łukasz Garczewski', 'Maciej Brencz',
		'Jesús Martínez Novo', 'Jack Phoenix', 'Sean Colombo', 'Robert Elwell',
	],
	'descriptionmsg' => 'linksuggest-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/LinkSuggest'
];

// ResourceLoader support (MW 1.17+)
$wgResourceModules['ext.wikia.LinkSuggest'] = [
	'scripts' => 'js/jquery.wikia.linksuggest.js',
	'dependencies' => [ 'jquery.ui.autocomplete' ],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/LinkSuggest'
];

// config
$wgLinkSuggestLimit = 6;

// classes
$wgAutoloadClasses['LinkSuggest'] = __DIR__ . '/LinkSuggest.class.php';
$wgAutoloadClasses['LinkSuggestLoader'] = __DIR__ . '/LinkSuggestLoader.class.php';
$wgAutoloadClasses['LinkSuggestHooks'] = __DIR__ . '/LinkSuggestHooks.class.php';

// i18n
$wgExtensionMessagesFiles['LinkSuggest'] = __DIR__ . '/LinkSuggest.i18n.php';

// hooks
$wgHooks['GetPreferences'][] = 'LinkSuggestHooks::onGetPreferences' ;
$wgHooks['EditForm::MultiEdit:Form'][] = 'LinkSuggestHooks::onEditFormMultiEditForm';
$wgHooks['UploadForm:initial'][] = 'LinkSuggestHooks::onUploadFormInitial'; // VOLDEV-121: add LinkSuggest to Special:Upload and MultipleUpload

// AJAX interface
$wgAjaxExportList[] = 'getLinkSuggest';
$wgAjaxExportList[] = 'getLinkSuggestImage';

function getLinkSuggest() {
	global $wgRequest;
	wfProfileIn(__METHOD__);

	$out = LinkSuggest::getLinkSuggest($wgRequest);

	$ar = new AjaxResponse($out);
	$ar->setCacheDuration(60 * 60);

	if ($wgRequest->getText('format') == 'json') {
		$ar->setContentType('application/json; charset=utf-8');
	}
	else {
		$ar->setContentType('text/plain; charset=utf-8');
	}

	wfProfileOut(__METHOD__);
	return $ar;
}

function getLinkSuggestImage() {
	global $wgRequest;
	wfProfileIn(__METHOD__);

	$res = LinkSuggest::getLinkSuggestImage($wgRequest->getText('imageName'));

	$ar = new AjaxResponse($res);
	$ar->setCacheDuration(60 * 60);
	$ar->setContentType('text/plain; charset=utf-8');

	wfProfileOut(__METHOD__);
	return $ar;
}
