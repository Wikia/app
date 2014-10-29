/* global define */
define('wikia.venusToc', ['wikia.toc', 'wikia.document'], function (toc, doc) {
	'use strict';

	/**
	 * Fetch data for TOC by calling wikia.toc.getData()
	 */
	function getTocStructure() {
		var data, headers;
		headers = getHeaders();
		data = toc.getData(headers, createSection, filterHeader);
	}

	/**
	 * Method which is passed to wikia.toc.getData.
	 * It defines which properties TOC entry should have
	 * @param {HTMLElement} header - header node
	 * @returns {Object}
	 */
	function createSection(header) {
		return {
			id: header.id,
			name: header.textContent.trim(),
			sections: []
		};
	}

	/**
	 * Method which is passed to wikia.toc.getData.
	 * Check if passed header should be added to TOC
	 * @param {HTMLElement} header - header node
	 * @returns {boolean}
	 */
	function filterHeader(header) {
		var rawHeader;
		rawHeader = header.getElementsByClassName('mw-headline');

		return rawHeader.length === 0 ? false : rawHeader[0];
	}

	function getHeaders() {
		return doc.getElementById('mw-content-text').querySelectorAll(':scope > h2, :scope > h3');
	}

	return {
		getTocStructure: getTocStructure
	};
});
