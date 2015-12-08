/*global define*/
define('ext.wikia.adEngine.template.floor', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.gpt.adDetect',
	'wikia.log',
	'wikia.document',
	'wikia.iframeWriter',
	'wikia.window'
], function (adContext, adDetect, log, doc, iframeWriter, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.floor',
		floorId = 'ext-wikia-adEngine-template-floor',
		floorHtml = '<div id="' + floorId + '">' +
			'<div class="background"></div>' +
			'<div class="ad"></div>' +
			'<a class="close" title="Close" href="#">' +
			'<svg role="img" class="ads-floor-close-button"><use xlink:href="#close"></use></svg>' +
			'</a>' +
			'</div>',
		$ = win.$;

	/**
	 * Show the floor ad.
	 *
	 * You need to supply the HTML to put to the floor ad container and the desired dimensions
	 * of the container. The semi-transparent bar will be always 90px high, so the ad can stick out
	 * a little bit (for example if the desired container height is 100px).
	 *
	 * If you supply the onClick callback the code fires when you click within the iframe.
	 * Note the standard event bubbling applies, so it's possible some element within the iframe
	 * stops the event propagation. Flash will stop propagation for sure.
	 *
	 * If you supply params.canHop, the code sniffs the ad in the supplied code by inspecting the iframe
	 * contents. The code will issue postMessage with either success or hop, so you need to pass
	 * the params.slotName as well. The creative will need to have AdEngine_adType = 'floor'
	 *
	 * @param {Object}  params
	 * @param {string}  params.code HTML code to put into floor container
	 * @param {number}  params.width width of the ad to put into floor container
	 * @param {number}  params.height width of the ad to put into floor container
	 * @param {number}  [params.onClick] function to call when floor iframe is clicked
	 * @param {boolean} [params.canHop] detect ad in the embedded iframe
	 * @param {string}  [params.slotName] name of the original slot (required if params.canHop set to true)
	 */
	function show(params) {
		log(['show', params], 'debug', logGroup);

		var iframe = iframeWriter.getIframe({
				code: params.code,
				width: params.width,
				height: params.height
			}),
			$floor = $('#' + floorId),
			isFloorPresent = $floor.length > 0,
			gptEventMock = {
				size: {
					width: params.width,
					height: params.height
				}
			},
			async = params.canHop && params.slotName;

		function showFloor() {
			var skin = adContext.getContext().targeting.skin;

			if (skin === 'oasis') {
				win.WikiaBar.hideContainer();
			}

			$floor.removeClass('hidden');
		}

		if (params.onClick) {
			$(iframe).on('load', function () {
				var iframeDoc = iframe.contentWindow.document;
				$('html', iframeDoc).css('cursor', 'pointer').on('click', params.onClick);
			});
		}

		if (async) {
			log(['show', params.slotName, 'can hop'], 'info', logGroup);
			$(iframe).on('load', function () {
				adDetect.onAdLoad(params.slotName + ' (floor inner iframe)', gptEventMock, iframe, function () {
					log(['ad detect', params.slotName, 'success'], 'info', logGroup);
					win.postMessage('{"AdEngine":{"slot_' + params.slotName + '":true,"status":"success"}}', '*');
					showFloor();
				}, function () {
					log(['ad detect', params.slotName, 'hop'], 'info', logGroup);
					win.postMessage('{"AdEngine":{"slot_' + params.slotName + '":true,"status":"hop"}}', '*');
				});
			});
		}

		if (!isFloorPresent) {
			$floor = $(floorHtml);
			$floor.addClass('hidden');
			$(doc.body).append($floor);
		}

		$floor.find('a.close').click(function (event) {
			event.preventDefault();
			$floor.addClass('hidden');
		});
		$floor.find('.ad').html(iframe);

		if (!async) {
			showFloor();
		}
	}

	adContext.addCallback(function () {
		var floor = doc.getElementById(floorId);
		if (floor) {
			floor.parentElement.removeChild(floor);
		}
	});

	return {
		show: show
	};
});
