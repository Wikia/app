define('ext.wikia.design-system.loading-spinner', [
	'jquery',
	'ext.wikia.design-system.templating'
], function ($, templating) {
	'use strict';

	function LoadingSpinner(radius, strokeWidth) {
		var self = this;
		this.radius = radius || 30;
		this.strokeWidth = strokeWidth || 6;
		this.spinnerClasses = 'wds-spinner wds-block';
		this.strokeClasses = 'wds-path';
		this.html = templating.renderSpinner({
			radius: self.radius,
			fullRadius: self.radius + (self.strokeWidth / 2),
			fullDiameter: (self.radius * 2) + self.strokeWidth,
			spinnerClasses: self.spinnerClasses,
			strokeClasses: self.strokeClasses,
			strokeLength: (2 * Math.PI * self.radius)
		});
	}

	return LoadingSpinner
});
