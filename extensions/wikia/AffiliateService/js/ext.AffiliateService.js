require([
	'jquery',
	'wikia.window',
	'wikia.geo',
	'wikia.log',
	'ext.wikia.AffiliateService.units',
], function ($, w, geo, log, units) {
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

		fetchTargetingFromService: function () {
			var url = w.wgServicesExternalDomain + 'knowledge-graph/affiliates/' + w.wgCityId + '/' + w.wgArticleId

			$.ajax({
				url: url,
			}).done(function (result) {
				if (!Array.isArray(result) || result.length === 0) {
					return [];
				}
				// flatten the response
				var targeting = [];
				result.forEach(function (campaign) {
					var campaignName = campaign.campaign;
					campaign.categories.forEach(function (category) {
						targeting.push({
							campaign: campaignName,
							category: category.name,
							score: category.score,
							tracking: category.tracking,
						})
					})
				});
				// sort by score
				targeting.sort(function (a, b) {
					return b.score - a.score;
				});
				deferred.resolve(targeting);
			}).fail(function (err) {
				log('Failed to fetch affiliates data' + err, log.levels.error);
				deferred.resolve([]);
			});

			return deferred.promise();
		},

		getAvailableUnits: function (targeting) {
			var currentCountry = geo.getCountryCode();
			// clone units
			var availableUnits = units.slice();
			// filter by geo
			availableUnits = $.grep(availableUnits, function (unit) {
				var c = unit.country;
				// if there's no `.country` property os it is not an Array or `.country` is empty
				return !Array.isArray(c) || (c.length === 0) || (c.indexOf(currentCountry) > -1);
			});
			// filter by category and campaign
			availableUnits = $.grep(availableUnits, function (unit) {
				var isValid = false;
				targeting.forEach(function (t) {
					if (unit.campaign === t.campaign && unit.category === t.category) {
						isValid = true;
					}
				});
				return isValid;
			});

			return availableUnits;
		},

		addUnitToPage: function () {
			// fetch targeting
			$.when(
				AffiliateService.fetchTargetingFromService(),
			).then(function (targeting) {
				if (targeting.length > 0) {
					var availableUnits = AffiliateService.getAvailableUnits(targeting);

					console.log('>', { targeting, units, availableUnits });
				} else {
					console.log('No units available');
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

			// if (!AffiliateService.canDisplayUnit()) {
			// 	return;
			// }

			AffiliateService.addMarker();
			AffiliateService.addUnitToPage();

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
