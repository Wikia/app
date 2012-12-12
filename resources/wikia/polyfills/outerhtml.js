/**
 * A pure JS polyfill for the lack of outerHTML support in Gecko (read-only for now)
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

(function (context) {
	'use strict';

	var doc = context.document,
		body = doc.body,
		htmlElm = context.HTMLElement;

	if (htmlElm && !doc.body.outerHTML && body.__defineGetter__) {
		htmlElm.prototype.__defineGetter__("outerHTML", function () {
			var el = doc.createElement('div'),
				shtml;

			el.appendChild(this.cloneNode(true));
			shtml = el.innerHTML;
			el = null;

			return shtml;
		});
	}
}(this));