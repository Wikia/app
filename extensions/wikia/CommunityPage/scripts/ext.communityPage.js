require([
	'jquery',
	'wikia.ui.factory',
	'wikia.mustache',
	'communitypage.templates.mustache',
	'wikia.nirvana'
], function ($, uiFactory, mustache, templates, nirvana) {
	'use strict';

	// "private" vars - don't access directly. Use getUiModalInstance().
	var uiModalInstance, modalNavHtml, activeTab;

	var tabs = {
		TAB_ALL: {
			className: '.modal-nav-all',
			template: 'allMembers',
			request: 'getAllMembersData',
			cachedData: null,
		},
		TAB_ADMINS: {
			className: '.modal-nav-admins',
			template: 'topAdmins',
			request: 'getTopAdminsData',
			cachedData: null,
		},
		TAB_LEADERBOARD: {
			className: '.modal-nav-leaderboard',
			template: 'topContributors',
			request: 'getTopContributorsData',
			cachedData: null,
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

	function getModalTabContentsHtml(tab) {
		var $deferred = $.Deferred();

		if (tab.cachedData) {
			$deferred.resolve(tab.cachedData);
		} else {
			nirvana.sendRequest({
				controller: 'CommunityPageSpecial',
				method: tab.request,
				data: {mcache: 'writeonly'}, // fixme: temporary debug variable
				format: 'json',
				type: 'get'
			}).then(function (response) {
				tab.cachedData = mustache.render(templates[tab.template], response);
				$deferred.resolve(tab.cachedData);
			});
		}

		return $deferred;
	}

	function openCommunityModal(tabToActivate) {
		tabToActivate = tabToActivate || tabs.TAB_LEADERBOARD;

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
				getModalTabContentsHtml(tabToActivate).then(function (tabContentHtml) {
					var html = navHtml + tabContentHtml;

					modal.$content
						.addClass('ContributorsModule ContributorsModuleModal')
						.html(html)
						.find(tabToActivate.className).children().addClass('active');

					modal.show();
					activeTab = tabToActivate;

					window.activeModal = modal;
				});
			});
		});
	}

	function switchCommunityModalTab(tabToActivate) {
		if (tabToActivate === activeTab) {
			return;
		}

		getModalNavHtml().then(function (navHtml) {
			var html;

			// Switch highlight to new tab
			// fixme: Loading indicator should be via a template.
			html = navHtml + $.msg('communitypage-modal-loading');
			window.activeModal.$content
				.html(html)
				.find(tabToActivate.className).children().addClass('active');

			getModalTabContentsHtml(tabToActivate).then(function (tabContentHtml) {
				html = navHtml + tabContentHtml;

				window.activeModal.$content
					.html(html)
					.find(tabToActivate.className).children().addClass('active');

				activeTab = tabToActivate;
			});
		});
	}

	$('#viewAllMembers').click(function (event) {
		openCommunityModal(tabs.TAB_ALL);
		event.preventDefault();
	});

	$(document).on( 'click', '#modalTabAll', function (event) {
		switchCommunityModalTab(tabs.TAB_ALL);
		event.preventDefault();
	});

	$(document).on( 'click', '#modalTabAdmins', function () {
		switchCommunityModalTab(tabs.TAB_ADMINS);
		event.preventDefault();
	});

	$(document).on( 'click', '#modalTabLeaderboard', function () {
		switchCommunityModalTab(tabs.TAB_LEADERBOARD);
		event.preventDefault();
	});


	$(function () {
		// prefetch UI modal on DOM ready
		getUiModalInstance();

		// prefetch modal contents
		getModalTabContentsHtml(tabs.TAB_ALL);
		getModalTabContentsHtml(tabs.TAB_ADMINS);
		getModalTabContentsHtml(tabs.TAB_LEADERBOARD);
	});
});
