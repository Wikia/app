/**
 * JS version of Factory.class.php - part of UI repo API for rendering components
 *
 * UIFactory handles building component which means loading
 * assets and component configuration file
 *
 * @author Rafal Leszczynski <rafal@wikia-inc.com>
 *
 */

define('wikia.uifactory', ['wikia.nirvana', 'wikia.deferred', 'wikia.uicomponent'], function loader(nirvana, Deferred, UIComponent){
	'use strict';

	/**
	 * Request components configs from backend
	 *
	 * @param array components
	 *
	 * @return promise with components configs
	 *
	 */

	function getComponentConfig(components) {

		var deferred = new Deferred,
			data = {
			components: components,
			cb: window.wgStyleVersion
		};

		nirvana.getJson(
			'[controller_name]',
			'[method_name]',
			data,
			function(configs) {
					deferred.resolve(configs);
			},
			function() {
				deferred.reject();
			}
		);

		return deferred.promise();

	}

	/**
	 * Creates a new instance of UI component
	 *
	 * @return new clean instance of UIComponent
	 *
	 */

	function getComponentInstance() {
		return new UIComponent;
	}

	/**
	 * Removes duplicates from an Array
	 *
	 * @param array array
	 *
	 * @return array
	 *
	 */

	function arrayUnique(array) {

		var o = {},
			uniqueArray = [];

		for (var i = 0; i < array.length; i++) {
			if (o.hasOwnProperty(array[i])) {
				continue;
			}
			uniqueArray.push(array[i]);
			o[array[i]] = 1;
		}

		return uniqueArray;

	}

	/**
	 * Add styles to DOM
	 *
	 * @param array styles
	 *
	 */

	function addStylesToDOM(styles) {
		var domFragment = createDocumentFragment();

		styles.forEach(function(element) {
			var link = document.createElement('link');
			link.rel = 'stylesheet';
			link.href = element;
			domFragment.appendChild(link);
		});

		document.head.appendChild(domFragment);
	}

	/**
	 * Add scripts to DOM
	 *
	 * @param array scripts
	 *
	 */

	function addScriptsToDOM(scripts) {
		var domFragment = createDocumentFragment();

		scripts.forEach(function(element) {
			var script = document.createElement('script');
			script.src = element;
			domFragment.appendChild(script);
		});

		document.body.appendChild(domFragment);
	}

	/**
	* Factory method for initialising components
	* (load assets dependencies and adds them to DOM + instantiates UI components and applies config to them)
	*
	* @param string|array componentName
	*
	* @return promise with UI components
	*
	*/

	function init(componentName) {

		var deferred = new Deferred,
			components = [];

		if (!componentName instanceof Array) {
			componentName = [].push(componentName);
		}

		getComponentConfig(componentName).done(function(configsArray) {

			var jsAssets = [],
				cssAssets = [];

			configsArray.forEach(function(element) {

				var component = getComponentInstance(),
					templateVars = element['templateVars'],
					dependencies = element['dependencies'];

				if (dependencies) {
					jsAssets = jsAssets.concat(dependencies['js']);
					cssAssets = cssAssets.concat(dependencies['css']);
				}

				if (templateVars) {
					component.setTemplateVarsConfig(templateVars);
				}

				components.push(component);
			});

			jsAssets = arrayUnique(jsAssets);
			cssAssets = arrayUnique(cssAssets);

			addScriptsToDOM(jsAssets);
			addStylesToDOM(cssAssets);

			deferred.resolve((components.length == 1) ? components[0] : components);

		}).fail(function() {
			deferred.reject();
		});

		return deferred.promise();

	}

	//Public API
	return {
		init: init
	}

});