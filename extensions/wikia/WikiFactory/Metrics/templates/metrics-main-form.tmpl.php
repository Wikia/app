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
#LEFT_SPOTLIGHT_1_load {display: none !important; }
.TablePager th { font-size:91%; }
.TablePager td { padding:1px; }
.TablePager th a {font-weight:normal;}
.red_button {
	background-color: #900;
	background-image: -moz-linear-gradient(top, #c00 20%, #670000 70%);
	background-image: -webkit-gradient(linear, 0% 20%, 0% 70%, from(#c00), to(#670000));
	border-color: #ff0000;
	color: #FFF;
	-moz-box-shadow: 0 0 0 1px #800000;
	-webkit-box-shadow: 0 1px 0 #800000, 0 -1px 0 #800000, 1px 0 0 #800000, -1px 0 0 #800000;
}
</style>
<p class='error'><?=$error?></p>
<div>
<form method="post" action="<?=$action?>" id="awc-metrics-opt-form">
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
			<? $selected = ""; $selected = $obj->setDefaultOption($params, 'created', $mDefPeriod, $value); ?> 
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
<?php 					$selected = $obj->setDefaultOption($params, 'lang', '', $sLang); ?> 
						<option <?=$selected?> value="<?=$sLang?>"><?=$sLang?>: <?=$aLanguages[$sLang]?></option>
<?php 				endforeach ?>
					</optgroup>
<?php 			endif ?>
					<optgroup label="<?= wfMsg('autocreatewiki-language-all') ?>">
<?php 			if (!empty($aLanguages) && is_array($aLanguages)) : ?>
<?php				foreach ($aLanguages as $sLang => $sLangName) : ?>
<?php 					$selected = $obj->setDefaultOption($params, 'lang', '', $sLang); ?> 
						<option <?= $selected ?> value="<?=$sLang?>"><?=$sLang?>: <?=$sLangName?></option>
<?php 				endforeach ?>
					</optgroup>
<?php 			endif ?>
					</select>
				</span>
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-category')?></span>
				<span style="vertical-align:middle">
					<select name="awc-metrics-category-hub" id="awc-metrics-category-hub"><option value=""> </option>
			<? foreach ($aCategories as $id => $catName) : ?>
<?php 				$selected = $obj->setDefaultOption($params, 'cat', '', $id); ?> 
					<option <?= $selected ?> value="<?=$id?>"><?=$catName['name']?></option>
			<? endforeach ?>
					</select>
				</span>
			</td></tr>
		</table>
		<table width="100%" style="text-align:left;">
			<tr><td valign="middle" class="awc-metrics-row">
				<span style="vertical-align:middle">
					<?= wfMsg('awc-metrics-created-between', 
						'<input name="awc-metrics-between-from" id="awc-metrics-between-from" size="20" value="'.@$params['from'].'" />', 
						'<input name="awc-metrics-between-to" id="awc-metrics-between-to" size="20" value="'.@$params['to'].'" />'
					) ?>
				</span>
			</td></tr>
		</table>
		<table width="100%" style="text-align:left;">
			<tr><td valign="middle" class="awc-metrics-row">
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-by-dbname')?></span>
				<span style="vertical-align:middle"><input name="awc-metrics-dbname" id="awc-metrics-dbname" size="10" value="<?=@$params['dbname']?>" /></span>
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-by-title')?></span>
				<span style="vertical-align:middle"><input name="awc-metrics-title" id="awc-metrics-title" size="10" value="<?=@$params['stitle']?>" /></span>
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-by-domains')?></span>
				(<input name="awc-metrics-domains-exact" id="awc-metrics-domains-exact" <?=(@$params['exact']==1)?'checked="checked"':''?> type="checkbox" /><?=wfMsg('awc-metrics-exact-match')?>)
				<span style="vertical-align:middle"><input name="awc-metrics-domains" id="awc-metrics-domains" size="10" value="<?=@$params['domain']?>" /></span>
			</td></tr>
			<tr><td valign="middle" class="awc-metrics-row">
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-by-user')?></span>
				<span style="vertical-align:middle"><input name="awc-metrics-user" id="awc-metrics-user" size="15" value="<?=@$params['founder']?>" /></span>
				<span style="vertical-align:middle"><?=wfMsg('awc-metrics-by-email')?></span>
				<span style="vertical-align:middle"><input name="awc-metrics-email" id="awc-metrics-email" size="40" value="<?=@$params['email']?>" /></span>
			</td></tr>
<?
$months = '<select name="awc-nbr-edits-days" id="awc-nbr-edits-days">';
$months .= '<option value="1">'.wfMsg('awc-metrics-this-month').'</option>';
for ($i = 2; $i <= 12; $i++ ) {
	$selected = $obj->setDefaultOption($params, 'etime', '', $i); 
	$months .= '<option '.$selected.' value="'.$i.'">'.wfMsgExt('awc-metrics-last-month', 'parsemag', $i).'</option>';
}
$months .= '</select>';

$days = '<select name="awc-nbr-pageviews-days" id="awc-nbr-pageviews-days">';
foreach ( array(30, 60, 90, 120, 180, 365) as $id ) {
	$selected = $obj->setDefaultOption($params, 'ptime', 90, $id); 
	$days .= '<option value="'.$id.'" '.$selected.'>'.$id.'</option>';
}
$days .= '</select>';
?>			
			<tr><td valign="middle" class="awc-metrics-row">
				<span style="vertical-align:middle"><?=wfMsgExt('awc-metrics-fewer-than', 'parsemag', '<input name="awc-nbr-articles" id="awc-nbr-articles" size="2" value="'.@$params['articles'].'" />')?></span>
				<span style="vertical-align:middle"><?=wfMsgExt('awc-metrics-edits-label', 'parsemag', '<input name="awc-nbr-edits" id="awc-nbr-edits" size="2" value="'.@$params['edits'].'" />', $months)?></span>
				<span style="vertical-align:middle"><?=wfMsgExt('awc-metrics-pageviews-label', 'parsemag', '<input name="awc-nbr-pageviews" id="awc-nbr-pageviews" size="2" value="'.@$params['pageviews'].'" />', $days)?></span>
			</td></tr>
		</table>
		<table width="100%" style="text-align:left;">
			<tr>
				<td valign="middle" class="awc-metrics-row">
					<input name="awc-metrics-active" id="awc-metrics-active" type="checkbox" checked="checked" /> <?=wfMsg('awc-metrics-active')?>
					<input name="awc-metrics-closed" id="awc-metrics-closed" type="checkbox" /> <?=wfMsg('awc-metrics-closed')?>
				</td>
				<td valign="middle" class="awc-metrics-row" align="right">
					<input type="submit" value="<?=wfMsg('search')?>" id="awc-metrics-submit" onclick="return false;" />
					<input type="button" value="<?=wfMsg('awc-metrics-hubs')?>" id="awc-metrics-hubs" />
					<input type="button" value="<?=wfMsg('awc-metrics-news-day')?>" id="awc-metrics-news-day" />
				</td>
			</tr>
		</table>
	</fieldset>
	</div>
</form> 
<!-- end of options -->
<form method="post" action="<?=$action?>" id="awc-metrics-form">
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

	limit = typeof(limit) != 'undefined' ?limit : <?=WikiMetrics::LIMIT?>;
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
	var results = new Array(25, 50, 100, 250, 500, 1000);
	for (k = 0; k < results.length; k++) {
		selected = (limit == results[k]) ? "selected" : "";
		nbr_result += "<option " + selected + " value=\""+results[k]+"\">" + results[k] + "</option>";
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

function __closeAllListed () {
	var div_details = YD.get( "awc-metrics-result" );
	var foundText 	= "<?=wfMsg('awc-metrics-wikis-found', "CNT")?>";

	AWCMetricsDetailsCallback = {
		success: function( oResponse ) {
			var resData = __parseResponse(oResponse.responseText);
			if ( (!resData) || (resData['nbr_records'] == 0) ) {
				alert("<?=wfMsg('awc-metrics-not-found')?>");
				div_details.innerHTML = "";
			} else { 
				div_details.innerHTML = foundText.replace("CNT", resData['nbr_records']);
 				if (resData['data']) {
					var formWiki = YD.get("awc-metrics-form");
					var loop = 0;
 					for (i in resData['data']) {
 						var el = document.createElement("input");
 						el.setAttribute("type", "checkbox");
 						el.setAttribute("name", "wikis[]");
 						el.setAttribute("value", i);
 						el.setAttribute("checked", "checked");
 						formWiki.appendChild(el);
 						loop++;
					}
					formWiki.submit();
				}
			}
		},
		failure: function( oResponse ) {
			alert("<?=wfMsg('awc-metrics-not-found')?>");
			div_details.innerHTML = "";
		}
	};

	//---
	div_details.innerHTML="<img src=\"<?=$wgExtensionsPath?>/wikia/WikiFactory/Metrics/images/ajax-loader-s.gif\" />";
	//---
	var baseurl = wgScript + "?action=ajax&rs=axAWCMetricsAllWikis";
	YAHOO.util.Connect.asyncRequest( "GET", baseurl, AWCMetricsDetailsCallback);
	
	return false;
}

function wkAWCMetricsDetails(limit, offset, ord, desc) 
{
	limit = typeof(limit) != 'undefined' ?limit : <?=WikiMetrics::LIMIT?>;
	offset = typeof(offset) != 'undefined' ? offset : 0;

	var div_details = YD.get( "awc-metrics-result" );
	var f 			= YD.get( "awc-metrics-form" );
	//----
	var created 	= YD.get( "awc-metrics-created" );
	var language	= YD.get( "awc-metrics-language" );
	var category	= YD.get( "awc-metrics-category-hub" );
	var between_f 	= YD.get( "awc-metrics-between-from" );
	var between_to  = YD.get( "awc-metrics-between-to" );
	//----
	var dbname 		= YD.get( "awc-metrics-dbname" );
	var domain 		= YD.get( "awc-metrics-domains" );
	var exact_domain= YD.get( "awc-metrics-domains-exact" );
	var title		= YD.get( "awc-metrics-title" );
	var user 		= YD.get( "awc-metrics-user" );
	var email 		= YD.get( "awc-metrics-email" );

	var active 		= YD.get( "awc-metrics-active" );
	var closed 		= YD.get( "awc-metrics-closed" );

	var nbr_articles		= YD.get( "awc-nbr-articles" );
	var nbr_edits			= YD.get( "awc-nbr-edits" );
	var nbr_edits_days		= YD.get( "awc-nbr-edits-days" );
	var nbr_pageviews		= YD.get( "awc-nbr-pageviews" );
	var nbr_pageviews_days	= YD.get( "awc-nbr-pageviews-days" );
	
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
				buttons += "<input type=\"submit\" value=\"<?=wfMsg('awc-metrics-close-listed')?>\" name=\"submit0\" id=\"submit0\" class=\"red_button\" onclick=\"__closeAllListed(); return false;\" />";
				buttons += "<input type=\"submit\" value=\"<?=wfMsg('awc-metrics-close-checked')?>\" name=\"submit1\"/>";
				buttons += "</div>";
				
				pager = wfJSPager(resData['nbr_records'], wgScript + "?title=" + wgPageName + "/metrics", page, limit, 'wkAWCMetricsDetails', order, desc, buttons);
				//
				var _tmp = "<div style=\"clear:both\">";
				_tmp += pager;
 				_tmp += "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" valign=\"top\" class=\"TablePager\" style=\"text-align:center\">";
 				
 				// first column (#)
				var oneRow = "<tr><th rowspan=\"2\">#</th>";

				// column (TITLE)
				var _th = (order == 'title') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_title\" style=\"cursor:pointer;" + ((order == 'title') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " Wikia</a></th>";

				// column (DBNAME)
				var _th = (order == 'db') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_db\" style=\"cursor:pointer;" + ((order == 'db') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " DBName</a></th>";
				
				// column (LANG)
				_th = (order == 'lang') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_lang\" style=\"cursor:pointer;" + ((order == 'lang') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " Lang</a></th>";

				// column (CREATED)				
				_th = (order == 'created') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_created\" style=\"cursor:pointer;" + ((order == 'created') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " Created</a></th>";
				
				// column (FOUNDER)
				_th = (order == 'founderName') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				var _th2 = (order == 'founderEmail') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_founderName\" style=\"cursor:pointer;" + ((order == 'founderName') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " Founder</a>";
				oneRow += "<a id=\"TablePager_founderEmail\" style=\"cursor:pointer;" + ((order == 'founderEmail') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th2 + " Founder email</a></th>";

				// column (FOUNDER EMAIL)
				//_th = (order == 'founderEmail') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				//oneRow += "<th rowspan=\"2\"><a id=\"TablePager_founderEmail\" style=\"cursor:pointer;" + ((order == 'founderEmail') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " Founder email</a></th>";

				// columns (stats)
				oneRow += "<th colspan=\"10\" style=\"text-align:center\"><?=wfMsg('awc-metrics-statistics')?></th>";

				// column (pageviews)
				_th = (order == 'pageviews') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th rowspan=\"2\"><a id=\"TablePager_pageviews\" style=\"cursor:pointer;" + ((order == 'pageviews') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-pageviews')?></a></th>";
				
				// column (options)
				oneRow += "<th rowspan=\"2\" style=\"text-align:center\"><?=wfMsg('awc-metrics-close')?></th></tr>";

				_tmp += oneRow;
				
				///////////////////////////////
				// second row in table header 
				///////////////////////////////
				oneRow = "<tr>";

				// column (WIKIANS)
				_th = (order == 'wikians') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th><a id=\"TablePager_wikians\" style=\"cursor:pointer;" + ((order == 'wikians') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-wikians')?></a></th>";

				// column (ARTICLES)
				_th = (order == 'articles') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th><a id=\"TablePager_articles\" style=\"cursor:pointer;" + ((order == 'articles') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-articles')?></a></th>";

				// column (NEW_ARTICLES_PER_DAY)
				_th = (order == 'articles_per_day') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th><a id=\"TablePager_articles_per_day\" style=\"cursor:pointer;" + ((order == 'articles_per_day') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-articles-per-day')?></a></th>";

				// column (REVISIONS)
				_th = (order == 'mean_nbr_revision') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th><a id=\"TablePager_mean_nbr_revision\" style=\"cursor:pointer;" + ((order == 'mean_nbr_revision') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-revisions-per-page')?></a></th>";

				// column (MEAN SIZE)
				_th = (order == 'mean_size') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th><a id=\"TablePager_mean_size\" style=\"cursor:pointer;" + ((order == 'mean_size') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-article-avg-size')?></a></th>";

				// column (EDITS)
				_th = (order == 'edits') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th><a id=\"TablePager_edits\" style=\"cursor:pointer;" + ((order == 'edits') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-edits')?></a></th>";

				// column (DB_SIZE)
				_th = (order == 'db_size') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th><a id=\"TablePager_db_size\" style=\"cursor:pointer;" + ((order == 'db_size') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-db-size')?></a></th>";

				// column (images)
				_th = (order == 'images') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th><a id=\"TablePager_images\" style=\"cursor:pointer;" + ((order == 'images') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-images')?></a></th>";

				// column (users_reg)
				_th = (order == 'users_reg') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th><a id=\"TablePager_users_reg\" style=\"cursor:pointer;" + ((order == 'users_reg') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-all-users')?></a></th>";

				// column (users_edits)
				_th = (order == 'users_edits') ? ((desc == -1) ? "<strong style=\"font-size:146%\">&darr;</strong>" : "<strong style=\"font-size:146%\">&uarr;</strong>") : "";
				oneRow += "<th><a id=\"TablePager_users_edits\" style=\"cursor:pointer;" + ((order == 'users_edits') ? "color:#006400;font-weight:bold;" : "") + "\">" + _th + " <?=wfMsg('awc-metrics-all-users-edit-main-ns')?></a></th>";

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
						if ( (resData['data'][i]['public'] == 0) || (resData['data'][i]['public'] == -1) ) {
							// closed or removed
							cssClass = " style=\"color:#EF0036;\" ";
							is_closed = 1;
						} else if ( (resData['data'][i]['public'] == 2) ) {
							// redirected 
							cssClass = " style=\"color:#007F11;\" ";
						}
						oneRow = "<tr style=\"font-size:90%;\"><td>" + loop  + ".</td>";
						oneRow += "<td " + cssClass + ">";
						oneRow += "<a href=\"" + resData['data'][i]['url'] + "\" target=\"new\">" +resData['data'][i]['title']+ "</a><br />";
						oneRow += "(<a href=\"http://community.wikia.com/wiki/Special:WikiFactory/" + resData['data'][i]['id'] + "\" target=\"new\">Wiki Factory</a>)";
						oneRow += "</td>";
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
			}
		},
		failure: function( oResponse )
		{
			var records = YD.get('awc-metrics-result');
			div_details.innerHTML = "";
			if (!resData) {
				records.innerHTML = "<?=wfMsg('awc-metrics-not-found')?>";
			}
		}
	};

	var params = "&awc-created=" + created.value;
	params += "&awc-from=" + between_f.value;
	params += "&awc-to=" + between_to.value;
	params += "&awc-language=" + language.value;
	params += "&awc-hub=" + category.value;
	params += "&awc-dbname=" + dbname.value;
	params += "&awc-domain=" + domain.value;
	params += "&awc-exactDomain=" + ((exact_domain.checked) ? 1 : 0);
	params += "&awc-title=" + title.value;
	params += "&awc-founder=" + user.value;
	params += "&awc-founderEmail=" + email.value;
	params += "&awc-limit=" + limit;
	params += "&awc-offset=" + offset;
	params += "&awc-order=" + ord;
	params += "&awc-desc=" + desc;
	params += "&awc-closed=" + ((closed.checked) ? 1 : 0);
	params += "&awc-active=" + ((active.checked) ? 1 : 0);
	params += "&awc-nbrArticles=" + nbr_articles.value;
	params += "&awc-nbrEdits=" + nbr_edits.value;
	params += "&awc-nbrEditsDays=" + nbr_edits_days.value;
	params += "&awc-nbrPageviews=" + nbr_pageviews.value;
	params += "&awc-nbrPageviewsDays=" + nbr_pageviews_days.value;

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
	var cnt = (select_pages) ? select_pages.value : <?=WikiMetrics::LIMIT?>;
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
	var category	= YD.get( "awc-metrics-category-hub" );
	var between_f 	= YD.get( "awc-metrics-between-from" );
	var between_to  = YD.get( "awc-metrics-between-to" );
	//----
	var dbname 		= YD.get( "awc-metrics-dbname" );
	var domain 		= YD.get( "awc-metrics-domains" );
	var exact_domain= YD.get( "awc-metrics-domains-exact" );
	var title		= YD.get( "awc-metrics-title" );
	var user 		= YD.get( "awc-metrics-user" );
	var emailFnder	= YD.get( "awc-metrics-email" );

	var active 		= YD.get( "awc-metrics-active" );
	var closed 		= YD.get( "awc-metrics-closed" );

	var nbr_articles		= YD.get( "awc-nbr-articles" );
	var nbr_edits			= YD.get( "awc-nbr-edits" );
	var nbr_edits_days		= YD.get( "awc-nbr-edits-days" );
	var nbr_pageviews		= YD.get( "awc-nbr-pageviews" );
	var nbr_pageviews_days	= YD.get( "awc-nbr-pageviews-days" );

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
				var maxDate = new Array();
				var maxHub = new Array();
				var prevMonth = new Array();
				var dataRows = "";
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
								var incArr = "&nbsp;";
								if ( typeof(prevMonth[i]) !='undefined' && prevMonth[i] !== null ) {
									var diff = cnt - parseInt(prevMonth[i]);
									if (diff > 0) {
										incArr = "<strong style=\"color:#0BBF13;\">&uarr;</strong>"; 
									} else if (diff < 0) {
										incArr = "<strong style=\"color:#FF000A;\">&darr;</strong>";
									}
								} 
								prevMonth[i] = cnt;
								//---
								oneRow += "<td id=\""+month+"_"+i+"\">" + cnt + "&nbsp;" + incArr + "</td>";
								rowCnt += cnt;
								//---
								if (!maxDate[month]) {
									maxDate[month] = 0;
								}
								if (maxDate[month] < cnt) {
									maxHub[month] = i; 
									maxDate[month] = cnt;
								} 
							}
						}
						oneRow += "<th>" + rowCnt + "</th>";
						oneRow += "</tr>";
						
						dataRows = oneRow + dataRows;
					}
				}
				_tmp += dataRows;

				_tmp += "</table><br />";
				records.innerHTML = _tmp + "</div>";

				if (maxHub) {
					for (month in maxHub) {
						var box = YD.get(month + "_" + maxHub[month]);
						if (box) {
							box.style.backgroundColor = "#EEEEFF";
							box.style.fontWeight = "bold";
						}
					}
				}
			}
		},
		failure: function( oResponse )
		{
			var records = YD.get('awc-metrics-list');
			div_details.innerHTML = "";
			if (!resData) {
				records.innerHTML = "<?=wfMsg('awc-metrics-not-found')?>";
			}
		}
	};

	var params = "&awc-created=" + created.value;
	params += "&awc-from=" + between_f.value;
	params += "&awc-to=" + between_to.value;
	params += "&awc-language=" + language.value;
	params += "&awc-hub=" + category.value;
	params += "&awc-dbname=" + dbname.value;
	params += "&awc-domain=" + domain.value;
	params += "&awc-exactDomain=" + ((exact_domain.checked) ? 1 : 0);
	params += "&awc-title=" + title.value;
	params += "&awc-founder=" + user.value;
	params += "&awc-founderEmail=" + emailFnder.value;
	params += "&awc-closed=" + ((closed.checked) ? 1 : 0);
	params += "&awc-active=" + ((active.checked) ? 1 : 0);
	params += "&awc-daily=" + daily;
	params += "&awc-nbrArticles=" + nbr_articles.value;
	params += "&awc-nbrEdits=" + nbr_edits.value;
	params += "&awc-nbrEditsDays=" + nbr_edits_days.value;
	params += "&awc-nbrPageviews=" + nbr_pageviews.value;
	params += "&awc-nbrPageviewsDays=" + nbr_pageviews_days.value;
	
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
	wkAWCMetricsDetails(<?=WikiMetrics::LIMIT?>, 0, 'created', desc );
	YE.addListener("awc-metrics-submit", "click", __ShowStats, [desc] );
	YE.addListener("awc-metrics-opt-form", "submit", __ShowStats, [desc] );
	YE.addListener("awc-metrics-hubs", "click", __ShowCategories, [0] );
	YE.addListener("awc-metrics-news-day", "click", __ShowCategories, [1] );
});
/*]]>*/
</script>
<!-- e:<?= __FILE__ ?> -->
