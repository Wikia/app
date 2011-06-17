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
	handleControlClick: function() {
		ControlCenter.ui.resetAll();
		ControlCenter.ui.showSection('contentarea');
		
		// load content
		var control = $(this).data('control');
		if(control) {
			ControlCenter.contentload['load'+control]();
		}
	},
	ui: {
		resetAll: function() {
			ControlCenter.ui.deselectAllTabs();
			ControlCenter.ui.hideAllSections();
			ControlCenter.section.contentarea.html('Loading...');	//i18n this later
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
		loadPage: function(page, callback) {
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
				ControlCenter.contentload.loadPage('ListUsers');
			});
		},
		loadUserRights: function() {
			ControlCenter.contentload.loadPage('UserRightsPage');
		}
	}
};

$(function() {
	ControlCenter.init();
});