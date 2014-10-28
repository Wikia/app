/* global define */
define('wikia.venusToc', ['wikia.toc', 'wikia.dom'], function (toc, dom) {
	'use strict';
	var container;

	/**
	 * Fetch data for TOC by calling wikia.toc.getData()
	 */
	function getTocStructure() {
		var data, headers;
		container = container || document.getElementById('mw-content-text');
		headers = dom.childrenByTagName(['h2', 'h3'], container);
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
			name: header.innerText.trim(),
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

	return {
		getTocStructure: getTocStructure
	};
});
