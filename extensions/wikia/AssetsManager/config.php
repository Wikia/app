<?php
$config = array();

// Rich Text Editor JavaScript (before reskin)
$config['oldrte'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#function_AssetsConfig::getRTEAssets'
	)
);
// Reskined rich text editor
$config['rte'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#function_AssetsConfig::getRTEAssetsEPL'
	)
);
// Generic edit page JavaScript
$config['epl'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#function_AssetsConfig::getEPLAssets',
	)
);
// Generic edit page JavaScript + reskined rich text editor
$config['eplrte'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_epl',
		'#group_rte'
	)
);

// Site specific CSS
$config['site_anon_css'] = array(
	'type' => AssetsManager::TYPE_CSS,
	'assets' => array(
		'#function_AssetsConfig::getSiteCSS'
	)
);

$config['site_user_css'] = array(
	'type' => AssetsManager::TYPE_CSS,
	'assets' => array(
		'#group_site_anon_css',
	)
);

// jQuery
$config['oasis_jquery'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#function_AssetsConfig::getJQueryUrl',
		'//skins/common/jquery/jquery.json-2.2.js',
		'//skins/common/jquery/jquery.getcss.js',
		'//skins/common/jquery/jquery.cookies.2.1.0.js',
		'//skins/common/jquery/jquery.timeago.js',
		'//skins/common/jquery/jquery.store.js',
		'//skins/common/jquery/jquery.wikia.js',
		'//skins/oasis/js/tables.js',
		'//skins/oasis/js/common.js'
	)
);

// Oasis core shared JS
$config['oasis_shared_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_oasis_jquery',
		'//skins/common/wikibits.js',
		'//skins/common/mwsuggest.js',
		'//skins/common/ajax.js',
		'//skins/oasis/js/tracker.js',
		'//skins/common/jquery/jquery.wikia.modal.js',
		'//skins/common/jquery/jquery.wikia.tracker.js',
		'//skins/oasis/js/hoverMenu.js',
		'//skins/oasis/js/PageHeader.js',
		'//skins/oasis/js/Search.js',
		'//skins/oasis/js/WikiaFooter.js',
		'//skins/oasis/js/buttons.js',
		'//skins/oasis/js/WikiHeader.js',
		'//skins/oasis/js/LatestPhotos.js',
		'//skins/oasis/js/Interlang.js',
		'//skins/oasis/js/WikiaNotifications.js',
		'//skins/oasis/js/Spotlights.js',
		'//skins/oasis/js/GlobalModal.js',
		'//skins/oasis/js/FirefoxFindFix.js',
		'//skins/oasis/js/isTouchScreen.js',
		'//skins/oasis/js/innerShiv.js',
	)
);

// Oasis extensions shared JS
$config['oasis_extensions_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/ShareFeature/js/ShareFeature.js',
		'//extensions/wikia/ArticleComments/js/ArticleComments.js',
		'//extensions/wikia/RelatedPages/js/RelatedPages.js',
		'//extensions/wikia/CreatePage/js/CreatePage.js',
		'//extensions/wikia/ImageLightbox/ImageLightbox.js',
		'//extensions/wikia/AjaxLogin/AjaxLoginBindings.js',
		'//extensions/FBConnect/fbconnect.js',
		'//extensions/wikia/AdEngine/AdConfig.js',
		'//extensions/wikia/AdEngine/AdEngine.js',
		'//extensions/wikia/AdEngine/AdProviderOpenX.js',
		'//extensions/wikia/AdEngine/LazyLoadAds.js',
		'//extensions/wikia/AdEngine/ghost/gw-11.6.6/lib/gw.min.js',
		'//extensions/wikia/Geo/geo.js',
		'//extensions/wikia/QuantcastSegments/qcs.js',
		'//extensions/wikia/ApertureAudience/Aperture.js',
		'//extensions/wikia/AdEngine/liftium/Liftium.js',
		'//extensions/wikia/AdEngine/liftium/Wikia.js',
		'//extensions/wikia/AdEngine/liftium/AdsInContent.js',
		'//extensions/wikia/AdEngine/AdDriver.js',
		'//extensions/wikia/AdSS/adss.js',
		'//extensions/wikia/PageLayoutBuilder/js/view.js', // TODO: load it on demand
		'//extensions/wikia/JSMessages/js/JSMessages.js', // TODO: maybe move to jquery.wikia.js
		'//extensions/wikia/GlobalNotification/GlobalNotification.js',
	)
);

// Oasis anon JS
$config['oasis_anon_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//skins/oasis/js/LatestActivity.js',
		'//extensions/wikia/Interstitial/Exitstitial.js',
		'#function_AssetsConfig::getSiteJS'
	)
);

// Oasis user JS
$config['oasis_user_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//skins/common/ajaxwatch.js',
		'//extensions/wikia/ArticleAjaxLoading/ArticleAjaxLoading.js',
		'#function_AssetsConfig::getSiteJS'
	)
);

//Wikiaphone JS
$config['wikiaphone_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_oasis_jquery',
		'//extensions/wikia/AdEngine/AdConfig.js',
		'//skins/wikiaphone/main.js'
	)
);

//SkeleSkin JS
$config['skeleskin_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//skins/common/zepto/zepto-0.6.js',
		'//skins/common/zepto/orientation.js',
		'//skins/skeleskin/js/main.js'
	)
);

//WikiaMobile JS
$config['wikiamobile_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//skins/common/zepto/zepto-0.7.js',
		'//skins/wikiamobile/js/zepto.wikiamobile.js',
		'//skins/common/zepto/zepto.getcss.js',
		'//skins/common/zepto/orientation.js',
		'//skins/wikiamobile/js/main.js',
		'//extensions/wikia/JSSnippets/js/JSSnippetsMobile.js'
	)
);

//WikiaApp JS and CSS
$config['wikiaapp_css'] = array(
	'type' => AssetsManager::TYPE_CSS,
	'assets' => array(
		'//skins/wikiaapp/main.css',
		'//skins/wikiaapp/skin.css'
	)
);

$config['wikiaapp_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//skins//common/zepto/zepto-0.6.js',
		'//skins/wikiaapp/main.js'
	)
);

$config['chat_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_oasis_jquery',
		'//extensions/wikia/Chat/js/lib/socket.io.client.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/Chat/js/lib/underscore.js',
		'//extensions/wikia/Chat/js/lib/backbone.js',
		'//extensions/wikia/Chat/js/models/models.js',
		'//extensions/wikia/Chat/js/controllers/controllers.js',
		'//extensions/wikia/Chat/js/views/views.js',
	)
);
