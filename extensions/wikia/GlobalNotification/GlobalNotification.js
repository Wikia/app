GlobalNotification = {
	dom: false,
	timed: false,
	initialized: false,
	init: function(callback) {
		// load css
		var sassUrl = $.getSassCommonURL('/extensions/wikia/GlobalNotification/GlobalNotification.scss');
		$.getCSS(sassUrl, function() {
			if(jQuery.isFunction(callback)) {
				callback();
			}
		});
	},
	createDom: function() {
		var isModal = GlobalNotification.isModal();
		// create and store dom
		GlobalNotification.dom = $('<div class="global-notification"><div class="msg"></div></div>');
		$(GlobalNotification.isModal() ? GlobalNotification.modal : 'body').prepend(GlobalNotification.dom);
		GlobalNotification.msg = GlobalNotification.dom.find('.msg');
	},
	notify: function(content) {
		GlobalNotification.content = content;
		GlobalNotification.show();
	},
	warn: function(content) {
		GlobalNotification.content = '<span class="warning"></span>' + content;
		GlobalNotification.show();
	},
	show: function() {
		var x = function() {
			if(!GlobalNotification.initialized) {
				GlobalNotification.init(function() {
					GlobalNotification.createDom();
					GlobalNotification.msg.html(GlobalNotification.content);
					GlobalNotification.dom.fadeIn();
				});
			} else {
				GlobalNotification.createDom();
				GlobalNotification.msg.html(GlobalNotification.content);
				GlobalNotification.dom.fadeIn();
			}
		};
		if(GlobalNotification.dom) {
			GlobalNotification.hide(x);
		} else {
			x();
		}
	},
	hide: function(callback) {
		GlobalNotification.dom.fadeOut(400, function() {
			GlobalNotification.dom.remove();
			GlobalNotification.dom = false;
			if(jQuery.isFunction(callback)) {
				callback();
			}
		});
	},
	isModal: function() {
		GlobalNotification.modal = $('.modalWrapper');
		if (GlobalNotification.modal.length > 0 && GlobalNotification.modal.is(':visible')) {
			return true;
		}
		return false;
	}
};

// ajax failure notification event registration
if(typeof wgAjaxFailureMsg != 'undefined') {
	$(document).ajaxError(function(evt, request, settings) {
		GlobalNotification.warn(wgAjaxFailureMsg);
	});
}