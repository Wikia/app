<!-- s:<?= __FILE__ ?> -->
<!-- USER-ACTIVITY -->
<!-- js part -->
<script type="text/javascript">
/*<![CDATA[*/
function wfJSPager(total,link,page,limit,func) {
	var lcNEXT = "<?=wfMsg('multilookupnext')?>";
	var lcPREVIOUS = "<?=wfMsg('multilookupprevious')?>";
	var lcR_ARROW = ">";
	var lcL_ARROW = "<";
	var NUM_NUMBER = 5;

	var selectStyle = "font-size:8.5pt;font-weight:normal;";
	var tdStyle = "";
	var tableStyle = "font-size:8.5pt;font-weight:normal;";
	var linkStyle = "";

	limit = typeof(limit) != 'undefined' ?limit : 20;
	page = typeof(page) != 'undefined' ? page : 0;

	if ((!total) || (total <= 0)) return "";

	function __makeClickFunc(jsFunc, func, base, limit, offset) {
		return " " + jsFunc + "=\"" + func + "(" + base + "," + limit + "," + offset + "); return false;\" ";
	}

	var page_count = Math.ceil(total/limit);
	var i = 0;
	var to = 0;

	var paramNbr = wfJSPager.arguments.length;
	var func_param = "";
	for (n = 5; n < paramNbr; n++) {
		func_param += "'" + wfJSPager.arguments[n] + "'";
		if (n < (paramNbr-1)) func_param += ",";
	}

	var nbr_result = "<?=wfMsg('multilookupnbrresult')?> <select id=\"wcLCselect\" style=\"" + selectStyle + "\" ";
	nbr_result += __makeClickFunc("onChange", func, func_param, "this.value", 0);
	for (k = 0; k <= 7; k++) {
		selected = (limit == (5*(parseInt(k)+1))) ? "selected" : "";
		nbr_result += "<option " + selected + " value=\""+(5*(parseInt(k)+1))+"\">" + (5*(parseInt(k)+1)) + "</option>";
	}
	nbr_result += "</select>";

	var pager  = "<table style=\"" + tableStyle + "\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
	pager += "<tr><td nowrap width=\"30%\">" + nbr_result + "</td><td align=\"left\" width=\"70%\">";

	if (page_count > 1) {
		if (page != 0) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onClick", func, func_param, limit, (parseInt(page)-1));
			pager += "href=\"" + link + "&page=" + (parseInt(page)-1) + "\">" + lcL_ARROW + " " + lcPREVIOUS + "</a>&nbsp;&nbsp;";
		}

		if (( page - NUM_NUMBER ) < 0 ) {
			i = 0;
		} else {
			i = page - NUM_NUMBER;
		}

		if ( i > 0 ) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onClick", func, func_param, limit, 0) + " href=\"" + link + "&page=0\">1</a>&nbsp;";
			if ( i != 1) pager += "&nbsp;...&nbsp;&nbsp;";
		}

		for (k = i; k < page; k++) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onClick", func, func_param, limit, parseInt(k));
			pager += " href=\"" + link + "&page=" + parseInt(k) + "\">" + (parseInt(k)+1) + "</a>&nbsp;&nbsp;";
		}

		pager += "<b>" + (parseInt(page)+1) + "</b>&nbsp;&nbsp;";

		if (( parseInt(page) + parseInt(NUM_NUMBER) + 1 ) > parseInt(page_count) ) {
			to = page_count;
		} else {
			to = parseInt(page) + parseInt(NUM_NUMBER) + 1;
		}

		for (i = parseInt(page)+1; i < to; i++) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onClick", func, func_param, limit, parseInt(i));
			pager += " href=\"" + link + "&page=" + parseInt(i) + "\">" + (parseInt(i)+1) + "</a>&nbsp;&nbsp;";
		}

		if ( to < page_count ) {
			if ( to != page_count-1 ) pager += "&nbsp;...&nbsp;&nbsp;";
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onClick", func, func_param, limit, parseInt(page_count)-1);
			pager += "href=\"" + link + "&page=" + (parseInt(page_count)-1) + "\">" + page_count + "</a>";
		}

		if ( (parseInt(page) + 1) != parseInt(page_count) ) {
			pager += "&nbsp;&nbsp;<a style=\"" + linkStyle + "\" " + __makeClickFunc("onClick", func, func_param, limit, (parseInt(page)+1));
			pager += " href=\"" + link + "&page=" + (parseInt(page)+1) + "\">" + lcNEXT + " " + lcR_ARROW + "</a>";
		}
	} else {
		pager += "&nbsp;&nbsp;<b>" + (parseInt(page)+1) + "</b>&nbsp;&nbsp;";
	}

	pager += "</td>";
	pager += "</tr></table>";
	return pager;
}

function wfJSShowRow() {
}

function wkLCshowDetails(dbname, limit, offset)
{
	limit = typeof(limit) != 'undefined' ?limit : 20;
	offset = typeof(offset) != 'undefined' ? offset : 0;

	var div_details = document.getElementById('wkLCUserActivityInd_' + dbname);
	var username = document.getElementById('wkLCUserName');

	MultiLookupShowDetailsCallback = {
		success: function( oResponse )
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			div_details.innerHTML = "";
			var records = document.getElementById('wkLCUserActivityRow_' + dbname);
			if (!resData) {
				records.innerHTML = "<?=wfMsg('multilookupinvalidresults')?>";
			} else if (resData['nbr_records'] == 0) {
				records.innerHTML = "<?=wfMsg('multilookupnoresultfound')?>";
			} else {
				//records.innerHTML = resData['nbr_records'];
				page = resData['offset'];
				limit = resData['limit'];
				records.style.borderColor = "#D5DDF2";
				records.style.borderStyle = "dashed";
				records.style.borderWidth = "1px";
				pager = wfJSPager(resData['nbr_records'],"/index.php?title=Special:MultiLookup&target=<?=htmlspecialchars($username)?>", page, limit, 'wkLCshowDetails', dbname);
				records.innerHTML = pager;
 				records.innerHTML += "<br /><table width=\"100%\">";
 				loop = limit * offset;
				for (i in resData['res']) {
					loop++;
					records.innerHTML += "<tr><td style=\"padding:2px;\">" + loop  + "</td><td style=\"padding:2px 10px\">" +resData['res'][i]['link']+ "</td><td nowrap><?=wfMsg('multilookuplastedit')?>" +resData['res'][i]['last_edit']+ "</td></tr>";
				}
				records.innerHTML += "</table><br />";
				records.innerHTML += pager + "<br />";
			}
		},
		failure: function( oResponse )
		{
			var records = document.getElementById('wkLCUserActivityRow_' + dbname);
			div_details.innerHTML = "";
			if (!resData) {
				records.innerHTML = "<?=wfMsg('multilookupinvalidresults')?>";
			}
		}
	};

	if (dbname == "") {
		return false;
	}

	var params = "";
	if (div_details && username && dbname) {
		params 	= "&rsargs[0]=" + dbname + "&rsargs[1]=" + username.value + "&rsargs[2]=" + limit + "&rsargs[3]=" + offset;
		div_details.innerHTML="<img src=\"/extensions/wikia/SpecialMultipleLookup/images/ajax-loader.gif\" />";
		//---
		var baseurl = "/index.php?action=ajax&rs=axWMultiLookupUserActivityDetails" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, MultiLookupShowDetailsCallback);
	}
}

/*]]>*/
</script>
<p><?=wfMsg('multilookuplistwikiainfo', $username)?></p>
<? if (empty($userActivity)) { ?>
<p><strong><?=wfMsg('multilookupnoresultfound')?></strong></p>
<? } else { ?>
<input type="hidden" name="target" id="wkLCUserName" value="<?=htmlspecialchars($username)?>">
<table valign="middle" width="600"><tr>
<td align="center" width="80%"><b><?=wfMsg('multilookupwiki')?></b></td>
<td align="center" width="12%"><b>&nbsp;</b></td>
<td align="center" width="13%"><b>&nbsp;</b></td>
</tr>
<? foreach ($userActivity as $id => $dbname) {
	$dbname = trim($dbname);
	if ( (!empty($dbname)) && (!empty($wikiList[$dbname])) ) {
		$wikiname = $wikiList[$dbname];
?>
<tr bgcolor="#FFFFDF">
	<td><a href="<?=$wikiname->city_url?>" target="new"><?=$wikiname->city_url?></a></td>
	<td nowrap><a href="javascript:void(0);" onClick="javascript:wkLCshowDetails('<?=$dbname?>');"><?=wfMsg('multilookupdetails')?></a>
	<td id="wkLCUserActivityInd_<?=$dbname?>" align="center"></td>
</tr>
<tr>
	<td colspan="3" valign="top" id="wkLCUserActivityRow_<?=$dbname?>"></td><td></td>
</tr>
<? } } ?>
</table>
&#160;&#160;
<br/>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
