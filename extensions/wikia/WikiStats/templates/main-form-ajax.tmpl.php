<?php
$tabsUrl = array(
	0 => sprintf("%s/%d/main?ajax=1", $mTitle->getLocalUrl(), $wgCityId),
	1 => sprintf("%s/%d/breakdown?ajax=1", $mTitle->getLocalUrl(), $wgCityId),
	2 => sprintf("%s/%d/anonbreakdown?ajax=1", $mTitle->getLocalUrl(), $wgCityId),
);
#$tabsName = array( "ws-main", "ws-month", "ws-day", "ws-compare" );
$tabsName = array( "ws-main", "ws-breakdown", "ws-anonbreakdown" );
?>
<script type="text/javascript">
var tabsName = new Array( <?= "'" . implode("','", $tabsName) . "'" ?> );
var tabsUrl = new Array( <?= "'" . implode("','", $tabsUrl ) . "'" ?> );
var activeTab = 1;
var activeTabName = 'ws-<?=$mAction?>' ;
var loadedTabs = new Array();
/*$(function() {
	for ( i = 0; i < tabsName.length; i++ )  {
		if ( tabsName[i] == activeTabName ) {
			activeTab = i+1;
		}
	}
	if ( !activeTab ) {
		activeTab = 1;
	}
	
	$('#ws-tabs').tabs( {
		fxFade: true,
		fxSpeed: 'fast',
		onClick: function() {
		},
		onHide: function() {
		},
		onShow: function(e) {
			activeTab = $('#ws-tabs').activeTab();
			if ( !loadedTabs[activeTab] ) {
				reloadTab();
				loadedTabs[activeTab] = 1;
			}
		}
	});
});*/

$(document).ready(function() {
	for ( i = 0; i < tabsName.length; i++ )  {
		if ( tabsName[i] == activeTabName ) {
			activeTab = i+1;
		}
	}
	if ( !activeTab ) {
		activeTab = 1;
	}
	
	$('#ws-tabs').tabs( {
		fxFade: true,
		fxSpeed: 'fast',
		onClick: function(e) {
		},
		onHide: function() {
		},
		onShow: function(e) {
			activeTab = $('#ws-tabs').activeTab();
			if ( !loadedTabs[activeTab] ) {
				reloadTab();
				loadedTabs[activeTab] = 1;
			}
		}
	});
		
	$('#ws-tabs').triggerTab(activeTab);

	if ( activeTab == 1 ) {
		//refreshInfo();
		reloadTab();
	}
	
});

function refreshInfo() {
	$("#ws-loader").show();	
	$('#ws-addinfo').load(wgServer+wgScript+'?action=ajax&rs=axWStats&ws=addinfo', function() {
		$("#ws-loader").hide();		
	});
}

function breakdownInfo(month, limit, anons) {
	$("#ws-loader").show();
	var params = '&month=' + month;
	params += '&limit=' + limit;
	params += '&anons=' + anons;
	$('#ws-breakdown-data' + anons).load(wgServer+wgScript+'?action=ajax&rs=axWStats&ws=breakdown' + params, function() {
		$("#ws-loader").hide();
	});
}

function reloadTab(xls) {
	if ( activeTab == 1 ) {
		var dateFrom = $('#ws-date-year-from').val() || '<?=intval($fromYear)?>';
		var monthFrom = $('#ws-date-month-from').val() || '<?=intval($fromMonth)?>';
		dateFrom += ( monthFrom < 10 ) ? '0' + monthFrom : monthFrom;

		var dateTo = $('#ws-date-year-to').val() || '<?=intval($toYear)?>';
		var monthTo = $('#ws-date-month-to').val() || '<?=intval($toMonth)?>';
		dateTo += ( monthTo < 10 ) ? '0' + monthTo : monthTo;

		var hub = $('#ws-category').val() || '<?=$mHub?>';
		var lang = $('#ws-language').val() || '<?=$mLang?>';

		var ws_domain = $('#ws-domain').val() || '<?=$domain?>';
		var allwikis = $('#ws-all-domain').is(':checked') || '<?= ( $domain == 'all' ) ?>';
		if ( allwikis ) {
			ws_domain = 'all';
		}
		if ( xls == true ) { 
			var dataString = '?from=' + dateFrom;
			dataString += '&to=' + dateTo;
			dataString += '&hub=' + hub;
			dataString += '&lang=' + lang;
			dataString += '&csv=1&ws-domain=' + ws_domain;
			top.wsxlshelper.location.href = tabsUrl[activeTab-1] + dataString;
		} else {
			var data = {
				'from'		: ( dateFrom != NaN) ? dateFrom : 0,
				'to'		: ( dateTo != NaN ) ? dateTo : 0,
				'hub'		: ( hub ) ? hub : '',
				'lang'		: ( lang ) ? lang : '',
				'ws-domain'	: ( ws_domain != undefined ) ? ws_domain : ''
			};
			
			var params = "";
			for ( var key in data ) {
				params += "&" + key + "=" + data[key];
			}
			
			$('#' + tabsName[activeTab-1]).load(tabsUrl[activeTab-1] + params, function() {
				$("#ws-loader").hide();
				$('#ws-show-stats').click(function() {
					reloadTab();
					refreshInfo();
				});	
				$('#ws-export-xls').click(function() {
					reloadTab(true);
				});	
				$('#ws-domain').focus(function() {
					ws_focus('ws-domain','axWFactoryDomainQuery');
					window.sf_initiated = false;
				});
				refreshInfo();
			});
		}
	} 
	else if ( activeTab == 2 ) { 
		$('#' + tabsName[activeTab-1]).load(tabsUrl[activeTab-1], function() {
			$("#ws-loader").hide();
			$('#ws-breakdown-btn').click(function() {
				var month = $('#ws-breakdown-month').val();
				var limit = $('#ws-breakdown-limit').val();
				var anons = 0;
				breakdownInfo(month, limit, anons);
			});		
		});
	} 
	else if ( activeTab == 3 ) {
		$('#' + tabsName[activeTab-1]).load(tabsUrl[activeTab-1], function() {
			$("#ws-loader").hide();
			$('#ws-breakdown-anons-btn').click(function() {
				var month = $('#ws-breakdown-anons-month').val();
				var limit = $('#ws-breakdown-anons-limit').val();
				var anons = 1;
				breakdownInfo(month, limit, anons);
			});		
		});		
	}
}

</script>
<iframe id="wsxlshelper" name="wsxlshelper" style="dispaly:none;height:0px;width:0px;border:0px;"></iframe>
<div id="ws-addinfo" class="ws-addinfo"></div>
<div id="ws-loader" class="ws-loader"><img src="<?=$wgStylePath?>/common/images/ajax.gif" width="16" height="16"></div>
<div id="ws-tabs">		
	<ul>
		<li><a href="<?=$tabsUrl[0]?>#ws-main"><span><?=wfMsg('wikistats_main_statistics_legend')?></span></a></li>
		<li><a href="<?=$tabsUrl[1]?>#ws-breakdown"><span><?=wfMsg('wikistats_breakdown_editors')?></span></a></li>
		<li><a href="<?=$tabsUrl[2]?>#ws-anonbreakdown"><span><?=wfMsg('wikistats_breakdown_anons')?></span></a></li>
	</ul>
<? foreach ( $tabsName as $id => $value ) : ?>	
	<div id="<?=$tabsName[$id]?>"></div>
<? endforeach ?>
</div>
