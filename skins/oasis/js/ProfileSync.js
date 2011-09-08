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
		$('#FacebookProfileSyncSave').trackClick('facebookprofilesync/save');
		$('#FacebookProfileSyncSave').trackClick('facebookprofilesync/save/' + $('#FacebookProfileSyncUserNameWiki').val());
	},
	
	removedId: '',
	
	removeColumn: function(obj) {
		var colunn = $(obj).parent().parent();
		ProfileSync.removedId = $(obj).attr('id');
		
		$(colunn).hide('fast', function(id) {
			$(colunn).remove();
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