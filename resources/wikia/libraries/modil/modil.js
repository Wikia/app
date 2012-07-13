/**
 * modil.js
 *
 * A no-frills, lightweight and fast AMD implementation for modular Javascript projects.
 *
 * @author Federico "Lox" Lucignano <https://plus.google.com/117046182016070432246>
 * @author Jakub Olek <https://plus.google.com/112565259111817320425>
 * @see https://github.com/federico-lox/modil.js
 * @see http://requirejs.org/docs/api.html for example and docs until the official docs for modil ain't ready
 */

(function(context){
	var modules = {},
		definitions = {},
		processing = {},
		//help minification
		arrType = Array,
		funcType = Function,
		strType = 'string',
		yes = true,
		nil = null,
		def;

	/**
	 * @private
	 */
	function process(name, requestId){
		var module = modules[name],
			//manage the process chain per request call since it's async
			pid = processing[requestId],
			dependencies,
			chain = '',
			x = 0,
			y,
			p;

		if(module){
			return module;
		}

		if(!pid){
			pid = {length: 0};
		}else if(pid[name]){
			for(p in pid){
				if(p !== 'length'){
					chain += p + '->';
				}
			}

			throw "circular dependency: " + chain + name;
		}

		pid[name] = yes;
		pid.length++;
		processing[requestId] = pid;
		module = definitions[name];

		if(module && module.def){
			if(module.dep instanceof arrType){
				dependencies = [];
				y = module.dep.length;

				for(; x < y; x++){
					dependencies[x] = process(module.dep[x], requestId);
				}
			}

			modules[name] = module = module.def.apply(context, dependencies);
		}

		delete definitions[name];
		delete pid[name];
		pid.length--;

		if(!pid.length){
			delete processing[requestId];
		}

		return module;
	}

	/**
	 * @public
	 */
	context.define = def = function(name, dependencies, definition){
		if(typeof name !== strType){
			throw "module name missing or not a string";
		}

		//no dependencies array, it's actually the definition
		if(!definition && dependencies){
			definition = dependencies;
			dependencies = nil;
		}

		if(!definition){
			throw "module " + name + " is missing a definition";
		}

		if(definition instanceof funcType){
			definitions[name] = {def: definition, dep: dependencies};
		}else{
			modules[name] = definition;
		}
	};

	/**
	 * required for UMD checks and to let jQuery register correctly
	 * @see https://github.com/amdjs/amdjs-api/wiki/jQuery-and-AMD
	 */
	def.amd = {
		jQuery: yes
	};

	/**
	 * @public
	 */
	context.require = function(name, callback){
		//execute asynchronously
		setTimeout(function(){
			var isArray = name instanceof arrType,
				id = Math.random();
				m = [];

			if(typeof name !== strType && !isArray){
				throw "module name missing or not valid";
			}

			if(isArray){
				var x = 0,
					y = name.length;

				for(; x < y; x++){
					m[x] = process(name[x], id);
				}
			}else{
				m[0] = process(name, id);
			}

			if(callback instanceof funcType){
				callback.apply(context, m);
			}
		}, 0);
	};

	//clear up temporary refs
	d = nil;
}(this));