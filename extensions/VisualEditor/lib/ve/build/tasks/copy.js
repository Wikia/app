/*!
 * Build a distribution file
 *
 * Concatenates the list of input files, and performs
 * version/date placeholder replacements.
 */

/*jshint node:true */
module.exports = function ( grunt ) {

	grunt.registerMultiTask( 'copy', function () {
		var destDir = this.data.dest + '/',
			strip = this.data.strip;
		this.filesSrc.forEach( function ( fileName ) {
			var destFileName = strip ? fileName.replace( strip, '' ) : fileName;
			grunt.file.copy( fileName, destDir + destFileName );
		} );
		grunt.log.writeln( 'Copied ' + this.filesSrc.length + ' files.' );
	} );

};
