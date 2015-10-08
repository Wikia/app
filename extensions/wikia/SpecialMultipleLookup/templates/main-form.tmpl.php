<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<script type="text/javascript" charset="utf-8">
function mlShowDetails(dbname) {
	var username = '<?= Xml::escapeJsString( $username ) ?>';
	var action = '<?= Xml::escapeJsString( $action ) ?>';

	if ( !username ) {
		return false;
	}

	document.location.href = action + '?target=' + username + '&wiki=' + dbname;
}

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=MultiLookupAjax::axData";
	var username = '<?= Xml::escapeJsString( $username ) ?>';

	if ( !username ) {
		return;
	}

	var oTable = $('#ml-table').dataTable( {
		"oLanguage": {
			"sLengthMenu": "<?= wfMessage( 'table_pager_limit', '_MENU_' )->escaped() ?>",
			"sZeroRecords": "<?= wfMessage( 'table_pager_empty' )->escaped() ?>",
			"sEmptyTable": "<?= wfMessage( 'table_pager_empty' )->escaped() ?>",
			"sInfo": "<?= wfMessage( 'multilookuprecordspager' )->parse() ?>",
			"sInfoEmpty": "<?= wfMessage( 'multilookuprecordspager' )->parse() ?>",
			"sInfoFiltered": "",
			"sSearch": "<?= wfMessage( 'search' )->escaped() ?>",
			"sProcessing": "<img src='" + stylepath + "/common/images/ajax.gif' /> <?= wfMessage( 'livepreview-loading' )->escaped() ?>",
			"oPaginate" : {
				"sFirst": "<?= wfMessage( 'table_pager_first' )->escaped() ?>",
				"sPrevious": "<?= wfMessage( 'table_pager_prev' )->escaped() ?>",
				"sNext": "<?= wfMessage( 'table_pager_next' )->escaped() ?>",
				"sLast": "<?= wfMessage( 'table_pager_last' )->escaped() ?>"
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
			{ "bVisible": true,  "aTargets": [ 0 ], "bSortable" : false },
			{ "fnRender": function ( oObj ) {
				var row = '<a href="'+ window.location.pathname + "?target="+ mw.html.escape( username ) +'&wiki=' + mw.html.escape( oObj.aData[1] ) + '">' + mw.html.escape( oObj.aData[1] ) + '</a>';
				return row;
			},
				"bUseRendered": false,
				"aTargets": [ 1 ],
				"bSortable" : false
			},
			{ "bVisible": true,  "aTargets": [ 2 ], "bSortable" : false },
			{ "fnRender": function ( oObj ) {
				var row = '<a href="'+ mw.html.escape( oObj.aData[3] ) + '">' + mw.html.escape( oObj.aData[3] ) + '</a>';
				return row;
			},
				"bUseRendered": false,
				"aTargets": [ 3 ],
				"bSortable" : false,
			},
			{ "sClass": "ml-datetime", "aTargets": [ 4 ], "bSortable" : true },
			{ "bVisible": true,  "aTargets": [ 5 ], "bSortable" : false },
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
			var	limit		= 25,
				offset 		= 0,
				groups	 	= 0,
				loop		= 1,
				order 		= '',
				sortingCols = 0,
				iColumns	= 0,
				_tmp		= [],
				sortColumns	= [],
				sortOrder	= [];

			for ( i in aoData ) {
				switch ( aoData[i].name ) {
					case 'iDisplayLength'	: limit = aoData[i].value; break;
					case 'iDisplayStart'	: offset = aoData[i].value; break;
					case 'sEcho'			: loop = aoData[i].value; break;
					case 'sColumns'			: columns = aoData[i].value.split(","); break;
					case 'iColumns'			: iColumns = aoData[i].value; break;
					case 'iSortingCols'		: sortingCols = aoData[i].value; break;
				}

				if ( aoData[i].name.indexOf( 'iSortCol_', 0) !== -1 ) {
					sortColumns.push(aoData[i].value);
				}

				if ( aoData[i].name.indexOf( 'sSortDir_', 0) !== -1 ) {
					sortOrder.push(aoData[i].value);
				}
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
	<span class="ml_filter ml_first"><?= wfMessage( 'multilookupselectuser' )->escaped() ?></span>
	<span class="ml_filter"><input type="text" name="target" id="ml_search" size="50" value="<?= Sanitizer::encodeAttribute( $username ) ?>"></span>
	<span class="ml_filter"><input type="button" value="<?= wfMessage( 'multilookupgo' )->escaped() ?>" id="ml-showuser" onclick="submit();"></span>
</div>
</form>
</div>
<? if ( $username ) { ?>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="ml-table">
	<thead>
		<tr>
			<th width="2%">#</th>
			<th width="3%"><?= wfMessage( 'multilookupwikidbname' )->escaped() ?></th>
			<th width="40%"><?= wfMessage( 'multilookupwikititle' )->escaped() ?></th>
			<th width="30%"><?= wfMessage( 'multilookupwikiurl' )->escaped() ?></th>
			<th width="5%"><?= wfMessage(  'multilookuplastedithdr' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'multilookupdetails' )->escaped() ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="6" class="dataTables_empty"><?= wfMessage( 'livepreview-loading' )->escaped() ?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="2%">#</th>
			<th width="3%"><?= wfMessage( 'multilookupwikidbname' )->escaped() ?></th>
			<th width="40%"><?= wfMessage( 'multilookupwikititle' )->escaped() ?></th>
			<th width="30%"><?= wfMessage( 'multilookupwikiurl' )->escaped() ?></th>
			<th width="5%"><?= wfMessage(  'multilookuplastedithdr' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'multilookupdetails' )->escaped() ?></th>
		</tr>
	</tfoot>
</table>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
