<!-- s:<?= __FILE__ ?> -->
<style>
.dt-jobs-list th {
	font-size:92%;
	padding:4px;
}
.dt-jobs-list td {
	font-size:90%;
	padding:4px;
}
</style>
<script type="text/javascript">
/*<![CDATA[*/

function wfJSPager(total,link,page,limit,func,order,desc) {
	var lNEXT = "<?=wfMsg('imgmultipagenext')?>";
	var lPREVIOUS = "<?=wfMsg('imgmultipageprev')?>";
	var lR_ARROW = "";
	var lL_ARROW = "";
	var NUM_NUMBER = 5;

	var selectStyle = "font-size:8.5pt;font-weight:normal;";
	var tdStyle = "";
	var tableStyle = "font-size:8.5pt;font-weight:normal;margin:5px;";
	var linkStyle = "padding:2px 6px;";

	limit = typeof(limit) != 'undefined' ?limit : 20;
	page = typeof(page) != 'undefined' ? page : 0;

	if ((!total) || (total <= 0)) return "";

	function __makeClickFunc(jsFunc, func, limit, offset, order, desc) {
		return " " + jsFunc + "=\"" + func + "(" + limit + "," + offset + ", '" + order + "'," + desc + "); return false;\" ";
	}

	var page_count = Math.ceil(total/limit);
	var i = 0;
	var to = 0;

	var nbr_result = "<select id=\"wcDTselect\" style=\"" + selectStyle + "\" ";
	nbr_result += __makeClickFunc("onChange", func, "this.value", 0, order, desc);
	for (k = 0; k <= 9; k++) {
		selected = (limit == (5*(parseInt(k)+1))) ? "selected" : "";
		nbr_result += "<option " + selected + " value=\""+(5*(parseInt(k)+1))+"\">" + (5*(parseInt(k)+1)) + "</option>";
	}
	nbr_result += "</select>";

	var pager  = "<table style=\"line-height:1.5em;" + tableStyle + "\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
	pager += "<td align=\"center\" valign=\"middle\" style=\"white-space:nowrap;width:100%;\">";

	if (page_count > 1) {
		if (page != 0) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, (parseInt(page)-1), order, desc);
			pager += "href=\"" + link + "&page=" + (parseInt(page)-1) + "\">" + lL_ARROW + " " + lPREVIOUS + "</a>&nbsp;&nbsp;";
		}

		if (( page - NUM_NUMBER ) < 0 ) {
			i = 0;
		} else {
			i = page - NUM_NUMBER;
		}

		if ( i > 0 ) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, 0, order, desc) + " href=\"" + link + "&page=0\">1</a>&nbsp;";
			if ( i != 1) pager += "&nbsp;...&nbsp;&nbsp;";
		}

		for (k = i; k < page; k++) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, parseInt(k), order, desc);
			pager += " href=\"" + link + "&page=" + parseInt(k) + "\">" + (parseInt(k)+1) + "</a>&nbsp;&nbsp;";
		}

		pager += "<b>" + (parseInt(page)+1) + "</b>&nbsp;&nbsp;";

		if (( parseInt(page) + parseInt(NUM_NUMBER) + 1 ) > parseInt(page_count) ) {
			to = page_count;
		} else {
			to = parseInt(page) + parseInt(NUM_NUMBER) + 1;
		}

		for (i = parseInt(page)+1; i < to; i++) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, parseInt(i), order, desc);
			pager += " href=\"" + link + "&page=" + parseInt(i) + "\">" + (parseInt(i)+1) + "</a>&nbsp;&nbsp;";
		}

		if ( to < page_count ) {
			if ( to != page_count-1 ) pager += "&nbsp;...&nbsp;&nbsp;";
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, parseInt(page_count)-1, order, desc);
			pager += "href=\"" + link + "&page=" + (parseInt(page_count)-1) + "\">" + page_count + "</a>";
		}

		if ( (parseInt(page) + 1) != parseInt(page_count) ) {
			pager += "&nbsp;&nbsp;<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, (parseInt(page)+1), order, desc);
			pager += " href=\"" + link + "&page=" + (parseInt(page)+1) + "\">" + lNEXT + " " + lR_ARROW + "</a>";
		}
	} else {
		pager += "&nbsp;&nbsp;<b>" + (parseInt(page)+1) + "</b>&nbsp;&nbsp;";
	}

	pager += "</td>";
	pager += "</tr></table>";
	return pager;
}

function wkDTshowDetails(limit, offset, ord, desc) 
{
	limit = typeof(limit) != 'undefined' ?limit : 30;
	offset = typeof(offset) != 'undefined' ? offset : 0;
	var order = ord;
	var records = document.getElementById('dt-jobs-list');
	var jobsLoader = document.getElementById('dt-jobs-loader');

	DTShowDetailsListCallback = {
		success: function( oResponse )
		{
			var resData = "";
			if (YAHOO.Tools) {
				resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			} else if ((YAHOO.lang) && (YAHOO.lang.JSON)) {
				resData = YAHOO.lang.JSON.parse(oResponse.responseText);
			} else {
				resData = eval('(' + oResponse.responseText + ')');
			}
			if (resData['nbr_records'] == 0) {
				records.innerHTML = "<?=wfMsg('daemonloader_nojobsfound')?>";
			} else {
				page = resData['page'];
				limit = resData['limit'];
				order = resData['order'];
				desc = resData['desc'];
				var pager = wfJSPager(resData['nbr_records'],"/index.php?title=Special:DaemonLoader", page, limit, 'wkDTshowDetails', order, desc);
				records.innerHTML = pager + resData['data'];
			}
			jobsLoader.innerHTML = "";
		},
		failure: function( oResponse )
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			if (!resData) {
				records.innerHTML = "<?=wfMsg('daemonloader_nojobsfound')?>";
			}
		}
	};

	var params = "&rsargs[0]=" + limit;
	params += "&rsargs[1]=" + offset;
	params += "&rsargs[2]=" + ord;
	params += "&rsargs[3]=" + desc;
	//---
	jobsLoader.innerHTML = "<img src=\"/skins/common/images/ajax.gif\" />";
	//---
	var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axJobsList" + params;
	YAHOO.util.Connect.asyncRequest( "GET", baseurl, DTShowDetailsListCallback);
}

function removeJobTask(id) {
	var divClick = YAHOO.util.Dom.get("dt-remove-" + id);
	var jobsLoader = document.getElementById('dt-jobs-loader');
	
	DTRemoveJobCallback = {
		success: function( oResponse ) {
			wkDTshowDetails(30, 0, 'dj_id', -1);
			jobsLoader.innerHTML = "";
		},
		failure: function( oResponse )
		{
		}
	};

	if (divClick) {
		if (confirm('<?=wfMsg('daemonloader_removejobconfirm')?>')) {
			var params = "&rsargs[0]=" + id;
			//---
			jobsLoader.innerHTML = "<img src=\"/skins/common/images/ajax.gif\" />";
			//---
			var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axRemoveJobsList" + params;
			YAHOO.util.Connect.asyncRequest( "GET", baseurl, DTRemoveJobCallback);
		}
	}	
}

function changeJobTask(id) {
	var divClick = YAHOO.util.Dom.get("dt-change-" + id);
	var jobsLoader = document.getElementById('dt-jobs-loader');
	var createtaskDiv = YAHOO.util.Dom.get("createtaskDiv");

	DTChangeJobCallback = {
		success: function( oResponse ) {
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			if (resData['data']) {
				var data = resData['data'];
				var YD = YAHOO.util.Dom;
				if (YD.get('dt-daemons-list')) {
					YD.get('dt-daemons-list').value = data.dt_id;
					loadDaemonById(data.param_values);
					showSecondStep(data);
				}
			}

			tabView.set('activeIndex', 0);
			jobsLoader.innerHTML = "";
		},
		failure: function( oResponse )
		{
			jobsLoader.innerHTML = "";
		}
	};
	
	if (tabView) {
		var params = "&rsargs[0]=" + id;
		//---
		jobsLoader.innerHTML = "<img src=\"/skins/common/images/ajax.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axGetJobInfo" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, DTChangeJobCallback );
	}
}

/*]]>*/
</script>

<?php 
$jsListeners = array();
?>
<div id="dt-jobs-loader" style="height:15px"></div>
<div class="dt-jobs-list" id="dt-jobs-list"></div>
<script type="text/javascript">
YAHOO.util.Event.onDOMReady(function() {
	wkDTshowDetails(30, 0, 'dj_id', -1);
	var desc = -1;
});
</script>

<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
