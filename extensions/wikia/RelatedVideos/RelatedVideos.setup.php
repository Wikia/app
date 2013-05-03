<?php
/**
 * @var WikiaApp
 */

$app = F::app();
$dir = dirname( __FILE__ );
if ( empty( $wgWikiaVideoRepoCategoryPath ) ){
	$wgWikiaVideoRepoCategoryPath = '';
}

/**
 * classes
 */
$wgAutoloadClasses['RelatedVideosHookHandler'] =  $dir . '/RelatedVideos.hooks.php';
$wgAutoloadClasses['RelatedVideosElement'] =  $dir . '/models/RelatedVideos.model.php';
$wgAutoloadClasses['RelatedVideosData'] =  $dir . '/RelatedVideosData.class.php';
$wgAutoloadClasses['RelatedVideosService'] =  $dir. '/RelatedVideosService.class.php';
$wgAutoloadClasses['RelatedVideosNamespaceData'] =  $dir . '/RelatedVideosNamespaceData.class.php';
$wgAutoloadClasses['RelatedVideosEmbededData'] =  $dir . '/RelatedVideosEmbededData.class.php';
$wgAutoloadClasses['RelatedVideosRailController'] =  $dir . '/RelatedVideosRailController.class.php';

/**
 * controllers
 */
$wgAutoloadClasses['RelatedVideosController'] =  $dir . '/RelatedVideosController.class.php';
$wgAutoloadClasses['RelatedHubsVideosController'] =  $dir . '/RelatedHubsVideosController.class.php';

/**
 * hooks
 */
$app->registerHook('BeforePageDisplay', 'RelatedVideosHookHandler', 'onBeforePageDisplay' );

define('RELATEDVIDEOS_POSITION', 'RELATEDVIDEOS_POSITION');
$app->registerHook('LanguageGetMagic', 'RelatedVideosHookHandler', 'onLanguageGetMagic' );
$app->registerHook('InternalParseBeforeLinks', 'RelatedVideosHookHandler', 'onInternalParseBeforeLinks' );

if( !empty( $wgRelatedVideosOnRail ) ) {
	$app->registerHook('GetRailModuleList', 'RelatedVideosHookHandler', 'onGetRailModuleList');
} else {
	array_splice( $wgHooks['OutputPageBeforeHTML'], 0, 0, 'RelatedVideosHookHandler::onOutputPageBeforeHTML' );
}

$app->registerHook('ArticleSaveComplete', 'RelatedVideosHookHandler', 'onArticleSaveComplete');
$app->registerHook( 'FileDeleteComplete', 'RelatedVideosHookHandler', 'onFileDeleteComplete' );
$app->registerHook( 'FileUndeleteComplete', 'RelatedVideosHookHandler', 'onFileUndeleteComplete' );
$app->registerHook( 'SpecialMovepageAfterMove', 'RelatedVideosHookHandler', 'onFileRenameComplete' );
$app->registerHook( 'ArticleDeleteComplete', 'RelatedVideosHookHandler', 'onArticleDeleteComplete' );
$app->registerHook( 'UndeleteComplete', 'RelatedVideosHookHandler', 'onUndeleteComplete' );

/**
 * messages
 */
$app->registerExtensionMessageFile( 'RelatedVideos', $dir . '/RelatedVideos.i18n.php' );

/**
 * extension related configuration
 */
// setup "RelatedVideo" namespace
define('NS_RELATED_VIDEOS', 1100);

$wgExtensionNamespacesFiles['RelatedVideos'] = "{$dir}/RelatedVideos.namespaces.php";
wfLoadExtensionNamespaces('RelatedVideos', array(NS_RELATED_VIDEOS));

// permissions
$wgGroupPermissions['*']['relatedvideos'] = false;
// Ideally we would hide viewing of the namespace articles from all but admins
// and staff, but give logged-in users edit privileges (which are needed to
// support the GUI add/remove video tools).
// The relatedvideos namespace covers editing of the namespace. we should
// restrict viewing of the namespace articles in some other way.
$wgGroupPermissions['user']['relatedvideos'] = true;
//$wgGroupPermissions['staff']['relatedvideos'] = true;
$wgNamespaceProtection[ NS_RELATED_VIDEOS ] = array( 'relatedvideos' );
$wgNonincludableNamespaces[] = NS_RELATED_VIDEOS;

$wgAvailableRights[] = 'relatedvideosedit';
if ( empty($wgRelatedVideosAdminOnly) ) {
	$wgGroupPermissions['*']['relatedvideosedit'] = true;
} else {
	$wgGroupPermissions['*']['relatedvideosedit'] = false;
	$wgGroupPermissions['staff']['relatedvideosedit'] = true;
	$wgGroupPermissions['sysop']['relatedvideosedit'] = true;
}

$wgAvailableRights[] = 'relatedvideosdelete';
$wgGroupPermissions['*']['relatedvideosdelete'] = false;
$wgGroupPermissions['staff']['relatedvideosdelete'] = true;
$wgGroupPermissions['sysop']['relatedvideosdelete'] = true;
$wgGroupPermissions['helper']['relatedvideosdelete'] = true;

