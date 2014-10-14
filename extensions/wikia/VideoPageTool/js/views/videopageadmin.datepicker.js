/**
 * @description Generalized view for jQuery.ui Datepicker, based/refactored from SpecialMarketingToolbox implementation
 * @dependencies Model datepicker
 */
define('views.videopageadmin.datepicker', [
		'models.videopageadmin.datepicker'
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
			_notPublished: 0,
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
					dayStatus;

			tdClassName = '';
			dayStatus = this.collection.getStatus(date);

			if (dayStatus !== undefined) {
				// response sends back a string, parse it to int
				dayStatus = parseInt(dayStatus, 10);
				if (dayStatus === this.state._notPublished ) {
					tdClassName = 'in-prog';
				} else if (dayStatus === this.state._published ) {
					tdClassName = 'published';
				}
			}

			return [true, tdClassName ];
		},
		onChangeMonthYear: function(year, month) {
			return this.collection.collectData(year, month);
		},
		onSelect: function(timestamp) {
			var qs = window.Wikia.Querystring,
					loc = window.location,
					pathname;


			if (loc.pathname.charAt( loc.pathname.length - 1 ) !== '/') {
				pathname = loc.pathname + '/';
			} else {
				pathname = loc.pathname;
			}

			qs(loc.protocol + '//' + loc.host + pathname + 'edit')
				.setVal({
						language: this.collection.language,
						date: timestamp/1000
				})
				.goTo();
		},
		constructor: DatepickerView
	};

	return DatepickerView;
});
