/**
 * JS version of Component.class.php - part of UI repo API for rendering components
 *
 * UIComponent handles rendering component
 *
 * @author Rafal Leszczynski <rafal@wikia-inc.com>
 *
 */

define('wikia.uicomponent',['wikia.mustache'], function uicomponent(mustache) {
	'use strict';

	function UIComponent() {

		if(!(this instanceof UIComponent)) {
			return new UIComponent;
		}

		var componentConfig = {},
			componentType,
			componentVars;

		/**
		 * Set template name for rendering this component
		 *
		 * @param {String} type name of the template
		 */

		function setComponentType(type) {
			componentType = type;
		}

		/**
		 * Return template name set for rendering this component
		 *
		 * @return {String} name of the template
		 */

		function getComponentType() {
			return componentType;
		}

		/**
		 * Set mustache template for rendering this component
		 *
		 * @param {{}} vars object with mustachevariables
		 */

		function setComponentVars(vars) {
			componentVars = vars;
		}

		/**
		 * Return mustache variables set for rendering this component
		 *
		 * @return {{}} object with variables
		 */

		function getComponentVars() {
			return componentVars;
		}

		/**
		 * Return mustache template
		 *
		 * @param {String} type name of the template
		 *
		 * @return {String} html markup for the component
		 */

		function getTemplate(type) {
			return componentConfig['templates'][type];
		}

		/**
		 * Check if all required mustache variables are set
		 *
		 * @throw {Error} message with missing variables
		 */

		function validateComponent() {

			// Validate component type
			var type = getComponentType(),
				supportedTypes = componentConfig.templates;

			if (!supportedTypes.hasOwnProperty(type)) {
				throw new Error('Requested component type is not supported');
			}

			// Validate required mustache variables
			var	requiredVars = componentConfig.templateVarsConfig[type].required,
				missingVars= [];

			requiredVars.forEach(function(element) {
				if (!componentVars.hasOwnProperty(element)) {
					missingVars.push(element);
				}
			});

			if (missingVars.length > 0) {
				var variables = missingVars.join(', ');
				throw new Error('Missing required mustache variables: ' + variables + '!');
			}
		}

		/**
		 * Renders component
		 *
		 * @param {{}} params (example: { type: [template_name], vars: { [mustache_variables] } }
		 *
		 * @return {String} html markup for the component
		 */

		this.render = function(params) {

			setComponentType(params['type']);
			setComponentVars(params['vars']);

			validateComponent();

			return mustache.render(getTemplate(getComponentType()), getComponentVars());
		};

		/**
		 * Configures component
		 *
		 * @param {{}} templates object with mustache templates
		 * @param {{}} templateVars object with accepted template variables
		 */

		this.setComponentsConfig = function(templates, templateVarsConfig) {
			componentConfig.templates = templates;
			componentConfig.templateVarsConfig = templateVarsConfig;
		};
	}

	return UIComponent;

});
