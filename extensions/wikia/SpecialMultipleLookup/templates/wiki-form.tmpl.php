<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<script type="text/javascript" charset="utf-8">

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=MultiLookupAjax::axData";
	var username = '<?= Xml::escapeJsString( $username ) ?>';
	var wiki = '<?= Xml::escapeJsString( $wiki ) ?>';

	if ( !username && !mode && !wiki ) {
		return;
	}

	var oTable = $('#ml-table').dataTable( {
		"oLanguage": {
			"sLengthMenu": "<?= wfMessage( 'table_pager_limit', '_MENU_' ) ?>",
			"sZeroRecords": "<?= wfMessage( 'table_pager_empty' ) ?>",
			"sEmptyTable": "<?= wfMessage( 'table_pager_empty' ) ?>",
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
		"sDom": '<"top"flip>r<"dttoolbar">t<"bottom"p><"clear">',
		"aoColumns": [
			{ "sName": "id" },
			{ "sName": "dbname" },
			{ "sName": "title" },
			{ "sName": "edit" }
		],
		"aoColumnDefs": [
			{ "bVisible": true,  "aTargets": [ 0 ], "bSortable" : false },
			{ "bVisible": true,  "aTargets": [ 1 ], "bSortable" : false },
			{ "bVisible": true,  "aTargets": [ 2 ], "bSortable" : false },
			{ "bVisible": true,  "aTargets": [ 3 ], "bSortable" : false }
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
					{ 'name' : 'username',	'value' : username },
					{ 'name' : 'wiki', 		'value' : wiki },
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
} );

</script>

<p class='error'><?=$error?></p>
<div>
<form method="post" action="<?=$action?>" id="ml-form">
<div class="lc_filter">
	<span class="lc_filter lc_first"><?= wfMessage( 'multilookupselectuser' )->escaped() ?></span>
	<span class="lc_filter"><input type="text" name="target" id="ml_search" size="50" value="<?= Sanitizer::encodeAttribute( $username ) ?>"></span>
	<span class="lc_filter"><input type="button" value="<?= wfMessage( 'multilookupgo' )->escaped() ?>" id="ml-showuser" onclick="submit();"></span>
</div>
</form>
</div>
<? if ( $username ) { ?>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="ml-table">
	<thead>
		<tr>
			<th width="2%">#</th>
			<th width="18%"><?= wfMessage( 'multilookupwikidbname' )->escaped() ?></th>
			<th width="35%"><?= wfMessage( 'multilookupwikititle' )->escaped() ?></th>
			<th width="45%"><?= wfMessage( 'multilookuplastedithdr' )->escaped() ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="4" class="dataTables_empty"><?= wfMessage( 'livepreview-loading' )->escaped() ?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="2%">#</th>
			<th width="18%"><?= wfMessage( 'multilookupwikidbname' )->escaped() ?></th>
			<th width="35%"><?= wfMessage( 'multilookupwikititle' )->escaped() ?></th>
			<th width="45%"><?= wfMessage( 'multilookuplastedithdr' )->escaped() ?></th>
		</tr>
	</tfoot>
</table>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
