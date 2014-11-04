'use strict';

define(
	'wikia.dropdownNavigation',
	['jquery', 'wikia.window', 'wikia.document', 'wikia.mustache', 'wikia.dropdownNavigation.templates'],
	function ($, win, doc, mustache, dropdownTemplates) {
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
				dropdownId = 'wikiaDropdownNav' + Math.floor(Math.random() * 99) + 1,
				dropdownParams = {
					activeClass: 'active',
					id: dropdownId,
					maxHeight: 400,
					posX: 'top',
					posY: 'right',
					scrollX: true
				},
				delayHoverParams = {
					onActivate: show,
					onDeactivate: hide,
					activateOnClick: false
				},
				AIMParams = {
					activate: show,
					deactivate: hide
				},

				// cached DOM elements
				trigger,
				dropDown;

			/**
			 * @desc adds dropdown to DOM and caches selectors
			 */
			function renderDropdown(params) {
				trigger.appendChild(mustache.render(dropdownTemplates.dropdown_navigation, params));
			}

			/**
			 * @desc shows dropdown
			 */
			function show() {
				$(dropDown).addClass(dropdownParams.activeClass);
			}

			/**
			 * @desc hides dropdown
			 */
			function hide() {
				$(dropDown).removeClass(dropdownParams.activeClass);
			}

			/**
			 * @desc initialize delay hover and AIM menu
			 * @param {Object} options - configuration options
			 */
			function init(options) {
				$.extend(dropdownParams, options);

				trigger = doc.getElementById(options.trigger);
				renderDropdown(dropdownParams);
				dropDown = doc.getElementById(dropdownParams.id);

				// initialize UX enhancements
				self.delayedHover = win.delayedHover(trigger, delayHoverParams);
				self.menuAim = win.menuAim(dropDown, AIMParams);
			}

			// initialize dropdown component
			init(options);
		}

		return DropdownNavigation;
	}
);
