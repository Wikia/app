/*global UserLoginFacebook: true, UserLoginAjaxForm: true, WikiBuilderCfg: true */

(function () {
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
		init: function (stringHelper) {
			// pre-cache
			this.wb = $('#CreateNewWiki');
			this.steps = this.wb.find('.steps .step');
			this.$nameWikiWrapper = $('#NameWiki');
			this.wikiName = this.$nameWikiWrapper.find('input[name=wiki-name]');
			this.wikiNameStatus = this.$nameWikiWrapper.find('.wiki-name-status-icon');
			this.wikiNameError = this.$nameWikiWrapper.find('.wiki-name-error');
			this.wikiDomain = this.$nameWikiWrapper.find('input[name=wiki-domain]');
			this.wikiDomainError = this.$nameWikiWrapper.find('.wiki-domain-error');
			this.wikiDomainStatus = this.$nameWikiWrapper.find('.domain-status-icon');
			this.wikiDomainCountry = this.$nameWikiWrapper.find('.domain-country');
			this.nameWikiSubmitError = this.$nameWikiWrapper.find('.submit-error');
			this.wikiLanguage = this.$nameWikiWrapper.find('select[name=wiki-language]');
			this.$descWikiWrapper = $('#DescWiki');
			this.wikiVertical = this.$descWikiWrapper.find('select[name=wiki-vertical]');
			this.wikiAllAges = this.$descWikiWrapper.find('input[name=all-ages]');
			this.allAgesDiv = $('#all-ages-div');
			this.descWikiSubmitError = this.$descWikiWrapper.find('.submit-error');
			this.nextButtons = this.wb.find('nav .next');
			this.finishSpinner = this.wb.find('.finish-status');
			this.descWikiNext = this.$descWikiWrapper.find('nav .next');

			var that = this,
				$signupRedirect = $('#SignupRedirect');

			$signupRedirect.submit(function (e) {
				var queryString = 'wikiName=' + that.wikiName.val() +
					'&wikiDomain=' + that.wikiDomain.val() +
					'&uselang=' + that.wikiLanguage.find('option:selected').val();
				$().log(queryString);
				$signupRedirect.find('input[name=returnto]').val(queryString);
			});

			// Name Wiki event handlers
			this.checkNextButtonStep1();

			this.$nameWikiWrapper.find('input.next').click(function () {
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
					if ($('#UserAuth').length) {
						// Init user auth
						that.userAuth = {
							el: $('#UserAuth'),
							loginAjaxForm: new UserLoginAjaxForm('#UserAuth .UserLoginModal', {
								ajaxLogin: true,
								callback: function (json) {
									that.transition('UserAuth', true, '+');
								}
							})
						};
						UserLoginFacebook.callbacks['login-success'] = function () {
							that.transition('UserAuth', true, '+');
							UserLoginFacebook.closeSignupModal();
						};
					}
					// Load facebook assets before going to the login form
					$.loadFacebookAPI(function () {
						that.transition('NameWiki', true, '+');
					});
				}
			});
			this.wikiDomain.keyup(function () {
				that.domainAjax = true;
				that.checkNextButtonStep1();
				if (that.wdtimer) {
					clearTimeout(that.wdtimer);
				}
				that.wdtimer = setTimeout($.proxy(that.checkDomain, that), 500);
			});
			this.wikiName.keyup(function () {
				that.nameAjax = true;
				that.checkNextButtonStep1();
				var name = $(this).val();
				name = $.trim(stringHelper.latinise(name).replace(/[^a-zA-Z0-9 ]+/g, '')).replace(/ +/g, '-');
				that.wikiDomain.val(name.toLowerCase()).trigger('keyup');
				if (that.wntimer) {
					clearTimeout(that.wntimer);
				}
				that.wntimer = setTimeout($.proxy(that.checkWikiName, that), 500);
			});
			this.wikiLanguage.bind('change', function () {
				that.checkWikiName();
				that.checkDomain();
				var selected = that.wikiLanguage.find('option:selected').val();

				if (selected && selected !== wgLangAllAgesOpt) {
					that.wikiDomainCountry.html(selected + '.');
					that.allAgesDiv.hide();
				} else {
					that.wikiDomainCountry.html('');
					that.allAgesDiv.show();
				}

			});
			$('#ChangeLang').click(function (e) {
				e.preventDefault();
				that.$nameWikiWrapper.find('.language-default').hide();
				that.$nameWikiWrapper.find('.language-choice').show();
			});
			this.wb.find('nav .back').bind('click', function () {
				var id = $(this).closest('.step').attr('id');
				if (id === 'DescWiki') {
					that.transition('DescWiki', false, '-');
					if ($('#UserAuth').length) {
						that.userAuth.loginAjaxForm.retrieveLoginToken({
							clearCache: true
						});
						that.userAuth.loginAjaxForm.submitButton.removeAttr('disabled');
					}
				} else {
					that.transition(id, false, '-');
				}
			});

			// Description event handlers
			this.descWikiNext.click(function () {
				that.descWikiNext.attr('disabled', true);
				var val = that.wikiVertical.find('option:selected').val();
				if (val !== "-1" /* yes, it is a string */ ) {
					$.nirvana.sendRequest({
						controller: 'CreateNewWiki',
						method: 'Phalanx',
						data: {
							text: $('#Description').val()
						},
						callback: function (res) {
							// check phalanx result
							if (res.msgHeader) {
								$.showModal(res.msgHeader, res.msgBody);
								that.descWikiNext.attr('disabled', false);
							} else {
								// call create wiki ajax
								that.saveState({
									wikiDescription: ($('#Description').val() == WikiBuilderCfg.descriptionplaceholder ? '' : $('#Description').val())
								}, function () {
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
			$('#ThemeWiki nav .next').click(function () {
				that.saveState(ThemeDesigner.settings, function () {
					if (WikiBuilderCfg.skipwikiaplus) {
						that.gotoMainPage();
					} else {
						that.transition('ThemeWiki', true, '+');
					}
				});
			});

			this.wikiVertical.on('change', function () {
				var $this = $(this),
					selectedValue = $this.val(),
					selectedOption,
					selectedShort,
					categoriesSets = $('.categories-sets'),
					categoriesSetId,
					duplicate;

				if (selectedValue === "-1" /* yes, it is a string */ ) {
					categoriesSets.hide();
				} else {
					categoriesSets.show();

					selectedOption = $this.find('option:selected');
					selectedShort = selectedOption.data('short');
					categoriesSetId = selectedOption.data('categoriesset');

					if (categoriesSetId !== that.categoriesSetId) {
						$('#categories-set-' + that.categoriesSetId).hide();
						$('#categories-set-' + categoriesSetId).show();
						that.categoriesSetId = categoriesSetId;
					}

					// unhide "duplicates"
					if (that.hiddenDuplicate) {
						that.hiddenDuplicate.show();
					}

					// hide "duplicates"
					duplicate = $('#categories-set-' + that.categoriesSetId).find('[data-short="' + selectedShort + '"]');
					if (duplicate) {
						duplicate.attr('checked', false);
						that.hiddenDuplicate = duplicate.parent().hide();
					}
				}
			});

			// Set current step on page load
			if (WikiBuilderCfg['currentstep']) {
				var pane = $('#' + WikiBuilderCfg.currentstep);
				this.wb.width(pane.width());
				this.steps.hide();
				pane.show();
			}

			$('.tooltip-icon').tooltip();

			// onload stuff
			this.wikiName.focus();
			if (this.wikiName.val() || this.wikiDomain.val()) {
				this.checkDomain();
				this.checkWikiName();
			}
		},

		requestKeys: function () {
			this.keys = WikiBuilderCfg['cnw-keys'];
		},

		solveKeys: function () {
			var v = 0,
				i;
			for (i = 0; i < this.keys.length; i++) {
				v *= (i % 5) + 1;
				v += this.keys[i];
			}
			this.answer = v;
		},

		checkWikiName: function (e) {
			var that = this,
				name = this.wikiName.val(),
				lang = this.wikiLanguage.val();
			if (name) {
				this.nameAjax = true;
				this.checkNextButtonStep1();

				$.nirvana.sendRequest({
					controller: 'CreateNewWiki',
					method: 'CheckWikiName',
					data: {
						name: name,
						lang: lang
					},
					callback: function (res) {
						if (res) {
							var response = res['res'];
							if (response) {
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

		checkDomain: function (e) {
			var that = this,
				wd = this.wikiDomain.val(),
				lang = this.wikiLanguage.val();
			if (wd) {
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
						lang: lang
					},
					callback: function (res) {
						if (res) {
							var response = res['res'];
							if (response) {
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

		isNameWikiSubmitError: function () {
			return !this.wikiDomain.val() ||
			       !this.wikiName.val() ||
			       this.$nameWikiWrapper.find('.wiki-name-error').html() ||
			       this.$nameWikiWrapper.find('.wiki-domain-error').html() ||
			       this.nameAjax ||
			       this.domainAjax;
		},

		/**
		 * Update the state of "Next" button on step #1.
		 * It depends on two AJAX validation requests which are performed in parallel.
		 *
		 * This method is used solely by automated tests (enabled class is added when test can proceed to the next step)
		 */
		checkNextButtonStep1: function () {
			var nextButton = this.nextButtons.eq(0);

			if (this.isNameWikiSubmitError()) {
				nextButton.removeClass('enabled');
			} else {
				nextButton.addClass('enabled');
			}
		},

		showIcon: function (el, art) {
			if (art) {
				var markup = '<img src="';
				if (art == 'spinner') {
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
			wb.animate({
				height: th,
				width: tw
			}, function () {
				t.animate({
					'opacity': 'show'
				}, {
					queue: false,
					duration: 250
				});
				if (dot) {
					if (dot === '+') {
						$('#StepsIndicator .step.active').last().next().addClass('active');
					} else if (dot === '-') {
						$('#StepsIndicator .step.active').last().removeClass('active');
					}
				}
				wb.height('auto');
			});
			f.animate({
				'opacity': 'hide'
			}, {
				queue: false,
				duration: 250
			});

		},

		saveState: function (data, callback) {
			var c = JSON.parse($.cookies.get('createnewwiki'));
			if (!c) {
				c = {};
			}
			for (var key in data) {
				c[key] = data[key];
			}
			$.cookies.set('createnewwiki', JSON.stringify(c), {
				hoursToLive: 24,
				domain: wgCookieDomain,
				path: wgCookiePath
			});
			if (callback) {
				callback();
			}
		},

		gotoMainPage: function () {
			this.nextButtons.attr('disabled', true);
			if (this.createStatus && this.createStatus == 'ok' && this.finishCreateUrl) {
				location.href = this.finishCreateUrl;
			} else if (this.createStatus && this.createStatus == 'backenderror') {
				$.showModal(this.createStatusMessage, this.createStatusMessage);
			} else if (this.retryGoto < 300) {
				if (!this.finishSpinner.data('spinning')) {
					this.finishSpinner.data('spinning', 'true');
					this.showIcon(this.finishSpinner, 'spinner');
				}
				this.retryGoto++;
				setTimeout(this.gotoMainPage, 200);
			}
		},

		createWiki: function () {

			var that = this,
				throbberWrapper = $('#ThemeWiki .next-controls'),
				verticalOption = that.wikiVertical.find('option:selected'),
				categories = [];

			this.requestKeys();
			this.solveKeys();

			throbberWrapper.startThrobbing();

			$('#categories-set-' + verticalOption.data('categoriesset') + ' :checked').each(function () {
				categories.push($(this).val());
			});

			$.nirvana.sendRequest({
				controller: 'CreateNewWiki',
				method: 'CreateWiki',
				data: {
					data: {
						wName: that.wikiName.val(),
						wDomain: that.wikiDomain.val(),
						wLanguage: that.wikiLanguage.find('option:selected').val(),
						wVertical: verticalOption.val(),
						wCategories: categories,
						wAllAges: that.wikiAllAges.is(':checked') ? that.wikiAllAges.val() : null,
						wAnswer: Math.floor(that.answer)
					}
				},
				callback: function (res) {
					that.createStatus = res.status;
					that.createStatusMessage = res.statusMsg;

					throbberWrapper.stopThrobbing();

					if (that.createStatus && that.createStatus == 'ok') {
						that.cityId = res.cityId;
						that.finishCreateUrl = (res.finishCreateUrl.indexOf('.com/wiki/') < 0 ? res.finishCreateUrl.replace('.com/', '.com/wiki/') : res.finishCreateUrl);

						// unblock "Next" button (BugId:51519)
						$('#ThemeWiki .next-controls input').
							attr('disabled', false).
							addClass('enabled'); // for QA with love
					} else {
						$.showModal(res.statusHeader, that.createStatusMessage);
					}
				},
				onErrorCallback: function () {
					that.generateAjaxErrorMsg();
				}
			});
		},

		generateAjaxErrorMsg: function () {
			$.showModal(WikiBuilderCfg['cnw-error-general-heading'], WikiBuilderCfg['cnw-error-general']);
		}
	};

	$(function () {
		wgAjaxPath = wgScriptPath + wgScript;

		mw.loader.use('wikia.stringhelper')
			.done(function () {
				require(['wikia.stringhelper'], function (stringHelper) {
					WikiBuilder.init(stringHelper);
				});
			});
		$('#AjaxLoginButtons').hide();
		$('#AjaxLoginLoginForm').show();

		if (window.wgOasisResponsive) {
			ThemeDesigner.slideByDefaultWidth = 500;
			ThemeDesigner.slideByItems = 3;

		} else {
			ThemeDesigner.slideByDefaultWidth = 608;
			ThemeDesigner.slideByItems = 4;
		}
		ThemeDesigner.themeTabInit();
	});
})();
