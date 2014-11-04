/* global define */
define(
	'wikia.venusToc',
	['wikia.document', 'wikia.toc', 'wikia.dropdownNavigation'],
	function (doc, tocModule, DropdownNavigation) {
		'use strict';

		var articleWrapperId = 'mw-content-text',
			articleHeaderClass = 'mw-headline',
			headers = [
				'h2',
				'h3'
			];

		/**
		 * @desc creates single toc data object
		 * @param {HTMLElement} header - header node
		 * @returns {Object}
		 */
		function createSection(header) {
			return {
				id: '#' + header.id,
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
		 */
		function getTocData(headers, containerId) {
			var headersSelector = headers.join(','),
				headersCollection = doc
					.getElementById(containerId)
					.querySelectorAll(headersSelector);

			return tocModule.getData(headersCollection, createSection, filterHeader);
		}

		/**
		 * @desc initialize TOC
		 * @param {String} id -  id of the trigger element
		 */
		function init(id) {
			return new DropdownNavigation({
				data: getTocData(headers, articleWrapperId).sections,
				trigger: id
			});
		}

		return {
			init: init
		};
	}
);
