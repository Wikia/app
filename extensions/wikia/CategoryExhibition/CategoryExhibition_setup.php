<?php

/**
 * Category Galleries II extension
 *
 * @package MediaWiki
 *
 * @author Jakub Kurcek <jakub@wikia-inc.com>
 */

if ( ! defined( 'MEDIAWIKI' ) ){
	die("Extension file.  Not a valid entry point");
}

$wgExtensionCredits['other'][] = array(
	"name" => "CategoryExhibition",
	"description" => "New loot to category page",
	"descriptionmsg" => "catexhibition-desc",
	"author" => array('Jakub Kurcek')
);


// Calculate the base directory and use it later a few times
$dir = dirname(__FILE__).'/';

// Autoload Category Page classes
$wgAutoloadClasses[ 'CategoryExhibitionPage' ]		= $dir . 'CategoryExhibitionPage.php';
$wgAutoloadClasses[ 'CategoryPageII' ]			= $dir . 'CategoryPageII.php';

// Autoload extension classes
$wgAutoloadClasses[ 'CategoryExhibitionSection' ]	= $dir . 'CategoryExhibitionSection.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionHelper' ]	= $dir . 'CategoryExhibitionHelper.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionAjax' ]		= $dir . 'CategoryExhibitionAjax.class.php';

// Autoload services
$wgAutoloadClasses[ 'CategoryDataService' ]		= $dir . 'services/CategoryDataService.class.php';

// Autoloads section data
$wgAutoloadClasses[ 'CategoryExhibitionSectionBlogs' ]	= $dir . 'CategoryExhibitionSectionBlogs.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionSectionMedia' ]	= $dir . 'CategoryExhibitionSectionMedia.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionSectionPages' ]	= $dir . 'CategoryExhibitionSectionPages.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionSectionSubcategories' ]	= $dir . 'CategoryExhibitionSectionSubcategories.class.php';

// Internalization
$wgExtensionMessagesFiles['CategoryPageII'] = $dir . 'i18n/CategoryExhibition.i18n.php';

// Hooks
define('CATEXHIBITION_DISABLED', 'CATEXHIBITION_DISABLED');
$wgHooks['LanguageGetMagic'][] = 'CategoryExhibitionHelper::onLanguageGetMagic';
$wgHooks['InternalParseBeforeLinks'][] = 'CategoryExhibitionHelper::onInternalParseBeforeLinks';
$wgHooks['ArticleFromTitle'][] = 'CategoryExhibitionHelper::onArticleFromTitle';

// Ajax dispatcher
$wgAjaxExportList[] = 'CategoryExhibitionAjax';

function CategoryExhibitionAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);
	if ( method_exists('CategoryExhibitionAjax', $method) ) {
		$data = CategoryExhibitionAjax::$method();
		wfProfileIn(__METHOD__);
		if (is_array($data)) {
			// send array as JSON
			$json = Wikia::json_encode($data);
			$response = new AjaxResponse($json);
			$response->setContentType('application/json; charset=utf-8');
		}
		else {
			// send text as text/html
			$response = new AjaxResponse($data);
			$response->setContentType('text/html; charset=utf-8');
		}
	}
	wfProfileOut(__METHOD__);
	return $response;
}