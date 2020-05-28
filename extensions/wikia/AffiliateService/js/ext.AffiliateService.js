function trackingPairsToObject(unit) {
	var tracking = {
		algo: '',
		method: '',
		version: '',
		recommendation_level: '',
	};

	if (unit.tracking && unit.tracking.forEach && typeof unit.tracking.forEach === 'function') {
		unit.tracking.forEach(function (kv) {
			tracking[kv.key] = kv.val;
		});
	}

	return tracking;
}

function linkToProxyLink(link, unit, wikiId, articleId, host) {
	var tracking = trackingPairsToObject(unit);

	var category = unit.category;

	// wikiId/articleId/category/algorithm/method/version
	var path = [wikiId, articleId, category, tracking.algo, tracking.method, tracking.version].join('/')

	var potentialLink = host + path + "?r=" +encodeURIComponent(link);

	// if we reach the limit lets serve them the link without the tracking
	if (potentialLink.length > 2000) {
		return link;
	}

	return potentialLink;

}

/**
 * Randomize array element order in-place.
 * Using Durstenfeld shuffle algorithm.
 *
 * @see https://stackoverflow.com/a/12646864
 * @see https://en.wikipedia.org/wiki/Fisher-Yates_shuffle#The_modern_algorithm
 */
function shuffleArray(array) {
	for (var i = array.length - 1; i > 0; i--) {
		var j = Math.floor(Math.random() * (i + 1));
		var temp = array[i];
		array[i] = array[j];
		array[j] = temp;
	}
}

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

	return arr.length - 1;
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

	// create page level and community level recommendations
	// NOTE items without `recommendationLevel` belong to both arrays
	var communityTargeting = [];
	var pageTargeting = [];

	targeting.forEach(function (t) {
		if (!t.recommendationLevel || t.recommendationLevel === 'page') {
			pageTargeting.push(t);
		}
		if (!t.recommendationLevel || t.recommendationLevel === 'community') {
			communityTargeting.push(t);
		}
	});

	return pageTargeting.length > 0 ? pageTargeting : communityTargeting;
}

var HULU_COMMUNITIES = [
	321995, // american horror story
	1644254, // brookyln 99
	881799, // rick and morty
	200383, // bobs burgers
	951918, // the handmaids tale
	8395, // runaways
	1637241, // futureman
];

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

		isHuluCommunity: function () {
			return HULU_COMMUNITIES.indexOf(parseInt(w.wgCityId, 10)) !== -1;
		},


		// ?debugAffiliateServiceTargeting=campaign,category
		getDebugTargeting: function () {
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
			if (AffiliateService.getDebugTargeting() !== false) {
				return true;
			}

			// is this the proper namespace and logged out
			if (w.wgAffiliateEnabled && !w.wgUserName) {
				return true;
			}

			// out of luck
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

			if (AffiliateService.isHuluCommunity()) {
				deferred.resolve([{
					campaign: 'disneyplus',
					category: 'hulu',
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

			// Commenting this out, not deleting at this time, because I want it to be
			// obvious that it is an active decision to no longer do this! Safe to fully remove after 7/31/2020 - AG
			// shuffleArray(availableUnits);

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
			// add extra fields
			var extraTracking = unit.tracking ? unit.tracking.slice() : [];
			extraTracking.push({
				// Y of the insertion point
				key: 'instertedAtY',
				val: $insertionPoint ? $insertionPoint.offset().top : -1,
			});

			var trackingOptions = {
				campaignId: unit.campaign,
				categoryId: unit.category,
				extraTracking: extraTracking,
			};

			// check if we found good insertion point
			if ($insertionPoint) {
				// get html to insert into target location
				var html = AffiliateService.getTemplate(unit);

				// insert markup
				var $element = $insertionPoint.prepend(html);

				// hook onmousedown tracking
				$element.find('.aff-unit__cta').on('mousedown', function (event) {
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

			$images.each(function (index, element) {
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
				if (yStart < notAllowedYStartValue || yStart > notAllowedYStopValue) {
					return true;
				}

				return false;
			}

			// if we cannot find a location after useFallbackAtY use the highest slot below a heading
			var $fallbackParagraph = null;
			var useFallbackAtY = 20000;

			// prepend the unit after the first paragraph below the
			var $insertionPoint = undefined;
			$paragraphs.each(function (index, element) {
				var $paragraph = $(element);
				var paragraphYStart = $paragraph.offset().top;
				var paragraphYEnd = $paragraph.height() + paragraphYStart;
				var paragraphYMiddle = paragraphYStart + $paragraph.height() / 2;

				// make sure we are past the infobox and not near an image
				if (paragraphYStart > startHeight && isValidSlot(paragraphYStart) && isValidSlot(paragraphYEnd) && isValidSlot(paragraphYMiddle)) {
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
				if ($fallbackParagraph && paragraphYStart > useFallbackAtY) {
					log('Affiliate Unit inserted using fallback slot');
					$insertionPoint = $fallbackParagraph;
					return false;
				}
			});

			AffiliateService.insertAtPointAndTrack($insertionPoint, unit);
		},

		// Using mustache to render template and unit info
		getTemplate: function (unit) {
			var updatedLink = unit.link;
			var watchShowEnabledDate = w.wgWatchShowEnabledDate || false;
			var isWatchShowEnabled = watchShowEnabledDate && (Date.parse(watchShowEnabledDate) < Date.now());

			if (unit.campaign === 'ddb') {
				var beaconId = $.cookies.get('wikia_beacon_id');
				var sessionId = $.cookies.get('wikia_session_id');
				var userId = w.wgUserId || 'null';
				var utmTerm = userId === 'null' ? sessionId + '_' + userId : sessionId;
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
				link: linkToProxyLink(updatedLink, unit, w.wgCityId, w.wgArticleId, w.wgServicesExternalDomain + 'affiliate/redirect/'),
				logoLight: unit.logo ? unit.logo.light : null,
				logoDark: unit.logo ? unit.logo.dark : null,
				showDisclaimer: !isWatchShowEnabled,
				disclaimerMessage: w.disclaimerMessage,
				campaign: unit.campaign,
				category: unit.category
			});
		},

		init: function () {
			if ($('.portable-infobox').length > 0) {
				AffiliateService.$infoBox = $('.portable-infobox').first();
			} else if ($('.infobox').length > 0) {
				AffiliateService.$infoBox = $('.infobox').first();
			}

			if (!AffiliateService.canDisplayUnit()) {
				return;
			}

			AffiliateService.addUnitToPage();
		},
	};

	$(AffiliateService.init);
});
