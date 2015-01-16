/*global define*/
define('ext.wikia.adEngine.slot.interstitial', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'wikia.ui.factory'
], function (log, win, doc, uiFactory) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.interstitial',
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

	function onModalReady(modal) {
		var div = doc.createElement('div');
		div.id = slotName;
		div.className = 'wikia-ad noprint';
		doc.getElementById(logGroup + '.content').appendChild(div);
		win.adslots2.push({
			slotname: slotName,
			success: function(){
				modal.show();
			}
		});
	}

	function init() {
		log(['init', slotName], 'debug', logGroup);
		uiFactory.init('modal').then(function (uiModal) {
			uiModal.createComponent(modalConfig, onModalReady);
		});
	}

	return {
		init: init
	};

});
