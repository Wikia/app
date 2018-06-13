if (window && window.Element) {
	if (!Element.prototype.matches) {
		Element.prototype.matches = Element.prototype.msMatchesSelector;
	}


	if (!Element.prototype.closest) {
		Element.prototype.closest = function (selector) {
			var element = this;

			if (!document.documentElement.contains(element)) {
				return null;
			}
			do {
				if (element.matches(selector)) {
					return element;
				}
				element = element.parentElement || element.parentNode;
			} while (element !== null && element.nodeType === 1);

			return null;
		};
	}
}
