/*!
 * Merge jsduck configuration files with a downstream one
 */

/*jshint node:true */
module.exports = function ( grunt ) {
	var _ = grunt.util._;

	grunt.registerMultiTask( 'jsduckcatconfig', function () {
		var targetFile = this.data.target,
			from = this.data.from,
			output = [];

		from.forEach( function ( src ) {
			var srcCategories;

			if ( typeof src === 'string' ) {
				src = {
					file: src
				};
			}

			srcCategories = grunt.file.readJSON( src.file );

			if ( !src.include && !src.aggregate ) {
				// Default to a straight inclusion
				output.push.apply( output, srcCategories );
				return;
			}

			if ( src.aggregate ) {
				_.forIn( src.aggregate, function ( targetCat, targetCatName ) {
					var targetGroups = [];
					// For each of the target category groups...
					targetCat.forEach( function ( targetGroupName ) {
						// ... find the category in the aggregate source
						srcCategories.forEach( function ( aggrCat ) {
							var targetGroup;
							if ( aggrCat.name === targetGroupName ) {
								targetGroup = {
									name: targetGroupName,
									classes: []
								};
								aggrCat.groups.forEach( function ( group ) {
									targetGroup.classes = targetGroup.classes.concat( group.classes );
								} );
								targetGroups.push( targetGroup );
							}
						} );
					} );
					output.push( {
						name: targetCatName,
						groups: targetGroups
					} );
				} );

			}

			if ( src.include ) {
				src.include.forEach( function ( targetCatName ) {
					srcCategories.forEach( function ( aggrCat ) {
						if ( aggrCat.name === targetCatName ) {
							output.push( aggrCat );
						}
					} );
				} );
			}

		} );

		grunt.file.write( targetFile, JSON.stringify( output, null, '\t' ) + '\n' );
		grunt.log.ok( 'File "' + targetFile + '" written.' );
	} );
};
