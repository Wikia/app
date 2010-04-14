/*
 * Author: Inez Korczynski
 */

if(typeof wgEnableAjaxLogin != 'undefined' && wgEnableAjaxLogin) {

	
	
	YAHOO.namespace("wikia.AjaxLogin");

	(function() {

	var Dom = YAHOO.util.Dom;
	var Event = YAHOO.util.Event;
	var DDM = YAHOO.util.DragDropMgr;

	YAHOO.wikia.AjaxLogin = {
		init: function() {
			if(Dom.get('userloginRound')) {
				Event.addListener('login', 'click', YAHOO.wikia.AjaxLogin.showLoginPanel);
			}
		},
		showLoginPanel: function(e) {
			// Prevent the default action for clicked element (probably A)
			if(e) {
				YAHOO.util.Event.preventDefault(e);
			}

			if(YAHOO.lang.isUndefined(YAHOO.wikia.AjaxLogin.loginPanel)) {

				var keylistenerHandler = function(type, args, obj) {
					YAHOO.wikia.AjaxLogin.loginPanel.hide();
				}

				YAHOO.wikia.AjaxLogin.keylistener = new YAHOO.util.KeyListener(document, { keys:[27] }, { fn:keylistenerHandler } );

				YAHOO.log("Initiate and display loginPanel", "info", "AjaxLogin.js");
				YAHOO.wikia.AjaxLogin.loginPanel = new YAHOO.widget.Panel('userloginRound',
				{
					width:"auto",
					modal:true,
					constraintoviewport:true,
					draggable: false,
					fixedcenter: true,
					underlay: "none",
					visible: true,
					keylisteners: YAHOO.wikia.AjaxLogin.keylistener
				});
				Dom.setStyle('userloginRound', 'display', '');
				YAHOO.wikia.AjaxLogin.loginPanel.render(document.body);

				// add submit event handler for login form
				Event.addListener('userajaxloginform', 'submit', YAHOO.wikia.AjaxLogin.formSubmitHandler);

				Event.addListener('wpAjaxRegister', 'click', YAHOO.wikia.AjaxLogin.ajaxRegisterConfirm);
			} else {
				YAHOO.log("Display initiated loginPanel", "info", "AjaxLogin.js");
				YAHOO.wikia.AjaxLogin.loginPanel.show();
			}
			if(Dom.get('wpName1')) {
				Dom.get('wpName1').focus();
			}
		},
		formSubmitHandler: function(e) {
			// Prevent the default action for event (submit of form)
			if(e) {
				YAHOO.util.Event.preventDefault(e);
			}

			var ajaxLoginCallback = {
				success: YAHOO.wikia.AjaxLogin.handleSuccess,
				failure: YAHOO.wikia.AjaxLogin.handleFailure,
				scope: YAHOO.wikia.AjaxLogin
			};

			YAHOO.util.Connect.setForm('userajaxloginform');

			// Let's block login form (disable buttons and input boxes)
			YAHOO.wikia.AjaxLogin.blockLoginForm(true);

			var actionURL = wgServer + wgScriptPath + '/api.php?action=ajaxlogin&format=json';
			var cObj = YAHOO.util.Connect.asyncRequest('POST', actionURL, ajaxLoginCallback);
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
			if(!YAHOO.lang.isBoolean(block)) {
				YAHOO.log("YAHOO.wikia.AjaxLogin.blockLoginForm was called with parameter which is not boolean", "error", "AjaxLogin.js");
				return;
			}
			if(Dom.get('wpName1'))
				Dom.get('wpName1').disabled = block;
			if(Dom.get('wpPassword1'))
				Dom.get('wpPassword1').disabled = block;
			if(Dom.get('wpLoginattempt'))
				Dom.get('wpLoginattempt').disabled = block;
			if(Dom.get('wpRemember'))
				Dom.get('wpRemember').disabled = block;
			if(Dom.get('wpMailmypassword'))
				Dom.get('wpMailmypassword').disabled = block;
		},
		ajaxRegisterConfirm: function(e) {
			if(Dom.get('wpPreview') && Dom.get('wpLogin')) {
				if(typeof(ajaxLogin2)!="undefined" && !confirm(ajaxLogin2)) {
					YAHOO.util.Event.preventDefault(e);
				}
			}
		}
	}

	Event.onDOMReady(YAHOO.wikia.AjaxLogin.init, YAHOO.wikia.AjaxLogin, true);

	})();
}