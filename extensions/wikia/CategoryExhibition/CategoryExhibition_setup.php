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

// Autoload
$wgAutoloadClasses[ 'CategoryDataService' ] = __DIR__ . '/services/CategoryDataService.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionAjax' ] = __DIR__ . '/CategoryExhibitionAjax.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionCacheHelper' ] = __DIR__ . '/CategoryExhibitionCacheHelper.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionHooks' ] = __DIR__ . '/CategoryExhibitionHooks.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionPage' ] = __DIR__ . '/CategoryExhibitionPage.php';
$wgAutoloadClasses[ 'CategoryExhibitionSection' ] = __DIR__ . '/CategoryExhibitionSection.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionSectionBlogs' ] = __DIR__ . '/CategoryExhibitionSectionBlogs.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionSectionMedia' ] = __DIR__ . '/CategoryExhibitionSectionMedia.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionSectionPages' ] = __DIR__ . '/CategoryExhibitionSectionPages.class.php';
$wgAutoloadClasses[ 'CategoryExhibitionSectionSubcategories' ] = __DIR__ . '/CategoryExhibitionSectionSubcategories.class.php';
$wgAutoloadClasses[ 'CategoryPageII' ] = __DIR__ . '/CategoryPageII.php';
$wgAutoloadClasses[ 'CategoryUrlParams' ] = __DIR__ . '/CategoryUrlParams.class.php';

// Internalization
$wgExtensionMessagesFiles[ 'CategoryPageII' ] = __DIR__ . '/i18n/CategoryExhibition.i18n.php';

// Hooks
define('CATEXHIBITION_DISABLED', 'CATEXHIBITION_DISABLED');
$wgHooks['LanguageGetMagic'][] = 'CategoryExhibitionHooks::onLanguageGetMagic';
$wgHooks['InternalParseBeforeLinks'][] = 'CategoryExhibitionHooks::onInternalParseBeforeLinks';
$wgHooks['ArticleFromTitle'][] = 'CategoryExhibitionHooks::onArticleFromTitle';
$wgHooks['onArticleSaveComplete'][] = 'CategoryExhibitionHooks::onArticleSaveComplete';
$wgHooks['AfterCategoriesUpdate'][] = 'CategoryExhibitionHooks::onAfterCategoriesUpdate';

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
