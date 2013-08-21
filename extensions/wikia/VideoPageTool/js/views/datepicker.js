define('vpt.views.datepicker', [
		'vpt.models.datepicker'
], function(DatepickerCollection) {

	function DatepickerView(params) {
		this.$el = $(params.el);
		this.collection = new DatepickerCollection({
				language: 'en',
				controller: 'VideoPageTool',
				method: 'getCalendarInfo'
		});

		this.currDate = new Date();
		this.init();
	}

	DatepickerView.prototype = {
		init: function() {
			// TODO: not a fan of how this callback chain requires a specific order, change this
			this.collection.models = this.collection
				.collectData( this.currDate.getFullYear(), this.currDate.getMonth() + 1 )
				.complete(function() {
						console.log(arguments);
				});
			this.render();
		},
		render: function() {
			this.$el.text('').datepicker({
						showOtherMonths: true,
						selectOtherMoths: true,
						dateFormat: '@',
						beforeShowDay: $.proxy(this.beforeShowDay, this),
						onChangeMonthYear: $.proxy(function(year, month) {
								return this.collection.collectData(year, month);
						}),
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

			window.wgMarketingToolboxConstants = {};
			window.wgMarketingToolboxConstants.NOT_PUBLISHED = 2;
			window.wgMarketingToolboxConstants.PUBLISHED = 1;
			dayStatus = 1;
			if (dayStatus) {
				if (dayStatus === window.wgMarketingToolboxConstants.NOT_PUBLISHED) {
					tdClassName = 'inProg';
				} else if (dayStatus === window.wgMarketingToolboxConstants.PUBLISHED) {
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
