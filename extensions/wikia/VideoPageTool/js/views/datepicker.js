function noop() { console.log('noop'); }
define('vpt.views.datepicker', [
		'vpt.models.datepicker'
], function(DatepickerCollection) {

	function Datepicker(params) {
		this.$el = $(params.el);
		this.collection = new DatepickerCollection({
				language: 'en',
				controller: 'VideoPageTool',
				method: 'getCalendarInfo'
		});

		this.currDate = new Date();
		this.init();
	}

	Datepicker.prototype = {
		init: function() {
			this.render();

			// TODO: not a fan of how this callback chain requires a specific order, change this
			this.collection.models = this.collection
				.collectData( this.currDate.getFullYear(), this.currDate.getMonth() + 1 )
				.complete(function() {
						console.log(arguments);
				});
		},
		render: function() {
			this.$el.text('')
				.datepicker({
						showOtherMonths: true,
						selectOtherMoths: true,
						dateFormat: '@',
						beforeShowDay: noop,
						onChangeMonthYear: noop,
						onSelect: noop
				});

			return this;
		},
		constructor: Datepicker
	};

	return Datepicker;
});
