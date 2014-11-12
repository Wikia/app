/*global define, clearTimeout, setTimeout*/
define('ext.wikia.adEngine.adPlacementChecker', ['jquery', 'wikia.document', 'wikia.log', 'wikia.window'], function ($, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adPlacementChecker';

	/**
	 * Return computed state of css property for element
	 *
	 * @param {element} el
	 * @param {string} cssProperty
	 * @returns {*}
	 */
	function getComputedStylePropertyValue(el, cssProperty) {
		if (!win.getComputedStyle) {
			if (doc.defaultView && doc.defaultView.getComputedStyle) {
				return doc.defaultView.getComputedStyle.getPropertyValue(cssProperty);
			}
		} else {
			return win.getComputedStyle(el).getPropertyValue(cssProperty);
		}
	}

	/**
	 * Checks whether ad will not ruin content if would be inserted after some element
	 *
	 * @param {String} fakeAdHtml   HTML to simulate the ad
	 * @param {Element} container   Container to check for height difference
	 * @param {Element=} header     Try insert ad after header element (or before first child otherwise)
	 * @param {Element=} nextHeader Following header after the ad
	 * @param {String=} adClass     Class for the ad
	 * @returns {boolean}           Whether the ad fits
	 */
	function doesAdFit(fakeAdHtml, container, header, nextHeader) {
		var $content = $(container),
			$header = $(header),
			$nextHeader = $(nextHeader),
			contentWidth = $content.width(),
			contentHeight = $content.height(),
			heightDiff,
			maxHeightDiff,
			$fakeAd = $(fakeAdHtml.toString()),
			$extraDiv = $('<div></div>');

		function cleanup() {
			$fakeAd.remove();
			$extraDiv.remove();
		}

		log(['doesAdFit', fakeAdHtml, container, header, nextHeader], 'info', logGroup);

		if ($header.width() < contentWidth) {
			log(['Header skipped. Too narrow', header], 'info', logGroup);
			cleanup();
			return false;
		}

		$header.after($fakeAd);

		if (!nextHeader) {
			log(['No next header. Adding a fake <div> at the end of the content', header], 'debug', logGroup);
			$nextHeader = $('<div></div>');
			$content.append($nextHeader);
		}

		if ($nextHeader.width() < contentWidth) {
			log(['Header skipped. Does not fit before the next header', header], 'info', logGroup);
			cleanup();
			return false;
		}

		heightDiff = $content.height() - contentHeight;
		maxHeightDiff = (1.2 * $fakeAd.outerWidth(true) * $fakeAd.outerHeight(true) / contentWidth).toFixed(1);
		log(['Height difference', heightDiff, 'max allowed', maxHeightDiff], 'info', logGroup);

		if (heightDiff > maxHeightDiff) {
			log(['Height difference too big', header, heightDiff, '>', maxHeightDiff], 'info', logGroup);
			cleanup();
			return false;
		}

		cleanup();
		return true;
	}

	function oldDoesAdFit(size, myContentDiv, header, nextHeader) {
		var indexOf = [].indexOf,
			fragment,
			result,
			contentCloneDiv,
			adPlace,
			headerIndex,
			nextHeaderIndex,
			nextHeaderWidth;

		result = false;
		fragment = doc.createDocumentFragment();

		if (!header) {
			header = myContentDiv.querySelector(':first-child');

			if ('right' === getComputedStylePropertyValue(header, 'float')) {
				header.style.clear = 'right';
			}
			if ('TABLE' === header.tagName && header.offsetWidth > 438) {
				result = false;
				return result;
			}
		}

		headerIndex = indexOf.call(myContentDiv.childNodes, header);

		contentCloneDiv = doc.createElement('DIV');

		if (myContentDiv.id) {
			contentCloneDiv.id = myContentDiv.id;
		}

		contentCloneDiv.className = myContentDiv.className;
		contentCloneDiv.innerHTML = myContentDiv.innerHTML;
		contentCloneDiv.style.position = 'absolute';
		contentCloneDiv.style.visibility = 'hidden';
		fragment.appendChild(contentCloneDiv);
		myContentDiv.parentNode.insertBefore(fragment, myContentDiv);

		adPlace = doc.createElement('DIV');

		adPlace.className += 'ad-in-content';
		adPlace.style.width = size[0] + 'px';
		adPlace.style.height = size[1]  + 'px';

		try {
			nextHeaderWidth = nextHeader && nextHeader.offsetWidth;
			contentCloneDiv.insertBefore(adPlace, contentCloneDiv.childNodes[headerIndex].nextSibling);
			nextHeaderIndex = (indexOf.call(myContentDiv.childNodes, nextHeader)) + 1;
		} catch (ignore) {}

		if ((myContentDiv.offsetHeight + size[1] * 0.75) > contentCloneDiv.offsetHeight) {
			result = true;
		}

		if (result && nextHeaderIndex > 0) {

			nextHeader = contentCloneDiv.childNodes[nextHeaderIndex];

			if (nextHeaderWidth < nextHeader.offsetWidth) {
				result = false;
			}

		}

		contentCloneDiv.parentNode.removeChild(contentCloneDiv);

		return result;
	}

	return {
		getComputedStylePropertyValue: getComputedStylePropertyValue,
		doesAdFit: doesAdFit
	};
});
