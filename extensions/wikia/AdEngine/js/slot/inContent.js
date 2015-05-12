/*global define*/
define('ext.wikia.adEngine.slot.inContent', [
	'jquery',
	'wikia.log'
], function ($, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.inContent',
		$container = $('#mw-content-text'),
		headersSelector = '> h2, > h3, > section > h2'; // relative to $container

	/**
	 * Representation of a section which is a chunk of HTML between two headers within an article content
	 *
	 * @typedef {Object} Section
	 * @property {boolean} intro            whether this is an intro section (the one BEFORE the first heading)
	 * @porperty {String} name              name of the section
	 * @porperty {String} nextName          name of the next section
	 * @property {jQuery} [$start]          header preceding the section (empty when section.intro = true)
	 * @property {jQuery} $end              header following the section
	 * @property {jQuery} $firstElement     first element in the section
	 * @property {String} firstElementFloat value of CSS property "float" of the first element in the section
	 * @property {number} height            height of the section before putting any ads to it
	 * @property {jQuery} [$ad]             ad Placeholder added to the section
	 * @property {boolean} [keepAd]         whether the ad fits in the section
	 */

	/**
	 * Helper function to pretty log info messages
	 *
	 * @param {Section} section
	 * @param {String}  result
	 */
	function logInfo(section, result) {
		var padding = ' '.repeat(60),
			name1 = section.name.substring(0, 30),
			name2 = section.nextName.substring(0, 30),
			msgPrefix = 'Between ' + name1 + ' and ' + name2 + padding,
			msg = msgPrefix.substring(0, 60).replace(/( *)$/, ':$1 ') + result;

		log(msg, 'info', logGroup);
	}

	/**
	 * Tell whether the jQuery element can re-flow its contents (if not, then when put in one
	 * line with an ad, the two can overlap)
	 *
	 * @param {jQuery} $el
	 * @returns {boolean}
	 */
	function canReFlow($el) {
		var ret = $el.css('display') === 'block' &&
			$el.css('float') === 'none' &&
			$el.css('overflow') === 'visible';

		log(['canReflow', $el, ret], 'debug', logGroup);

		return ret;
	}

	/**
	 * Calculate the section height before or after injecting an ad to it
	 *
	 * @param {Section} section
	 * @returns {number}
	 */
	function getSectionHeight(section) {
		var $firstElement = section.$ad || section.$firstElement,
			offsetTop = $firstElement.offset().top,
			offsetBottom;

		if (section.$end.length) {
			offsetBottom = section.$end.offset().top;
		} else {
			offsetBottom = $container.offset().top + $container.outerHeight(true);
		}

		return offsetBottom - offsetTop;
	}

	/**
	 * Build the sections array
	 *
	 * DOM/layout querying: OK
	 * DOM modification:    forbidden
	 *
	 * @param {jQuery} $headers headers dividing the article to sections
	 * @returns {Section[]}
	 */
	function buildSections($headers) {
		var i,
			len,
			sections = [],
			intro,
			$start,
			$end,
			$firstElement,
			section;

		for (i = 0, len = $headers.length; i < len + 1; i += 1) {
			intro = (i === 0);
			$start = !intro && $headers.eq(i - 1);
			$end = $headers.eq(i);
			$firstElement = intro ? $container.children().first() : $start.next();
			section = {
				intro: intro,
				name: intro ? 'TOP' : $start.children().first().text(),
				nextName: $end.length ? $end.children().first().text() : 'BOTTOM',
				$start: intro ? undefined : $start,
				$end: $end,
				$firstElement: $firstElement,
				firstElementFloat: $firstElement.css('float')
			};

			section.height = getSectionHeight(section);

			log(['buildSectionObject', section], 'debug', logGroup);
			sections.push(section);
		}

		return sections;
	}

	/**
	 * Inject ad placeholder into section and adjust surrounding elements CSS
	 *
	 * DOM/layout querying: forbidden
	 * DOM modification:    OK
	 *
	 * @param {Section} section section to inject the ad to
	 * @param {jQuery} $ad      ad placeholder to inject
	 * @returns {Section[]}
	 */
	function injectAdPlaceholderIntoSection(section, $ad) {
		section.$firstElement.before($ad);

		// If the first element is right-floating, move it below the ad
		if (section.firstElementFloat === 'right') {
			section.$firstElement.addClass('clear-right-after-ad-in-content');
		}

		// Make sure the section floating elements are kept within the section boundaries
		// even when browser window is resized or some content is removed from the section
		section.$end.addClass('clear-both-after-ad-in-content');
	}

	/**
	 * Add placeholders for ads and store them in section.$ad and apply any CSS code necessary
	 * for proper calculations.
	 *
	 * DOM/layout querying: forbidden
	 * DOM modification:    OK
	 *
	 * @param {Section[]} sections
	 * @param {jQuery}    Placeholder to add
	 */
	function addPlaceholders(sections, $adPlaceholder) {
		var i, len, section;

		for (i = 0, len = sections.length; i < len; i += 1) {
			section = sections[i];

			// Inject the ad Placeholder now
			section.$ad = $adPlaceholder.clone();
			injectAdPlaceholderIntoSection(section, section.$ad);
		}
	}

	/**
	 * Check whether the ad added in section.$ad breaks the content or not
	 * If the ad can stay, mark this by setting section.keepAd flag
	 *
	 * DOM/layout querying: OK
	 * DOM modification:    forbidden
	 *
	 * @param {boolean} sections
	 */
	function checkIfCapable(section) {
		var $ad = section.$ad,
			adHeight = $ad.outerHeight(true),
			adWidth = $ad.outerWidth(true),

			originalContainerWidth = $container.width(),
			newContentWidth = originalContainerWidth - adWidth, // width left in the content well after adding the ad

			firstElementClear,
			maxHeightDiff,
			minSectionHeight,
			newSectionHeight,
			heightDiff,
			msg;

		if (!section.intro && section.$start.width() < originalContainerWidth) {
			logInfo(section, 'NO: current section header is too narrow');
			return false;
		}

		if (section.$end.length && section.$end.width() < originalContainerWidth) {
			logInfo(section, 'NO: next section header is too narrow');
			return false;
		}

		firstElementClear = section.$firstElement.css('clear');
		if (firstElementClear === 'both' || firstElementClear === 'right') {
			logInfo(section, 'NO: the first element in section has an incompatible clear CSS property');
			return false;
		}

		maxHeightDiff = 1.2 * $ad.outerWidth(true) * adHeight / originalContainerWidth;
		minSectionHeight = adHeight - maxHeightDiff;

		if (section.height < minSectionHeight) {
			msg = 'NO: section too short: ' + section.height.toFixed(1) + '<' + minSectionHeight.toFixed(1);
			logInfo(section, msg);
			return false;
		}

		newSectionHeight = getSectionHeight(section);
		heightDiff = newSectionHeight - section.height;

		if (heightDiff > maxHeightDiff) {
			msg = 'NO: height difference is too big: ' + heightDiff.toFixed(1) + '>' + maxHeightDiff.toFixed(1);
			logInfo(section, msg);
			return false;
		}

		if (!canReFlow(section.$firstElement) && section.$firstElement.width() > newContentWidth) {
			msg = 'NO: the first element in section is too wide and does not adapt: ' +
				section.$firstElement.width() + '>' + newContentWidth;
			logInfo(section, msg);
			return false;
		}

		msg = 'YES: ad fits and height difference is acceptable: ' +
			heightDiff.toFixed(1) + '<' + maxHeightDiff.toFixed(1);

		logInfo(section, msg);

		return true;
	}

	/**
	 * Check in which sections the ad added in section.$ad broke the content
	 * Mark the ad-safe sections by setting section.keepAd flag
	 *
	 * DOM/layout querying: OK
	 * DOM modification:    forbidden
	 *
	 * @param {boolean} sections
	 */
	function markCapableSections(sections) {
		var i, len, section;
		for (i = 0, len = sections.length; i < len; i += 1) {
			section = sections[i];

			if (checkIfCapable(section)) {
				section.keepAd = true;
			}
		}
	}

	/**
	 * Clean up all the extra CSS classes added in case the ad was not safe to leave.
	 *
	 * DOM/layout querying: forbidden
	 * DOM modification:    OK
	 *
	 * @param {Section[]} sections
	 */
	function cleanUp(sections) {
		var i, len, section;

		for (i = 0, len = sections.length; i < len; i += 1) {
			section = sections[i];
			section.$ad.remove();
			section.$firstElement.removeClass('clear-right-after-ad-in-content');
			section.$end.removeClass('clear-both-after-ad-in-content');
			delete section.$ad;
		}
	}

	/**
	 * Get all sections that can hold in-content ads
	 *
	 * @param {jQuery} $adPlaceholder ad placeholder to test against
	 * @return {Section[]} sections that were verified safe to contain ads
	 */
	function getCapableSections($adPlaceholder) {
		log('getCapableSections', 'debug', logGroup);

		var sections, filteredSections;

		// Phase 1: Build the section objects and read the initial dimensions (DOM/layout query)
		sections = buildSections($container.find(headersSelector));

		// Phase 2: Add the Placeholders and CSS (DOM modification)
		addPlaceholders(sections, $adPlaceholder);

		// Phase 3: Check which sections were unaffected by putting the ad in them (DOM/layout query)
		markCapableSections(sections);

		// Phase 4: Clean up (DOM modification)
		cleanUp(sections);

		// Only return sections with keepAd = true
		filteredSections = sections.filter(function (section) {
			return section.keepAd;
		});

		log('Found ' + filteredSections.length + ' sections capable of holding in content ads', 'info', logGroup);

		return filteredSections;
	}

	return {
		getCapableSections: getCapableSections,
		injectAdPlaceholderIntoSection: injectAdPlaceholderIntoSection
	};
});
