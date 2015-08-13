/*global define, require*/
define('ext.wikia.adEngine.template.modal', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.provider.gpt.adDetect',
	'wikia.document',
	'wikia.log',
	'wikia.iframeWriter',
	'wikia.window',
	require.optional('wikia.ui.factory')
], function (adContext, adHelper, adDetect, doc, log, iframeWriter, win, uiFactory) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.modal',
		modalId = 'ext-wikia-adEngine-template-modal',
		lightBoxExpansionModel = {
			mercury: {
				availableHeightRatio: 1,
				availableWidthRatio: 1,
				heightSubtract: 80,
				minWidth: 100,
				minHeight: 100,
				maximumRatio: 3
			},
			oasis: {
				availableHeightRatio: 0.8,
				availableWidthRatio: 0.9,
				heightSubtract: 90,
				minWidth: 200,
				minHeight: 150,
				maximumRatio: 2
			}
		},
		mercuryModalHandler = {
			show: function () {
				win.Mercury.Modules.Ads.getInstance().showLightbox();
			},

			create: function (adContainer, modalVisible) {
				win.Mercury.Modules.Ads.getInstance().openLightbox(adContainer, modalVisible);
			}
		},
		oasisModalHandler = {
			show: function () {
				if (this.modal) {
					this.modal.show();
				}
			},

			create: function (adContainer, modalVisible) {
				var modalConfig = {
					vars: {
						id: modalId,
						size: 'medium',
						content: '',
						title: 'Advertisement',
						closeText: 'Close',
						buttons: []
					}
				};

				uiFactory.init('modal').then((function (uiModal) {
					uiModal.createComponent(modalConfig, (function (modal) {
						this.modal = modal;
						modal.$content.append(adContainer);
						modal.$element.width('auto');
						if (modalVisible) {
							this.show();
						}
					}).bind(this));
				}).bind(this));
			}
		};
	/**
	 * Show the modal ad
	 *
	 * @param {Object} params
	 * @param {string} params.code - code to put into Lightbox
	 * @param {number} params.width - desired width of the Lightbox
	 * @param {number} params.height - desired height of the Lightbox
	 * @param {boolean} params.scalable - extend iframe to maximum sensible size of the Lightbox
	 * @param {boolean} [params.canHop] detect ad in the embedded iframe
	 * @param {string}  [params.slotName] name of the original slot (required if params.canHop set to true)
	 */
	function show(params) {
		log(['show', params], 'debug', logGroup);

		var adContainer = doc.createElement('DIV'),
			adIframe = iframeWriter.getIframe({
				code: params.code,
				height: params.height,
				width: params.width,
				classes: 'wikia-ad-iframe'
			}),
			async = params.canHop && params.slotName,
			gptEventMock = {
				size: {
					width: params.width,
					height: params.height
				}
			},
			modalHandler,
			skin = adContext.getContext().targeting.skin,
			lightboxParams = lightBoxExpansionModel[skin];

		if (skin === 'mercury') {
			modalHandler = mercuryModalHandler;
		} else if (skin === 'oasis') {
			modalHandler = oasisModalHandler;
		} else {
			return;
		}

		function scaleAd() {
			var availableWidth = Math.max(
					win.innerWidth * lightboxParams.availableWidthRatio,
					lightboxParams.minWidth
				),
				availableHeight = Math.max(
					win.innerHeight * lightboxParams.availableHeightRatio - lightboxParams.heightSubtract,
					lightboxParams.minHeight
				),
				ratioWidth = availableWidth / params.width,
				ratioHeight = availableHeight / params.height,
				ratio = Math.min(ratioWidth, ratioHeight, lightboxParams.maximumRatio);

			adIframe.style.transform = 'scale(' + ratio + ')';
			adIframe.style.msTransform = 'scale(' + ratio + ')';
			adIframe.style.WebkitTransform = 'scale(' + ratio + ')';

			adIframe.style.transformOrigin = 'top left';
			adIframe.style.msTransformOrigin = 'top left';
			adIframe.style.WebkitTransformOrigin = 'top left';

			adContainer.style.width = Math.floor(params.width * ratio) + 'px';
			adContainer.style.height = Math.floor(params.height * ratio) + 'px';
		}

		function scaleAdIfNeeded() {
			if (params.scalable) {
				scaleAd();
				win.addEventListener('resize', adHelper.throttle(function () {
					scaleAd();
				}));
			}
		}

		adIframe.style.maxWidth = 'none';
		adContainer.appendChild(adIframe);

		if (async) {
			adIframe.addEventListener('load', function () {
				adDetect.onAdLoad(params.slotName + ' (modal inner iframe)', gptEventMock, adIframe, function () {
					log(['ad detect', params.slotName, 'success'], 'info', logGroup);
					win.postMessage('{"AdEngine":{"slot_' + params.slotName + '":true,"status":"success"}}', '*');
					modalHandler.show();
				}, function () {
					log(['ad detect', params.slotName, 'hop'], 'info', logGroup);
					win.postMessage('{"AdEngine":{"slot_' + params.slotName + '":true,"status":"hop"}}', '*');
				});
			});
		}

		scaleAdIfNeeded();
		modalHandler.create(adContainer, !async);
	}

	return {
		show: show
	};
});
