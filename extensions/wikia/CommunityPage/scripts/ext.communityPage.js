require([
	'jquery',
	'wikia.ui.factory',
    'wikia.mustache',
    'communitypage.templates.mustache',
    'wikia.nirvana'
], function ($, uiFactory, mustache, templates, nirvana) {
	'use strict';

	// "private" vars - don't access directly. Use getUiModalInstance().
	var uiModalInstance, modalNavHtml;

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

	function getModalNavHtml() {
		var $deferred = $.Deferred();

		if (modalNavHtml) {
			$deferred.resolve(modalNavHtml);
		} else {
			nirvana.sendRequest({
				controller: 'CommunityPageSpecial',
				method: 'getModalHeaderData',
				format: 'json',
				type: 'get'
			})
			.then(function (response) {
				modalNavHtml = mustache.render(templates.modalHeader, response);
				$deferred.resolve(modalNavHtml);
			});
		}

		return $deferred;
	}

	function openCommunityModal() {
		$.when(
			getUiModalInstance(),
			getModalNavHtml()
		).then(function (uiModal, navHtml) {
			var createPageModalConfig = {
				vars: {
					id: 'CommunityPageModalDialog',
					size: 'medium',
					content: '',
					title: $.msg('communitypage-modal-title'),
					classes: ['CommunityPageModalDialog']
				}
			};
			uiModal.createComponent(createPageModalConfig, function (modal) {
				console.log(modal);

				// TODO: this is an oversimplified method for populating content
				// assumes we're opening the modal on the leaderboard section
				nirvana.sendRequest({
					controller: 'CommunityPageSpecial',
					method: 'getTopContributorsData',
					format: 'json',
					type: 'get'
				}).then(function (response) {
					var html = navHtml + mustache.render(templates.topContributors, response);

					modal.$content
						.addClass('ContributorsModule ContributorsModuleModal')
						.html(html)
						.find('.modal-nav-leaderboard').addClass('active');

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
		openCommunityModal();
	});
});
