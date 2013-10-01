define('views.videopageadmin.index', [
	'views.videopageadmin.datepicker'
], function(Datepicker) {
	'use strict';

	function VPTIndex() {
		this.init();
	}

	VPTIndex.prototype = {
		init: function() {
			this.$regionSelect = $('#VideoPageToolRegionSelect');
			this.defaultLanguage = this.$regionSelect.data('defaultLanguage');
			this.bindEvents();
			this.renderDatepicker();
		},
		bindEvents: function() {
			var that = this;
			this.$regionSelect.on('change', function(evt) {
				return that.renderDatepicker.call(that, evt);
			});
		},
		renderDatepicker: function(evt) {
			var value = evt ? evt.target.value : this.defaultLanguage;

			// don't render if placeholder is chosen (for first time)
			if (value === 'placeholder') {
				return false;
			}

			// disable placeholder from being selected after a region has been selected
			this.$regionSelect.find('option[value=\'placeholder\']').attr('disabled', true);

			// delete stale datepickers
			if (this.datepicker) {
				this.datepicker.destroy();
			}

			// initialize new datepicker, passing through the language
			this.datepicker = new Datepicker({
				el: '#VPTDashboard .date-picker',
				language: value,
				controller: 'VideoPageAdminSpecial',
				method: 'getCalendarInfo'
			});
		}
	};

	return VPTIndex;
});

require(['views.videopageadmin.index'], function(IndexView) {

	'use strict';

	$(function() {
		new IndexView();
	});
});
