<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<script type="text/javascript" charset="utf-8">
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

	var baseurl = wgScript + "?action=ajax&rs=ListusersAjax::axShowUsers";

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
			{ "sName": "loggedin" },
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
				_tmpDesc = [],
				columns = [],
				sortColumns = [],
				sortOrder = [],
				iColumns = 0;

			for ( i in aoData ) {
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
						'name': 'numOrder',
						'value': sortingCols
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
			$checkbox.removeAttr( 'checked' );
			$this.removeClass( 'lu-selected' );
			$this.val( '<?= wfMessage( 'listusers-select-all' )->escaped() ?>' );
		} else {
			$checkbox.attr( 'checked', 'checked' );
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
?>
		<td valign="middle" style="padding:0px 2px 0px 1px;">
			<span style="vertical-align:middle"><input type="checkbox" name="lu_target" class="lu_target" value="<?=$groupName?>" <?=( in_array( $groupName, $obj->mDefGroups ) )?"checked=\"checked\"":''?>></span>
			<span style="padding-bottom:5px;"><?= $link ?> <small>(<?= wfMessage( 'listuserscount', ( isset( $group['count'] ) ) ? intval($group['count']) : 0 )->parse() ?>)</small></span>
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
<!--<fieldset class="lu_fieldset">
<legend><?= wfMessage( 'listusers-options' )->escaped() ?></legend>
	<div class="lu_filter">
		<span class="lu_filter lu_first"><?= wfMessage( 'listusersstartingtext' )->escaped() ?></span>
		<span class="lu_filter"><input type="text" name="lu_search" id="lu_search" size="5"></span>
		<span class="lu_filter lu_first"><?= wfMessage( 'listuserscontributed' )->escaped() ?></span>
		<span class="lu_filter"><select name="lu_contributed" id="lu_contributed" ><? foreach ( $obj->mContribs as $val => $text ) { ?><option <?= ( $val == $defContrib ) ? "selected='selected'" : "" ?> value="<?= $val ?>"><?= $text ?><? } ?></select></span>
		<span class="lu_filter"><input type="button" value="<?= wfMessage( 'listusersdetails' )->escaped() ?>" id="lu-showusers"></span>
	</div>
</fieldset>-->
</form>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lu-table">
	<thead>
		<tr>
			<th width="45%"><?= wfMessage( 'listusers-username' )->escaped() ?></th>
			<th width="15%"><?= wfMessage( 'listusers-groups' )->escaped() ?></th>
			<th width="10%"><?= wfMessage( 'listusersrev-cnt' )->escaped() ?></th>
			<th width="15%"><?= wfMessage( 'listusers-loggedin' )->escaped() ?></th>
			<th width="15%"><?= wfMessage( 'listusers-edited' )->escaped() ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty"><?= wfMessage( 'livepreview-loading')->escaped() ?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="45%"><?= wfMessage( 'listusers-username' )->escaped() ?></th>
			<th width="15%"><?= wfMessage( 'listusers-groups' )->escaped() ?></th>
			<th width="5%"><?= wfMessage( 'listusersrev-cnt' )->escaped() ?></th>
			<th width="15%"><?= wfMessage( 'listusers-loggedin' )->escaped() ?></th>
			<th width="15%"><?= wfMessage( 'listusers-edited' )->escaped() ?></th>
		</tr>
	</tfoot>
</table>

<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
