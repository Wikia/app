/**
 * Introduce a delayed onDOMReady event to measure the impact of performance regressions
 *
  * @see FrontendDelay.class.php
 */
(function(w, log, weppy, $) {

	/**
	 * @see https://github.com/jfriend00/docReady
	 */
	var docReady = (function() {
		"use strict";
		var readyList = [];
		var readyFired = false;
		var readyEventHandlersInstalled = false;

		// call this when the document is ready
		// this function protects itself against being called more than once
		function ready() {
			if (!readyFired) {
				// this must be set to true before we start calling callbacks
				readyFired = true;
				for (var i = 0; i < readyList.length; i++) {
					// if a callback here happens to add new ready handlers,
					// the docReady() function will see that it already fired
					// and will schedule the callback to run right after
					// this event loop finishes so all handlers will still execute
					// in order and no new ones will be added to the readyList
					// while we are processing the list
					readyList[i].fn.call(window, readyList[i].ctx);
				}
				// allow any closures held by these functions to free
				readyList = [];
			}
		}

		function readyStateChange() {
			if ( document.readyState === "complete" ) {
				ready();
			}
		}

		// This is the one public interface
		// docReady(fn, context);
		// the context argument is optional - if present, it will be passed
		// as an argument to the callback
		return function(callback, context) {
			// if ready has already fired, then just schedule the callback
			// to fire asynchronously, but right away
			if (readyFired) {
				setTimeout(function() {callback(context);}, 1);
				return;
			} else {
				// add the function and context to the list
				readyList.push({fn: callback, ctx: context});
			}
			// if document already ready to go, schedule the ready function to run
			// IE only safe when readyState is "complete", others safe when readyState is "interactive"
			if (document.readyState === "complete" || (!document.attachEvent && document.readyState === "interactive")) {
				setTimeout(ready, 1);
			} else if (!readyEventHandlersInstalled) {
				// otherwise if we don't have event handlers installed, install them
				if (document.addEventListener) {
					// first choice is DOMContentLoaded event
					document.addEventListener("DOMContentLoaded", ready, false);
					// backup is window load event
					window.addEventListener("load", ready, false);
				} else {
					// must be IE
					document.attachEvent("onreadystatechange", readyStateChange);
					window.attachEvent("onload", ready);
				}
				readyEventHandlersInstalled = true;
			}
		}
	})();

	function info(msg) {
		log(msg, log.levels.info, 'FrontEndDelay');
	}

	var delay = w.wgPerfTestFrontEndDelay;

	// report the delayed onDOMReady
	// will be stored in rum_metrics_performance_tests series in InfluxDB
	$(function() {
		var sink = weppy('performance_tests::metrics');
		if (w.wgNow) {
			sink.store('domCompleteDelayed', new Date() - w.wgNow); // metrics.domCompleteDelayed [ms]
		}
	});

	// skip the test, there's no delay defined
	if (!delay) {
		info('delay not defined, leaving...');
		return;
	}

	info('delay set to ' + delay + ' ms');

	// @see http://api.jquery.com/jquery.holdready/
	$.holdReady(true);

	docReady(function() {
		info('docReady() called');

		setTimeout(function () {
			info('hold released');
			$.holdReady(false);
		}, delay);
	});

})(window, window.Wikia.log, window.Weppy, jQuery);
