<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<script type="text/javascript" charset="utf-8">
function lcShowDetails(dbname, mode) {
	var username = '<?= Xml::escapeJsString( $username ) ?>';
	var action = '<?= Xml::escapeJsString( $action ) ?>';
	//var sel_mode = '#lc-mode-' + dbname;
	//var mode = ( $(sel_mode).exists() ) ? $(sel_mode).val() : '';

	if ( !username ) {
		return false;
	}

	document.location.href = action + '?target=' + encodeURIComponent(username) + '&wiki=' + mw.html.escape( dbname ) + '&mode=' + mw.html.escape( mode );
}

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=LookupContribsAjax::axData";
	var username = '<?= Xml::escapeJsString( $username ) ?>';

	if ( !username ) {
		return;
	}

	var oTable = $('#lc-table').dataTable( {
		bAutoWidth: false,
		"oLanguage": {
			"sLengthMenu": "<?= wfMessage( 'table_pager_limit', '_MENU_' )->escaped() ?>",
			"sZeroRecords": "<?= wfMessage( 'table_pager_empty' )->escaped() ?>",
			"sEmptyTable": "<?= wfMessage( 'table_pager_empty' )->escaped() ?>",
			"sInfo": "<?= wfMessage('lookupcontribsrecordspager', '_START_', '_END_', '_TOTAL_' )->parse() ?>",
			"sInfoEmpty": "<?= wfMessage( 'lookupcontribsrecordspager', '0', '0', '0' )->parse() ?>",
			"sInfoFiltered": "",
			"sSearch": "<?= wfMessage( 'search' )->escaped() ?>",
			"sProcessing": "<img src='" + mw.html.escape( stylepath ) + "/common/images/ajax.gif' /> <?= wfMessage( 'livepreview-loading' )->escaped() ?>",
			"oPaginate" : {
				"sFirst": "<?= wfMessage( 'table_pager_first')->escaped() ?>",
				"sPrevious": "<?= wfMessage( 'table_pager_prev')->escaped() ?>",
				"sNext": "<?= wfMessage( 'table_pager_next')->escaped() ?>",
				"sLast": "<?= wfMessage( 'table_pager_last')->escaped() ?>"
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
			{ "bVisible": true,  "aTargets": [ 2 ], "bSortable" : true, "sClass": "lc-datetime", 'fnRender': function (oObj) {
				return mw.html.escape(oObj.aData[2]);
			} },
			{
				"fnRender": function ( oObj ) {
					var row = '<span class="lc-row"><a href="' + mw.html.escape(oObj.aData[3])+ '">' + mw.html.escape(oObj.aData[3]) + '</a></span>';
					row += '&nbsp;(<a href="' + mw.html.escape(oObj.aData[3]) + 'index.php?title=Special:Contributions/' + mw.html.escape(encodeURIComponent(username)) + '">';
					row += '<?= wfMessage( 'lookupcontribscontribs' )->escaped() ?>';
					row += '</a>)</span>';
					return row;
				},
				"aTargets": [ 3 ],
				"bSortable": true
			},
			{ "sClass": "lc-datetime", "aTargets": [ 4 ], "bSortable" : true },
			{
				"fnRender": function ( oObj ) {
					var row = '<div style="white-space:nowrap">';
<? $loop = 0; foreach ( $modes as $mode => $modeName ) : ?>
					row += '(<a href="javascript:void(0)" onclick="lcShowDetails(\'' + mw.html.escape(encodeURIComponent(oObj.aData[1])) + '\', \'<?= Sanitizer::encodeAttribute( $mode ) ?>\');"><?= htmlspecialchars( $modeName ) ?></a>)';
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

			var _tmp = new Array();
			var sortColumns = new Array();
			var sortOrder	= new Array();

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
					{ 'name' : 'username',	'value' : ( $('#lc_search').length ) ? $('#lc_search').val() : '' },
					{ 'name' : 'limit', 	'value' : limit },
					{ 'name' : 'offset',	'value' : offset },
					{ 'name' : 'loop',      'value' : loop },
					{ 'name' : 'numOrder',	'value' : sortingCols },
					{ 'name' : 'order',     'value' : order }
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
	<span class="lc_filter lc_first"><?= wfMessage( 'lookupcontribsselectuser' )->escaped() ?></span>
		<span class="lc_filter"><input type="text" name="target" id="lc_search" size="50" value="<?= Sanitizer::encodeAttribute( $username ) ?>"></span>
	<span class="lc_filter"><input type="button" value="<?= wfMessage( 'lookupcontribsgo' )->escaped() ?>" id="lc-showuser" onclick="submit();"></span>
</div>
</form>
</div>
<? if ( $username ) { ?>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lc-table">
	<thead>
		<tr>
			<th width="2%">#</th>
			<th width="3%"><?= wfMessage( 'lookupcontribswikidbname' )->escaped() ?></th>
			<th width="35%"><?= wfMessage( 'lookupcontribswikititle' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupcontribswikiurl' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupcontribslastedited' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupcontribscontribtitleforuser' )->escaped() ?></th>
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
			<th width="3%"><?= wfMessage( 'lookupcontribswikidbname' )->escaped() ?></th>
			<th width="35%"><?= wfMessage( 'lookupcontribswikititle' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupcontribswikiurl' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupcontribslastedited' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupcontribscontribtitleforuser' )->escaped() ?></th>
		</tr>
	</tfoot>
</table>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
