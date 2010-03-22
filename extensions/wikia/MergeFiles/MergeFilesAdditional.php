<?php
/*
 * Author: Inez Korczynski (inez@wikia.com)
 */
if(!defined('MEDIAWIKI')) {
	exit(1);
}

function getWidgetsAssets() {
	$js = $css = array();
	$dir = 'extensions/wikia/WidgetFramework/Widgets/';
	if(is_dir($dir)) {
		if($dh = opendir($dir)) {
			while(($file = readdir($dh)) !== false) {
				if(filetype($dir.$file) == 'dir') {
					if(file_exists($dir.$file.'/'.$file.'.js')) {
						$js[] = '../'.$dir.$file.'/'.$file.'.js';
					}
					if(file_exists($dir.$file.'/'.$file.'.css')) {
						$css[] = '../'.$dir.$file.'/'.$file.'.css';
					}
				}
			}
		}
		closedir($dh);
	}
	return array('js' => $js, 'css' => $css);
}

$widgetsAssets = getWidgetsAssets();

global $MF;

$MF['quartz_js']['source'] = array(
	'common/yui_2.5.2/utilities/utilities.js',
	'common/yui_2.5.2/cookie/cookie-beta.js',
	'common/yui_2.5.2/container/container.js',
	'common/yui_2.5.2/autocomplete/autocomplete.js',
	'common/yui_2.5.2/logger/logger.js',
	'common/yui_2.5.2/menu/menu.js',
	'common/yui_2.5.2/tabview/tabview.js',
	'common/yui_extra/tools-min.js',
	'common/yui_extra/carousel-min.js',

	'common/jquery/jquery-1.3.2.js',
	'common/jquery/jquery.json-1.3.js',
	'common/jquery/jquery.cookies.2.1.0.js',
	'common/jquery/jquery.wikia.js',
	'common/jquery/jquery-ui-1.7.1.custom.js',
	'common/jquery/jquery.flytabs.js',

	'common/urchin.js',
	'quartz/js/main.js',
	'quartz/js/usermenu.js',
	'quartz/js/languagemenu.js',
	'quartz/js/shareit.js',
	'quartz/js/ratearticle.js',
	'quartz/js/search.js',
	'common/widgets/js/widgetsConfig.js',
	'common/widgets/js/widgetsFramework.js',
	'common/wikibits.js',
	'quartz/js/tracker.js',
	'common/tracker.js',
	'../extensions/wikia/AjaxLogin/AjaxLogin.js',
	'../extensions/wikia/ProblemReports/js/ProblemReports-loader.js',
	'../extensions/wikia/HelperPanel/HelperPanel.js',
	'common/contributed.js',
);
$MF['quartz_js']['source'] = array_merge($MF['quartz_js']['source'], $widgetsAssets['js']);

$MF['quartz_css']['source'] = array(
	'../extensions/wikia/Blogs/css/Blogs.css',
);

$MF['quartz_css']['source'] = array_merge($MF['quartz_css']['source'],$widgetsAssets['css']);

$MF['monobook_js']['source'] = array(
	'common/yui_2.5.2/utilities/utilities.js',
	'common/yui_2.5.2/cookie/cookie-beta.js',
	'common/yui_2.5.2/container/container.js',
	'common/yui_2.5.2/autocomplete/autocomplete.js',
	'common/yui_2.5.2/logger/logger.js',
	'common/yui_2.5.2/menu/menu.js',
	'common/yui_2.5.2/tabview/tabview.js',
	'common/yui_extra/tools-min.js',

	'common/jquery/jquery-1.3.2.js',
	'common/jquery/jquery.json-1.3.js',
	'common/jquery/jquery.cookies.2.1.0.js',
	'common/jquery/jquery.wikia.js',
	'common/jquery/jquery.flytabs.js',

	'common/urchin.js',
	'common/wikibits.js',
	'monobook/main.js',
	'monobook/tracker.js',
	'common/tracker.js',
	'../extensions/wikia/ProblemReports/js/ProblemReports-loader.js',
	'common/contributed.js',
);

$MF['monobook_css']['source'] = array(
	'../extensions/wikia/Blogs/css/Blogs.css',
);

$MF['monaco_loggedin_js']['source'] = array(
	'common/yui_2.5.2/utilities/utilities.js',
	'common/yui_2.5.2/cookie/cookie-beta.js',
	'common/yui_2.5.2/container/container.js',
	'common/yui_2.5.2/autocomplete/autocomplete.js',
	'common/yui_2.5.2/animation/animation-min.js',
	'common/yui_2.5.2/logger/logger.js',
	'common/yui_2.5.2/menu/menu.js',
	'common/yui_2.5.2/tabview/tabview.js',
	'common/yui_extra/tools-min.js',
	'common/yui_extra/carousel-min.js',

	'common/jquery/jquery-1.3.2.js',
	'common/jquery/jquery.json-1.3.js',
	'common/jquery/jquery.cookies.2.1.0.js',
	'common/jquery/jquery.wikia.js',
	'common/jquery/jquery-ui-1.7.1.custom.js',
	'common/jquery/jquery.flytabs.js',

	'common/ajax.js',
	'common/urchin.js',
	'common/wikibits.js',
 	'monaco_old/js/tracker.js',
	'common/tracker.js',
	'common/ajaxwatch.js',
	'monaco_old/js/main.js',
	'common/widgets/js/widgetsConfig.js',
	'common/widgets/js/widgetsFramework.js',
	'../extensions/wikia/ProblemReports/js/ProblemReports-loader.js',
	'../extensions/wikia/AdEngine/AdEngine.js',
	'common/contributed.js',
	'../extensions/wikia/ShareFeature/js/ShareFeature.js',
);
$MF['monaco_loggedin_js']['source'] = array_merge($MF['monaco_loggedin_js']['source'], $widgetsAssets['js']);

$MF['monaco_non_loggedin_js']['source'] = array(
	'common/yui_2.5.2/utilities/utilities.js',
	'common/yui_2.5.2/cookie/cookie-beta.js',
	'common/yui_2.5.2/container/container.js',
	'common/yui_2.5.2/autocomplete/autocomplete.js',
	'common/yui_2.5.2/animation/animation-min.js',
	'common/yui_2.5.2/logger/logger.js',
	'common/yui_2.5.2/menu/menu.js',
	'common/yui_2.5.2/tabview/tabview.js',
	'common/yui_extra/tools-min.js',

	'common/jquery/jquery-1.3.2.js',
	'common/jquery/jquery.json-1.3.js',
	'common/jquery/jquery.cookies.2.1.0.js',
	'common/jquery/jquery.wikia.js',
	'common/jquery/jquery-ui-1.7.1.custom.js',
	'common/jquery/jquery.flytabs.js',

	'common/ajax.js',
	'common/urchin.js',
	'common/wikibits.js',
	'monaco_old/js/tracker.js',
	'common/tracker.js',
	'monaco_old/js/main.js',
	'common/widgets/js/widgetsConfig.js',
	'common/widgets/js/widgetsFramework.js',
	'../extensions/wikia/AjaxLogin/AjaxLogin.js',
	'../extensions/wikia/ProblemReports/js/ProblemReports-loader.js',
	'../extensions/wikia/AdEngine/AdEngine.js',
	'../extensions/wikia/Userengagement/Userengagement.js',
	'common/contributed.js',
	'../extensions/wikia/ShareFeature/js/ShareFeature.js',
);
$MF['monaco_non_loggedin_js']['source'] = array_merge($MF['monaco_non_loggedin_js']['source'], $widgetsAssets['js']);

$MF['monaco_css']['source'] = array(
	'common/yui_2.5.2/container/assets/container.css',
	'common/yui_2.5.2/tabview/assets/tabview.css',
	'common/shared.css',
	'monaco_old/css/monobook_modified.css',
	'monaco_old/css/reset_modified.css',
	'monaco_old/css/root.css',
	'monaco_old/css/header.css',
	'monaco_old/css/article.css',
	'monaco_old/css/widgets.css',
	'monaco_old/css/footer.css',
	'monaco_old/css/star_rating.css',
	'monaco_old/css/ny.css',
	'monaco_old/css/modal.css',
	'../extensions/wikia/Blogs/css/Blogs.css',
	'../extensions/wikia/Masthead/css/Masthead.css',
);
$MF['monaco_css']['source'] = array_merge($MF['monaco_css']['source'], $widgetsAssets['css']);

/* Lean Monaco */
// see StaticChute extension for list of JS/CSS files loaded in LeanMonaco
