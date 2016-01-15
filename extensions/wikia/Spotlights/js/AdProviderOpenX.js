var AdProviderOpenX = {
	url : '',
	url2 : '',
	defaultHttpBase: 'http://spotlights.wikia.net/',
	reviveHttpBase: 'http://spotlights-revive.wikia.net/'
};

AdProviderOpenX.getUrl2 = function() {

	var httpBase = window.wgEnableReviveSpotlights ? AdProviderOpenX.reviveHttpBase : AdProviderOpenX.defaultHttpBase,
		url = httpBase + "spc.php";
		url += "?zones=14|15|16|17|18|19|20|21|22";
		url += "&source=";
		url += "&r=" + Math.floor(Math.random()*99999999);
		url += "&loc=" + escape(window.location);
	if (typeof document.referrer !== "undefined") {
		url += "&referer=" + escape(document.referrer);
	}
		url += "&target=_top";
		url += "&cb=" + Math.floor(Math.random()*99999999);
		url += "&hub=" + window.wgWikiVertical;
		url += "&skin_name=" + skin;
		url += "&cont_lang=" + wgContentLanguage;
		url += "&user_lang=" + wgUserLanguage;
		// varnish handles this url += "&browser_lang=X-BROWSER";
		url += "&dbname=" + wgDBname;
		url += "&tags=" + escape(wgWikiFactoryTagNames.join(","));
		url += "&block=1";
		url += (document.charset ? '&charset='+document.charset : (document.characterSet ? '&charset='+document.characterSet : ''));

	AdProviderOpenX.url2 = url;

	return AdProviderOpenX.url2;
};

if (!window.wgNoExternals && window.wgEnableOpenXSPC && !window.wgIsEditPage && !window.navigator.userAgent.match(/sony_tvs/)) {
	jQuery(function($) {
		$.getScript(AdProviderOpenX.getUrl2(), function() {
			var lazy = new window.Wikia.LazyLoadAds();
		});
	});
} else {
	$('#SPOTLIGHT_FOOTER').parent('section').hide();
}
