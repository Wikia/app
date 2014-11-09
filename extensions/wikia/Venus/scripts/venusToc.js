/* global define */
define(
	'wikia.venusToc',
	['jquery', 'wikia.window', 'wikia.toc', 'wikia.dropdownNavigation'],
	function ($, win, tocModule, DropdownNavigation) {
		'use strict';

		var articleWrapperId = 'mw-content-text',
			articleHeaderClass = 'mw-headline',
			headers = [
				'h2',
				'h3'
			],
			delayHoverParams = {
				onActivate: show,
				onDeactivate: hide,
				activateOnClick: false
			},
			tocDropdown,
			// cached jQuery Selectors
			$triggerButton,
			$parent;

		/**
		 * @desc creates single toc data object
		 * @param {HTMLElement} header - header node
		 * @returns {Object}
		 */
		function createSection(header) {
			return {
				href: '#' + header.id,
				title: header.textContent.trim(),
				sections: []
			};
		}

		/**
		 * @desc checks if header is valid article headers that should be shown in TOC
		 * @param {HTMLElement} header - header node
		 * @returns {Boolean}
		 */
		function filterHeader(header) {
			var rawHeader = header.getElementsByClassName(articleHeaderClass);

			return rawHeader.length === 0 ? false : rawHeader[0];
		}

		/**
		 * @desc gets data model for TOC
		 * @param {Array} headers - array of headers levels (example ['h2, 'h3'])
		 * @param {string} containerId - id of headers container
		 * @returns {Array}
		 */
		function getTocData(headers, containerId) {
			var headersSelector = headers.join(','),
				headersCollection = win.document
					.getElementById(containerId)
					.querySelectorAll(headersSelector);

			return tocModule.getData(headersCollection, createSection, filterHeader).sections;
		}

		/**
		 * @desc shows dropdown
		 */
		function show() {
			$parent.addClass('active');
		}

		/**
		 * @desc hides dropdown
		 */
		function hide() {
			tocDropdown.resetUI();
			$parent.removeClass('active');
		}

		/**
		 * @desc initialize TOC
		 * @param {String} id -  id of the trigger element
		 */
		function init(id) {
			var options = {
				sections: getTocData(headers, articleWrapperId),
				trigger: id
			};

			tocDropdown = new DropdownNavigation(options);
			$triggerButton = $('#' + id);
			$parent = $triggerButton.parent();

			win.delayedHover($parent[0], delayHoverParams);
		}

		return {
			init: init
		};
	}
);
