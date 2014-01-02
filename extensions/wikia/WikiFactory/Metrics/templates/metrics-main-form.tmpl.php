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
.TablePager { font-size:8.5pt }
.TablePager td { padding:1px; }
.TablePager th a {font-weight:normal;}
</style>
<script type="text/javascript" charset="utf-8">

function __makeParamValue() {
	var f = document.getElementById('wfm-form');	
	var target = "";
	if (f.wfm_target && f.wfm_target.length > 0) {
		for ( i = 0; i < f.wfm_target.length; i++ ) {
			if (f.wfm_target[i].checked)
				target += f.wfm_target[i].value + ",";
		}
	}
	return target;
}

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=axAWCMetrics";
				
	var oTable = $('#wfm-table').dataTable( {
		bAutoWidth: false,
		"oLanguage": {
			"sLengthMenu": "<?=wfMsg('table_pager_limit', '_MENU_');?>",
			"sZeroRecords": "<?=wfMsg('table_pager_empty');?>",
			"sEmptyTable": "<?=wfMsg('table_pager_empty');?>",
			"sInfo": "<?=wfMsgExt('awc-metrics-recordspager',  array('parseinline'), '_START_', '_END_', '_TOTAL_');?>",
			"sInfoEmpty": "<?=wfMsg('awc-metrics-recordspager','0', '0', '0');?>",
			"sInfoFiltered": "",
			"sSearch": "<?=wfMsg('search')?>",
			"sProcessing": "<img src='" + stylepath + "/common/images/ajax.gif' /> <?=wfMsg('livepreview-loading')?>",
			"oPaginate" : {
				"sFirst": "<?=wfMsg('table_pager_first')?>",
				"sPrevious": "<?=wfMsg('table_pager_prev')?>",
				"sNext": "<?=wfMsg('table_pager_next')?>",
				"sLast": "<?=wfMsg('table_pager_last')?>"
			}
		},
		"sCookiePrefix" : "awc-metrics",
		"aLengthMenu": [[10,15,20,25], [10,15,20,25]],
		"sDom": '<"dttoolbar"><"top"flip>rt<"bottom"p><"clear">',
		"aoColumnDefs": [ 
			{ "bVisible": true,  "aTargets": [ 0 ], "bSortable" : false },
			{ "bVisible": false,  "aTargets": [ 1 ], "bSortable" : false },
			{ "bVisible": false,  "aTargets": [ 2 ], "bSortable" : false },
			{ "fnRender": function ( oObj ) {
				var active = ( !oObj.aData[1] ) ? ' style="color:#FF0000" ' : '';
				var row = '<a target="_blank" href="' + oObj.aData[4] + '" ' + active + '>' + oObj.aData[3] + '</a>';
				return row;
				},
				"bUseRendered": true,
				"aTargets": [ 3 ],
				"bSortable" : true
			},			
			{ "bVisible": false,  "aTargets": [ 4 ], "bSortable" : false },
			{ "bVisible": true,  "aTargets": [ 14 ], "bSortable" : false },
			{ "fnRender": function ( oObj ) {
				var row = '<input type="checkbox" name="wikis[]" value="' + oObj.aData[2] + '">';
				return row;
				},
				"bUseRendered": true,
				"aTargets": [ 15 ],
				"bSortable" : false
			}
		],	
		"aoColumns": [
			{ "sName": "id" },
			{ "sName": "active" },
			{ "sName": "wikiid" },			
			{ "sName": "title" },
			{ "sName": "url" },
			{ "sName": "db" },
			{ "sName": "lang" },
			{ "sName": "created" },
			{ "sName": "founder" },
			{ "sName": "users" },
			{ "sName": "regusers" },
			{ "sName": "articles" },
			{ "sName": "edits" },
			{ "sName": "images" },
			{ "sName": "pviews" },
			{ "sName": "close" },
		],
		"aaSorting": [[ 3, "asc" ]],
		"bProcessing": true,
		"bServerSide": true,
		"bFilter" : false,
		"sPaginationType": "full_numbers",
		"sAjaxSource": baseurl,
		/*"fnInitComplete" : function ( oInstance, oSettings, json ) {
			// make CSS buttons
		},*/
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			var limit		= 30;
			var offset 		= 0;		
			var groups	 	= __makeParamValue();
			var loop		= 1;
			var order 		= '';
			
			var sortingCols = 0;
			var _tmp = new Array();
			var _tmpDesc = new Array();			
			var columns		= new Array();
			var sortColumns = new Array();
			var sortOrder	= new Array();
			var iColumns	= 0;
			
			for ( i in aoData ) {
				switch ( aoData[i].name ) {
					case 'iDisplayLength'	: limit = aoData[i].value; break;
					case 'iDisplayStart'	: offset = aoData[i].value; break;
					case 'sEcho'			: loop = aoData[i].value; break;
					case 'sColumns'			: columns = aoData[i].value.split(","); break;
					case 'iColumns'			: iColumns = aoData[i].value; break;
					case 'iSortingCols'		: sortingCols = aoData[i].value; break;
				}
				
				if ( aoData[i].name.indexOf( 'iSortCol_', 0) !== -1 ) 
					sortColumns.push(aoData[i].value);
				
				if ( aoData[i].name.indexOf( 'sSortDir_', 0) !== -1 ) 
					sortOrder.push(aoData[i].value);
			}
				
			if ( sortingCols > 0 ) {
				for ( i = 0; i < sortingCols; i++ ) {
					var info = columns[sortColumns[i]] + ":" + sortOrder[i];
					_tmp.push(info);
				}
				order = _tmp.join('|');
			}

			$.ajax( {
				"dataType": 'json', 
				"type": "POST", 
				"url": sSource, 
				"data": [
					{ 'name' : 'awc-created',  'value' : ( $('#awc-metrics-created').exists() ) ? $('#awc-metrics-created').val() : 0 },
					{ 'name' : 'awc-from',     'value' : ( $('#awc-metrics-between-from').exists() ) ? $('#awc-metrics-between-from').val() : '' },
					{ 'name' : 'awc-to',       'value' : ( $('#awc-metrics-between-to').exists() ) ? $('#awc-metrics-between-to').val() : '' },
					{ 'name' : 'awc-language', 'value' : ( $('#awc-metrics-language').exists() ) ? $('#awc-metrics-language').val() : 0 },
					{ 'name' : 'awc-hub',      'value' : ( $('#awc-metrics-category-hub').exists() ) ? $('#awc-metrics-category-hub').val() : '' },
					{ 'name' : 'awc-dbname',   'value' : ( $('#awc-metrics-dbname').exists() ) ? $('#awc-metrics-dbname').val() : '' },
					{ 'name' : 'awc-domain',   'value' : ( $('#awc-metrics-domains').exists() ) ? $('#awc-metrics-domains').val() : '' },
					{ 'name' : 'awc-exactDomain',   'value' : ( $('#awc-metrics-domains-exact').exists() ) ? $('#awc-metrics-domains-exact').val() : '' },
					{ 'name' : 'awc-title',    'value' : ( $('#awc-metrics-title').exists() ) ? $('#awc-metrics-title').val() : '' },
					{ 'name' : 'awc-user',     'value' : ( $('#awc-metrics-user').exists() ) ? $('#awc-metrics-user').val() : '' },
					{ 'name' : 'awc-email',    'value' : ( $('#awc-metrics-email').exists() ) ? $('#awc-metrics-email').val() : '' },
					{ 'name' : 'awc-closed',   'value' : ( $('#awc-metrics-closed:checked').val() ) ? 1 : 0 },
					{ 'name' : 'awc-active',   'value' : ( $('#awc-metrics-active:checked').val() ) ? 1 : 0 },
					{ 'name' : 'awc-nbrArticles',   'value' : ( $('#awc-nbr-articles').exists() ) ? $('#awc-nbr-articles').val() : 0 },
					{ 'name' : 'awc-nbrEdits',   'value' : ( $('#awc-nbr-edits').exists() ) ? $('#awc-nbr-edits').val() : 0 },
					{ 'name' : 'awc-nbrEditsDays',   'value' : ( $('#awc-nbr-edits-days').exists() ) ? $('#awc-nbr-edits-days').val() : 0 },
					{ 'name' : 'awc-nbrPageviews',   'value' : ( $('#awc-nbr-pageviews').exists() ) ? $('#awc-nbr-pageviews').val() : 0 },
					{ 'name' : 'awc-nbrPageviewsDays',   'value' : ( $('#awc-nbr-pageviews-days').exists() ) ? $('#awc-nbr-pageviews-days').val() : 0 },
					{ 'name' : 'awc-limit', 	'value' : limit },
					{ 'name' : 'awc-offset',	'value' : offset },
					{ 'name' : 'awc-loop', 		'value' : loop },
					{ 'name' : 'awc-numOrder',	'value' : sortingCols },
					{ 'name' : 'awc-order',		'value' : order }
				], 
				"success": fnCallback
			} );
		}		
	} );
	
	var toolbar = '';
	
	$("div.dttoolbar").html( toolbar );
	$('#awc-metrics-submit').click( function() { oTable.fnDraw(); } );
} );

</script>

<p class='error'><?=$error?></p>
<div>
<form method="post" action="<?=$action?>" id="wfm-form">
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
					<!--<input type="button" value="<?=wfMsg('awc-metrics-hubs')?>" id="awc-metrics-hubs" />
					<input type="button" value="<?=wfMsg('awc-metrics-news-day')?>" id="awc-metrics-news-day" />-->
				</td>
			</tr>
		</table>
	</fieldset>
	</div>
</form> 
</div>
<form method="post" action="<?=$action?>" id="wfm-form">
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="wfm-table">
	<thead>
		<tr>
			<th rowspan="2" width="1%">#</th>
			<th rowspan="2" width="1%">#</th>
			<th rowspan="2" width="1%">#</th>
			<th rowspan="2" width="14%">Wikia</th>
			<th rowspan="2" width="1%">Url</th>
			<th rowspan="2" width="10%">DB Name</th>
			<th rowspan="2" width="7%">Language</th>
			<th rowspan="2" width="10%">Created</th>
			<th rowspan="2" width="15%">Founder</th>
			<th colspan="5"><?=wfMsg('awc-metrics-statistics')?></th>
			<th width="7%" rowspan="2"><?=wfMsg('awc-metrics-pageviews')?></th>
			<th width="5%" rowspan="2"><?=wfMsg('awc-metrics-close-checked')?></th>
		</tr>
		<tr>
			<th width="7%"><?=wfMsg('awc-metrics-all-users')?></th>			
			<th width="7%"><?=wfMsg('awc-metrics-all-users-edit-main-ns')?></th>
			<th width="7%"><?=wfMsg('awc-metrics-articles')?></th>
			<th width="7%"><?=wfMsg('awc-metrics-edits')?></th>
			<th width="7%"><?=wfMsg('awc-metrics-images')?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="14" class="dataTables_empty"><?=wfMsg('livepreview-loading')?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th rowspan="2" width="1%">#</th>
			<th rowspan="2" width="1%">#</th>
			<th rowspan="2" width="1%">#</th>
			<th rowspan="2" width="14%">Wikia</th>
			<th rowspan="2" width="1%">Url</th>
			<th rowspan="2" width="10%">DB Name</th>
			<th rowspan="2" width="7%">Language</th>
			<th rowspan="2" width="10%">Created</th>
			<th rowspan="2" width="15%">Founder</th>
			<th width="7%"><?=wfMsg('awc-metrics-all-users')?></th>			
			<th width="7%"><?=wfMsg('awc-metrics-all-users-edit-main-ns')?></th>
			<th width="7%"><?=wfMsg('awc-metrics-articles')?></th>
			<th width="7%"><?=wfMsg('awc-metrics-edits')?></th>
			<th width="7%"><?=wfMsg('awc-metrics-images')?></th>
			<th width="7%" rowspan="2"><?=wfMsg('awc-metrics-pageviews')?></th>
			<th width="7%" rowspan="2"><input type="submit" value="<?=wfMsg('awc-metrics-close-action')?>">
			<input type="hidden" name="close_flags[]" value="4"><input type="hidden" name="close_flags[]" value="8"></th>
		</tr>
		<tr>
			<th colspan="5"><?=wfMsg('awc-metrics-statistics')?></th>
		</tr>
	</tfoot>
</table>
</form>

<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
