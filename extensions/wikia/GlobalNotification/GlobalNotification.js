GlobalNotification = {
	dom: false,
	timed: false,
	initialized: false,
	enableShow: true,
		// Used to avoid race condition that happens when we call show and hide in short intervals.
		// Race condition is caused by the delay of loading css file.
		
	init: function(callback) {		
		if ( !jQuery.isFunction( callback ) ){
			callback = function(){};
		}
		if( !GlobalNotification.initialized ) {
			// load css
			var sassUrl = $.getSassCommonURL( '/extensions/wikia/GlobalNotification/GlobalNotification.scss' );
			$.getCSS( sassUrl, function() {
				GlobalNotification.initialized = true;
				callback();
			});
		} else {
			callback();
		}
	},
	createDom: function() {
		// create and store dom
		GlobalNotification.dom = $( '<div class="global-notification"><div class="msg"></div></div>' );
		$( GlobalNotification.isModal() ? GlobalNotification.modal : 'body' ).prepend( GlobalNotification.dom );
		GlobalNotification.msg = GlobalNotification.dom.find( '.msg' );
	},
	notify: function( content ) {
		GlobalNotification.content = content;
		GlobalNotification.show();
	},
	warn: function( content ) {
		GlobalNotification.content = '<span class="warning"></span>' + content;
		GlobalNotification.show();
	},
	show: function() {
		GlobalNotification.enableShow = true;
		var callback = function() {
			GlobalNotification.init( function() {
				if ( GlobalNotification.enableShow == true ) {
					GlobalNotification.createDom();
					GlobalNotification.msg.html( GlobalNotification.content );
					GlobalNotification.dom.fadeIn();
				} else {
					GlobalNotification.hide();
				}
			});
		};
		if( GlobalNotification.dom ) {
			GlobalNotification.hide( callback );
		} else {
			callback();
		}
	},
	hide: function( callback ) {
		GlobalNotification.enableShow = false;
		if ( GlobalNotification.dom != false ){
			GlobalNotification.dom.fadeOut( 400, function() {
				GlobalNotification.dom.remove();
				GlobalNotification.dom = false;
				if( jQuery.isFunction( callback ) ) {
					GlobalNotification.enableShow = true;
					callback();
				}
			});
		}
	},
	isModal: function() {
		GlobalNotification.modal = $( '.modalWrapper' );
		if ( GlobalNotification.modal.length > 0 && GlobalNotification.modal.is( ':visible' ) ) {
			return true;
		}
		return false;
	}
};

// ajax failure notification event registration
if( typeof wgAjaxFailureMsg != 'undefined' ) {
	$( document ).ajaxError( function( evt, request, settings ) {
		GlobalNotification.warn( wgAjaxFailureMsg );
	});
}