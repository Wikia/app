/**
 * DOM Writer: binds document.write calls to a DOM element to preserve the
 * content of the page after DOMReady has fired
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

/*global define, document*/
(function (context) {
	'use strict';

	function domwriter() {
		function TargetException(element) {
			this.message = "Target is not a DOM element:" + element;
		}

		TargetException.prototype.toString = function () {
			return this.message;
		};

		/**
		 * @public
		 * @param {DOMElement} element The DOM element to bind all the content to write to
		 * @return {Bool} true for success, false for failure
		 */
		function target(element) {
			if (typeof element === 'object' && typeof element.innerHTML === 'string') {
				var doc = element.ownerDocument;

				//backup native implementations
				doc.backupWrite = doc.write;
				doc.backupWriteLn = doc.writeln;

				doc.write = function (text) {
					element.innerHTML += text;
				};

				doc.writeln = function (text) {
					this.write(text + "\n");
				};
			} else {
				throw new TargetException();
			}
		}

		/**
		 * @public
		 */
		function reset() {
			//restore native implementations
			doc.write = doc.backupWrite;
			doc.writeln = doc.backupWriteLn;
		}

		return {
			target: target,
			reset: reset
		};
	}

	if (typeof define !== 'undefined' && define.amd) {
		//AMD
		define('domwriter', domwriter);
	} else {
		//Namespace
		if (!context.Wikia) {
			context.Wikia = {};
		}

		context.Wikia.DOMWriter = domwriter();
	}
}(this));