// Tabs code
if (typeof HeaderTabs == "undefined") {
    var HeaderTabs = { };
}

HeaderTabs.tabView = null;
HeaderTabs.tabids = [];
HeaderTabs.init = function(useHistory) {

	if (useHistory)
	{
		var bookmarkedtab = YAHOO.util.History.getBookmarkedState('tab') || '--no-tab--';

		YAHOO.util.History.register('tab', bookmarkedtab, function(tabid)
		{
			for (var i = 0; i<HeaderTabs.tabids.length; i++)
			{
				if (HeaderTabs.tabids[i] == tabid)
				{
					HeaderTabs.tabView.set('activeIndex', i);
					return;
				}
			}
		});

		try {
			YAHOO.util.History.initialize("yui-history-field", "yui-history-iframe");
		}
		catch (e)
		{
			useHistory = false;
		}
	}

	if (useHistory)
	{
		YAHOO.util.History.onReady(function()
		{
			var tabid = YAHOO.util.History.getCurrentState("tab");
			for (var i = 0; i<HeaderTabs.tabids.length; i++)
			{
				if (HeaderTabs.tabids[i] == tabid)
				{
					HeaderTabs.tabView.set('activeIndex', i);
					return;
				}
			}
		});
	}

	YAHOO.util.Event.onContentReady('headertabs', function()
	{
		HeaderTabs.tabView = new YAHOO.widget.TabView('headertabs');

		var tabs = new YAHOO.util.Element('headertabs').getElementsByClassName('yui-content')[0].childNodes;

		YAHOO.util.Dom.batch(tabs, function(tab) {
			HeaderTabs.tabids.push(tab.id);
		});

		HeaderTabs.tabView.set('activeIndex', 0);

		if (useHistory)
		{
			HeaderTabs.tabView.addListener('activeTabChange', function(e)
			{
				if (e.prevValue != e.newValue)
				{
					YAHOO.util.History.navigate('tab', HeaderTabs.tabids[HeaderTabs.tabView.get('activeIndex')]);
				}
			});
		}
	});

	YAHOO.util.Event.onContentReady('bodyContent', function()
	{
		// don't try adding tabs if there is no tabview
		if (typeof HeaderTabs.tabView == "undefined")
		{
			return;
		}

		// Adding Factbox tab
		var factboxdiv = new YAHOO.util.Element('bodyContent').getElementsByClassName('smwfact')[0];
		if (factboxdiv)
		{
			HeaderTabs.tabView.addTab(new YAHOO.widget.Tab({
				label: 'Factbox',
				id: 'headertabs_Factbox_tab',
				contentEl: factboxdiv
			}));

			HeaderTabs.tabids.push('Factbox');
			
			document.getElementById('headertabs_Factbox_tab').getElementsByTagName('a')[0].id = 'headertab_Factbox';
		}
	});
};

HeaderTabs.switchTab = function(tabid) {
	if (typeof HeaderTabs.tabView == "undefined")
	{
		return false;
	}

	for (var i = 0; i<HeaderTabs.tabids.length; i++)
	{
		if (HeaderTabs.tabids[i] == tabid)
		{
			HeaderTabs.tabView.set('activeIndex', i);

			document.getElementById('headertab_'+tabid).focus();

			return false;
		}
	}

	return false;
};
