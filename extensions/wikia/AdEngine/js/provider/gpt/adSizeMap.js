/*global define*/
define('ext.wikia.adEngine.provider.gpt.adSizeMap', [
	'wikia.window',
	'wikia.log'
], function (win, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adSizeMap';

	function SizeMap(slotSizes) {
		log(['SizeMap', slotSizes], 'debug', logGroup);
		this.mapping = slotSizes || [];
	}

	SizeMap.is = function (object) {
		return object instanceof SizeMap;
	};

	SizeMap.prototype.toGptSizeMap = function () {
		log(['toGptSizeMap', this.mapping], 'debug', logGroup);
		var sizeMapping = win.googletag && win.googletag.sizeMapping();

		if (!sizeMapping) {
			return null;
		}

		this.mapping.forEach(function (mapping) {
			sizeMapping.addSize(mapping.viewport, mapping.sizes);
		});

		log(['toGptSizeMap', this.mapping, sizeMapping], 'debug', logGroup);
		return sizeMapping;
	};

	SizeMap.prototype.toString = function () {
		var param = {};

		this.mapping.forEach(function (viewportMapping) {
			param[viewportMapping.viewport.join('x')] = viewportMapping.sizes;
		});

		return JSON.stringify(param);
	};

	SizeMap.prototype.isEmpty = function () {
		return !this.mapping.length;
	}

	SizeMap.prototype.filterAllSizes = function (filter) {
		log(['filterAllSizes', this.mapping], 'debug', logGroup);
		this.mapping.forEach(function (viewportMapping) {
			viewportMapping.sizes = filter(viewportMapping.sizes);
		});
	};

	return SizeMap;
});
