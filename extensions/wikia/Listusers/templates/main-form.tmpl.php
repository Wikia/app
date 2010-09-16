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
	border-bottom: 1px outset #E0E4EF;
	border-right: 1px outset #E0E4EF;
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
	border-bottom:0px;
}
.lu_left {
	font-size:85%;
	border:1px solid black;
}
.lu_filter {
	padding: 3px 2px 7px 2px;
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
.lu_fieldset {
	line-height:10px;
	margin: 1px 0px;
	padding: 0px 2px 2px;
	width: 60%;
	white-space: nowrap;
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

function wfJSPager(total,link,page,limit,func,order,desc) {
	var lNEXT = "<?=wfMsg('listusersnext')?>";
	var lPREVIOUS = "<?=wfMsg('listusersprevious')?>";
	var lR_ARROW = ">";
	var lL_ARROW = "<";
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

	var nbr_result = "<select id=\"wcLUselect\" style=\"" + selectStyle + "\" ";
	nbr_result += __makeClickFunc("onChange", func, "this.value", 0, order, desc);
	for (k = 0; k <= 9; k++) {
		selected = (limit == (5*(parseInt(k)+1))) ? "selected='selected'" : "";
		nbr_result += "<option " + selected + " value=\""+(5*(parseInt(k)+1))+"\">" + (5*(parseInt(k)+1)) + "</option>";
	}
	nbr_result += "</select>";

	var pager  = "<table style=\"line-height:1.5em;" + tableStyle + "\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
	pager += "<tr><td valign=\"middle\" style=\"white-space:nowrap;\"><?=wfMsg('listusersnbrresult')?></td>";
	pager += "<td valign=\"middle\" align=\"left\">" + nbr_result + "</td>";
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

function wkLUshowDetails(limit, offset, ord, desc)
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
			var resData = "";
			if (YAHOO.Tools) {
				resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			} else if ((YAHOO.lang) && (YAHOO.lang.JSON)) {
				resData = YAHOO.lang.JSON.parse(oResponse.responseText);
			} else {
				resData = eval('(' + oResponse.responseText + ')');
			}
			div_details.innerHTML = "";
			var records = document.getElementById('lu-result');
			if ( (!resData) || (resData['nbr_records'] == 0) ) {
				records.innerHTML = "<br /><div style=\"clear:both;border:1px dashed #D5DDF2;margin:4px 5px 4px 15px;padding:5px;\"><?=wfMsg('listusersnodata')?></div><br />";
			} else {
				page = resData['page'];
				limit = resData['limit'];
				order = resData['order'];
				desc = resData['desc'];
				//
				div_details.innerHTML = foundText.replace("CNT", resData['nbr_records']);
				//
				pager = wfJSPager(resData['nbr_records'],"/index.php?title=Special:Listusers", page, limit, 'wkLUshowDetails', order, desc);
				var _tmp = "<div style=\"clear:both\">";
				_tmp += pager;
 				_tmp += "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" valign=\"top\" class=\"TablePager\">";
				var oneRow = "<tr><th>#</th>";
				var _th = (order == 'username') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_username\" style=\"cursor:pointer;" + ((order == 'username') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('listusers-username')?></a></th>";
				_th = (order == 'groups') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_groups\" style=\"cursor:pointer;" + ((order == 'groups') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('listusers-groups')?></a></th>";
				_th = (order == 'revcnt') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_revcnt\" style=\"cursor:pointer;" + ((order == 'revcnt') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('listusersrev-cnt')?></a></th>";
				//if (wgUserName) {
					_th = (order == 'loggedin') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
					oneRow += "<th><a id=\"TablePager_loggedin\" style=\"cursor:pointer;" + ((order == 'loggedin') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('listusers-loggedin')?></a></th>";
					_th = (order == 'dtedit') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
					oneRow += "<th><a id=\"TablePager_dtedit\" style=\"cursor:pointer;" + ((order == 'dtedit') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('listusers-edited')?></a></th>";
					oneRow += "</tr>";
				//}
				_tmp += oneRow;
 				loop = limit * offset;
 				if (resData['data']) {
					for (i in resData['data']) {
						loop++;
						var blocked = (resData['data'][i]['blcked'] == 1) ? "style=\"color:#DF2930\"" : "";
						oneRow = "<tr><td " + blocked + " >" + loop  + ".</td>";
						oneRow += "<td " + blocked + " ><span style=\"font-size:90%;font-weight:bold;\">" +resData['data'][i]['user_link']+ "</span> <span style=\"font-size:77%; padding-left:8px;\">" + resData['data'][i]['links'] + "</span></td>";
						oneRow += "<td " + blocked + " >" +resData['data'][i]['groups']+ "</td>";
						oneRow += "<td " + blocked + " >" +resData['data'][i]['rev_cnt']+ "</td>";
						//if (wgUserName) {
							oneRow += "<td " + blocked + " >" + ((resData['data'][i]['last_login']) ? resData['data'][i]['last_login'] : "-") + "</td>";
							oneRow += "<td " + blocked + " >" ;
							if (resData['data'][i]['last_edit_ts']) {
								oneRow += "<a href='" + resData['data'][i]['last_edit_page'] + "'>" + resData['data'][i]['last_edit_ts'] + "</a>";
								oneRow += " (<a href='" + resData['data'][i]['last_edit_diff'] + "'><?=wfMsg('diff')?></a>)";
							} else {
								oneRow += " - ";
							}
							oneRow += "</td>";
						//}
						oneRow += "</tr>";
						_tmp += oneRow;
					}
				}
				_tmp += "</table><br />";
				records.innerHTML = _tmp + pager + "</div>";
				_addEvents(order, desc);
			}
		},
		failure: function( oResponse )
		{
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
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
		params += "&rsargs[5]=" + ord;
		params += "&rsargs[6]=" + desc;
		//---
		div_details.innerHTML="<img src=\"<?=$wgStylePath?>/common/images/ajax.gif\" />";
		//---
		var baseurl = wgScript + "?action=ajax&rs=Listusers::axShowUsers" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, LocalUsersShowDetailsCallback);
	}
}

__ShowUsers = function(e, args) {
	var _id = this.id;
	var _desc = args[0];
	var _order = "username";
	if (_id.indexOf('TablePager_', 0) !== -1) {
		_order = _id.replace('TablePager_', '');
	}
	var select_pages = document.getElementById('wcLUselect');
	var cnt = (select_pages) ? select_pages.value : 30;
	wkLUshowDetails(cnt, 0, _order, _desc);
};

function _addEvents(f, desc) {
	YAHOO.util.Event.addListener("TablePager_username", "click", __ShowUsers, [(f == 'username')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_groups", "click", __ShowUsers, [(f == 'groups')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_revcnt", "click", __ShowUsers, [(f == 'revcnt')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_loggedin", "click", __ShowUsers, [(f == 'loggedin')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_dtedit", "click", __ShowUsers, [(f == 'dtedit')?desc*-1:desc]);
}

//http://images.wikia.com/common/releases_200901.3/skins/common/images/Arr_u.png
//http://images.wikia.com/common/releases_200901.3/skins/common/images/Arr_d.png

$(function() {
	$.loadYUI(function() {
		wkLUshowDetails(30, 0, 'username', -1);
		var desc = -1;
		YAHOO.util.Event.addListener("lu-showusers", "click", __ShowUsers, [desc]);
	});
});

/*]]>*/
</script>
<p class='error'><?=$error?></p>
<div>
<form method="post" action="<?=$action?>" id="lu-form">
<? $found = 0; ?>
<? if ( !empty($groupList) && (!empty($aGroups)) ) { ?>
<fieldset class="lu_fieldset">
<legend><?=wfMsg('listusers-groups')?></legend>
	<table><tr>
	<? $i = 0; foreach ($aGroups as $groupName => $userGroupName) { ?>
		<? if ($i % 3 == 0) { ?>
	</tr><tr>
		<? } ?>
		<? $found += (in_array($groupName, $mGroup) && isset($groupList[$groupName])) ? $groupList[$groupName] : 0 ?>
		<?
			$groupLink = wfMsgExt("Grouppage-{$groupName}", array('parseinline') );
			$link = "";
			if ( !wfEmptyMsg("Grouppage-{$groupName}", $groupLink) ) {
				$sk = $wgUser->getSkin();
				$link = $sk->makeLink($groupLink, $wgContLang->ucfirst($userGroupName), "");
			} else {
				$groupLink = "";
				$link = $wgContLang->ucfirst($userGroupName);
			}
		?>
	<td valign="middle" style="padding:0px 3px;">
		<span style="vertical-align:middle"><input type="checkbox" name="lu_target" id="lu_target" value="<?=$groupName?>" <?=(in_array($groupName, $mGroup))?"checked=\"checked\"":''?>></span>
		<span style="padding-bottom:5px;"><strong><?=$link?></strong> (<?=wfMsg('listuserscount', (isset($groupList[$groupName]))?$groupList[$groupName]:0 )?>)</span>
	</td>
		<? $i++; ?>
	<? } ?>
	</tr></table>
</fieldset>
<? } ?>
<fieldset class="lu_fieldset">
<legend><?=wfMsg('listusers-options')?></legend>
	<div class="lu_filter">
		<span class="lu_filter lu_first"><?= wfMsg('listusersstartingtext') ?></span>
		<span class="lu_filter"><input type="text" name="lu_search" id="lu_search" size="5"></span>
		<span class="lu_filter lu_first"><?= wfMsg('listuserscontributed') ?></span>
		<span class="lu_filter"><select name="lu_contributed" id="lu_contributed" ><? foreach ($contributed as $val => $text) { ?><option <?= ($val == $selContrib) ? "selected='selected'" : "" ?> value="<?=$val?>"><?=$text?><? } ?></select></span>
		<span class="lu_filter"><input type="button" value="<?=wfMsg('listusersdetails')?>" id="lu-showusers"></span>
	</div>
</fieldset>
<div style="font-size:85%;text-align:right;height:20px;" id="listusers-result"><?=wfMsg('listusersfound', $found)?></div>
<div id="lu-result" style="font-size:100%;clear:both;"></div>
</form>
</div>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
