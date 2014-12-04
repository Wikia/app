define('venus.infobox', ['wikia.document', 'wikia.window'], function(d, w) {
	'use strict';

	var maxInfoboxHeight = 700,
		infoboxCollapsedClass = 'collapsed-infobox';

	/**
	 * Returns alpha value from CSS rgba color value
	 * if no match found returns null
	 * example
	 * for rgba(255,255,255,0.2) returns 0.2
	 * @param {string} color
	 * @return number | null
	 */
	function getColorAlpha(color) {
		var alphaGroups,
			alphaRegEx = /rgba\((\d*[,\s]*){3},\s*(0[\.\d]*)\)/,
			alphaValue = null;

		alphaGroups = alphaRegEx.exec(color);

		if(alphaGroups !== null) {
			alphaValue = parseFloat(alphaGroups[2]);
		}

		return alphaValue;
	}

	/**
	 * Checks if given color is valid and not transparent
	 *
	 * @param {string} color CSS color
	 * @return {boolean}
	 */
	function isValidColor(color) {
		var alphaValue;

		// quick check for transparency
		if (!color.length || color === 'rgba(0, 0, 0, 0)' || color === 'transparent') {
			return false;
		}

		// check alpha channel (ported from CON-2230)
		alphaValue = getColorAlpha(color);

		if (alphaValue !== null && alphaValue < 0.5) {
			return false;
		}

		return true;
	}

	/**
	 * Check should infobox be collapsed
	 *
	 * @param container infobox wrapper
	 * @returns {boolean}
	 */
	function isInfoboxCollapsible(container) {
		return container.offsetHeight > maxInfoboxHeight;
	}

	/**
	 * Collapse infobox to maxInfoboxHeight
	 *
	 * @param container infobox wrapper
	 */
	function collapseInfobox(container) {
		container.classList.add(infoboxCollapsedClass);
	}

	/**
	 * Expand infobox
	 *
	 * @param container infobox wrapper
	 * @param seeMoreButton button to expand infobox
	 */
	function expandInfobox(container, seeMoreButton) {
		container.classList.remove(infoboxCollapsedClass);
		seeMoreButton.classList.add('hide');
	}

	/**
	 * Create and add see more button to infobox
	 *
	 * @param infobox DOM node with infobox
	 * @param id identifier for 'see more' button
	 */
	function createSeeMoreButton(infobox, id) {
		var seeMoreButton,
			infoboxStyles,
			bgColor,
			borderColor;

		if (infobox) {
			seeMoreButton = d.createElement('a');
			seeMoreButton.id = id;
			seeMoreButton.classList.add('see-more');

			// translations needed
			seeMoreButton.innerHTML = w.mw.msg('venus-article-infobox-see-more');

			infoboxStyles = w.getComputedStyle(infobox);

			bgColor = infoboxStyles.getPropertyValue('background-color');
			borderColor = infoboxStyles.getPropertyValue('border-color');

			// try fallbacks
			if (!isValidColor(borderColor)) {
				borderColor = infoboxStyles.getPropertyValue('border-bottom-color');
			}

			if (!isValidColor(bgColor)) {
				bgColor = borderColor;
			}

			// apply colors
			if (isValidColor(bgColor)) {
				seeMoreButton.style.backgroundColor = bgColor;
			}

			if (isValidColor(borderColor)) {
				seeMoreButton.style.border = '1px solid ' + borderColor;
			}
		}

		return seeMoreButton;
	}

	return {
		isInfoboxCollapsible: isInfoboxCollapsible,
		collapseInfobox: collapseInfobox,
		expandInfobox: expandInfobox,
		createSeeMoreButton: createSeeMoreButton,
		getColorAlpha: getColorAlpha
	};
});
