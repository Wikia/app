<?php
$config = array();

$config['rte'] = array(
	'#function_AssetsConfig::getRTEAssets',
);

$config['site_css'] = array(
	'#function_AssetsConfig::getSiteCSS',
);

$config['oasis_jquery'] = array(
	'//skins/common/jquery/jquery-1.5.2.js',
	'//skins/common/jquery/jquery.json-1.3.js',
	'//skins/common/jquery/jquery.getcss.js',
	'//skins/common/jquery/jquery.wikia.js',
	'//skins/common/jquery/jquery.cookies.2.1.0.js',
	'//skins/common/jquery/jquery.timeago.js',
	'//skins/oasis/js/tables.js',
	'//skins/oasis/js/common.js',
);

$config['oasis_shared_js'] = array(
	'#group_oasis_jquery',
	'//skins/common/wikibits.js',
	'//skins/common/mwsuggest.js',
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
	'//extensions/wikia/ShareFeature/js/ShareFeature.js',
	'//extensions/wikia/ArticleComments/js/ArticleComments.js',
	'//extensions/wikia/RelatedPages/js/RelatedPages.js',
	'//skins/oasis/js/WikiaNotifications.js',
	'//skins/oasis/js/Spotlights.js',
	'//skins/common/ajax.js',
	'//extensions/wikia/CreatePage/js/CreatePage.js',
	'//extensions/wikia/ImageLightbox/ImageLightbox.js',
	'//extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.view.js',
	'//extensions/wikia/AjaxLogin/AjaxLoginBindings.js',
	'//extensions/FBConnect/fbconnect.js',
	'//extensions/wikia/AdEngine/AdConfig.js',
	'//extensions/wikia/AdEngine/AdEngine.js',
	'//extensions/wikia/AdEngine/AdProviderOpenX.js',
	'//extensions/wikia/AdEngine/LazyLoadAds.js',
	'//extensions/wikia/AdEngine/ghost/gw-2010.10.4/lib/gw.js',
	'//extensions/wikia/Geo/geo.js',
	'//extensions/wikia/QuantcastSegments/qcs.js',
	'//extensions/wikia/AdEngine/liftium/Liftium.js',
	'//extensions/wikia/AdEngine/liftium/Wikia.js',
	'//extensions/wikia/AdEngine/AdDriver.js',
	'//extensions/wikia/AdSS/adss.js',
	'//extensions/wikia/PageLayoutBuilder/js/view.js',
	'//skins/oasis/js/GlobalModal.js',
);

$config['oasis_anon_js'] = array(
	'#group_oasis_shared_js',
	'//skins/oasis/js/LatestActivity.js',
	'//extensions/wikia/Interstitial/Exitstitial.js',
	'#function_AssetsConfig::getSiteJS',
);

$config['oasis_user_js'] = array(
	'#group_oasis_shared_js',
	'//skins/common/ajaxwatch.js',
	'#function_AssetsConfig::getSiteJS',
);
