/*global define, require*/
define('ext.wikia.adEngine.tracking.pageLayout',  [
	'wikia.document',
	'wikia.domCalculator'
], function (doc, domCalculator) {
	'use strict';

	var topPositionSelectors = {
		'INCONTENT_PLAYER': '#INCONTENT_WRAPPER',
		'MOBILE_IN_CONTENT': '.mobile-in-content'
	};

	function getTopPosition(selector) {
		var element = doc.querySelector(selector);

		if (element) {
			return domCalculator.getTopOffset(element);
		}
	}

	function getSerializedData(slotName) {
		var data = [];

		if (topPositionSelectors[slotName]) {
			data.push('pos_top=' + getTopPosition(topPositionSelectors[slotName]));
		}

		return data.join(';');
	}

	return {
		getSerializedData: getSerializedData
	};
});
