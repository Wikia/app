// ********************************
//
// Depends on skins/oasis/js/tab.js
//
// author: Rafal Leszczynski
//
// ********************************

window.TabView = {

	init: function (options) {

		// new instance for each tabs on a single page
		new TabViewClass(options);

	}

};

window.TabViewClass = $.createClass(Object, {

	constructor: function (options) {

		// *****************************************************
		//
		// options object has two properties:
		//
		// id: - id of the tabs wrapper element
		// selected: - index of the default selected tab
		//
		// check $out in TabView.php fo more details - line 107
		//
		// *****************************************************

		var tabsWrapperSelector = $('#' + options.id);

		// cashed data used across TabView methods
		this.cashedStuff = {

			tabsWrapperId: options.id,
			tabsWrapperSelector: tabsWrapperSelector,
			tabsSelector: tabsWrapperSelector.find('li'),
			containersWrapperId: options.id + '-content-wrapper'
		};

		var that = this,
			selectedTab = this.cashedStuff.tabsSelector.eq(options.selected),
			eventTarget = '#' + this.cashedStuff.tabsWrapperId + ' a';

		// set data-tab attributes
		this.setTabs(this.cashedStuff.tabsWrapperId, this.cashedStuff.tabsSelector);

		// add classes for styling - check Wikia UI Styleguide
		tabsWrapperSelector.children('ul').addClass('tabs');
		selectedTab.addClass('selected');

		// create containers for tabs content
		tabsWrapperSelector.after(that.createContainers(that.cashedStuff.tabsWrapperId));

		// attach handlers
		$('body').on('click', eventTarget, function (event) {

			event.preventDefault();

			that.loadContent($(this));

		});

		// load content to default selected slider
		this.loadContent(selectedTab.children('a'));

		// show default tab container
		$('#' + this.cashedStuff.containersWrapperId)
			.children('[data-tab-body="' + selectedTab.attr('data-tab') + '"]')
			.addClass('selected');

	},

	// ****** METHOD: set data-tab attributes to tab li elements - check tab.js and Wikia UI Styleguide for details
	setTabs: function (tabsWrapperId, tabsSelector) {

		var i,
			tabsCount = tabsSelector.length;

		for (i = 0; i < tabsCount; i += 1) {
			tabsSelector.eq(i).attr('data-tab', tabsWrapperId + i);
		}

	},

	// ****** METHOD: create containers for tabs content
	createContainers: function (tabsWrapperSelector) {

		var i,
			dataTabIds = [], // empty array for storing tab urls
			tabsColection = this.cashedStuff.tabsSelector,
			htmlString = '';

		for (i = 0; i < tabsColection.length; i += 1) {

			dataTabIds.push(tabsColection.eq(i).attr('data-tab'));

		}

		// view object and template for mustache
		var view = {
				dataTabIds: dataTabIds,
				containersWrapperId: this.cashedStuff.containersWrapperId
			},
			template = '<div id="{{containersWrapperId}}">{{#dataTabIds}}' +
				'<div class="tabBody" data-tab-body="{{.}}"></div>{{/dataTabIds}}</div>';

		htmlString += Mustache.render(template, view);

		return htmlString;

	},

	// ****** METHOD: load tabs content via AJAX
	loadContent: function (tabLink) {

		var tabUrl = tabLink.attr('href'),
			dataTabId = tabLink.parent().attr('data-tab'),
			containerSelector = $('#' + this.cashedStuff.containersWrapperId).children('div[data-tab-body="' + dataTabId + '"]');

		// if content not loaded, make AJAX request
		if (containerSelector.data('loaded') !== true) {

			containerSelector.startThrobbing();

			$.get(tabUrl, {action: 'render'}, function (html) {
				containerSelector.html(html).data('loaded', true).stopThrobbing();

				// fire event when new article comment is/will be added to DOM
				mw.hook('wikipage.content').fire(containerSelector);
			});
		}

	}

});
