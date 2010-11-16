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
$wikia_rows = "<div id=\"ws-select-cities\">
<select name=\"ws-city-list\" width=\"200\" id=\"ws-city-list\" class=\"ws-input\" size=\"29\" onChange=\"XLSShowMenu(this.value); WikiaStatsGetInfo('wk-stats-info-panel', this.value);\">";
$y = 0;
foreach ($cityStats as $id => $cityId) {
	#if ($loop >= 100) break;
	if (!empty($cityList[$cityId])) {
		$loop++;
		$selected = ($wgCityId == $cityId) ? " selected=\"selected\" " : "";
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
            YAHOO.util.Dom.get("compareStatsDialog").style.display = "block";
            if (!YAHOO.Wikia.Statistics.compareStatsDialog) {
                YAHOO.Wikia.Statistics.handleSubmit = function() {
                    XLSCancel();
                    YAHOO.util.Dom.get("compareStatsDialog_c").style.display = "none";
                    this.cancel();
                    var checklist = document.XLSCompareForm.wscid;
                    var is_checked = 0; var checked_list = "";
                    for (i = 0; i < checklist.length; i++) { if (checklist[i].checked) { checked_list += checklist[i].value + ";"; is_checked++; } }
                    // FIXME: wikiastats_xls_generate_info requires plural support in JavaScipt.
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
                    YAHOO.util.Dom.get("compareStatsDialog_c").style.display = "none";
                    StatsPageLoaderHide(0);
                    this.cancel();
                };
                // Instantiate the Dialog
                YAHOO.Wikia.Statistics.compareStatsDialog = new YAHOO.widget.Dialog("compareStatsDialog", {
                    width:"500px",height:"570px", fixedcenter:true,visible:false,draggable:true,zindex:9000,constraintoviewport:true,close:false,
                    buttons : [ { text:"<?=wfMsg('wikiastats_xls_generate')?>", handler:YAHOO.Wikia.Statistics.handleSubmit, isDefault:true },
                                { text:"<?=wfMsg('wikiastats_panel_close_btn')?>", handler:YAHOO.Wikia.Statistics.handleCancel } ]
                });
                // Render the Dialog
                YAHOO.Wikia.Statistics.compareStatsDialog.render(document.body);
				YAHOO.util.Dom.get("compareStatsDialog_c").style.display = "none";
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
	YAHOO.util.Dom.get('ws-wikis-check').innerHTML = txt;
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
	YAHOO.util.Dom.get("ws-div-scroll").innerHTML = "<div style=\"height:auto\"><center><img src=\"http://images.wikia.com/common/skins/common/images/ajax.gif)\" border=\"0\"></center></div>";
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
	<input type="hidden" name="showXLS" id="showXLS" value="0" />
	<div id="wk-select-cities-panel">
		<fieldset class="ws-frame-border">
		<legend class="normal"><?= wfMsg('wikiastats_mainstats_info') ?></legend>
			<div style="float:left;padding:3px 0px 1px 0px;" id="ws-wikis-check"><?=wfMsg('wikiastats_show_nbr_wikis_check', "<strong style=\"color:#8B0000\">".($MAX_NBR)."</strong>")?></div>
			<div style="float:left;padding:3px 0px 1px 0px;clear:both;" id="ws-search-panel">
				<table><tr><td><?=wfMsg('wikiastats_search_text')?></td><td><input type="text" name="ws-search-input-panel" id="ws-search-input-panel" autocomplete="off" /></td>
				<td><div id="ws-search-input-panel-btn"></div></td>
				</tr></table>
			</div>
			<div style="float:right;padding:3px 0px 1px 0px;clear:right;" id="ws-sort-panel"><a href="javascript:void(0);" onClick="sortWikiaPanelList(1)"><?=addslashes(wfMsg('wikiastats_sort_list_alphabet'))?></a></div>
			<div class="ws-div-scroll" id="ws-div-scroll"></div>
			<div class="clear"></div>
			<div class="ws-btn-panel">
				<span class="button-group">
					<input type="button" name="ws-check-cities" id="ws-check-cities" style="font-size:8pt;" value="<?=wfMsg('wikiastats_xls_uncheck_list')?>" />
					<?=wfMsg('wikiastats_xls_press_uncheck')?>
				</span>
			</div>
		</fieldset>
	</div>
	</form>
</div>
<div class="bd" id="showStatsNewWindow" style="padding:5px 0px 0px 0px;float:left;display:table !important;width:250px;">
<table width="100%" class="100%">
<tr>
	<td style="padding:2px;"><input type="checkbox" checked id="showStatsNewWindowBox" /></td>
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
	<table style="width:650px" height="100%" valign="top" border="0">
	<!-- main tables -->
 	<tr>
	<td id="tdMenu" valign="top">
		<table valign="top" id="ws_main_wikia_select_td" style="border:1px solid #2F6FAB; padding:3px;">
		    <tr>
				<td align="left" valign="middle">
					<?=wfMsg('wikiastats_search_text')?> <input type="text" name="ws-city-name" autocomplete="off" id="ws-city-name" class="ws-input" style="width:auto" />
				</td>
				<td align="left" valign="top" height="100%" rowspan="2" style="padding: 2px 10px">
					<div style="float:right;clear:both;font-size:8pt;height:12px;"><a href="http://help.wikia.com/wiki/Help:WikiaStats" target="_new"><?=wfMsg('wikiastats_see_old_statistics_page')?></a></div>
					<fieldset style="width:360px;">
						<legend><?=wfMsg('wikiastats_wikia_information')?></legend>
						<div id="wk-stats-info-panel" class="wk-stats-info-panel"></div>
					</fieldset>
					<div class="wk-select-class-main">
						<input type="button" class="input_button" id="ws-show-stats" name="ws-show-stats" value="<?= wfMsg("wikiastats_showstats_btn") ?>" onClick="redirectToStats(0)" />
						<input type="button" class="input_button" id="ws-show-charts" value="<?= wfMsg("wikiastats_showcharts") ?>" name="ws-show-charts" onClick="redirectToStats(1)" />
					</div>
					<div style="clear:both;" id="ws-main-xls-stats">
					<fieldset style="margin:0px">
						<legend><?=wfMsg('wikiastats_generate_XLS_file_title')?></legend>
						<div class="wk-stats-main-panel" id="wk-stats-main-panel">
							<ul>
								<li id="wk-xls-pagetitle"><a href="javascript:void(0);" onClick="XLSStats('1', '<?=$DEF_DATE?>', '<?=date('Y-m')?>');"><?=wfMsg("wikiastats_pagetitle")?></a></li>
								<!--<li><a href="javascript:void(0);" onClick="XLSStats('9', '<?=$DEF_DATE?>', '<?=date('Y-m')?>');"><?=wfMsg("wikiastats_pageviews")?></a></li>-->
							</ul>
						</div>
						<div class="wk-stats-main-panel" id="wk-stats-panel">
							<ul>
							<!--<li><a href="javascript:void(0);" onClick="XLSStats('2', '<?=$DEF_DATE?>', '<?=date('Y-m')?>');"><?=wfMsg("wikiastats_distrib_article")?></a></li>-->
							<li><a href="javascript:void(0);" onClick="XLSStats('3', '<?=$DEF_DATE?>', '<?=date('Y-m')?>');"><?=wfMsg("wikiastats_active_absent_wikians")?></a></li>
							<li><a href="javascript:void(0);" onClick="XLSStats('4', '<?=$DEF_DATE?>', '<?=date('Y-m')?>');"><?=wfMsg("wikiastats_anon_wikians")?></a></li>
							<!--<li><a href="javascript:void(0);" onClick="XLSStats('5', '<?=$DEF_DATE?>', '<?=date('Y-m')?>');"><?=wfMsg("wikiastats_article_one_link")?></a></li>-->
							<!---<li><a href="javascript:void(0);" onClick="XLSStats('6', '<?=$DEF_DATE?>', '<?=date('Y-m')?>');"><?=wfMsg("wikiastats_namespace_records")?></a></li>-->
							<li><a href="javascript:void(0);" onClick="XLSStats('7', '<?=$DEF_DATE?>', '<?=date('Y-m')?>');"><?=wfMsg("wikiastats_page_edits")?></a></li>
							<li><a href="javascript:void(0);" onClick="XLSStats('8', '<?=$DEF_DATE?>', '<?=date('Y-m')?>');"><?=wfMsg("wikiastats_other_nspaces_edits")?></a></li>
							</ul>
						</div>
					</fieldset>
					</div>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top">
					<?=$wikia_rows?>
					<div id="ws-sort-link" style="float:right; clear:both; font-size:8pt;">
						<a href="javascript:void(0);" onClick="sortWikiaList(1)"><?=wfMsg('wikiastats_sort_list_alphabet')?></a>
					</div>
				</td>
			</tr>
		</table>
    </td>
    <td align="left" valign="top">
		<table style="width:auto;line-height:11pt;display:none;" cellpadding="0" cellspacing="0" id="ws_main_wikia_compare_td" valign="top">
		<tr><td>
<?
$k = 9;
$linkText = array(
	"1" => wfMsg('wikiastats_comparision'),
	"3" => wfMsg('wikiastats_distrib_wikians'),
	"9" => wfMsg('wikiastats_articles_text'),
	"12" => wfMsg('wikiastats_database'),
	"15" => wfMsg('wikiastats_links'),
	"17" => wfMsg('wikiastats_images')
);
for ($i=1; $i<=17; $i++) {
	$l = $k + $i;
	if ( in_array($i, array_keys($linkText)) ) { if ($i != 1) {
?>
	</fieldset>
<?  } ?>
	<fieldset>
	<legend style="font-size:10pt;"><strong><?= $linkText[$i] ?></strong></legend>
<?  } ?>
	<div style="width:680px">
		<div style="width:580px; float: left;"><?= wfMsg("wikiastats_comparisons_table_$i") ?></div>
		<div style="width:auto; float: right;">
			<a href="javascript:void(0);" onClick="showXLSCompareDialog('<?=$l?>', false);"><?= wfMsg('wikiastats_xls_files_stats') ?></a>&nbsp;-&nbsp;
			<a href="javascript:void(0);" onClick="showXLSCompareDialog('<?=$l?>', true);"><?= wfMsg('wikiastats_tables') ?></a>
		</div>
	</div>
<?
}
?>
		</td></tr>
		</table>
    </td>
 </tr>
</table>
</div>
<script type="text/javascript">
/*<![CDATA[*/
YAHOO.util.Event.onDOMReady(function () {
	var wsElement = document.getElementById('ws-city-name');
	if (wsElement) { wsElement.onkeyup = function(){ WikiaStatsGetWikis(this, this.value); }; }
	var wsCompareElement = document.getElementById('ws-search-input-panel');
	if (wsCompareElement) { wsCompareElement.onkeyup =
		function(){
			WikiaStatsCompareGetWikis(this, this.value);
		};
	}
	if (document.getElementById("ws_main_wikia_select_td") && document.getElementById("ws_main_wikia_compare_td")) {
		setActiveSelectTab();
	}
});
</script>
<!-- e:<?= __FILE__ ?> -->
