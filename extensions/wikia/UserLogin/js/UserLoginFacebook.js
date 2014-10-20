/* global FB */
(function () {
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
			var self = this;

			if (!this.initialized) {
				this.bucky.timer.start('init');
				require(['wikia.tracker'], function (tracker) {
					self.actions = tracker.ACTIONS;
					self.track = tracker.buildTrackingFunction({
						category: 'user-sign-up',
						value: origin || 0,
						trackingMethod: 'both'
					});
				});

				this.initialized = true;
				this.loginSetup();

				// load when the login dropdown is shown - see BugId:68955
				window.fbAsyncInit = function () {
					FB.init({
						appId: window.fbAppId,
						xfbml: true,
						cookie: true,
						version: 'v2.1'
					});
				};

				(function (d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) {return;}
					js = d.createElement(s); js.id = id;
					js.src = '//connect.facebook.net/en_US/sdk.js';
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));

				this.log('init');
				this.bucky.timer.stop('init');
			}
		},

		loginSetup: function () {
			var self = this;

			this.bucky.timer.start('loginSetup');

			$('body')
				.off('fb')
				.on('click.fb', '.sso-login-facebook', function (ev) {
					ev.preventDefault();

					// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
					window.FB.login($.proxy(self.loginCallback, self), {
						scope: 'email'
					});
				});
		},

		// callback for FB.login
		loginCallback: function (response) {
			if (typeof response === 'object' && response.status) {
				this.log(response);
				switch (response.status) {
				case 'connected':
					this.log('FB.login successful');

					// begin ajax call performance tracking
					this.bucky.timer.start('loginCallbackAjax');

					// now check FB account (is it connected with Wikia account?)
					$.nirvana.postJson('FacebookSignupController', 'index',
						$.proxy(this.checkAccountCallback, this));
					break;

				default:
					// Track FB Connect Error
					this.track({
						action: this.actions.ERROR,
						label: 'facebook-login'
					});
				}
			}
			this.bucky.timer.stop('loginSetup');
		},

		// check FB account (is it connected with Wikia account?)
		checkAccountCallback: function (resp) {
			var self, loginCallback;

			// end ajax call performance tracking
			this.bucky.timer.stop('loginCallbackAjax');

			self = this;
			loginCallback = this.callbacks['login-success'] || '';

			// logged in using FB account, reload the page or callback
			if (resp.loggedIn) {

				// Track FB Connect Login
				this.track({
					action: this.actions.SUCCESS,
					label: 'facebook-login'
				});

				if (loginCallback && typeof loginCallback === 'function') {
					loginCallback();
				} else {
					this.bucky.timer.start('loggedInCallback');
					require(['wikia.querystring'], function (Qs) {
						var w = window,
							wgCanonicalSpecialPageName = w.wgCanonicalSpecialPageName,
							qString = new Qs(),
							returnTo = (wgCanonicalSpecialPageName &&
								(wgCanonicalSpecialPageName.match(/Userlogin|Userlogout/))) ? w.wgMainPageTitle : null;

						if (returnTo) {
							qString.setPath(w.wgArticlePath.replace('$1', returnTo));
						}
						// send bucky info immediately b/c the page is about to redirect
						self.bucky.timer.stop('loggedInCallback');
						self.bucky.flush();
						qString.addCb().goTo();
					});
				}
			} else if (resp.loginAborted) {
				window.GlobalNotification.show(resp.errorMsg, 'error');

			// user not logged in, show the login/signup modal
			} else {
				self.bucky.timer.start('loggedOutCallback');
				require(['wikia.ui.factory'], function (uiFactory) {
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
								title: resp.title,
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
							var form,
								wikiaForm,
								signupAjaxForm,
								$modal = facebookSignupModal.$element;

							self.modal = facebookSignupModal; // set reference to modal object

							// Track Facebook Connect Modal Close
							facebookSignupModal.bind('beforeClose', function () {
								// Track FB Connect Modal Close
								self.track({
									action: self.actions.CLOSE,
									label: 'facebook-login-modal'
								});
							});

							self.form = new window.UserLoginFacebookForm($modal, {
								ajaxLogin: true,
								callback: function (res) {
									// Track FB Connect Sign Up
									self.track({
										action: self.actions.SUBMIT,
										label: 'facebook-login-modal'
									});
									var location = res.location;

									// redirect to the user page
									if (loginCallback && typeof loginCallback === 'function') {
										loginCallback();
									} else if (location) {
										window.location.href = location;
									}
								}
							});
							form = self.form; // cache in local variables

							self.wikiaForm = form.wikiaForm; // re-reference for convinience
							wikiaForm = self.wikiaForm; // cache in local variables

							self.signupAjaxForm = new window.UserSignupAjaxForm(
								wikiaForm,
								null,
								form.el.find('input[type=submit]')
							);
							signupAjaxForm = self.signupAjaxForm; // cache in local variables

							// attach handlers to modal content
							$modal
								.on('click', '.FacebookSignupConfigHeader', function (event) {
									event.preventDefault();
									$(this).toggleClass('on').next('form').toggle();
								})
								.on('blur', 'input[name=username], input[name=password]',
									$.proxy(signupAjaxForm.validateInput, signupAjaxForm)
							)
								.on('click', '.submit-pane .extiw', function (event) {
									require(['wikia.tracker'], function (tracker) {
										tracker.track({
											action: tracker.ACTIONS.CLICK_LINK_TEXT,
											browserEvent: event,
											category: 'user-sign-up',
											href: $(event.target).attr('href'),
											label: 'wikia-terms-of-use',
											trackingMethod: 'both'
										});
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
				});
			}
		},

		closeSignupModal: function () {
			var modal = this.modal;

			if (modal) {
				modal.trigger('close');
			}
		}
	};

	window.UserLoginFacebook = UserLoginFacebook;
})();
