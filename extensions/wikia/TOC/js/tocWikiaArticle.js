require(['jquery', 'wikia.toc'], function($, toc) {

	var templateURL = 'extensions/wikia/TOC/templates/TOC_articleContent.mustache',
		hasTOC = false;

	/**
	 * Wraps subsections of TOC with <ol> element
	 *
	 * @returns {Function} - custom mustache wrapping function
	 */

	function wrapper() {
		return function (text, render) {
			if (text !== '') {
				return '<ol>' + render(text) + '</ol>';
			} else {
				return false;
			}
		}
	}

	/**
	 *
	 * @param {Object} header - Node element object for single article header
	 *
	 * @returns {Boolean|Object} - returns false for non Wikia Article related headers
	 *                             (example lazy loaded discussion thread)
	 *                             or custom TOC single section object.
	 */

	function createTOCSection(header) {
		header = $(header).children('.mw-headline');

		if (header.length === 0) {
			return false;
		}

		return {
			title: header.text(),
			id: header.attr('id'),
			sections: []
		};
	}

	/**
	 * Render TOC for article or preview
	 *
	 * @param {Object} $target - jQuery selector object for event target
	 *                           which gives a context to either article or preview in the editor.
	 */

	function renderTOC($target) {
		var $container = $target.parents('#toc').children('ol'),
			$headers = $target.parents('#mw-content-text').find('h2, h3, h4, h5'),
			data = toc.getData($headers, createTOCSection);

		data.wrapper = wrapper;

		toc.render(templateURL, data).done(function(data) {
			$container.append(data);
			hasTOC = true;
		});
	}

	/**
	 * Shows / hides TOC
	 *
	 * @param {Object} $target - jQuery selector object for event target
	 *                           which gives a context to either article or preview in the editor.
	 */

	function showHideTOC($target) {
		var tocWrapper = $target.parents('#toc'),
			targetLabel;

		tocWrapper.toggleClass('show');

		if (tocWrapper.hasClass('show')) {
			targetLabel = $target.data('hide');
		} else {
			targetLabel = $target.data('show');
		}

		$target.text(targetLabel);
		$target.attr('title', targetLabel);
	}

	/** Attach events */

	$('body').on('click', '#togglelink', function(event) {
		event.preventDefault();

		var $target = $(event.target);

		showHideTOC($target);

		if (!hasTOC) {
			renderTOC($target);
		}
	});
});