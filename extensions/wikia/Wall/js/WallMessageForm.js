var WallMessageForm = $.createClass(Observable, {
	constructor: function(username, model) {
		WallMessageForm.superclass.constructor.apply(this,arguments);
		this.model = model;
		this.username = username;
	},

	loginBeforeAction: function(action) {
		if( typeof(showComboAjaxForPlaceHolder) == 'function') {
			showComboAjaxForPlaceHolder('', false, this.proxy(function() {
				AjaxLogin.doSuccess = this.proxy(function() {
					action();
					return true;
				});
			}), false, true );
		}
	},
	
	reloadAfterLogin: function() {
		AjaxLogin.doReload();
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