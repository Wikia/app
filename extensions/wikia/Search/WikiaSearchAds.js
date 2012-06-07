jQuery(function($) {

	return; // very very very ugly devel switch

	// In the case that there aren't enough ad units to fill the ad space
	// this function will shrink the ad wrapper to the proper height.
	function shrinkWrap(element) {
		var originalHeight = element.height();
		var shrinkToHeight = element.css('min-height', 0).height();

		if (originalHeight > shrinkToHeight) {
			element.css('min-height', originalHeight).animate({ minHeight: shrinkToHeight });
		}

		return element.removeClass('loading');
	}

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
		var template = packagesData[0].mustache[0];
		var data = resourceData[0].ads;

		shrinkWrap($('#SearchAdsTop ul').html($.mustache(template, {
			ads: data.slice(0, 3)
		})));

		shrinkWrap($('#SearchAdsBottom ul').html($.mustache(template, {
			ads: data.slice(3, 6)
		})));
	});
});