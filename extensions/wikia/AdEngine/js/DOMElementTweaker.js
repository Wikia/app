/*global define*/
define('ext.wikia.adEngine.domElementTweaker', [
	'wikia.log',
	'wikia.document',
	'wikia.window'
], function (log, doc, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slotTweaker',
		rclass = /[\t\r\n]/g;

	function removeClass(element, cls) {
		var oldClasses,
			newClasses = ' ' + element.className.replace(rclass, ' ') + ' ';

		// Remove all instances of class in the className string
		while (oldClasses !== newClasses) {
			oldClasses = newClasses;
			newClasses = oldClasses.replace(' ' + cls + ' ', ' ');
		}

		log(['removeClass ' + cls, element], 8, logGroup);
		element.className = newClasses;
	}

	function isElement(obj) {
		return obj instanceof HTMLElement;
	}

	function moveStylesToInline(element) {
		var computedStyles,
			styleName;

		if (!isElement(element)) {
			return;
		}

		computedStyles = document.defaultView.getComputedStyle(element, '');

		if (typeof win.CSS2Properties !== 'undefined' && computedStyles instanceof win.CSS2Properties) {
			// Hack for Firefox
			for (var i = 0; i < computedStyles.length; i++) {
				styleName = computedStyles[i];
				element.style[styleName] = computedStyles[styleName];
			}
		} else if (typeof win.CSSStyleDeclaration !== 'undefined' && computedStyles instanceof win.CSSStyleDeclaration) {
			element.style.cssText = computedStyles.cssText;
		}
	}

	function recursiveMoveStylesToInline(element) {
		for (var i = 0; i < element.childNodes.length; i++) {
			recursiveMoveStylesToInline(element.childNodes[i]);
		}
		moveStylesToInline(element);
	}

	return {
		isElement: isElement,
		recursiveMoveStylesToInline: recursiveMoveStylesToInline,
		removeClass: removeClass,
		moveStylesToInline: moveStylesToInline
	};
});
