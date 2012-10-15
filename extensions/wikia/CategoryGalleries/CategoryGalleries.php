<?php
/**
 * Category Galleries extension
 *
 * @package MediaWiki
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */

if ( ! defined( 'MEDIAWIKI' ) ){
	die("Extension file.  Not a valid entry point");
}

$wgExtensionCredits['other'][] = array(
	"name" => "CategoryGalleries",
	'descriptionmsg' => 'categorygalleries-desc',
//	"url" => "http://help.wikia.com/wiki/Help:Category_Galleries",
	"author" => array('Władysław Bodzek')
);

// Calculate the base directory and use it later a few times
$dir = dirname(__FILE__);

// Autoload base classes
$wgAutoloadClasses[ 'CategoryGallery' ] = $dir . '/CategoryGallery.class.php';
$wgAutoloadClasses[ 'CategoryGalleriesHelper' ] = $dir . '/CategoryGalleriesHelper.class.php';

// Internalization
$wgExtensionMessagesFiles['CategoryGalleries'] = $dir . '/CategoryGalleries.i18n.php';

// Set up hooks for embedding gallery into category page
$wgHooks['CategoryPageView'][] = 'CategoryGalleriesHelper::onCategoryPageView';
$wgHooks['CategoryPage::getCategoryTop'][] = 'CategoryGalleriesHelper::onCategoryPageGetCategoryTop';
$wgHooks['CategoryService::invalidateTopArticles'][] = 'CategoryGalleriesHelper::onCategoryServiceInvalidateTopArticles';
$wgHooks['ArticlePurge'][] = 'CategoryGalleriesHelper::onArticlePurge';

// Add parser magic words
define('CATGALLERY_ENABLED', 'CATGALLERY_ENABLED');
define('CATGALLERY_DISABLED', 'CATGALLERY_DISABLED');
$wgHooks['LanguageGetMagic'][] = 'CategoryGalleriesHelper::onLanguageGetMagic';
$wgHooks['InternalParseBeforeLinks'][] = 'CategoryGalleriesHelper::onInternalParseBeforeLinks';

// CategoryService setup
$wgAutoloadClasses[ 'CategoryService' ] = $dir . '/services/CategoryService.class.php';
$wgHooks['ArticleUpdateCategoryCounts'][] = 'CategoryService::onArticleUpdateCategoryCounts';
$wgHooks['TitleMoveComplete'][] = 'CategoryService::onTitleMoveComplete';
