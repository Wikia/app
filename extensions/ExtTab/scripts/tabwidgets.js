var ExtTab = {tabWidgets : []};
Ext.onReady(function(){
	for(var i=0;i<ExtTab.tabWidgets.length;++i) {
	    new Ext.TabPanel({
	        renderTo : ExtTab.tabWidgets[i].id,
	        activeTab : 0,
	        width : (ExtTab.tabWidgets[i].width>0?ExtTab.tabWidgets[i].width:600),
	        height : (ExtTab.tabWidgets[i].height>0?ExtTab.tabWidgets[i].height:250),
	        plain : true,
	        defaults : {autoScroll: true},
	        items : ExtTab.tabWidgets[i].items
	    });
    }
});