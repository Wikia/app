/**
 * JS version of Factory.class.php - part of UI repo API for rendering components
 *
 * UIFactory handles building component which means loading
 * assets and component configuration file
 *
 * @author Rafal Leszczynski <rafal@wikia-inc.com>
 *
 */

define('wikia.uifactory', ['wikia.nirvana', 'wikia.window', 'wikia.deferred', 'wikia.uicomponent'], function uifactory(nirvana, window, Deferred, UIComponent){
	'use strict';

	/**
	 * Request components configs from backend
	 *
	 * @param {[]} components array with names of the requested components
	 *
	 * @return {{}} promise with components configs
	 */

	function getComponentsConfig(components) {

		var deferred = new Deferred,
			data = {
			components: components,
			cb: window.wgStyleVersion
		};

		nirvana.getJson(
			'Wikia\\UI\\UIFactoryApi',
			'getComponentsConfig',
			data,
			function(data) {
					deferred.resolve(data);
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
	 * @return {{}} new clean instance of UIComponent
	 */

	function getComponentInstance() {
		return new UIComponent;
	}

	/**
	 * Removes duplicates from an Array
	 *
	 * @param {[]} array Array with potential duplicated items
	 *
	 * @return {[]} array without duplicates
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
	 * @param {[]} styles Array with links for CSS files
	 */

	function addStylesToDOM(styles) {
		var domFragment = window.document.createDocumentFragment();

		styles.forEach(function(element) {
			var link = window.document.createElement('link');
			link.rel = 'stylesheet';
			link.href = element;
			domFragment.appendChild(link);
		});

		window.document.head.appendChild(domFragment);
	}

	/**
	 * Add scripts to DOM
	 *
	 * @param {[]} scripts Array with links for JS files
	 */

	function addScriptsToDOM(scripts) {
		var domFragment = window.document.createDocumentFragment();

		scripts.forEach(function(element) {
			var script = window.document.createElement('script');
			script.src = element;
			domFragment.appendChild(script);
		});

		window.document.body.appendChild(domFragment);
	}

	/**
	* Factory method for initialising components
	* (load assets dependencies and adds them to DOM + instantiates UI components and applies config to them)
	*
	* @param {String|[]} componentName Name of a single component or array with multiple components
	*
	* @return {{}} promise with UI components
	*/

	function init(componentName) {

		var deferred = new Deferred,
			components = [];

		if (!componentName instanceof Array) {
			componentName = [].push(componentName);
		}

		getComponentsConfig(componentName).done(function(data) {

			if (data.status !== 1) {
				deferred.reject();
				throw new Error(data.errorMessage);
			}

			var jsAssets = [],
				cssAssets = [];

			data.components.forEach(function(element) {

				var component = getComponentInstance(),
					templateVarsConfig = element.templateVarsConfig,
					assets = element.assets,
					templates = element.templates;

				if (assets) {
					jsAssets = jsAssets.concat(assets.js);
					cssAssets = cssAssets.concat(assets.css);
				}

				if (templateVarsConfig && templates) {
					component.setComponentsConfig(templates, templateVarsConfig);
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
