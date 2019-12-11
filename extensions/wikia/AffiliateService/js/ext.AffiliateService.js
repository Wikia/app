// find the first slot where we can insert
// todo: we could use a better algorithm here
function insertSpot(arr, val) {
	for (var i = 0; i < arr.length - 1; i++) {
		var arrVal = arr[i];
		var nextVal = arr[i + 1];

		if (i === 0 && arrVal > val) {
			return -1;
		}

		if (arrVal <= val && nextVal > val) {
			return i;
		}
	}

	return arr.length;
}

function flattenServiceResponse(response) {
	var targeting = [];
	response.forEach(function (campaign) {
		var campaignName = campaign.campaign;
		campaign.categories.forEach(function (category) {
			targeting.push({
				campaign: campaignName,
				category: category.name,
				score: category.score,
				tracking: category.tracking,
				recommendationLevel: category.recommendationLevel,
			})
		})
	});
	// sort by score
	targeting.sort(function (a, b) {
		return b.score - a.score;
	});

	// sort by page targetting first
	targeting.sort(function(a, b) {
		if (!a.recommendationLevel || !b.recommendationLevel) {
			return 0;
		}

		return a.recommendationLevel === 'page' ? -1 : 1;
	});

	return targeting;
}

require([
	'jquery',
	'wikia.window',
	'wikia.geo',
	'wikia.log',
	'ext.wikia.AffiliateService.units',
	'ext.wikia.AffiliateService.templates',
	'ext.wikia.AffiliateService.tracker',
], function ($, w, geo, log, units, templates, tracker) {
	'use strict';

	var deferred = $.Deferred();
	var $w = $(w);

	var AffiliateService = {
		$infoBox: undefined,

		// ?debugAffiliateServiceTargeting=campaign,category
		getDebugTargeting: function() {
			// check if we have the mechanism to get the param (ie. not on IE)
			if (typeof URLSearchParams === 'function') {
				var urlParams = new URLSearchParams(w.location.search);

				if (urlParams.has('debugAffiliateServiceTargeting')) {
					return urlParams.get('debugAffiliateServiceTargeting');
				}
			}

			return false;
		},

		canDisplayUnit: function () {
			// you're logged out?
			if (!w.wgUserName) {
				// is that wiki whitelisted?
				if (w.wgAffiliateEnabled) {
					return true;
				}

				// do we have debug targeting
				if (AffiliateService.getDebugTargeting() !== false) {
					return true;
				}
			}

			// tough luck
			return false;
		},

		getStartHeight: function () {
			if (AffiliateService.$infoBox.length === 0) {
				return 0;
			}

			var infoBoxOffset = AffiliateService.$infoBox.offset();
			var infoBoxHeight = AffiliateService.$infoBox.height();

			return infoBoxOffset.top + infoBoxHeight;
		},

		fetchTargetingFromService: function () {
			var debugTargetting = AffiliateService.getDebugTargeting();
			if (debugTargetting !== false) {
				console.log('debugTargetting', debugTargetting);

				const debugArray = debugTargetting.split(',');

				deferred.resolve([{
					campaign: debugArray[0],
					category: debugArray[1],
					score: 1,
					tracking: [],
				}]);

				return deferred.promise();
			}

			var url = w.wgServicesExternalDomain + 'knowledge-graph/affiliates/' + w.wgCityId + '/' + w.wgArticleId

			$.ajax({
				url: url,
			}).done(function (result) {
				if (!Array.isArray(result) || result.length === 0) {
					deferred.resolve([]);
				}
				deferred.resolve(flattenServiceResponse(result));
			}).fail(function (err) {
				log('Failed to fetch affiliates data' + err, log.levels.error);
				deferred.resolve([]);
			});

			return deferred.promise();
		},

		getAvailableUnits: function (targeting) {
			var currentCountry = geo.getCountryCode();
			// clone units
			var potentialUnits = units.slice();
			// filter by geo
			potentialUnits = $.grep(potentialUnits, function (unit) {
				var c = unit.country;
				// if there's no `.country` property os it is not an Array or `.country` is empty
				return !Array.isArray(c) || (c.length === 0) || (c.indexOf(currentCountry) > -1);
			});
			// filter by category and campaign also add tracking to the list
			var availableUnits = [];
			potentialUnits.forEach(function (unit) {
				// for every unit check every targeting, add to the list if we have a match
				targeting.forEach(function (t) {
					if (unit.campaign === t.campaign && unit.category === t.category) {
						// add tracking params coming from the service
						availableUnits.push($.extend({}, unit, {
							tracking: t.tracking,
						}));
					}
				});
			});

			return availableUnits;
		},

		addUnitToPage: function () {
			$.when(
				AffiliateService.fetchTargetingFromService(),
			).then(function (targeting) {
				if (targeting.length > 0) {
					var availableUnits = AffiliateService.getAvailableUnits(targeting);

					if (availableUnits.length > 0) {
						var unit = availableUnits[0];
						// add unit data to be inserted into template
						AffiliateService.renderUnitMarkup(unit);
					} else {
						console.log('No units available for targeting', targeting);
					}
				} else {
					console.log('No targeting available');
				}
			});
		},

		insertAtPointAndTrack: function ($insertionPoint, unit) {
			// check if we found good insertion point
			if ($insertionPoint) {
				// get html to insert into target location
				var html = AffiliateService.getTemplate(unit);

				// insert markup
				var $element = $insertionPoint.prepend(html);

				// add extra fields
				var extraTracking = unit.tracking.slice();
				extraTracking.push({
					// Y of the insertion point
					key: 'instertedAtY',
					val: $insertionPoint.offset().top,
				});

				var trackingOptions = {
					campaignId: unit.campaign,
					categoryId: unit.category,
					extraTracking: extraTracking,
				};

				// hook onmousedown tracking
				$element.find('.affiliate-unit__cta').on('mousedown', function (event) {
					tracker.trackClick('only-item', trackingOptions);
				});

				// hook true impression
				var impressionFired = false;
				$w.on('resize scroll', $.debounce(150, function () {
					if (!impressionFired) {
						var elementTop = $element.offset().top;
						var elementBottom = elementTop + $element.outerHeight();
						var viewportTop = $w.scrollTop();
						var viewportBottom = viewportTop + $w.height();

						// check if we're in viewport
						if (elementBottom > viewportTop && elementTop < viewportBottom) {
							tracker.trackImpression(trackingOptions);
							impressionFired = true;
						}
					}
				}));

				// fire "load" impression
				tracker.trackLoad(trackingOptions);
			} else {
				// we couldn't insert the unit
				tracker.trackNoImpression(trackingOptions);
			}
		},

		renderUnitMarkup: function (unit) {
			var startHeight = AffiliateService.getStartHeight();

			// only select paragraphs one level from the root main element
			var $paragraphs = $('#mw-content-text > p');

			// don't select placement near images
			var $images = $('#mw-content-text > figure');
			var notAllowedYStart = []; // array of y coordinate start positions
			var notAllowedYStop = [] // array of y coordinate final positions

			$images.each(function(index, element) {
				var $image = $(element);
				var imageStart = $image.offset().top;
				notAllowedYStart.push(imageStart);
				notAllowedYStop.push(imageStart + $image.height());
			});

			// determine if this y coordinate conflicts with any images
			function isValidSlot(yStart) {
				// if there are no images always return true
				if (notAllowedYStart.length === 0) {
					return true;
				}

				// find the index of where this would be inserted
				var index = insertSpot(notAllowedYStart, yStart);

				// no images yet, we are gucci
				if (index === -1) {
					return true;
				}

				var notAllowedYStartValue = notAllowedYStart[index];
				var notAllowedYStopValue = notAllowedYStop[index];

				// happens when the index is is out of the bounds of possibility (no images before that point)
				if (notAllowedYStartValue === undefined) {
					return true;
				}

				// verify that the final value that isn't allow is less than the requested y start position
				if (notAllowedYStopValue < yStart) {
					return true;
				}

				return false;
			}

			// if we cannot find a location after useFallbackAtY use the highest slot below a heading
			var $fallbackParagraph = null;
			var useFallbackAtY = 20000;

			// prepend the unit after the first paragraph below the
			var $insertionPoint = undefined;
			$paragraphs.each(function(index, element) {
				var $paragraph = $(element);
				var paragraphY = $paragraph.offset().top;

				// make sure we are past the infobox and not near an image
				if (paragraphY > startHeight && isValidSlot(paragraphY)) {
					if ($fallbackParagraph === null) {
						$fallbackParagraph = $paragraph;
					}

					// when prepending make sure the prev child is a paragraph
					if ($paragraph.prev().is('p')) {
						$insertionPoint = $paragraph;
						return false;
					}
				}

				// once we hit a certain height lets go back up and use one of the fall back paragraphs
				if ($fallbackParagraph && paragraphY > useFallbackAtY) {
					log('Affiliate Unit inserted using fallback slot');
					$insertionPoint = $fallbackParagraph;
					return false;
				}
			});

			AffiliateService.insertAtPointAndTrack($insertionPoint, unit);
		},

		// Using mustache to render template and unit info
		getTemplate: function(unit) {
			var updatedLink = unit.link;

			if (unit.campaign === 'ddb') {
				var beaconId = $.cookies.get('wikia_beacon_id');
				var sessionId = $.cookies.get('wikia_session_id');
				var userId = w.wgUserId || 'null';
				var utmTerm = userId === 'null' ? sessionId + '_' + userId  : sessionId;
				var queryParams = {
					'utm_medium': 'affiliate_link',
					'utm_source': 'fandom',
					'utm_campaign': unit.category,
					'utm_term': utmTerm,
					'utm_content': w.wgCityId + '_' + w.wgArticleId + '_' + userId + '_mediawiki_content',
					'fandom_session_id': sessionId,
					'fandom_user_id': userId,
					'fandom_campaign_id': unit.category,
					'fandom_community_id': w.wgCityId,
					'fandom_page_id': w.wgArticleId,
					'fandom_beacon_id': beaconId,
					'fandom_slot_id': 'mediawiki_content',
				};

				updatedLink = unit.link + '?' + $.param(queryParams);
			}



			return templates.unit({
				image: unit.image,
				heading: unit.heading,
				buttonText: unit.subheading,
				link: updatedLink,
				logoLight: unit.logo.light,
				logoDark: unit.logo.dark,
			});
		},

		init: function () {
			AffiliateService.$infoBox = $('.portable-infobox').first();

			if (!AffiliateService.canDisplayUnit()) {
				// fire negative impression
				return;
			}

			console.log('hi');

			AffiliateService.addUnitToPage();
		},
	};

	$(AffiliateService.init);
});
