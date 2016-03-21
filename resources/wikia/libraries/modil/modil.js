/**
 * modil.js
 *
 * A no-frills, lightweight and fast AMD implementation
 * for modular JavaScript projects.
 *
 * @author Federico "Lox" Lucignano
 * <https://plus.google.com/117046182016070432246>
 * @author Jakub Olek
 *
 * @see https://github.com/federico-lox/modil.js
 * @see http://requirejs.org/docs/api.html for example
 * and docs until the official docs for modil ain't ready
 */

/*global setTimeout*/
(function (context) {
	'use strict';

	//if one of define or require already exists then throw an erro
	//to avoid silly things such as overriding native CommonJS support
	if (context.define) {
		throw 'define is already defined in the global scope, cannot continue';
	}

	if (context.require) {
		throw 'require is already defined in the global scope, cannot continue';
	}

	var mocks = {},
		modules = {},
		definitions = {},
		processing = {},
	//help minification
		arrType = Array,
		funcType = Function,
		strType = 'string',
		yes = true,
		nil = null,
		define,
		require;

	/**
	 * Processes a module definition for a require call
	 *
	 * @private
	 *
	 * @param {String} id The identifier of the module to process
	 * @param {Number} reqId The unique identifier generated by the require call
	 *
	 * @return {Object} The result of the module definition
	 *
	 * @throws {Error} If the processed module has circular dependencies
	 * @throws {Error} If id refers to an undefined module
	 */
	function process(id, reqId, optional) {
		var module = modules[id],
			mock = mocks[id],
		//manage the process chain per require
		//call since it can be an async call
			pid = processing[reqId],
			dependencies,
			chain = '',
			x,
			y,
			p,
			moduleDependencies,
			dependency;

		if (module) {
			return mock ? override(module, mock) : module;
		}

		if (!pid) {
			pid = {length: 0};
		} else if (pid[id]) {
			for (p in pid) {
				if (pid.hasOwnProperty(p) && p !== 'length') {
					chain += p + '->';
				}
			}

			throw 'circular dependency: ' + chain + id;
		}

		pid[id] = yes;
		pid.length += 1;
		processing[reqId] = pid;
		module = definitions[id];

		if (module && module.def) {
			dependencies = [];

			if (module.dep instanceof arrType) {
				moduleDependencies = module.dep;

				for (x = 0, y = moduleDependencies.length; x < y; x += 1) {
					dependency = moduleDependencies[x];
					dependencies[x] = process(dependency.toString(), reqId, dependency instanceof OptionalModule);
				}
			}

			modules[id] = module = module.def.apply(context, dependencies);
		} else if (!optional) {
			throw 'Module ' + id + ' is not defined.';
		}

		delete definitions[id];
		delete pid[id];
		pid.length -= 1;

		if (!pid.length) {
			delete processing[reqId];
		}

		return mock ? override(module, mock) : module;
	}

	function getRandomId() {
		return 'amd' + Math.round(1000000 * Math.random());
	}

	/**
	 * Defines a new module
	 *
	 * @public
	 *
	 * @example define('mymod', function () { return {hello: 'World'}; });
	 * @example define('mymod', ['dep1', 'dep2'], function (dep1, dep2) { ... });
	 *
	 * @param {String} id The identificator for the new module
	 * @param {Array} dependencies [Optional] A list of module id's which
	 * the new module depends on
	 * @param {Object} definition The definition for the module
	 *
	 * @throws {Error} If id is not passed or undefined
	 * @throws {Error} If id doesn't have a definition
	 * @throws {Error} If dependenices is not undefined but not an array
	 */
	define = function (id, dependencies, definition, defMock) {
		//no id, it's the definition or dependencies
		if (id instanceof funcType && !dependencies && !definition) {
			definition = id;
			dependencies = nil;
			id = getRandomId();
		} else if (id instanceof arrType && dependencies && !definition) {
			definition = dependencies;
			dependencies = id;
			id = getRandomId();
		}

		if (typeof id !== strType) {
			throw "Module id missing or not a string. " + (new Error().stack||'').replace(/\n/g, ' / ');
		}

		//no dependencies array, it's actually the definition
		if (!definition && dependencies) {
			definition = dependencies;
			dependencies = nil;
		}

		if (!definition) {
			throw "Module " + id + " is missing a definition.";
		} else if (definition instanceof funcType) {
			if (dependencies === nil || dependencies instanceof arrType) {
				if (defMock) {
					mocks[id] = definition();
				} else {
					definitions[id] = {def: definition, dep: dependencies};
				}

			} else {
				throw 'Invalid dependencies for module ' + id;
			}
		} else {
			(defMock ? mocks : modules)[id] = definition;
		}
	};

	/**
	 * Simple function to create mocks
	 *
	 * @param id {String} Name of a module to mock
	 * @param definition {Object} definition of mock
	 */
	define.mock = function (id, definition){
		define(id, nil, definition, yes);
	};


	/**
	 * Declares support for the AMD spec
	 *
	 * @public
	 */
	define.amd = {
		/**
		 * @see https://github.com/amdjs/amdjs-api/wiki/jQuery-and-AMD
		 */
		jQuery: yes
	};

	/**
	 * Requires pre-defined modules and injects them as dependencies into
	 * a callback, the process is non-blocking
	 *
	 * @public
	 *
	 * @example require(['mymod'], function (mymod) { ... });
	 * @example require(['mymod'], function (mymod, another) {}, function (err) {});
	 *
	 * @param {Array} ids An array of dependencies as moudule indentifiers
	 * @param {Function} callback The callback run in case of success, it will
	 * receive all the dependencies specified in ids as arguments
	 * @param {Function} errHandler [Optional] The callback to run in case of
	 * failure, should accept the error reference as the only parameter
	 *
	 * @throws {Error} If ids is not an array and/or callback is not a function
	 */
	require = function (ids, callback, errHandler) {
		if (ids instanceof arrType && callback instanceof funcType) {
			//execute asynchronously
			setTimeout(function () {
				try {
					var reqId = Math.random(),
						m = [],
						x,
						y;

					for (x = 0, y = ids.length; x < y; x += 1) {
						var module = ids[x];
						m[x] = process(module.toString(), reqId, module instanceof OptionalModule);
					}

					callback.apply(context, m);
				} catch (err) {
					if (errHandler instanceof funcType) {
						errHandler.call(context, err);
					} else {
						throw err;
					}
				}
			}, 0);
		} else {
			throw 'Invalid require call - ids: ' + JSON.stringify(ids);
		}
	};

	/**
	 * Class that stores optional module name
	 *
	 * @param id {String} Name of optional module
	 * @constructor
	 */
	var OptionalModule = function(id){
		this.id = id;
	};

	OptionalModule.prototype.toString = function(){
		return this.id;
	};

	/**
	 * Function that 'marks' module as optonal
	 *
	 * @param id {String} Name of optional module
	 * @return {OptionalModule} OptionalModule object
	 */
	require.optional = function(id){
		return new OptionalModule(id);
	};

	/**
	 * @param module Module to be mocked/partially mocked
	 * @param mock Mock
	 * @return Module
	 */
	function override(module, mock){
		for (var p in mock) {
			if (mock.hasOwnProperty(p) && module.hasOwnProperty(p)) module[p] = mock[p];
		}
		return module;
	}

	//expose needed functions to context
	context.require = require;
	context.define = define;
}(this));
