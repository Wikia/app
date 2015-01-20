/*global define*/
define('ext.wikia.adEngine.slot.interstitial', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'wikia.ui.factory'
], function (log, win, doc, uiFactory) {
	'use strict';

	var slotDiv,
		logGroup = 'ext.wikia.adEngine.slot.interstitial',
		slotName = 'MODAL_INTERSTITIAL_5',
		modalConfig = {
			vars: {
				id: slotName + '_AD',
				size: 'medium',
				content: '<div id="' + logGroup + '.content" class="modal_interstitial ad-centered-wrapper"></div>',
				title: 'Advertisement',
				closeText: 'Close',
				buttons: []
			}
		};

	function onAdSuccess() {
		uiFactory.init('modal').then(function (uiModal) {
			uiModal.createComponent(modalConfig, function(modal) {
					doc.getElementById(logGroup + '.content').appendChild(slotDiv);
					modal.show();
				}
			);
		});
	}

	function init() {
		log(['init', slotName], 'debug', logGroup);

		slotDiv = doc.createElement('div');
		slotDiv.id = slotName;
		slotDiv.className = 'wikia-ad noprint';
		doc.querySelector('body').appendChild(slotDiv);

		win.adslots2.push({
			slotname: slotName,
			success: onAdSuccess
		});
	}

	return {
		init: init
	};

});
