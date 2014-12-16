define('videosmodule.views.incontent', [
	'videosmodule.views.rail',
	'sloth'
], function (RailView, sloth) {
	'use strict';

	var VideosModule = function (options) {
		// previousElement is the {DOM Node} element which fires the sloth loading of the Videos Module,
		// if there's none, sloth is skipped and init is running immediately
		this.previousElement = options.previousElement;

		// referenceElement is the {DOM Node} element (a sibling or a parent container),
		// which is a reference for placing the Videos Module by the
		// {jQuery Function} moduleInsertingFunction [before(), after(), prepend()]
		this.referenceElement = options.referenceElement;
		this.moduleInsertingFunction = options.moduleInsertingFunction;

		RailView.call(this, options);
	};

	VideosModule.prototype = Object.create(RailView.prototype);

	VideosModule.prototype.init = function () {
		var self = this;

		if (this.moduleInsertingFunction) {
			this.moduleInsertingFunction.call($(this.referenceElement), this.$el);
		}

		if (this.previousElement) {
			// Sloth is a lazy loading service that waits till an element is visible to load more content
			sloth({
				on: this.previousElement,
				threshold: 200,
				callback: function () {
					self.constructor.prototype.init.call(self);
				}
			});
		} else {
			this.constructor.prototype.init.call(this);
		}
	};

	return VideosModule;
});
