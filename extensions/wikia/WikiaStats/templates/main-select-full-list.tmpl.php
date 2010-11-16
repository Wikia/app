<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript" src="/extensions/wikia/WikiaStats/js/wikiastats.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
<?
$xlsMenuHeader = addslashes(wfMsg("wikiastats_select_statistics"));
#---
$loop = 0;
#$cities_list = "<select name=\"ws-city[]\" id=\"ws-city\" size=12 style=\"width:400px;border:0px;\" multiple>";
$wikia_rows = array();
$cities_list = "";
$y = 0;
foreach ($cityStats as $id => $cityId)
{
	if (!empty($cityList[$cityId]))
	{
		$loop++;
		#----
		#$cities_list .= "<option value=\"{$cityId}\">".$cityList[$cityId]['dbname']."</option>";
		$readolny = ($cityId == 0) ? "checked disabled" : "";
		
		if ($loop > 10 * ($y + 1)) $y++;
		if (empty($wikia_rows[$y])) $wikia_rows[$y] = "";
		
		$wikia_rows[$y] .= "<tr id=\"wkri-{$cityId}\">";
		$wikia_rows[$y] .= "<td class=\"wktd\" id=\"wkcn-{$cityId}\">";
		$wikia_rows[$y] .= "<a target=\"new\" href=\"".$cityList[$cityId]['url']."\">";
		$wikia_rows[$y] .= ($cityId != 0) ? ucfirst($cityList[$cityId]['dbname']): wfMsg('wikiastats_trend_all_wikia_text') ;
		$wikia_rows[$y] .= "</a></td>";
		$wikia_rows[$y] .= "<td width=\"250\" class=\"wktdr\"><a href=\"/index.php?title=Special:WikiaStats&action=citystats&city={$cityId}\">".wfMsg('wikiastats_tables')."</a>&nbsp;-&nbsp;";
		$wikia_rows[$y] .= "<a href=\"/index.php?title=Special:WikiaStats&action=citycharts&city={$cityId}\">".wfMsg('wikiastats_charts')."</a>&nbsp;-&nbsp;";
		$wikia_rows[$y] .= "<a href=\"javascript:void(0)\" onClick=\"XLSShowMenu('{$cityId}');\">".wfMsg('wikiastats_xls_files_stats')."</a></td></tr>";
		
		$cities_list .= "<input type=\"checkbox\" {$readolny} id=\"wscid\" name=\"wscid\" value=\"{$cityId}\" />". ucfirst($cityList[$cityId]['title']) ." (".ucfirst($cityList[$cityId]['dbname']).") <br />";
		$cities_list .= ($cityId == 0) ? "<br />" : "";
	}
}
#$cities_list .= "</select>";
?>

//YAHOO.namespace("YAHOO.Wikia.Statistics");
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;

var xlsMenuHeader = "<?=addslashes(wfMsg("wikiastats_select_wikia_statistics"))?>";
var wk_stats_city_id = 0;
var background_color = "";
var compare_stats = 0;

function showXLSCompareDialog(statistics)
{
	compare_stats = statistics;
	//----
	if (statistics == 9)
	{
		wk_stats_city_id = 0;
		YD.get("wk-stats-panel").style.display = "none";
		YD.get("wk-stats-main-panel").style.display = "none";
		YD.get("wk-progress-stats-panel").style.display = "block";	
		XLSGenerate(statistics, '', '', '');
		YAHOO.wkstatsxlsmenu.container.xlsmenu.setHeader('<?= addslashes(wfMsg('wikiastats_creation_panel_header')) ?>');
		YAHOO.wkstatsxlsmenu.container.xlsmenu.show();
	}
	else
	{
		YAHOO.Wikia.Statistics.compareStatsDialog.show();
		YD.get("compareStatsDialog_c").style.display = "block";
	}
}

YAHOO.namespace("wkstatsxlsmenu.container"); 
(function() {
    YAHOO.wkstatsxlsmenu.container = {
        init: function() 
        {
            if (!YAHOO.wkstatsxlsmenu.container.xlsmenu) 
            { 
                YAHOO.wkstatsxlsmenu.container.xlsmenu = new YAHOO.widget.Panel("xlsmenu", 
                { 	width: "450px",
                    constraintoviewport: true, 
                    fixedcenter: true, 
                    close: true, 
                    draggable: true, 
                    zindex:9000, 
                    //modal: true, 
                    visible: false} 
                ); 
                YAHOO.wkstatsxlsmenu.container.xlsmenu.setHeader("<?=$xlsMenuHeader?>"); 

                xlmmenutext = "<div class=\"wk-stats-main-panel\" id=\"wk-stats-main-panel\">";
                xlmmenutext += "<ul>";
                xlmmenutext += "<li id=\"wk-xls-pagetitle\"><a href=\"javascript:void(0);\" onClick=\"XLSGenerate('1', '', '', '');\"><?=wfMsg("wikiastats_pagetitle")?></a></li>";
                xlmmenutext += "</ul>";
                xlmmenutext += "</div>";

                xlmmenutext += "<div class=\"wk-stats-panel\" id=\"wk-stats-panel\">";
                xlmmenutext += "<ul>";
                //xlmmenutext += "<li><a href=\"javascript:void(0);\" onClick=\"XLSGenerate('2', '', '', '');\"><?=wfMsg("wikiastats_distrib_article")?></a></li>";
                xlmmenutext += "<li><a href=\"javascript:void(0);\" onClick=\"XLSGenerate('3', '', '', '');\"><?=wfMsg("wikiastats_active_absent_wikians")?></a></li>";
                xlmmenutext += "<li><a href=\"javascript:void(0);\" onClick=\"XLSGenerate('4', '', '', '');\"><?=wfMsg("wikiastats_anon_wikians")?></a></li>";
                //xlmmenutext += "<li><a href=\"javascript:void(0);\" onClick=\"XLSGenerate('9', '', '', '');\"><?=wfMsg("wikiastats_pageviews")?></a></li>";
                //xlmmenutext += "<li><a href=\"javascript:void(0);\" onClick=\"XLSGenerate('5', '', '', '');\"><?=wfMsg("wikiastats_article_one_link")?></a></li>";
                //xlmmenutext += "<li><a href=\"javascript:void(0);\" onClick=\"XLSGenerate('6', '', '', '');\"><?=wfMsg("wikiastats_namespace_records")?></a></li>";
                xlmmenutext += "<li><a href=\"javascript:void(0);\" onClick=\"XLSGenerate('7', '', '', '');\"><?=wfMsg("wikiastats_page_edits")?></a></li>";
                xlmmenutext += "<li><a href=\"javascript:void(0);\" onClick=\"XLSGenerate('8', '', '', '');\"><?=wfMsg("wikiastats_other_nspaces_edits")?></a></li>";
                xlmmenutext += "</ul>";
                xlmmenutext += "</div>";

                xlmmenutext += "<div class=\"wk-progress-stats-panel\" id=\"wk-progress-stats-panel\">";
                xlmmenutext += "<center><img src=\"/skins/common/images/ajax.gif\" border=\"0\"></center>";
                xlmmenutext += "</div>";

                xlmmenutext += "<div style=\"float:right;\">";
                xlmmenutext += "<input type=\"button\" name=\"closePanel\" value=\"<?=wfMsg('wikiastats_panel_close_btn')?>\" onClick=\"XLSPanelClose();\" />";
                xlmmenutext += "</div>";

                YAHOO.wkstatsxlsmenu.container.xlsmenu.setBody(xlmmenutext); 

                YAHOO.wkstatsxlsmenu.container.xlsmenu.render(document.body); 		
            }
        } 
    }  
    YE.onDOMReady(YAHOO.wkstatsxlsmenu.container.init, YAHOO.wkstatsxlsmenu.container, true); 
}
)();


YAHOO.namespace("Wikia.Statistics");
(function() { 
    YAHOO.Wikia.Statistics = 
    {
	    init: function() {
            YD.get("compareStatsDialog").style.display = "block";
            YD.get("wk-progress-compare-panel").style.display = "none";
            if (!YAHOO.Wikia.Statistics.compareStatsDialog) 
            { 
                YAHOO.Wikia.Statistics.handleSubmit = function() 
                { 
                    var checklist = document.XLSCompareForm.wscid;
                    var is_checked = 0;
                    var checked_list = "";
                    for (i = 0; i < checklist.length; i++)
                    {
                        if (checklist[i].checked)
                        {
                            checked_list += checklist[i].value + ";";
                            is_checked++;
                        }
                    }
                    if (is_checked > <?= ($MAX_NBR + 1)?>)
                    {
                        // FIXME: wikiastats_xls_generate_info requires plural support in JavaScript.
                        alert(YAHOO.tools.printf("<?=addslashes(wfMsg('wikiastats_xls_generate_info'))?>", (<?=$MAX_NBR + 1?>)));
                        return false;
                    }
                    YD.get("wk-progress-compare-panel").style.display = "block";
                    XLSGenerate(compare_stats, checked_list, '', '');
                };
                YAHOO.Wikia.Statistics.handleCancel = function() 
                { 
                    YD.get("wk-progress-compare-panel").style.display = "none";
                    XLSCancel();
                    YD.get("compareStatsDialog_c").style.display = "none";
                    this.cancel(); 
                };
                // Instantiate the Dialog
                YAHOO.Wikia.Statistics.compareStatsDialog = new YAHOO.widget.Dialog("compareStatsDialog",
                {
                    width : "450px", 
                    fixedcenter : true,
                    visible : false,
                    draggable: false, 
                    zindex:9000, 
                    constraintoviewport : true,
                    buttons : [ { text:"<?=wfMsg('wikiastats_xls_generate')?>", handler:YAHOO.Wikia.Statistics.handleSubmit, isDefault:true },
                                { text:"<?=wfMsg('wikiastats_panel_close_btn')?>", handler:YAHOO.Wikia.Statistics.handleCancel } 
                              ]
                });
                // Render the Dialog
                YAHOO.Wikia.Statistics.compareStatsDialog.render(document.body);
				YD.get("compareStatsDialog_c").style.display = "none";
            }
        }
    }
    YE.onDOMReady(YAHOO.Wikia.Statistics.init, YAHOO.Wikia.Statistics, true); 
}
)();

YE.addListener("ws-check-cities", "click", XLSClearCitiesList);

/*]]>*/
</script>
<!-- Statistics dialog -->
<div id="compareStatsDialog">
<div class="hd" id="ws-stats-dialog-hd"><?=wfMsg('wikiastats_comparision')?></div>
<div class="bd">
	<form name="XLSCompareForm" action="/" method="post">
	<div id="wk-select-cities-panel">
		<fieldset class="ws-frame-border">
		<legend class="normal"><?= wfMsg('wikiastats_mainstats_info') ?></legend>
			<div class="ws-div-scroll"><?=$cities_list?></div>
			<div class="clear"></div>
			<div class="ws-btn-panel">
				<span class="button-group">
					<button name="ws-check-cities" id="ws-check-cities" type="button"><?=wfMsg('wikiastats_xls_uncheck_list')?></button>
					<?=wfMsg('wikiastats_xls_press_uncheck')?>
				</span>
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="wk-progress-compare-panel" id="wk-progress-compare-panel">
		<center><img src="/skins/common/images/ajax.gif" border="0"></center>
	</div>

	</form>
</div>
</div>
<!-- end of statistics dialog -->
<div id="ws-xls-div"></div>
<div id="ws-main-table" style="height:100%">
<!-- WIKI's INFORMATION -->
<table style="width:auto; font-family: arial,sans-serif,helvetica;" height="100%" valign="top">
 <tr>
    <td class="panel-bootom-big" style="white-space:nowrap;" align="left">
        <strong><?= wfMsg('wikiastats_wikia') ?> <!--(<?=$loop?> <?= wfMsg('wikiastats_records') ?>)--></strong> 
    </td>
    <td align="left" style="width:30px;white-space:nowrap;">&nbsp;</td>
    <td class="panel-bootom-big" style="white-space:nowrap;" align="left">
        <strong><?= wfMsg('wikiastats_comparision') ?></strong>
    </td>
 </tr>
<!-- main tables -->
 <tr>
    <td align="left" valign="top" id="tdMenu" valign="top" height="100%" style="white-space:nowrap;">
    <?= count($wikia_rows); ?>
    <? foreach ($wikia_rows as $id => $rows) { ?>
        <table valign="top" class="ws-trend-table"><?=$rows?></table>
	<? } ?>        
    </td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
        <table class="ws-trend-table-wob" id="ws-trend-table">
<?
$k = 7; for ($i=1; $i<=17; $i++) {
	$l = $k + $i;
?>	
        <tr><td class="wktd"><?= wfMsg("wikiastats_comparisons_table_$i") ?></td><td class="wktd"><a href="javascript:void(0);" onClick="showXLSCompareDialog('<?=$l?>');"><?= wfMsg('wikiastats_xls_files_stats') ?></a>&nbsp;-&nbsp;<a href="/index.php?title=Special:WikiaStats&action=compare&table=<?=$i?>"><?= wfMsg('wikiastats_tables') ?></a></td></tr>
<?	if ($i == 2) {
?>
        <tr><td class="eb-trend-trend" colspan="2">&nbsp;</tr>
<?	}
}
?>	
        </table>
    </td>
 </tr>
</table>
</div>
<!-- e:<?= __FILE__ ?> -->
