var ProfileSync = {
	init: function() {
		ProfileSync.attachListeners();
	},

	attachListeners: function() {
		$('.fbconnect-preview-synced-profile .remove').one('click', function() {
			ProfileSync.removeColumn(this);
		});
	},

	removedId: '',

	removeColumn: function(obj) {
		var node = $(obj),
			column = node.parent().parent();

		ProfileSync.removedId = node.attr('id');

		column.hide('fast', function(id) {
			column.remove();
		});
	}
};

$(function() {
    ProfileSync.init();
});
