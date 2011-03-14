/**
 * Global Modal helper
 * if query parameter contains "modal=XYZ", it will execute "showXYZ()" if the function exists
 * @author Hyun Lim
 */
GlobalModal = {
	init: function() {
		var modal = $.getUrlVar('modal');
		if (modal) {
			var f = GlobalModal['show'+modal];
			$().log(f);
			if(typeof f === 'function') {
				f();
			}
		}
	},

	showUploadImage: function() {
		if (!wgUserName) {
			$('.ajaxLogin').trigger('click');
		} else {
			$('.upphotos').trigger('click');
		}
	},

	showAddPage: function() {
		if (!wgUserName) {
			$('.ajaxLogin').trigger('click');
		} else {
			$('.createpage').trigger('click');
		}
	},

	showLogin: function() {
		if (!wgUserName) {
			$('.ajaxLogin').trigger('click');
		}
	}
}

$(function() {
	GlobalModal.init();
});