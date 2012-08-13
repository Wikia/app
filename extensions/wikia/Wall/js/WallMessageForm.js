(function(window, $) {

Wall.MessageForm = $.createClass(Observable, {
	constructor: function(page, model) {
		Wall.MessageForm.superclass.constructor.apply(this,arguments);
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
		// gets overriden if MiniEditor is enabled
		return '';
	},

	proxy: function(func) {
		return $.proxy(func, this);
	}
});

})(window, jQuery);