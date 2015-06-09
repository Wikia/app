/**
 * JavaScript for SRF boilerplate format using the semanticFormats namespace
 * @see http://www.semantic-mediawiki.org/wiki/Help:Boilerplate format
 *
 * Please remember to add your documentation to http://www.semantic-mediawiki.org
 *
 * @since 1.8
 * @release 0.1
 *
 * @file
 * @ingroup SemanticResultFormats
 *
 * @licence GNU GPL v2 or later
 * @author mwjames
 */
( function( $, mw, srf ) {

	// Use EcmaScript 5 to improve code quality and check with jshint/jslint
	// if the code adheres standard coding conventions

	// Strict mode eliminates some JavaScript pitfalls
	'use strict';

	// Passing jshint
	/*global mediaWiki:true, semanticFormats:true*/

	/**
	 * Module for formats extensions
	 * @since 1.8
	 * @type Object
	 */

	// Ensure the namespace is initialized and available
	srf.formats = srf.formats || {};

	/**
	 * Base constructor for objects representing a boilerplate instance
	 * @since 1.8
	 * @type Object
	 */

	// If you have default values to be set during the instantiation
	// $.extend ... can be used here
	srf.formats.boilerplate = function() {};

	srf.formats.boilerplate.prototype = {
		// Specify your functions and parameters
		show: function( context ) {
			return context.each( function() {

				// Ensure variables have only local scope otherwise leaked content might
				// cause issues for other plugins
				var $this = $( this );

				// Find the container instance that was created by the PHP output
				// and store it as "container" variable which all preceding steps
				// working on a localized instance
				var container = $this.find( '.container' );

				// Find the ID that connects to the current instance with the published data
				var ID = container.attr( 'id' );

				// Fetch the stored data with help of mw.config.get() method and the current instance ID
				// @see http://www.mediawiki.org/wiki/ResourceLoader/Default_modules#mediaWiki.config
				var json = mw.config.get( ID );

				// Parse the fetched json string and convert it back into objects/arrays
				var data = typeof json === 'string' ? jQuery.parseJSON( json ) : json;

				// Hide the spinner which belongs to the outer wrapper
				// Use the utility function here which makes it easier as no explicit knowledge
				// of a class selector is needed
				util.spinner.hide( { context: $this } );

				// You got everything you need to work your magic
				// A clean instance, data from the wiki, and a separate container

				// If you need to see what data you've got from your result printer
				// it is always helpfull to do

				// console.log( data );

				// Happy coding ...

		} );
		}
	};

	/**
	 * Implementation and representation of the boilerplate instance
	 * @since 1.8
	 * @type Object
	 */

	// Create class instance
	var boilerplate = new srf.formats.boilerplate();

	// Get access to SRF specific utilities function
	var util = new srf.util();

	$( document ).ready(function() {

		// Use the class selector to find all instances relevant to the "boilerplate" printer
		// since a wiki page can have more than one instance of the same result printer
		// .each() ensures instances are handled separately
		$( '.srf-boilerplate' ).each(function() {

			// Access methods available through the boilerplate class
			boilerplate.show( $( this ) );
		} );
	} );
} )( jQuery, mediaWiki, semanticFormats );