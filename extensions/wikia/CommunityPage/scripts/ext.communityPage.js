require([
	'jquery',
	'wikia.ui.factory',
    'wikia.mustache',
    'communitypage.templates.mustache',
    'wikia.nirvana'
], function ($, uiFactory, mustache, templates, nirvana) {
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

				nirvana.sendRequest({
					controller: 'CommunityPageSpecial',
					method: 'getTopContributorsData',
					format: 'json',
					type: 'get'
				}).then(function (response) {
					var html = mustache.render(templates.topContributors, response);

					modal.$content.html(html);

					modal.show();
				});
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
