(function () {

	// add Element.closest function in IE
	// @see https://developer.mozilla.org/en-US/docs/Web/API/Element/closest
	if (!Element.prototype.matches)
		Element.prototype.matches = Element.prototype.msMatchesSelector ||
			Element.prototype.webkitMatchesSelector;

	if (!Element.prototype.closest) {
		Element.prototype.closest = function (s) {
			var el = this;
			if (!document.documentElement.contains(el)) return null;
			do {
				if (el.matches(s)) return el;
				el = el.parentElement;
			} while (el !== null);
			return null;
		};
	}

	// add NodeList.foreach function in IE
	if (window.NodeList && !NodeList.prototype.forEach) {
		NodeList.prototype.forEach = function (callback, thisArg) {
			thisArg = thisArg || window;
			for (var i = 0; i < this.length; i++) {
				callback.call(thisArg, this[i], i, this);
			}
		};
	}

})();
