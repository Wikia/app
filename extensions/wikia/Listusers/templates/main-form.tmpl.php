<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<style>
.lu_td { 
	height:30px;
	padding:2px 5px;
	font-size:90%;
	white-space: nowrap;
}
.lu_row {
	border: 1px dashed #E0E4EF;
	font-size:100%;
	padding: 1px 3px;
	text-align: left;
	white-space:normal;
}
.lu_result {
	padding:2px;
	font-size:90%;
	border:1px solid black;
	width:110px;
	text-align:center;
	border-left:0px;
	border-bottom:0px;
}
.lu_header {
	valign:top;
	border:1px solid black;
	border-left:0px;
	border-bottom:0px;
}
.lu_left {
	font-size:85%;
	border:1px solid black;	
}
.lu_filter {
	padding: 2px;
}
.lu_first {
	padding-left: 5px;
}
.lu_groups {
	list-style:none;
	height:65px;
	overflow-y:scroll;
	padding:1px 5px;
	margin:1px;
}
</style>
<script type="text/javascript">
/*<![CDATA[*/

function __makeParamValue(f) {
	var target = "";
	if (f.lu_target) {
		if (f.lu_target.length > 0) {
			for ( i = 0; i < f.lu_target.length; i++ ) {
				if (f.lu_target[i].checked) {
					target += f.lu_target[i].value + ",";
				}
			}
		}
	}
	return target;
}

function wfJSPager(total,link,page,limit,func) {
	var lNEXT = "<?=wfMsg('listusersnext')?>";
	var lPREVIOUS = "<?=wfMsg('listusersprevious')?>";
	var lR_ARROW = ">";
	var lL_ARROW = "<";
	var NUM_NUMBER = 5;

	var selectStyle = "font-size:8.5pt;font-weight:normal;";
	var tdStyle = "";
	var tableStyle = "font-size:8.5pt;font-weight:normal;margin:5px;";
	var linkStyle = "background-color:#FFFFFF;border:1px solid #CBCBCB;padding:2px 6px;";

	limit = typeof(limit) != 'undefined' ?limit : 20;
	page = typeof(page) != 'undefined' ? page : 0;

	if ((!total) || (total <= 0)) return "";

	function __makeClickFunc(jsFunc, func, limit, offset) {
		return " " + jsFunc + "=\"" + func + "(" + limit + "," + offset + "); return false;\" ";
	}

	var page_count = Math.ceil(total/limit);
	var i = 0;
	var to = 0;

	var nbr_result = "<select id=\"wcLUselect\" style=\"" + selectStyle + "\" ";
	nbr_result += __makeClickFunc("onChange", func, "this.value", 0);
	for (k = 0; k <= 9; k++) {
		selected = (limit == (5*(parseInt(k)+1))) ? "selected" : "";
		nbr_result += "<option " + selected + " value=\""+(5*(parseInt(k)+1))+"\">" + (5*(parseInt(k)+1)) + "</option>";
	}
	nbr_result += "</select>";

	var pager  = "<table style=\"line-height:1.5em;" + tableStyle + "\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
	pager += "<tr><td valign=\"middle\" style=\"white-space:nowrap;\"><?=wfMsg('listusersnbrresult')?></td>";
	pager += "<td valign=\"middle\" align=\"left\">" + nbr_result + "</td>";
	pager += "<td align=\"center\" valign=\"middle\" style=\"white-space:nowrap;width:100%;\">";

	if (page_count > 1) {
		if (page != 0) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, (parseInt(page)-1));
			pager += "href=\"" + link + "&page=" + (parseInt(page)-1) + "\">" + lL_ARROW + " " + lPREVIOUS + "</a>&nbsp;&nbsp;";
		}

		if (( page - NUM_NUMBER ) < 0 ) {
			i = 0;
		} else {
			i = page - NUM_NUMBER;
		}

		if ( i > 0 ) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, 0) + " href=\"" + link + "&page=0\">1</a>&nbsp;";
			if ( i != 1) pager += "&nbsp;...&nbsp;&nbsp;";
		}

		for (k = i; k < page; k++) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, parseInt(k));
			pager += " href=\"" + link + "&page=" + parseInt(k) + "\">" + (parseInt(k)+1) + "</a>&nbsp;&nbsp;";
		}

		pager += "<b>" + (parseInt(page)+1) + "</b>&nbsp;&nbsp;";

		if (( parseInt(page) + parseInt(NUM_NUMBER) + 1 ) > parseInt(page_count) ) {
			to = page_count;
		} else {
			to = parseInt(page) + parseInt(NUM_NUMBER) + 1;
		}

		for (i = parseInt(page)+1; i < to; i++) {
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, parseInt(i));
			pager += " href=\"" + link + "&page=" + parseInt(i) + "\">" + (parseInt(i)+1) + "</a>&nbsp;&nbsp;";
		}

		if ( to < page_count ) {
			if ( to != page_count-1 ) pager += "&nbsp;...&nbsp;&nbsp;";
			pager += "<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, parseInt(page_count)-1);
			pager += "href=\"" + link + "&page=" + (parseInt(page_count)-1) + "\">" + page_count + "</a>";
		}

		if ( (parseInt(page) + 1) != parseInt(page_count) ) {
			pager += "&nbsp;&nbsp;<a style=\"" + linkStyle + "\" " + __makeClickFunc("onclick", func, limit, (parseInt(page)+1));
			pager += " href=\"" + link + "&page=" + (parseInt(page)+1) + "\">" + lNEXT + " " + lR_ARROW + "</a>";
		}
	} else {
		pager += "&nbsp;&nbsp;<b>" + (parseInt(page)+1) + "</b>&nbsp;&nbsp;";
	}

	pager += "</td>";
	pager += "</tr></table>";
	return pager;
}

function wkLUshowDetails(limit, offset) 
{
	limit = typeof(limit) != 'undefined' ?limit : 30;
	offset = typeof(offset) != 'undefined' ? offset : 0;

	var div_details = document.getElementById('listusers-result');

	var f = document.getElementById('lu-form');
	var userText 	= document.getElementById( "lu_search" );
	var contributed	= document.getElementById( "lu_contributed" );
	var target = __makeParamValue(f);

	var foundText = "<?=wfMsg('listusersfound', "CNT")?>";

	LocalUsersShowDetailsCallback = {
		success: function( oResponse )
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			div_details.innerHTML = "";
			var records = document.getElementById('lu-result');
			if ( (!resData) || (resData['nbr_records'] == 0) ) {
				records.innerHTML = "<div style=\"clear:both;border:1px dashed #D5DDF2;margin:0px 5px 0px 15px;padding:5px;\"><?=wfMsg('listusersnodata')?></div>";
			} else { 
				page = resData['page'];
				limit = resData['limit'];
				//
				div_details.innerHTML = foundText.replace("CNT", resData['nbr_records']);
				//
				pager = wfJSPager(resData['nbr_records'],"/index.php?title=Special:Listusers", page, limit, 'wkLUshowDetails');
				var _tmp = "<div>";
				_tmp += pager;
 				_tmp += "<br /><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" valign=\"top\">";
				var oneRow = "<tr><th class=\"lu_row\" rowspan=\"2\">#</th>";
				oneRow += "<th class=\"lu_row\" rowspan=\"2\"><?=wfMsg('listusers-username')?></th>";
				oneRow += "<th class=\"lu_row\" rowspan=\"2\"><?=wfMsg('listusers-groups')?></th>";
				oneRow += "<th class=\"lu_row\" rowspan=\"2\"><?=wfMsg('listusersrev-cnt')?></th>";
				oneRow += "<th class=\"lu_row\" colspan=\"2\"><?=wfMsg('listusers-last')?></th></tr>";
				oneRow += "<tr><th class=\"lu_row\"><?=wfMsg('listusers-loggedin')?></th>";
				oneRow += "<th class=\"lu_row\"><?=wfMsg('listusers-edited')?></th></tr>";
				_tmp += oneRow;
 				loop = limit * offset;
 				if (resData['data']) {
					for (i in resData['data']) {
						loop++;
						var blocked = (resData['data'][i]['blcked'] == 1) ? "style=\"color:#DF2930\"" : "";
						oneRow = "<tr><td class=\"lu_row\" " + blocked + " >" + loop  + ".</td>";
						oneRow += "<td class=\"lu_row\" " + blocked + " ><span style=\"font-size:90%;font-weight:bold;\">" +resData['data'][i]['user_link']+ "</span> <span style=\"font-size:77%; padding-left:8px;\">" + resData['data'][i]['links'] + "</span></td>";
						oneRow += "<td class=\"lu_row\" " + blocked + " >" +resData['data'][i]['groups']+ "</td>";
						oneRow += "<td class=\"lu_row\" " + blocked + " >" +resData['data'][i]['rev_cnt']+ "</td>";
						oneRow += "<td class=\"lu_row\" " + blocked + " >" + ((resData['data'][i]['last_login']) ? resData['data'][i]['last_login'] : "-") + "</td>";
						oneRow += "<td class=\"lu_row\" " + blocked + " >" + ((resData['data'][i]['last_edited']) ? resData['data'][i]['last_edited'] : "-") + "</td>";
						oneRow += "</tr>";
						_tmp += oneRow;
					}
				}
				_tmp += "</table><br />";
				records.innerHTML = _tmp + pager + "</div>";
			}
		},
		failure: function( oResponse )
		{
			var records = document.getElementById('lu-result');
			div_details.innerHTML = "";
			if (!resData) {
				records.innerHTML = "<?=wfMsg('lookupcontribsinvalidresults')?>";
			}
		}
	};

	var params = "";
	if (div_details && userText && contributed && target) {
		var params = "&rsargs[0]=" + target;
		params += "&rsargs[1]=" + userText.value;
		params += "&rsargs[2]=" + contributed.value;
		params += "&rsargs[3]=" + limit;
		params += "&rsargs[4]=" + offset;
		//---
		YAHOO.util.Event.preventDefault(e);
		div_details.innerHTML="<img src=\"<?=$wgExtensionsPath?>/wikia/Listusers/images/ajax-loader-s.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=ListUsers::axShowUsers" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, LocalUsersShowDetailsCallback);
	}
}

YAHOO.util.Event.onDOMReady(function () {
	YAHOO.namespace("Wikia.ListUsers");
	wkLUshowDetails();
	
	YAHOO.Wikia.ListUsers.ShowUsers = function(e) {
		var select_pages = document.getElementById('wcLUselect');
		var cnt = (select_pages) ? select_pages.value : 30;
		wkLUshowDetails(cnt, 0);
	};

	YAHOO.util.Event.addListener("lu-showusers", "click", YAHOO.Wikia.ListUsers.ShowUsers);
});

/*]]>*/
</script>
<p class='error'><?=$error?></p>
<form method="post" action="<?=$action?>" id="lu-form">
<table style="width:100%;" cellpadding="0" cellspacing="0"><tr>
<td valign="middle" class="lu_left" style="border-bottom:0px;width:230px;">
<? $found = 0; ?>	
<? if ( !empty($groupList) && (!empty($aGroups)) ) { ?>
	<ul class="lu_groups">
	<? foreach ($aGroups as $groupName => $userGroupName) { ?>
		<? $found += (in_array($groupName, $mGroup) && isset($groupList[$groupName])) ? $groupList[$groupName] : 0 ?>
		<li style="height:15px"><span style="vertical-align: middle"><input type="checkbox" name="lu_target" id="lu_target" value="<?=$groupName?>" "<?=(in_array($groupName, $mGroup))?"checked":""?>"></span>
			<span style="padding-bottom:5px;"><strong><?=$wgContLang->ucfirst($userGroupName)?></strong> (<?= wfMsg('listuserscount', (isset($groupList[$groupName]))?$groupList[$groupName]:0 ) ?>)</span>
		</li>
	<? } ?>
	</ul>
<? } ?>
</td>
<td class="lu_header">
	<div class="lu_filter">
		<span class="lu_filter lu_first"><?= wfMsg('listusersstartingtext') ?></span>
		<span class="lu_filter"><input type="text" name="lu_search" id="lu_search" size="5"></span>
	</div>
	<div class="lu_filter">
		<span class="lu_filter lu_first"><?= wfMsg('listuserscontributed') ?></span>
		<span class="lu_filter"><select name="lu_contributed" id="lu_contributed" ><? foreach ($contributed as $val => $text) { ?><option <?= ($val == $selContrib) ? "selected" : "" ?> value="<?=$val?>"><?=$text?><? } ?></select></span>
		<span class="lu_filter"><input type="button" value="<?=wfMsg('listusersdetails')?>" id="lu-showusers"></span>
	</div>	
</td>
<td valign="middle" class="lu_result">
	<div style="font-size:85%;" id="listusers-result"><?=wfMsg('listusersfound', $found)?></div>
</td>
</tr>
<tr>
<td valign="top" colspan="3" class="lu_left" id="lu-result" style="font-size:100%"></td>
</tr>
</table>
</form>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
