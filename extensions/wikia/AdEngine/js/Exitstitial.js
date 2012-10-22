/**
 * Exitstitial ads
 */
(function(window, document, location, $) {
	'use strict';

	var modalId = 'ExitstitialInfobox'
		, modalWidth = 840
		, adSlot = 'EXIT_STITIAL_BOXAD_1'
		, redirectDelay = window.wgOutboundScreenRedirectDelay || 10
		, enabled = window.wgAdsInterstitialsEnabled
	;

	// Check external links should be ad-guarded
	if (!enabled) {
		return;
	}

	$(document).ready(function() {
		$('.WikiaArticle a.external.exitstitial').click(function(event) {
			event.preventDefault();

			var url = $(this).attr('href');

			$.getMessages('AdEngine', function() {
				var $goBack = $('<a></a>').attr('href', '').text($.msg('adengine-exitstitial-go-back'))
					, modalTitle = $.msg('adengine-exitstitial-title-template', window.wgSiteName)
					, $modal
					, $modalBody = $('<div></div>')
					, $modalText = $('<p></p>').text($.msg('adengine-exitstitial-redirecting') + ' ')
					, $modalAd = $('<div class="ad-wrapper"></div>')
					, $ad = $('<div class="wikia-ad noprint"></div>').attr('id', adSlot)
					, $modalSkip = $('<div class="close-exitstitial-ad"></div>')
					, $skipAd = $('<a></a>').attr('href', url).text($.msg('adengine-exitstitial-button'))
				;

				$modalText.append($goBack);
				$modalSkip.append($skipAd);

				$goBack.click(function(event) {
					event.preventDefault();
					$modal.closeModal();
				});

				$modalBody.append($modalText).append($modalAd).append($modalSkip);

				// Show modal
				$modal = $.showModal(modalTitle, $modalBody, {
					id: modalId,
					width: modalWidth
				});

				// Show ads
				$modalAd.html($('<div></div>').html($ad));
				window.adslots2.push([adSlot]);

				// Skip ads after N seconds
				setTimeout(function() {
					$skipAd.filter(':visible').each(function() {
						location.href = url;
					});
				}, redirectDelay * 1000);
			});
		});
	});
}(window, document, location, jQuery));
