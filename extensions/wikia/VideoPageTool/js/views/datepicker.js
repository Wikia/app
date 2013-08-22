define('vpt.views.datepicker', [
		'vpt.models.datepicker'
], function(DatepickerCollection) {

	function DatepickerView(params) {
		this.$el = $(params.el);
		this.collection = new DatepickerCollection({
				language: 'en',
				controller: 'VideoPageToolSpecial',
				method: 'getCalendarInfo'
		});

		this.currDate = new Date();
		this.init();
	}

	DatepickerView.prototype = {
		init: function() {
			var that = this;
			// TODO: not a fan of how this callback chain requires a specific order, change this
			this.collection
				.collectData( this.currDate.getFullYear(), this.currDate.getMonth() + 1 )
				.success(function() {
					that.render();
				});
		},
		state: {
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
								console.log(this);
								return this.collection.collectData(year, month);
						}, this),
						onSelect: $.proxy(this.onSelect, this)
				});
			return this;
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
			alert('clicked');
		},
		constructor: DatepickerView
	};

	return DatepickerView;
});
