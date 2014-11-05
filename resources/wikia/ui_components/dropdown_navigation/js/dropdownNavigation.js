'use strict';

define(
	'wikia.dropdownNavigation',
	['jquery', 'wikia.window', 'wikia.document', 'wikia.mustache', 'wikia.dropdownNavigation.templates'],
	function ($, win, doc, mustache, dropdownTemplates) {
		// used for setting unique id for each dropdown added to the page
		var dropdownIndex = 0;

		/**
		 * @desc validates dropdown naviagation options
		 * @param {Object} params
		 */
		function validateParams(params) {
			if (!Array.isArray(params.data) || params.data.length < 1) {
				throw new Error('"data" param must be non empty array');
			}
			if (typeof params.trigger !== 'string' || params.trigger.length < 1) {
				throw new Error('"trigger" param must be a valid jQuery selector');
			}
		}

		/**
		 * @desc creates new instance of Dropdown Navigation
		 * @param {Object} options - configuration options
		 * @returns {Object} - if called without `new` returns new instance of DropdownNavigation
		 * @constructor
		 */
		function DropdownNavigation(options) {
			validateParams(options);

			if (!(this instanceof DropdownNavigation)) {
				return new DropdownNavigation(options);
			}

			var self = this,
				dropdownId = 'wikiaDropdownNav' + dropdownIndex++,
				dropdownParams = {
					activeClass: 'active',
					id: dropdownId,
					maxHeight: 400,
					scrollX: true
				},
				delayHoverParams = {
					onActivate: show,
					onDeactivate: hide,
					activateOnClick: false
				},

				// cached DOM elements
				$trigger,
				$container,
				$dropdown;

			/**
			 * @desc adds dropdown to DOM and returns jQuery selector for it
			 * @returns {jQuery} - jQuery selector for dropdown element
			 */
			function render() {
				return $(mustache.render(dropdownTemplates.dropdown_navigation, dropdownParams)).appendTo($container);
			}

			/**
			 * @desc shows dropdown
			 */
			function show() {
				$dropdown.addClass(dropdownParams.activeClass);
			}

			/**
			 * @desc hides dropdown
			 */
			function hide() {
				$dropdown.removeClass(dropdownParams.activeClass);
			}

			/**
			 * @desc sets dropdown positions
			 */
			function setPosition() {
				$dropdown.css('left', $trigger.outerWidth());
			}

			/**
			 * @desc initialize delay hover and AIM menu
			 * @param {Object} options - configuration options
			 */
			function init(options) {
				$.extend(dropdownParams, options);

				$trigger = $('#' + options.trigger);
				$container = $trigger.closest('li');
				$dropdown = render();

				setPosition();

				// initialize UX enhancements
				self.delayedHover = win.delayedHover($container[0], delayHoverParams);
			}

			// initialize dropdown component
			init(options);
		}

		return DropdownNavigation;
	}
);
