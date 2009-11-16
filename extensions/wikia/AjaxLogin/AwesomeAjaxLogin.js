/*
 * Author: Maciej Brencz (based on code from Inez Korczynski)
 */
var AjaxLogin = {
	init: function(form) {
		this.form = form;

		// move login/password/remember fields from hidden form to AjaxLogin
		var labels = this.form.find('label');
		$('#wpName1Ajax').appendTo("#ajaxlogin_username_cell");
		$('#wpPassword1Ajax').appendTo("#ajaxlogin_password_cell");
		$('#wpRemember1Ajax').insertBefore(labels[2]);

		// remove hidden form
		$('#userajaxloginform').remove();

		this.form.attr('id', 'userajaxloginform');

		// add submit event handler for login form
		this.form.bind('submit', this.formSubmitHandler);

		$().log('AjaxLogin: init()');

		// ask before going to register form from edit page
		$('#wpAjaxRegister').click(this.ajaxRegisterConfirm);
	},
	formSubmitHandler: function(ev) {
		// Prevent the default action for event (submit of form)
		if(ev) {
			ev.preventDefault();
		}
		AjaxLogin.form.log('AjaxLogin: selected action = '+ AjaxLogin.action);

		// tracking
		WET.byStr('loginActions/' + AjaxLogin.action);

		var params = [
			'action=ajaxlogin',
			'format=json',
			(AjaxLogin.action == 'password' ? 'wpMailmypassword=1' : 'wpLoginattempt=1'),

			// serialize form fields
			AjaxLogin.form.serialize()
		];

		// Let's block login form (disable buttons and input boxes)
		AjaxLogin.blockLoginForm(true);

		$.postJSON(window.wgScriptPath + '/api.php?' + params.join('&'), function(response) {
					var responseResult = response.ajaxlogin.result;
					switch(responseResult) {
					case 'Reset':
					// password reset

					// we're on edit page
					if($('#wpPreview').exists() && $('#wpLogin').exists()) {
					if(typeof(ajaxLogin1)!="undefined" && !confirm(ajaxLogin1)) {
					break;
					}
					}

					// change the action of the AjaxLogin form
					$('#userajaxloginform').attr('action', wgServer + wgScriptPath + '/index.php?title=Special:Userlogin&action=submitlogin&type=login');

					// remove AJAX functionality from login form
					AjaxLogin.form.unbind('submit', this.formSubmitHandler);

					// unblock and submit the form
					AjaxLogin.blockLoginForm(false);
					$('#userajaxloginform').submit();
					break;

					case 'Success':
					// macbre: call custom function (if provided by any extension)
					if (typeof window.wgAjaxLoginOnSuccess == 'function') {
						// let's update wgUserName
						window.wgUserName = response.ajaxlogin.lgusername;

						// close AjaxLogin form
						$('#AjaxLoginBoxWrapper').closeModal();

						$().log('AjaxLogin: calling custom function');
						window.wgAjaxLoginOnSuccess();
						return;
					}

					// we're on edit page
					if($('#wpPreview').exists() && $('#wpLogin').exists()) {
						if ($('#wikiDiff').children().exists()) {
							$('#wpDiff').click();
						} else {
							if (!$('#wikiPreview').children().exists()) {
								$('#wpLogin').attr('value', 1);
							}
							$('#wpPreview').click();
						}
					} else {
						if(wgCanonicalSpecialPageName == "Userlogout") {
							window.location.href = wgServer + wgScriptPath;
						} else {
							window.location.reload(true);
						}
					}
					break;

					case 'NotExists':
					AjaxLogin.blockLoginForm(false);
					$('#wpPassword1n').attr('value', '');
					$('#wpName1').attr('value', '').focus();

					case 'WrongPass':
					AjaxLogin.blockLoginForm(false);
					$('#wpPassword1').attr('value', '').focus();

					default:
					AjaxLogin.blockLoginForm(false);
					AjaxLogin.displayReason(response.ajaxlogin.text);
					break;
				}
		});
	},
	handleFailure: function() {
		AjaxLogin.form.log('AjaxLogin: handleFailure was called');
	},
	displayReason: function(reason) {
		$('#wpError').css('display', '').html(reason + '<br/><br/>');
	},
	blockLoginForm: function(block) {
		AjaxLogin.form.find('input').attr('disabled', (block ? true : false));
	},
	ajaxRegisterConfirm: function(ev) {
		AjaxLogin.form.log('AjaxLogin: ajaxRegisterConfirm()');
        	
		if($('#wpPreview').exists() && $('#wpLogin').exists()) {
			if(typeof(ajaxLogin2)!="undefined" && !confirm(ajaxLogin2)) {
				ev.preventDefault();
			}
		}
		WET.byStr('signupActions/popup/switchtocreateaccount');
	}
};
