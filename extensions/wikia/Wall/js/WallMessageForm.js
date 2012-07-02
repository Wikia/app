var WallMessageForm = $.createClass(Observable, {
	constructor: function(page, model) {
		WallMessageForm.superclass.constructor.apply(this,arguments);
		this.model = model;
		this.page = page;
		this.wall = $('#Wall');
	},

	loginBeforeAction: function(action) {
		UserLoginModal.show({
			callback: this.proxy(function() {
				action();
				return true;
			})
		});
	},
	
	reloadAfterLogin: function() {
		UserLoginAjaxForm.prototype.reloadPage();
	},

	getFormat: function() {
		// gets overrided if MiniEditor is enabled
		return '';
	},
		
	track: function(url) {
		if( typeof($.tracker) != 'undefined' ) {
			$.tracker.byStr(url);
		} else {
			WET.byStr(url);
		}
	},
	
	proxy: function(func) {
		return $.proxy(func, this);
	}
});