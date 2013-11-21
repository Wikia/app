/**
 * JS version of Component.class.php - part of UI repo API for rendering components
 *
 * UIComponent handles rendering / creating component
 *
 * @author Rafal Leszczynski <rafal@wikia-inc.com>
 */

define( 'wikia.ui.component', [ 'wikia.mustache' ], function uicomponent( mustache ) {
	'use strict';

	/**
	 * Check if all required mustache variables are set
	 *
	 * @throw {Error} message with missing variables
	 */

	function validateComponent( componentConfig, componentType, componentVars ) {

		// Validate component type
		var supportedTypes = componentConfig.templates,
			variables,
			requiredVars,
			missingVars = [];


		if ( !supportedTypes.hasOwnProperty( componentType ) ) {
			throw new Error( 'Requested component type is not supported!' );
		}

		// Validate required mustache variables
		requiredVars = componentConfig.templateVarsConfig[ componentType ].required;
		missingVars= [];

		requiredVars.forEach(function( element ) {
			if ( !componentVars.hasOwnProperty( element ) ) {
				missingVars.push( element );
			}
		});

		if ( missingVars.length > 0 ) {
			variables = missingVars.join( ', ' );
			throw new Error( 'Missing required mustache variables: ' + variables + '!' );
		}
	}

	/**
	 * Constructor function for creating UI Components
	 *
	 * @returns {Object} - new instance of UI component class
	 * @constructor
	 */

	function UIComponent() {

		if ( !( this instanceof UIComponent ) ) {
			return new UIComponent();
		}

		var componentConfig = {},
			componentType,
			componentVars;

		/**
		 * Renders component
		 *
		 * @param {{}} params (example: { type: [template_name], vars: { [mustache_variables] } }
		 *
		 * @return {String} html markup for the component
		 */

		this.render = function( params ) {

			componentType = params.type;
			componentVars = params.vars;

			validateComponent( componentConfig, componentType, componentVars );

			return mustache.render( componentConfig.templates[ componentType ], componentVars );
		};

		/**
		 * Configures component
		 *
		 * @param {Object} config - component configuration object needed for rendering and creating components
		 */

		this.setComponentsConfig = function( config ) {
			componentConfig = config;
		};

		/**
		 * Shortcut method for creating components which have additional JS logic (example: Modals)
		 *
		 * Calls special 'createComponent' function in components AMD wrapper module with mustache params
		 * and reference to UI component instance passed as parameters. Rendering, appending to DOM and
		 * initializing are done in a single step.
		 *
		 *      Example:
		 *              require( [ wikia.ui.factory ], function( uifactory ) {
		 *
		 *                  uifactory.init( [ 'modal' ] ).then( function( modal ) {
		 *
		 *                     modal.createComponent( mustacheParams, function(newModalInstance ) {
		 *
		 *                          newModalInstance.show();
		 *
		 *                      } );
		 *                  } );
		 *              } );
		 *
		 *
		 * @param {Object} params - Mustache params for rendering component
		 * @param {Function} callback - callback function with the instance of components object passed as parameter
		 */
		this.createComponent = function( params, callback ) {
			var that = this;
			if ( componentConfig.jsWrapperModule ) {
				require( [ componentConfig.jsWrapperModule ], function( object ) {
					callback( object.createComponent( params, that ) );
				});
			} else {
				callback( that, params );
			}
		};

		/**
		 * Returns sub component by name
		 *
		 * @param {String} componentName - name of requested subcomponent
		 * @returns {Object} - requested component
		 * @throws {Error} - if sub-component not found
		 */
		this.getSubComponent = function( componentName ) {
			if ( typeof componentConfig.dependencies[ componentName ] !== 'undefined' ) {
				return componentConfig.dependencies[ componentName ];
			}
			throw new Error( 'Dependency ' + componentName + ' not found.' );
		};
	}

	return UIComponent;

});
