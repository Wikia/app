require([
	'jquery',
	'wikia.ui.factory',
	'wikia.mustache',
	'communitypage.templates.mustache',
	'wikia.nirvana',
	'wikia.throbber',
	'wikia.tracker'
], function ($, uiFactory, mustache, templates, nirvana, throbber, tracker) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		category: 'community-page',
		trackingMethod: 'analytics'
	});

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
				type: 'get',
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
				modal.$content
					.addClass('ContributorsModule ContributorsModuleModal')
					.html(navHtml + mustache.render(templates.modalLoadingScreen))
					.find(tabToActivate.className).children().addClass('active');

				throbber.show($('.throbber-placeholder'));

				modal.show();
				initModalTracking();

				window.activeModal = modal;
				switchCommunityModalTab(tabToActivate);
			});
		});
	}

	function switchCommunityModalTab(tabToActivate) {
		getModalNavHtml().then(function (navHtml) {
			// Switch highlight to new tab
			window.activeModal.$content
				.html(navHtml + mustache.render(templates.modalLoadingScreen))
				.find(tabToActivate.className).children().addClass('active');

			throbber.show($('.throbber-placeholder'));

			getModalTabContentsHtml(tabToActivate).then(function (tabContentHtml) {
				window.activeModal.$content
					.html(navHtml + tabContentHtml)
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

	$(document).on( 'click', '#modalTabAdmins', function (event) {
		switchCommunityModalTab(tabs.TAB_ADMINS);
		event.preventDefault();
	});

	$(document).on( 'click', '#modalTabLeaderboard', function (event) {
		switchCommunityModalTab(tabs.TAB_LEADERBOARD);
		event.preventDefault();
	});

	function initTracking() {
		// Track clicks in contribution module
		$('.ContributorsModule').on('mousedown touchstart', 'a',  function (event) {
			var data = $(event.currentTarget).data('tracking');

			if (typeof(data) !== 'undefined') {
				track({
					label: data,
				});
			}
		});
	}

	function initModalTracking() {
		// Track clicks in contribution modal
		$('#CommunityPageModalDialog').on('mousedown touchstart', 'a', function (event) {
			var data = $(event.currentTarget).data('tracking');

			if (typeof(data) !== 'undefined') {
				track({
					label: data,
				});
			}
		});

		// Track clicks on modal close button
		$('.close[title=\'close\']').on('mousedown touchstart', function (event) {
			track({
				label: 'modal-close',
			});
		});
	}

	$(function () {
		initTracking();

		// prefetch UI modal on DOM ready
		getUiModalInstance();

		// prefetch modal contents
		getModalTabContentsHtml(tabs.TAB_ALL);
		getModalTabContentsHtml(tabs.TAB_ADMINS);
		getModalTabContentsHtml(tabs.TAB_LEADERBOARD);
	});
});
