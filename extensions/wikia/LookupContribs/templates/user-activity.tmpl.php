<!-- s:<?= __FILE__ ?> -->
<!-- USER-ACTIVITY -->
<!-- js part -->
<script type="text/javascript">
/*<![CDATA[*/
function wfJSPager(total,link,page,limit,func) {
	var lcNEXT = "<?=wfMsg('lookupcontribsnext')?>";
	var lcPREVIOUS = "<?=wfMsg('lookupcontribsprevious')?>";
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

	var nbr_result = "<?=wfMsg('lookupcontribsnbrresult')?> <select id=\"wcLCselect\" style=\"" + selectStyle + "\" ";
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
	var mode = document.getElementById('wkLCmode' + dbname);
	var username = document.getElementById('wkLCUserName');

	LookupContribsShowDetailsCallback = {
		success: function( oResponse )
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			div_details.innerHTML = "";
			var records = document.getElementById('wkLCUserActivityRow_' + dbname);
			if (!resData) {
				records.innerHTML = "<?=wfMsg('lookupcontribsinvalidresults')?>";
			} else if (resData['nbr_records'] == 0) {
				records.innerHTML = "<?=wfMsg('lookupcontribsnoresultfound')?>";
			} else {
				//records.innerHTML = resData['nbr_records'];
				page = resData['offset'];
				limit = resData['limit'];
				records.style.borderColor = "#D5DDF2";
				records.style.borderStyle = "dashed";
				records.style.borderWidth = "1px";
				pager = wfJSPager(resData['nbr_records'],"/index.php?title=Special:LookupContribs&target=<?=htmlspecialchars($username)?>", page, limit, 'wkLCshowDetails', dbname);
				records.innerHTML = pager;
 				records.innerHTML += "<br /><table width=\"100%\">";
 				loop = limit * offset;
				for (i in resData['res']) {
					loop++;
					records.innerHTML += "<tr><td>" + loop  + "</td><td>" +resData['res'][i]['link']+ "</td><td>" +resData['res'][i]['diff']+ "</td>" +
	  	 			"<td>" +resData['res'][i]['hist']+ "</td><td>" +resData['res'][i]['contrib']+ "</td><td>" +resData['res'][i]['time']+ "</td></tr>";
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
				records.innerHTML = "<?=wfMsg('lookupcontribsinvalidresults')?>";
			}
		}
	};

	if (dbname == "") {
		return false;
	}

	var params = "";
	if (div_details && username && dbname && mode) {
		params 	= "&rsargs[0]=" + dbname + "&rsargs[1]=" + username.value + "&rsargs[2]=" + mode.value + "&rsargs[3]=" + limit + "&rsargs[4]=" + offset;
		div_details.innerHTML="<img src=\"/extensions/wikia/LookupContribs/images/ajax-loader.gif\" />";
		//---
		var baseurl = "/index.php?action=ajax&rs=axWLookupContribsUserActivityDetails" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, LookupContribsShowDetailsCallback);
	}
}

/*]]>*/
</script>
<p><?=wfMsg('lookupcontribslistwikiainfo', $username)?></p>
<? if (empty($userActivity)) { ?>
<p><strong><?=wfMsg('lookupcontribsnoresultfound')?></strong></p>
<? } else { ?>
<input type="hidden" name="target" id="wkLCUserName" value="<?=htmlspecialchars($username)?>">
<table valign="middle"><tr>
<td align="center"><b><?=wfMsg('lookupcontribswiki')?></b></td>
<td align="center"><b><?=wfMsg('lookupcontribscontribslink')?></b></td>
<td align="center">&nbsp;</td>
</tr>
<? foreach ($userActivity as $id => $dbname) {
	$dbname = trim($dbname);
	if ( (!empty($dbname)) && (!empty($wikiList[$dbname])) ) {
		$wikiname = $wikiList[$dbname];
?>
<tr bgcolor="#FFFFDF">
	<td><a href="<?=$wikiname->city_url?>" target="new"><?=$wikiname->city_url?></a></td>
	<td>(<a href="<?php echo $wikiname->city_url?>index.php?title=Special:Contributions/<?php echo urlencode( $username ) ?>" target="new"><?=wfMsg('lookupcontribscontribs')?></a>)</td>
	<td><?=wfMsg('lookupcontribsdetails')?>&#160;<select name="mode" id="wkLCmode<?=$dbname?>">
		<option value="normal"><?=wfMsg('lookupcontribsselectmodenormal')?></option><option value="final"><?=wfMsg('lookupcontribsselectmodefinal')?></option>
		</select>&#160;&#160;<input type="button" value="<?=wfMsg('lookupcontribsgo')?>" onClick="javascript:wkLCshowDetails('<?=$dbname?>');">
	</td>
	<td id="wkLCUserActivityInd_<?=$dbname?>"></td>
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
