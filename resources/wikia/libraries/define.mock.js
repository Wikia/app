/**
 * Mock of the AMD define function meant for unit tests focusing on AMD modules.
 *
 * @author  Piotr Gabryjeluk <rychu@wikia-inc.com>
 *
 * @example
 *
 * Usage:
 *
 * In the JavaScript test include this file before including the module to test.
 * The module definition will then be available throughout the test via define.getModule(),
 * this will initialize the module every time the method is called.
 *
 * It allows multiple instances of the module to be tested in different cases inside the same
 * test scenario, and allows mocking define-time dependencies inline.
 *
 * WARNING: Don't use any other AMD module loader (such as Require.js and modil.js) at the
 * same time, as the implementations of the define function will clash (or at least it will
 * make no sense).
 *
 * @example
 *
 * // testedModule will contain a reference to an isolated instance of the module to test
 * var testedModule = define.getModule();
 *
 * // testedModuleWithMockedDeps will contain a reference to an isolated instance of the module to test
 * // passing in mockedDep1 and mockedDep2 as the define-time dependencies
 * // matching a module definition like: define('myMod', ['dep1', 'dep2'], function (dep1, dep2) { ... });
 * var testedModuleWithMockedDeps = define.getModule(mockedDep1, mockedDep2);
 *
 * @see  LazyQueueTest.js
 * @see  CacheTest.js
 */

(function (context) {
	'use strict';

	function define(id, deps, def) {
		var undef;
		if (def === undef) {
			def = deps;
		}
		define.getModule = def;
	}

	define.amd = true;
	context.define = define;
}(this));
