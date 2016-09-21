/*global define*/
define('ext.wikia.adEngine.utils.hooks', [], function () {
	'use strict';

	/**
	 * Register "pre" and "post" hooks for given methods
	 *
	 * @param {object} objectInstance
	 * @param {string[]} methodNames
	 */
	return function (objectInstance, methodNames) {
		var hooks = {};

		function addHookListeners() {
			if (typeof objectInstance.pre === 'function' || typeof objectInstance.post === 'function') {
				return;
			}

			objectInstance.pre = function (methodName, callback) {
				if (!hooks[methodName]) {
					throw new Error('Method ' + methodName + ' is not registered.');
				}
				if (typeof callback === 'function') {
					hooks[methodName].pre.push(callback);
				}
			};
			objectInstance.post = function (methodName, callback) {
				if (!hooks[methodName]) {
					throw new Error('Method ' + methodName + ' is not registered.');
				}
				if (typeof callback === 'function') {
					hooks[methodName].post.push(callback);
				}
			};
		}

		function callAllCallbacks(callbacks, args) {
			callbacks.forEach(function (callback) {
				callback.apply(objectInstance, args);
			});
		}

		methodNames.forEach(function (methodName) {
			var copy = objectInstance[methodName];
			if (typeof copy !== 'function') {
				throw new Error('Method ' + methodName + ' does not exist.');
			}

			hooks[methodName] = {
				pre: [],
				post: []
			};

			objectInstance[methodName] = function () {
				callAllCallbacks(hooks[methodName].pre, arguments);
				copy.apply(objectInstance, arguments);
				callAllCallbacks(hooks[methodName].post, arguments);
			};
		});

		addHookListeners();
	};
});
