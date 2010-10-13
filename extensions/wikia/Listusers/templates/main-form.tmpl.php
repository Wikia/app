<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<script type="text/javascript" charset="utf-8">

function __makeParamValue() {
	var f = document.getElementById('lu-form');	
	var target = "";
	if (f.lu_target && f.lu_target.length > 0) {
		for ( i = 0; i < f.lu_target.length; i++ ) {
			if (f.lu_target[i].checked)
				target += f.lu_target[i].value + ",";
		}
	}
	return target;
}

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=ListusersAjax::axShowUsers";
				
	var oTable = $('#lu-table').dataTable( {
		"oLanguage": {
			"sLengthMenu": "<?=wfMsg('table_pager_limit', '_MENU_');?>",
			"sZeroRecords": "<?=wfMsg('table_pager_empty');?>",
			"sEmptyTable": "<?=wfMsg('table_pager_empty');?>",
			"sInfo": "<?=wfMsgExt('listusersrecordspager',  array('parseinline'), '_START_', '_END_', '_TOTAL_');?>",
			"sInfoEmpty": "<?=wfMsg('listusersrecordspager','0', '0', '0');?>",
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
		"sCookiePrefix" : "<?=$title?>-wikia",
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
			var limit		= 30;
			var offset 		= 0;		
			var groups	 	= __makeParamValue();
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
					{ 'name' : 'groups', 	'value' : groups },
					{ 'name' : 'username',	'value' : ( $('#lu_search').exists() ) ? $('#lu_search').val() : '' },
					{ 'name' : 'edits', 	'value' : ( $('#lu_contributed').exists() ) ? $('#lu_contributed').val() : <?=$defContrib?> },
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
	
	var toolbar = '<div class="lu_filter">';
	toolbar += '<span class="lu_filter lu_first"><?= wfMsg('listusersstartingtext') ?></span>';
	toolbar += '<span class="lu_filter"><input type="text" name="lu_search" id="lu_search" size="5"></span>';
	toolbar += '<span class="lu_filter lu_first"><?= wfMsg('listuserscontributed') ?></span>';
	toolbar += '<span class="lu_filter"><select name="lu_contributed" id="lu_contributed" >';
	<? foreach ($obj->mContribs as $val => $text) { ?>
		toolbar += '<option <?= ($val == $defContrib) ? "selected=\'selected\'" : "" ?> value="<?=$val?>"><?=$text?>';
	<? } ?>
	toolbar += '</select></span>';
	toolbar += '<span class="lu_filter"><input type="button" value="<?=wfMsg('listusersdetails')?>" id="lu-showusers"></span></div>';
	
	$("div.dttoolbar").html( toolbar );
	$('#lu-showusers').click( function() { oTable.fnDraw(); } );
} );

</script>

<p class='error'><?=$error?></p>
<div>
<form method="post" action="<?=$action?>" id="lu-form">
<? $found = 0; ?>
<? if ( !empty($obj->mGroups) && (!empty($obj->mGroups)) ) { ?>
<fieldset class="lu_fieldset">
<legend><?=wfMsg('listusers-groups')?></legend>
	<table><tr>
<? 
	$i = 0; 
	foreach ($obj->mGroups as $groupName => $group) {
		if ( $i > 0 && $i % 4 == 0) { ?> </tr><tr> <? } 

		$found += ( isset($group['cnt']) ) ? intval($group['cnt']) : 0;
		$groupLink = wfMsgExt("Grouppage-{$groupName}", array('parseinline') );
		$link = "";
		if ( !wfEmptyMsg("Grouppage-{$groupName}", $groupLink) ) {
			$sk = $wgUser->getSkin();
			$link = $sk->makeLink($groupLink, $wgContLang->ucfirst($group['name']), "");
		} else {
			$groupLink = "";
			$link = $wgContLang->ucfirst($group['name']);
		}
?>
		<td valign="middle" style="padding:0px 2px 0px 1px;">
			<span style="vertical-align:middle"><input type="checkbox" name="lu_target" id="lu_target" value="<?=$groupName?>" <?=(in_array($groupName, $obj->mDefGroups))?"checked=\"checked\"":''?>></span>
			<span style="padding-bottom:5px;"><?=$link?> <small>(<?=wfMsg('listuserscount', ( isset( $group['count'] ) ) ? intval($group['count']) : 0 )?>)</small></span>
		</td>
<? 		
		$i++; 
	} 
?>
		</tr>
	</table>
</fieldset>
<? } ?>
<!--<fieldset class="lu_fieldset">
<legend><?=wfMsg('listusers-options')?></legend>
	<div class="lu_filter">
		<span class="lu_filter lu_first"><?= wfMsg('listusersstartingtext') ?></span>
		<span class="lu_filter"><input type="text" name="lu_search" id="lu_search" size="5"></span>
		<span class="lu_filter lu_first"><?= wfMsg('listuserscontributed') ?></span>
		<span class="lu_filter"><select name="lu_contributed" id="lu_contributed" ><? foreach ($obj->mContribs as $val => $text) { ?><option <?= ($val == $defContrib) ? "selected='selected'" : "" ?> value="<?=$val?>"><?=$text?><? } ?></select></span>
		<span class="lu_filter"><input type="button" value="<?=wfMsg('listusersdetails')?>" id="lu-showusers"></span>
	</div>
</fieldset>-->
</form>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lu-table">
	<thead>
		<tr>
			<th width="45%"><?=wfMsg('listusers-username')?></th>
			<th width="15%"><?=wfMsg('listusers-groups')?></th>
			<th width="10%"><?=wfMsg('listusersrev-cnt')?></th>
			<th width="15%"><?=wfMsg('listusers-loggedin')?></th>
			<th width="15%"><?=wfMsg('listusers-edited')?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty"><?=wfMsg('livepreview-loading')?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="45%"><?=wfMsg('listusers-username')?></th>
			<th width="15%"><?=wfMsg('listusers-groups')?></th>
			<th width="5%"><?=wfMsg('listusersrev-cnt')?></th>
			<th width="15%"><?=wfMsg('listusers-loggedin')?></th>
			<th width="15%"><?=wfMsg('listusers-edited')?></th>
		</tr>
	</tfoot>
</table>

<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
