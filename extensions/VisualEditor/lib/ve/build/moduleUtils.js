/*!
 * Utility methods for interpreting the modules.json manifest.
 *
 * Code shared with the OOjs UI project
 */

/*jshint node:true */

var self = module.exports = {
	/**
	 * Expand an array of file paths and variant-objects into
	 * a flattened list by variant.
	 *
	 *     input = [
	 *       'foo.js',
	 *       'bar.js',
	 *       { default: 'baz-fallback.js', svg: 'baz-svg.js', }.
	 *       'quux.js'
	 *     ]
	 *
	 *     output = {
	 *         default: [
	 *             'foo.js',
	 *             'bar.js'
	 *             'baz-fallback.js'
	 *             'quux.js'
	 *         ],
	 *         svg: [
	 *             'foo.js',
	 *             'bar.js'
	 *             'baz-svg.js'
	 *             'quux.js'
	 *         ]
	 *    ]
	 *
	 * @param {Array} resources List of expandable resources
	 * @return {Array} Flat list of file paths
	 */
	expandResources: function ( resources ) {
		// Figure out what the different css targets will be,
		// we need this to be shared between the recess task
		// (which will compile the less code) and the concat task
		// (which will prepend intro.css without it being stripped
		// like recess would).
		var targets = { default: [] };
		resources.forEach( function ( filepath ) {
			var variant, buffer;
			if ( typeof filepath !== 'object' ) {
				filepath = { default: filepath };
			}
			// Fetch copy of buffer before filepath/variant loop, otherwise
			// it can incorrectly include the default file in a non-default variant.
			buffer = targets.default.slice();
			for ( variant in filepath ) {
				if ( !targets[ variant ] ) {
					targets[ variant ] = buffer.slice();
				}
				targets[ variant ].push( filepath[ variant ] );
			}

		} );
		return targets;
	},

	/**
	 * Create a build list
	 *
	 * @param {Array} modules List of modules and their dependencies
	 * @param {Array} targets List of target modules to load including any dependencies
	 * @return {Object} An object containing arrays of the scripts and styles
	 */
	makeBuildList: function ( modules, targets ) {
		/**
		* Given a list of modules and targets, returns an object splitting the scripts
		* and styles.
		*
		* @param {Array} modules List of modules
		* @param {Array} buildlist List of targets to work through
		* @param {Object|null} filelist Object to extend
		* @return {Object} Object of two arrays listing the file paths
		*/
		function expandBuildList( modules, buildlist, filelist ) {
			var build, moduleName, script, style;

			filelist = filelist || {};
			filelist.scripts = filelist.scripts || [];
			filelist.styles = filelist.styles || [];

			for ( build in buildlist ) {
				moduleName = buildlist[ build ];

				for ( script in modules[ moduleName ].scripts ) {
					if ( !modules[ moduleName ].scripts[ script ].debug ) {
						filelist.scripts.push( modules[ moduleName ].scripts[ script ] );
					}
				}

				for ( style in modules[ moduleName ].styles ) {
					if ( !modules[ moduleName ].styles[ style ].debug ) {
						filelist.styles.push( modules[ moduleName ].styles[ style ] );
					}
				}
			}
			return filelist;
		}

		return expandBuildList( modules, self.buildDependencyList( modules, targets ) );
	},

	/**
	 * Expands an array of arrays of file paths with dependencies into an ordered
	 * lit of dependencies stemming from one or more given top-level modules.
	 *
	 * @param {Array} modules List of modules and their dependencies
	 * @param {Array} load List of targets to return and their dependencies
	 * @param {Array|null} list Extant flat list of file paths to extend
	 * @return {Array} Flat list of file paths
	 */
	buildDependencyList: function ( modules, load, list ) {
		var i, module;

		list = list || [];

		for ( i = 0; i < load.length; i++ ) {
			module = load[i];

			if ( !modules.hasOwnProperty( module ) ) {
				throw new Error( 'Dependency ' + module + ' not found' );
			}

			// Add in any dependencies
			if ( modules[module].hasOwnProperty( 'dependencies' ) ) {
				self.buildDependencyList( modules, modules[module].dependencies, list );
			}

			// Append target load module to the end of the current list
			if ( list.indexOf( module ) === -1 ) {
				list.push( module );
			}
		}

		return list;
	}
};
