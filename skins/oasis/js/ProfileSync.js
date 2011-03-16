$(function() {
    ProfileSync.init();
});


var ProfileSync = {
	init: function() {
		ProfileSync.attachListeners();
	},

	attachListeners: function() {
		$('.fbconnect-preview-synced-profile .remove').one('click', function() {
			ProfileSync.removeColumn(this);
		});
	},
	
	removeColumn: function(obj) {
		var colunn = $(obj).parent().parent();
		$(colunn).hide('fast', function() {
			$(colunn).remove();
		});
	}
};