<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<script type="text/javascript" charset="utf-8">

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=LookupContribsAjax::axData";
	var username = '<?= Xml::escapeJsString( $username ) ?>';
	var mode = '<?= Xml::escapeJsString( $mode ) ?>';
	var wiki = '<?= Xml::escapeJsString( $wiki ) ?>';
	var nspace = '<?=  Xml::escapeJsString( $nspace ) ?>';

	if ( !username && !mode && !wiki ) {
		return;
	}

	var oTable = $('#lc-table').dataTable( {
		bAutoWidth: false,
		"oLanguage": {
			"sLengthMenu": "<?= wfMessage('table_pager_limit', '_MENU_')->escaped() ?>",
			"sZeroRecords": "<?= wfMessage('table_pager_empty')->escaped() ?>",
			"sEmptyTable": "<?= wfMessage('table_pager_empty')->escaped() ?>",
			"sInfo": "<?= wfMessage( 'lookupcontribsrecordspager' )->parse() ?>",
			"sInfoEmpty": "<?= wfMessage( 'lookupcontribsrecordspager' )->parse() ?>",
			"sInfoFiltered": "",
			"sSearch": "<?= wfMessage( 'search' )->escaped() ?>",
			"sProcessing": "<img src='" + mw.html.escape(stylepath) + "/common/images/ajax.gif' /> <?= wfMessage( 'livepreview-loading' )->escaped() ?>",
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
			{ "sName": "title" },
			{ "sName": "links" },
			{ "sName": "edit" }
		],
		"aoColumnDefs": [
			{ "bVisible": true,  "aTargets": [ 0 ], "bSortable" : false },
			{ "bVisible": true,  "aTargets": [ 1 ], "bSortable" : false },
			{ "bVisible": true,  "aTargets": [ 2 ], "bSortable" : false },
			{ "sClass": "lc-datetime", "bVisible": true,  "aTargets": [ 3 ], "bSortable" : false }
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
					{ 'name' : 'mode', 		'value' : ( $('#lc-mode').exists() ) ? mw.html.escape($('#lc-mode').val()) : mode },
					{ 'name' : 'ns',		'value' : ( $('#lc-nspace').exists() ) ? mw.html.escape($('#lc-nspace').val()) : -1 },
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

	var toolbar = '<div class="lc_toolbar">';
	//toolbar += '<span class="lc_toolbar lc_first"><?= wfMessage( 'show' )->escaped() ?>:</span>';
	toolbar += '<span class="lc_filter"><select name="lc-mode" id="lc-mode" class="small">';
<? foreach ( $modes as $mode => $modeName ) : ?>
	toolbar += '<option ' + ((mode == '<?= $mode ?>') ? 'selected' : '') + ' value="<?= Sanitizer::encodeAttribute( $mode ) ?>"><?= htmlspecialchars( $modeName ) ?></option>';
<? endforeach ?>
	toolbar += '</select></span>';

	toolbar += '<span class="lc_filter"><select id="lc-nspace" class="small">';
	toolbar += '<option value="-1"><?= wfMessage( 'allpages' )->escaped() ?></option>';
	toolbar += '<option value="-2"><?= wfMessage( 'lookupcontribsshowpages' )->params( wfMessage( 'lookupcontribscontent' )->escaped() ) ?></option>';
	toolbar += '<optgroup label="<?= wfMessage( 'allinnamespace' )->escaped() ?>">';
<? if ( !empty( $nspaces ) ) foreach ( $nspaces as $id => $nspace ) : if ( $id < 0 ) continue; ?>
	toolbar += '<option ' + ((nspace == <?=$id?>) ? 'selected' : '') + ' value="<?= Sanitizer::encodeAttribute( $id ) ?>"><?= ( $id != 0 ) ? $nspace : wfMessage( 'nstab-main' )->escaped() ?></option>';
<? endforeach ?>
	toolbar += '</optgroup></select>';
	toolbar += '</span>';

	toolbar += '<span class="lc_filter"><input type="button" value="<?= wfMessage( 'show' )->escaped() ?>" id="lc-showdata"></span></div>';

	$("div.dttoolbar").html( toolbar );
	$('#lc-showdata').click( function() { oTable.fnDraw(); } );

} );

</script>

<p class='error'><?=$error?></p>
<div>
<form method="post" action="<?=$action?>" id="lc-form">
<div class="lc_filter">
	<span class="lc_filter lc_first"><?= wfMessage( 'lookupcontribsselectuser' )->escaped() ?></span>
	<input type="text" name="target" id="lc_search" size="50" value="<?= Sanitizer::encodeAttribute( $username ) ?>"></span>
	<span class="lc_filter"><input type="button" value="<?= wfMessage( 'lookupcontribsgo' )->escaped() ?>" id="lc-showuser" onclick="submit();"></span>
</div>
</form>
</div>
<? if ( $username ) { ?>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lc-table">
	<thead>
		<tr>
			<th width="2%">#</th>
			<th width="58%"><?= wfMessage( 'lookupcontribswikititle' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupcontribswikioptions' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupcontribslastedited' )->escaped() ?></th>
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
			<th><?= wfMessage( 'lookupcontribswikititle' )->escaped() ?></th>
			<th><?= wfMessage( 'lookupcontribswikioptions' )->escaped() ?></th>
			<th><?= wfMessage( 'lookupcontribslastedited' )->escaped() ?></th>
		</tr>
	</tfoot>
</table>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
