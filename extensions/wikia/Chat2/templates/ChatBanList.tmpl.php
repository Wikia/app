<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<script type="text/javascript" charset="utf-8">
$( function () {

	var baseurl = wgScript + "?action=ajax&rs=ChatBanListAjax::axShowUsers";
	var loaderIcon = "<img src='" + stylepath + "/common/images/ajax.gif' />";
	var oTable = $( '#lu-table' ).dataTable( {
		"oLanguage": {
			"sLengthMenu": "<?= wfMessage( 'table_pager_limit', '_MENU_' )->escaped() ?>",
			"sZeroRecords": "<?= wfMessage( 'table_pager_empty' )->escaped() ?>",
			"sEmptyTable": "<?= wfMessage( 'table_pager_empty' )->escaped() ?>",
			"sInfo": "<?= wfMessage('listusersrecordspager', '_START_', '_END_', '_TOTAL_')->parse() ?>",
			"sInfoEmpty": "<?= wfMessage( 'listusersrecordspager','0', '0', '0' )->parse() ?>",
			"sInfoFiltered": "",
			"sSearch": "<?= wfMessage( 'search' )->escaped() ?>",
			"sProcessing": loaderIcon + "<?= wfMessage( 'livepreview-loading' )->escaped() ?>",
			"oPaginate" : {
				"sFirst": "<?= wfMessage( 'table_pager_first' )->escaped() ?>",
				"sPrevious": "<?= wfMessage( 'table_pager_prev' )->escaped() ?>",
				"sNext": "<?= wfMessage( 'table_pager_next' )->escaped() ?>",
				"sLast": "<?= wfMessage( 'table_pager_last' )->escaped() ?>"
			}
		},
		"sCookiePrefix" : "<?= $title ?>-wikia",
		"aLengthMenu": [[10, 25, 50], [10, 25, 50]],
		"sDom": '<"dttoolbar"><"top"flip>rt<"bottom"p><"clear">',
		"aoColumns": [
			{ "sName": "timestamp" },
			{ "sName": "target" },
			{ "sName": "expires" },
			{ "sName": "blockedBy" },
			{ "sName": "reason" , "asSorting": false }
		],
		"aoColumnDefs": [
			{"asSorting": ["desc", "asc"], "aTargets": [0]},
			{"bSortable": false, "aTargets": [-1]},
			{"bSearchable": false, "aTargets": [-1]}
		],
		"bProcessing": true,
		"bServerSide": true,
		"bFilter" : false,
		"sPaginationType": "full_numbers",
		"sAjaxSource": baseurl,
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			var limit = 30,
				offset = 0,
				loop = 1,
				order = '',
				sortingCols = 0,
				_tmp = [],
				columns = [],
				sortColumns = [],
				sortOrder = [],
				iColumns = 0;

			for ( var i in aoData ) {
				switch ( aoData[i].name ) {
					case 'iDisplayLength':
						limit = aoData[i].value;
						break;
					case 'iDisplayStart':
						offset = aoData[i].value;
						break;
					case 'sEcho':
						loop = aoData[i].value;
						break;
					case 'sColumns':
						columns = aoData[i].value.split( ',' );
						break;
					case 'iColumns':
						iColumns = aoData[i].value;
						break;
					case 'iSortingCols':
						sortingCols = aoData[i].value;
						break;
				}

				if ( aoData[i].name.indexOf( 'iSortCol_', 0 ) !== -1 )
					sortColumns.push( aoData[i].value );

				if ( aoData[i].name.indexOf( 'sSortDir_', 0 ) !== -1 )
					sortOrder.push( aoData[i].value );
			}

			if ( sortingCols > 0 ) {
				for ( i = 0; i < sortingCols; i++ ) {
					var info = columns[sortColumns[i]] + ":" + sortOrder[i];
					_tmp.push(info);
				}
				order = _tmp.join( '|' );
			}

			$.ajax( {
				"dataType": 'json',
				"type": "POST",
				"url": sSource,
				"data": [
					{
						'name': 'username',
						'value': $( '#lu_search' ).val()
					},
					{
						'name': 'limit',
						'value' : limit
					},
					{
						'name': 'offset',
						'value' : offset
					},
					{
						'name': 'loop',
						'value': loop
					},
					{
						'name': 'numOrder',
						'value': sortingCols
					},
					{
						'name': 'order',
						'value': order
					}
				],
				"success": fnCallback
			} );
		}
	} );

	$( '#lu-showusers' ).click( function () {
		oTable.fnDraw();
	} );
} );

</script>

<div class="lu_filter">
	<span class="lu_filter lu_first"><?= wfMessage( 'username' )->escaped() ?></span>
	<span class="lu_filter">
		<input type="text" name="lu_search" id="lu_search" size="10" >
	</span>
	<span class="lu_filter">
		<input type="button" value="<?= wfMessage( 'ipblocklist-submit' )->escaped() ?>" id="lu-showusers">
	</span>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lu-table">
	<thead>
		<tr>
			<th width="19%"><?= wfMessage( 'blocklist-timestamp' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'blocklist-target' )->escaped() ?></th>
			<th width="19%"><?= wfMessage( 'blocklist-expiry' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'blocklist-by' )->escaped() ?></th>
			<th width="22%"><?= wfMessage( 'blocklist-reason' )->escaped() ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty"><?= wfMessage( 'livepreview-loading')->escaped() ?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="19%"><?= wfMessage( 'blocklist-timestamp' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'blocklist-target' )->escaped() ?></th>
			<th width="19%"><?= wfMessage( 'blocklist-expiry' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'blocklist-by' )->escaped() ?></th>
			<th width="22%"><?= wfMessage( 'blocklist-reason' )->escaped() ?></th>
		</tr>
	</tfoot>
</table>

<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
