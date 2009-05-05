/*
 * Author: Maciej Brencz (based on code from Inez Korczynski)
 */
AjaxLogin = {
	init: function(form) {
		this.form = form;

		// add submit event handler for login form
		this.form.submit(AjaxLogin.formSubmitHandler);
	},
	formSubmitHandler: function(ev) {
		// Prevent the default action for event (submit of form)
		if(ev) {
			ev.preventDefault();
		}
		// Let's block login form (disable buttons and input boxes)
		AjaxLogin.blockLoginForm(true);

		var actionURL = window.wgScriptPath + '/api.php?action=ajaxlogin&format=json';
	},
	handleSuccess: function(o) {
		var response = YAHOO.Tools.JSONParse(o.responseText);
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
				if(wgCanonicalNamespace == 'Special' && wgCanonicalSpecialPageName == 'RequestWiki') {
					Event.removeListener('pSubmit', 'click', YAHOO.wikia.AjaxLogin.showLoginPanel);
					Dom.get('pSubmit').click();
				} else if(Dom.get('wpPreview') && Dom.get('wpLogin')) {
					if (Dom.get('wikiDiff') && (Dom.get('wikiDiff').childNodes.length > 0)) {
						Dom.get('wpDiff').click();
					} else {
						if (Dom.get('wikiPreview') && Dom.get('wikiPreview').childNodes.length == 0) {
							Dom.get('wpLogin').value = 1;
						}
						Dom.get('wpPreview').click();
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
				this.blockLoginForm(false);
				Dom.get('wpName1').value = '';
				Dom.get('wpPassword1').value = '';
				Dom.get('wpName1').focus();
			case 'WrongPass':
				this.blockLoginForm(false);
				Dom.get('wpPassword1').value = '';
				Dom.get('wpPassword1').focus();
			default:
				this.blockLoginForm(false);
				this.displayReason(response.ajaxlogin.text);
				break;
		}
	},
	handleFailure: function() {
		YAHOO.log("YAHOO.wikia.AjaxLogin.handleFailure was called", "error", "AjaxLogin.js");
	},
	displayReason: function(reason) {
		Dom.setStyle('wpError', 'display', '');
		Dom.get('wpError').innerHTML = reason + '<br/><br/>';
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
