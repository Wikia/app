define('wikia.ui.toc', ['jquery', 'wikia.window'], function($, w) {
	"use strict";

	function TOC(toc) {

		if (!(this instanceof TOC)) {
			return new TOC;
		}

		var $w = $(w),
			$toc = $(toc),
			$sectionLinks = $toc.find('li > a'),
			bodyHeight = $('body').outerHeight(),
			sections = createSectionsArray($sectionLinks),
			ACTIVE_CLASS = 'active', // const for the css class use for highlighting current section
			OFFSET = 10; // const scroll tolerance for styping which section is in position

		/**
		 * Creates array of section objects with section ID and offset top position
		 *
		 * @param {Object} $sectionLinks - jQuery selector object with links to TOC sections
		 *
		 * @return {Array} - array of section objects
		 */

		function createSectionsArray($sectionLinks) {
			var sections = [],
				i,
				length = $sectionLinks.length;

			for (i = 0; i < length; i++) {
				var sectionObj = {};

				sectionObj.id = $($sectionLinks[i]).attr('href');
				sectionObj.pos = ( $(sectionObj.id).length ? $(sectionObj.id).offset().top : null );

				sections.push(sectionObj);
			}

			return sections;
		}

		/**
		 *  Check which section is in view
		 */

		function checkPosition() {
			var wScrollPos = $w.scrollTop(),
				wHeight = $w.height(),
				i,
				length = sections.length;

			if (wScrollPos >= bodyHeight - wHeight) {
				highlightActiveSection(getActiveSection(sections[length - 1].id));
				return;
			}

			for  (i= 0; i < length; i ++) {
				var currentSection = sections[i],
					nextSection = sections[i + 1];

				if(currentSection.pos !== null && wScrollPos >= currentSection.pos - OFFSET && ((nextSection && wScrollPos <= nextSection.pos - OFFSET) || (sections.indexOf(currentSection) === length - 1))) {
					highlightActiveSection(getActiveSection(currentSection.id));
					break;
				}
			}
		}

		/**
		 * Return selector for the active TOC section
		 *
		 * @param {String} sectionId - ID of current section in view
		 * @return {Object} - jQuery selector object
		 */

		function getActiveSection(sectionId) {
			var $activeEl = $sectionLinks.filter('[href="'+ sectionId +'"]');

			return $activeEl.parent();
		}

		/**
		 * Highlight active TOC section
		 *
		 * @param {Object} $section - jQuery selector for active TOC section
		 */

		function highlightActiveSection($section) {
			$section.addClass(ACTIVE_CLASS).siblings('li').removeClass(ACTIVE_CLASS);
		}



		/** TOC public methods */

		this.init = function() {
			var throttled = $.throttle(50, checkPosition);

			$w.on('scroll', throttled);

			$toc.on('click', 'li', function(event) {
				highlightActiveSection($(event.currentTarget));
			});
		}
	}

	/** Public API */

	return TOC

});
