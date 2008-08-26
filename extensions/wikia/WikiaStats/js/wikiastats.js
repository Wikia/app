function StatsPageLoaderShow(show) { if (show == 1) YAHOO.pageloader.container.wait.show(); };
function StatsPageLoaderHide(hide) { if (hide == 1) YAHOO.pageloader.container.wait.hide(); };
function XLSPanelClose() { XLSCancel(); }
function XLSClearCitiesList() { var checklist = document.XLSCompareForm.wscid; var is_checked = 0; var checked_list = ""; for (i = 1; i < checklist.length; i++) checklist[i].checked = false; WSCountCheckboxes(true, 1);}
function XLSIframeStatusChanged() { if (window.frames['ws_frame_xls_'+wk_stats_city_id].document.readyState == 'complete') { /*StatsPageLoaderHide(); */ } else { setTimeout("XLSIframeStatusChanged()", 500) } }
function XLSIframeLoaded(panel, statistics) { StatsPageLoaderHide(0); }
function XLSIframeLoadedReady() { StatsPageLoaderHide(0); }
function XLSGenerate(statistics, others) { 
	var params 	= "&rsargs[0]=" + wk_stats_city_id + "&rsargs[1]=" + statistics;
    YD.get("ws-xls-div").innerHTML = "";
	if (others != '') params += "&rsargs[2]=" + others;
	//----
    var baseurl = "/index.php?action=ajax&rs=axWStatisticsXLS" + params;
    if (window.frames['ws_frame_xls_'+wk_stats_city_id]) {
    	delete window.frames['ws_frame_xls_'+wk_stats_city_id];
	}
	
	YD.get("ws-xls-div").innerHTML = "<iframe name=\"ws_frame_xls_"+wk_stats_city_id+"\" id=\"ws_frame_xls_"+wk_stats_city_id+"\" src=\""+baseurl+"\" onload=\"XLSIframeLoaded('ws-xls-div'," + statistics + ");\" style=\"width:0px;height:0px\" frameborder=\"0\"></iframe>";
	if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
		var f = document.getElementById("ws_frame_xls_"+wk_stats_city_id);
		f.onreadystatechange = XLSIframeStatusChanged();
	}
}
function XLSCancel() { YD.get("ws-xls-div").innerHTML = ""; }
function XLSShowMenu(city) { YAHOO.util.Dom.get("wk-stats-panel").style.display = (city == 0) ? "none" : "block"; YAHOO.util.Dom.get("ws-main-xls-stats").style.display = "block"; }
function WikiaStatsGetInfo(panel, city) {
	WikiaInfoCallback = { success: function( oResponse ) { YD.get(panel).innerHTML = oResponse.responseText; }, failure: function( oResponse ) { YD.get(panel).innerHTML = ""; } };
	YD.get(panel).innerHTML = "<div class=\"wk-progress-stats-panel\"><center><img src=\"/extensions/wikia/WikiaStats/images/ajax_indicators.gif\" border=\"0\"></center></div>";
	var baseurl = "/index.php?action=ajax&rs=axWStatisticsWikiaInfo&rsargs[0]=" + city;
	YAHOO.util.Connect.asyncRequest( "GET", baseurl, WikiaInfoCallback);	
};
function pageLoaderInit(text, btn_text) {
	YAHOO.namespace("pageloader.container");
	if (!YAHOO.pageloader.container.wait) {
		YAHOO.pageloader.container.wait = new YAHOO.widget.Dialog("wait", {width:"350px",fixedcenter:true,close:true,draggable:false,zindex:99999,modal:false,visible:false,buttons : [ { text: btn_text, handler:function(){this.cancel(); if (window.stop || window.document.execCommand) { if (window.stop) window.stop(); else if (window.document && window.document.execCommand) window.document.execCommand('Stop');} }, isDefault:true }]});
		YAHOO.pageloader.container.wait.setHeader(text);
		YAHOO.pageloader.container.wait.setBody("<center><img src=\"/extensions/wikia/WikiaStats/images/progressbar.gif\"/></center>");
		YAHOO.pageloader.container.wait.render(document.body);
	}
};
function redirectToStats(charts) { var city  = parseInt(document.getElementById("ws-city-list").value); StatsPageLoaderShow(0);
    if (charts) { document.location = "/index.php?title=Special:WikiaStats&action=citycharts&city=" + city; } else { document.location = "/index.php?title=Special:WikiaStats&action=citystats&city=" + city; }
}
function showXLSCompareDialog(statistics, showHtml) {
	compare_stats = statistics;
	if (showHtml == true) {
		document.getElementById('showXLS').value = 1;
		document.getElementById('showStatsNewWindow').style.display = "block";
	} else {
		document.getElementById('showXLS').value = 0;
		document.getElementById('showStatsNewWindow').style.display = "none";
	}
	//----
	if ((statistics == 9) && (showHtml == false)) {StatsPageLoaderShow(0); wk_stats_city_id = 0; XLSGenerate(statistics, ''); }
	else if ((statistics == 2) && (showHtml == true)) { StatsPageLoaderShow(1); ShowCompareStats(statistics, "", false); }
	else {
		CitiesListCallback = { 
			success: function( oResponse ) { //YD.get("ws-div-scroll").innerHTML = oResponse.responseText; 
				res = "<table>";
				var resData = eval('(' + oResponse.responseText + ')');
				var addToArray = false;
				if (selectWSWikisDialogList.length == 0) { addToArray = true }
					
				if (resData) {
					var loop = 0;
					for (k in resData) {
						var attr = (resData[k]["city"] == 0) ? "checked disabled" : " onClick=\"WSCountCheckboxes(this.checked, 0)\" ";
						var line = (resData[k]["city"] == 0) ? "<tr><td colspan=\"2\" style=\"height:5px\">&nbsp;</td></tr>" : "";
						res += "<tr><td style=\"padding:0px 3px\"><input type=\"checkbox\" " + attr + " id=\"wscid\" name=\"wscid\" value=\"" + resData[k]["city"] + "\"></td><td style=\"padding:0px 2px\">" +  resData[k]['name'] + "</td></tr>" + line;
						if (addToArray  == true) {
							selectWSWikisDialogList[k] = new Array(resData[k]["city"], resData[k]['name']);
						}
						loop++;
					}
				}
				res += "<table>";
				YD.get("ws-div-scroll").innerHTML = res; 
			},
			failure: function( oResponse ) { YD.get("ws-div-scroll").innerHTML = ""; }
		};

		YAHOO.Wikia.Statistics.compareStatsDialog.show();
		YD.get("compareStatsDialog_c").style.display = "block";
		var city_list = document.getElementById( "ws-div-scroll" );
		if (city_list.innerHTML == "") {
			city_list.innerHTML = "<table width=\"100%\" height=\"100%\" align=\"center\"><tr><td width=\"100%\" align=\"center\"><img src=\"/extensions/wikia/WikiaStats/images/ajax_indicators.gif\" border=\"0\"></td></tr></table>";
			YAHOO.util.Connect.asyncRequest( "GET", "/index.php?action=ajax&rs=axWStatisticsWikiaList", CitiesListCallback);
		}
	}
}
function XLSStats(id) { StatsPageLoaderShow(0); wk_stats_city_id = parseInt(document.getElementById("ws-city-list").value); XLSGenerate(id, ''); }
function ShowCompareStats(id, cityList, openNewWindow) { 
	if (openNewWindow) { window.open("/index.php?title=Special:WikiaStats&action=compare&table=" + id + "&cities=" + cityList , "compareStatsWindow"); } 
	else { StatsPageLoaderShow(1); document.location.href = "/index.php?title=Special:WikiaStats&action=compare&table=" + id + "&cities=" + cityList; }
}

function sortByText(a, b) {
    var x = a[1].toLowerCase();
    var y = b[1].toLowerCase();
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
}

function hideSortUrl(layer_ref, state) { 
	var maxwell_smart = document.getElementById(layer_ref); 
	maxwell_smart.style.visibility = state; 
}

function showWSSearchResult(value) {
	var search_div = document.getElementById( "ws-select-cities" );
	var param = "&rsargs[0]=" + value;

	if (selectWSWikisList.length == 0) {
		var defaultSelect = document.getElementById('ws-city-list');
		for (i=0; i<defaultSelect.length;i++) {
			selectWSWikisList[i] = new Array(defaultSelect.options[i].value, defaultSelect.options[i].text);
		}
	}

	hideSortUrl("ws-sort-link", "visible");

	if (value == "") {
		res = "<select name=\"ws-city-list\" id=\"ws-city-list\" class=\"ws-input\" size=\"14\" onChange=\"XLSShowMenu(this.value); WikiaStatsGetInfo('wk-stats-info-panel', this.value);\">";
		var _tmpList = new Array();
		for (i in selectWSWikisList) {
			_tmpList[i] = new Array(selectWSWikisList[i][0], selectWSWikisList[i][1]);
		}
		var firstElem = selectWSWikisList[0];
		if (sortMethod == 1) {
			_tmpList.sort(sortByText);
		}
		res += "<option value=\"" + firstElem[0] + "\">" + firstElem[1] + "</option>";
		for (i in _tmpList) {
			if (_tmpList[i]) {
				if ( _tmpList[i][0] != 0 ) {
					res += "<option value=\"" + _tmpList[i][0] + "\">" + _tmpList[i][1] + "</option>";
				}
			}
		}
		res += "</select>";
		search_div.innerHTML = res;
		_tmpList = 0;
		return;
	}

	SearchWSCallback = { 
		success: function( oResponse ) { 
			var resData = eval('(' + oResponse.responseText + ')');
			res = "<select name=\"ws-city-list\" id=\"ws-city-list\" class=\"ws-input\" size=\"14\" onChange=\"XLSShowMenu(this.value); WikiaStatsGetInfo('wk-stats-info-panel', this.value);\">";
			for (k in resData) {
				res += "<option value=\"" + k + "\">" + resData[k] + "</option>";
			}
			res += "</search>";
			search_div.innerHTML = res;
		},
		failure: function( oResponse ) { 
			search_div.innerHTML = "<select name=\"ws-city-list\" id=\"ws-city-list\" class=\"ws-input\" size=\"14\" onChange=\"XLSShowMenu(this.value); WikiaStatsGetInfo('wk-stats-info-panel', this.value);\"></search>";
		}
	};

	if (search_div) {
		search_div.innerHTML = "<div class=\"wk-progress-stats-panel\" style=\"height:164px\"><center><img src=\"/extensions/wikia/WikiaStats/images/ajax_indicators.gif\" border=\"0\"></center></div>";
		hideSortUrl("ws-sort-link", "hidden");
		YAHOO.util.Connect.asyncRequest( "GET", "/index.php?action=ajax&rs=axWStatisticsSearchWikis" + param, SearchWSCallback);
	}
}
function WikiaStatsPanelSortList() {
	var _tmpList = new Array();
	for (i in selectWSWikisDialogList) {
		_tmpList[i] = new Array(selectWSWikisDialogList[i][0], selectWSWikisDialogList[i][1]);
	}
	var firstElem = selectWSWikisDialogList[0];
	if (sortPanelMethod == 1) {
		_tmpList.sort(sortByText);
	}

	var res = "<table>";
	res += "<tr><td style=\"padding:0px 3px\"><input type=\"checkbox\" checked disabled id=\"wscid\" name=\"wscid\" value=\"" + firstElem[0] + "\"></td><td style=\"padding:0px 2px\">" +  firstElem[1] + "</td></tr>";
	res += "<tr><td colspan=\"2\" style=\"height:5px\">&nbsp;</td></tr>";

	if (_tmpList) {
		for (k in _tmpList) {
			if (_tmpList[k][0] != 0) {
				res += "<tr><td style=\"padding:0px 3px\"><input type=\"checkbox\" id=\"wscid\" onClick=\"WSCountCheckboxes(this.checked, 0)\" name=\"wscid\" value=\"" + _tmpList[k][0] + "\"></td><td style=\"padding:0px 2px\">" +  _tmpList[k][1] + "</td></tr>";
			}
		}
	}
	res += "<table>";
	YD.get("ws-div-scroll").innerHTML = res; 
	_tmpList = 0;
}

function WikiaStatsGetWikis(element, value) {
	var func = function() { showWSSearchResult(value) };

	if ( element.zid ) {
		clearTimeout(element.zid);
	}
	element.zid = setTimeout(func,800);
}
function redirectTooldStats() {
	var dbname = document.getElementById("ws-city-dbname").value;
	if (dbname) {
		document.location.href = "http://wikistats.wikia.com/EN/TablesWikia" + dbname.toUpperCase() + ".htm";
	}
}
