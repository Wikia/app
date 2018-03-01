/*global WikiBuilderCfg, ThemeDesigner */

define('ext.createNewWiki.builder', ['ext.createNewWiki.helper', 'wikia.tracker'], function (helper, tracker) {
	'use strict';

	var wntimer = false,
		wdtimer = false,
		createStatus = false,
		createStatusMessage = false,
		cityId = false,
		finishCreateUrl = false,
		retryGoto = 0,
		nameAjax = false,
		domainAjax = false,
		wb,
		$nameWikiWrapper,
		$descWikiWrapper,
		$authWrapper,
		$themWikiWrapper,
		steps,
		wikiName,
		wikiNameLabel,
		wikiNameError,
		wikiDomain,
		wikiDomainLabel,
		wikiDomainError,
		wikiDomainCountry,
		wikiLanguage,
		wikiLanguageList,
		wikiVertical,
		wikiVerticalList,
		wikiVerticalError,
		wikiAllAges,
		allAgesDiv,
		descWikiSubmitError,
		nextButtons,
		finishSpinner,
		descWikiNext,
		categoriesSetId,
		hiddenDuplicate,
		userAuth,
		errorModalHeader,
		errorModalMessage,
		isUserLoggedIn = window.wgUserName !== null,
		track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK,
			category: 'create-new-wiki',
			trackingMethod: 'analytics'
		});

	function init() {
		var pane;

		cacheSelectors();
		checkNextButtonStep1();
		bindEventHandlers();
		initFloatingLabelsPosition();

		// Set current step on page load
		if (WikiBuilderCfg.currentstep) {
			pane = $('#' + WikiBuilderCfg.currentstep);
			wb.width(pane.width());
			steps.hide();
			pane.show();
		}

		// onload stuff
		wikiName.focus();
		if (wikiName.val() || wikiDomain.val()) {
			checkDomain();
			checkWikiName();
		}

		// added like this, instead of in stylesheet, so it won't override overflow property globally
		$('#WikiaArticle').css('overflow', 'visible');
	}

	function cacheSelectors() {
		wb = $('#CreateNewWiki');
		$nameWikiWrapper = $('#NameWiki');
		$descWikiWrapper = $('#DescWiki');
		$authWrapper = $('#UserAuth');
		$themWikiWrapper = $('#ThemeWiki');
		steps = wb.find('.steps .step');
		wikiName = $nameWikiWrapper.find('input[name=wiki-name]');
		wikiNameLabel = $nameWikiWrapper.find('label[for=wiki-name]');
		wikiNameError = $nameWikiWrapper.find('.wiki-name-error');
		wikiDomain = $nameWikiWrapper.find('input[name=wiki-domain]');
		wikiDomainLabel = $nameWikiWrapper.find('label[for=wiki-domain]');
		wikiDomainError = $nameWikiWrapper.find('.wiki-domain-error');
		wikiDomainCountry = $nameWikiWrapper.find('.domain-country');
		wikiLanguage = $nameWikiWrapper.find('input[name=wiki-language]');
		wikiLanguageList = $nameWikiWrapper.find('.wiki-language-dropdown');
		wikiVertical = $descWikiWrapper.find('input[name=wiki-vertical]');
		wikiVerticalList = $descWikiWrapper.find('.wiki-vertical-dropdown');
		wikiVerticalError = $descWikiWrapper.find('.wiki-vertical-error');
		wikiAllAges = $descWikiWrapper.find('input[name=all-ages]');
		allAgesDiv = $('#all-ages-div');
		descWikiSubmitError = $descWikiWrapper.find('.submit-error');
		nextButtons = wb.find('nav .next');
		finishSpinner = wb.find('.finish-status');
		descWikiNext = $descWikiWrapper.find('nav .next');
	}

	function bindEventHandlers() {
		$nameWikiWrapper.find('input.next').click(onNameWikiWrapperClick);
		wikiDomain.keyup(onWikiDomainKeyUp);
		wikiName.keyup(onWikiNameKeyUp);
		wikiName.on('focus', onWikiNameFocus);
		wikiName.on('blur', onWikiNameBlur);
		wikiDomain.on('focus', onWikiDomainFocus);
		wikiDomain.on('blur', onWikiDomainBlur);
		wikiLanguage.bind('change', onWikiLanguageChange);
		wikiLanguageList.bind('click', onWikiLanguageListClick);
		wb.find('nav .back').bind('click', onNavBackClick);
		descWikiNext.click(onDescWikiNextClick);
		$('#Description').placeholder();
		$themWikiWrapper.find('nav .next').click(onThemeNavNextClick);
		wikiVertical.on('change', onWikiVerticalChange);
		wikiVerticalList.bind('click', onWikiVerticalListClick);
		$descWikiWrapper.find('#all-ages-div input').bind('change', onIntendedForKidsCheckboxChange);
	}

	function initFloatingLabelsPosition() {
		wikiNameLabel.css('left', wikiName.position().left);
		wikiDomainLabel.css('left', wikiDomain.position().left);

		if (wikiName.val()) {
			wikiNameLabel.addClass('active').css('left', 0);
		}

		if (wikiDomain.val()) {
			wikiDomainLabel.addClass('active').css('left', 0);
		}
	}

	function onThemeNavNextClick() {
		track({
			action: tracker.ACTIONS.SUBMIT,
			label: 'theme-selection-submitted'
		});
		saveState(ThemeDesigner.settings, function () {
			gotoMainPage();
		});
	}

	function onDescWikiNextClick() {
		var val,
			descriptionVal;

		descWikiNext.attr('disabled', true);
		val = wikiVertical.val();

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
					if (res.statusHeader) {
						track({
							action: tracker.ACTIONS.ERROR,
							label: 'wiki-description-validation-error'
						});
						$.showModal(res.statusHeader, res.statusMsg);
						descWikiNext.attr('disabled', false);
					} else {
						var descriptionLabel = (descriptionVal === WikiBuilderCfg.descriptionplaceholder) ?
							'wiki-description-submitted-empty' :
							'wiki-description-submitted';

						track({
							action: tracker.ACTIONS.SUBMIT,
							label: descriptionLabel
						});

						// call create wiki ajax
						saveState({
							wikiDescription: (descriptionVal === WikiBuilderCfg.descriptionplaceholder ?
								'' : descriptionVal)
						}, function () {
							createWiki();
							transition('DescWiki', true);
						});
					}
				},
				onErrorCallback: generateAjaxErrorMsg
			});
		} else {
			track({
				action: tracker.ACTIONS.ERROR,
				label: 'vertical-not-selected-error'
			});
			descWikiNext.attr('disabled', false);

			addWikiVerticalError(WikiBuilderCfg['desc-wiki-submit-error']);
		}
	}

	function onWikiVerticalChange () {
		var selectedOption = $(this),
			selectedValue = selectedOption.val(),
			selectedShort,
			categoriesSets = $('.categories-sets'),
			newCategoriesSetId,
			duplicate,
			nextButton = nextButtons.eq(1);

		if (selectedValue === '-1' /* yes, it is a string */ ) {
			track({
				label: 'vertical-unselected'
			});
			categoriesSets.hide();

			nextButton.attr('disabled', true);
			addWikiVerticalError(WikiBuilderCfg['desc-wiki-submit-error']);
		} else {
			track({
				label: 'vertical-selected'
			});
			categoriesSets.show();

			selectedShort = selectedOption.data('short');
			newCategoriesSetId = selectedOption.data('categoriesset');

			if (newCategoriesSetId !== categoriesSetId) {
				$('#categories-set-' + categoriesSetId).hide();
				$('#categories-set-' + newCategoriesSetId).show();
				categoriesSetId = newCategoriesSetId;
			}

			// unhide 'duplicates'
			if (hiddenDuplicate) {
				hiddenDuplicate.show();
			}

			// hide 'duplicates'
			duplicate = $('#categories-set-' + categoriesSetId)
				.find('[data-short="' + selectedShort + '"]');
			if (duplicate) {
				duplicate.attr('checked', false);
				hiddenDuplicate = duplicate.closest('label').hide();
			}
			$descWikiWrapper.find('label input[type="checkbox"]').change(onCategorySelection);

			nextButton.attr('disabled', false);
			removeWikiVerticalError();
		}
	}

	function onWikiVerticalListClick(e) {
		var li = $(e.target),
			input = $descWikiWrapper.find('input[name=wiki-vertical]');

		$descWikiWrapper.find('.wds-dropdown').removeClass('wds-is-active');
		input.data({ short: li.data('short'), categoriesset: li.data('categoriesset') });
		input.val(li.attr('id')).change();
		$descWikiWrapper.find('.default-value').text(li.text());
	}

	function onCategorySelection() {
		track({
			label: 'category-checkbox-clicked'
		});
	}

	function onIntendedForKidsCheckboxChange() {
		track({
			label: 'intended-for-kids-checkbox-clicked'
		});
	}

	function onNavBackClick() {
		track({
			label: 'description-back-button-clicked'
		});

		var id = $(this).closest('.step').attr('id');

		if (id === 'DescWiki') {
			transition('DescWiki', false);
			if ($authWrapper.length) {
				userAuth.loginAjaxForm.retrieveLoginToken({
					clearCache: true
				});
				userAuth.loginAjaxForm.submitButton.removeAttr('disabled');
			}

			removeWikiVerticalError();
		} else {
			transition(id, false);
		}
	}

	function onWikiLanguageChange() {
		checkWikiName();
		checkDomain();
		var selected = $(this).val();

		if (selected && selected !== window.wgLangAllAgesOpt) {
			wikiDomainCountry.html(selected + '.');
			allAgesDiv.hide();
		} else {
			wikiDomainCountry.html('');
			allAgesDiv.show();
		}

		if (!wikiDomainLabel.hasClass('active')) {
			wikiDomainLabel.css('left', wikiDomain.position().left);
		}

		track({
			label: 'language-changed'
		});
	}

	function onWikiLanguageListClick(e) {
		var li = $(e.target);
		if (!li.hasClass('spacer')) {
			$nameWikiWrapper.find('.wds-dropdown').removeClass('wds-is-active');
			$nameWikiWrapper.find('input[name=wiki-language]').val(li.attr('id')).change();
			$nameWikiWrapper.find('.default-value').text(li.text().split(':')[1]);
		}
	}

	function onWikiNameKeyUp() {
		var name;

		nameAjax = true;
		checkNextButtonStep1();
		name = helper.sanitizeWikiName($(this).val());
		if (name) {
			wikiDomainLabel.addClass('active').css('left', 0);
		} else {
			wikiDomainLabel.removeClass('active').css('left', wikiDomain.position().left);
		}

		wikiDomain.val(name.toLowerCase()).trigger('keyup');
		if (wntimer) {
			clearTimeout(wntimer);
		}
		wntimer = setTimeout(checkWikiName, 500);
	}

	function onWikiNameFocus() {
		wikiNameLabel.addClass('active').css('left', 0);
	}

	function onWikiNameBlur(e) {
		if (e.target.value.trim().length === 0) {
			wikiNameLabel.removeClass('active').css('left', wikiName.position().left);
			if (!wikiDomain.val().trim().length) {
				wikiDomainLabel.removeClass('active').css('left', wikiDomain.position().left);
			}
		}
	}

	function onWikiDomainKeyUp() {
		domainAjax = true;
		checkNextButtonStep1();
		if (wdtimer) {
			clearTimeout(wdtimer);
		}
		wdtimer = setTimeout(checkDomain, 500);
	}

	function onWikiDomainFocus() {
		wikiDomainLabel.addClass('active').css('left', 0);
	}

	function onWikiDomainBlur(e) {
		if (e.target.value.trim().length === 0) {
			wikiDomainLabel.removeClass('active').css('left', wikiDomain.position().left);
		}
	}

	function onNameWikiWrapperClick () {
		var wikiNameVal = wikiName.val(),
			wikiDomainVal = wikiDomain.val(),
			wikiLanguageVal;

		if (isNameWikiSubmitError()) {
			track({
				action: tracker.ACTIONS.ERROR,
				label: 'wiki-name-submit-error'
			});
			if (wikiNameVal.length === 0) {
				addWikiNameError(WikiBuilderCfg['name-wiki-submit-error']);
			}
			if (wikiDomainVal.length === 0) {
				addWikiDomainError(WikiBuilderCfg['name-wiki-submit-error']);
			}
		} else {
			wikiLanguageVal = wikiLanguage.find('option:selected').val();

			saveState({
				wikiName: wikiNameVal,
				wikiDomain: wikiDomainVal,
				wikiLang: wikiLanguageVal
			});

			if (isUserLoggedIn) {
				onAuthSuccess();
			} else {
				track({
					action: tracker.ACTIONS.IMPRESSION,
					label: 'login-modal-shown'
				});
				helper.login(onAuthSuccess, helper.getLoginRedirectURL(wikiNameVal, wikiDomainVal, wikiLanguageVal));
			}
			track({
				action: tracker.ACTIONS.SUCCESS,
				label: 'wiki-name-submitted'
			});
		}
	}

	function onAuthSuccess() {
		isUserLoggedIn = true;
		transition('NameWiki', true);
	}

	function checkWikiName () {
		var name = wikiName.val(),
			lang = wikiLanguage.val();
		if (name) {
			nameAjax = true;
			checkNextButtonStep1();

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
							addWikiNameError(response);
						} else {
							removeWikiNameError();
						}
						nameAjax = false;
						checkNextButtonStep1();
					}
				}
			});
		} else {
			removeWikiNameError();
		}
	}

	function checkDomain() {
		var wd = wikiDomain.val(),
			lang = wikiLanguage.val(),
			throbberWrapper = $nameWikiWrapper.find('.controls');

		if (wd) {
			throbberWrapper.startThrobbing();

			wd = wd.toLowerCase();
			wikiDomain.val(wd);
			domainAjax = true;
			checkNextButtonStep1();

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
							addWikiDomainError(response);
						} else {
							removeWikiDomainError();
						}

						domainAjax = false;
						checkNextButtonStep1();
						throbberWrapper.stopThrobbing();
					}
				}
			});
		} else {
			removeWikiDomainError();
		}
	}

	function isNameWikiSubmitError() {
		return !wikiDomain.val() ||
			!wikiName.val() ||
			$nameWikiWrapper.find('.wiki-name-error').html() ||
			$nameWikiWrapper.find('.wiki-domain-error').html() ||
			nameAjax ||
			domainAjax;
	}

	/**
	 * Update the state of "Next" button on step #1.
	 * It depends on two AJAX validation requests which are performed in parallel.
	 *
	 * This method is used solely by automated tests (enabled class is added when test can proceed to the next step)
	 */
	function checkNextButtonStep1() {
		var nextButton = nextButtons.eq(0);

		if (isNameWikiSubmitError()) {
			nextButton.removeClass('enabled').attr('disabled', true);
		} else {
			nextButton.addClass('enabled').attr('disabled', false);
		}
	}

	function showSpinnerIcon(el) {
		$(el).html('<img src="' + window.stylepath + '/common/images/ajax.gif' + '">');
	}

	function transition(from, next) {
		var f = $('#' + from),
			t = (next ? f.next() : f.prev()),
			op = t.css('position'),
			stepsWrapper = wb.find('.steps'),
			th;

		t.css('position', 'absolute');
		th = t.height() + wb.outerHeight() - stepsWrapper.height();
		t.css('position', op);
		stepsWrapper.css({'border-bottom-style': 'none'});

		wb.animate({
			height: th
		}, function () {
			t.animate({
				'opacity': 'show'
			}, {
				queue: false,
				duration: 250
			});
			wb.height('auto');
			stepsWrapper.css({'border-bottom-style': 'solid'});
		});
		f.animate({
			'opacity': 'hide'
		}, {
			queue: false,
			duration: 250
		});
	}

	function saveState(data, callback) {
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
	}

	function gotoMainPage() {
		nextButtons.attr('disabled', true);
		if (createStatus && createStatus === 'ok' && finishCreateUrl) {
			location.href = finishCreateUrl;
		} else if (!createStatus || (createStatus && createStatus === 'backenderror')) {
			$.showModal(errorModalHeader, errorModalMessage);
		} else if (retryGoto < 300) {
			if (!finishSpinner.data('spinning')) {
				finishSpinner.data('spinning', 'true');
				showSpinnerIcon(finishSpinner);
			}
			retryGoto++;
			setTimeout(gotoMainPage, 200);
		}
	}

	function createWiki() {
		var throbberWrapper = $themWikiWrapper.find('.controls'),
			categories = [],
			descriptionVal;

		throbberWrapper.startThrobbing();

		$('#categories-set-' + wikiVertical.data('categoriesset') + ' :checked').each(function () {
			categories.push($(this).val());
		});

		descriptionVal = $('#Description').val();

		$.get(mw.util.wikiScript('api'), {
			action: 'query',
			uiprop: 'preferencestoken',
			meta: 'userinfo',
			format: 'json'
		}).then(function (response) {
			var preferencesToken;

			if (!response || !response.query || !response.query.userinfo) {
				generateAjaxErrorMsg();
				return;
			}

			preferencesToken = response.query.userinfo.preferencestoken;

			$.nirvana.sendRequest({
				controller: 'CreateNewWiki',
				method: 'CreateWiki',
				data: {
					data: {
						wName: wikiName.val(),
						wDomain: wikiDomain.val(),
						wLanguage: wikiLanguage.val(),
						wVertical: wikiVertical.val(),
						wCategories: categories,
						wAllAges: wikiAllAges.is(':checked') ? wikiAllAges.val() : null,
						wDescription: descriptionVal
					},
					token: preferencesToken
				},
				callback: function (res) {
					throbberWrapper.stopThrobbing();
					throbberWrapper.removeClass('creating-wiki');
					cityId = res.cityId;
					createStatus = res.status;
					createStatusMessage = res.statusMsg;
					finishCreateUrl = (res.finishCreateUrl.indexOf('.com/wiki/') < 0 ?
						res.finishCreateUrl.replace('.com/', '.com/wiki/') :
						res.finishCreateUrl);

					// unblock "Next" button (BugId:51519)
					// for QA with love
					$themWikiWrapper.find('.controls input').attr('disabled', false).addClass('enabled');
				},
				onErrorCallback: generateAjaxErrorMsg
			});
		}).fail(generateAjaxErrorMsg);
	}

	function generateAjaxErrorMsg(error) {
		var responseTextObject;

		if (error && error.responseText) {
			responseTextObject = JSON.parse(error.responseText);
			errorModalHeader = responseTextObject.statusHeader;
			errorModalMessage = responseTextObject.statusMsg;
			createStatus = responseTextObject.status;
		} else {
			errorModalHeader = WikiBuilderCfg['cnw-error-general-heading'];
			errorModalMessage = WikiBuilderCfg['cnw-error-general'];
		}

		$.showModal(errorModalHeader, errorModalMessage);
	}

	function addWikiNameError(message) {
		wikiName.addClass('input-error');
		wikiNameLabel.addClass('label-error');
		wikiNameError.html(message);
	}

	function removeWikiNameError() {
		wikiName.removeClass('input-error');
		wikiNameLabel.removeClass('label-error');
		wikiNameError.html('');
	}

	function addWikiDomainError(message) {
		wikiDomain.addClass('input-error');
		wikiDomainLabel.addClass('label-error');
		wikiDomainError.html(message);
	}

	function removeWikiDomainError() {
		wikiDomain.removeClass('input-error');
		wikiDomainLabel.removeClass('label-error');
		wikiDomainError.html('');
	}

	function addWikiVerticalError(message) {
		wikiVerticalList.parent().addClass('input-error');
		wikiVerticalError.html(message);
	}

	function removeWikiVerticalError() {
		wikiVerticalList.parent().removeClass('input-error');
		wikiVerticalError.html('');
	}

	return {
		init: init
	};
});
