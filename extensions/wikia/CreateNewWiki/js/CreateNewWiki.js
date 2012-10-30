/*global UserLoginFacebook: true, UserLoginAjaxForm: true, WikiBuilderCfg: true */
var WikiBuilder = {
	registerInit: false,
	wntimer: false,
	wdtimer: false,
	createStatus: false,
	createStatusMessage: false,
	themestate: false,
	cityId: false,
	finishCreateUrl: false,
	retryGoto: 0,
	nameAjax: false,
	domainAjax: false,
	init: function() {
		// pre-cache
		WikiBuilder.wb = $('#CreateNewWiki');
		WikiBuilder.steps = $('#CreateNewWiki .steps .step');
		WikiBuilder.loginEntities = $('#Auth .login-msg, #Auth .signup');
		WikiBuilder.signupEntities = $('#Auth .signup-msg, #Auth .login');
		WikiBuilder.wikiName = $('#NameWiki input[name=wiki-name]');
		WikiBuilder.wikiNameStatus = $('#NameWiki .wiki-name-status-icon');
		WikiBuilder.wikiNameError = $('#NameWiki .wiki-name-error');
		WikiBuilder.wikiDomain = $('#NameWiki input[name=wiki-domain]');
		WikiBuilder.wikiDomainError = $('#NameWiki .wiki-domain-error');
		WikiBuilder.wikiDomainStatus = $('#NameWiki .domain-status-icon');
		WikiBuilder.wikiDomainCountry = $('#NameWiki .domain-country');
		WikiBuilder.nameWikiSubmitError = $('#NameWiki .submit-error');
		WikiBuilder.wikiLanguage = $('#NameWiki select[name=wiki-language]');
		WikiBuilder.wikiCategory = $('#DescWiki select[name=wiki-category]');
		WikiBuilder.descWikiSubmitError = $('#DescWiki .submit-error');
		WikiBuilder.nextButtons = WikiBuilder.wb.find('nav .next');
		WikiBuilder.finishSpinner = $('#CreateNewWiki .finish-status');
		WikiBuilder.descWikiNext = $('#DescWiki nav .next');

		$('#SignupRedirect').submit(function(e){
			var queryString = 'wikiName=' + WikiBuilder.wikiName.val() +
				'&wikiDomain=' + WikiBuilder.wikiDomain.val() +
				'&uselang=' + WikiBuilder.wikiLanguage.find('option:selected').val();
			$().log(queryString);
			$('#SignupRedirect input[name=returnto]').val(queryString);
		});

		// Name Wiki event handlers
		this.checkNextButtonStep1();

		$('#NameWiki input.next').click(function() {
			if (WikiBuilder.isNameWikiSubmitError()) {
				WikiBuilder.nameWikiSubmitError.
					show().
					html(WikiBuilderCfg['name-wiki-submit-error']).
					delay(3000).
					fadeOut();
			} else {
				WikiBuilder.saveState({
					wikiName: WikiBuilder.wikiName.val(),
					wikiDomain: WikiBuilder.wikiDomain.val(),
					wikiLang: WikiBuilder.wikiLanguage.find('option:selected').val()
				});
				if ($('#Auth').length) {
					//AjaxLogin.init($('#AjaxLoginLoginForm form:first'));
					WikiBuilder.handleRegister();
				} else if($('#UserAuth').length) {
					// Init user auth
					WikiBuilder.userAuth = {
						el:$('#UserAuth'),
						loginAjaxForm: new UserLoginAjaxForm('#UserAuth .UserLoginModal', {
							ajaxLogin: true,
							callback: function(json) {
								WikiBuilder.transition('UserAuth', true, '+');
							}
						})
					};
					UserLoginFacebook.callbacks['login-success'] = function() {
						WikiBuilder.transition('UserAuth', true, '+');
						UserLoginFacebook.closeSignupModal();
					};
				}
				if(onFBloaded) {  // FB hax
					onFBloaded();
				}
				WikiBuilder.transition('NameWiki', true, '+');
			}
		});
		WikiBuilder.wikiDomain.keyup(function() {
			WikiBuilder.domainAjax = true;
			WikiBuilder.checkNextButtonStep1();
			if(WikiBuilder.wdtimer) {
				clearTimeout(WikiBuilder.wdtimer);
			}
			WikiBuilder.wdtimer = setTimeout(WikiBuilder.checkDomain, 500);
		});
		WikiBuilder.wikiName.keyup(function() {
			WikiBuilder.nameAjax = true;
			WikiBuilder.checkNextButtonStep1();
			var name = $(this).val();
			name = $.trim(name.replace(/[^a-zA-Z0-9 ]+/g, '')).replace(/ +/g, '-');
			WikiBuilder.wikiDomain.val(name.toLowerCase()).trigger('keyup');
			if(WikiBuilder.wntimer) {
				clearTimeout(WikiBuilder.wntimer);
			}
			WikiBuilder.wntimer = setTimeout(WikiBuilder.checkWikiName, 500);
		});
		WikiBuilder.wikiLanguage.bind('change', function () {
			WikiBuilder.checkWikiName();
			WikiBuilder.checkDomain();
			var selected = WikiBuilder.wikiLanguage.find('option:selected').val();
			WikiBuilder.wikiDomainCountry.html((selected && selected !== 'en') ? selected + '.' : '');
		});
		$('#ChangeLang').click(function(e) {
			e.preventDefault();
			$('#NameWiki .language-default').hide();
			$('#NameWiki .language-choice').show();
		});
		$('#CreateNewWiki nav .back').bind('click', function() {
			var id = $(this).closest('.step').attr('id');
			if (id === 'DescWiki') {
				WikiBuilder.transition('DescWiki', false, '-');
				if ($('#Auth').length) {
					//AjaxLogin.init($('#AjaxLoginLoginForm form:first'));
					WikiBuilder.handleRegister();
				} else if($('#UserAuth').length) {
					WikiBuilder.userAuth.loginAjaxForm.retrieveLoginToken({clearCache:true});
					WikiBuilder.userAuth.loginAjaxForm.submitButton.removeAttr('disabled');
				}
			} else {
				WikiBuilder.transition(id, false, '-');
			}
		});

		// Login/Signup event handlers
		$('#Auth .signup-msg a').click(function() {
			WikiBuilder.handleRegister();
		});
		$('#Auth .login-msg a').click(function() {
			WikiBuilder.handleLogin();
		});
		$('#Auth nav input.login').click(function(e) {
			AjaxLogin.form.submit();
		});

		// Description event handlers
		WikiBuilder.descWikiNext.click(function() {
			WikiBuilder.descWikiNext.attr('disabled', true);
			var val = WikiBuilder.wikiCategory.find('option:selected').val();
			if(val) {
				$.nirvana.sendRequest({
					controller: 'CreateNewWiki',
					method: 'Phalanx',
					data: {
						text: $('#Description').val()
					},
					callback: function(res) {
						// check phalanx result
						if (res.msgHeader) {
							$.showModal(res.msgHeader, res.msgBody);
							WikiBuilder.descWikiNext.attr('disabled', false);
						} else {
							// call create wiki ajax
							WikiBuilder.saveState({
								wikiDescription: ($('#Description').val() == WikiBuilderCfg.descriptionplaceholder ? '' : $('#Description').val())
							}, function() {
								WikiBuilder.createWiki();
								WikiBuilder.transition('DescWiki', true, '+');
							});
						}
					}
				});
			} else {
				WikiBuilder.descWikiSubmitError.show().html(WikiBuilderCfg['desc-wiki-submit-error']).delay(3000).fadeOut();
				WikiBuilder.descWikiNext.attr('disabled', false);
			}
		});
		$('#Description').placeholder();

		// Theme event handlers
		$('#ThemeWiki nav .next').click(function() {
			WikiBuilder.saveState(ThemeDesigner.settings, function(){
				if(WikiBuilderCfg.skipwikiaplus) {
					WikiBuilder.gotoMainPage();
				} else {
					WikiBuilder.transition('ThemeWiki', true, '+');
				}
			});
		});

		// Set current step on page load
		if(WikiBuilderCfg['currentstep']) {
			var pane = $('#' + WikiBuilderCfg.currentstep);
			WikiBuilder.wb.width(pane.width());
			WikiBuilder.steps.hide();
			pane.show();
		}

		// onload stuff
		WikiBuilder.wikiName.focus();
		if(WikiBuilder.wikiName.val() || WikiBuilder.wikiDomain.val()) {
			WikiBuilder.checkDomain();
			WikiBuilder.checkName();
		}
	},

	requestKeys: function() {
		WikiBuilder.keys = WikiBuilderCfg['cnw-keys'];
	},

	solveKeys: function() {
		var v = 0,
			i;
		for(i = 0; i < WikiBuilder.keys.length; i++) {
			v *= (i % 5) + 1;
			v += WikiBuilder.keys[i];
		}
		WikiBuilder.answer = v;
	},

	handleRegister: function() {
		AjaxLogin.showRegister();
		$('#wpRemember').attr('checked', 'true').hide().siblings().hide();
		if(!WikiBuilder.registerInit) {
			$.getScript(window.wgScript + '?action=ajax&rs=getRegisterJS&uselang=' + window.wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion,
				function() {
					$('#Auth nav input.signup').click(function(){
						UserRegistration.submitForm2('normal');
					});
			});
		}
		$('#Auth, #CreateNewWiki').width(700);
		WikiBuilder.signupEntities.hide();
		WikiBuilder.loginEntities.show();
	},

	handleLogin: function() {
		AjaxLogin.showLogin();
		AjaxLogin.init($('#AjaxLoginLoginForm form:first'));
		$('#Auth, #CreateNewWiki').width(600);
		WikiBuilder.signupEntities.show();
		WikiBuilder.loginEntities.hide();
	},

	checkWikiName: function(e) {
		var name = WikiBuilder.wikiName.val();
		var lang = WikiBuilder.wikiLanguage.val();
		if(name) {
			WikiBuilder.nameAjax = true;
			WikiBuilder.checkNextButtonStep1();

			$.nirvana.sendRequest({
				controller: 'CreateNewWiki',
				method: 'CheckWikiName',
				data: {
					name: name,
					lang: lang
				},
				callback: function(res) {
					if(res) {
						var response = res['res'];
						if(response) {
							WikiBuilder.wikiNameError.html(response);
						} else {
							WikiBuilder.wikiNameError.html('');
						}
						WikiBuilder.nameAjax = false;
						WikiBuilder.checkNextButtonStep1();
					}
				}
			});
		} else {
			WikiBuilder.showIcon(WikiBuilder.wikiNameStatus, '');
			WikiBuilder.wikiNameError.html('');
		}
	},

	checkDomain: function(e) {
		var wd = WikiBuilder.wikiDomain.val();
		var lang = WikiBuilder.wikiLanguage.val();
		if(wd) {
			wd = wd.toLowerCase();
			WikiBuilder.wikiDomain.val(wd);
			WikiBuilder.showIcon(WikiBuilder.wikiDomainStatus, 'spinner');
			WikiBuilder.domainAjax = true;
			WikiBuilder.checkNextButtonStep1();
			$.nirvana.sendRequest({
				controller: 'CreateNewWiki',
				method: 'CheckDomain',
				data: {
					name: wd,
					lang: lang,
					type: ''
				},
				callback: function(res) {
					if(res) {
						var response = res['res'];
						if(response) {
							WikiBuilder.wikiDomainError.html(response);
							WikiBuilder.showIcon(WikiBuilder.wikiDomainStatus, '');
						} else {
							WikiBuilder.wikiDomainError.html('');
							WikiBuilder.showIcon(WikiBuilder.wikiDomainStatus, 'ok');
						}
						WikiBuilder.domainAjax = false;
						WikiBuilder.checkNextButtonStep1();
					}
				}
			});
		} else {
			WikiBuilder.wikiDomainError.html('');
			WikiBuilder.showIcon(WikiBuilder.wikiDomainStatus, '');
		}
	},

	isNameWikiSubmitError: function() {
		return !this.wikiDomain.val() ||
			!this.wikiName.val() ||
			$('#NameWiki .wiki-name-error').html() ||
			$('#NameWiki .wiki-domain-error').html() ||
			this.nameAjax ||
			this.domainAjax;
	},

	/**
	 * Update the state of "Next" button on step #1.
	 * It depends on two AJAX validation requests which are performed in parallel.
	 *
	 * This method is used solely by automated tests (enabled class is added when test can proceed to the next step)
	 */
	checkNextButtonStep1: function() {
		var nextButton = this.nextButtons.eq(0);

		if (this.isNameWikiSubmitError()) {
			nextButton.removeClass('enabled');
		}
		else {
			nextButton.addClass('enabled');
		}
	},

	showIcon: function (el, art) {
		if(art) {
			var markup = '<img src="';
			if(art == 'spinner') {
				markup += window.stylepath + '/common/images/ajax.gif';
			} else if (art == 'ok') {
				markup += window.wgExtensionsPath + '/wikia/CreateNewWiki/images/check.png';
			}
			markup += '">';
			$(el).html(markup);
		} else {
			$(el).html('');
		}
	},

	transition: function (from, next, dot) {
		var f = $('#' + from);
		var t = (next ? f.next() : f.prev());
		var wb = WikiBuilder.wb;
		var fh = f.height();
		var fw = f.width();
		var op = t.css('position');
		t.css('position', 'absolute');
		var th = t.height();
		var tw = t.width();
		t.css('position', op);
//		wb.height(fh).width(fw);
		wb.animate({height: th, width: tw}, function(){
			t.animate({'opacity':'show'},{queue:false, duration: 250});
			if (dot) {
				if (dot === '+') {
					$('#StepsIndicator .step.active').last().next().addClass('active');
				} else if (dot === '-') {
					$('#StepsIndicator .step.active').last().removeClass('active');
				}
			}
			wb.height('auto');
		});
		f.animate({'opacity':'hide'},{queue:false, duration: 250});

	},

	saveState: function (data, callback) {
		var c = JSON.parse($.cookies.get('createnewwiki'));
		if (!c) {
			c = {};
		}
		for(var key in data) {
			c[key] = data[key];
		}
		$.cookies.set('createnewwiki', JSON.stringify(c), {hoursToLive: 0, domain: wgCookieDomain, path: wgCookiePath});
		if(callback) {
			callback();
		}
	},

	gotoMainPage: function() {
		WikiBuilder.nextButtons.attr('disabled', true);
		if(WikiBuilder.createStatus && WikiBuilder.createStatus == 'ok' && WikiBuilder.finishCreateUrl) {
			location.href = WikiBuilder.finishCreateUrl;
		} else if(WikiBuilder.createStatus && WikiBuilder.createStatus == 'backenderror') {
			$.showModal(WikiBuilder.createStatusMessage, WikiBuilder.createStatusMessage);
		} else if (WikiBuilder.retryGoto < 300) {
			if(!WikiBuilder.finishSpinner.data('spinning')) {
				WikiBuilder.finishSpinner.data('spinning', 'true');
				WikiBuilder.showIcon(WikiBuilder.finishSpinner, 'spinner');
			}
			WikiBuilder.retryGoto++;
			setTimeout(WikiBuilder.gotoMainPage, 200);
		}
	},

	createWiki: function() {
		WikiBuilder.requestKeys();
		WikiBuilder.solveKeys();
		$.nirvana.sendRequest({
			controller: 'CreateNewWiki',
			method: 'CreateWiki',
			data: {
				data: {
					wName: WikiBuilder.wikiName.val(),
					wDomain: WikiBuilder.wikiDomain.val(),
					wLanguage: WikiBuilder.wikiLanguage.find('option:selected').val(),
					wCategory: WikiBuilder.wikiCategory.find('option:selected').val(),
					wAnswer: Math.floor(WikiBuilder.answer)
				}
			},
			callback: function(res) {
				WikiBuilder.createStatus = res.status;
				WikiBuilder.createStatusMessage = res.statusMsg;
				if(WikiBuilder.createStatus && WikiBuilder.createStatus == 'ok') {
					WikiBuilder.cityId = res.cityId;
					WikiBuilder.finishCreateUrl = (res.finishCreateUrl.indexOf('.com/wiki/') < 0 ? res.finishCreateUrl.replace('.com/','.com/wiki/') : res.finishCreateUrl);

					// unblock "Next" button (BugId:51519)
					$('#ThemeWiki .next-controls input').
						attr('disabled', false).
						addClass('enabled'); // for QA with love
				} else {
					$.showModal(res.statusHeader, WikiBuilder.createStatusMessage);
				}
			},
			onErrorCallback: function() {
				WikiBuilder.generateAjaxErrorMsg();
			}
		});
	},

	generateAjaxErrorMsg: function() {
		$.showModal(WikiBuilderCfg['cnw-error-general-heading'], WikiBuilderCfg['cnw-error-general']);
	}
}

var isAutoCreateWiki = true;

// global fix this spelling later...
function realoadAutoCreateForm() {
	if('undefined' != typeof AjaxLogin.form) {
		AjaxLogin.blockLoginForm(false);
	}
	WikiBuilder.transition('Auth', true, '+');
}

function sendToConnectOnLogin() {
	wgPageQuery += encodeURIComponent('&fbreturn=1');
	sendToConnectOnLoginForSpecificForm("");
}

$(function() {
	wgAjaxPath = wgScriptPath + wgScript;
	WikiBuilder.init();
	$('#AjaxLoginButtons').hide();
	$('#AjaxLoginLoginForm').show();

	ThemeDesigner.slideByDefaultWidth = 608;
	ThemeDesigner.slideByItems = 4;
	ThemeDesigner.themeTabInit();
});
