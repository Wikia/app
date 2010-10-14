<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<script type="text/javascript" charset="utf-8">
function lcShowDetails(dbname, mode) {
	var username = '<?=$username?>';
	var action = '<?=$action?>';
	//var sel_mode = '#lc-mode-' + dbname;
	//var mode = ( $(sel_mode).exists() ) ? $(sel_mode).val() : '';
					
	if ( !username ) {
		return false;
	}	
	
	document.location.href = action + '?target=' + username + '&wiki=' + dbname + '&mode=' + mode;
}

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=LookupContribsAjax::axData";
	var username = '<?=$username?>';
				
	if ( !username ) {
		return;
	}
	
	var oTable = $('#lc-table').dataTable( {
		"oLanguage": {
			"sLengthMenu": "<?=wfMsg('table_pager_limit', '_MENU_');?>",
			"sZeroRecords": "<?=wfMsg('table_pager_empty');?>",
			"sEmptyTable": "<?=wfMsg('table_pager_empty');?>",
			"sInfo": "<?=wfMsgExt('lookupcontribsrecordspager',  array('parseinline'), '_START_', '_END_', '_TOTAL_');?>",
			"sInfoEmpty": "<?=wfMsgExt('lookupcontribsrecordspager', array('parseinline'), '0', '0', '0');?>",
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
			{ "sName": "lastedit" },
			{ "sName": "options" }
		],
		"aoColumnDefs": [ 
			{ "bVisible": false,  "aTargets": [ 0 ], "bSortable" : false },
			{ "bVisible": false,  "aTargets": [ 1 ], "bSortable" : false },
			{ "bVisible": true,  "aTargets": [ 2 ], "bSortable" : false, "sClass": "lc-datetime" },			
			{
				"fnRender": function ( oObj ) {
					var row = '<span class="lc-row"><a href="' + oObj.aData[3] + '" target="new">' + oObj.aData[3] + '</a></span>';
					row += '&nbsp;(<a href="' + oObj.aData[3] + 'index.php?title=Special:Contributions/' + username + '" target="new">';
					row += '<?=wfMsg('lookupcontribscontribs')?>';
					row += '</a>)</span>';
					return row;
				},
				"aTargets": [ 3 ],
				"bSortable": false
			},
			{ "sClass": "lc-datetime", "aTargets": [ 4 ], "bSortable" : false },
			{
				"fnRender": function ( oObj ) {
					var row = '<div style="white-space:nowrap">';
<? $loop = 0; foreach ( $modes as $mode => $modeName ) : ?>						
					row += '(<a href="javascript:void(0)" onclick="lcShowDetails(\'' + oObj.aData[1] + '\', \'<?=$mode?>\');"><?=$modeName?></a>)';
<? if ( $loop < count($modes) - 1 ) : ?> row += ' &#183; '; <? endif ?>					
<? $loop++; endforeach ?> 
					row += '</div>';
					return row;
				},
				"aTargets": [ 5 ],
				"bSortable" : false 
			}
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
			
			for ( i in aoData ) {
				switch ( aoData[i].name ) {
					case 'iDisplayLength'	: limit = aoData[i].value; break;
					case 'iDisplayStart'	: offset = aoData[i].value; break;
					case 'sEcho'			: loop = aoData[i].value; break;
					case 'sColumns'			: columns = aoData[i].value.split(","); break;
					case 'iColumns'			: iColumns = aoData[i].value; break;
					case 'iSortingCols'		: sortingCols = aoData[i].value; break;
				}
			}
				
			$.ajax( {
				"dataType": 'json', 
				"type": "POST", 
				"url": sSource, 
				"data": [
					{ 'name' : 'username',	'value' : ( $('#lc_search').exists() ) ? $('#lc_search').val() : '' },
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
	
	//oTable.fnSetColumnVis( 0, false );
	//oTable.fnSetColumnVis( 1, false );
	
} );

</script>

<p class='error'><?=$error?></p>
<div>
<form method="post" action="<?=$action?>" id="lc-form">
<div class="lc_filter">
	<span class="lc_filter lc_first"><?= wfMsg('lookupcontribsselectuser') ?></span>
	<span class="lc_filter"><input type="text" name="target" id="lc_search" size="50" value="<?=$username?>"></span>
	<span class="lc_filter"><input type="button" value="<?=wfMsg('lookupcontribsgo')?>" id="lc-showuser" onclick="submit();"></span>
</div>
</form>
</div>
<? if ( $username ) { ?>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lc-table">
	<thead>
		<tr>
			<th width="2%">#</th>
			<th width="3%"><?=wfMsg('lookupcontribswikidbname')?></th>			
			<th width="35%"><?=wfMsg('lookupcontribswikititle')?></th>			
			<th width="20%"><?=wfMsg('lookupcontribswikiurl')?></th>
			<th width="20%" style="white-space:nowrap"><?=wfMsg('lookupcontribslastedited')?></th>
			<th width="20%"><?=wfMsg('lookupcontribscontribtitleforuser')?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="6" class="dataTables_empty"><?=wfMsg('livepreview-loading')?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="2%">#</th>
			<th width="3%"><?=wfMsg('lookupcontribswikidbname')?></th>			
			<th width="35%"><?=wfMsg('lookupcontribswikititle')?></th>			
			<th width="20%"><?=wfMsg('lookupcontribswikiurl')?></th>
			<th width="20%" style="white-space:nowrap"><?=wfMsg('lookupcontribslastedited')?></th>
			<th width="20%"><?=wfMsg('lookupcontribscontribtitleforuser')?></th>
		</tr>
	</tfoot>
</table>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
