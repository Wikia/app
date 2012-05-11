/**
 * A pure JS polyfill for the lack of outerHTML support in Gecko (read-only for now)
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

if(typeof document.body.outerHTML == 'undefined' && document.body.__defineGetter__ && HTMLElement){
	HTMLElement.prototype.__defineGetter__("outerHTML",
		function(){
			var el = document.createElement('div'),
			shtml;

			el.appendChild(this.cloneNode(true));
			shtml = el.innerHTML;
			el = null;

			return shtml;
		}
	);
}