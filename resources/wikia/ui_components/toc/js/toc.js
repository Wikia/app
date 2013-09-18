define('wikia.ui.toc', ['jquery', 'wikia.window'], function($, w) {
	"use strict";

	function TOC(toc) {

		if (!(this instanceof TOC)) {
			return new TOC;
		}

		var $w = $(w),
			$toc = $(toc),
			$sectionLinks = $toc.find('li > a'),
			sections = [],
			ACTIVE_CLASS = 'active'; // const for the css class use for highlighting current section

		/**
		 * Creates array of section objects with section ID and offset top position
		 */

		function createSectionsArray() {
			var i,
				length = $sectionLinks.length;

			for (i = 0; i < length; i++) {
				var sectionObj = {};

				sectionObj.id = $($sectionLinks[i]).attr('href'),
				sectionObj.pos = ( $(sectionObj.id).length ? $(sectionObj.id).offset().top : null );

				sections.push(sectionObj);
			}
		}

		/**
		 *  Check which section is in view
		 */

		function checkPosition() {
			var wScrollPos = $w.scrollTop(),
				i,
				length = sections.length;

			for  (i= 0; i < length; i ++) {
				var currentSection = sections[i],
					nextSection = sections[i + 1];

				if(currentSection.pos !== null && wScrollPos >= currentSection.pos && ((nextSection && wScrollPos <= nextSection.pos) || (sections.indexOf(currentSection) === length - 1))) {
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

			createSectionsArray();

			$w.on('scroll', throttled);

			$toc.on('click', 'li', function(event) {
				highlightActiveSection($(event.target));
			});
		}
	}

	/** Public API */

	return TOC

});