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
	init: function(stringHelper) {
		// pre-cache
		this.wb = $('#CreateNewWiki');
		this.steps = $('#CreateNewWiki .steps .step');
		this.loginEntities = $('#Auth .login-msg, #Auth .signup');
		this.signupEntities = $('#Auth .signup-msg, #Auth .login');
		this.wikiName = $('#NameWiki input[name=wiki-name]');
		this.wikiNameStatus = $('#NameWiki .wiki-name-status-icon');
		this.wikiNameError = $('#NameWiki .wiki-name-error');
		this.wikiDomain = $('#NameWiki input[name=wiki-domain]');
		this.wikiDomainError = $('#NameWiki .wiki-domain-error');
		this.wikiDomainStatus = $('#NameWiki .domain-status-icon');
		this.wikiDomainCountry = $('#NameWiki .domain-country');
		this.nameWikiSubmitError = $('#NameWiki .submit-error');
		this.wikiLanguage = $('#NameWiki select[name=wiki-language]');
		this.wikiCategory = $('#DescWiki select[name=wiki-category]');
		this.wikiAllAges = $('#DescWiki input[name=all-ages]');
		this.descWikiSubmitError = $('#DescWiki .submit-error');
		this.nextButtons = this.wb.find('nav .next');
		this.finishSpinner = $('#CreateNewWiki .finish-status');
		this.descWikiNext = $('#DescWiki nav .next');

		var that = this;

		$('#SignupRedirect').submit(function(e){
			var queryString = 'wikiName=' + that.wikiName.val() +
				'&wikiDomain=' + that.wikiDomain.val() +
				'&uselang=' + that.wikiLanguage.find('option:selected').val();
			$().log(queryString);
			$('#SignupRedirect input[name=returnto]').val(queryString);
		});

		// Name Wiki event handlers
		this.checkNextButtonStep1();

		$('#NameWiki input.next').click(function() {
			if (that.isNameWikiSubmitError()) {
				that.nameWikiSubmitError.
					show().
					html(WikiBuilderCfg['name-wiki-submit-error']).
					delay(3000).
					fadeOut();
			} else {
				that.saveState({
					wikiName: that.wikiName.val(),
					wikiDomain: that.wikiDomain.val(),
					wikiLang: that.wikiLanguage.find('option:selected').val()
				});
				if ($('#Auth').length) {
					//AjaxLogin.init($('#AjaxLoginLoginForm form:first'));
					that.handleRegister();
				} else if($('#UserAuth').length) {
					// Init user auth
					that.userAuth = {
						el:$('#UserAuth'),
						loginAjaxForm: new UserLoginAjaxForm('#UserAuth .UserLoginModal', {
							ajaxLogin: true,
							callback: function(json) {
								that.transition('UserAuth', true, '+');
							}
						})
					};
					UserLoginFacebook.callbacks['login-success'] = function() {
						that.transition('UserAuth', true, '+');
						UserLoginFacebook.closeSignupModal();
					};
				}
				if(onFBloaded) {  // FB hax
					onFBloaded();
				}
				that.transition('NameWiki', true, '+');
			}
		});
		this.wikiDomain.keyup(function() {
			that.domainAjax = true;
			that.checkNextButtonStep1();
			if(that.wdtimer) {
				clearTimeout(that.wdtimer);
			}
			that.wdtimer = setTimeout($.proxy(that.checkDomain,that), 500);
		});
		this.wikiName.keyup(function() {
			that.nameAjax = true;
			that.checkNextButtonStep1();
			var name = $(this).val();
			name = $.trim(stringHelper.latinise(name).replace(/[^a-zA-Z0-9 ]+/g, '')).replace(/ +/g, '-');
			that.wikiDomain.val(name.toLowerCase()).trigger('keyup');
			if(that.wntimer) {
				clearTimeout(that.wntimer);
			}
			that.wntimer = setTimeout($.proxy(that.checkWikiName, that), 500);
		});
		this.wikiLanguage.bind('change', function () {
			that.checkWikiName();
			that.checkDomain();
			var selected = that.wikiLanguage.find('option:selected').val();
			that.wikiDomainCountry.html((selected && selected !== 'en') ? selected + '.' : '');
		});
		$('#ChangeLang').click(function(e) {
			e.preventDefault();
			$('#NameWiki .language-default').hide();
			$('#NameWiki .language-choice').show();
		});
		$('#CreateNewWiki nav .back').bind('click', function() {
			var id = $(this).closest('.step').attr('id');
			if (id === 'DescWiki') {
				that.transition('DescWiki', false, '-');
				if ($('#Auth').length) {
					//AjaxLogin.init($('#AjaxLoginLoginForm form:first'));
					that.handleRegister();
				} else if($('#UserAuth').length) {
					that.userAuth.loginAjaxForm.retrieveLoginToken({clearCache:true});
					that.userAuth.loginAjaxForm.submitButton.removeAttr('disabled');
				}
			} else {
				that.transition(id, false, '-');
			}
		});

		// Login/Signup event handlers
		$('#Auth .signup-msg a').click(function() {
			that.handleRegister();
		});
		$('#Auth .login-msg a').click(function() {
			that.handleLogin();
		});
		$('#Auth nav input.login').click(function(e) {
			AjaxLogin.form.submit();
		});

		// Description event handlers
		this.descWikiNext.click(function() {
			that.descWikiNext.attr('disabled', true);
			var val = that.wikiCategory.find('option:selected').val();
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
							that.descWikiNext.attr('disabled', false);
						} else {
							// call create wiki ajax
							that.saveState({
								wikiDescription: ($('#Description').val() == WikiBuilderCfg.descriptionplaceholder ? '' : $('#Description').val())
							}, function() {
								that.createWiki();
								that.transition('DescWiki', true, '+');
							});
						}
					}
				});
			} else {
				that.descWikiSubmitError.show().html(WikiBuilderCfg['desc-wiki-submit-error']).delay(3000).fadeOut();
				that.descWikiNext.attr('disabled', false);
			}
		});
		$('#Description').placeholder();

		// Theme event handlers
		$('#ThemeWiki nav .next').click(function() {
			that.saveState(ThemeDesigner.settings, function(){
				if(WikiBuilderCfg.skipwikiaplus) {
					that.gotoMainPage();
				} else {
					that.transition('ThemeWiki', true, '+');
				}
			});
		});

		// Set current step on page load
		if(WikiBuilderCfg['currentstep']) {
			var pane = $('#' + WikiBuilderCfg.currentstep);
			this.wb.width(pane.width());
			this.steps.hide();
			pane.show();
		}

		$('.tooltip-icon').tooltip();

		// onload stuff
		this.wikiName.focus();
		if(this.wikiName.val() || this.wikiDomain.val()) {
			this.checkDomain();
			this.checkWikiName();
		}
	},

	requestKeys: function() {
		this.keys = WikiBuilderCfg['cnw-keys'];
	},

	solveKeys: function() {
		var v = 0,
			i;
		for(i = 0; i < this.keys.length; i++) {
			v *= (i % 5) + 1;
			v += this.keys[i];
		}
		this.answer = v;
	},

	handleRegister: function() {
		AjaxLogin.showRegister();
		$('#wpRemember').attr('checked', 'true').hide().siblings().hide();
		if(!this.registerInit) {
			$.getScript(window.wgScript + '?action=ajax&rs=getRegisterJS&uselang=' + window.wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion,
				function() {
					$('#Auth nav input.signup').click(function(){
						UserRegistration.submitForm2('normal');
					});
			});
		}
		if ( !window.wgOasisResponsive ) {
			$('#Auth, #CreateNewWiki').width(700);
		}
		this.signupEntities.hide();
		this.loginEntities.show();
	},

	handleLogin: function() {
		AjaxLogin.showLogin();
		AjaxLogin.init($('#AjaxLoginLoginForm form:first'));
		if ( !window.wgOasisResponsive ) {
			$('#Auth, #CreateNewWiki').width(600);
		}
		this.signupEntities.show();
		this.loginEntities.hide();
	},

	checkWikiName: function(e) {
		var that = this,
			name = this.wikiName.val(),
			lang = this.wikiLanguage.val();
		if(name) {
			this.nameAjax = true;
			this.checkNextButtonStep1();

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
							that.wikiNameError.html(response);
						} else {
							that.wikiNameError.html('');
						}
						that.nameAjax = false;
						that.checkNextButtonStep1();
					}
				}
			});
		} else {
			this.showIcon(this.wikiNameStatus, '');
			this.wikiNameError.html('');
		}
	},

	checkDomain: function(e) {
		var that = this,
			wd = this.wikiDomain.val(),
			lang = this.wikiLanguage.val();
		if(wd) {
			wd = wd.toLowerCase();
			this.wikiDomain.val(wd);
			this.showIcon(this.wikiDomainStatus, 'spinner');
			this.domainAjax = true;
			this.checkNextButtonStep1();
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
							that.wikiDomainError.html(response);
							that.showIcon(that.wikiDomainStatus, '');
						} else {
							that.wikiDomainError.html('');
							that.showIcon(that.wikiDomainStatus, 'ok');
						}
						that.domainAjax = false;
						that.checkNextButtonStep1();
					}
				}
			});
		} else {
			this.wikiDomainError.html('');
			this.showIcon(this.wikiDomainStatus, '');
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
		var wb = this.wb;
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
		$.cookies.set('createnewwiki', JSON.stringify(c), {hoursToLive: 24, domain: wgCookieDomain, path: wgCookiePath});
		if(callback) {
			callback();
		}
	},

	gotoMainPage: function() {
		this.nextButtons.attr('disabled', true);
		if(this.createStatus && this.createStatus == 'ok' && this.finishCreateUrl) {
			location.href = this.finishCreateUrl;
		} else if(this.createStatus && this.createStatus == 'backenderror') {
			$.showModal(this.createStatusMessage, this.createStatusMessage);
		} else if (this.retryGoto < 300) {
			if(!this.finishSpinner.data('spinning')) {
				this.finishSpinner.data('spinning', 'true');
				this.showIcon(this.finishSpinner, 'spinner');
			}
			this.retryGoto++;
			setTimeout(this.gotoMainPage, 200);
		}
	},

	createWiki: function() {

		var that = this,
			throbberWrapper = $('#ThemeWiki .next-controls');

		this.requestKeys();
		this.solveKeys();

		throbberWrapper.startThrobbing();

		$.nirvana.sendRequest({
			controller: 'CreateNewWiki',
			method: 'CreateWiki',
			data: {
				data: {
					wName: that.wikiName.val(),
					wDomain: that.wikiDomain.val(),
					wLanguage: that.wikiLanguage.find('option:selected').val(),
					wCategory: that.wikiCategory.find('option:selected').val(),
					wAllAges: that.wikiAllAges.is(':checked') ? that.wikiAllAges.val() : null,
					wAnswer: Math.floor(that.answer)
				}
			},
			callback: function(res) {
				that.createStatus = res.status;
				that.createStatusMessage = res.statusMsg;

				throbberWrapper.stopThrobbing();

				if(that.createStatus && that.createStatus == 'ok') {
					that.cityId = res.cityId;
					that.finishCreateUrl = (res.finishCreateUrl.indexOf('.com/wiki/') < 0 ? res.finishCreateUrl.replace('.com/','.com/wiki/') : res.finishCreateUrl);

					// unblock "Next" button (BugId:51519)
					$('#ThemeWiki .next-controls input').
						attr('disabled', false).
						addClass('enabled'); // for QA with love
				} else {
					$.showModal(res.statusHeader, that.createStatusMessage);
				}
			},
			onErrorCallback: function() {
				that.generateAjaxErrorMsg();
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

	mw.loader.use('wikia.stringhelper')
		.done(function(){
			require(['wikia.stringhelper'], function(stringHelper) { WikiBuilder.init(stringHelper);});
		});
	$('#AjaxLoginButtons').hide();
	$('#AjaxLoginLoginForm').show();

	if ( window.wgOasisResponsive )
	{
		ThemeDesigner.slideByDefaultWidth = 500;
		ThemeDesigner.slideByItems = 3;

	} else {
		ThemeDesigner.slideByDefaultWidth = 608;   
		ThemeDesigner.slideByItems = 4;
	}
	ThemeDesigner.themeTabInit();
});
