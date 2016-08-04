require(['jquery', 'mw', 'wikia.nirvana'], function ($, mw, nirvana) {
	var AdminDashboard = {
		controls: {},
		section: {},
		externalComponents: {},
		init: function () {
			// precache
			AdminDashboard.cc = $('#AdminDashboard');

			if (AdminDashboard.cc.length === 0) {
				return;
			}

			AdminDashboard.allControls = AdminDashboard.cc.find('.control');
			AdminDashboard.tabs = $('#AdminDashboardTabs');
			AdminDashboard.allTabs = AdminDashboard.tabs.find('.tab');
			AdminDashboard.generalTab = AdminDashboard.tabs.find('[data-section=general]');
			AdminDashboard.section.general = $('#AdminDashboardGeneral');
			AdminDashboard.section.advanced = $('#AdminDashboardAdvanced');
			AdminDashboard.section.contentarea = $('#AdminDashboardContentArea');
			AdminDashboard.wikiaArticle = $('#WikiaArticle');

			// events
			AdminDashboard.allControls.hover(function () {
				var el = $(this);
				AdminDashboard.tooltip = el.closest('.control-section').find('header .dashboard-tooltip');
				AdminDashboard.tooltip.text(el.data('tooltip'));
			}, function () {
				AdminDashboard.tooltip.text('');
			}).click(AdminDashboard.handleControlClick);

			// init addVideo jQuery plugin
			var addVideoButton = AdminDashboard.cc.find('.addVideoButton'),
				addVideoButtonReturnUrl = addVideoButton.data('return-url');

			if ($.fn.addVideoButton) { //FB#68272
				addVideoButton.addVideoButton({
					callbackAfterSelect: function (url, VET) {
						nirvana.postJson(
							// controller
							'VideosController',
							// method
							'addVideo',
							// data
							{
								token: mw.user.tokens.get('editToken'),
								url: url
							},
							// success callback
							function (formRes) {
								if (formRes.error) {
									new window.BannerNotification(formRes.error, 'error')
										.show();
								} else {
									VET.close();
									window.location = addVideoButtonReturnUrl;
								}
							},
							// error callback
							function () {
								new window.BannerNotification(
									$.msg('vet-error-while-loading'),
									'error'
								).show();
							}
						);
						// Don't move on to second VET screen.  We're done.
						return false;
					}
				});
			}

			AdminDashboard.allTabs.click(function (e) {
				e.preventDefault();
				var el = $(this);
				AdminDashboard.ui.resetAll();
				AdminDashboard.ui.selectTab(el);
				AdminDashboard.ui.showSection(el.data('section'));
			});

			AdminDashboard.cc.on('mousedown', 'a[data-tracking]', function (e) {
				var t = $(this);
				AdminDashboard.track(Wikia.Tracker.ACTIONS.CLICK, t.data('tracking'), null, {}, e);
			});
		},
		track: function (action, label, value, params, event) {
			Wikia.Tracker.track({
				category: 'admin-dashboard',
				action: action,
				browserEvent: event,
				label: label,
				trackingMethod: 'analytics',
				value: value
			}, params);
		},
		handleControlClick: function (e) {
			var modal = $(this).data('modal');
			if (modal) {
				e.preventDefault();
				AdminDashboard.modalLoad['load' + modal]();
			}
		},
		ui: {
			resetAll: function () {
				AdminDashboard.ui.deselectAllTabs();
				AdminDashboard.ui.hideAllSections();
				AdminDashboard.section.contentarea.html(mw.message('admindashboard-loading').escaped());
				AdminDashboard.wikiaArticle.removeClass('AdminDashboardChromedArticle expanded');
				$('.AdminDashboardDrawer, .AdminDashboardNavigation, .AdminDashboardArticleHeader').remove();
				if (typeof FounderProgressList !== 'undefined') {
					FounderProgressList.hideListModal();
				}
			},
			hideAllSections: function () {
				for (var s in AdminDashboard.section) {
					if (AdminDashboard.section.hasOwnProperty(s)) {
						$(AdminDashboard.section[s]).hide();
					}
				}
			},
			showSection: function (section) {
				AdminDashboard.section[section].show();
			},
			deselectAllTabs: function () {
				AdminDashboard.allTabs.removeClass('active');
			},
			selectTab: function (tab) {
				$(tab).addClass('active');
			}
		},
		modalLoad: {
			loadAddPage: function () {
				CreatePage.requestDialog();
			},
			loadAddPhoto: function () {
				UploadPhotos.showDialog();
			}
		}
	};

	$(AdminDashboard.init);
});
