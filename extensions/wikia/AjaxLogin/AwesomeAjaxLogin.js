/*
 * Author: Maciej Brencz (based on code from Inez Korczynski)
 */
AjaxLogin = {
	init: function(form) {
		this.form = form;

		// add submit event handler for login form
		this.form.submit(AjaxLogin.formSubmitHandler).log('AjaxLogin: init()');
	},
	formSubmitHandler: function(ev) {
		// Prevent the default action for event (submit of form)
		if(ev) {
			ev.preventDefault();
		}
		// Let's block login form (disable buttons and input boxes)
		AjaxLogin.blockLoginForm(true);

		var params = [
			'action=ajaxlogin',
			'format=json',
			'wpLoginattempt=1',
			'wpName=' + encodeURIComponent(AjaxLogin.form.find('#wpName1').attr('value')),
			'wpPassword=' + encodeURIComponent(AjaxLogin.form.find('#wpPassword1').attr('value')),
			'wpRemember=' + (AjaxLogin.form.find('#wpRemember1').attr('checked') ? 1 : 0)
		];

		$.getJSON(window.wgScriptPath + '/api.php?' + params.join('&'), AjaxLogin.handleSuccess);
	},
	handleSuccess: function(response) {
		var responseResult = response.ajaxlogin.result;
		switch(responseResult) {
			case 'Reset':
				if(Dom.get('wpPreview') && Dom.get('wpLogin')) {
					if(typeof(ajaxLogin1)!="undefined" && !confirm(ajaxLogin1)) {
						break;
					}
				}
				Dom.get('userajaxloginform').action = wgServer + wgScriptPath + '/index.php?title=Special:Userlogin&action=submitlogin&type=login';
				Event.removeListener('userajaxloginform', 'submit', YAHOO.wikia.AjaxLogin.formSubmitHandler);
				YAHOO.wikia.AjaxLogin.blockLoginForm(false);
				Dom.get('userajaxloginform').submit();
				YAHOO.wikia.AjaxLogin.blockLoginForm(true);
				break;
			case 'Success':
				// we're on edit page
				if($('#wpPreview').length && $('#wpLogin').length) {
					if ($('#wikiDiff').children().length) {
						$('#wpDiff').click();
					} else {
						if ($('#wikiPreview').children().length == 0) {
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
				AjaxLogin.form.find('#wpPassword1').attr('value', '');
				AjaxLogin.form.find('#wpName1').attr('value', '').focus();
			case 'WrongPass':
				AjaxLogin.blockLoginForm(false);
				AjaxLogin.form.find('#wpPassword1').attr('value', '').focus();
			default:
				AjaxLogin.blockLoginForm(false);
				AjaxLogin.displayReason(response.ajaxlogin.text);
				break;
		}
	},
	handleFailure: function() {
		AjaxLogin.form.log("YAHOO.wikia.AjaxLogin.handleFailure was called");
	},
	displayReason: function(reason) {
		AjaxLogin.form.find('#wpError').css('display', '').html(reason + '<br/><br/>');
	},
	blockLoginForm: function(block) {
		this.form.find('input').attr('disabled', (block ? true : false));
	},
	ajaxRegisterConfirm: function(e) {
		if(Dom.get('wpPreview') && Dom.get('wpLogin')) {
			if(typeof(ajaxLogin2)!="undefined" && !confirm(ajaxLogin2)) {
				YAHOO.util.Event.preventDefault(e);
			}
		}
	}
}
