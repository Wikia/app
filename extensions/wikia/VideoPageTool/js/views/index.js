define('vpt.views.index', [
		'vpt.views.datepicker'
], function(Datepicker) {

	function VPTIndex(opts) {

		this.init();
	}

	VPTIndex.prototype = {
		init: function() {
			this.datepicker = new Datepicker({
					el: '#date-picker'
			});
		}
	};

	return VPTIndex;
});

require(['vpt.views.index'], function(IndexView) {
		$(function() {
			var index = new IndexView();
		});
});
