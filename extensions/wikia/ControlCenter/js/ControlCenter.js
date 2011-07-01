var ControlCenterChrome = {
	init: function() {
		ControlCenterChrome.rail = $('#ControlCenterRail');
		ControlCenterChrome.drawer = $('#ControlCenterDrawer');
		ControlCenterChrome.wikiaArticle = $('#WikiaArticle');
		ControlCenterChrome.arrow = $('#ControlCenterDrawer .arrow');
		ControlCenterChrome.drawer.click(function() {
			if(ControlCenterChrome.rail.is(':visible')) {
				ControlCenterChrome.rail.hide();
				ControlCenterChrome.wikiaArticle.addClass('expanded');
				ControlCenterChrome.arrow.addClass('expanded');
			} else {
				ControlCenterChrome.arrow.removeClass('expanded');
				ControlCenterChrome.wikiaArticle.removeClass('expanded');
				ControlCenterChrome.rail.show();
			}
		});
	}
};

var ControlCenter = {
	controls: {},
	section: {},
	init: function() {
		// precache
		ControlCenter.cc = $('#ControlCenter');
		
		if(ControlCenter.cc.length == 0) {
			return;
		}
		
		ControlCenter.allControls = ControlCenter.cc.find('.control');
		ControlCenter.tabs = $('#ControlCenterTabs');
		ControlCenter.allTabs = ControlCenter.tabs.find('.tab');
		ControlCenter.section.general = $('#ControlCenterGeneral');
		ControlCenter.section.advanced = $('#ControlCenterAdvanced');
		ControlCenter.section.contentarea = $('#ControlCenterContentArea');
		ControlCenter.wikiaArticle = $('#WikiaArticle');
		
		// events
		ControlCenter.allControls.hover(function() {
			var el = $(this);
			ControlCenter.tooltip = $(this).closest('.control-section').find('header .tooltip');
			ControlCenter.tooltip.text(el.data('tooltip'));
		}, function() {
			ControlCenter.tooltip.text('');
		}).click(ControlCenter.handleControlClick);

		ControlCenter.allTabs.click(function(e) {
			e.preventDefault();
			var el = $(this);
			ControlCenter.ui.resetAll();
			ControlCenter.ui.selectTab(el);
			ControlCenter.ui.showSection(el.data('section'));
		});
	},
	handleControlClick: function(e) {
		var control = $(this).data('control');
		if(control) {
			e.preventDefault();
			// load content
			ControlCenter.ui.resetAll();
			ControlCenter.ui.showSection('contentarea');
			ControlCenter.contentload['load'+control]();
		}
		var modal = $(this).data('modal');
		if (modal) {
			e.preventDefault();
			ControlCenter.modalLoad['load'+modal]();
		}
	},
	ui: {
		resetAll: function() {
			ControlCenter.ui.deselectAllTabs();
			ControlCenter.ui.hideAllSections();
			ControlCenter.section.contentarea.html('Loading...');	//i18n this later
			ControlCenter.wikiaArticle.removeClass('ControlCenterChromedArticle expanded');
			$('.ControlCenterDrawer, .ControlCenterNavigation, .ControlCenterArticleHeader').remove();
		},
		hideAllSections: function() {
			for(var s in ControlCenter.section) {
				$(ControlCenter.section[s]).hide();
			}
		},
		showSection: function(section) {
			ControlCenter.section[section].show();
		},
		deselectAllTabs: function() {
			ControlCenter.allTabs.removeClass('active');
		},
		selectTab: function(tab) {
			$(tab).addClass('active');
		}
	},
	contentload: {
		loadSpecialPage: function(page, callback) {
			$.post(wgScriptPath + '/wikia.php', {
				controller: 'ControlCenterSpecialPage',
				method: 'chromedArticleHeader',
				headerText: 'Replace Me'
			}, function(html) {
				ControlCenter.wikiaArticle.addClass('ControlCenterChromedArticle');
				ControlCenter.wikiaArticle.prepend(html);
				ControlCenterChrome.init();
			});
			ControlCenter.section.contentarea.load(wgScriptPath + '/wikia.php', {
				controller: 'ControlCenterSpecialPage',
				method: 'GetSpecialPage',
				page: page
			}, function(response){
				if(callback && typeof callback == 'function') {
					callback();
				}
			});
		},
		loadListUsers: function() {
			var sassUrl = $.getSassCommonURL('/extensions/wikia/Listusers/css/table.scss');
			$.getResources([wgScriptPath + '/extensions/wikia/Listusers/js/jquery.dataTables.min.js',
				wgScriptPath + '/extensions/wikia/Listusers/css/table.css',
				sassUrl
			], function() {
				ControlCenter.contentload.loadSpecialPage('ListUsers');
			});
		},
		loadUserRights: function() {
			ControlCenter.contentload.loadSpecialPage('UserRightsPage');
		},
		loadCategories: function() {
			ControlCenter.contentload.loadSpecialPage('Categories');
		},
		loadMultipleUpload: function() {
			ControlCenter.contentload.loadSpecialPage('MultipleUpload');
		},
		loadRecentChanges: function() {
			ControlCenter.contentload.loadSpecialPage('Recentchanges');
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

$(function() {
	ControlCenter.init();
	ControlCenterChrome.init();
});