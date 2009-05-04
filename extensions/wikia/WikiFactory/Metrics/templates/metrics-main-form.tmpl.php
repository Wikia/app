<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
.awc-metrics-row {padding:2px 4px;}
.awc-metrics-row span {padding:0px 1px 0px 4px;}
.awc-metrics-msg {clear:both;margin:4px 5px 4px 15px;padding:5px;}
.awc-buttons {white-space:nowrap;}
.awc-buttons input {font-size:90%;}
.awc-metrics-fieldset {font-size:90%;}
.awc-metrics-fieldset select {font-size:90%;}
.awc-metrics-fieldset input {font-size:90%;}
div#widget_sidebar { display: none !important; }
div#wikia_page { margin-left: 5px; z-index:100; }
div#sidebar { display: none !important; }
.TablePager th { font-size:91%; }
.TablePager td { padding:1px; }
</style>
<p class='error'><?=$error?></p>
<div>
<form method="post" action="<?=$action?>" id="awc-metrics-form">
<? $found = 0; $i = 0; $isSelected = false; ?>	
<!-- options -->
	<div>
	<fieldset class="awc-metrics-fieldset">
		<legend><?=wfMsg('awc-metrics-wikis')?></legend>
		<table style="text-align:left;">
			<tr><td valign="middle" class="awc-metrics-row">
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-select')?></span>
				<span style="vertical-align:middle">
					<select name="awc-metrics-created" id="awc-metrics-created">
			<? foreach ($mPeriods as $value => $text) : ?>
			<? $selected = ($mDefPeriod == $value) ? " selected=\"selected\" " : ""; ?>
					<option <?=$selected?> value="<?=$value?>"><?= wfMsg('awc-metrics-' . $text) ?></option>
			<? endforeach ?>
					</select>
				</span>
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-by-language')?></span>
				<span style="vertical-align:middle">
					<select name="awc-metrics-language" id="awc-metrics-language"><option value="0"><?=wfMsg('awc-metrics-all-languages')?></option>
<?php 			if (!empty($aTopLanguages) && is_array($aTopLanguages)) : ?>
					<optgroup label="<?= wfMsg('autocreatewiki-language-top', count($aTopLanguages)) ?>">
<?php 				foreach ($aTopLanguages as $sLang) : ?>
						<option value="<?=$sLang?>"><?=$aLanguages[$sLang]?></option>
<?php 				endforeach ?>
					</optgroup>
<?php 			endif ?>
					<optgroup label="<?= wfMsg('autocreatewiki-language-all') ?>">
<?php 			if (!empty($aLanguages) && is_array($aLanguages)) : ?>
<?php				foreach ($aLanguages as $sLang => $sLangName) : ?>
						<option value="<?=$sLang?>"><?=$sLangName?></option>
<?php 				endforeach ?>
					</optgroup>
<?php 			endif ?>
					</select>
				</span>
			</td></tr>
		</table>
		<table width="100%" style="text-align:left;">
			<tr><td valign="middle" class="awc-metrics-row">
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-created-between', '<input name="awc-metrics-between-from" id="awc-metrics-between-from" size="15" />', '<input name="awc-metrics-between-to" id="awc-metrics-between-to" size="15" />')?></span>
			</td></tr>
		</table>
		<table width="100%" style="text-align:left;">
			<tr><td valign="middle" class="awc-metrics-row">
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-by-domains')?></span>
				<span style="vertical-align:middle"><input name="awc-metrics-domains" id="awc-metrics-domains" size="15" /></span>
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-by-title')?></span>
				<span style="vertical-align:middle"><input name="awc-metrics-title" id="awc-metrics-title" size="15" /></span>
			</td></tr>
			<tr><td valign="middle" class="awc-metrics-row">
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-by-user')?></span>
				<span style="vertical-align:middle"><input name="awc-metrics-user" id="awc-metrics-user" size="15" /></span>
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-by-email')?></span>
				<span style="vertical-align:middle"><input name="awc-metrics-email" id="awc-metrics-email" size="30" /></span>
			</td></tr>
		</table>
		<table width="100%" style="text-align:left;">
			<tr>
				<td valign="middle" class="awc-metrics-row">
					<input name="awc-metrics-closed" id="awc-metrics-closed" type="checkbox" /> <?=wfMsg('awc-metrics-closed')?>
					<input name="awc-metrics-redirected" id="awc-metrics-redirected" type="checkbox" /> <?=wfMsg('awc-metrics-redirected')?>
				</td>
				<td valign="middle" class="awc-metrics-row" align="right">
					<input type="button" value="<?=wfMsg('search')?>" id="awc-metrics-submit" />
					<input type="button" value="<?=wfMsg('awc-metrics-hubs')?>" id="awc-metrics-hubs" />
					<input type="button" value="<?=wfMsg('awc-metrics-news-day')?>" id="awc-metrics-news-day" />
				</td>
			</tr>
		</table>
	</fieldset>
	</div>
<!-- end of options -->
	<div style="text-align:right;height:25px;" id="awc-metrics-result"><?=wfMsg('awc-metrics-wikis-found', $found)?></div>
	<div id="awc-metrics-list" style="font-size:83.666%;clear:both;"></div>
</form> 
</div>
<script type="text/javascript">
/*<![CDATA[*/
var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;

function wfJSPager(total,link,page,limit,func,order,desc,additional) {
	var lNEXT = " ";
	var lPREVIOUS = " ";
	var lR_ARROW = "&#8658;";
	var lL_ARROW = "&#8656;";
	var NUM_NUMBER = 4;

	var selectStyle = "font-size:8.5pt;font-weight:normal;";
	var tdStyle = "";
	var tableStyle = "font-size:8.5pt;font-weight:normal;margin:5px;";
	var linkStyle = "font-size:9pt;padding:2px 6px;";

	limit = typeof(limit) != 'undefined' ?limit : <?=CreateWikiMetrics::LIMIT?>;
	page = typeof(page) != 'undefined' ? page : 0;

	if ((!total) || (total <= 0)) return "";

	function __makeClickFunc(jsFunc, func, limit, offset, order, desc) {
		return " " + jsFunc + "=\"" + func + "(" + limit + "," + offset + ", '" + order + "'," + desc + "); return false;\" ";
	}

	var page_count = Math.ceil(total/limit);
	var i = 0;
	var to = 0;

	var nbr_result = "<select id=\"wcAWCMetricsSelect\" style=\"" + selectStyle + "\" ";
	nbr_result += __makeClickFunc("onChange", func, "this.value", 0, order, desc);
	for (k = 0; k <= 9; k++) {
		selected = (limit == (5*(parseInt(k)+1))) ? "selected" : "";
		nbr_result += "<option " + selected + " value=\""+(5*(parseInt(k)+1))+"\">" + (5*(parseInt(k)+1)) + "</option>";
	}
	nbr_result += "</select>";

	var pager  = "<table style=\"line-height:1.5em;" + tableStyle + "\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
	pager += "<tr><td valign=\"middle\" style=\"white-space:nowrap;\"><?=wfMsg('awc-metrics-nbr-result')?></td>";
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

		pager += "<span style=\"font-weight:bold;font-size:10pt;" + linkStyle + "\">" + (parseInt(page)+1) + "</span>&nbsp;&nbsp;";

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
		pager += "&nbsp;&nbsp;<span style=\"font-weight:bold;" + linkStyle + "\">" + (parseInt(page)+1) + "</span>&nbsp;&nbsp;";
	}

	pager += "</td>";
	if (additional) {
		pager += "<td>" + additional + "</td>";
	}
	pager += "</tr></table>";
	return pager;
}

function wkAWCMetricsDetails(limit, offset, ord, desc) 
{
	limit = typeof(limit) != 'undefined' ?limit : <?=CreateWikiMetrics::LIMIT?>;
	offset = typeof(offset) != 'undefined' ? offset : 0;

	var div_details = YD.get( "awc-metrics-result" );
	var f 			= YD.get( "awc-metrics-form" );
	//----
	var created 	= YD.get( "awc-metrics-created" );
	var language	= YD.get( "awc-metrics-language" );
	var between_f 	= YD.get( "awc-metrics-between-from" );
	var between_to  = YD.get( "awc-metrics-between-to" );
	//----
	var domain 		= YD.get( "awc-metrics-domains" );
	var title		= YD.get( "awc-metrics-title" );
	var user 		= YD.get( "awc-metrics-user" );
	var email 		= YD.get( "awc-metrics-email" );

	var closed 		= YD.get( "awc-metrics-closed" );
	var redirected 	= YD.get( "awc-metrics-redirected" );

	var foundText 	= "<?=wfMsg('awc-metrics-wikis-found', "CNT")?>";

	AWCMetricsDetailsCallback = {
		success: function( oResponse )
		{
			var resData = __parseResponse(oResponse.responseText);
			div_details.innerHTML = "";
			var records = YD.get( "awc-metrics-list" );
			if ( (!resData) || (resData['nbr_records'] == 0) ) {
				tmp  = "<br />";
				tmp += "<div class=\"awc-metrics-msg\"><?=wfMsg('awc-metrics-not-found')?></div>";
				tmp += "<br />";
				records.innerHTML = tmp;
			} else { 
				page = resData['page'];
				limit = resData['limit'];
				order = resData['order'];
				desc = resData['desc'];
				//
				div_details.innerHTML = foundText.replace("CNT", resData['nbr_records']);
				//
				var buttons = "<div class=\"awc-buttons\">";
				buttons += "<input type=\"submit\" value=\"Close\" name=\"submit0\"/>";
				buttons += "<input type=\"submit\" value=\"Close and Redirect\" name=\"submit1\"/>";
				buttons += "<input type=\"submit\" value=\"Close and Delete\" name=\"submit2\"/>";
				buttons += "</div>";
				
				pager = wfJSPager(resData['nbr_records'], wgScript + "?title=" + wgPageName + "/metrics", page, limit, 'wkAWCMetricsDetails', order, desc, buttons);
				//
				var _tmp = "<div style=\"clear:both\">";
				_tmp += pager;
 				_tmp += "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" valign=\"top\" class=\"TablePager\" style=\"text-align:center\">";
 				
 				// first column (#)
				var oneRow = "<tr><th rowspan=\"2\">#</th>";

				// column (TITLE)
				var _th = (order == 'title') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_title\" style=\"cursor:pointer;" + ((order == 'title') ? "color:#006400;" : "") + "\">" + _th + " Wikia</a></th>";

				// column (DBNAME)
				var _th = (order == 'db') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_db\" style=\"cursor:pointer;" + ((order == 'db') ? "color:#006400;" : "") + "\">" + _th + " DBName</a></th>";
				
				// column (LANG)
				_th = (order == 'lang') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_lang\" style=\"cursor:pointer;" + ((order == 'lang') ? "color:#006400;" : "") + "\">" + _th + " Lang</a></th>";

				// column (CREATED)				
				_th = (order == 'created') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_created\" style=\"cursor:pointer;" + ((order == 'created') ? "color:#006400;" : "") + "\">" + _th + " Created</a></th>";
				
				// column (FOUNDER)
				_th = (order == 'founderName') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				var _th2 = (order == 'founderEmail') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_founderName\" style=\"cursor:pointer;" + ((order == 'founderName') ? "color:#006400;" : "") + "\">" + _th + " Founder</a>";
				oneRow += "<a id=\"TablePager_founderEmail\" style=\"cursor:pointer;" + ((order == 'founderEmail') ? "color:#006400;" : "") + "\">" + _th2 + " Founder email</a></th>";

				// column (FOUNDER EMAIL)
				//_th = (order == 'founderEmail') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				//oneRow += "<th rowspan=\"2\"><a id=\"TablePager_founderEmail\" style=\"cursor:pointer;" + ((order == 'founderEmail') ? "color:#006400;" : "") + "\">" + _th + " Founder email</a></th>";

				// columns (stats)
				oneRow += "<th colspan=\"10\" style=\"text-align:center\"><?=wfMsg('awc-metrics-statistics')?></th>";

				// column (pageviews)
				_th = (order == 'pageviews') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_pageviews\" style=\"cursor:pointer;" + ((order == 'pageviews') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-pageviews')?></a></th>";
				
				// column (options)
				oneRow += "<th rowspan=\"2\" style=\"text-align:center\"><?=wfMsg('awc-metrics-close')?></th></tr>";

				_tmp += oneRow;
				
				///////////////////////////////
				// second row in table header 
				///////////////////////////////
				oneRow = "<tr>";

				// column (WIKIANS)
				_th = (order == 'wikians') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_wikians\" style=\"cursor:pointer;" + ((order == 'wikians') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-wikians')?></a></th>";

				// column (ARTICLES)
				_th = (order == 'articles') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_articles\" style=\"cursor:pointer;" + ((order == 'articles') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-articles')?></a></th>";

				// column (NEW_ARTICLES_PER_DAY)
				_th = (order == 'articles_per_day') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_articles_per_day\" style=\"cursor:pointer;" + ((order == 'articles_per_day') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-articles-per-day')?></a></th>";

				// column (REVISIONS)
				_th = (order == 'mean_nbr_revision') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_mean_nbr_revision\" style=\"cursor:pointer;" + ((order == 'mean_nbr_revision') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-revisions-per-page')?></a></th>";

				// column (MEAN SIZE)
				_th = (order == 'mean_size') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_mean_size\" style=\"cursor:pointer;" + ((order == 'mean_size') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-article-avg-size')?></a></th>";

				// column (EDITS)
				_th = (order == 'edits') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_edits\" style=\"cursor:pointer;" + ((order == 'edits') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-edits')?></a></th>";

				// column (DB_SIZE)
				_th = (order == 'db_size') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_db_size\" style=\"cursor:pointer;" + ((order == 'db_size') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-db-size')?></a></th>";

				// column (images)
				_th = (order == 'images') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_images\" style=\"cursor:pointer;" + ((order == 'images') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-images')?></a></th>";

				// column (users_reg)
				_th = (order == 'users_reg') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_users_reg\" style=\"cursor:pointer;" + ((order == 'users_reg') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-all-users')?></a></th>";

				// column (users_edits)
				_th = (order == 'users_edits') ? ((desc == -1) ? "&darr;" : "&uarr;") : "";
				oneRow += "<th><a id=\"TablePager_users_edits\" style=\"cursor:pointer;" + ((order == 'users_edits') ? "color:#006400;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-all-users-edit-main-ns')?></a></th>";

				oneRow += "</tr>";
				
				_tmp += oneRow;
				
				///////////////////////////////
				// data
				///////////////////////////////
 				loop = limit * offset;
 				if (resData['data']) {
					for (i in resData['data']) {
						loop++;
						var cssClass = " style=\"color:#000000;\" ";
						var is_closed = 0;
						if (resData['data'][i]['public'] == 0) {
							// closed
							cssClass = " style=\"color:#EF0036;\" ";
							is_closed = 1;
						} else if (resData['data'][i]['public'] == 2) {
							// redirected
							cssClass = " style=\"color:#26CF5D;\" ";
						}
						oneRow = "<tr style=\"font-size:90%;\"><td>" + loop  + ".</td>";
						oneRow += "<td " + cssClass + "><a href=\"" + resData['data'][i]['url'] + "\" target=\"new\">" +resData['data'][i]['title']+ "</a></td>";
						oneRow += "<td " + cssClass + ">" + resData['data'][i]['db']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['lang']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['created']+ "</td>";
						oneRow += "<td " + cssClass + "><div>" +resData['data'][i]['founderUrl']+ "</div><div>" +resData['data'][i]['founderEmail']+ "</div></td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['wikians']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['articles']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['articles_per_day']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['mean_nbr_revision']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['mean_size_txt']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['edits']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['db_size_txt']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['images']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['users_reg']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['users_edits']+ "</td>";
						oneRow += "<td " + cssClass + ">" +resData['data'][i]['pageviews_txt']+ "</td>";
						oneRow += "<td " + cssClass + "><input type=\"checkbox\" " + ((is_closed == 1) ? " disabled=\"disabled\" " : "") + " value=\"" +resData['data'][i]['id']+ "\" name=\"wikis[]\"/></td>";
						oneRow += "</tr>";
						_tmp += oneRow;
					}
				}
				_tmp += "</table><br />";
				records.innerHTML = _tmp + pager + "</div>";
				_addEvents(order, desc);
				if (typeof TieDivLibrary != "undefined" ) {
					TieDivLibrary.calculate();
				};
			}
		},
		failure: function( oResponse )
		{
			var records = YD.get('awc-metrics-result');
			div_details.innerHTML = "";
			if (!resData) {
				records.innerHTML = "<?=wfMsg('awc-metrics-not-found')?>";
			}
			if (typeof TieDivLibrary != "undefined" ) {
				TieDivLibrary.calculate();
			}; 
		}
	};

	var params = "&awc-created=" + created.value;
	params += "&awc-from=" + between_f.value;
	params += "&awc-to=" + between_to.value;
	params += "&awc-language=" + language.value;
	params += "&awc-domain=" + domain.value;
	params += "&awc-title=" + title.value;
	params += "&awc-founder=" + user.value;
	params += "&awc-founderEmail=" + email.value;
	params += "&awc-limit=" + limit;
	params += "&awc-offset=" + offset;
	params += "&awc-order=" + ord;
	params += "&awc-desc=" + desc;
	params += "&awc-closed=" + ((closed.checked) ? 1 : 0);
	params += "&awc-redir=" + ((redirected.checked) ? 1 : 0);

	//---
	div_details.innerHTML="<img src=\"<?=$wgExtensionsPath?>/wikia/WikiFactory/Metrics/images/ajax-loader-s.gif\" />";
	//---
	var baseurl = wgScript + "?action=ajax&rs=axAWCMetrics" + params;
	YAHOO.util.Connect.asyncRequest( "GET", baseurl, AWCMetricsDetailsCallback);
}

function __parseResponse(text) {
	var resData = text;
	if (YAHOO.Tools) {
		resData = YAHOO.Tools.JSONParse(text);
	} else if ((YAHOO.lang) && (YAHOO.lang.JSON)) {
		resData = YAHOO.lang.JSON.parse(text);
	} else {
		resData = eval('(' + text + ')');
	}
	
	return resData;
}

__ShowStats = function(e, args) {
	var _id = this.id;
	var _desc = args[0];
	var _order = "created";
	if (_id.indexOf('TablePager_', 0) !== -1) {
		_order = _id.replace('TablePager_', '');
	} 
	var select_pages = YD.get( 'wcAWCMetricsSelect' );
	var cnt = (select_pages) ? select_pages.value : <?=CreateWikiMetrics::LIMIT?>;
	wkAWCMetricsDetails(cnt, 0, _order, _desc);
};

__ShowCategories = function(e, args) {
	var daily = (args[0]) ? args[0] : 0;
	var div_details = YD.get( "awc-metrics-result" );
	var records = YD.get( "awc-metrics-list" );

	//----
	var f 			= YD.get( "awc-metrics-form" );
	var created 	= YD.get( "awc-metrics-created" );
	var language	= YD.get( "awc-metrics-language" );
	var between_f 	= YD.get( "awc-metrics-between-from" );
	var between_to  = YD.get( "awc-metrics-between-to" );
	//----
	var domain 		= YD.get( "awc-metrics-domains" );
	var title		= YD.get( "awc-metrics-title" );
	var user 		= YD.get( "awc-metrics-user" );
	var emailFnder	= YD.get( "awc-metrics-email" );

	var closed 		= YD.get( "awc-metrics-closed" );
	var redirected 	= YD.get( "awc-metrics-redirected" );

	var foundText 	= "<?=wfMsg('awc-metrics-wikis-found', "CNT")?>";

	AWCMetricsCategoriesCallback = {
		success: function( oResponse )
		{
			var resData = __parseResponse(oResponse.responseText);
			//---
			div_details.innerHTML = "";
			if ( (!resData) || (resData['nbr_records'] == 0) ) {
				tmp  = "<br />";
				tmp += "<div class=\"awc-metrics-msg\"><?=wfMsg('awc-metrics-not-found')?></div>";
				tmp += "<br />";
				records.innerHTML = tmp;
			} else { 
				records.innerHTML = "";
				cats = resData['cats'];
				data = resData['data'];
				//
				div_details.innerHTML = foundText.replace("CNT", resData['nbr_records']);
				//
				var _tmp = "<div style=\"clear:both\">";
 				_tmp += "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" valign=\"top\" class=\"TablePager\" style=\"text-align:center\">";
 				
 				// first column (month)
				var oneRow = "<th>&nbsp;</th>";

				// columns (categories)
				if ( cats ) {
					for (i in cats) {
						oneRow += "<th>" + cats[i] + "</th>";
					}
				}
				
				if (daily) {
					oneRow += "<th><?=wfMsg('awc-metrics-sum-day')?></th>";
				} else {
					oneRow += "<th><?=wfMsg('awc-metrics-sum-month')?></th>";
				}
				_tmp += "<tr>" + oneRow + "</tr>";
				// end of header

				// data
 				if ( data ) {
					for (month in data) {
						oneRow = "<tr>";
						oneRow += "<th>" + month + "</th>";
						var rowCnt = 0;
						if ( cats ) {
							for (i in cats) {
								var cnt = 0; 
								if ( data[month][i] ) {
									cnt = parseInt(data[month][i]['count']);
								}
								oneRow += "<td>" + cnt + "</td>";
								rowCnt += cnt;
							}
						}
						oneRow += "<th>" + rowCnt + "</th>";
						oneRow += "</tr>";
						_tmp += oneRow;
					}
				}

				_tmp += "</table><br />";
				records.innerHTML = _tmp + "</div>";

				if (typeof TieDivLibrary != "undefined" ) {
					TieDivLibrary.calculate();
				};
			}
		},
		failure: function( oResponse )
		{
			var records = YD.get('awc-metrics-list');
			div_details.innerHTML = "";
			if (!resData) {
				records.innerHTML = "<?=wfMsg('awc-metrics-not-found')?>";
			}
			if (typeof TieDivLibrary != "undefined" ) {
				TieDivLibrary.calculate();
			}; 
		}
	};

	var params = "&awc-created=" + created.value;
	params += "&awc-from=" + between_f.value;
	params += "&awc-to=" + between_to.value;
	params += "&awc-language=" + language.value;
	params += "&awc-domain=" + domain.value;
	params += "&awc-title=" + title.value;
	params += "&awc-founder=" + user.value;
	params += "&awc-founderEmail=" + emailFnder.value;
	params += "&awc-closed=" + ((closed.checked) ? 1 : 0);
	params += "&awc-redir=" + ((redirected.checked) ? 1 : 0);
	params += "&awc-daily=" + daily;
	//---
	div_details.innerHTML="<img src=\"<?=$wgExtensionsPath?>/wikia/WikiFactory/Metrics/images/ajax-loader-s.gif\" />";
	//---
	var baseurl = wgScript + "?action=ajax&rs=axAWCMetricsCategory" + params;
	YAHOO.util.Connect.asyncRequest( "GET", baseurl, AWCMetricsCategoriesCallback);
};

function _addEvents(f, desc) {
	YAHOO.util.Event.addListener("TablePager_db", "click", __ShowStats, [(f == 'db')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_title", "click", __ShowStats, [(f == 'title')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_lang", "click", __ShowStats, [(f == 'lang')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_created", "click", __ShowStats, [(f == 'created')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_founderName", "click", __ShowStats, [(f == 'founderName')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_founderEmail", "click", __ShowStats, [(f == 'founderEmail')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_wikians", "click", __ShowStats, [(f == 'wikians')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_articles", "click", __ShowStats, [(f == 'articles')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_articles_per_day", "click", __ShowStats, [(f == 'articles_per_day')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_mean_nbr_revision", "click", __ShowStats, [(f == 'mean_nbr_revision')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_mean_size", "click", __ShowStats, [(f == 'mean_size')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_edits", "click", __ShowStats, [(f == 'edits')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_db_size", "click", __ShowStats, [(f == 'db_size')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_images", "click", __ShowStats, [(f == 'images')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_users_reg", "click", __ShowStats, [(f == 'users_reg')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_users_edits", "click", __ShowStats, [(f == 'users_edits')?desc*-1:desc]);
	YAHOO.util.Event.addListener("TablePager_pageviews", "click", __ShowStats, [(f == 'pageviews')?desc*-1:desc]);
}

YAHOO.util.Event.onDOMReady(function () {
	var desc = 1;
	wkAWCMetricsDetails(<?=CreateWikiMetrics::LIMIT?>, 0, 'created', desc );
	YE.addListener("awc-metrics-submit", "click", __ShowStats, [desc] );
	YE.addListener("awc-metrics-hubs", "click", __ShowCategories, [0] );
	YE.addListener("awc-metrics-news-day", "click", __ShowCategories, [1] );
});
/*]]>*/
</script>
<!-- e:<?= __FILE__ ?> -->
