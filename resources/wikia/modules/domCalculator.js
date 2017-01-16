/*global define*/
define('wikia.domCalculator', [
], function () {
	'use strict';

	function getTopOffset(element) {
		var topPos = 0,
			elementWindow = element.ownerDocument.defaultView || element.ownerDocument.parentWindow;

		do {
			topPos += element.offsetTop;
			element = element.offsetParent;
		} while (element !== null);

		if (elementWindow.frameElement) {
			topPos += getTopOffset(elementWindow.frameElement);
		}

		return topPos;
	}

	return {
		getTopOffset: getTopOffset
	};
});
