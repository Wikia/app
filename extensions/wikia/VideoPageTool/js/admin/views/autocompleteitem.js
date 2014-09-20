define('videopageadmin.views.autocompleteitem', [
	'jquery',
	'videopagetool.templates.mustache'
], function ($, templates) {
	'use strict';

	var CategorySingleResultView = Backbone.View.extend({
		initialize: function (opts) {
			this.parentView = opts.parentView;
		},
		tagName: 'div',
		className: 'autocomplete-item',
		template: Mustache.compile(templates.autocompleteItem),
		events: {
			'hover': 'onHover',
			'click': 'select'
		},
		onHover: function () {
			this.$el.addClass('selected').siblings().removeClass('selected');
		},
		select: function (evt) {
			evt.stopPropagation();
			this.model.collection.setCategory(this.model);
			this.parentView.trigger('results:hide');
		},
		render: function () {
			var html = this.template(this.model.toJSON());
			this.$el.html(html);
			return this;
		}
	});

	return CategorySingleResultView;
});
