<!-- s:<?= __FILE__ ?> -->
<!-- USER-ACTIVITY -->
<!-- css -->
<style>
.lc-points { white-space:nowrap;padding:0px 10px 0px 1px; }
.lc-row { padding: 3px; }
.lc-msg {clear:both; margin:5px 5px 15px 15px; padding:10px 5px;}
.lc-table-row {clear:both;margin:5px 5px 15px 0px;}
.lc-table-result {font-size:88%;}
</style>
<!-- js part -->
<script type="text/javascript">
/*<![CDATA[*/
function wfLCPager(total,link,page,limit,func,nspace) {
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
	nspace = typeof(nspace) != 'undefined' ? nspace : -1;

	//if ((!total) || (total <= 0)) return "";

	function __makeClickFunc(jsFunc, func, base, limit, offset, nspace) {
		return " " + jsFunc + "=\"" + func + "(" + base + "," + limit + "," + offset + "," + nspace + "); return false;\" ";
	}

	var page_count = Math.ceil(total/limit);
	var i = 0;
	var to = 0;

	var paramNbr = wfLCPager.arguments.length;
	var func_param = "";
	for (n = 6; n < paramNbr; n++) {
		func_param += "'" + wfLCPager.arguments[n] + "'";
		if (n < (paramNbr-1)) func_param += ",";
	}

	var nbr_result = "<select id=\"wcLCselect\" style=\"" + selectStyle + "\" ";
	nbr_result += __makeClickFunc("onChange", func, func_param, "this.value", 0, nspace);
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
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, (parseInt(page)-1), nspace);
			pager += "href=\"" + link + "&page=" + (parseInt(page)-1) + "\">" + lcL_ARROW + " " + lcPREVIOUS + "</a>&nbsp;&nbsp;";
		}

		if (( page - NUM_NUMBER ) < 0 ) {
			i = 0;
		} else {
			i = page - NUM_NUMBER;
		}

		if ( i > 0 ) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, 0, nspace) + " href=\"" + link + "&page=0\">1</a>&nbsp;";
			if ( i != 1) pager += "&nbsp;...&nbsp;&nbsp;";
		}

		for (k = i; k < page; k++) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, parseInt(k), nspace);
			pager += " href=\"" + link + "&page=" + parseInt(k) + "\">" + (parseInt(k)+1) + "</a>&nbsp;&nbsp;";
		}

		pager += "<b>" + (parseInt(page)+1) + "</b>&nbsp;&nbsp;";

		if (( parseInt(page) + parseInt(NUM_NUMBER) + 1 ) > parseInt(page_count) ) {
			to = page_count;
		} else {
			to = parseInt(page) + parseInt(NUM_NUMBER) + 1;
		}

		for (i = parseInt(page)+1; i < to; i++) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, parseInt(i), nspace);
			pager += " href=\"" + link + "&page=" + parseInt(i) + "\">" + (parseInt(i)+1) + "</a>&nbsp;&nbsp;";
		}

		if ( to < page_count ) {
			if ( to != page_count-1 ) pager += "&nbsp;...&nbsp;&nbsp;";
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, parseInt(page_count)-1, nspace);
			pager += "href=\"" + link + "&page=" + (parseInt(page_count)-1) + "\">" + page_count + "</a>";
		}

		if ( (parseInt(page) + 1) != parseInt(page_count) ) {
			pager += "&nbsp;&nbsp;<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, func_param, limit, (parseInt(page)+1), nspace);
			pager += " href=\"" + link + "&page=" + (parseInt(page)+1) + "\">" + lcNEXT + " " + lcR_ARROW + "</a>";
		}
	} else {
		pager += "&nbsp;&nbsp;<b>" + (parseInt(page)+1) + "</b>&nbsp;&nbsp;";
	}

	pager += "</td>";
	
	ns_result = "<select id=\"wcLCNSselect\" style=\"" + selectStyle + "\" ";
	ns_result += __makeClickFunc("onChange", func, func_param, limit, 0, "this.value");
	ns_result += "<option value=\"-1\"><?=wfMsg('allpages')?></option>";
	ns_result += "<option value=\"-2\"><?=wfMsgExt('lookupcontribsshowpages', array(), wfMsg('lookupcontribscontent') )?></option>";
	ns_result += "<optgroup label=\"<?=wfMsgExt('allinnamespace', array(), "")?>\">";
<? if ( !empty($nspaces) ) foreach ($nspaces as $id => $nspace) { if ( $id >= 0 ) { ?>	
	ns_result += "<option " + ((nspace == parseInt('<?=$id?>'))?'selected=\'true\'':'') + " value=\"<?=$id?>\"><?=( $id != 0 ) ? $nspace : wfMsg('nstab-main')?></option>";
<? } } ?>	
	ns_result += "</optgroup></select>";
	pager += "<td valign=\"middle\" align=\"left\"><?=wfMsg('show')?>: </td>";
	pager += "<td valign=\"middle\" align=\"left\">" + ns_result + "</td>";

	pager += "</tr></table>";
	return pager;
}

function wkLCshowDetails(dbname, limit, offset, nspace) {
	if (dbname == "") return false;
	limit = typeof(limit) != 'undefined' ?limit : 20;
	offset = typeof(offset) != 'undefined' ? offset : 0;
	nspace = typeof(nspace) != 'undefined' ? nspace : -1;

	var div_details = document.getElementById('wkLCUserActivityInd_' + dbname);
	var mode = document.getElementById('wkLCmode' + dbname);
	var username = document.getElementById('wkLCUserName');

	LookupContribsShowDetailsCallback = {
		success: function( oResponse )
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			div_details.innerHTML = "";
			var records = document.getElementById('wkLCUserActivityRow_' + dbname);
			//records.innerHTML = resData['nbr_records'];
			var url = "/index.php?title=Special:LookupContribs&target=<?=htmlspecialchars($username)?>";
			var pager = wfLCPager(resData['nbr_records'], url, resData['offset'], resData['limit'], 'wkLCshowDetails', resData['nspace'], dbname);
			var _tmp = "<div class=\"lc-table-row\">";
			_tmp += pager;
			loop = resData['offset'] * resData['limit'];
			// data 
			if (!resData) {
				_tmp += "<div class=\"lc-msg\"><?=wfMsg('lookupcontribsinvalidresults')?></div>";
			} else if (resData['nbr_records'] == 0) {
				_tmp += "<div class=\"lc-msg\"><?=wfMsg('lookupcontribsnoresultfound')?></div>";
			} else {
				_tmp += "<table width=\"100%\" valign=\"top\" class=\"TablePager\">";
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
			}
			records.innerHTML = _tmp + pager + "</div>";
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

	var params = "";
	if (div_details && username && dbname && mode) {
		params  = "&rsargs[0]=" + dbname;
		params += "&rsargs[1]=" + username.value;
		params += "&rsargs[2]=" + mode.value;
		params += "&rsargs[3]=" + limit;
		params += "&rsargs[4]=" + offset;
		params += "&rsargs[5]=" + nspace;
		div_details.innerHTML="<img src=\"http://images.wikia.com/common/skins/common/images/ajax.gif\" />";
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
<ol>
<? $loop = 0; foreach ($userActivity as $id => $row) { $loop++; ?>
<li>
<div>
	<span class="lc-row"><a href="<?=$row['url']?>"><?=$row['url']?></a></span>
	<span class="lc-row">(<a href="<?=$row['url']?>index.php?title=Special:Contributions/<?=urlencode($username) ?>"><?=wfMsg('lookupcontribscontribs')?></a>)</span>
	<span class="lc-row"><?=wfMsg('lookupcontribsdetails')?>&#160;<select name="mode" id="wkLCmode<?=$row['dbname']?>" class="small">
		<option value="normal"><?=wfMsg('lookupcontribsselectmodenormal')?></option>
		<option value="final"><?=wfMsg('lookupcontribsselectmodefinal')?>
		</option><option value="all"><?=wfMsg('lookupcontribsselectmodeall')?></option>
		</select>&#160;&#160;
		<input type="button" value="<?=wfMsg('lookupcontribsgo')?>" onclick="javascript:wkLCshowDetails('<?=$row['dbname']?>');" class="small">
	</span>
	<span class="lc-row" id="wkLCUserActivityInd_<?=$row['dbname']?>"></span>
</div>
<div>
	<span id="wkLCUserActivityRow_<?=$row['dbname']?>" class="lc-table-result">&nbsp;</span>
</div>
</li>
<? } ?>
</ol>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->


