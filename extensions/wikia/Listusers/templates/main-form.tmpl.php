<script>
$( function () {

	function __makeParamValue() {
		var f = document.getElementById( 'lu-form' ),
			target = "",
			i;

		if ( f.lu_target && f.lu_target.length > 0 ) {
			for ( i = 0; i < f.lu_target.length; i++ ) {
				if ( f.lu_target[i].checked ) {
					target += f.lu_target[i].value + ",";
				}
			}
		}
		return target;
	}

	var baseurl = window.wgScript + "?action=ajax&rs=ListusersAjax::axShowUsers";

	// @see https://datatables.net/reference/option/ (jquery.dataTables.min.js v1.8.2)
	var oTable = $( '#lu-table' ).dataTable( {
		"oLanguage": {
			"sLengthMenu": "<?= wfMessage( 'table_pager_limit', '_MENU_' )->escaped() ?>",
			"sZeroRecords": "<?= wfMessage( 'table_pager_empty' )->escaped() ?>",
			"sEmptyTable": "<?= wfMessage( 'table_pager_empty' )->escaped() ?>",
			"sInfo": "<?= wfMessage('listusersrecordspager', '_START_', '_END_', '_TOTAL_')->parse() ?>",
			"sInfoEmpty": "<?= wfMessage( 'listusersrecordspager','0', '0', '0' )->parse() ?>",
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
		"sCookiePrefix" : "<?= $title ?>-wikia",
		"aLengthMenu": [[10, 25, 50], [10, 25, 50]],
		"sDom": '<"dttoolbar"><"top"flip>rt<"bottom"p><"clear">',
		"aoColumns": [
			{ "sName": "username" },
			{ "sName": "groups" },
			{ "sName": "revcnt" },
			{ "sName": "dtedit" }
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
			var limit = 30,
				offset = 0,
				groups = __makeParamValue(),
				loop = 1,
				order = '',
				sortingCols = 0,
				_tmp = [],
				columns = [],
				i;

			for ( i in aoData ) {
			    $.log(aoData[i], 'listusers');

				switch ( aoData[i].name ) {
					case 'sEcho':
						loop = aoData[i].value;
						break;
					case 'sColumns':
						columns = aoData[i].value.split( ',' );
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
				"type": "GET",
				"url": sSource,
				"data": [
					{
						'name': 'groups',
						'value': groups
					}, {
						'name': 'username',
						'value': ( $( '#lu_search' ).exists() ) ? $( '#lu_search' ).val() : '<?= addslashes( $defUser ) ?>'
					}, {
						'name': 'edits',
						'value' : ( $( '#lu_contributed' ).exists() ) ? $( '#lu_contributed' ).val() : <?= intval( $defContrib ) ?>
					}, {
						'name': 'limit',
						'value' : limit
					}, {
						'name': 'offset',
						'value' : offset
					}, {
						'name': 'loop',
						'value': loop
					}, {
						'name': 'order',
						'value': order
					}
				],
				"success": fnCallback
			} );
		}
	} );

	var toolbar = '<div class="lu_filter">';
	toolbar += '<span class="lu_filter lu_first"><?= wfMessage( 'listusersstartingtext' )->escaped() ?></span>';
	toolbar += '<span class="lu_filter"><input type="text" name="lu_search" id="lu_search" size="5" value="<?=$defUser?>"></span>';
	toolbar += '<span class="lu_filter lu_first"><?= wfMessage( 'listuserscontributed' )->escaped() ?></span>';
	toolbar += '<span class="lu_filter"><select name="lu_contributed" id="lu_contributed" >';
	<? foreach ( $obj->mContribs as $val => $text ) { ?>
		toolbar += '<option <?= ( $val == $defContrib ) ? "selected=\'selected\'" : "" ?> value="<?= $val ?>"><?= $text ?></option>';
	<? } ?>
	toolbar += '</select></span>';
	toolbar += '<span class="lu_filter"><input type="button" value="<?= wfMessage( 'listusersdetails' )->escaped() ?>" id="lu-showusers"></span></div>';

	$( 'div.dttoolbar' ).html( toolbar );
	$( '#lu-showusers' ).click( function () {
		oTable.fnDraw();
	} );
	$( '#lu-select-all' ).click( function () {
		var $this = $( this ),
			$checkbox = $( '.lu_target' );
		
		if ( $this.hasClass( 'lu-selected' ) ) {
			$checkbox.prop( 'checked', false );
			$this.removeClass( 'lu-selected' );
			$this.val( '<?= wfMessage( 'listusers-select-all' )->escaped() ?>' );
		} else {
			$checkbox.prop( 'checked', true );
			$this.addClass( 'lu-selected' );
			$this.val( '<?= wfMessage( 'listusers-deselect-all' )->escaped() ?>' );
		}
	} );
} );

</script>

<p class="error"><?= $error ?></p>
<div>
<form method="post" action="<?= $action ?>" id="lu-form">
<? $found = 0; ?>
<? if ( !empty( $obj->mGroups ) && ( !empty( $obj->mGroups ) ) ) { ?>
<fieldset class="lu_fieldset">
<legend><?= wfMessage( 'listusers-groups' )->escaped() ?></legend>
	<table><tr>
<?
	$i = 0;
	foreach ( $obj->mGroups as $groupName => $group ) {
		if ( $i > 0 && $i % 4 == 0 ) { ?> </tr><tr> <? }

		$found += ( isset($group['cnt'] ) ) ? intval( $group['cnt'] ) : 0;
		$groupLink = wfMessage( "Grouppage-{$groupName}" )->parse();
		$link = "";
		if ( !wfMessage( "Grouppage-{$groupName}", $groupLink )->inContentLanguage()->isBlank() ) {
			$sk = RequestContext::getMain()->getSkin();
			$link = $sk->link( $groupLink, $wgContLang->ucfirst( $group['name'] ), "" );
		} else {
			$groupLink = "";
			$link = $wgContLang->ucfirst( $group['name'] );
		}
		
		$checked = '';
		if ( count( $obj->mDefGroups ) === 0 || in_array( $groupName, $obj->mDefGroups ) ) {
			$checked = 'checked="checked"';
		}
?>
		<td valign="middle" style="padding:0px 2px 0px 1px;">
			<label for="checkBoxFor<?=$groupName?>">
				<span style="vertical-align:middle">
					<input type="checkbox" name="lu_target" class="lu_target" value="<?=$groupName?>" <?=$checked?> id="checkBoxFor<?=$groupName?>">
				</span>
				<span style="padding-bottom:5px;"><?= $link ?> <small>(<?= wfMessage( 'listuserscount', ( isset( $group['count'] ) ) ? intval($group['count']) : 0 )->parse() ?>)</small></span>
			</label>
		</td>
<?
		$i++;
	}
?>
		</tr>
		<tr><td colspan="4" style="text-align:right;"><input type="button" class="wikia-button lu-selected" id="lu-select-all" value="<?= wfMessage( 'listusers-deselect-all' )->escaped() ?>" /></td>
	</table>
</fieldset>
<? } ?>
</form>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lu-table">
	<thead>
		<tr>
			<th><?= wfMessage( 'listusers-username' )->escaped() ?></th>
			<th><?= wfMessage( 'listusers-groups' )->escaped() ?></th>
			<th><?= wfMessage( 'listusersrev-cnt' )->escaped() ?></th>
			<th><?= wfMessage( 'listusers-edited' )->escaped() ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="4" class="dataTables_empty"><?= wfMessage( 'livepreview-loading')->escaped() ?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th><?= wfMessage( 'listusers-username' )->escaped() ?></th>
			<th><?= wfMessage( 'listusers-groups' )->escaped() ?></th>
			<th><?= wfMessage( 'listusersrev-cnt' )->escaped() ?></th>
			<th><?= wfMessage( 'listusers-edited' )->escaped() ?></th>
		</tr>
	</tfoot>
</table>
