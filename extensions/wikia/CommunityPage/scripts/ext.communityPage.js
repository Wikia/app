require([
	'jquery',
	'wikia.ui.factory'
], function ($, uiFactory) {
	'use strict';

	// "private" var - don't access directly. Use getUiModalInstance().
	var uiModalInstance;

	function getUiModalInstance() {
		var $deferred = $.Deferred();

		if (uiModalInstance) {
			$deferred.resolve(uiModalInstance);
		} else {
			uiFactory.init(['modal']).then(function (uiModal) {
				uiModalInstance = uiModal;
				$deferred.resolve(uiModalInstance);
			});
		}

		return $deferred;
	}

	function openCommunityModal() {
		getUiModalInstance().then(function (uiModal) {
			var createPageModalConfig = {
				vars: {
					id: 'CommunityPageModalDialog',
					size: 'medium',
					title: $.msg('communitypage-modal-title'),
					content: 'bar',
					classes: ['modalContent, CommunityPageModalDialog']
				}
			};
			uiModal.createComponent(createPageModalConfig, function (modal) {
				console.log(modal);

				modal.show();
			});
		});
	}

	$(function () {
		// prefetch UI modal on DOM ready
		getUiModalInstance();

		// test code to open modal on demand
		window.openCommModal = openCommunityModal;
	});
});
