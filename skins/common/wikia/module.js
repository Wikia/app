/**
 * Simple Require.js-syntax-compatible implementation of the AMD spec for modules , to keep the code small and generic it
 * doesn't implement resource loading which is awkward on platforms using assets aggregation
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
//avoid re-defining existing functionality
if(!window.require && !window.define){
	(function(){
		/** @private **/

		var modules = {};

		function getModule(mod){
			var m = modules[mod],
				x = 0,
				y,
				deps;

			if(typeof m === 'object' && m.__def__/*checked by define, safe*/){
				//definition has not been run so far
				deps = m.__deps__;

				if(deps instanceof Array && deps.length > 0){
					y = deps.length;

					for(; x < y; x++)
						deps[x] = require(deps[x]);
				}

				m = m.__def__.apply(window, deps);

				//store the result if not undefined for next call
				if(typeof m !== 'undefined')
					modules[mod] = m;
			}

			return m;
		}

		/** @public **/

		/**
		 * @see http://requirejs.org/docs/api.html for example and docs
		 */
		window.require = function(mod, callback){
			var m;

			if(!(callback instanceof Function))
				throw "Missing or wrong callback referenced";

			if(typeof mod === 'string'){
				m = getModule(mod);
			}else if(mod instanceof Array){
				m = [];

				for(var x = 0, y = mod.length; x < y; x++){
					//faster than .push
					m[x] = getModule(mod[x]);
				}
			}

			if(callback instanceof Function)
				callback.apply(window, m);
		};

		/**
		 * @see http://requirejs.org/docs/api.html for example and docs
		 */
		window.define = function(mod, deps, def){
			var f = def,
				d = deps;

			//module name is required as 1 JS file could map to many modules due to asset aggregation
			if(typeof mod === 'string'){
				if(modules[mod])
					throw "cannot redefine module " + mod;

				if(typeof f === 'undefined' && (typeof d !== 'undefined')){
					//no dependencies, definition has been passed as the second parameter
					f = d;
					d = undefined;
				}

				if(f instanceof Function){
					m = (d instanceof Array) ? {__def__: f, __deps__: d} : {__def__: d};
				}else if(typeof f !== 'undefined'){
					m = d;
				}else{
					throw "missing definition for module" + mod;
				}

				modules[mod] = m;
			}else{
				throw "module name missing";
			}
		};
	})();
}