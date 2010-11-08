<!-- s:<?= __FILE__ ?> -->
<!-- ACTIVITY -->
<script type="text/javascript" charset="utf-8">

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=axWStats&ws=activity";
	var lang = '<?=$plang?>';
	var cat = '<?=$pcat?>';
	var year = '<?=$pyear?>';
	var month = '<?=$pmonth?>';
	
	var oTable = $('#ws-table').dataTable( {
		"oLanguage": {
			"sLengthMenu": "<?=wfMsg('table_pager_limit', '_MENU_');?>",
			"sZeroRecords": "<?=wfMsg('table_pager_empty');?>",
			"sEmptyTable": "<?=wfMsg('table_pager_empty');?>",
			"sInfo": "<?=wfMsgExt('wikistats_recordspager',  array('parseinline'), '_START_', '_END_', '_TOTAL_');?>",
			"sInfoEmpty": "<?=wfMsgExt('wikistats_recordspager', array('parseinline'), '0', '0', '0');?>",
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
		"aaSorting" : [],
		"iDisplayLength" : 25,
		"aLengthMenu": [[25, 50, 100, 250], [25, 50, 100, 250]],
		"sDom": '<"dttoolbar"><"top"flip>rt<"bottom"p><"clear">',
		"aoColumns": [
			{ "sName": "id" },
			{ "sName": "dbname" },			
			{ "sName": "title" },
			{ "sName": "url" },
			{ "sName": "users" },
			{ "sName": "edits" },
			{ "sName": "articles" },
			{ "sName": "lastedit" },
			{ "sName": "users_diff" },
			{ "sName": "edits_diff" },
			{ "sName": "articles_diff" }
		],
		"aoColumnDefs": [ 
			{ "bVisible": false,  "aTargets": [ 0 ], "bSortable" : false },
			{
				"fnRender": function ( oObj ) {
					var row = '<span class="ws-row"><a target="new" href="http://community.wikia.com/index.php?title=Special:WikiFactory/db:' + oObj.aData[1] + '" target="new">' + oObj.aData[1] + '</a></span>';
					if ( oObj.aData[0] == 0 ) {
						row = '<span class="ws-row">' + oObj.aData[1] + '</span>';
					}
					return row;
				},
				"aTargets": [ 1 ],
				"bSortable": true
			},
			{
				"fnRender": function ( oObj ) {
					var row = '<span class="ws-row"><a target="new" href="' + oObj.aData[3] + '" target="new">' + oObj.aData[2] + '</a></span>';
					if ( oObj.aData[0] == 0 ) {
						row = '<span class="ws-row">' + oObj.aData[2] + '</span>';
					}					
					return row;
				},
				"aTargets": [ 2 ],
				"bSortable": true
			},
			{ "bVisible": false,  "aTargets": [ 3 ], "bSortable" : false },
			{
				"fnRender": function ( oObj ) {
					var change = ( oObj.aData[8] > oObj.aData[4] ) ? ' <span style="color:#00FF00;">&#8593;</span> ' : '<span></span>';
					change = ( oObj.aData[8] < oObj.aData[4] ) ? ' <span style="color:#FF0000;">&#8595;</span> ' : change;
					var row = '<span class="ws-row">' + oObj.aData[4] + ' ' + change + '</span>';
					return row;
				},
				"aTargets": [ 4 ],
				"bSortable": true
			},
			{
				"fnRender": function ( oObj ) {
					var change = ( oObj.aData[9] > oObj.aData[5] ) ? ' <span style="color:#00FF00;">&#8593;</span> ' : '<span></span>';
					change = ( oObj.aData[9] < oObj.aData[5] ) ? ' <span style="color:#FF0000;">&#8595;</span> ' : change;
					var row = '<span class="ws-row">' + oObj.aData[5] + ' ' + change + '</span>';
					return row;
				},
				"aTargets": [ 5 ],
				"bSortable": true
			},
			{
				"fnRender": function ( oObj ) {
					var change = ( oObj.aData[10] > oObj.aData[6] ) ? ' <span style="color:#00FF00">&#8593;</span> ' : '<span></span>';
					change = ( oObj.aData[10] < oObj.aData[6] ) ? ' <span style="color:#FF0000;">&#8595;</span> ' : change;
					var row = '<span class="ws-row">' + oObj.aData[6] + ' ' + change + '</span>';
					return row;
				},
				"aTargets": [ 6 ],
				"bSortable": true
			},			
			{ "sClass": "ws-datetime", "aTargets": [ 7 ], "bSortable" : true},
			{ "bVisible": false,  "aTargets": [ 8 ], "bSortable" : false },
			{ "bVisible": false,  "aTargets": [ 9 ], "bSortable" : false },
			{ "bVisible": false,  "aTargets": [ 10 ], "bSortable" : false }
		],		
		"bProcessing": true,
		"bServerSide": true,
		"bFilter" : false,
		"sPaginationType": "full_numbers",
		"sAjaxSource": baseurl,
		/*"fnInitComplete" : function ( oInstance, oSettings, json ) {
			// make CSS buttons
		},*/
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			var limit		= 25;
			var offset 		= 0;		
			var groups	 	= 0;
			var loop		= 1;
			var order 		= '';
			
			var sortingCols = 0;
			var iColumns	= 0;
				
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
					{ 'name' : 'lang',		'value' : ( $('#ws_lang').exists() ) ? $('#ws_lang').val() : '' },
					{ 'name' : 'cat',		'value' : ( $('#ws_cat').exists() ) ? $('#ws_cat').val() : '' },
					{ 'name' : 'year',		'value' : ( $('#ws_year').exists() ) ? $('#ws_year').val() : '' },
					{ 'name' : 'month',		'value' : ( $('#ws_month').exists() ) ? $('#ws_month').val() : '' },
					{ 'name' : 'summary',	'value' : ( $('#wsall').exists() ) ? $('#wsall:checked').val() : 0 },
					{ 'name' : 'limit', 	'value' : limit },
					{ 'name' : 'offset',	'value' : offset },
					{ 'name' : 'loop', 		'value' : loop },
					{ 'name' : 'numOrder',	'value' : sortingCols },
					{ 'name' : 'order',		'value' : order }
				], 
				"success": fnCallback
			} );
		}		
	} );
	
	$('#wsactivebtn').click( function() { oTable.fnDraw(); } );
	$('#wsactivexls').click( function() { 
		var lang = ( $('#ws_lang').exists() ) ? $('#ws_lang').val() : '';
		var cat = ( $('#ws_cat').exists() ) ? $('#ws_cat').val() : '' ;
		var year = ( $('#ws_year').exists() ) ? $('#ws_year').val() : '';
		var month = ( $('#ws_month').exists() ) ? $('#ws_month').val() : '';
		var baseurl = wgScript + "?action=ajax&rs=axWStats&ws=activity&op=xls";
		document.location = baseurl + "&cat=" + cat + "&lang=" + lang + "&year=" + year + "&month=" + month;
	});
		
	//oTable.fnSetColumnVis( 0, false );
	//oTable.fnSetColumnVis( 1, false );
	
} );

</script>

<div class="ws_filter">
		<ul>
			<li><span><?= wfMsg('wikistats_date') ?></span></li>
			<li><select id="ws_month">
<?php 
for ( $i=1; $i <= 12; $i++ ) :
	$selected = ($i == intval($pmonth)) ? " selected=\"selected\" " : ""; ?>
				<option <?= $selected ?> value="<?= $i ?>"><?= $wgLang->getMonthName($i) ?></option>
<?php endfor; ?>
				</select>
			</li>			
			<li><select id="ws_year">
<?php 
for ( $i=2001; $i <= date('Y'); $i++ ) :
	$selected = ($i == intval($pyear)) ? " selected=\"selected\" " : ""; ?>
				<option <?= $selected ?> value="<?= $i ?>"><?= $i ?></option>
<?php endfor; ?>
				</select>
			</li>
			<li><span><?=wfMsg('wikistats_wikicategory')?></span></li>
			<li><select name="ws_cat" id="ws_cat">
<?php if (!empty($categories) && is_array($categories) ): ?>
				<option value=""></option>
<?php foreach ($categories as $iCat => $sCatName) : ?>
<?php $selected = ($iCat == $pcat) ? " selected=\"selected\" " : ""; ?>
				<option value="<?php echo $iCat ?>" <?= $selected ?>><?php echo $sCatName?></option>
<?php endforeach ?>
<?php endif ?>
				</select>
			</li>
			<li><span><?=wfMsg('wikistats_wikilang')?></span></li>
			<li><select name="ws_lang" id="ws_lang">
				<option value=""></option>
<?php if (!empty($topLanguages) && is_array($topLanguages)) : ?>
				<optgroup label="<?= wfMsg('wikistats_language_top', count($topLanguages)) ?>">
<?php foreach ($topLanguages as $sLang) : ?>
<?php $selected = ($sLang == $plang) ? " selected=\"selected\" " : ""; ?>
				<option value="<?=$sLang?>" <?=$selected?>><?=$sLang?>: <?=$aLanguages[$sLang]?></option>
<?php endforeach ?>
				</optgroup>
<?php endif ?>
				<optgroup label="<?= wfMsg('wikistats_language_all') ?>">
<?php if (!empty($aLanguages) && is_array($aLanguages)) : ?>
<?php ksort($aLanguages); foreach ($aLanguages as $sLang => $sLangName) : ?>
<?php $selected = ($sLang == $plang) ? " selected=\"selected\" " : ""; ?>
				<option value="<?=$sLang?>" <?=$selected?>><?=$sLang?>: <?=$sLangName?></option>
<?php endforeach ?>
				</optgroup>
<?php endif ?>
				</select>
			</li>
		</ul>
		<ul>	
			<input name="wsall" id="wsall" type="checkbox" value="1" /><?=wfMsg('wikistats_summary_data')?>
			<li><input type="submit" id="wsactivebtn" value="<?= wfMsg("wikistats_showstats_btn") ?>"  /></li>
			<li><input type="submit" id="wsactivexls" value="<?= wfMsg("wikistats_export_xls") ?>" /></li>
		</ul>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="ws-table">
	<thead>
		<tr>
			<th width="2%">#</th>
			<th width="15%"><?=wfMsg('wikistats_database')?></th>			
			<th width="50%"><?=wfMsg('wikistats_title')?></th>			
			<th width="3%"><?=wfMsg('wikistats_title')?></th>			
			<th width="3%"><?=wfMsg('wikistats_unique_users')?></th>
			<th width="3%"><?=$wgLang->ucfirst(wfMsg('wikistats_edits'))?></th>
			<th width="3%"><?=wfMsg('wikistats_articles_text')?></th>
			<th width="15%"><?=wfMsg('wikistats_last_edit')?></th>
			<th width="1%">#</th>
			<th width="1%">#</th>
			<th width="1%">#</th>	
		</tr>		
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="8" class="dataTables_empty"><?=wfMsg('livepreview-loading')?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="2%">#</th>
			<th width="15%"><?=wfMsg('wikistats_database')?></th>			
			<th width="50%"><?=wfMsg('wikistats_title')?></th>			
			<th width="3%"><?=wfMsg('wikistats_title')?></th>			
			<th width="3%"><?=wfMsg('wikistats_unique_users')?></th>
			<th width="3%"><?=$wgLang->ucfirst(wfMsg('wikistats_edits'))?></th>
			<th width="3%"><?=wfMsg('wikistats_articles_text')?></th>
			<th width="15%"><?=wfMsg('wikistats_last_edit')?></th>
			<th width="1%">#</th>
			<th width="1%">#</th>
			<th width="1%">#</th>
		</tr>
	</tfoot>
</table>
<!-- END OF ACTIVITY -->
<!-- e:<?= __FILE__ ?> -->
