var AdProviderOpenX = {
	url : '',
	url2 : ''
};

AdProviderOpenX.getUrl = function (baseUrl, slotname, zoneId, affiliateId, hub, additionalParams) {
	var url = baseUrl;
	url += "?loc=" + escape(window.location);
	if(typeof document.referrer != "undefined"){ url += "&referer=" + escape(document.referrer); }
	if(typeof document.context != "undefined"){ url += "&context=" + escape(document.context); }
	if(typeof document.mmm_fo != "undefined"){ url += "&mmm_fo=1"; }
	url += "&target=_top";
	if(typeof AdsCB != "undefined") { url += "&cb=" + AdsCB; } else { url += "&cb=" + Math.floor(Math.random()*99999999); }
	if(typeof document.MAX_used != "undefined" && document.MAX_used != ","){ url += "&exclude=" + document.MAX_used; }
	url += "&hub=" + hub;
	url += "&skin_name=" + skin;
	url += "&cont_lang=" + wgContentLanguage;
	url += "&user_lang=" + wgUserLanguage;
	// varnish handles this url += "&browser_lang=X-BROWSER";
	url += "&dbname=" + wgDBname;
	url += "&tags=" + wgWikiFactoryTagNames.join(",");
	url += additionalParams;
	if(slotname != ''){ url += "&slotname=" + slotname; }
	if(zoneId != ''){ url += "&zoneid=" + zoneId; }
	if(affiliateId != ''){ url += "&id=" + affiliateId; }
	url += "&block=1";

	AdProviderOpenX.url = url;

	return AdProviderOpenX.url;
};

AdProviderOpenX.getUrl2 = function() {
	var url = "/__spotlights/spc.php";
	url += "?zones=14|15|16|17|18|19|20|21|22";
	url += "&source=";
	url += "&r=" + Math.floor(Math.random()*99999999);
	url += "&loc=" + escape(window.location);
	if (typeof document.referrer !== "undefined") {
		url += "&referer=" + escape(document.referrer);
	}
	url += "&target=_top";
	url += "&cb=" + Math.floor(Math.random()*99999999);
	url += "&hub=" + window.cityShort;
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

if (!window.wgNoExternals && window.wgEnableOpenXSPC && !window.wgIsEditPage) {
	jQuery(function($) {
		$.getScript(AdProviderOpenX.getUrl2(), function() {
			var lazy = new window.Wikia.LazyLoadAds();
		});
	});
}
