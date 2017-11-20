<script>
// to be consumed by js/tables.js script
var listUsersLanguage = {
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
};


var listUserToolbar = '<div class="lu_filter">';
listUserToolbar += '<span class="lu_filter lu_first"><?= wfMessage( 'listuserbyname' )->escaped() ?></span>';
listUserToolbar += '<span class="lu_filter"><input type="text" name="lu_search" id="lu_search" size="25" value="<?=$searchByUser?>"></span>';
listUserToolbar += '<span class="lu_filter lu_first"><?= wfMessage( 'listuserscontributed' )->escaped() ?></span>';
listUserToolbar += '<span class="lu_filter"><select name="lu_contributed" id="lu_contributed" >';
<?php
/* @var array $contribs */
foreach ( $contribs as $val => $text ) { ?>
    listUserToolbar += '<option <?= ( $val == $defContrib ) ? "selected=\'selected\'" : "" ?> value="<?= $val ?>"><?= $text ?></option>';
<? } ?>
listUserToolbar += '</select></span>';
listUserToolbar += '<span class="lu_filter"><input type="button" value="<?= wfMessage( 'listusersdetails' )->escaped() ?>" id="lu-showusers"></span></div>';

$( function () {
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

<form id="lu-form">
<? $found = 0; ?>
<? if ( !empty( $groups ) ) { ?>
<fieldset class="lu_fieldset">
<legend><?= wfMessage( 'listusers-groups' )->escaped() ?></legend>
	<table><tr>
<?
	$i = 0;
	foreach ( $groups as $groupName => $group ) {
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
		/* @var array $filtered_group */
		if ( count( $filtered_group ) === 0 || in_array( $groupName, $filtered_group ) ) {
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

</form>