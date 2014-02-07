/**
 * JS version of Factory.class.php - part of UI repo API for rendering components
 *
 * UIFactory handles building component which means loading
 * assets and component configuration file
 *
 * @author Rafal Leszczynski <rafal@wikia-inc.com>
 *
 */

define( 'wikia.ui.factory', [
	'wikia.nirvana',
	'wikia.window',
	'wikia.loader',
	'wikia.ui.component',
	'jquery'
], function uifactory(
	nirvana,
	window,
	loader,
	UIComponent,
    $
) {

	'use strict';

	/**
	 * Request components configs from backend
	 *
	 * @param {[]} components array with names of the requested components
	 *
	 * @return {{}} promise with components configs
	 */

	function getComponentsConfig( components ) {

		var deferred = new $.Deferred(),
			data = {
				components: components,
				cb: window.wgStyleVersion
			};

		nirvana.getJson(
			'Wikia\\UI\\UIFactoryApi',
			'getComponentsConfig',
			data,
			function( data ) {
					deferred.resolve( data );
			},
			function( xhrObject ) {
				deferred.reject( JSON.parse( xhrObject.responseText ) );
			}
		);

		return deferred.promise();

	}

	/**
	 * Creates a new instance of UI component
	 *
	 * @return {{}} new clean instance of UIComponent
	 */

	function getComponentInstance() {
		return new UIComponent();
	}

	/**
	 * Removes duplicates from an Array
	 *
	 * @param {[]} array Array with potential duplicated items
	 *
	 * @return {[]} array without duplicates
	 *
	 */

	// TODO: use jQuery helper methods for this or move this method to separate shared utility lib - waiting for decision about using jQuery in mobile skin

	function arrayUnique( array ) {

		var o = {},
			uniqueArray = [],
			i;

		for ( i = 0; i < array.length; i++ ) {
			if ( o.hasOwnProperty( array[ i ] ) ) {
				continue;
			}
			uniqueArray.push( array[ i ] );
			o[ array[ i ] ] = 1;
		}

		return uniqueArray;

	}

	/**
	* Factory method for initialising components
	* (load assets dependencies and adds them to DOM + instantiates UI components and applies config to them)
	*
	* @param {String|[]} componentName Name of a single component or array with multiple components
	*
	* @return {{}} promise with UI components
	*/

	function init( componentName ) {

		var deferred = new $.Deferred(),
			components = [],
			dependencyObjects = {};

		if ( !( componentName instanceof Array ) ) {
			componentName = [ componentName ];
		}

		getComponentsConfig( componentName ).done(function( data ) {

			var jsAssets = [],
				cssAssets = [],
				createComponent = function( element ) {
					var component = getComponentInstance(),
						templateVarsConfig = element.templateVarsConfig,
						assets = element.assets,
						templates = element.templates,
						dependencies = element.dependencies,
						dependencyList = {};

					if ( typeof dependencies === 'object' ) {
						dependencies.forEach( function ( name ) {
							if ( typeof dependencyObjects[ name ] !== 'undefined' ) {
								dependencyList[ name ] = dependencyObjects[ name ];
							} else {
								deferred.reject();
								throw new Error( 'Sub component ' + name + ' not found' );
							}
						});
					}

					if ( assets ) {
						jsAssets = jsAssets.concat( assets.js );
						cssAssets = cssAssets.concat( assets.css );
					}

					if ( templateVarsConfig && templates ) {
						component.setComponentsConfig( {
							name: element.name,
							jsWrapperModule: element.jsWrapperModule,
							templates: templates,
							templateVarsConfig: templateVarsConfig,
							dependencies: dependencyList
						});
					}

					return component;
				};

			if ( data.dependencies ) {
				Object.keys( data.dependencies ).forEach(function( name ) {
					dependencyObjects[ name ] = createComponent( data.dependencies[ name ] );
				});
			}
			data.components.forEach(function( element ) {
				components.push( createComponent( element ) );
			});

			jsAssets = arrayUnique( jsAssets );
			cssAssets = arrayUnique( cssAssets );

			// TODO: temporary solution - to limit number of requests all assets will be fetched as strings in a single request while calling getComponentsConfig
			loader({
				type: loader.CSS,
				resources: cssAssets
			});

			function resolveDeferred() {
				deferred.resolve.apply( null, components );
			}

			if ( jsAssets.length > 0 ) {
				loader({
					type: loader.JS,
					resources: jsAssets
				}).done( resolveDeferred );
			} else {
				resolveDeferred();
			}

		}).fail(function( data ) {
			if ( data.error ) {
				throw new Error( data.error + ': ' + data.message );
			}
			deferred.reject();
		});

		return deferred.promise();

	}

	//Public API
	return {
		init: init
	};

});
