<?php
$tabsUrl = array(
	0 => sprintf("%s/%d/main", $mTitle->getLocalUrl(), $wgCityId),
	#1 => sprintf("%s/%d/month", $mTitle->getLocalUrl(), $wgCityId),
	#2 => sprintf("%s/%d/current", $mTitle->getLocalUrl(), $wgCityId),
	#3 => sprintf("%s/%d/compare", $mTitle->getLocalUrl(), $wgCityId)
	#1 => sprintf("%s/%d/pviews", $mTitle->getLocalUrl(), $wgCityId)
);
#$tabsName = array( "ws-main", "ws-month", "ws-day", "ws-compare" );
$tabsName = array( "ws-main", "ws-pv" );
?>
<script type="text/javascript">
var tabsName = new Array( <?= "'" . implode("','", $tabsName) . "'" ?> );
var tabsUrl = new Array( <?= "'" . implode("','", $tabsUrl ) . "'" ?> );
var activeTab = 0;
$(function() {
	$('#ws-tabs').tabs({
		fxFade: true,
		fxSpeed: 'fast',
		onClick: function() {
			reloadTab();
		},
		onHide: function() {
		},
		onShow: function() {
			activeTab = $('#ws-tabs').activeTab();
			reloadTab();
		}
	});
	refreshInfo();
	reloadTab();
});

function refreshInfo() {
	$('#ws-addinfo').load(wgServer+wgScript+'?action=ajax&rs=axWStats&ws=addinfo');
}

function reloadTab(xls) {
	var dateFrom = $('#ws-date-year-from').val();
	var monthFrom = $('#ws-date-month-from').val();
	dateFrom += ( monthFrom < 10 ) ? '0' + monthFrom : monthFrom;

	var dateTo = $('#ws-date-year-to').val();
	var monthTo = $('#ws-date-month-to').val();
	dateTo += ( monthTo < 10 ) ? '0' + monthTo : monthTo;

	var hub = $('#ws-category').val();
	var lang = $('#ws-language').val();

	var ws_domain = $('#ws-domain').val();
	var allwikis = $('#ws-all-domain').is(':checked');
	if ( allwikis ) {
		ws_domain = 'all';
	}
	if ( xls == true ) { 
		dataString = '?from=' + dateFrom;
		dataString += '&to=' + dateTo;
		dataString += '&hub=' + hub;
		dataString += '&lang=' + lang;
		dataString += '&css=1&ws-domain=' + ws_domain;
		top.wsxlshelper.location.href = tabsUrl[0] + dataString;
	} else {
		var data = {
			'from': ( dateFrom != NaN) ? dateFrom : 0,
			'to': ( dateTo != NaN ) ? dateTo : 0,
			'hub': ( hub ) ? hub : '',
			'lang': ( lang ) ? lang : '',
			'ws-domain': ( ws_domain != undefined ) ? ws_domain : ''
		};
		$('#' + tabsName[activeTab]).load(tabsUrl[0], data, function() {
			$("#ws-loader").css('display', 'none'); 
			$('#ws-show-stats').click(function() {
				$("#ws-loader").css('display', 'block'); 
				reloadTab();
				refreshInfo();
			});	
			$('#ws-export-xls').click(function() {
				$("#ws-loader").css('display', 'block'); 
				reloadTab(true);
				$("#ws-loader").css('display', 'none'); 
			});	
			//$('table').visualize({type: 'line'});
		});
	}
/*	var refreshId = setInterval( function() {
		$("#ws-loader").css('display', 'block');  
		$('#' + tabsName[activeTab]).load(tabsUrl[0], data, function() {
			$("#ws-loader").css('display', 'none'); 
			$('#ws-show-stats').click(function() {
				reloadTab();
				refreshInfo();
			});	
			$('#ws-export-xls').click(function() {
				reloadTab(true);
			});	
			//$('table').visualize({type: 'line'});
		}); 
	}, 500000 ); */
}

</script>
<iframe id="wsxlshelper" name="wsxlshelper" style="dispaly:none;height:0px;width:0px;border:0px;"></iframe>
<div id="ws-addinfo" class="ws-addinfo"></div>
<div id="ws-loader" class="ws-loader"><img src="<?=$wgStylePath?>/common/images/ajax.gif" width="16" height="16"></div>
<div id="ws-tabs">		
	<ul>
		<li><a href="<?=$tabsUrl[0]?>#ws-main"><span><?=wfMsg('wikistats_main_statistics_legend')?></span></a></li>
	</ul>
	<div id="<?=$tabsName[0]?>"></div>
</div>
