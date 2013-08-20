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
		this.init();
	}

	Datepicker.prototype = {
		init: function() {
			this.render();
			console.log(this.collection.collectData());
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
