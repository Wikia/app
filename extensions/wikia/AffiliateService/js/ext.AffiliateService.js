require([
	'jquery',
	'wikia.window',
	'wikia.log',
], function ($, w, log) {
	'use strict';

	var deferred = $.Deferred();

	var AffiliateService = {
		$infoBox: undefined,

		canDisplayUnit: function () {
			typeof AffiliateService.$infoBox !== 'undefined';
		},

		getStartHeight: function () {
			var infoBoxOffset = AffiliateService.$infoBox.offset();
			var infoBoxHeight = AffiliateService.$infoBox.height();

			return infoBoxOffset.top + infoBoxHeight;
		},

		fetchUnitsFromService: function () {
			var url = w.wgServicesExternalDomain + 'knowledge-graph/affiliates/' + w.wgCityId + '/' + w.wgArticleId

			$.ajax({
				url: url,
			}).done(function (result) {
				deferred.resolve(result);
			}).fail(function (err) {
				log('Failed to fetch affiliates data' + err, log.levels.error);
				deferred.resolve(null);
			});

			return deferred.promise();
		},

		addUnitsToPage: function () {
			// fetch units
			$.when(
				AffiliateService.fetchUnitsFromService(),
			).then(function (units) {
				// if it's `null`, there's 404 on the services side
				if (Array.isArray(units)) {
					// HERE WE HAVE SOME DATA
					console.log('>', units);
				}
			});
		},

		addMarker: function () {
			var startHeight = AffiliateService.getStartHeight();

			// only select paragraphs one level from the root main element
			var $paragraphs = $('#mw-content-text > p');

			// prepend the unit after the first paragraph below the infobox
			$paragraphs.each(function (index, element) {
				var $paragraph = $(element);
				var paragraphHeight = $paragraph.offset().top;

				if (paragraphHeight > startHeight) {
					$paragraph.prepend('<div style="background: red; width: 100%; height: 100px"> </div>')
					return false;
				}
			});
		},

		init: function () {
			AffiliateService.$infoBox = $('.portable-infobox').first();


			if (!AffiliateService.canDisplayUnit()) {
				return;
			}

			AffiliateService.addMarker();
			AffiliateService.addUnitsToPage();


		// iterate through all of the paragraphs comparing the widths of each one. When there is a width that is much larger
		// than the previous high use that. Only look at the first N paragraphs.
		// var widths = [];
		// var defaultSlot = null;
		// $paragraphs.each(function(index, element) {
		// 	var $paragraph = $(element);
		// 	var paragraphWidth = $paragraph.width();
		// 	widths.push(paragraphWidth);

		// 	var maxWidth = Math.max.apply(null, widths);

		// 	if (index > 2) {
		// 		console.log(paragraphWidth, maxWidth);
		// 		if (paragraphWidth > maxWidth) {
		// 			$paragraph.append('<div style="background: blue; width: 100%; height: 100px"> </div>')
		// 			return false;
		// 		}
		// 	}
		// });
		},
	};

	$(AffiliateService.init);
});
