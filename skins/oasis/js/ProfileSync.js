var ProfileSync = {
	init: function() {
		ProfileSync.attachListeners();
		ProfileSync.addTrackclicking();
	},

	attachListeners: function() {
		$('.fbconnect-preview-synced-profile .remove').one('click', function() {
			ProfileSync.removeColumn(this);
		});
	},

	addTrackclicking: function() {
		var node = $('#FacebookProfileSyncSave');

		node.trackClick('facebookprofilesync/save');
		node.trackClick('facebookprofilesync/save/' + $('#FacebookProfileSyncUserNameWiki').val());
	},

	removedId: '',

	removeColumn: function(obj) {
		var node = $(obj),
			column = node.parent().parent();

		ProfileSync.removedId = node.attr('id');

		column.hide('fast', function(id) {
			column.remove();
			ProfileSync.track(ProfileSync.removedId);
		});
	},

	track: function(fakeUrl) {
		$.tracker.byStr('facebookprofilesync/' + fakeUrl);
	}
};

$(function() {
    ProfileSync.init();
});
