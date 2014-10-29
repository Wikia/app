/*global WikiaFooterApp*/

/*
 * GlobalNotification.show()
 * @param string content - message to be displayed
 * @param string type - 'notify' (blue), 'confirm' (green), 'error' (red), 'warn' (yellow)
*/

var GlobalNotification = {
	init: function() {
		'use strict';
		// If there's already a global notification on page load, set up JS
		GlobalNotification.dom = $('.global-notification');
		if(GlobalNotification.dom.length) {
			this.setUpClose();

			// temporary fix for CON-1856
			// todo: must be removed together with global notification redesign
			this.autoHide();
		}
		// Float notification (BugId:33365)
		this.wikiaHeaderHeight = $('#WikiaHeader').height();
	},
	// This is only for introspection in the browser
	options: {
		'notify': 'blue',
		'confirm': 'green',
		'error': 'red',
		'warn': 'yellow'
	},

	/**
	 * @desc auto-hides global notification after 3 seconds
	 * @todo: required for CON-1856 - temporary solution must be removed together with global notification redesign
	 */
	autoHide: function() {
		window.setTimeout(this.hide, 3000);
	},

	createDom: function(element) {
		'use strict';
		// create and store dom
		if(!GlobalNotification.dom.length) {
			GlobalNotification.dom = $( '<div class="global-notification">' +
				'<button class="close wikia-chiclet-button">' +
				'<img src="' + window.stylepath + '/oasis/images/icon_close.png">' +
				'</button><div class="msg"></div></div>' )
				.hide();
			GlobalNotification.setUpClose();
		}
		// allow notification wrapper element to be passed by extension (used for YUI modal in VET)
		if(element instanceof jQuery) {
			element.prepend( GlobalNotification.dom ).show();
		// handle standard modal implementation
		} else if(GlobalNotification.isModal()) {
			GlobalNotification.modal.prepend( GlobalNotification.dom );
		// handle non-modal implementation
		} else {
			if($('.oasis-split-skin').length) {
				$('.WikiaHeader').after( GlobalNotification.dom );
			} else {
				$('.WikiaPageContentWrapper').prepend( GlobalNotification.dom );
			}
		}
		GlobalNotification.msg = GlobalNotification.dom.find( '.msg' );
	},
	show: function(content, type, element, timeout) {
		'use strict';
		GlobalNotification.content = content;
		var callback = function() {
			GlobalNotification.createDom(element);
			GlobalNotification.msg.html( GlobalNotification.content );
			GlobalNotification.dom.removeClass('confirm, error, notify, warn').addClass(type);
			// Share scroll event with WikiaFooterApp's toolbar floating (BugId:33365)
			if (window.WikiaFooterApp) {
				WikiaFooterApp.addScrollEvent();
			}
			GlobalNotification.dom.fadeIn('slow');
			if(typeof timeout === 'number') {
				setTimeout(function() {
					GlobalNotification.hide();
				}, timeout);
			}
		};
		GlobalNotification.hide( callback );
	},
	hide: function( callback ) {
		'use strict';
		if ( !GlobalNotification.dom ) {
			return;
		}
		if ( GlobalNotification.dom.length ){
			GlobalNotification.dom.animate({
				'height': 0,
				'padding': 0,
				'opacity': 0
			}, 400, function() {
				GlobalNotification.dom.remove();
				GlobalNotification.dom = [];
				if( jQuery.isFunction( callback ) ) {
					callback();
				}
			});
		} else {
			if( jQuery.isFunction( callback ) ) {
				callback();
			}
		}
	},
	isModal: function() {
		'use strict';
		GlobalNotification.modal = $( '.modalWrapper, .yui-panel' );
		if ( GlobalNotification.modal.length > 0 && GlobalNotification.modal.is( ':visible' ) ) {
			return true;
		}
		return false;
	},
	setUpClose: function() {
		'use strict';
		GlobalNotification.dom.find( '.close' ).click(GlobalNotification.hide);
	},
	// Called from WikiaFooter.js
	onScroll: function(scrollTop) {
		'use strict';
		if(GlobalNotification.dom && GlobalNotification.dom.length) {
			var minTop = GlobalNotification.wikiaHeaderHeight;
			if(scrollTop > minTop) {
				GlobalNotification.dom.addClass('float');
			} else {
				GlobalNotification.dom.removeClass('float');
			}

		}
	}
};
$(function() {
	'use strict';
	GlobalNotification.init();
});

// ajax failure notification event registration
if( typeof wgAjaxFailureMsg !== 'undefined' ) {
	$( document ).ajaxError( function() {
		'use strict';
		GlobalNotification.show( window.wgAjaxFailureMsg, 'error' );
	});
}
