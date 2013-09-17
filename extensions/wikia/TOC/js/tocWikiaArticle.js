require(['jquery', 'wikia.toc', 'wikia.mustache'], function($, toc, mustache) {
	'use strict';

	var hasTOC = false, // flag - TOC is already created
		cacheKey = 'TOCAssets'; // Local Storage key

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
	 * load mustache template or get it from Local Storage
	 *
	 * @return {Object} - promise with mustache template
	 */

	function loadTemplate() {
		var dfd = new $.Deferred();

		require(['wikia.loader', 'wikia.cache'], function(loader, cache) {
			var template = cache.getVersioned(cacheKey);

			if(template) {
				dfd.resolve(template);
			} else {
				require(['wikia.throbber'], function(throbber) {
					var toc = $('#toc');

					throbber.show(toc);

					loader({
						type: loader.MULTI,
						resources: {
							mustache: 'extensions/wikia/TOC/templates/TOC_articleContent.mustache'
						}
					}).done(function(data) {
						template = data.mustache[0];

						dfd.resolve(template);

						cache.setVersioned(cacheKey, template, 604800); //7days

						throbber.remove(toc);
					});
				});
			}
		});

		return dfd.promise();
	}

	/**
	 * Render TOC for article or preview
	 *
	 * @param {Object} $target - jQuery selector object for event target
	 *                           which gives a context to either article or preview in the editor.
	 */

	function renderTOC($target) {
		var $container = $target.parents('#toc').children('ol'),
			$headers = $('#mw-content-text').find('h2, h3, h4, h5'),
			data = toc.getData($headers, createTOCSection);

		data.wrapper = wrapper;

		loadTemplate().done(function(template) {
			$container.append(mustache.render(template, data));

			hasTOC = true;
		});
	}

	/**
	 * Set Cookie for hidden TOC
	 *
	 * @param {?Number} isHidden - accepts 'null' or 1
	 */

	function setTOCCookie(isHidden) {
		$.cookie('mw_hidetoc', isHidden, {
			expires: 30,
			path: '/'
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
			targetLabel,
			tocCookie;

		tocWrapper.toggleClass('show');

		if (tocWrapper.hasClass('show')) {
			targetLabel = $target.data('hide');
			tocCookie = null;
		} else {
			targetLabel = $target.data('show');
			tocCookie = 1;
		}

		$target.text(targetLabel);
		$target.attr('title', targetLabel);

		setTOCCookie(tocCookie);
	}

	/** Attach events */

	$('body').on('click', '#togglelink', function(event) {
		event.preventDefault();

		var $target = $(event.target);

		if (!hasTOC) {
			renderTOC($target);
		}

		showHideTOC($target);
	});

	/** Auto expand TOC in article for logged-in users with hideTOC cookie set to 'null'  */
	if (window.wgUserName !== null && $.cookie('mw_hidetoc') === null) {
		var $showLink = $('#togglelink');

		if (!hasTOC) {
			renderTOC($showLink);
		}

		showHideTOC($showLink);
	}
});
