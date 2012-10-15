/**
 * DOM Writer: binds document.write calls to an HTMLElement to preserve the
 * content of the page after the DOM has already been processed while maintaining
 * the original behaviour of the native function.
 *
 * @author Federico "Lox" Lucignano <http://plus.ly/federico.lox>
 *
 * @see https://github.com/federico-lox/DOMwriter
 */

/*global define, document, HTMLElement*/
(function (context) {
	'use strict';

	function domwriter() {
			/**
			 * Constants
			 */
		var CLASS_NAME = 'domwriter_script',//class applied to scripts to be processed
			IDLE_TIME = 2000,//time in milliseconds to detect idleness
			/**
			 * Globals
			 */
			callbacks = {
				/**
				 * Events
				 */
				attached: [],//fired when target is invoked
				written: [],//fired when all the content of a document.write call has completed processing
				idle: [],//fired after IDLE_TIME milliseconds have passed from the last document.write call
				detached: []//fired when reset is invoked
			},
			sandbox,
			doc,
			idleTimer;

		function TargetException(element) {
			this.message = "Target is not a DOM element:" + element;
		}

		TargetException.prototype.toString = function () {
			return this.message;
		};

		/**
		 * fires an event that can be caught with addEventListener
		 *
		 * @private
		 *
		 * @param {String} event The name of the event to fire
		 * @param {Object} scope The scope for the event handler
		 *
		 * @see  addEventListener
		 */
		function fireEvent(event, scope) {
			var stack = callbacks[event],
				len;

			if (stack instanceof Array && (len = stack.length) > 0) {
				context.setTimeout(function () {
					var x = 0;

					while (x < len) {
						stack[x].call(scope);
						x += 1;
					}
				}, 0);
			}
		}

		/**
		 * Attaches an handler to an event
		 *
		 * @public
		 *
		 * @param {String} event The name of the event
		 * @param {Function} callback The event handler
		 *
		 * @see  removeEventListener
		 */
		function addEventListener(event, callback) {
			if (callbacks[event]) {
				callbacks[event].push(callback);
			}
		}

		/**
		 * Detaches an handler for an event
		 *
		 * @public
		 *
		 * @param {String} event The name of the event
		 * @param {Function} callback The previously registered handler to be detached
		 *
		 * @see addEventListener
		 */
		function removeEventListener(event, callback) {
			var stack = callbacks[event],
				len;

			if (stack instanceof Array) {
				len = stack.length;

				while (len > 0) {
					len -= 1;

					if (stack[len] === callback) {
						stack.splice(len, 1);
						break;
					}
				}
			}
		}

		/**
		 * Create a replica of a script node, differently from cloneNode
		 * the script will be actually downloaded/processed when injected
		 * back in the DOM
		 *
		 * @private
		 *
		 * @param {HTMLElement} element The script node to replicate
		 *
		 * @return {HTMLElement} The replica
		 */
		function copyScript(element) {
			var s = document.createElement('script'),
				attribs = element.attributes,
				a,
				x,
				y;

			for (x = 0, y = attribs.length; x < y; x += 1) {
				a = attribs[x];
				s.setAttribute(a.name, a.value);
			}

			s.text = element.text;
			s.className = element.className.replace(CLASS_NAME, '');
			return s;
		}

		/**
		 * Processes the script inside a wrapping HTMLElement one by one
		 * synchronously respecting their order in the DOM, this basically
		 * replicates the behviour of document.write processing
		 *
		 * @private
		 *
		 * @param {HTMLElement} element The node wrapping the scripts to be processed
		 */
		function processScripts(element) {
			//use class selection since tag selection
			//will be overridden further in the process
			var items = element.getElementsByClassName(CLASS_NAME),
				item,
				copy;

			if (items.length) {
				item = items[0];
				copy = copyScript(items[0]);

				//it's a common practice in code returned by Ad networks
				//to find the point of insertion or some settings by selecting
				//the script tag using document.getElementsByTag('script') or document.scripts and then
				//getting the last element (document.write would ensure the last one)
				//is actually the running script, to preserve this behaviour override
				//temporaneously the function and return the current item captured
				//using a closure
				if (!doc.backupGetByTag) {
					doc.backupGetByTag = doc.getElementsByTagName;
				}

				//supported since IE8 and pretty much everywhere
				//except iOS 4
				try {
					Object.defineProperty(doc, 'scripts', {
						get : function () { return [item]; },
						set : function (newValue) {},
						configurable: true
					});
				} catch (e) {}

				doc.getElementsByTagName = function (tag) {
					var ret;

					//if the search is for script tags then
					//return the current script otherwise
					//just use the native implementation
					if (tag.toLowerCase() === 'script') {
						ret = [item];
					} else {
						ret = this.backupGetByTag(tag);
					}

					return ret;
				};

				if (item.src) {
					//remote script, don't process the next one
					//until it won't be fully loaded and processed
					copy.onload = function () {
						processScripts(element);
					};
				}

				//replace the original node with its' copy
				//this will actually donwload/process the script
				item.parentNode.replaceChild(copy, item);

				if (!item.src) {
					//if it was an inline script, then it has been
					//processed at this point, move to the next one
					processScripts(element);
				}
			} else {
				//processing finished, cleanup any mess left behind
				if (doc.backupGetByTag) {
					doc.getElementsByTagName = doc.backupGetByTag;
					delete doc.backupGetByTag;

					//native behavior re-implemented as is not possible to reference
					//a property's implementation, in the end document.script
					//is not much used anymore and this will just work
					try {
						Object.defineProperty(doc, 'scripts', {
							get : function () { return doc.getElementsByTagName('script'); },
							set : function (newValue) {},
							configurable: true
						});
					} catch (err) {}
				}

				//setup check for idleness
				idleTimer = context.setTimeout(
					function () {
						context.clearTimeout(idleTimer);
						fireEvent('idle', sandbox);
					},
					IDLE_TIME
				);

				//fire completion event
				fireEvent('written', sandbox);
			}
		}

		/**
		 * @public
		 *
		 * @param {HTMLElement} element The node inject all the content to be writte into
		 *
		 * @throws {TargetException} If element is not an HTMLElement
		 */
		function target(element) {
			if (element instanceof HTMLElement) {
				sandbox = element;
				doc = element.ownerDocument;

				var wrapper = doc.createElement('div'),
					fragment = doc.createDocumentFragment();

				//backup native implementations
				doc.backupWrite = doc.write;
				doc.backupWriteLn = doc.writeln;

				//override the native document.write implementation
				//the magic starts from here
				doc.write = function (html) {
					var items,
						item,
						x,
						y;

					//clear idleness timer
					if (idleTimer) {
						context.clearTimeout(idleTimer);
					}

					//push the html to the temporary div
					//to get DOM nodes out of it
					//scripts won't be processed (yet)
					wrapper.innerHTML = html;
					items = wrapper.childNodes;

					//processing nodes in reverse order since
					//appending to the fragment makes the items
					//array shrink causing errors
					for (x = items.length - 1; x >= 0; x -= 1) {
						item = items[x];

						if (item.tagName === 'SCRIPT') {
							//mark the scripts with a unique class
							//to be able to find them back later, see processScripts
							item.className += ((item.className) ? ' ' : '') + CLASS_NAME;
						}

						//we're reverse processing the array so
						//prepend the nodes to restore
						//the original order
						fragment.insertBefore(item, fragment.firstChild);
					}

					element.appendChild(fragment);
					processScripts(element);
				};

				doc.writeln = function (html) {
					this.write(html + "\n");
				};

				fireEvent('attached', sandbox);
			} else {
				throw new TargetException();
			}
		}

		/**
		 * Restore the native implementation of document.write and document.writeln
		 *
		 * @public
		 */
		function reset() {
			if (doc && doc.write && doc.writeln) {
				//restore native implementations
				doc.write = doc.backupWrite;
				doc.writeln = doc.backupWriteLn;
			}

			sandbox = undefined;
			fireEvent('detached', context);
		}

		return {
			target: target,
			reset: reset,
			addEventListener: addEventListener,
			removeEventListener: removeEventListener
		};
	}

	if (typeof define !== 'undefined' && define.amd) {
		//AMD
		define('domwriter', domwriter);
	} else {
		//Namespace
		context.DOMWriter = domwriter();
	}
}(this));