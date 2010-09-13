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
	"description" => "Shows articles gallery to category page",
	"descriptionmsg" => "catgallery-desc",
//	"url" => "http://help.wikia.com/wiki/Help:Category_Galleries",
	"svn-date" => '$LastChangedDate: 2010-08-19 15:37:51 +0200 (Cz, 19 sie 2010) $',
	"svn-revision" => '$LastChangedRevision: 25551 $',
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
$wgHooks['CategoryViewer::addPage'][] = 'CategoryGalleriesHelper::onCategoryViewerAddPage';
$wgHooks['CategoryPage::getCategoryTop'][] = 'CategoryGalleriesHelper::onCategoryPageGetCategoryTop';

// Add parser magic words
define('CATGALLERY_ENABLED', 'CATGALLERY_ENABLED');
define('CATGALLERY_DISABLED', 'CATGALLERY_DISABLED');
$wgHooks['LanguageGetMagic'][] = 'CategoryGalleriesHelper::onLanguageGetMagic';
$wgHooks['InternalParseBeforeLinks'][] = 'CategoryGalleriesHelper::onInternalParseBeforeLinks';

// CategoryService setup
$wgAutoloadClasses[ 'CategoryService' ] = $dir . '/services/CategoryService.class.php';
$wgHooks['ArticleUpdateCategoryCounts'][] = 'CategoryService::onArticleUpdateCategoryCounts';
$wgHooks['TitleMoveComplete'][] = 'CategoryService::onTitleMoveComplete';

