<?php
/**
 * AutomaticWikiAdoption
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-05
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AutomaticWikiAdoption/AutomaticWikiAdoption_setup.php");
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named AutomaticWikiAdoption.\n";
	exit( 1 ) ;
}

$wgExtensionCredits['other'][] = array(
	'name' => 'AutomaticWikiAdoption',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AutomaticWikiAdoption',
	'description-msg' => 'wikiadoption-desc',
);

$dir = dirname(__FILE__);

$wgExtensionFunctions[] = 'AutomaticWikiAdoptionInit';
$wgExtensionMessagesFiles['AutomaticWikiAdoption'] = "$dir/AutomaticWikiAdoption.i18n.php";
$wgAutoloadClasses['AutomaticWikiAdoptionAjax'] = "$dir/AutomaticWikiAdoptionAjax.class.php";
$wgAutoloadClasses['AutomaticWikiAdoptionHelper'] = "$dir/AutomaticWikiAdoptionHelper.class.php";
$wgAutoloadClasses['AutomaticWikiAdoptionController'] = "$dir/AutomaticWikiAdoptionController.class.php";

//register special page
$wgAutoloadClasses['SpecialWikiAdoption'] = "$dir/SpecialWikiAdoption.class.php";
$wgSpecialPages['WikiAdoption'] = 'SpecialWikiAdoption';

# 194785 = ID of wiki created on 2010-12-14 so it will work for wikis created after this project has been deployed
if ( $wgCityId > 194785 ) {
	$wgDefaultUserOptions["adoptionmails-$wgCityId"] = 1;
}

/**
 * Initialize hooks
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function AutomaticWikiAdoptionInit() {
	global $wgHooks;

	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'AutomaticWikiAdoptionHelper::onSkinTemplateOutputPageBeforeExec';
	$wgHooks['GetPreferences'][] = 'AutomaticWikiAdoptionHelper::onGetPreferences';
	$wgHooks['ArticleSaveComplete'][] = 'AutomaticWikiAdoptionHelper::onArticleSaveComplete';
}

// Ajax dispatcher
$wgAjaxExportList[] = 'AutomaticWikiAdoptionAjax';
function AutomaticWikiAdoptionAjax() {
	global $wgUser, $wgRequest;
	$method = $wgRequest->getVal( 'method', false );

	if ( method_exists( 'AutomaticWikiAdoptionAjax', $method ) ) {
		wfProfileIn( __METHOD__ );

		$data = AutomaticWikiAdoptionAjax::$method();

		if ( is_array( $data ) ) {
			// send array as JSON
			$json = json_encode( $data );
			$response = new AjaxResponse( $json );
			$response->setContentType( 'application/json; charset=utf-8' );
		} else {
			// send text as text/html
			$response = new AjaxResponse( $data );
			$response->setContentType( 'text/html; charset=utf-8' );
		}

		wfProfileOut( __METHOD__ );
		return $response;
	}
}
