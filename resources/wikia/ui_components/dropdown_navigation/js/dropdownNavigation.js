define(
	'wikia.dropdownNavigation',
	[
		'jquery',
		'wikia.window',
		'wikia.dropdownNavigation.utils',
		'wikia.mustache',
		'wikia.dropdownNavigation.templates'
	],
	function ($, win, utils, mustache, templates) {
		'use strict';

		// used for generating unique ID for each dropdown rendered on a page
		var dropdownIndex = 0;

		/**
		 * @desc creates new instance of Dropdown Navigation
		 * @param {Object} options - configuration options
		 * @returns {Object} - if called without `new` returns new instance of DropdownNavigation
		 * @constructor
		 */
		function DropdownNavigation(options) {

			if (!(this instanceof DropdownNavigation)) {
				return new DropdownNavigation(options);
			}

			utils.validateParams(options);

			var self = this,
				params = {
					activeClass: 'active',
					$container: null,
					id: 'wikiaDropdownNav' + dropdownIndex++,
					maxHeight: 400
				},
				menuAIMParams = {
					activate: showSecondLevelList,
					deactivate: hideSecondLevelList,
					tolerance: 85
				},

				// cached DOM elements
				$sectionsWrapper,
				$sections,
				$subsections;

			/**
			 * @desc sets dropdown UI to initial state
			 */
			this.resetUI = function () {
				this.menuAim.resetActiveRow();
				$sections
					.add($subsections)
					.removeClass(params.activeClass);

				$sectionsWrapper.scrollTop(0);
			};

			/**
			 * @desc shows subsection
			 * @param {Element} row - dropdown "<li>" HTML element
			 * @param {Event=} event - passed only if row was clicked
			 */
			function showSecondLevelList(row, event) {
				var $row = $(row),
					id = $row.data('id');

				// handle touch interactions
				if (event && id && !$row.hasClass(params.activeClass)) {
					event.preventDefault();
					event.stopPropagation();
				}

				$('#' + row.getAttribute('data-id'))
					.add(row)
					.addClass(params.activeClass);
			}

			/**
			 * @desc hides subsection
			 * @param {Element} row - dropdwon "<li>" HTML element
			 */
			function hideSecondLevelList(row) {
				$('#' + row.getAttribute('data-id'))
					.add(row)
					.removeClass(params.activeClass);
			}

			/**
			 * @desc creates dropdown and adds it to DOM
			 * @param {Object} params - dropdown template params
			 * @param {Object} templates - mustache templates
			 * @param {jQuery} $container - dropdown container
			 * @returns {jQuery} - dropdown element in jQuery collection
			 */
			function createDropdown(params, templates, $container) {
				utils.createSubsectionData(params);

				return $(mustache.render(templates.dropdown, params, templates)).appendTo($container);

			}

			/**
			 * @desc initialize delay hover and AIM menu
			 * @param {Object} options - configuration options
			 */
			function init(options) {
				var $dropdownTrigger, $parent, $dropdownWrapper;

				$.extend(params, options);

				$dropdownTrigger = $('#' + params.trigger);
				$parent = params.$container || $dropdownTrigger.closest('li');

				// bind to existing markup or create new dropdown markup and add in to DOM
				$dropdownWrapper = params.render === false ?
					$('#' + params.id) :
					createDropdown(params, templates, $parent);

				$sectionsWrapper = $dropdownWrapper.children('ul');
				$sections = $sectionsWrapper.children();
				$subsections = $dropdownWrapper.find('div > ul');

				utils.setPosition($dropdownWrapper, $dropdownTrigger);

				// initialize dropdown UX enhancements
				self.menuAim = win.menuAim($sectionsWrapper[0], menuAIMParams);
			}

			// initialize component
			init(options);
		}

		return DropdownNavigation;
	}
);
