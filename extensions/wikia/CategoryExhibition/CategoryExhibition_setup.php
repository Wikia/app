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
	"descriptionmsg" => "category-exhibition-desc",
	"author" => 'Jakub Kurcek',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CategoryExhibition',
);

// Calculate the base directory and use it later a few times
$dir = dirname(__FILE__) . '/';

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
$wgHooks['onArticleSaveComplete'][] = 'CategoryExhibitionHelper::onArticleSaveComplete';
$wgHooks['AfterCategoriesUpdate'][] = 'CategoryExhibitionHelper::onAfterCategoriesUpdate';

// Ajax dispatcher
$wgAjaxExportList[] = 'CategoryExhibitionAjax';

function CategoryExhibitionAjax() {
	global $wgRequest;
	wfProfileIn(__METHOD__);
	$method = $wgRequest->getVal('method', false);
	if ( method_exists('CategoryExhibitionAjax', $method) ) {
		$data = CategoryExhibitionAjax::$method();
		if (is_array($data)) {
			// send array as JSON
			$json = json_encode($data);
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
