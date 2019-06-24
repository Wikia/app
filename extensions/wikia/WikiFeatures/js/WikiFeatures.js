/* global Modernizr */

(function (window, $, mw) {
	'use strict';

	var lockedFeatures = {},
		// provided as a list of WF variable strings, i.e. wgEnableFeatureExt
	    fadingFeatures = [];

	function init() {
		var $wikifeatures = $('#WikiFeatures'),
			$sliders = $wikifeatures.find('.slider');

		if (!Modernizr.csstransforms) {
			$('.representation').removeClass('promotion');
		}

		$sliders.click(function (event) {
			event.preventDefault();

			var $el = $(this),
				feature = $el.closest('.feature'),
				featureName = feature.data('name'),
				isEnabled,
				modalTitle;

			if (!lockedFeatures[featureName]) {
				isEnabled = $el.hasClass('on');

				if (isEnabled) {
					modalTitle = $.msg('wikifeatures-deactivate-heading', feature.find('h3')
                        .contents(':first').text().trim());

					require(['wikia.ui.factory'], function (uiFactory) {
						uiFactory.init(['modal']).then(function (uiModal) {
							var deactivateModalConfig = {
								vars: {
									id: 'DeactivateDialog',
									size: 'medium',
									title: modalTitle,
									content: [
										'<p>',
										$.msg('wikifeatures-deactivate-description'),
										'</p><p>',
										$.msg('wikifeatures-deactivate-notification'),
										'</p>'
									].join(''),
									buttons: [{
										vars: {
											value: $.msg('wikifeatures-deactivate-confirm-button'),
											classes: ['normal', 'primary'],
											data: [{
												key: 'event',
												value: 'confirm'
											}]
										}
									}, {
										vars: {
											value: $.msg('wikifeatures-deactivate-cancel-button'),
											data: [{
												key: 'event',
												value: 'close'
											}]
										}
									}]
								}
							};

							uiModal.createComponent(deactivateModalConfig, function (deactivateModal) {
								deactivateModal.bind('confirm', function (event) {
									event.preventDefault();
									toggleFeature(featureName, false);
									$el.toggleClass('on');
									deactivateModal.trigger('close');
								});
								deactivateModal.show();
							});
						});
					});
				} else {
					toggleFeature(featureName, true);
					$el.toggleClass('on');
				}
			}
		});

	function toggleFeature(featureName, enable) {
		lockedFeatures[featureName] = true;

		$.post(window.wgScriptPath + '/wikia.php', {
			controller: 'WikiFeaturesSpecial',
			method: 'toggleFeature',
			format: 'json',
			feature: featureName,
			enabled: enable,
			token: mw.user.tokens.get('editToken')
		}, function (res) {
			if (res.result === 'ok') {
				lockedFeatures[featureName] = false;
				if (fadingFeatures.indexOf(featureName) !== -1) {
					$('.feature[data-name="' + featureName + '"]').addClass('faded');
				}
			} else {
				new window.BannerNotification(res.error, 'error').show();
			}
		});
	}

	$(function () {
		init();
	});

})(window, jQuery, mediaWiki);
