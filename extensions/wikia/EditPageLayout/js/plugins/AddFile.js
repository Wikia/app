(function(window, $) {

var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

WE.plugins.addfile = $.createClass(WE.plugin, {

	init: function() {
		if(window.wgEditPageAddFileType) {
			var message = '';
			if(this.editor.mode == 'wysiwyg') {
				message = $.msg('wikia-editor-add-file-notice', window.wgEditPageAddFileType);
			} else {
				message = $.msg('wikia-editor-add-file-notice-no-wysiwyg', window.wgEditPageAddFileType);
			}
			new window.BannerNotification(message, 'notify').show();
		}
	}
});

})(this, jQuery);