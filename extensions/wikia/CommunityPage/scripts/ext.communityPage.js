require([
	'jquery',
	'wikia.ui.factory',
	'wikia.mustache',
	'communitypage.templates.mustache',
	'wikia.nirvana',
	'wikia.throbber',
	'wikia.tracker',
	'wikia.window'
], function ($, uiFactory, mustache, templates, nirvana, throbber, tracker, window) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		category: 'community-page',
		trackingMethod: 'analytics',
	});

	// "private" vars - don't access directly. Use getUiModalInstance().
	var uiModalInstance, modalNavHtml, activeTab, allMembersCount, allAdminsCount;

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
			}
		},
		tabLinkClass = '.modal-tab-link';

	function init() {
		initTracking();

		$('#openModalTopAdmins').click(function (event) {
			event.preventDefault();
			openCommunityModal(tabs.TAB_ADMINS);
		});

		$('#viewAllMembers').click(function (event) {
			event.preventDefault();
			openCommunityModal(tabs.TAB_ALL);
		});

		$('#community-page-create-event').click(function (event) {
			event.preventDefault();
			openCreateEventModal();
		});

		$('#community-page-delete-event').click(function (event) {
			event.preventDefault();
			deleteEvent();
		});
	}

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
				leaderboardText: $.msg('communitypage-top-contributors-week'),
				allMembersCount: allMembersCount,
				allAdminsCount: allAdminsCount,
			});
			$deferred.resolve(modalNavHtml);
		}

		return $deferred;
	}

	function updateModalHeader() {
		if (typeof allMembersCount !== 'undefined') {
			$('#allCount').text('(' + allMembersCount + ')');
		}

		if (typeof allAdminsCount !== 'undefined') {
			$('#allAdminsCount').text('(' + allAdminsCount + ')');
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
				data: {
					uselang: window.wgUserLanguage
				},
				format: 'json',
				type: 'get',
			}).then(function (response) {
				if (response.hasOwnProperty('membersCount')) {
					allMembersCount = response.membersCount;
				}

				allAdminsCount = response.allAdminsCount;

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

	function meetupData() {
		var $deferred = $.Deferred();

		nirvana.sendRequest({
			controller: 'CommunityPageSpecial',
			method: 'meetupData',
			format: 'json',
			type: 'get',
		}).then(function (response) {
			$deferred.resolve(response);
		});

		return $deferred;
	}

	function saveEvent(user, venue, date, description) {
		var $deferred = $.Deferred();

		console.log("desc = " + description);

		nirvana.sendRequest({
			controller: 'CommunityPageSpecial',
			method: 'saveEvent',
			format: 'json',
			type: 'get',
			data: {
				user: user,
				venue: venue,
				date: date,
				description: description,
			},
		}).then(function (response) {
			$deferred.resolve(response);
			location.reload();
		});

		return $deferred;
	}

	function deleteEvent() {
		var $deferred = $.Deferred();

		nirvana.sendRequest({
			controller: 'CommunityPageSpecial',
			method: 'deleteEvent',
			format: 'json',
			type: 'get',
		}).then(function (response) {
			$deferred.resolve(response);
			location.reload();
		});

		return $deferred;
	}

	function openCommunityModal(tabToActivate) {
		tabToActivate = tabToActivate || tabs.TAB_LEADERBOARD;

		$.when(
			getUiModalInstance(),
			getModalNavHtml()
		).then(function (uiModal, navHtml) {
			var $header = getHeader(navHtml),
				createPageModalConfig = {
					vars: {
						classes: ['CommunityPageModalDialog'],
						content: '',
						htmlTitle: $header.html(),
						id: 'CommunityPageModalDialog',
						size: 'medium',
					}
				};

			uiModal.createComponent(createPageModalConfig, function (modal) {
				modal.$content
					.addClass('contributors-module contributors-module-modal')
					.html(mustache.render(templates.modalLoadingScreen))
					.find(tabToActivate.className).children(tabLinkClass).addClass('active');

				throbber.show($('.throbber-placeholder'));

				modal.show();
				initModalTracking(modal);
				initModalEventBindings(modal);

				window.activeModal = modal;
				switchCommunityModalTab(tabToActivate);
			});
		});
	}

	function openCreateEventModal() {
		$.when(
			getUiModalInstance(),
			meetupData()
		).then(function(uiModal, meetupData) {
				var header = `<h3>Create event for location ${meetupData.currentUser.location}</h3>`;

				var createPageModalConfig = {
						vars: {
							classes: ['CommunityPageModalDialog'],
							content: '',
							htmlTitle: header,
							id: 'CommunityPageModalDialog',
							size: 'medium',
						}
					};

				uiModal.createComponent(createPageModalConfig, function (modal) {
					modal.$content
						.addClass('contributors-module meetup-modal')
						.html(mustache.render(templates.createEvent, meetupData))

					modal.show();

					$('#community-page-new-event').click(function (event) {
						event.preventDefault();

						var venue = $('#venue').val(),
							date = $('#date').val(),
							description = $('#description').val();

						if (!venue || !date || !description) {
							alert("Missing data!");
						} else {
							var d = new Date(date);

							if (isNaN(d.getDay())) {
								alert('Invalid date format');
							} else {
								saveEvent(meetupData.currentUser.name, venue, d, description);
							}
						}
					});
				});
		});
	}


	function getHeader(navHtml) {
		return $('<div>')
			.append($('<h3>').html($.msg('communitypage-modal-title')))
			.append(navHtml);
	}

	function markActiveTab(tabToActivate) {
		var $modal = window.activeModal.$element;

		$modal.find(tabLinkClass).removeClass('active');
		$modal.find(tabToActivate.className).children(tabLinkClass).addClass('active');
	}

	function switchCommunityModalTab(tabToActivate) {
		var $content = window.activeModal.$content,
			$modalLoadingScreen = $(mustache.render(templates.modalLoadingScreen));

		markActiveTab(tabToActivate);
		$content.html($modalLoadingScreen);
		throbber.show($modalLoadingScreen);

		getModalTabContentsHtml(tabToActivate).then(function (tabContentHtml) {
			$content.html(tabContentHtml);
			updateModalHeader();
			activeTab = tabToActivate;
		});
	}

	function initModalEventBindings(modal) {
		modal.$element
			.on('click', '#modalTabAll', function (event) {
				event.preventDefault();
				switchCommunityModalTab(tabs.TAB_ALL);
			})
			.on('click', '#modalTabAdmins', function (event) {
				event.preventDefault();
				switchCommunityModalTab(tabs.TAB_ADMINS);
			})
			.on('click', '#modalTabLeaderboard', function (event) {
				event.preventDefault();
				switchCommunityModalTab(tabs.TAB_LEADERBOARD);
			});
	}

	function handleClick (event, category) {
		var label = event.currentTarget.getAttribute('data-tracking');

		if (label !== null && label.length > 0) {
			track({
				category: category,
				label: label,
			});
		}
	}

	function initTracking() {
		// Track clicks in contribution module
		$('.contributors-module').on('mousedown touchstart', 'a', function (event) {
			handleClick(event, 'community-page-contribution-module');
		});

		// Track clicks in the Recent Activity module
		$('.recent-activity-module').on('mousedown touchstart', 'a', function (event) {
			handleClick(event, 'community-page-recent-activity-module');
		});

		// Track clicks in the Help module
		$('.help-module').on('mousedown touchstart', 'a', function (event) {
			handleClick(event, 'community-page-help-module');
		});

		$('.community-policy-module').on('mousedown touchstart', 'a', function (event) {
			handleClick(event, 'community-page-community-policy-module');
		});

		// Track clicks in the Insights modules
		$('.community-page-insights-module').on('mousedown touchstart', 'a', function (event) {
			var category = event.delegateTarget.getAttribute('data-tracking');

			if (category !== null && category.length > 0) {
				handleClick(event, category);
			}
		});
	}

	function initModalTracking(modal) {
		// Track clicks in contribution modal
		$('#CommunityPageModalDialog').on('mousedown touchstart', 'a', function (event) {
			handleClick(event, 'community-page-contribution-modal');
		});

		// Track clicks on modal close button
		modal.bind('close', function () {
			track({
				label: 'modal-close',
			});
		});
	}

	$(init);
});
