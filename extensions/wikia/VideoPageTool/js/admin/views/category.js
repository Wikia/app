/**
 * View file for the category (aka latest videos) form
 * @extends 'videopageadmin.views.editbase'
 */

define('videopageadmin.views.category', [
	'jquery',
	'videopageadmin.collections.category',
	'videopageadmin.views.categoryforms',
	'videopageadmin.views.editbase'
], function ($, CategoryCollection, FormGroupView, EditBaseView) {
	'use strict';

	var CategoryPageView = EditBaseView.extend({
		initialize: function () {
			EditBaseView.prototype.initialize.call(this, arguments);
			this.categories = new CategoryCollection();
			this.$fieldsToValidate = this.$el.find('.category-name');
			this.$formGroups = this.$el.find('.form-wrapper');

			_.bindAll(this, 'render', 'initValidator');
			this.initValidator();
			this.categories.on('reset', this.render);
		},
		render: function () {
			var self = this;
			this.formSubViews = _.map(this.$formGroups, function (e) {
				return new FormGroupView({
					el: e,
					categories: new CategoryCollection(self.categories.toJSON())
				});
			});
			return this;
		},
		initValidator: function () {
			var self = this;

			EditBaseView.prototype.initValidator.call(this, arguments);

			this.$fieldsToValidate.rules('add', {
				required: {
					depends: function () {
						var count = 0;
						_.each(self.$fieldsToValidate, function (elem) {
							if ($(elem).val()) {
								count++;
							}
						});
						return count < 3;
					}
				},
				messages: {
					required: $.msg('videopagetool-formerror-category-name')
				}
			});
		}
	});

	return CategoryPageView;
});
