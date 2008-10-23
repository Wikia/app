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

	var nbr_result = "<select id=\"wcLCselect\" style=\"" + selectStyle + "\" ";
	nbr_result += __makeClickFunc("onChange", func, func_param, "this.value", 0);
	for (k = 0; k <= 7; k++) {
		selected = (limit == (5*(parseInt(k)+1))) ? "selected" : "";
		nbr_result += "<option " + selected + " value=\""+(5*(parseInt(k)+1))+"\">" + (5*(parseInt(k)+1)) + "</option>";
	}
	nbr_result += "</select>";

	var pager  = "<table style=\"line-height:1.5em;" + tableStyle + "\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
	pager += "<tr><td valign=\"middle\" style=\"white-space:nowrap;\"><?=wfMsg('lookupcontribsnbrresult')?></td>";
	pager += "<td valign=\"middle\" align=\"left\">" + nbr_result + "</td>";
	pager += "<td align=\"center\" valign=\"middle\" style=\"white-space:nowrap;width:100%;\">";

	if (page_count > 1) {
		if (page != 0) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, (parseInt(page)-1));
			pager += "href=\"" + link + "&page=" + (parseInt(page)-1) + "\">" + lcL_ARROW + " " + lcPREVIOUS + "</a>&nbsp;&nbsp;";
		}

		if (( page - NUM_NUMBER ) < 0 ) {
			i = 0;
		} else {
			i = page - NUM_NUMBER;
		}

		if ( i > 0 ) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, 0) + " href=\"" + link + "&page=0\">1</a>&nbsp;";
			if ( i != 1) pager += "&nbsp;...&nbsp;&nbsp;";
		}

		for (k = i; k < page; k++) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, parseInt(k));
			pager += " href=\"" + link + "&page=" + parseInt(k) + "\">" + (parseInt(k)+1) + "</a>&nbsp;&nbsp;";
		}

		pager += "<b>" + (parseInt(page)+1) + "</b>&nbsp;&nbsp;";

		if (( parseInt(page) + parseInt(NUM_NUMBER) + 1 ) > parseInt(page_count) ) {
			to = page_count;
		} else {
			to = parseInt(page) + parseInt(NUM_NUMBER) + 1;
		}

		for (i = parseInt(page)+1; i < to; i++) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, parseInt(i));
			pager += " href=\"" + link + "&page=" + parseInt(i) + "\">" + (parseInt(i)+1) + "</a>&nbsp;&nbsp;";
		}

		if ( to < page_count ) {
			if ( to != page_count-1 ) pager += "&nbsp;...&nbsp;&nbsp;";
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, parseInt(page_count)-1);
			pager += "href=\"" + link + "&page=" + (parseInt(page_count)-1) + "\">" + page_count + "</a>";
		}

		if ( (parseInt(page) + 1) != parseInt(page_count) ) {
			pager += "&nbsp;&nbsp;<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, (parseInt(page)+1));
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
				records.innerHTML = "<div style=\"clear:both;border:1px dashed #D5DDF2;margin:0px 5px 0px 15px;padding:5px;\"><?=wfMsg('lookupcontribsinvalidresults')?></div>";
			} else if (resData['nbr_records'] == 0) {
				records.innerHTML = "<div style=\"clear:both;border:1px dashed #D5DDF2;margin:0px 5px 0px 15px;padding:5px;\"><?=wfMsg('lookupcontribsnoresultfound')?></div>";
			} else {
				//records.innerHTML = resData['nbr_records'];
				page = resData['offset'];
				limit = resData['limit'];
				//records.style.borderColor = "#D5DDF2";
				//records.style.borderStyle = "dashed";
				//records.style.borderWidth = "1px";
				pager = wfJSPager(resData['nbr_records'],"/index.php?title=Special:LookupContribs&target=<?=htmlspecialchars($username)?>", page, limit, 'wkLCshowDetails', dbname);
				var _tmp = "<div style=\"clear:both;border:1px dashed #D5DDF2;margin:0px 5px 0px 15px;\">";
				_tmp += pager;
 				_tmp += "<br /><table width=\"100%\" style=\"line-height:1.5em\">";
 				loop = limit * offset;
				for (i in resData['res']) {
					loop++;
					var style = (resData['res'][i]['removed']  == 1) ? "style=\"color:#8B0000;padding:0px 1px;\"" : "style=\"padding:0px 2px;\"";
					var oneRow = "<tr><td style=\"width:15px;white-space:nowrap;\">" + loop  + ".</td>";
					oneRow += "<td " + style + ">" +resData['res'][i]['link']+ "</td>";
					oneRow += "<td " + style + ">" +resData['res'][i]['diff']+ "</td>";
	  	 			oneRow += "<td " + style + ">" +resData['res'][i]['hist']+ "</td>";
	  	 			oneRow += "<td " + style + ">" +resData['res'][i]['contrib']+ "</td>";
	  	 			oneRow += "<td " + style + ">" +resData['res'][i]['time']+ "</td></tr>";
	  	 			_tmp += oneRow;
				}
				_tmp += "</table><br />";
				records.innerHTML = _tmp + pager + "</div>";
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
<table valign="top"><tr>
<td align="center" colspan="2"><b><?=wfMsg('lookupcontribswiki')?></b></td>
<td align="center"><b><?=wfMsg('lookupcontribscontribslink')?></b></td>
<td align="center" colspan="2">&nbsp;</td>
</tr>
<? $loop = 0; foreach ($userActivity as $id => $city_id) {
	if ( (!empty($city_id)) && (!empty($wikiList[$city_id])) ) {
		$wikiname = $wikiList[$city_id];
		$loop++;
?>
<tr bgcolor="#FFFFDF">
	<td style="white-space:nowrap;padding:0px 10px 0px 1px;"><?=$loop?>.</td>
	<td><a href="<?=$wikiname->city_url?>" target="new"><?=$wikiname->city_url?></a></td>
	<td align="center">(<a href="<?php echo $wikiname->city_url?>index.php?title=Special:Contributions/<?php echo urlencode( $username ) ?>" target="new"><?=wfMsg('lookupcontribscontribs')?></a>)</td>
	<td><?=wfMsg('lookupcontribsdetails')?>&#160;<select name="mode" id="wkLCmode<?=$wikiname->city_dbname?>" class="small">
		<option value="normal"><?=wfMsg('lookupcontribsselectmodenormal')?></option><option value="final"><?=wfMsg('lookupcontribsselectmodefinal')?></option><option value="all"><?=wfMsg('lookupcontribsselectmodeall')?></option>
		</select>&#160;&#160;<input type="button" value="<?=wfMsg('lookupcontribsgo')?>" onclick="javascript:wkLCshowDetails('<?=$wikiname->city_dbname?>');" class="small">
	</td>
	<td id="wkLCUserActivityInd_<?=$wikiname->city_dbname?>" style="clear:both"></td>
</tr>
<tr><td colspan="4" valign="top" id="wkLCUserActivityRow_<?=$wikiname->city_dbname?>" style="line-height:0.3em">&nbsp;</td><td></td>
</tr>
<? } } ?>
</table>
&#160;&#160;
<br/>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
