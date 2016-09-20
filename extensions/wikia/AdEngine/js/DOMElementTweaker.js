/*global define*/
define('ext.wikia.adEngine.domElementTweaker', [
	'wikia.log',
	'wikia.window'
], function (log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.domElementTweaker',
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
		return obj instanceof win.HTMLElement;
	}

	function rewriteStylesToElement(computedStyles, targetElement) {
		var i,
			styleName;
		for (i = 0; i < computedStyles.length; i++) {
			styleName = computedStyles[i];
			targetElement.style[styleName] = computedStyles[styleName];
		}
	}

	function moveStylesToInline(element) {
		var computedStyles;

		if (!isElement(element)) {
			return;
		}

		computedStyles = document.defaultView.getComputedStyle(element, '');

		if (win.CSS2Properties !== undefined && computedStyles instanceof win.CSS2Properties) {
			rewriteStylesToElement(computedStyles, element); // Hack for Firefox
		} else if (win.CSSStyleDeclaration !== undefined && computedStyles instanceof win.CSSStyleDeclaration) {
			element.style.cssText = computedStyles.cssText;
		} else {
			log(['Can\'t copy styles from element', computedStyles.cssText], 4, logGroup);
		}
	}

	function recursiveMoveStylesToInline(element) {
		var i;
		for (i = 0; i < element.childNodes.length; i++) {
			recursiveMoveStylesToInline(element.childNodes[i]);
		}
		moveStylesToInline(element);
	}

	return {
		isElement: isElement,
		moveStylesToInline: moveStylesToInline,
		recursiveMoveStylesToInline: recursiveMoveStylesToInline,
		removeClass: removeClass
	};
});
