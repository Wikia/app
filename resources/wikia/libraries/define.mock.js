/**
 * AMD define mock to unit test AMD modules.
 *
 * Usage:
 *
 * In JavaScript test include this file before including the tested module.
 * Whatever is defined as AMD module will be available in test via define.getModule.
 * This let's you initialize module multiple times and mock it's dependencies.
 *
 * Don't use modil and this mock at the same time in tests.
 *
 * See LazyQueueTest.js or CacheTest.js as examples of how to use this define mock.
 */

var modules = {};

function define(id, deps, def) {
	var undef;
	if (def === undef) {
		def = deps;
	}

	window.modules[id] = def;
}

define.amd = true;

require = function(deps, def){
	//whatever is required, make it available as a module - prepend it with require, so it's possible to distunguish it from actual modules
	define('require,' + deps.toString(), deps, def);
};

require.optional = function(name){
	return name;
};
