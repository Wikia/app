var UserLoginModal = {
	loginAjaxForm: false,
	isInitializationStarted: false,
	$modal: false,

	initModal: function(options) {
		'use strict';
		$.when(
			Wikia.getMultiTypePackage({
				templates: [{
					controller: 'UserLoginSpecial',
					method: 'modal',
					params: {uselang: window.wgUserLanguage}
				}],
				styles: '/extensions/wikia/UserLogin/css/UserLoginModal.scss',
				messages: 'UserLogin'
			})
		).done(function(packagesData){
			require(['wikia.ui.factory', 'wikia.loader'], function(uiFactory, loader) {
				loader.processStyle(packagesData.styles);
				uiFactory.init('modal').then(function(elem){
					$('body').append(elem.render({
						type:'default',
						vars: {
							id: 'userForceLoginModal',
							size: 'medium',
							content: packagesData.templates.UserLoginSpecial_modal,
							title: $.msg('userlogin-login-heading'),
							closeButton: true
						}
					}));
					require(['wikia.ui.modal'], function(modal){
						UserLoginModal.$modal = modal.init('userForceLoginModal');

						UserLoginModal.loginAjaxForm = new UserLoginAjaxForm(UserLoginModal.$modal.$element, {
							ajaxLogin: true,
							callback: function(res) {
								window.wgUserName = res.username;
								var callback = options.callback;
								if(callback && typeof callback === 'function') {
									if(!options.persistModal) {
										UserLoginModal.$modal.hide();
									}
									callback();
								} else {
									UserLoginModal.loginAjaxForm.reloadPage();
								}
							},
							resetpasscallback: function() {
								$.nirvana.sendRequest({
									controller: 'UserLoginSpecial',
									method: 'changePassword',
									format: 'html',
									data: {
										username: UserLoginModal.loginAjaxForm.inputs.username.val(),
										password: UserLoginModal.loginAjaxForm.inputs.password.val(),
										returnto: UserLoginModal.loginAjaxForm.inputs.returnto.val(),
										fakeGet: 1
									},
									callback: function(html) {
										var content = $('<div style="display:none" />').append(html),
											heading = content.find('h1'),
											contentBlock = UserLoginModal.$modal.$element.find('.UserLoginModal');

										UserLoginModal.$modal.$element.find('h1').text(heading.text());
										heading.remove();

										contentBlock.slideUp(400, function() {
											contentBlock.html('').html(content);
											content.show();
											contentBlock.slideDown(400);
										});
									}
								});
							}
						});
						UserLoginFacebook.init();

						if (options.modalInitCallback && typeof options.modalInitCallback === 'function') {
							options.modalInitCallback();
						}
					});
				});
			});
		});
	},
	showModal:function() {

	},

	/**
	 * options (optional):
	 *  callback: callback after login successful login
	 * returns: true if modal is shown, false if it is not
	 */
	show: function(options) {
		'use strict';
		
		if (!window.wgComboAjaxLogin && window.wgEnableUserLoginExt) {
			options = options || {};

			var openModal = $.proxy(function(){ this.$modal.show(); }, this);
			if (this.$modal) {
				openModal();
			} else {
				if ( !this.isInitializationStarted ) {
					this.isInitializationStarted = true;
					options.modalInitCallback = openModal;
					this.initModal(options);
				}
			}
			return true;
		} else if(window.wgComboAjaxLogin) {
			/* 1st, 2nd, 4th, and 5th vars in this method is not used outside of ajaxlogin itself*/
			showComboAjaxForPlaceHolder(false, false, function() {
				if(options['callback']) {
					AjaxLogin.doSuccess = options['callback'];
				}
			}, false, true);

			return true;
		}

		return false;
	},
	isPreventingForceLogin: function(element) {
		'use strict';
		if(!(element.closest('span').hasClass('drop')) && !(element.closest('ul').hasClass('WikiaMenuElement'))) {
			return false;
		}
		return true;
	},
	init: function() {
		'use strict';
		// attach event handler
		var editpromptable = $('#te-editanon, .loginToEditProtectedPage, .upphotoslogin');

		// add .editsection on wikis with anon editing disabled
		if ( window.wgDisableAnonymousEditing ) {
			editpromptable = editpromptable.add('.editsection');
		}

		editpromptable.click($.proxy(function(ev) {
			ev.stopPropagation(); // (BugId:34026) stop bubbling up when parent and child both have event listener.

			if(!this.isPreventingForceLogin($(ev.target)) && UserLogin.isForceLogIn()) {
				ev.preventDefault();
			}
		},this));

		//Attach DOM-Ready handlers
		$('body').delegate('.ajaxLogin', 'click', function(e) {
			UserLoginModal.show();
			e.preventDefault();
		});
	}
};

$(function() {
	'use strict';
	if ((typeof window.wgEnableUserLoginExt !== 'undefined') && window.wgEnableUserLoginExt ) {
		UserLoginModal.init();
	}
});
