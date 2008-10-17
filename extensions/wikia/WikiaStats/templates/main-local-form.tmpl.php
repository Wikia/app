<!-- s:<?= __FILE__ ?> -->
<!-- js part -->
<script type="text/javascript">
/*<![CDATA[*/

var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var wk_stats_city_id = 0;
var previous_page = 0;

function visible_wikians(rows, col, v)
{
	//--- main header and footer
	var cels = rows[0].getElementsByTagName('td');
	cels[col].style.display = v;

	cels = rows[1].getElementsByTagName('td');
	for (y = 1; y <= 2; y++) { cels[y].style.display = v; }

	cels = rows[2].getElementsByTagName('td');
	for (y = 0; y <= 3; y++) { cels[y].style.display = v; }

	cels = rows[3].getElementsByTagName('td');
	for (y = 0; y <= 5; y++) { cels[y].style.display = v; }

	cels = rows[rows.length-1].getElementsByTagName('td');
	cels[col].style.display = v;

	cels = rows[rows.length-2].getElementsByTagName('td');
	for (y = 0; y <= 1; y++) { cels[y].style.display = v; }

	cels = rows[rows.length-3].getElementsByTagName('td');
	for (y = 0; y <= 2; y++) { cels[y].style.display = v; }

	cels = rows[rows.length-4].getElementsByTagName('td');
	for (y = 1; y <= 7; y++) { cels[y].style.display = v; }
}

function visible_articles(rows, col, v)
{
	var cels = rows[0].getElementsByTagName('td');
	cels[2].style.display = v;

	cels = rows[1].getElementsByTagName('td');
	for (y = 3; y <= 6; y++) { cels[y].style.display = v; }
	
	cels = rows[3].getElementsByTagName('td');
	for (y = 6; y <= 11; y++) { cels[y].style.display = v; }
	
	// footers
	cels = rows[rows.length-1].getElementsByTagName('td');
	cels[2].style.display = v;

	cels = rows[rows.length-3].getElementsByTagName('td');
	for (y = 3; y <= 5; y++) { cels[y].style.display = v; }

	cels = rows[rows.length-4].getElementsByTagName('td');
	for (y = 8; y <= 14; y++) { cels[y].style.display = v; }
}

function visible_database(rows, col, v)
{
	//--- main header and footer
	var cels = rows[0].getElementsByTagName('td');
	cels[3].style.display = v;
	
	cels = rows[1].getElementsByTagName('td');
	for (y = 7; y <= 9; y++) { cels[y].style.display = v; }
	
	// footers
	cels = rows[rows.length-1].getElementsByTagName('td');
	cels[3].style.display = v;

	cels = rows[rows.length-4].getElementsByTagName('td');
	for (y = 15; y <= 17; y++) { cels[y].style.display = v; }
}

function visible_links(rows, col, v)
{
	//--- main header and footer
	var cels = rows[0].getElementsByTagName('td');
	cels[4].style.display = v;
	
	cels = rows[1].getElementsByTagName('td');
	for (y = 10; y <= 14; y++) { cels[y].style.display = v; }
	
	// footers
	cels = rows[rows.length-1].getElementsByTagName('td');
	cels[4].style.display = v;

	cels = rows[rows.length-4].getElementsByTagName('td');
	for (y = 18; y <= 22; y++) { cels[y].style.display = v; }
	//
}

function visible_image(rows, col, v)
{
	//--- main header and footer
	var cels = rows[0].getElementsByTagName('td');
	cels[5].style.display = v;
	
	cels = rows[1].getElementsByTagName('td');
	for (y = 15; y <= 16; y++) { cels[y].style.display = v; }

	// footers
	cels = rows[rows.length-1].getElementsByTagName('td');
	cels[5].style.display = v;

	cels = rows[rows.length-4].getElementsByTagName('td');
	for (y = 23; y <= 24; y++) { cels[y].style.display = v; }
	//
}

function visible_column(col, col_to, show, text, div_hide)
{
	var tableStats  = document.getElementById("table_stats");
	var v = (show) ? '' : 'none';
	var rows = tableStats.getElementsByTagName('tr');

	var rowStart = 4;
	var rowEnd = rows.length-4;

	if (show == 1) {
		for (i = rowStart; i < rowEnd; i++) {
			var cels = rows[i].getElementsByTagName('td');
			for (y = col; y <= col_to; y++) {
				cels[y].style.display = v;
			}
		}
	}

	if (col == 1) { //wikians headers and footer
		visible_wikians(rows, col, v);
	} else if (col == 8) { //article headers and footer
		visible_articles(rows, col, v);
	} else if (col == 15) { //database headers and footer
		visible_database(rows, col, v);
	} else if (col == 18) { //links headers and footer
		visible_links(rows, col, v);
	} else if (col == 23) { //daily headers and footer
		visible_image(rows, col, v);
	}

	if (show == 0) {
		for (i = rowStart; i < rowEnd; i++) {
			var cels = rows[i].getElementsByTagName('td');
			for (y = col; y <= col_to; y++) {
				cels[y].style.display = v;
			}
		}
	}

	var table_hidden = document.getElementById('ws-hide-table');
	var colText = "<?= wfMsg('wikiastats_stats') ?>";
	for (i = 1; i < 6; i++) {
		var div_hidden = document.getElementById('ws-hide-div' + i);
		if (show == 0) {
			if (!div_hidden) {
				table_hidden.innerHTML += "<span id=\"ws-hide-div"+i+"\" style=\"float:left; padding:4px; margin:2px; width:auto;\"><a href=\"javascript:void(0)\" onclick=\"javascript:visible_column("+col+","+col_to+",1,'"+ text +"',"+i+");\">" + colText.replace("%s", text) + "</a></span>";
				div_hidden = document.getElementById('ws-hide-div' + i);
				div_hidden.style.background = "#ffdead";
				div_hidden.style.clear = 'none';
				break;
			} else if ((div_hidden) && (div_hidden.innerHTML == "")) {
				div_hidden.style.background = "#ffdead";
				div_hidden.innerHTML = "<a href=\"javascript:void(0)\" onclick=\"javascript:visible_column("+col+","+col_to+",1,'"+ text +"',"+i+");\">" + colText.replace("%s", text) + "</a>";
				div_hidden.style.margin = "2px";
				div_hidden.style.padding = "4px";
				div_hidden.style.clear = 'none';
				break;
			}
		} else {
			if (div_hide == i) {
				div_hidden.innerHTML = "";
				div_hidden.style.background = "";
				div_hidden.style.margin = "0px";
				div_hidden.style.padding = "0px";
				div_hidden = null;
			}
		}
	}

	return true;
}

function selectArticleSize(id) {
	var backColor = YAHOO.util.Dom.getStyle('article-size-' + id, 'background-color');
	var new_backColor = (backColor == 'transparent') ? '#ADFF2F' : 'transparent';
	YAHOO.util.Dom.setStyle('article-size-' + id, 'background-color', new_backColor);
}

function wk_show_page_edited_details(page_id, ns) {
	div_previous = document.getElementById('wk-page-edited-row-' + previous_page);
	if (div_previous) {
		div_previous.style.background = "#ffffdd";		
	}

	previous_page = page_id;
	div_hidden = document.getElementById('wk-page-edited-row-' + page_id);
	div_hidden.style.background = "#ADFF2F";
	
	var city 	= document.getElementById( "wk-stats-city-id" );
	var params 	= "&rsargs[0]=" + city.value + "&rsargs[1]=" + page_id;
	//---
	document.getElementById( "wk-page-edits-stats-page-id" ).value = page_id;
	//---
	if (ns == 0) {
		YD.get("ws-progress-page-edits-bar").innerHTML="&nbsp;<img src=\"/extensions/wikia/WikiaStats/images/ajax_loader.gif\" />";
	} else {
		YD.get("ws-progress-othernpaces-edits-bar").innerHTML="&nbsp;<img src=\"/extensions/wikia/WikiaStats/images/ajax_loader.gif\" />";
	}
	//---
	var baseurl = wgScript + "?action=ajax&rs=axWStatisticsPageEditsDetails" + params;
	if (ns == 0) {
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, YAHOO.Wikia.Statistics.PageEditsDetailsStatisticCallback );
	} else {
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, YAHOO.Wikia.Statistics.PageOtherNpacesEditsDetailsStatisticCallback );
	}
}

YAHOO.util.Event.onDOMReady(function () {

	YAHOO.namespace("Wikia.Statistics");

	YAHOO.Wikia.Statistics.MainStatisticCallback = {
		success: function( oResponse ) {
			var resCode = 0;
			if (oResponse.responseText != "") {
				resCode = 1;
				YD.get("ws-main-table").innerHTML = oResponse.responseText;
				YD.get("ws-progress-bar").innerHTML = "&nbsp;";
			} else {
				YD.get("ws-main-table").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
				YD.get("ws-progress-bar").innerHTML = "&nbsp;";
			}
			//var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			//YD.get("ws-main-table").innerHTML = resData['text'];
			//YD.get("ws-progress-bar").innerHTML = "&nbsp;";
			if (resCode > 0) {
				if ( (document.getElementById( "wk-stats-city-id" )) && (document.getElementById( "wk-stats-city-id" ).value > 0) ) {
					var _otherStats = document.getElementById('ws-other-stats-panel');
					if (_otherStats.style.display == 'block') {
						document.getElementById( "ws-edits-article" ).style.display = "block";
						document.getElementById( "ws-active-wikians" ).style.display = "block";
						document.getElementById( "wk-select-month-wikians-div" ).style.display = "none";
						document.getElementById( "ws-anon-wikians" ).style.display = "block";
						document.getElementById( "ws-article-size" ).style.display = "block";
						document.getElementById( "ws-namespace-count" ).style.display = "block";
						document.getElementById( "ws-page-edits-count" ).style.display = "block";
						document.getElementById( "ws-othernpaces-edits-count" ).style.display = "block";
						document.getElementById( "ws-other-stats-panel" ).style.display = "block";
					}
				} else {
					document.getElementById( "ws-edits-article" ).style.display = "none";
					document.getElementById( "ws-active-wikians" ).style.display = "none";
					document.getElementById( "wk-select-month-wikians-div" ).style.display = "none";
					document.getElementById( "ws-anon-wikians" ).style.display = "none";
					document.getElementById( "ws-article-size" ).style.display = "none";
					document.getElementById( "ws-namespace-count" ).style.display = "none";
					document.getElementById( "ws-page-edits-count" ).style.display = "none";
					document.getElementById( "ws-othernpaces-edits-count" ).style.display = "block";
					document.getElementById( "ws-other-stats-panel" ).style.display = "none";
				}
			}
		},
		failure: function( oResponse ) {
			YD.get("ws-main-table").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
			YD.get("ws-progress-bar").innerHTML = "&nbsp;";
		}
	};

	YAHOO.Wikia.Statistics.ShowStats = function(e) 
	{
		var city = document.getElementById( "wk-stats-city-id" );
		document.getElementById( "ws-edits-article-table" ).innerHTML = "";
		document.getElementById( "ws-wikians-active-absent-table" ).innerHTML = "";
		document.getElementById( "ws-anon-wikians-table" ).innerHTML = "";
		document.getElementById( "ws-articles-size-table" ).innerHTML = "";
		document.getElementById( "ws-namespace-count-table" ).innerHTML = "";
		document.getElementById( "ws-page-edits-count-table" ).innerHTML = "";
		document.getElementById( "ws-othernpaces-edits-count-table" ).innerHTML = "";
		var params 	= "&rsargs[0]=" + city.value;
		//--- from
		params 	+= "&rsargs[1]=" + document.getElementById( "ws-date-year-from" ).value;
		params 	+= "&rsargs[2]=" + document.getElementById( "ws-date-month-from" ).value;
		//--- to
		params 	+= "&rsargs[3]=" + document.getElementById( "ws-date-year-to" ).value;
		params 	+= "&rsargs[4]=" + document.getElementById( "ws-date-month-to" ).value;
		
		var _legend = document.getElementById('wk-stats-legend');
		var _otherStats = document.getElementById('ws-other-stats-panel');
		if (this.id == "ws-show-charts") {
			params += "&rsargs[5]=1";
			if (_legend) {
				_legend.style.display = "none";
			}
			if (_otherStats) {
				_otherStats.style.display = "none";
			}
		} else {
			if (_legend) {
				_legend.style.display = "block";
			}
			if (_otherStats) {
				_otherStats.style.display = "block";
			}
		}
		//---
		YE.preventDefault(e);
		YD.get("ws-progress-bar").innerHTML="&nbsp;<img src=\"/extensions/wikia/WikiaStats/images/progressbar.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=axWStatisticsGenerate" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, YAHOO.Wikia.Statistics.MainStatisticCallback);
	};

	YAHOO.Wikia.Statistics.DistribEditsStatisticCallback = 
	{
		success: function( oResponse ) 
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			YD.get("ws-edits-article-table").innerHTML = resData['text'];
			YD.get("ws-progress-edits-bar").innerHTML = "&nbsp;";
		},
		failure: function( oResponse ) 
		{
			YD.get("ws-edits-article-table").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
			YD.get("ws-progress-edits-bar").innerHTML = "&nbsp;";
		}
	};

	YAHOO.Wikia.Statistics.WikiansRankStatisticCallback = 
	{
		success: function( oResponse ) 
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			YD.get("ws-wikians-active-absent-table").innerHTML = resData['text'];
			YD.get("ws-progress-wikians-bar").innerHTML = "&nbsp;";
			document.getElementById( "wk-select-month-wikians-div" ).style.display = "block";
		},
		failure: function( oResponse ) 
		{
			YD.get("ws-wikians-active-absent-table").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
			YD.get("ws-progress-wikians-bar").innerHTML = "&nbsp;";
		}
	};

	YAHOO.Wikia.Statistics.UserAnonStatisticCallback = 
	{
		success: function( oResponse ) 
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			YD.get("ws-anon-wikians-table").innerHTML = resData['text'];
			YD.get("ws-progress-anon-bar").innerHTML = "&nbsp;";
		},
		failure: function( oResponse ) 
		{
			YD.get("ws-anon-wikians-table").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
			YD.get("ws-progress-anon-bar").innerHTML = "&nbsp;";
		}
	};

	YAHOO.Wikia.Statistics.UserArticlesStatisticCallback = 
	{
		success: function( oResponse ) 
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			YD.get("ws-articles-size-table").innerHTML = resData['text'];
			YD.get("ws-progress-article-bar").innerHTML = "&nbsp;";
		},
		failure: function( oResponse ) 
		{
			YD.get("ws-articles-size-table").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
			YD.get("ws-progress-article-bar").innerHTML = "&nbsp;";
		}
	};

	YAHOO.Wikia.Statistics.NamespaceStatisticCallback = 
	{
		success: function( oResponse ) 
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			YD.get("ws-namespace-count-table").innerHTML = resData['text'];
			YD.get("ws-progress-namespace-bar").innerHTML = "&nbsp;";
		},
		failure: function( oResponse ) 
		{
			YD.get("ws-namespace-count-table").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
			YD.get("ws-progress-namespace-bar").innerHTML = "&nbsp;";
		}
	};

	YAHOO.Wikia.Statistics.PageEditsStatisticCallback = 
	{
		success: function( oResponse ) 
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			YD.get("ws-page-edits-count-table").innerHTML = resData['text'];
			YD.get("ws-progress-page-edits-bar").innerHTML = "&nbsp;";
		},
		failure: function( oResponse ) 
		{
			YD.get("ws-page-edits-count-table").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
			YD.get("ws-progress-page-edits-bar").innerHTML = "&nbsp;";
		}
	};

	YAHOO.Wikia.Statistics.PageOtherNspacesEditsStatisticCallback = 
	{
		success: function( oResponse ) 
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			YD.get("ws-othernpaces-edits-count-table").innerHTML = resData['text'];
			YD.get("ws-progress-othernpaces-edits-bar").innerHTML = "&nbsp;";
		},
		failure: function( oResponse ) 
		{
			YD.get("ws-othernpaces-edits-count-table").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
			YD.get("ws-progress-othernpaces-edits-bar").innerHTML = "&nbsp;";
		}
	};

	YAHOO.Wikia.Statistics.DistribArticleEditsStats = function(e)
	{
		var city 	= document.getElementById( "wk-stats-city-id" );
		var params 	= "&rsargs[0]=" + city.value;
		//---
		YE.preventDefault(e);
		YD.get("ws-progress-edits-bar").innerHTML="&nbsp;<img src=\"/extensions/wikia/WikiaStats/images/ajax_loader.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=axWStatisticsDistribEditsGenerate" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, YAHOO.Wikia.Statistics.DistribEditsStatisticCallback);
	};

	YAHOO.Wikia.Statistics.WikiansRankStats = function(e) 
	{
		var city 	= document.getElementById( "wk-stats-city-id" );
		var month 	= document.getElementById( "ws-wikians-active-month" );
		var _month = (month) ? month.value : 1;
		var params 	= "&rsargs[0]=" + city.value + "&rsargs[1]=" + _month;
		//---
		YE.preventDefault(e);
		YD.get("ws-progress-wikians-bar").innerHTML="&nbsp;<img src=\"/extensions/wikia/WikiaStats/images/ajax_loader.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=axWStatisticsWikiansRank" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, YAHOO.Wikia.Statistics.WikiansRankStatisticCallback);
	};

	YAHOO.Wikia.Statistics.AnonUsersStats = function(e) 
	{
		var city 	= document.getElementById( "wk-stats-city-id" );
		document.getElementById( "ws-anon-wikians-table" ).innerHTML = "";
		var params 	= "&rsargs[0]=" + city.value;
		//---
		YE.preventDefault(e);
		YD.get("ws-progress-anon-bar").innerHTML="&nbsp;<img src=\"/extensions/wikia/WikiaStats/images/ajax_loader.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=axWStatisticsAnonUsers" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, YAHOO.Wikia.Statistics.UserAnonStatisticCallback);
	};

	YAHOO.Wikia.Statistics.ArticlesSizeStats = function(e) 
	{
		var city 	= document.getElementById( "wk-stats-city-id" );
		document.getElementById( "ws-articles-size-table" ).innerHTML = "";
		var params 	= "&rsargs[0]=" + city.value;

		var sizeList = "";	
		for (s = 32, i = 0 ; i <= 13 ; s *= 2 , i++)
		{
			if (YAHOO.util.Dom.getStyle('article-size-' + s, 'background-color') != "transparent")
			{
				sizeList = sizeList + s + "," ;
			}
		}
		params 	+= "&rsargs[1]=" + sizeList;
		
		//---
		YE.preventDefault(e);
		YD.get("ws-progress-article-bar").innerHTML="&nbsp;<img src=\"/extensions/wikia/WikiaStats/images/ajax_loader.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=axWStatisticsArticleSize" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, YAHOO.Wikia.Statistics.UserArticlesStatisticCallback);
	};

	YAHOO.Wikia.Statistics.NamespaceStats = function(e) 
	{
		var city 	= document.getElementById( "wk-stats-city-id" );
		document.getElementById( "ws-namespace-count-table" ).innerHTML = "";
		var params 	= "&rsargs[0]=" + city.value;
		
		//---
		YE.preventDefault(e);
		YD.get("ws-progress-namespace-bar").innerHTML="&nbsp;<img src=\"/extensions/wikia/WikiaStats/images/ajax_loader.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=axWStatisticsNamespaceCount" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, YAHOO.Wikia.Statistics.NamespaceStatisticCallback);
	};

	YAHOO.Wikia.Statistics.PageEditsStats = function(e) 
	{
		var city 	= document.getElementById( "wk-stats-city-id" );
		document.getElementById( "ws-page-edits-count-table" ).innerHTML = "";
		var params 	= "&rsargs[0]=" + city.value;
		//---
		YE.preventDefault(e);
		YD.get("ws-progress-page-edits-bar").innerHTML="&nbsp;<img src=\"/extensions/wikia/WikiaStats/images/ajax_loader.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=axWStatisticsPageEdits" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, YAHOO.Wikia.Statistics.PageEditsStatisticCallback);
	};

	YAHOO.Wikia.Statistics.PageEditsDetailsStatisticCallback = 
	{
		success: function( oResponse ) 
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			var page_id = document.getElementById( "wk-page-edits-stats-page-id" ).value;
			YD.get("wk-page-count-details-stats").innerHTML = resData['text'];
			YD.get("ws-progress-page-edits-bar").innerHTML = "&nbsp;";
		},
		failure: function( oResponse ) 
		{
			var page_id = document.getElementById( "wk-page-edits-stats-page-id" ).value;
			YD.get("wk-page-count-details-stats").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
			YD.get("ws-progress-page-edits-bar").innerHTML = "&nbsp;";
		}
	};

	YAHOO.Wikia.Statistics.OtherNpacesEditsStats = function(e) 
	{
		var city 	= document.getElementById( "wk-stats-city-id" );
		document.getElementById( "ws-othernpaces-edits-count-table" ).innerHTML = "";
		var params 	= "&rsargs[0]=" + city.value;
		//---
		YE.preventDefault(e);
		YD.get("ws-progress-othernpaces-edits-bar").innerHTML="&nbsp;<img src=\"/extensions/wikia/WikiaStats/images/ajax_loader.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=axWStatisticsOtherNpacesPageEdits" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, YAHOO.Wikia.Statistics.PageOtherNspacesEditsStatisticCallback);
	};

	YAHOO.Wikia.Statistics.PageOtherNpacesEditsDetailsStatisticCallback = 
	{
		success: function( oResponse ) 
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			var page_id = document.getElementById( "wk-page-edits-stats-page-id" ).value;
			YD.get("wk-othernpaces-count-details-stats").innerHTML = resData['text'];
			YD.get("ws-progress-othernpaces-edits-bar").innerHTML = "&nbsp;";
		},
		failure: function( oResponse ) 
		{
			var page_id = document.getElementById( "wk-page-edits-stats-page-id" ).value;
			YD.get("wk-othernpaces-count-details-stats").innerHTML = "<?= wfMsg("wikiastats_nostats_found") ?>";
			YD.get("ws-progress-othernpaces-edits-bar").innerHTML = "&nbsp;";
		}
	};

	YAHOO.Wikia.Statistics.GenerateXLSStats = function(e) 
	{
		var id = 0;
		switch (this.id) {
			case "ws-export-xls" : {
				id = 1; 
				wk_stats_city_id = parseInt(document.getElementById("wk-stats-city-id").value); 
				var month_from = document.getElementById("ws-date-month-from").value;
				var year_from = document.getElementById("ws-date-year-from").value;
				var month_to = document.getElementById("ws-date-month-to").value;
				var year_to = document.getElementById("ws-date-year-to").value;
				XLSGenerate(id, '', year_from + '-' + month_from, year_to + '-' + month_to); 
				break;
			}
			default : {
				var id = this.id;
				id = id.replace("ws-xls-", "");
				XLSGenerate(id, '', '', ''); 
			}
		}
	}

	YE.addListener("ws-show-stats", "click", YAHOO.Wikia.Statistics.ShowStats);
	YE.addListener("ws-show-charts", "click", YAHOO.Wikia.Statistics.ShowStats);
	YE.addListener("ws-export-xls", "click", YAHOO.Wikia.Statistics.GenerateXLSStats);
	YE.addListener("ws-edits-article-show", "click", YAHOO.Wikia.Statistics.DistribArticleEditsStats);
	YE.addListener("ws-wikians-rank-show", "click", YAHOO.Wikia.Statistics.WikiansRankStats);
	YE.addListener("ws-wikians-active-btn", "click", YAHOO.Wikia.Statistics.WikiansRankStats);
	YE.addListener("ws-anon-users-show", "click", YAHOO.Wikia.Statistics.AnonUsersStats);
	YE.addListener("ws-article-size-show", "click", YAHOO.Wikia.Statistics.ArticlesSizeStats);
	YE.addListener("ws-namespace-count-show", "click", YAHOO.Wikia.Statistics.NamespaceStats); 
	YE.addListener("ws-page-edits-count-show", "click", YAHOO.Wikia.Statistics.PageEditsStats);
	YE.addListener("ws-page-edits-details-show", "click", YAHOO.Wikia.Statistics.PageEditsStats);
	YE.addListener("ws-othernspaces-edits-count-show", "click", YAHOO.Wikia.Statistics.OtherNpacesEditsStats);
	YE.addListener("ws-page-edits-details-show", "click", YAHOO.Wikia.Statistics.OtherNpacesEditsStats);

	for (k=2; k<9; k++) {
		YE.addListener("ws-xls-" + k, "click", YAHOO.Wikia.Statistics.GenerateXLSStats);
	}	
});


/*]]>*/
</script>
<input type="hidden" id="wk-stats-city-id" value="<?=$selCity?>" />
<fieldset>
<legend><?=wfMsg('wikiastats_main_statistics_legend')?></legend>
<div id="ws-upload">
	<div id="ws-progress-bar"></div>
	<div style="text-align:right; float:right; margin:0px 0px 0px 20px;">
	<span class="wk-select-class"><?= wfMsg('wikiastats_daterange_from') ?> 
	<select name="ws-date-month-from" id="ws-date-month-from" style="text-align:left; font-size:11px;">
<?php
$curMonth = date("m"); $curYear = date("Y");
if (!empty($toDate)) {
	list ($curYear, $curMonth) = $toDate;
}
list ($fromYear, $fromMonth) = array($curYear, "");
if (!empty($fromDate)) {
	list ($fromYear, $fromMonth) = $fromDate;
}
foreach ($dateRange['months'] as $id => $month) { 
	$selected = ($fromMonth == ($id+1)) ? " selected=\"selected\" " : "";
?>
	<option value="<?= ($id+1) ?>" <?=$selected?>><?= ucfirst($month) ?></option>
<?php
}	
?>	
	</select>
	<select name="ws-date-year-from" id="ws-date-year-from" style="text-align:left; font-size:11px;">
<?php
$minYear = intval($dateRange['minYear']); 
if ($minYear < 2000) $minYear = 2000;
$maxYear = intval($dateRange['maxYear']);
while ($minYear <= $maxYear) {
	$selected = ($fromYear == $minYear) ? " selected=\"selected\" " : "";
?>
	<option <?= $selected ?> value="<?= $minYear ?>"><?= $minYear ?></option>
<?php	
	$minYear++;
}
?>
	</select></span>
	<span class="wk-select-class">
	<?= wfMsg('wikiastats_daterange_to') ?>
	<select name="ws-date-month-to" id="ws-date-month-to" style="text-align:left; font-size:11px;">
<?php
foreach ($dateRange['months'] as $id => $month) {
	$k = $id+1; $selected = ($curMonth == $k) ? " selected=\"selected\" " : "";
?>
	<option <?= $selected ?> value="<?= $k ?>"><?= ucfirst($month) ?></option>
<?php
}	
?>	
	</select>
	<select name="ws-date-year-to" id="ws-date-year-to" style="text-align:left; font-size:11px;">
<?php
$minYear = intval($dateRange['minYear']); $maxYear = intval($dateRange['maxYear']);
while ($minYear <= $maxYear) {
	$selected = ($curYear == $minYear) ? " selected=\"selected\" " : "";
?>
	<option <?= $selected ?> value="<?= $minYear ?>"><?= $minYear ?></option>
<?php	
	$minYear++;
}
?>
	</select></span>
	<br />
	<div class="wk-select-class">
		<span style="padding:5px 2px;"><input type="button" id="ws-show-stats" name="ws-show-stats" value="<?= wfMsg("wikiastats_showstats_btn") ?>" /></span>
		<span style="padding:5px 2px;"><input type="button" id="ws-show-charts" value="<?= wfMsg("wikiastats_showcharts") ?>" name="ws-show-charts" /></span>
		<span style="padding:5px 2px;"><input type="button" id="ws-export-xls" value="<?= wfMsg("wikiastats_export_xls") ?>" name="ws-export-xls" /></span>
	</div>
	</div>
</div>
<div id="ws-main-table">
<?
if (!empty($main_tbl)) {
	echo $main_tbl;
}
?>
</div>
</fieldset>
<? if ( !empty($main_tbl) && (empty($show_chart)) ) { if ($selCity > 0) { ?>
<fieldset id="ws-other-stats-panel">
<legend class="legend-subtitle"><?=wfMsg('wikiastats_other_statistics_legend')?></legend>
<? } } ?>
<!-- DISTRIBUTION OF ARTICLE EDITS OVER WIKIANS -->
<div id="ws-edits-article">
	<div id="ws-edits-article-title" style="clear:left;width:auto;float:left">
		<div valign="middle">
			<a href="javascript:void(0)" id="ws-edits-article-show"><?= wfMsg('wikiastats_distrib_article'); ?></a>
			<span style="padding:5px 2px;"><input type="image" id="ws-xls-2" value="<?= wfMsg("wikiastats_export_xls") ?>" src="/extensions/wikia/WikiaStats/images/xls.gif" /></span>
		</div>	
		<span class="small"><?= wfMsg('wikiastats_distrib_article_subtext') ?></span><br />
		<span class="small"><?= wfMsg('wikiastats_distrib_article_counting') ?></span>
	</div>
	<div id="ws-progress-edits-bar"></div>
	<div class="clear">&nbsp;</div>
	<div id="ws-edits-article-table"></div>
</div>
<!-- END OF DISTRIBUTION OF ARTICLE EDITS OVER WIKIANS -->
<!-- ACTIVE/ABSENT WIKIANS ORDERED BY NUMBER OF CONTRIBUTIONS -->
<div id="ws-active-wikians">
	<div id="ws-wikians-title" style="clear:left;width:auto;float:left">
		<div valign="middle">
			<a href="javascript:void(0)" id="ws-wikians-rank-show"><?= wfMsg('wikiastats_active_absent_wikians'); ?></a>
			<span style="padding:5px 2px;"><input type="image" id="ws-xls-3" value="<?= wfMsg("wikiastats_export_xls") ?>" src="/extensions/wikia/WikiaStats/images/xls.gif" /></span>		
		</div>	
		<span class="small"><?= wfMsg('wikiastats_active_wikians_subtitle') ?></span>
	</div>
	<div id="ws-progress-wikians-bar"></div>
	<div class="clear">&nbsp;</div>
	<div style="text-align:left;" id="wk-select-month-wikians-div"><?= wfMsg("wikiastats_active_wikians_date") ?>
		<span class="wk-select-class"><select name="ws-wikians-active-month" id="ws-wikians-active-month" style="text-align:left; font-size:11px;">
<?php 
for ($i = 1; $i <= 6; $i++)
{
	$month_name = ($i == 1) ? wfMsg('wikiastats_active_month') : wfMsg('wikiastats_active_months');
	$selected = ""; //($i == $cur_month) ? " selected=\"selected\" " : "" ;
?>
		<option <?= $selected ?> value="<?= $i ?>"><?= $i . " " .$month_name ?></option>
<?php 
}
?>	
		</select></span>
		<span class="wk-select-class"><input type="button" id="ws-wikians-active-btn" name="ws-wikians-active-btn" value=" ... " /></span>
	</div>
	<div id="ws-wikians-active-absent-table"></div>
</div>
<!-- END OF DISTRIBUTION OF ARTICLE EDITS OVER WIKIANS -->
<!-- ANONYMOUS USERS -->
<div id="ws-anon-wikians">
	<div id="ws-anon-users-title" style="clear:left;width:auto;float:left">
		<div valign="middle">
			<a href="javascript:void(0)" id="ws-anon-users-show"><?= wfMsg('wikiastats_anon_wikians'); ?></a>
			<span style="padding:5px 2px;"><input type="image" id="ws-xls-4" value="<?= wfMsg("wikiastats_export_xls") ?>" src="/extensions/wikia/WikiaStats/images/xls.gif" /></span>
		</div>	
		<span class="small"><?= wfMsg('wikiastats_anon_wikians_subtitle') ?></span>
	</div>
	<div id="ws-progress-anon-bar"></div>
	<div class="clear">&nbsp;</div>
	<div id="ws-anon-wikians-table"></div>
</div>
<!-- END OF ANONYMOUS USERS -->
<!-- ARTICLE SIZE -->
<div id="ws-article-size">
	<div id="ws-articles-title" style="clear:left;width:auto;float:left">
		<div valign="middle">
			<?= wfMsg('wikiastats_article_size'); ?>
			<span style="padding:5px 2px;"><input type="image" id="ws-xls-5" value="<?= wfMsg("wikiastats_export_xls") ?>" src="/extensions/wikia/WikiaStats/images/xls.gif" /></span>
		</div>	
		<br />
		<span class="small"><?= wfMsg('wikiastats_article_size_subtitle') ?></span>
		<br />
<?php
	for ($s = 32, $i = 0 ; $i <= 13 ; $s *= 2 , $i++) {
		$bT = wfMsg('size-bytes', $s);
		$text = "&lt;&nbsp;".$bT;
		if ($s >= 1024) {
			$kbT = wfMsg('size-kilobytes', sprintf("%.0f", $s/1024));
			$text = "&lt;&nbsp;".$kbT;
		}
?>		
		<span class="medium" id="article-size-<?=$s?>" onclick="selectArticleSize('<?=$s?>');" style="border:1px outset white; cursor:pointer; padding:2px;"><?=$text?></span>
<?php
	}
?>		
		<span class="medium"><input type="button" class="medium" id="ws-article-size-show" value="<?= wfMsg('wikiastats_show') ?>" /></span>
	</div>
	<div id="ws-progress-article-bar"></div>
	<div class="clear">&nbsp;</div>
	<div id="ws-articles-size-table"></div>
</div>
<!-- END OF ARTICLE SIZE -->
<!-- NAMESPACE COUNTS -->
<div id="ws-namespace-count">
	<div id="ws-namespace-count-title" style="clear:left;width:auto;float:left">
		<div valign="middle">
			<a href="javascript:void(0)" id="ws-namespace-count-show"><?= wfMsg('wikiastats_namespace_records'); ?></a>
			<span style="padding:5px 2px;"><input type="image" id="ws-xls-6" value="<?= wfMsg("wikiastats_export_xls") ?>" src="/extensions/wikia/WikiaStats/images/xls.gif" /></span>
		</div>	
	</div>
	<div id="ws-progress-namespace-bar"></div>
	<div class="clear">&nbsp;</div>
	<div id="ws-namespace-count-table"></div>
</div>
<!-- NAMESPACE COUNTS -->
<!-- NUMBER OF PAGE EDITED -->
<div id="ws-page-edits-count">
	<div id="ws-page-edits-count-title" style="clear:left;width:auto;float:left">
		<div valign="middle">
			<a href="javascript:void(0)" id="ws-page-edits-count-show"><?= wfMsg('wikiastats_page_edits'); ?></a>
			<span style="padding:5px 2px;"><input type="image" id="ws-xls-7" value="<?= wfMsg("wikiastats_export_xls") ?>" src="/extensions/wikia/WikiaStats/images/xls.gif" /></span>
		</div>	
	</div>
	<div id="ws-progress-page-edits-bar"></div>
	<div class="clear">&nbsp;</div>
	<div id="ws-page-edits-count-table"></div>
</div>
<div id="ws-othernpaces-edits-count">
	<div id="ws-othernpaces-edits-count-title" style="clear:left;width:auto;float:left">
		<div valign="middle">
			<a href="javascript:void(0)" id="ws-othernspaces-edits-count-show"><?= wfMsg('wikiastats_other_nspaces_edits'); ?></a>
			<span style="padding:5px 2px;"><input type="image" id="ws-xls-8" value="<?= wfMsg("wikiastats_export_xls") ?>" src="/extensions/wikia/WikiaStats/images/xls.gif" /></span>
		</div>	
	</div>
	<div id="ws-progress-othernpaces-edits-bar"></div>
	<div class="clear">&nbsp;</div>
	<div id="ws-othernpaces-edits-count-table"></div>
</div>
<? if ( !empty($main_tbl) && (empty($show_chart)) ) { if ($selCity > 0) { ?>
</fieldset>
<? 
} } 
if ( !empty($main_tbl) && (empty($show_chart)) )
{
	if ($selCity > 0)
	{
?>
<script type="text/javascript">
document.getElementById( "ws-edits-article" ).style.display = "block";
document.getElementById( "ws-active-wikians" ).style.display = "block";
document.getElementById( "wk-select-month-wikians-div" ).style.display = "none";
document.getElementById( "ws-anon-wikians" ).style.display = "block";
document.getElementById( "ws-article-size" ).style.display = "block";
document.getElementById( "ws-namespace-count" ).style.display = "block";
document.getElementById( "ws-page-edits-count" ).style.display = "block";
document.getElementById( "ws-othernpaces-edits-count" ).style.display = "block";
</script>
<?	
	}
}
?>
<div id="ws-xls-div"></div>
<!-- NUMBER OF PAGE EDITED -->
<!-- e:<?= __FILE__ ?> -->
