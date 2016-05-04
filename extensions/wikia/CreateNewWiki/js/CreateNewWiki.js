/* global mw, ThemeDesigner */

$(function () {
	'use strict';
<<<<<<< HEAD
	window.wgAjaxPath = window.wgScriptPath + window.wgScript;
	mw.loader.using('wikia.stringhelper')
		.done(function () {
			require(
				[
					'wikia.stringhelper',
					'WikiBuilder'
				], function (stringHelper, wikiBuilder) {
					wikiBuilder.init(stringHelper);
				}
			);
		});

	if (window.wgOasisResponsive || window.wgOasisBreakpoints) {
		ThemeDesigner.slideByDefaultWidth = 500;
		ThemeDesigner.slideByItems = 3;

	} else {
		ThemeDesigner.slideByDefaultWidth = 608;
		ThemeDesigner.slideByItems = 4;
	}
	ThemeDesigner.themeTabInit();
});
=======

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
			this.$nameWikiWrapper = $('#NameWiki');
			this.$descWikiWrapper = $('#DescWiki');
			this.$authWrapper = $('#UserAuth');
			this.$themWikiWrapper = $('#ThemeWiki');
			this.$progress = $('#StepsIndicator');
			this.steps = this.wb.find('.steps .step');
			this.wikiName = this.$nameWikiWrapper.find('input[name=wiki-name]');
			this.wikiNameStatus = this.$nameWikiWrapper.find('.wiki-name-status-icon');
			this.wikiNameError = this.$nameWikiWrapper.find('.wiki-name-error');
			this.wikiDomain = this.$nameWikiWrapper.find('input[name=wiki-domain]');
			this.wikiDomainError = this.$nameWikiWrapper.find('.wiki-domain-error');
			this.wikiDomainStatus = this.$nameWikiWrapper.find('.domain-status-icon');
			this.wikiDomainCountry = this.$nameWikiWrapper.find('.domain-country');
			this.nameWikiSubmitError = this.$nameWikiWrapper.find('.submit-error');
			this.wikiLanguage = this.$nameWikiWrapper.find('select[name=wiki-language]');
			this.wikiVertical = this.$descWikiWrapper.find('select[name=wiki-vertical]');
			this.wikiAllAges = this.$descWikiWrapper.find('input[name=all-ages]');
			this.allAgesDiv = $('#all-ages-div');
			this.descWikiSubmitError = this.$descWikiWrapper.find('.submit-error');
			this.nextButtons = this.wb.find('nav .next');
			this.finishSpinner = this.wb.find('.finish-status');
			this.descWikiNext = this.$descWikiWrapper.find('nav .next');

			var self = this,
				pane;

			// Name Wiki event handlers
			this.checkNextButtonStep1();

			this.$nameWikiWrapper.find('input.next').click(function () {
				if (self.isNameWikiSubmitError()) {
					self.nameWikiSubmitError.
						show().
						html(WikiBuilderCfg['name-wiki-submit-error']).
						delay(3000).
						fadeOut();
				} else {
					self.saveState({
						wikiName: self.wikiName.val(),
						wikiDomain: self.wikiDomain.val(),
						wikiLang: self.wikiLanguage.find('option:selected').val()
					});
					if (window.wgUserName) {
						self.onAuthSuccess();
					} else {
						require(['AuthModal', 'wikia.querystring'], function (authModal, querystring) {
							var redirectUrl = new querystring();

							redirectUrl.setVal({
								wikiName: self.wikiName.val(),
								wikiDomain: self.wikiDomain.val(),
								wikiLanguage: self.wikiLanguage.find('option:selected').val()
							});

							authModal.load({
								forceLogin: true,
								url: '/signin?redirect=' + encodeURIComponent(redirectUrl.toString()),
								origin: 'create-new-wikia',
								onAuthSuccess: $.proxy(self.onAuthSuccess, self)
							});
						});
					}
				}
			});
			this.wikiDomain.keyup(function () {
				self.domainAjax = true;
				self.checkNextButtonStep1();
				if (self.wdtimer) {
					clearTimeout(self.wdtimer);
				}
				self.wdtimer = setTimeout($.proxy(self.checkDomain, self), 500);
			});
			this.wikiName.keyup(function () {
				self.nameAjax = true;
				self.checkNextButtonStep1();
				var name = $(this).val();
				name = $.trim(stringHelper.latinise(name).replace(/[^a-zA-Z0-9 ]+/g, '')).replace(/ +/g, '-');
				self.wikiDomain.val(name.toLowerCase()).trigger('keyup');
				if (self.wntimer) {
					clearTimeout(self.wntimer);
				}
				self.wntimer = setTimeout($.proxy(self.checkWikiName, self), 500);
			});
			this.wikiLanguage.bind('change', function () {
				self.checkWikiName();
				self.checkDomain();
				var selected = self.wikiLanguage.find('option:selected').val();

				if (selected && selected !== window.wgLangAllAgesOpt) {
					self.wikiDomainCountry.html(selected + '.');
					self.allAgesDiv.hide();
				} else {
					self.wikiDomainCountry.html('');
					self.allAgesDiv.show();
				}

			});
			$('#ChangeLang').click(function (e) {
				e.preventDefault();
				self.$nameWikiWrapper.find('.language-default').hide();
				self.$nameWikiWrapper.find('.language-choice').show();
			});
			this.wb.find('nav .back').bind('click', function () {
				var id = $(this).closest('.step').attr('id');
				if (id === 'DescWiki') {
					self.transition('DescWiki', false, '-');
					if (self.$authWrapper.length) {
						self.userAuth.loginAjaxForm.retrieveLoginToken({
							clearCache: true
						});
						self.userAuth.loginAjaxForm.submitButton.removeAttr('disabled');
					}
				} else {
					self.transition(id, false, '-');
				}
			});

			// Description event handlers
			this.descWikiNext.click(function () {
				var val, descriptionVal;

				self.descWikiNext.attr('disabled', true);
				val = self.wikiVertical.find('option:selected').val();

				if (val !== '-1' /* yes, it is a string */ ) {
					descriptionVal = $('#Description').val();
					$.nirvana.sendRequest({
						controller: 'CreateNewWiki',
						method: 'Phalanx',
						data: {
							text: descriptionVal
						},
						callback: function (res) {
							// check phalanx result
							if (res.msgHeader) {
								$.showModal(res.msgHeader, res.msgBody);
								self.descWikiNext.attr('disabled', false);
							} else {
								// call create wiki ajax
								self.saveState({
									wikiDescription: (descriptionVal === WikiBuilderCfg.descriptionplaceholder ?
										'' : descriptionVal)
								}, function () {
									self.createWiki();
									self.transition('DescWiki', true, '+');
								});
							}
						}
					});
				} else {
					self.descWikiSubmitError
						.show()
						.html(WikiBuilderCfg['desc-wiki-submit-error'])
						.delay(3000)
						.fadeOut();
					self.descWikiNext.attr('disabled', false);
				}
			});
			$('#Description').placeholder();

			// Theme event handlers
			this.$themWikiWrapper.find('nav .next').click(function () {
				self.saveState(ThemeDesigner.settings, function () {
					if (WikiBuilderCfg.skipwikiaplus) {
						self.gotoMainPage();
					} else {
						self.transition('ThemeWiki', true, '+');
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

				if (selectedValue === '-1' /* yes, it is a string */ ) {
					categoriesSets.hide();
				} else {
					categoriesSets.show();

					selectedOption = $this.find('option:selected');
					selectedShort = selectedOption.data('short');
					categoriesSetId = selectedOption.data('categoriesset');

					if (categoriesSetId !== self.categoriesSetId) {
						$('#categories-set-' + self.categoriesSetId).hide();
						$('#categories-set-' + categoriesSetId).show();
						self.categoriesSetId = categoriesSetId;
					}

					// unhide 'duplicates'
					if (self.hiddenDuplicate) {
						self.hiddenDuplicate.show();
					}

					// hide 'duplicates'
					duplicate = $('#categories-set-' + self.categoriesSetId)
						.find('[data-short="' + selectedShort + '"]');
					if (duplicate) {
						duplicate.attr('checked', false);
						self.hiddenDuplicate = duplicate.parent().hide();
					}
				}
			});

			// Set current step on page load
			if (WikiBuilderCfg.currentstep) {
				pane = $('#' + WikiBuilderCfg.currentstep);
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

		onAuthSuccess: function () {
			this.transition('NameWiki', true, '+');
		},

		checkWikiName: function () {
			var self = this,
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
							var response = res.res;
							if (response) {
								self.wikiNameError.html(response);
							} else {
								self.wikiNameError.html('');
							}
							self.nameAjax = false;
							self.checkNextButtonStep1();
						}
					}
				});
			} else {
				this.showIcon(this.wikiNameStatus, '');
				this.wikiNameError.html('');
			}
		},

		checkDomain: function () {
			var self = this,
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
							var response = res.res;
							if (response) {
								self.wikiDomainError.html(response);
								self.showIcon(self.wikiDomainStatus, '');
							} else {
								self.wikiDomainError.html('');
								self.showIcon(self.wikiDomainStatus, 'ok');
							}
							self.domainAjax = false;
							self.checkNextButtonStep1();
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
				if (art === 'spinner') {
					markup += window.stylepath + '/common/images/ajax.gif';
				} else if (art === 'ok') {
					markup += window.wgExtensionsPath + '/wikia/CreateNewWiki/images/check.png';
				}
				markup += '">';
				$(el).html(markup);
			} else {
				$(el).html('');
			}
		},

		transition: function (from, next, dot) {
			var self = this,
				f = $('#' + from),
				t = (next ? f.next() : f.prev()),
				wb = this.wb,
				op = t.css('position'),
				th, tw;

			t.css('position', 'absolute');
			th = t.height();
			tw = t.width();
			t.css('position', op);

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
						self.$progress.find('.step.active').last().next().addClass('active');
					} else if (dot === '-') {
						self.$progress.find('.step.active').last().removeClass('active');
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
			var c = JSON.parse($.cookies.get('createnewwiki')),
				key;

			if (!c) {
				c = {};
			}
			for (key in data) {
				c[key] = data[key];
			}
			$.cookies.set('createnewwiki', JSON.stringify(c), {
				hoursToLive: 24,
				domain: window.wgCookieDomain,
				path: window.wgCookiePath
			});
			if (typeof callback === 'function') {
				callback();
			}
		},

		gotoMainPage: function () {
			this.nextButtons.attr('disabled', true);
			if (this.createStatus && this.createStatus === 'ok' && this.finishCreateUrl) {
				location.href = this.finishCreateUrl;
			} else if (this.createStatus && this.createStatus === 'backenderror') {
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

			var self = this,
				throbberWrapper = this.$themWikiWrapper.find('.next-controls'),
				verticalOption = self.wikiVertical.find('option:selected'),
				categories = [];

			this.requestKeys();
			this.solveKeys();

			throbberWrapper.startThrobbing();

			$('#categories-set-' + verticalOption.data('categoriesset') + ' :checked').each(function () {
				categories.push($(this).val());
			});

			$.get('/api.php', {
				action: 'query',
				uiprop: 'preferencestoken',
				meta: 'userinfo',
				format: 'json'
			}).then(function (response) {
				var preferencesToken;

				if (!response || !response.query || !response.query.userinfo) {
					self.generateAjaxErrorMsg();
					return;
				}

				preferencesToken = response.query.userinfo.preferencestoken;

				$.nirvana.sendRequest({
					controller: 'CreateNewWiki',
					method: 'CreateWiki',
					data: {
						data: {
							wName: self.wikiName.val(),
							wDomain: self.wikiDomain.val(),
							wLanguage: self.wikiLanguage.find('option:selected').val(),
							wVertical: verticalOption.val(),
							wCategories: categories,
							wAllAges: self.wikiAllAges.is(':checked') ? self.wikiAllAges.val() : null,
							wAnswer: Math.floor(self.answer)
						},
						token: preferencesToken
					},
					callback: function (res) {
						self.createStatus = res.status;
						self.createStatusMessage = res.statusMsg;

						throbberWrapper.stopThrobbing();

						if (self.createStatus && self.createStatus === 'ok') {
							self.cityId = res.cityId;
							self.finishCreateUrl = (res.finishCreateUrl.indexOf('.com/wiki/') < 0 ?
								res.finishCreateUrl.replace('.com/', '.com/wiki/') :
								res.finishCreateUrl);

							// unblock "Next" button (BugId:51519)
							self.$themWikiWrapper.find('.next-controls input').
								attr('disabled', false).
								addClass('enabled'); // for QA with love
						} else {
							$.showModal(res.statusHeader, self.createStatusMessage);
						}
					},
					onErrorCallback: function () {
						self.generateAjaxErrorMsg();
					}
				});
			}).fail(function () {
				self.generateAjaxErrorMsg();
			});
		},

		generateAjaxErrorMsg: function () {
			$.showModal(WikiBuilderCfg['cnw-error-general-heading'], WikiBuilderCfg['cnw-error-general']);
		}
	};

	$(function () {
		window.wgAjaxPath = window.wgScriptPath + window.wgScript;

		mw.loader.using('wikia.stringhelper')
			.done(function () {
				require(['wikia.stringhelper'], function (stringHelper) {
					WikiBuilder.init(stringHelper);
				});
			});

		if (window.wgOasisResponsive || window.wgOasisBreakpoints) {
			ThemeDesigner.slideByDefaultWidth = 500;
			ThemeDesigner.slideByItems = 3;

		} else {
			ThemeDesigner.slideByDefaultWidth = 608;
			ThemeDesigner.slideByItems = 4;
		}
		ThemeDesigner.themeTabInit();
	});
})();
>>>>>>> dev
