jQuery(document).ready(function() {

return; // very very very ugly devel switch

$.when(
	$.loadMustache(),
	$.nirvana.sendRequest({
		controller: 'WikiaSearchAdsController',
		method: 'getAds',
		format: 'json'
	}),
	Wikia.getMultiTypePackage({
		mustache: 'extensions/wikia/Search/templates/WikiaSearchAds_getAds.mustache'
	})
).done(function(libData, resourceData, packagesData) {
	//$().log({libData: libData, resourceData: resourceData, packagesData: packagesData}, 'WikiaSearchAds');

	var template = packagesData[0].mustache[0];
	var data = resourceData[0].ads;

	var html = $.mustache(template, {ads: data.slice(0,3)});
	//$().log(html, 'WikiaSearchAds');
	$('div#SearchAdsTop').html(html);

	var html = $.mustache(template, {ads: data.slice(3,6)});
	//$().log(html, 'WikiaSearchAds');
	$('div#SearchAdsBottom').html(html);
});

});