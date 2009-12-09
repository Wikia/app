CKEDITOR.plugins.add('rte-first-run-notice',
{
	// dismiss notice using cookie (for both anons and logged-in) and by sending AJAX request (for logged-in only)
	dismiss: function(ev) {
		RTE.log('first run notice - dismiss');

		// hide notice
		$('#RTEFirstRunNotice').slideUp();

		// for logged-in: store in user settings
		if (window.wgUserName) {
			RTE.ajax('firstRunNoticeDismiss');
		}

		// for anons/logged-in: store in cookie
		$.cookies.set('RTENoticeDismissed', 1, {
			hoursToLive: 24 * 365 * 10, // 10 years
			domain: window.RTECookieDomain,
			path: window.RTECookiePath
		});

		RTE.track('firstRunNotice', 'close');
	},

	// check whether we should show notice
	isDismissed: function() {
		// notice not rendered - dismissed
		if (!$('#RTEFirstRunNotice').exists()) {
			RTE.log('first run notice - disabled / user option set');
			return true;
		}

		// check cookie
		var cookieValue = $.cookies.get('RTENoticeDismissed');
		if (cookieValue == 1) {
			RTE.log('first run notice - cookie set');
			return true;
		}

		return false;
	},

	init: function(editor) {
		var self = this;

		// show first run notice and bind events
		editor.on('instanceReady', function() {
			if (self.isDismissed()) {
				return;
			}

			// setup and show notice
			var notice = $('#RTEFirstRunNotice');
			notice.children('#RTEFirstRunNoticeClose').bind('click', self.dismiss);
			notice.slideDown();

			RTE.log('first run notice - show');
			RTE.track('firstRunNotice', 'init');
		});
	}
});
