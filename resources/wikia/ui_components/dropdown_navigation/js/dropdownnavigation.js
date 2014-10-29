'use strict';

define(
	'wikia.dropdownNavigation',
	['j.query', 'mustache', 'wikia.dropdownNavigation.templates'],
	function ($, mustache, templates) {

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

			var params = {
					id: 'wikiaDropdownNav' + Math.random(),
					maxHeight: 400,
					posX: 'top',
					posY: 'right',
					scrollX: true
				},
				$trigger = $(options.trigger),
				$dropdown;

			$.extend(params, options);
			renderDropdown(params);
			attachHandlers();

			/**
			 * @desc adds dropdown to DOM and caches selectors
			 */
			function renderDropdown(params) {
				$trigger.after(mustache(templates.dropdown_navigation, params));
				$dropdown = $(params.id);
			}

			/**
			 * @desc shows dropdown
			 */
			function show() {
				$dropdown.addClass('active');
			}

			/**
			 * @desc hides dropdown
			 */
			function hide() {
				$dropdown.addClass('active');
			}

			/**
			 * @desc attaches event handlers
			 */
			function attachHandlers() {
				$('body')
					.on('click', params.trigger, show)
					.on('click', params.id + 'a', hide);
			}
		}

		return DropdownNavigation;
	}
);
