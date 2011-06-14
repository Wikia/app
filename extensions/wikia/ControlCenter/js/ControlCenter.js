var ControlCenter = {
	controls: {},
	section: {},
	init: function() {
		// precache
		ControlCenter.cc = $('#ControlCenter');
		ControlCenter.allControls = ControlCenter.cc.find('.control');
		ControlCenter.tabs = ControlCenter.cc.find('.tabs');
		ControlCenter.allTabs = ControlCenter.tabs.find('.tab');
		ControlCenter.section.general = $('#ControlCenterGeneral');
		ControlCenter.section.advanced = $('#ControlCenterAdvanced');
		ControlCenter.section.contentarea = $('#ControlCenterContentArea');
		
		//events
		ControlCenter.allControls.hover(function() {
			var el = $(this);
			ControlCenter.tooltip = $(this).closest('.control-section').find('header .tooltip');
			ControlCenter.tooltip.text(el.data('tooltip'));
		}, function() {
			ControlCenter.tooltip.text('');
		}).click(ControlCenter.handleControlClick);

		ControlCenter.allTabs.click(function() {
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
	},
	ui: {
		resetAll: function() {
			ControlCenter.ui.deselectAllTabs();
			ControlCenter.ui.hideAllSections();
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
		loadUserList: function() {
			
		}
	}
};

$(function() {
	ControlCenter.init();
});