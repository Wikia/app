/**
 * JS version of Factory.class.php - part of UI repo API for rendering components
 *
 * UIFactory handles building component which means loading
 * assets and component configuration file
 *
 * @author Rafal Leszczynski <rafal@wikia-inc.com>
 *
 */

define('wikia.ui.factory', [
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

	function getComponentsConfig(components) {

		var deferred = new $.Deferred(),
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
			function(xhrObject) {
				deferred.reject(JSON.parse(xhrObject.responseText));
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

	// TODO: use jQuery helper methods for this or move this method to separate shared utility lib - waiting for decision about using jQuery in mobile skin

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
	* Factory method for initialising components
	* (load assets dependencies and adds them to DOM + instantiates UI components and applies config to them)
	*
	* @param {String|[]} componentName Name of a single component or array with multiple components
	*
	* @return {{}} promise with UI components
	*/

	function init(componentName) {

		var deferred = new $.Deferred(),
			components = [];

		if (!(componentName instanceof Array)) {
			var a = [];
			a.push(componentName);
			componentName = a;
		}

		getComponentsConfig(componentName).done(function(data) {

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

			// TODO: temporary solution - to limit number of requests all assets will be fetched as strings in a single request while calling getComponentsConfig
			loader({
				type: loader.CSS,
				resources: cssAssets
			});

			if (jsAssets.length > 0) {
				loader({
					type: loader.JS,
					resources: jsAssets
				}).done(function() {
					deferred.resolve((components.length == 1) ? components[0] : components);
				});
			} else {
				deferred.resolve((components.length == 1) ? components[0] : components);
			}

		}).fail(function(data) {
			if (data.error) {
				throw new Error(data.error + ': ' + data.message);
			}
			deferred.reject();
		});

		return deferred.promise();

	}

	//Public API
	return {
		init: init
	}

});
