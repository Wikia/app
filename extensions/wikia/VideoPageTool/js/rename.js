#!/bin/env node
'use strict';

var fs = require( 'fs' );
var path = require( 'path' );

var files = fs.readdirSync( './' );

files.forEach(function( filename ) {
	var parts,
			newFilename,
			absolutePath;
	parts = filename.split( '.' );
	module = parts[0];
	newFilename = parts.splice(1).join('.');
	absolutePath = path.resolve( filename, '..' );

	if ( module === 'videohomepage' ) {
		module = 'homepage';
	} else if ( module === 'videopageadmin' ) {
		module = 'admin';
	} else {
		module = 'shared';
	}

	var mvc = absolutePath.split('/');
	mvc = mvc[ mvc.length -1 ];

	absolutePath = path.resolve( absolutePath, '..' );

	fs.renameSync( path.resolve( filename ), absolutePath + '/' + module + '/' + mvc + '/' + newFilename  );

});

