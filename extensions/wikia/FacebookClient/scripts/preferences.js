(function () {
	'use strict';

	function Preferences() {
		this.$connect = $('#fbConnectPreferences');
		this.$disconnect = $('#fbDisconnectPreferences');
		this.$disconnectLink = $('#fbDisconnectLink');
		this.$connectLink = $('.sso-login-facebook');
		return this;
	}

	Preferences.prototype.init = function () {
		$.loadFacebookAPI(this.bindEvents.bind(this));
	};

	Preferences.prototype.bindEvents = function () {
		this.$connectLink.on('click', this.connect.bind(this));
		this.$disconnectLink.on('click', this.disconnect.bind(this));
	};

	Preferences.prototype.connect = function (e) {
		e.preventDefault();

		window.FB.login(this.loginCallback.bind(this));
	};

	Preferences.prototype.loginCallback = function () {
		var self = this;

		$.nirvana.sendRequest({
			controller: 'FacebookClient',
			method: 'connectLoggedInUser',
			format: 'json',
			callback: function (data) {
				if (data.status === 'ok') {

					window.GlobalNotification.show($.msg('fbconnect-preferences-connected'), 'confirm');

					window.Wikia.Tracker.track({
						category: 'user-sign-up',
						trackingMethod: 'both',
						action: window.Wikia.Tracker.ACTIONS.SUCCESS,
						label: 'facebook-login'
					});
					self.toggle();
				} else {
					window.GlobalNotification.show($.msg('fbconnect-preferences-connected-error'), 'error');
				}
			}
		});
	};

	Preferences.prototype.toggle = function () {
		this.$connect
			.add(this.$disconnect)
			.toggleClass('hidden');
	};

	Preferences.prototype.disconnect = function (e) {
		var self = this,
			fbFromExisting = this.$disconnect.attr('data-fb-from-exist'),
			disconnectMsg = fbFromExisting ? 'fbconnect-disconnect-info-existing' : 'fbconnect-disconnect-info';

		e.preventDefault();

		$.nirvana.sendRequest({
			controller: 'FacebookClient',
			method: 'disconnectFromFB',
			format: 'json',
			callback: function (data) {
				if (data.status === 'ok') {
					window.GlobalNotification.show($.msg(disconnectMsg), 'confirm');
					window.Wikia.Tracker.track({
						category: 'user-sign-up',
						trackingMethod: 'both',
						action: window.Wikia.Tracker.ACTIONS.CLICK,
						label: 'fb-disconnect'
					});
					self.toggle();
				} else {
					window.GlobalNotification.show($.msg('oasis-generic-error'), 'error');
				}
			}
		});
	};

	$(function () {
		new Preferences().init();
	});
})();
