/**
 * LazyQueue module
 *
 * LazyQueue can be used when handling some events needs to be delayed
 * but then handled on the fly.
 *
 * @author Piotr Gabryjeluk <rychu@wikia-inc.com>
 * @author Przemek Piotrowski <nef@wikia-inc.com>
 *
 * @example You need a simple JavaScript array:
 *
 * var myQueue = [];
 *
 * You should add things to it (ALWAYS) using push method:
 *
 * myQueue.push('item1');
 * myQueue.push('item2');
 *
 * At some time, you can "upgrade" the array to be a lazy queue by calling:
 *
 * Wikia.LazyQueue.makeQueue(myQueue, function(item) {
 *  alert(item);
 * });
 *
 * The function passed as second argument is a callback that will be
 * eventually called for every element pushed to the queue.
 *
 * You can still push things to this array/queue:
 *
 * myQueue.push('item3');
 *
 * Then, you can start handling the items pushed you do:
 *
 * myQueue.start();
 *
 * The callback you passed before would be called for all the elements pushed
 * to the queue so far (so you see 3 alerts, item1, item2, item3).
 *
 * And even now, you can still push elements to the queue and callback will
 * be called for them:
 *
 * myQueue.push('item4');
 *
 * This will pop up the alert saying 'item4'.
 *
 * This module will be more than helpful to consistently handle events appearing
 * both before and after library loads. Just register the events in the LazyQueue
 * and when loading the library makeQueue and start it.
 */

(function (context) {
	'use strict';

	function lazyQueue() {
		/**
		 * Turns an array in a LazyQueue
		 *
		 * @public
		 *
		 * @param {Array} queue An array of values
		 * @param {Function} callback The callback to apply to each array item
		 */
		function makeQueue(queue, callback) {
			if (typeof callback !== 'function') {
				throw new Error('LazyQueue used with callback not being a function');
			} else if (queue instanceof Array) {
				queue.start = function () {
					while (queue.length > 0) {
						callback(queue.shift());
					}
					queue.push = function (item) {
						callback(item);
					};
				};
			} else {
				throw new Error('LazyQueue requires an array as the first parameter');
			}
		}

		return {
			makeQueue: makeQueue
		};
	}

	//UMD inclusive
	if (!context.Wikia) {
		context.Wikia = {};
	}

	//namespace
	context.Wikia.LazyQueue = lazyQueue();

	if (context.define && context.define.amd) {
		context.define('wikia.lazyqueue', lazyQueue);
	}
}(this));
