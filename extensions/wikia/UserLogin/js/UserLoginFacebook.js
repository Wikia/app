/* global UserLoginModal, wgCanonicalSpecialPageName, wgMainPageTitle, wgArticlePath */

// TODO: this is now an AMD module, which causes race conditions. Either revert that change or fix where this is called to require it as such.


/**
 * Handle
 */
define('wikia.userLoginFacebook', [
	'wikia.tracker',
	'wikia.querystring',
	'wikia.ui.factory'
], function (tracker, QueryString, uiFactory) {
	'use strict';

	var UserLoginFacebook = {
		modal: false,
		form: false,
		callbacks: {},
		initialized: false,
		origins: {
			DROPDOWN: 1,
			PAGE: 2,
			MODAL: 3
		},
		actions: {},
		track: false,
		bucky: window.Bucky('UserLoginFacebook'),

		log: function (msg) {
			$().log(msg, 'UserLoginFacebook');
		},

		init: function (origin) {
			if (this.initialized) {
				return;
			}
			this.bucky.timer.start('init');
			this.actions = tracker.ACTIONS;
			this.track = tracker.buildTrackingFunction({
				category: 'user-sign-up',
				value: origin || 0,
				trackingMethod: 'both'
			});

			this.initialized = true;
			this.loginSetup();

			// load when the login dropdown is shown or specific page is loaded
			$.loadFacebookAPI();

			this.log('init');
			this.bucky.timer.stop('init');
		},

		loginSetup: function () {
			var self = this;

			this.bucky.timer.start('loginSetup');

			$('body')
				.off('fb')
				.on('click.fb', '.sso-login-facebook', function (ev) {
					ev.preventDefault();

					// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
					window.FB.login($.proxy(self.onFBLogin, self), {
						scope: 'email'
					});
					if (UserLoginModal.$modal) {
						UserLoginModal.$modal.trigger('close');
					}
				});
		},

		// callback for FB.login
		onFBLogin: function (response) {
			if (typeof response !== 'object' || !response.status) {
				this.bucky.timer.stop('loginSetup');
				return;
			}
			this.log(response);
			switch (response.status) {
			case 'connected':
				this.log('FB.login successful');

				this.track({
					action: this.actions.SUCCESS,
					label: 'facebook-login'
				});

				// begin ajax call performance tracking
				this.bucky.timer.start('loginCallbackAjax');

				// now check FB account (is it connected with Wikia account?)
				$.nirvana.postJson('FacebookSignupController', 'index', {
						returnto: encodeURIComponent(window.wgPageName),
						returntoquery: encodeURIComponent(window.location.search.substring(1))
					},
					$.proxy(this.checkAccountCallback, this));
				break;
			case 'not_authorized':
				// Not logged into the Wikia FB app
				this.track({
					action: this.actions.SUCCESS,
					label: 'facebook-login-not-auth'
				});
				break;
			default:
				// Track FB Connect Error
				this.track({
					action: this.actions.ERROR,
					label: 'facebook-login'
				});
			}
			this.bucky.timer.stop('loginSetup');
		},

		/**
		 * Check if the current user's FB account is connected with a Wikia account and act acordingly
		 * @param {Object} resp Response object from FacebookSignupController::index
		 */
		checkAccountCallback: function (resp) {
			// end ajax call performance tracking
			this.bucky.timer.stop('loginCallbackAjax');

			// if extensions have specified a callback, run it after successful login
			this.loginCallback = typeof this.callbacks['login-success'] === 'function' ?
				this.callbacks['login-success'] : false;

			// logged in using FB account, reload the page or callback
			if (resp.loggedIn) {
				this.loggedInCallback();

			// some error occurred
			} else if (resp.loginAborted) {
				window.GlobalNotification.show(resp.errorMsg, 'error');
			} else if (resp.unconfirmed) {
				$.get(wgScriptPath + '/wikia.php', {
					controller: 'UserLoginSpecial',
					method: 'getUnconfirmedUserRedirectUrl',
					format: 'json',
					username: resp.userName
				}, function (json) {
					window.location = json.redirectUrl;
				});
			// user not logged in, show the login/signup modal
			} else {
				this.showModal(resp);
			}
		},

		/**
		 * This runs after has signed in with facebook and is already registered with Wikia.
		 */
		loggedInCallback: function () {
			if (this.loginCallback) {
				this.loginCallback();
			} else {
				this.bucky.timer.start('loggedInCallback');
				var qString = new QueryString(),
					returnTo = (wgCanonicalSpecialPageName &&
						(wgCanonicalSpecialPageName.match(/Userlogin|Userlogout/))) ?
						wgMainPageTitle : null;

				if (returnTo) {
					qString.setPath(wgArticlePath.replace('$1', returnTo));
				}
				// send bucky info immediately b/c the page is about to redirect
				this.bucky.timer.stop('loggedInCallback');
				this.bucky.flush();
				qString.addCb().goTo();
			}
		},

		/**
		 * Show a modal (to logged out users) for logging in or signing up with Wikia
		 * after a successful Facebook connection.
		 * @param {Object} resp Response object from FacebookSignupController::index
		 */
		showModal: function (resp) {
			var self = this;

			this.bucky.timer.start('loggedOutCallback');
			$.when(
				uiFactory.init('modal'),
				$.getResources(
					[$.getSassCommonURL('extensions/wikia/UserLogin/css/UserLoginFacebook.scss')]
				)
			).then(function (uiModal) {
				var modalConfig = {
					vars: {
						id: 'FacebookSignUp',
						size: 'medium',
						content: resp.modal,
						htmlTitle: resp.htmlTitle,
						classes: ['facebook-signup-modal'],
						buttons: [{
							vars: {
								value: resp.cancelMsg,
								data: [{
									key: 'event',
									value: 'close'
								}]
							}
						}]
					}
				};

				uiModal.createComponent(modalConfig, function (facebookSignupModal) {
					var $modal = facebookSignupModal.$element;

					// set reference to modal object
					self.modal = facebookSignupModal;

					// Track Facebook Connect Modal Close
					facebookSignupModal.bind('beforeClose', function () {
						self.track({
							action: self.actions.CLOSE,
							label: 'facebook-login-modal'
						});
					});

					self.createSignupForm($modal);
					self.createLoginForm($modal);

					$modal.on('click', '.submit-pane .extiw', function (event) {
						self.track({
							action: tracker.ACTIONS.CLICK_LINK_TEXT,
							browserEvent: event,
							href: $(event.target).attr('href'),
							label: 'wikia-terms-of-use'
						});
					});

					// Track FB Connect Modal Open
					self.track({
						action: self.actions.OPEN,
						label: 'facebook-login-modal'
					});

					facebookSignupModal.show();
					self.bucky.timer.stop('loggedOutCallback');
				});
			});
		},

		/**
		 * Handle JS for the signup form portion of the modal
		 * @param {Object} $modal jQuery DOM element of the open modal
		 */
		createSignupForm: function ($modal) {
			var self = this;

			this.signupForm = new window.UserSignupFacebookForm($modal.find('.UserLoginFacebookLeft'), {
				ajaxLogin: true,
				skipFocus: true,
				callback: function () {
					// Track FB Connect Sign Up
					self.track({
						action: self.actions.SUBMIT,
						label: 'facebook-signup-modal'
					});

					// run logged in callback or redirect to the specified location
					if (self.loginCallback) {
						self.loginCallback();
					} else {
						window.location.href = this.returnToUrl;
					}
				}
			});
		},

		createLoginForm: function ($modal) {
			var self = this;

			this.loginForm = new window.UserLoginFacebookForm($modal.find('.UserLoginFacebookRight'), {
				ajaxLogin: true,
				skipFocus: true,
				callback: function () {
					// Track FB Connect login
					self.track({
						action: self.actions.SUBMIT,
						label: 'facebook-login-modal'
					});

					// run logged in callback or redirect to the specified location
					if (self.loginCallback) {
						self.loginCallback();
					} else {
						window.location.href = this.returnToUrl;
					}
				}
			});
		},

		/**
		 * Used mainly by other extensions to close the signup modal after a successful login
		 */
		closeSignupModal: function () {
			var modal = this.modal;

			if (modal) {
				modal.trigger('close');
			}
		}
	};

	return UserLoginFacebook;
});
