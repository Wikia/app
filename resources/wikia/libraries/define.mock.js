/**
 * Mock of the AMD define function meant for unit tests focusing on AMD modules.
 *
 * @author  Piotr Gabryjeluk <rychu@wikia-inc.com>
 *
 * @example
 *
 * Usage:
 *
 * In the JavaScript test include this file before including the module to test,
 * the module definition will then be available throughout the test via define.getModule();
 * this will re-initialize the module every time it's called in the code, allowing for multiple
 * instances to be tested in different case inside the same test scenario, while also making mocking
 * define-time dependencies inline.
 *
 * WARNING: Don't use any other AMD module loader (such as Require.js and modil.js) at the same time,
 * as the definitions of the define function will clash.
 *
 * @example
 *
 * //mockedMod will contain a reference to an isolated instance of the module to test
 * var mockedMod = define.getModule();
 *
 * //mockedMod2 will containa  reference to an isolated instance of the module to test
 * //passing in mockedDep1 and mockedDep2 as the define-time dependencies
 * //to match modules definition like: define('myMod', ['dep1', 'dep2'], function (dep1, dep2){ ... });
 * var mockedMod2 = define.getModule(mockedDep1, mockedDep2);
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
