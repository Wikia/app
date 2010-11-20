<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<script type="text/javascript" charset="utf-8">
function mlShowDetails(dbname) {
	var username = '<?=$username?>';
	var action = '<?=$action?>';
					
	if ( !username ) {
		return false;
	}	
	
	document.location.href = action + '?target=' + username + '&wiki=' + dbname;
}

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=MultiLookupAjax::axData";
	var username = '<?=$username?>';
				
	if ( !username ) {
		return;
	}
	
	var oTable = $('#ml-table').dataTable( {
		"oLanguage": {
			"sLengthMenu": "<?=wfMsg('table_pager_limit', '_MENU_');?>",
			"sZeroRecords": "<?=wfMsg('table_pager_empty');?>",
			"sEmptyTable": "<?=wfMsg('table_pager_empty');?>",
			"sInfo": "<?=wfMsgExt('multilookuprecordspager',  array('parseinline'), '_START_', '_END_', '_TOTAL_');?>",
			"sInfoEmpty": "<?=wfMsgExt('multilookuprecordspager', array('parseinline'), '0', '0', '0');?>",
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
			{ "sName": "options" }
		],
		"aoColumnDefs": [ 
			{ "bVisible": true,  "aTargets": [ 0 ], "bSortable" : false },
			{ "fnRender": function ( oObj ) {
				var row = '<a href="'+ window.location.pathname + "?target="+ username +'&wiki=' + oObj.aData[1] + '">' + oObj.aData[1] + '</a>';
				return row;
			},
				"bUseRendered": false,
				"aTargets": [ 1 ],
				"bSortable" : false
			},
			{ "bVisible": true,  "aTargets": [ 2 ], "bSortable" : false, "sClass": "ml-datetime" },
			{ "bVisible": true,  "aTargets": [ 3 ], "bSortable" : false, "sClass": "ml-datetime" },
			{ "bVisible": true,  "aTargets": [ 4 ], "bSortable" : false, "sClass": "ml-datetime" },
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
					{ 'name' : 'username',	'value' : ( $('#ml_search').exists() ) ? $('#ml_search').val() : '' },
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
<form method="post" action="<?=$action?>" id="ml-form">
<div class="ml_filter">
	<span class="ml_filter ml_first"><?= wfMsg('multilookupselectuser') ?></span>
	<span class="ml_filter"><input type="text" name="target" id="ml_search" size="50" value="<?=$username?>"></span>
	<span class="ml_filter"><input type="button" value="<?=wfMsg('multilookupgo')?>" id="ml-showuser" onclick="submit();"></span>
</div>
</form>
</div>
<? if ( $username ) { ?>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="ml-table">
	<thead>
		<tr>
			<th width="2%">#</th>
			<th width="3%"><?=wfMsg('multilookupwikidbname')?></th>			
			<th width="45%"><?=wfMsg('multilookupwikititle')?></th>			
			<th width="30%"><?=wfMsg('multilookupwikiurl')?></th>
			<th width="20%"><?=wfMsg('multilookupdetails')?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty"><?=wfMsg('livepreview-loading')?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="2%">#</th>
			<th width="3%"><?=wfMsg('multilookupwikidbname')?></th>			
			<th width="45%"><?=wfMsg('multilookupwikititle')?></th>			
			<th width="30%"><?=wfMsg('multilookupwikiurl')?></th>
			<th width="20%"><?=wfMsg('multilookupdetails')?></th>
		</tr>
	</tfoot>
</table>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
