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
.TablePager {font-size:7.4pt;}
.TablePager td { padding:1px; }
.TablePager th a {font-weight:normal;}
</style>
<script type="text/javascript" charset="utf-8">

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=axAWCMetricsCategory";
	var cnt = 0;
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
		//"aaSorting": [[ 2, "asc" ]],
		"bProcessing": true,
		"bSort" : false,
		"bServerSide": true,
		"bFilter" : false,
		"aoColumnDefs": [ 
			{ 
				"fnRender": function ( oObj ) {
					var row = '<span style="white-space:nowrap;font-weight:bold;">' + oObj.aData[0] + '</span>';
					return row;
				},
				"bUseRendered": true,
				"aTargets": [ 0 ],
				"bSortable" : true
			},
			{ 
				"fnRender": function ( oObj ) {
					var row = '<span style="white-space:nowrap;font-weight:bold;">' + oObj.aData[oObj.aData.length-1] + '</span>';
					return row;
				},
				"bUseRendered": true,
				"aTargets": [ <?=count($aCategories)+1?> ],
				"bSortable" : true
			}
		],			
		"sPaginationType": "full_numbers",
		"sAjaxSource": baseurl,
		/*"fnInitComplete" : function ( oInstance, oSettings, json ) {
			// make CSS buttons
		},*/
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			var limit		= 30;
			var offset 		= 0;		
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
					{ 'name' : 'awc-daily', 	'value' : 0 },
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
} );

</script>

<p class='error'><?=$error?></p>
<div>
<? $found = 0; $i = 0; $isSelected = false; ?>	
<!-- options -->
	<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="wfm-table">
	<thead>
		<tr>
			<th width="10%">Month</th>
<? if ( count($aCategories) > 0 ) foreach ($aCategories as $id => $catName) : ?>
			<th width="<?=intval(80/count($aCategories))?>"><?=$catName['name']?></option>
<? endforeach ?>
			<th width="10%"><?=wfMsg('awc-metrics-sum-month')?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="<?= count($aCategories) + 2 ?>" class="dataTables_empty"><?=wfMsg('livepreview-loading')?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="10%">Month</th>
<? if ( count($aCategories) > 0 ) foreach ($aCategories as $id => $catName) : ?>
			<th width="<?=intval(80/count($aCategories))?>"><?=$catName['name']?></option>
<? endforeach ?>
			<th width="10%"><?=wfMsg('awc-metrics-sum-month')?></th>
		</tr>
	</tfoot>
	</table>
</div>

<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
