var JSSnippets = {
	stack: [],
	log: function(msg) {
		$().log(msg, 'JSSnippets');
	},
	// @see http://net.tutsplus.com/tutorials/javascript-ajax/javascript-from-null-utility-functions-and-debugging/
	unique: function(origArr) {
		var newArr = [],
			origLen = origArr.length,
			found,
			x, y;

		for ( x = 0; x < origLen; x++ ) {
			found = undefined;
			for ( y = 0; y < newArr.length; y++ ) {
				if ( origArr[x] === newArr[y] ) {
					found = true;
					break;
				}
			}
			if ( !found) {
				newArr.push( origArr[x] );
			}
		}
		return newArr;
	},

	// clear the stack
	clear: function() {
		this.stack = window.JSSnippetsStack = [];
		this.log('stack cleared');
	},

	// resolve dependencies, load them and initialize stuff
	init: function() {
		var self = this;

		this.stack = window.JSSnippetsStack || [];

		// stack is empty - leave now
		if (this.stack.length == 0) {
			return;
		}

		this.log('init');

		// create unique list of dependiences (both static files and libraries loader functions) and callbacks
		var dependencies = [],
			callbacks = {},
			options = {};

		$.each(this.stack, function(i, entry) {
			// get list of JS/CSS files to load
			$.each(entry.dependencies, function(n, dependency) {
				// file extension
				var ext = dependency.match(/\.([^.]+)$/);

				if (ext) {
					switch(ext[1]) {
						// fetch SCSS files via SASS processor
						case 'scss':
							dependency = $.getSassCommonURL(dependency);
							break;

						// paths rewrite for CSS and JS files
						default:
							dependency = dependency.
								replace(/^\/extensions/, wgExtensionsPath).
								replace(/^\/skins/, stylepath);
					}
				}

				dependencies.push(dependency);
			});

			// get "loader" JS functions
			if (entry.getLoaders) {
				$.each(entry.getLoaders(), function(n, loaderFn) {
					dependencies.push(loaderFn);
				});
			}

			if (entry.callback) {
				// register unique callback for each "type" of the code using JS snippets
				callbacks[entry.id] = entry.callback;

				// create a stack of options passed to each type of callback
				options[entry.id] = options[entry.id] || [];

				// push options to it
				options[entry.id].push(entry.options);
			}
		});

		// remove duplicated dependencies
		dependencies = this.unique(dependencies);

		// load all dependencies in parallel and then fire all callbacks
		$.getResources(dependencies, function() {
			self.log('dependencies loaded, running callbacks...');

			$.each(callbacks, function(id, callback) {
				$.each(options[id], function(oid, option) {
					callback(option);
				});
			});
		});

		// clear the stack
		this.clear();
	}
};

$(function() {
	JSSnippets.init();
});