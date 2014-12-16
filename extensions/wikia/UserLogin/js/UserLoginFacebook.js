/* global UserLoginModal, wgCanonicalSpecialPageName, wgMainPageTitle, wgArticlePath, wgScriptPath, wgUserLanguage */

/**
 * Handle signing in and signing up with Facebook
 */
(function () {
	'use strict';

	var tracker, QueryString, uiFactory, UserLoginFacebook;

	UserLoginFacebook = {
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
			var self = this;

			if (this.initialized) {
				return;
			}

			this.bucky.timer.start('init');

			// requiring these variables here instead of at the top of the page to avoid race conditions until we can
			// turn this file into a proper AMD module
			// @todo: Turn this file into a proper AMD module
			require([
				'wikia.tracker',
				'wikia.querystring',
				'wikia.ui.factory'
			], function (t, qs, uf) {

				tracker = t;
				QueryString = qs;
				uiFactory = uf;
				self.actions = tracker.ACTIONS;
				self.track = tracker.buildTrackingFunction({
					category: 'user-sign-up',
					value: origin || 0,
					trackingMethod: 'both'
				});

				self.initialized = true;
				self.loginSetup();

				// load when the login dropdown is shown or specific page is loaded
				$.loadFacebookAPI();

				self.log('init');
				self.bucky.timer.stop('init');
			});
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

		/**
		 * Callback function after Facebook Login
		 * @param {Object} response Response object sent from Facebook after login attempt
		 */
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
		 * @param {Object} response Response object from FacebookSignupController::index
		 */
		checkAccountCallback: function (response) {
			// end ajax call performance tracking
			this.bucky.timer.stop('loginCallbackAjax');

			// if extensions have specified a callback, run it after successful login
			this.loginCallback = typeof this.callbacks['login-success'] === 'function' ?
				this.callbacks['login-success'] : false;

			// logged in using FB account, reload the page or callback
			if (response.loggedIn) {
				this.loggedInCallback();

			// some error occurred
			} else if (response.loginAborted) {
				window.GlobalNotification.show(response.errorMsg, 'error');
			} else if (response.unconfirmed) {
				$.get(wgScriptPath + '/wikia.php', {
					controller: 'UserLoginSpecial',
					method: 'getUnconfirmedUserRedirectUrl',
					format: 'json',
					username: response.userName
				}, function (json) {
					window.location = json.redirectUrl;
				});
			// user not logged in, show the login/signup modal
			} else {
				this.setupModal(response);
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
						(wgCanonicalSpecialPageName.match(/Userlogin|Userlogout|UserSignup/))) ?
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
		 * @param {Object} response Response object from FacebookSignupController::index
		 */
		setupModal: function (response) {
			this.bucky.timer.start('loggedOutCallback');
			$.when(
				uiFactory.init('modal'),
				$.getResources(
					[$.getSassCommonURL('extensions/wikia/UserLogin/css/UserLoginFacebook.scss')]
				)
			// response argument will be prepended to arguments otherwise passed to buildModal
			).then(this.buildModal.bind(this, response));
		},

		/**
		 * Build the login/signup modal once the dependencies are retrieved
		 * @param {Object} response Response object from FacebookSignupController::index
		 * @param {Object} uiModal UI Factory modal
		 */
		buildModal: function (response, uiModal) {
			// show the "or" circle only for languages where it makes sense
			var self = this,
				langClass = 'lang-' + wgUserLanguage,
				modalConfig = {
					vars: {
						id: 'FacebookSignUp',
						size: 'medium',
						content: response.modal,
						htmlTitle: response.htmlTitle,
						classes: [
							'facebook-signup-modal',
							langClass
						]
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

				$modal.on('click', '.extiw', function (event) {
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

		/**
		 * Handle JS for the login form portion of the modal
		 * @param {Object} $modal jQuery DOM element of the open modal
		 */
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

	window.UserLoginFacebook = UserLoginFacebook;
})();
