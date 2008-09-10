<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
// Find the search box in the DOM
var selectWSWikisList = new Array();
var selectWSWikisDialogList = new Array();
var sortMethod = 0;
var sortPanelMethod = 0;
var countWikis = 0;
<?
$xlsMenuHeader = addslashes(wfMsg("wikiastats_select_statistics"));
#---
$loop = 0;
$wikia_rows = "<div style=\"width:240px;font-weight:bold;font-size:9pt;\">".wfMsg('wikiastats_search_text')." <input type=\"text\" name=\"ws-city-name\" autocomplete=\"off\" id=\"ws-city-name\" class=\"ws-input\" style=\"width:auto\"></div>
<div id=\"ws-select-cities\">
<select name=\"ws-city-list\" width=\"250\" id=\"ws-city-list\" class=\"ws-input\" size=\"14\" onChange=\"XLSShowMenu(this.value); WikiaStatsGetInfo('wk-stats-info-panel', this.value);\">";
$y = 0;
foreach ($cityStats as $id => $cityId) {
	#if ($loop >= 100) break;
	if (!empty($cityList[$cityId])) { 
		$loop++;
		$selected = ($wgCityId == $cityId) ? "selected" : "";
		$wikia_rows .= "<option value=\"{$cityId}\" $selected>".( ($cityId != 0) ? ucfirst($cityList[$cityId]['urlshort']): wfMsg('wikiastats_trend_all_wikia_text')) ."</option>";
	}
}
$wikia_rows .= "</select></div>";
?>
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var xlsMenuHeader = "<?=addslashes(wfMsg("wikiastats_select_wikia_statistics"))?>";
var wk_stats_city_id = 0;
var background_color = "";
var compare_stats = 0;

YAHOO.namespace("Wikia.Statistics");
(function() { 
    YAHOO.Wikia.Statistics = 
    {
	    init: function() {
            YD.get("compareStatsDialog").style.display = "block";
            if (!YAHOO.Wikia.Statistics.compareStatsDialog) { 
                YAHOO.Wikia.Statistics.handleSubmit = function() {
                    XLSCancel(); 
                    YD.get("compareStatsDialog_c").style.display = "none";
                    this.cancel(); 
                    var checklist = document.XLSCompareForm.wscid;
                    var is_checked = 0; var checked_list = "";
                    for (i = 0; i < checklist.length; i++) { if (checklist[i].checked) { checked_list += checklist[i].value + ";"; is_checked++; } }
                    if (is_checked > <?= ($MAX_NBR + 1)?>) { alert(YAHOO.tools.printf("<?=addslashes(wfMsg('wikiastats_xls_generate_info'))?>", (<?=$MAX_NBR + 1?>))); return false; }
                    if (document.getElementById('showXLS').value == 1) {
                    	if (!document.getElementById('showStatsNewWindowBox').checked) { StatsPageLoaderShow(0); }
                    	ShowCompareStats(compare_stats, checked_list, (document.getElementById('showStatsNewWindowBox').checked));
					} else {
						StatsPageLoaderShow(0);
                    	XLSGenerate(compare_stats, checked_list, '', '');
					}
                };
                YAHOO.Wikia.Statistics.handleCancel = function() { 
                    XLSCancel(); 
                    YD.get("compareStatsDialog_c").style.display = "none";
                    StatsPageLoaderHide(0);
                    this.cancel(); 
                };
                // Instantiate the Dialog
                YAHOO.Wikia.Statistics.compareStatsDialog = new YAHOO.widget.Dialog("compareStatsDialog", {
                    width:"500px",height:"530px", fixedcenter:true,visible:false,draggable:true,zindex:9000,constraintoviewport:true,close:false,
                    buttons : [ { text:"<?=wfMsg('wikiastats_xls_generate')?>", handler:YAHOO.Wikia.Statistics.handleSubmit, isDefault:true },
                                { text:"<?=wfMsg('wikiastats_panel_close_btn')?>", handler:YAHOO.Wikia.Statistics.handleCancel } ]
                });
                // Render the Dialog
                YAHOO.Wikia.Statistics.compareStatsDialog.render(document.body);
				YD.get("compareStatsDialog_c").style.display = "none";
            }
            XLSShowMenu('<?=intval($wgCityId)?>');
            WikiaStatsGetInfo('wk-stats-info-panel', '<?=intval($wgCityId)?>');
        }
    }    

	YAHOO.Wikia.Statistics.WSShowStatsTab = function(e) {
		if (this.id == "ws-wikia-compare-id") {
			setActiveCompareTab();
		} else {
			setActiveSelectTab();
		} 
	}
	YE.addListener("ws-wikia-select-id", "click", YAHOO.Wikia.Statistics.WSShowStatsTab);
	YE.addListener("ws-wikia-compare-id", "click", YAHOO.Wikia.Statistics.WSShowStatsTab);
    YE.onDOMReady(YAHOO.Wikia.Statistics.init, YAHOO.Wikia.Statistics, true); 
}
)();

function setActiveSelectTab() {
	var tab_active = document.getElementById("ws_main_wikia_select_td");
	var tab_hid = document.getElementById("ws_main_wikia_compare_td");
	tab_active.style.display = "block";
	tab_hid.style.display = "none";
	document.getElementById("ws-wikia-select-id").className="selected";
	document.getElementById("ws-wikia-compare-id").className="";
}

function setActiveCompareTab() {
	var tab_active = document.getElementById("ws_main_wikia_compare_td");
	var tab_hid = document.getElementById("ws_main_wikia_select_td");
	tab_active.style.display = "block";
	tab_hid.style.display = "none";
	tab_active.class="";
	tab_hid.class="selected";
	document.getElementById("ws-wikia-compare-id").className="selected";
	document.getElementById("ws-wikia-select-id").className="";
}

function WSCountCheckboxes(checked, reset) {
	var nbrToCheck = <?=$MAX_NBR?>;
	if (reset != 1) {
		countWikis = (checked) ? countWikis-1 : countWikis+1;
	} else {
		countWikis = 0;
	}
	var _tmp = parseInt(nbrToCheck) + parseInt(countWikis);
	var txt = new String("<?=wfMsg('wikiastats_show_nbr_wikis_check', '<strong style=\"color:#8B0000\">_NBR_</strong>')?>");
	txt = txt.replace("_NBR_", _tmp);
	YD.get('ws-wikis-check').innerHTML = txt;
}

function sortWikiaList(method) {
	var sort_div = document.getElementById( "ws-sort-link" );
	var text = "<?=addslashes(wfMsg('wikiastats_sort_list_alphabet'))?>";
	var sort = (method == 1) ? 0 : 1;
	if (method == 1) {
		text = "<?=addslashes(wfMsg('wikiastats_sort_list_size'))?>";
	}
	sortMethod = method;
	sort_div.innerHTML = '<a href="javascript:void(0);" onClick="sortWikiaList(\''+ sort +'\')">' + text + '</a>';
	value = document.getElementById('ws-city-name').value;
	showWSSearchResult(value);
}

function sortWikiaPanelList(method) {
	YD.get("ws-div-scroll").innerHTML = "<div style=\"height:auto\"><center><img src=\"/extensions/wikia/WikiaStats/images/ajax_indicators.gif\" border=\"0\"></center></div>";
	var sort_div = document.getElementById( "ws-sort-panel" );
	var text = "<?=addslashes(wfMsg('wikiastats_sort_list_alphabet'))?>";
	var sort = (method == 1) ? 0 : 1;
	if (method == 1) {
		text = "<?=addslashes(wfMsg('wikiastats_sort_list_size'))?>";
	}
	sortPanelMethod = method;
	sort_div.innerHTML = '<a href="javascript:void(0);" onClick="sortWikiaPanelList(\''+ sort +'\')">' + text + '</a>';
	WikiaStatsPanelSortList();
}

YE.addListener("ws-check-cities", "click", XLSClearCitiesList);
pageLoaderInit('<?=addslashes(wfMsg('wikiastats_generate_stats_msg'))?>', '<?=addslashes(wfMsg('wikiastats_xls_cancel'))?>');

/*]]>*/
</script>
<!-- Statistics dialog -->
<div id="compareStatsDialog">
<div class="hd" id="ws-stats-dialog-hd"><?=wfMsg('wikiastats_comparision')?></div>
<div class="bd">
	<form name="XLSCompareForm" action="/" method="post">
	<input type="hidden" name="showXLS" id="showXLS" value="0">
	<div id="wk-select-cities-panel">
		<fieldset class="ws-frame-border">
		<legend class="normal"><?= wfMsg('wikiastats_mainstats_info') ?></legend>
			<div style="float:left;padding:3px 0px 1px 0px;" id="ws-wikis-check"><?=wfMsg('wikiastats_show_nbr_wikis_check', "<strong style=\"color:#8B0000\">".($MAX_NBR)."</strong>")?></div>
			<div style="float:right;padding:3px 0px 1px 0px;clear:right;" id="ws-sort-panel"><a href="javascript:void(0);" onClick="sortWikiaPanelList(1)"><?=addslashes(wfMsg('wikiastats_sort_list_alphabet'))?></a></div>
			<div class="ws-div-scroll" id="ws-div-scroll"></div>
			<div class="clear"></div>
			<div class="ws-btn-panel">
				<span class="button-group">
					<input type="button" name="ws-check-cities" id="ws-check-cities" style="font-size:8pt;" value="<?=wfMsg('wikiastats_xls_uncheck_list')?>">
					<?=wfMsg('wikiastats_xls_press_uncheck')?>
				</span>
			</div>
		</fieldset>
	</div>
	</form>
</div>
<div class="bd" id="showStatsNewWindow" style="padding:5px 0px 0px 0px;float:left;display:table !important;">
<table width="100%" class="100%">
<tr>
	<td style="padding:2px;"><input type="checkbox" checked id="showStatsNewWindowBox"></td>
	<td style="padding:2px"><?=wfMsg('wikiastats_show_new_window')?></td>
</tr>
</table>
</div>
</div>
<!-- end of statistics dialog -->
<div id="ws-xls-div"></div>
<div id="ws-main-table" style="height:100%">
<!-- WIKI's INFORMATION -->
<div id="page_bar" class="reset color1 clearfix">
<ul id="page_tabs" style="float:left">
	<li class="selected" id="ws-wikia-select-id"><?=wfMsg('wikiastats_pagetitle')?></li>
	<li class="" id="ws-wikia-compare-id"><?=wfMsg('wikiastats_comparision')?></li>
</ul>
</div>
<br />
<table style="width:auto; font-family:Trebuchet MS,Arial,Helvetica,sans-serif;" height="100%" valign="top" border="0">
<!-- main tables -->
 <tr>
    <td align="left" valign="top" id="tdMenu" valign="top" height="100%">
    	<div id="ws_main_wikia_select_td">
			<fieldset style="margin:2px 0pt;height:250px;width:550px;">
				<div style="width:250px;padding:0px 1px;float:left;clear:left;margin-top:5pt;margin-bottom:2pt;margin-left:auto;margin-right:auto;">
				  <?=$wikia_rows?>
				  <div id="ws-sort-link" style="float:right; padding:0px 10px;"><a href="javascript:void(0);" onClick="sortWikiaList(1)"><?=wfMsg('wikiastats_sort_list_alphabet')?></a></div>
				</div>  
				<div class="wk-stats-main-panel" id="wk-stats-info-panel" class="ws-input" style="margin-top:6pt;margin-bottom:2pt;float:left;clear:right;width:271px;height:150px;"></div>
				<div class="wk-select-class-main">
					<span style="padding-left: 10px;"><input type="button" class="input_button" id="ws-show-charts" value="<?= wfMsg("wikiastats_showcharts") ?>" name="ws-show-charts" onClick="redirectToStats(1)"></span>
					<span style="padding-left: 10px;"><input type="button" class="input_button" id="ws-show-stats" name="ws-show-stats" value="<?= wfMsg("wikiastats_showstats_btn") ?>" onClick="redirectToStats(0)"></span>
					<div style="padding:15px 21px 0px 120px;"><a href="javascript:void(0);" onClick="redirectTooldStats();"><?=wfMsg('wikiastats_see_old_statistics_page')?></a></div>
				</div>
			</fieldset>
			<div style="float:left; width:100%; padding: 0px 1px;clear:both;" id="ws-main-xls-stats">
			<fieldset style="margin:0px">
				<legend><?=wfMsg('wikiastats_generate_XLS_file_title')?></legend>
				<div class="wk-stats-main-panel" id="wk-stats-main-panel">
					<ul><li id="wk-xls-pagetitle"><a href="javascript:void(0);" onClick="XLSStats('1');"><?=wfMsg("wikiastats_pagetitle")?></a></li></ul>
				</div>
				<div class="wk-stats-main-panel" id="wk-stats-panel">
					<ul>
					<li><a href="javascript:void(0);" onClick="XLSStats('2');"><?=wfMsg("wikiastats_distrib_article")?></a></li>
					<li><a href="javascript:void(0);" onClick="XLSStats('3');"><?=wfMsg("wikiastats_active_absent_wikians")?></a></li>
					<li><a href="javascript:void(0);" onClick="XLSStats('4');"><?=wfMsg("wikiastats_anon_wikians")?></a></li>
					<li><a href="javascript:void(0);" onClick="XLSStats('5');"><?=wfMsg("wikiastats_article_one_link")?></a></li>
					<li><a href="javascript:void(0);" onClick="XLSStats('6');"><?=wfMsg("wikiastats_namespace_records")?></a></li>
					<li><a href="javascript:void(0);" onClick="XLSStats('7');"><?=wfMsg("wikiastats_page_edits")?></a></li>
					</ul>
				</div>
			</fieldset>
			</div>
    	</div>
    </td>
    <td nowrap align="left" valign="top">&nbsp;</td>
    <td nowrap align="left" valign="top">
       <table style="width: auto;line-height:11pt" cellpadding="0" cellspacing="0" id="ws_main_wikia_compare_td">
<? $k = 7; for ($i=1; $i<=27; $i++) { $l = $k + $i; if ( empty($userIsSpecial) && (is_array($wgStatsExcludedNonSpecialGroup)) && (in_array(($i-2), $wgStatsExcludedNonSpecialGroup) )) continue; ?>	
        <tr><td class="wstab"><?= wfMsg("wikiastats_comparisons_table_$i") ?></td>
        <td class="wstabopt"><a href="javascript:void(0);" onClick="showXLSCompareDialog('<?=$l?>', false);"><?= wfMsg('wikiastats_xls_files_stats') ?></a>&nbsp;-&nbsp;<a href="javascript:void(0);" onClick="showXLSCompareDialog('<?=$i?>', true);"><?= wfMsg('wikiastats_tables') ?></a></td></tr>
<? if ($i == 2) { ?>
        <tr><td class="wstabbot" style="line-height:7pt" colspan="2">&nbsp;</tr>
<? } } ?>	
       </table>
    </td>
 </tr>
</table>
</div>
<script type="text/javascript">
/*<![CDATA[*/
var wsElement = document.getElementById('ws-city-name');
if (wsElement) { wsElement.onkeyup = function(){ WikiaStatsGetWikis(this, this.value); }; }
if (document.getElementById("ws_main_wikia_select_td") && document.getElementById("ws_main_wikia_compare_td")) {
	setActiveSelectTab();
}
</script>
<!-- e:<?= __FILE__ ?> -->
