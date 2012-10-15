/**
 * Global Modal helper
 * if query parameter contains "modal=XYZ", it will execute "showXYZ()" if the function exists
 * @author Hyun Lim
 */
var GlobalModal = {
	init: function() {
		var modal = $.getUrlVar('modal');
		if (modal) {	// modal takes precedence
			var f = GlobalModal['show'+modal];
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
	},

	showAdopt: function() {
		$.when(
			$.getResources([$.getSassCommonURL('/extensions/wikia/AutomaticWikiAdoption/css/AutomaticWikiAdoption.scss')]),
			$.nirvana.sendRequest({
				controller: 'AutomaticWikiAdoption',
				method: 'AdoptWelcomeDialog',
				format: 'html',
				type: 'get',
				data: {
					cb: wgCurRevisionId
				}
			})
		).then(function(sass, nirvanaData) {
			var html = nirvanaData[0]; // while using .when/.then pattern ajax returns jQuery XHR object and html is at index [0]
			$(html).makeModal({width: 500, height: 400});
		});
	}
}

$(function() {
	GlobalModal.init();
});
