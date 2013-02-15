(function(window, $) {

var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

WE.plugins.addfile = $.createClass(WE.plugin, {

	init: function() {
		if( typeof window.wgEditPageAddFileMessage == 'string' ) {
			GlobalNotification.show( window.wgEditPageAddFileMessage, 'notify' );
		}
	}
});

})(this, jQuery);