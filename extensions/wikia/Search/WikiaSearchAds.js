jQuery(function($) {
	//$().log('start', 'WikiaSearchAds');

	// In the case that there aren't enough ad units to fill the ad space
	// this function will shrink the ad wrapper to the proper height.
	function shrinkWrap(element) {
		//$().log(element, 'WikiaSearchAds');
		var originalHeight = element.height();
		var shrinkToHeight = element.css('min-height', 0).height();

		if (originalHeight > shrinkToHeight) {
			element.css('min-height', originalHeight).animate({ minHeight: shrinkToHeight });
		}

		return element.removeClass('loading');
	}

	//$().log([$('#search-v2-input').val(), null, window.navigator.userAgent], 'WikiaSearchAds');
	$.when(
		$.loadMustache(),
		$.nirvana.sendRequest({
			controller: 'WikiaSearchAdsController',
			method: 'getAds',
			format: 'json',
			data: {
				query: $('#search-v2-input').val(),
				header: window.navigator.userAgent
			}
		}),
		Wikia.getMultiTypePackage({
			mustache: 'extensions/wikia/Search/templates/WikiaSearchAds_getAds.mustache'
		})

	).done(function(libData, resourceData, packagesData) {
		//$().log([libData, resourceData, packagesData], 'WikiaSearchAds');
		var template = packagesData[0].mustache[0]
			, data = resourceData[0].ads;
		//$().log([template, data], 'WikiaSearchAds');

		shrinkWrap($('#SearchAdsTop ul').html($.mustache(template, {
			ads: data.slice(0, 3)
		})));

		shrinkWrap($('#SearchAdsBottom ul').html($.mustache(template, {
			ads: data.slice(3, 6)
		})));
	});
});
