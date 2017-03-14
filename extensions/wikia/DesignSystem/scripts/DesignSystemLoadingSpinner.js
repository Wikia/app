define('ext.wikia.design-system.loading-spinner', [
	'jquery',
	'ext.wikia.design-system.templating'
], function ($, templating) {
	'use strict';

	var templateLocation = 'extensions/wikia/DesignSystem/services/templates/DesignSystemLoadingSpinner.mustache';

	function LoadingSpinner(radius, strokeWidth) {
		var self = this;
		this.radius = radius || 30;
		this.strokeWidth = strokeWidth || 6;
		this.spinnerClasses = 'wds-spinner wds-block';
		this.strokeClasses = 'wds-path';
		this.deferredElement = new $.Deferred();

		this.init = function() {
			return templating.renderByLocation(
				templateLocation,
				{
					radius: self.radius,
					fullRadius: self.radius + (self.strokeWidth / 2),
					fullDiameter: (self.radius * 2) + self.strokeWidth,
					spinnerClasses: self.spinnerClasses,
					strokeClasses: self.strokeClasses,
					strokeLength: (2 * Math.PI * self.radius)
				})
				.then(function (html) {
					var $element = $(html);
					self.deferredElement.resolve($element);
					return $element;
				});
		};

		this.enable = function () {
			this.deferredElement.promise().then(
				function ($element) {
					$element.addClass('zorf');
				}
			)
		};

		this.disable = function () {
			this.deferredElement.promise().then(
				function ($element) {
					$element.addClass('morf');
				}
			)
		}
	}

	return LoadingSpinner
});
