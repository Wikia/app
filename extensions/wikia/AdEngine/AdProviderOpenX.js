var AdProviderOpenX = {
	url : ''
};

AdProviderOpenX.getUrl = function (baseUrl, slotname, zoneId, affiliateId, hub, additionalParams) {
	var url = baseUrl;
	url += "?loc=" + escape(window.location);
	if(typeof document.referrer != "undefined") url += "&referer=" + escape(document.referrer);
	if(typeof document.context != "undefined") url += "&context=" + escape(document.context);
	if(typeof document.mmm_fo != "undefined") url += "&mmm_fo=1";
	url += "&target=_top";
	if(typeof AdsCB != "undefined") { url += "&cb=" + AdsCB; } else { url += "&cb=" + Math.floor(Math.random()*99999999); }
	if(typeof document.MAX_used != "undefined" && document.MAX_used != ",") url += "&exclude=" + document.MAX_used;
	url += "&hub=" + hub;
	url += "&skin_name=" + skin;
	url += "&cont_lang=" + wgContentLanguage;
	url += "&user_lang=" + wgUserLanguage;
	url += "&dbname=" + wgDB;
	url += "&tags=" + wgWikiFactoryTagNames.join(",");
	url += additionalParams;
	if(slotname != '') url += "&slotname=" + slotname;
	if(zoneId != '') url += "&zoneid=" + zoneId;
	if(affiliateId != '') url += "&id=" + affiliateId;
	url += "&block=1";

	AdProviderOpenX.url = url;

	return AdProviderOpenX.url;
}
