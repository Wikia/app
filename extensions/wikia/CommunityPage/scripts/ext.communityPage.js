require([
	'jquery',
	'wikia.ui.factory',
	'wikia.mustache',
	'communitypage.templates.mustache',
	'wikia.nirvana'
], function ($, uiFactory, mustache, templates, nirvana) {
	'use strict';

	// "private" vars - don't access directly. Use getUiModalInstance().
	var uiModalInstance, modalNavHtml, activeTab, allMembersCount, adminsCount;

	var tabs = {
		TAB_ALL: {
			className: '.modal-nav-all',
			template: 'allMembers',
			request: 'getAllMembersData',
			cachedData: null,
		},
		TAB_ADMINS: {
			className: '.modal-nav-admins',
			template: 'allAdmins',
			request: 'getAllAdminsData',
			cachedData: null,
		},
		TAB_LEADERBOARD: {
			className: '.modal-nav-leaderboard',
			template: 'topContributorsModal',
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
			modalNavHtml = mustache.render(templates.modalHeader, {
				allText: $.msg('communitypage-modal-tab-all'),
				adminsText: $.msg('communitypage-modal-tab-admins'),
				leaderboardText: $.msg('communitypage-modal-tab-leaderboard'),
				allMembersCount: allMembersCount,
				adminsCount: adminsCount,
			});
			$deferred.resolve(modalNavHtml);
		}

		return $deferred;
	}

	function updateModalHeader() {
		if (typeof allMembersCount !== 'undefined') {
			$('#allCount').text('(' + allMembersCount + ')');
		}

		if (typeof adminsCount !== 'undefined') {
			$('#adminsCount').text('(' + adminsCount + ')');
		}
	}

	function getModalTabContentsHtml(tab) {
		var $deferred = $.Deferred();

		if (tab.cachedData) {
			$deferred.resolve(tab.cachedData);
		} else {
			nirvana.sendRequest({
				controller: 'CommunityPageSpecial',
				method: tab.request,
				format: 'json',
				type: 'get'
			}).then(function (response) {
				if (response.hasOwnProperty('members')) {
					allMembersCount = response.members.length;
				}

				if (response.hasOwnProperty('admins')) {
					adminsCount = response.admins.length;
				}

				tab.cachedData = mustache.render(templates[tab.template], response);
				$deferred.resolve(tab.cachedData);
			}, function (error) {
				$deferred.resolve(mustache.render(templates.loadingError, {
					loadingError: $.msg('communitypage-modal-tab-loadingerror'),
				}));
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
				var loading = mustache.render(templates.modalLoadingScreen, {
						loadingText: $.msg('communitypage-modal-tab-loading'),
					}),
					html = navHtml + loading;

				modal.$content
					.addClass('ContributorsModule ContributorsModuleModal')
					.html(html)
					.find(tabToActivate.className).children().addClass('active');

				modal.show();

				window.activeModal = modal;
				switchCommunityModalTab(tabToActivate);
			});
		});
	}

	function switchCommunityModalTab(tabToActivate) {
		getModalNavHtml().then(function (navHtml) {
			// Switch highlight to new tab
			var loading = mustache.render(templates.modalLoadingScreen, {
					loadingText: mw.html.escape($.msg('communitypage-modal-tab-loading')),
				}),
				html = navHtml + loading;

			window.activeModal.$content
				.html(html)
				.find(tabToActivate.className).children().addClass('active');

			getModalTabContentsHtml(tabToActivate).then(function (tabContentHtml) {
				html = navHtml + tabContentHtml;

				window.activeModal.$content
					.html(html)
					.find(tabToActivate.className).children().addClass('active');

				updateModalHeader();
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
