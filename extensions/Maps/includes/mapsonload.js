/**
 * Some JS stolen from wikibits.js to allow Maps to work in MW 1.17 with the resource loader.
 * This approach might not be optimal, but prevents the need for a rewrite of the actual output for now.
 * 
 * @since 0.7
 * 
 * @file maponload.js
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */

// add any onload functions in this hook (please don't hard-code any events in the xhtml source)
var doneMapsOnloadHook;

if (!window.mapsOnloadFuncts) {
	var mapsOnloadFuncts = [];
}

function addMapsOnloadHook(hookFunct) {
	// Allows add-on scripts to add onload functions
	if(!doneMapsOnloadHook) {
		mapsOnloadFuncts[mapsOnloadFuncts.length] = hookFunct;
	} else {
		hookFunct();  // bug in MSIE script loading
	}
}

addMapOnloadHandler(window, "load",
	function () {
		// don't run anything below this for non-dom browsers
		if (doneMapsOnloadHook || !(document.getElementById && document.getElementsByTagName)) {
			return;
		}
	
		// set this before running any hooks, since any errors below
		// might cause the function to terminate prematurely
		doneMapsOnloadHook = true;
	
		// Run any added-on functions
		for (var i = 0; i < mapsOnloadFuncts.length; i++) {
			mapsOnloadFuncts[i]();
		}
	}
);

/**
 * Add an event handler to an element
 *
 * @param Element element Element to add handler to
 * @param String attach Event to attach to
 * @param callable handler Event handler callback
 */
function addMapOnloadHandler( element, attach, handler ) {
	if( window.addEventListener ) {
		element.addEventListener( attach, handler, false );
	} else if( window.attachEvent ) {
		element.attachEvent( 'on' + attach, handler );
	}
}
