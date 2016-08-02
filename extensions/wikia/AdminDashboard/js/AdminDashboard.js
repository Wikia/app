require(['jquery', 'mw', 'wikia.nirvana'], function($, mw, nirvana) {
	var AdminDashboard = {
		controls: {},
		section: {},
		externalComponents: {},
		init: function () {
			// precache
			this.cc = $('#AdminDashboard');

			if (this.cc.length === 0) {
				return;
			}

			this.allControls = this.cc.find('.control');
			this.tabs = $('#AdminDashboardTabs');
			this.allTabs = this.tabs.find('.tab');
			this.generalTab = this.tabs.find('[data-section=general]');
			this.section.general = $('#AdminDashboardGeneral');
			this.section.advanced = $('#AdminDashboardAdvanced');
			this.section.contentarea = $('#AdminDashboardContentArea');
			this.wikiaArticle = $('#WikiaArticle');

			// events
			this.allControls.hover(function () {
				var el = $(this);
				this.tooltip = el.closest('.control-section').find('header .dashboard-tooltip');
				this.tooltip.text(el.data('tooltip'));
			}, function () {
				this.tooltip.text('');
			}).click(this.handleControlClick);

			// init addVideo jQuery plugin
			var addVideoButton = this.cc.find('.addVideoButton'),
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

			this.allTabs.click(function (e) {
				e.preventDefault();
				var el = $(this);
				this.ui.resetAll();
				this.ui.selectTab(el);
				this.ui.showSection(el.data('section'));
			});

			this.cc.on('mousedown', 'a[data-tracking]', function (e) {
				var t = $(this);
				this.track(Wikia.Tracker.ACTIONS.CLICK, t.data('tracking'), null, {}, e);
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
				this.modalLoad['load' + modal]();
			}
		},
		ui: {
			resetAll: function () {
				this.ui.deselectAllTabs();
				this.ui.hideAllSections();
				this.section.contentarea.html(mw.message('admindashboard-loading').escaped());
				this.wikiaArticle.removeClass('AdminDashboardChromedArticle expanded');
				$('.AdminDashboardDrawer, .AdminDashboardNavigation, .AdminDashboardArticleHeader').remove();
				if (typeof FounderProgressList !== 'undefined') {
					FounderProgressList.hideListModal();
				}
			},
			hideAllSections: function () {
				for (var s in this.section) {
					if (this.section.hasOwnProperty(s)) {
						$(this.section[s]).hide();
					}
				}
			},
			showSection: function (section) {
				this.section[section].show();
			},
			deselectAllTabs: function () {
				this.allTabs.removeClass('active');
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

	$(AdminDashboard.init.bind(AdminDashboard));
});
