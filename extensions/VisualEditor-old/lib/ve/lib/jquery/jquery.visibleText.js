/**
 * jQuery visibleText plugin 0.1.0
 * https://github.com/Krinkle/jquery-visibleText
 *
 * @author Timo Tijhof, 2012
 * @source This plugin is based on Sizzle.getText.
 *  Copyright 2012 jQuery Foundation and other contributors http://jquery.com/
 * @license MIT License <http://www.opensource.org/licenses/mit-license.php>
 */
(function ($) {

	/**
	 * @param {Array|jQuery|HTMLElement} elem
	 */
	var getVisibleText = $.getVisibleText = function (elem) {
		var node,
			i = 0,
			ret = '',
			nodeType = elem.nodeType;

		if (nodeType) {
			if (nodeType === 1 || nodeType === 9 || nodeType === 11) {
				// Traverse the children
				for (elem = elem.firstChild; elem; elem = elem.nextSibling) {
					ret += $.expr.filters.hidden(elem) ?
						'' :
						getVisibleText(elem);
				}
			} else if (nodeType === 3 || nodeType === 4) {
				return elem.nodeValue;
			}
		} else {

			// If no nodeType, this is expected to be an array (or jQuery object)
			for (; (node = elem[i]); i++) {
				ret += getVisibleText(node);
			}
		}
		return ret;
	};

	$.fn.visibleText = function () {
		return getVisibleText(this);
	};

}(jQuery));
