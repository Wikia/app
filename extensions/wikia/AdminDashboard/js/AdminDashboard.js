var AdminDashboardChrome = {
	init: function() {
		AdminDashboardChrome.rail = $('#AdminDashboardRail');
		AdminDashboardChrome.drawer = $('#AdminDashboardDrawer');
		AdminDashboardChrome.wikiaArticle = $('#WikiaArticle');
		AdminDashboardChrome.arrow = $('#AdminDashboardDrawer .arrow');
		AdminDashboardChrome.drawer.click(AdminDashboardChrome.toggleDrawer);
		AdminDashboardChrome.initArrow();
	},
	initArrow: function() {
		// add arrow 100px from the top if current arrow is below the fold
		if (AdminDashboardChrome.arrow.length && AdminDashboardChrome.arrow.offset().top > ($(window).height() - 200)) {
			AdminDashboardChrome.drawer.append('<span class="arrow atf"></span>');
			AdminDashboardChrome.arrow = $('#AdminDashboardDrawer .arrow');
		}
	},
	collapseDrawer: function() {
		AdminDashboardChrome.arrow.removeClass('expanded');
		AdminDashboardChrome.wikiaArticle.removeClass('expanded');
		AdminDashboardChrome.rail.show();
		AdminDashboardChrome.isCollapsed = true;
	},
	expandDrawer: function() {
		AdminDashboardChrome.rail.hide();
		AdminDashboardChrome.wikiaArticle.addClass('expanded');
		AdminDashboardChrome.arrow.addClass('expanded');
		AdminDashboardChrome.isCollapsed = false;
	},
	toggleDrawer: function() {
		if(AdminDashboardChrome.rail.is(':visible')) {
			AdminDashboardChrome.expandDrawer();
		} else {
			AdminDashboardChrome.collapseDrawer();
		}
		AdminDashboardChrome.saveState();
	},
	restoreDefaultState: function() {
		if(AdminDashboardChrome.isCollapsed) {
			AdminDashboardChrome.collapseDrawer();
		} else {
			AdminDashboardChrome.expandDrawer();
		}
	},
	saveState: function() {
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'AdminDashboardSpecialPage',
			method: 'saveDrawerState',
			format: 'json',
			state: AdminDashboardChrome.isCollapsed
		}, function(res) {
			// do nothing
		});
	}
};

var AdminDashboard = {
	controls: {},
	section: {},
	externalComponents: {},
	init: function() {
		// precache
		AdminDashboard.cc = $('#AdminDashboard');
		
		if(AdminDashboard.cc.length == 0) {
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
		AdminDashboard.allControls.hover(function() {
			var el = $(this);
			AdminDashboard.tooltip = $(this).closest('.control-section').find('header .tooltip');
			AdminDashboard.tooltip.text(el.data('tooltip'));
		}, function() {
			AdminDashboard.tooltip.text('');
		}).click(AdminDashboard.handleControlClick);

		AdminDashboard.allTabs.click(function(e) {
			e.preventDefault();
			var el = $(this);
			AdminDashboard.ui.resetAll();
			AdminDashboard.ui.selectTab(el);
			AdminDashboard.ui.showSection(el.data('section'));
		});
	},
	handleControlClick: function(e) {
		var control = $(this).data('control');
		if(control) {
			e.preventDefault();
			// load content
			AdminDashboard.ui.resetAll();
			AdminDashboard.ui.selectTab(AdminDashboard.generalTab);
			AdminDashboard.ui.showSection('contentarea');
			AdminDashboard.contentload['load'+control]();
		}
		var modal = $(this).data('modal');
		if (modal) {
			e.preventDefault();
			AdminDashboard.modalLoad['load'+modal]();
		}
	},
	ui: {
		resetAll: function() {
			AdminDashboard.ui.deselectAllTabs();
			AdminDashboard.ui.hideAllSections();
			AdminDashboard.section.contentarea.html('Loading...');	//i18n this later
			AdminDashboard.wikiaArticle.removeClass('AdminDashboardChromedArticle expanded');
			$('.AdminDashboardDrawer, .AdminDashboardNavigation, .AdminDashboardArticleHeader').remove();
			if(typeof FounderProgressList != 'undefined') {
				FounderProgressList.hideListModal();
			}
			AdminDashboardChrome.rail.show();
		},
		hideAllSections: function() {
			for(var s in AdminDashboard.section) {
				$(AdminDashboard.section[s]).hide();
			}
		},
		showSection: function(section) {
			AdminDashboard.section[section].show();
		},
		deselectAllTabs: function() {
			AdminDashboard.allTabs.removeClass('active');
		},
		selectTab: function(tab) {
			$(tab).addClass('active');
		}
	},
	contentload: {
		loadSpecialPage: function(page, callback) {
			$.post(wgScriptPath + '/wikia.php', {
				controller: 'AdminDashboardSpecialPage',
				method: 'chromedArticleHeader',
				page: page,
				headerText: ''
			}, function(html) {
				AdminDashboard.wikiaArticle.addClass('AdminDashboardChromedArticle');
				AdminDashboard.wikiaArticle.prepend(html);
				AdminDashboard.wikiaArticle.find('.AdminDashboardNavigation a').click(function(e) {
					e.preventDefault();
					AdminDashboard.ui.resetAll();
					AdminDashboard.ui.selectTab(AdminDashboard.generalTab);
					AdminDashboard.ui.showSection('general');
				});
				AdminDashboardChrome.init();
				AdminDashboardChrome.restoreDefaultState();
			});
			AdminDashboard.section.contentarea.load(wgScriptPath + '/wikia.php', {
				controller: 'AdminDashboardSpecialPage',
				method: 'GetSpecialPage',
				page: page
			}, function(response){
				if(callback && typeof callback == 'function') {
					callback();
				}
				AdminDashboardChrome.initArrow();
			});
		},
		loadListUsers: function() {
			var sassUrl = $.getSassCommonURL('/extensions/wikia/Listusers/css/table.scss');
			$.getResources([wgScriptPath + '/extensions/wikia/Listusers/js/jquery.dataTables.min.js'], function() {
				AdminDashboard.contentload.loadSpecialPage('Listusers');
			});
		},
		loadUserRights: function() {
			AdminDashboard.contentload.loadSpecialPage('UserRightsPage');
		},
		loadCategories: function() {
			AdminDashboard.contentload.loadSpecialPage('Categories');
		},
		loadMultipleUpload: function() {
			AdminDashboard.contentload.loadSpecialPage('MultipleUpload');
		},
		loadRecentChanges: function() {
			AdminDashboard.contentload.loadSpecialPage('Recentchanges');
		}
	},
	modalLoad: {
		loadAddPage: function() {
			CreatePage.openDialog();
		},
		loadAddPhoto: function() {
			UploadPhotos.showDialog();
		}
	}
};

var AdminDashboardTracking = {
	init: function() {
		$('#AdminDashboardHeader, #AdminDashboardTabs, #WikiaArticle').bind('click', function(e) {
			var node = false;
			var target = $(e.target);
			if(target.is('a')) {
				node = target;
			} else {
				node = target.closest('a');
			}
			
			if(node) {
				var tracking = node.data('tracking');
				if(tracking) {
					$.tracker.byStr('admindashboard/' + tracking);
				}
			}
		});
		
		$('#AdminDashboardHeader nav a').bind('click', function(e) {
			var target = $(e.target);
			if(target.hasClass('text')) {
				$.tracker.byStr('admindashboard/header/help');
			} else {
				$.tracker.byStr('admindashboard/header/exit');
			}
		});
	}
};

$(function() {
	AdminDashboard.init();
	AdminDashboardChrome.init();
	AdminDashboardTracking.init();
});