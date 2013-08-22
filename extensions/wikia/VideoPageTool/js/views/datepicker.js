/**
 * @description Generalized view for jQuery.ui Datepicker, based/refactored from SpecialMarketingToolbox implementation
 * @dependencies Model datepicker
 */
define('vpt.views.datepicker', [
		'vpt.models.datepicker'
], function(DatepickerCollection) {
	'use strict';

	function DatepickerView(params) {
		this.$el = $(params.el);
		this.collection = new DatepickerCollection({
				language: params.language,
				controller: params.controller,
				method: params.method
		});

		this.currDate = new Date();
		this.init();
	}

	DatepickerView.prototype = {
		init: function() {
			var that = this;
			// TODO: not a fan of how this callback chain requires a specific order, change this
			// Bootstrap the collection
			this.collection
				.collectData( this.currDate.getFullYear(), this.currDate.getMonth() + 1 )
				// when collection returns, render the calendar
				.success(function() {
					that.render();
				});
		},
		state: {
			// private constants used to track state of a date entry
			_notPublished: 2,
			_published: 1
		},
		render: function() {
			this.$el.text('').datepicker({
						showOtherMonths: true,
						selectOtherMoths: true,
						dateFormat: '@',
						nextText: '',
						prevText: '',
						beforeShowDay: $.proxy(this.beforeShowDay, this),
						onChangeMonthYear: $.proxy(function(year, month) {
								return this.collection.collectData(year, month);
						}, this),
						onSelect: $.proxy(this.onSelect, this)
				});
			return this;
		},
		destroy: function() {
			this.$el.datepicker('destroy');
			delete this.collection;
		},
		beforeShowDay: function(date) {
			var tdClassName,
					tooltip,
					dayStatus;

			tdClassName = '';
			tooltip = '';
			dayStatus = this.collection.getStatus(date);

			if (dayStatus) {
				if (dayStatus === this.state._notPublished ) {
					tdClassName = 'inProg';
				} else if (dayStatus === this.state._published ) {
					tdClassName = 'published';
				}
				// tooltip = this.tooltipMessages[dayStatus];
			}

			return [true, tdClassName, tooltip];
		},
		onChangeMonthYear: function(year, month) {
			return this.collection.collectData(year, month);
		},
		onSelect: function() {
			// TODO: not implemented, build appropriate URI to programming page based on date and lang?
			window.alert('clicked');
		},
		constructor: DatepickerView
	};

	return DatepickerView;
});
