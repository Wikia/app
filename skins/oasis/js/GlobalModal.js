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
		$.get(wgScript, {
			action: 'ajax',
			rs: 'moduleProxy',
			moduleName: 'AutomaticWikiAdoption',
			actionName: 'AdoptWelcomeDialog',
			outputType: 'html',
			cb: wgCurRevisionId
		}, function(html) {
			$(html).makeModal({width: 500, height: 400});
		});
		var sassUrl = $.getSassCommonURL('/extensions/wikia/AutomaticWikiAdoption/css/AutomaticWikiAdoption.scss');
		$.getCSS(sassUrl);
	}
}

$(function() {
	GlobalModal.init();
});