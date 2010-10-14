<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<script type="text/javascript" charset="utf-8">

$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=LookupContribsAjax::axData";
	var username = '<?=$username?>';
	var mode = '<?=$mode?>';
	var wiki = '<?=$wiki?>';
	var nspace = '<?=$nspace?>';
				
	if ( !username && !mode && !wiki ) {
		return;
	}
	
	var oTable = $('#lc-table').dataTable( {
		"oLanguage": {
			"sLengthMenu": "<?=wfMsg('table_pager_limit', '_MENU_');?>",
			"sZeroRecords": "<?=wfMsg('table_pager_empty');?>",
			"sEmptyTable": "<?=wfMsg('table_pager_empty');?>",
			"sInfo": "<?=wfMsgExt('lookupcontribsrecordspager',  array('parseinline'), '_START_', '_END_', '_TOTAL_');?>",
			"sInfoEmpty": "<?=wfMsgExt('lookupcontribsrecordspager', array('parseinline'), '0', '0', '0');?>",
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
		"aaSorting" : [],
		"iDisplayLength" : 25,
		"aLengthMenu": [[25, 50, 100, 250], [25, 50, 100, 250]],
		"sDom": '<"top"flip>r<"dttoolbar">t<"bottom"p><"clear">',
		"aoColumns": [
			{ "sName": "id" },
			{ "sName": "title" },			
			{ "sName": "diff" },
			{ "sName": "history" },
			{ "sName": "contribution" },						
			{ "sName": "edit" },
		],
		"aoColumnDefs": [ 
			{ "bVisible": true,  "aTargets": [ 0 ], "bSortable" : false },
			{ "bVisible": true,  "aTargets": [ 1 ], "bSortable" : false },
			{ "bVisible": true,  "aTargets": [ 2 ], "bSortable" : false },
			{ "bVisible": true,  "aTargets": [ 3 ], "bSortable" : false },			
			{ "bVisible": true,  "aTargets": [ 4 ], "bSortable" : false },			
			{ "bVisible": true,  "aTargets": [ 5 ], "bSortable" : false }
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
					{ 'name' : 'mode', 		'value' : ( $('#lc-mode').exists() ) ? $('#lc-mode').val() : mode },
					{ 'name' : 'ns',		'value' : ( $('#lc-nspace').exists() ) ? $('#lc-nspace').val() : -1 },
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
	//toolbar += '<span class="lc_toolbar lc_first"><?=wfMsg('show')?>:</span>';
	toolbar += '<span class="lc_filter"><select name="lc-mode" id="lc-mode" class="small">';
<? foreach ( $modes as $mode => $modeName ) : ?>					
	toolbar += '<option ' + ((mode == '<?=$mode?>')?'selected="true"':'') + ' value="<?=$mode?>"><?=$modeName?></option>';
<? endforeach ?>
	toolbar += '</select></span>';	
	
	toolbar += '<span class="lc_filter"><select id="lc-nspace" class="small">';
	toolbar += '<option value="-1"><?=wfMsg('allpages')?></option>';
	toolbar += '<option value="-2"><?=wfMsgExt('lookupcontribsshowpages', array(), wfMsg('lookupcontribscontent') )?></option>';
	toolbar += '<optgroup label="<?=wfMsgExt('allinnamespace', array(), "")?>">';
<? if ( !empty($nspaces) ) foreach ($nspaces as $id => $nspace) : if ( $id < 0 ) continue; ?>	
	toolbar += '<option ' + ((nspace == <?=$id?>)?'selected="true"':'') + ' value="<?=$id?>"><?=( $id != 0 ) ? $nspace : wfMsg('nstab-main')?></option>';
<? endforeach ?>
	toolbar += '</optgroup></select>';
	toolbar += '</span>';

	toolbar += '<span class="lc_filter"><input type="button" value="<?=wfMsg('show')?>" id="lc-showdata"></span></div>';
	
	$("div.dttoolbar").html( toolbar );
	$('#lc-showdata').click( function() { oTable.fnDraw(); } );
	
} );

</script>

<p class='error'><?=$error?></p>
<div>
<form method="post" action="<?=$action?>" id="lc-form">
<div class="lc_filter">
	<span class="lc_filter lc_first"><?= wfMsg('lookupcontribsselectuser') ?></span>
	<span class="lc_filter"><input type="text" name="lc_search" id="lc_search" size="50" value="<?=$username?>"></span>
	<span class="lc_filter"><input type="button" value="<?=wfMsg('lookupcontribsgo')?>" id="lc-showuser"></span>
</div>
</form>
</div>
<? if ( $username ) { ?>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lc-table">
	<thead>
		<tr>
			<th width="2%">#</th>
			<th width="65%"><?=wfMsg('lookupcontribswikititle')?></th>			
			<th width="18%" colspan="3"><?=wfMsg('lookupcontribswikioptions')?></th>			
			<th width="15%" style="white-space:nowrap"><?=wfMsg('lookupcontribslastedited')?></th>
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
			<th><?=wfMsg('lookupcontribswikititle')?></th>			
			<th colspan="3"><?=wfMsg('lookupcontribswikioptions')?></th>			
			<th style="white-space:nowrap"><?=wfMsg('lookupcontribslastedited')?></th>
		</tr>
	</tfoot>
</table>
<? } ?>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
