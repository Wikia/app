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

	var tabs = {
		TAB_ALL: {
			className: '.modal-nav-all',
			template: 'allMembers',
			request: 'getAllMembersData',
		},
		TAB_ADMINS: {
			className: '.modal-nav-admins',
			template: 'topAdmins',
			request: 'getTopAdminsData',
		},
		TAB_LEADERBOARD: {
			className: '.modal-nav-leaderboard',
			template: 'topContributors',
			request: 'getTopContributorsData',
		},
	};

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

	function openCommunityModal(activeTab) {
		activeTab = activeTab || tabs.TAB_LEADERBOARD;

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
				nirvana.sendRequest({
					controller: 'CommunityPageSpecial',
					method: activeTab.request,
					format: 'json',
					type: 'get'
				}).then(function (response) {
					var html = navHtml + mustache.render(templates[activeTab.template], response);

					modal.$content
						.addClass('ContributorsModule ContributorsModuleModal')
						.html(html)
						.find(activeTab.className).children().addClass('active');

					modal.show();

					window.activeModal = modal;
				});
			});
		});
	}

	$('#viewAllMembers').click(function (event) {
		openCommunityModal(tabs.TAB_ALL);
		event.preventDefault();
	});


	$(function () {
		// prefetch UI modal on DOM ready
		getUiModalInstance();

		// test code to open modal on demand
		window.openCommModal = openCommunityModal;
		//openCommunityModal();
	});
});
