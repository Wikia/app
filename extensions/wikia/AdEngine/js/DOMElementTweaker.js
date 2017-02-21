/*global define*/
define('ext.wikia.adEngine.domElementTweaker', [
	'wikia.log',
	'wikia.window'
], function (log, win) {
	'use strict';

	var hiddenElementClass = 'hidden',
		logGroup = 'ext.wikia.adEngine.domElementTweaker';

	function hide(element, useInline) {
		if (element && useInline) {
			element.style.display = 'none';
		} else if (element) {
			element.classList.add(hiddenElementClass);
		}
	}

	function show(element, useInline) {
		if (element && useInline) {
			element.style.display = 'block';
		} else if (element) {
			element.classList.remove(hiddenElementClass);
		}
	}

	function addClass(element, cls) {
		log(['addClass ' + cls, element], 8, logGroup);
		element.classList.add(cls);
	}

	function removeClass(element, cls) {
		log(['removeClass ' + cls, element], 8, logGroup);
		element.classList.remove(cls);
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

	function moveStylesToInline(sourceElement, targetElement, ignoredStyles) {
		var computedStyles, tmpStyles = {};

		if (!isElement(sourceElement)) {
			log(['Can\'t copy styles because parameter isn\'t element', sourceElement], 4, logGroup);
			return;
		}

		computedStyles = document.defaultView.getComputedStyle(sourceElement, '');

		ignoredStyles.forEach(function (styleName) {
			tmpStyles[styleName] = targetElement.style[styleName];
		});

		if (win.CSS2Properties !== undefined && computedStyles instanceof win.CSS2Properties) {
			rewriteStylesToElement(computedStyles, targetElement); // Hack for Firefox
		} else if (win.CSSStyleDeclaration !== undefined && computedStyles instanceof win.CSSStyleDeclaration) {
			targetElement.style.cssText = computedStyles.cssText;
		} else {
			log(['Can\'t copy styles from element', computedStyles.cssText], 4, logGroup);
			return;
		}

		Object.keys(tmpStyles).forEach(function (key) {
			targetElement.style[key] = tmpStyles[key];
		});
	}

	function forceRepaint(domElement) {
		return domElement.offsetWidth;
	}

	return {
		addClass: addClass,
		forceRepaint: forceRepaint,
		hide: hide,
		isElement: isElement,
		moveStylesToInline: moveStylesToInline,
		removeClass: removeClass,
		show: show
	};
});
