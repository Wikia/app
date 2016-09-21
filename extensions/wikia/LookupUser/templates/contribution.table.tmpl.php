<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	var baseurl = wgScript + "?action=ajax&rs=LookupContribsAjax::axData&lookupUser=1";
	var username = '<?= Xml::escapeJsString( $username ) ?>';

	if ( !username ) {
		return;
	}

	var ajaxRequests = [];

	var oTable = $('#lookupuser-table').dataTable( {
		bAutoWidth: false,
		oLanguage: {
			sLengthMenu: "<?= wfMessage( 'table_pager_limit', '_MENU_' )->escaped() ?>",
			sZeroRecords: "<?= wfMessage( 'table_pager_empty' )->escaped() ?>",
			sEmptyTable: "<?= wfMessage( 'table_pager_empty' )->escaped() ?>",
			sInfo: "<?= wfMessage( 'lookupuser-table-recordspager' )->parse() ?>",
			sInfoEmpty: "<?= wfMessage( 'lookupuser-table-recordspager' )->parse() ?>",
			sInfoFiltered: "",
			sSearch: "<?= wfMessage( 'search' )->escaped() ?>",
			sProcessing: "<img src='" + stylepath + "/common/images/ajax.gif' /> <?= wfMessage( 'livepreview-loading' )->escaped() ?>",
			oPaginate : {
				sFirst: "<?= wfMessage( 'table_pager_first' )->escaped() ?>",
				sPrevious: "<?= wfMessage( 'table_pager_prev' )->escaped() ?>",
				sNext: "<?= wfMessage( 'table_pager_next' )->escaped() ?>",
				sLast: "<?= wfMessage( 'table_pager_last' )->escaped() ?>"
			}
		},
		aaSorting : [],
		iDisplayLength : 25,
		aLengthMenu: [[25, 50, 100, 250], [25, 50, 100, 250]],
		sDom: '<"dttoolbar"><"top"flip>rt<"bottom"p><"clear">',
		aoColumns: [
			{ sName: "id" },
			{ sName: "title" },
			{ sName: "url" },
			{ sName: "lastedit" },
			{ sName: "edits" },
			{ sName: "userrights" },
			{ sName: "blocked" }
		],
		aoColumnDefs: [
			{ bVisible: false, aTargets: [0], bSortable: true },
			{ bVisible: true,  aTargets: [1], bSortable: true },
			{
				fnRender: function ( oObj ) {
					var row = '<span class="lc-row"><a href="' + mw.html.escape( oObj.aData[2] ) + '">' + mw.html.escape( oObj.aData[2] ) + '</a></span>';
					row += '&nbsp;(<a href="' + mw.html.escape( oObj.aData[2] ) + 'index.php?title=Special:Contributions/' + mw.html.escape( username ) + '">';
					row += '<?= wfMessage( 'lookupuser-table-contribs' )->escaped() ?>';
					row += '</a>)</span>';
					return row;
				},
				aTargets: [2],
				bSortable: true
			},
			{ bVisible: true, aTargets: [3], bSortable: true },
			{ bVisible: true, aTargets: [4], bSortable: true },
			{ bVisible: true, aTargets: [5], bSortable: false },
			{ bVisible: true, aTargets: [6], bSortable: false }
		],
		bProcessing: true,
		bServerSide: true,
		bFilter: false,
		sPaginationType: "full_numbers",
		sAjaxSource: baseurl,
		fnServerData: function ( sSource, aoData, fnCallback ) {
			var limit = 25;
			var offset = 0;
			var groups = 0;
			var loop = 1;
			var order = '';

			var sortingCols = 0;
			var _tmp = new Array();
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

			$.ajax({
				dataType: 'json',
				type: "POST",
				url: sSource,
				data: [
					{ name: 'username', value: ( $('#lu_name').length ) ? $('#lu_name').val() : '' },
					{ name: 'limit', value: limit },
					{ name: 'offset', value: offset },
					{ name: 'loop', value: loop },
					{ name: 'numOrder', value: sortingCols },
					{ name: 'order', value: order }
				],
				success: function(json) {
					fnCallback(json);

					//taking care of data from cache
					$('.user-blocked').each(function(){
						$(this).parent().parent().find('td').each(function(){
							$(this).addClass('red-background');
						});
					});

					//changing placeholders with ajax loading gifs
					$('.user-groups-placeholder').each(function(){
						var self = $(this);
						var wikiId = parseInt( self.find('input.wikiId').val() );
						var url = self.find('input.wikiUrl').val();
						var username = self.find('input.name').val();

						try {
							var ajaxRequest = $.ajax({
								dataType: 'json',
								type: "POST",
								data: {
									url: url,
									username: username,
									id: wikiId,
								},
								url: wgScript + "?action=ajax&rs=LookupUserPage::requestApiAboutUser",
								success: function(res) {
									var blockedInfo = $('.user-blocked-placeholder-' + wikiId);

									if( res.success === true && typeof(res.data) !== 'undefined') {
										self.hide();

										//user's group data
										if( res.data.groups === false ) {
											self.parent().append('-');
										} else {
											self.parent().append( res.data.groups.join(', ') );
										}

										//user's block data
										blockedInfo.hide();
										switch(res.data.blocked) {
											case true: var blockedInfoTd = blockedInfo.parent();
														blockedInfoTd.append('Y');
														blockedInfoTd.parent().find('td').each(function(){
															$(this).addClass('red-background');
														});
														break;
											case false: blockedInfo.parent().append('N'); break;
										}
									} else {
										self.hide();
										self.parent().append('-');

										blockedInfo.hide();
										blockedInfo.parent().append('-');
									}
								}
							});

							ajaxRequests.push(ajaxRequest);
						} catch(e) {
							$().log('Exception');
							$().log(e);
						}
					});

					$('.paginate_button').click(function(){
						for(i in ajaxRequests) {
							ajaxRequests[i].abort();
						}
						ajaxRequests = [];
					});
				}
			});
		}
	});
});
</script>

<input id="lu_name" type="hidden" value="<?= Sanitizer::encodeAttribute( $username ) ?>" />

<ul>
<?php if( $isUsernameGloballyBlocked ) { ?>
	<li><?= Linker::link(
		GlobalTitle::newFromText( 'Phalanx/test', NS_SPECIAL, WikiFactory::COMMUNITY_CENTRAL ),
		wfMessage( 'lookupuser-username-blocked-globally' )->parse(),
		[],
		[
			'wpBlockText' => Sanitizer::encodeAttribute( $username ),
		]
	) ?></li>
<?php } else { ?>
	<li><?= wfMessage( 'lookupuser-username-not-blocked-globally' )->parse() ?></li>
<?php }?>
</ul>

<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lookupuser-table">
	<thead>
		<tr>
			<th width="2%">#</th>
			<th width="25%"><?= wfMessage( 'lookupuser-table-title' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupuser-table-url' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupuser-table-lastedited' )->escaped() ?></th>
			<th width="15%"><?= wfMessage( 'lookupuser-table-editcount' )->escaped() ?></th>
			<th width="15%"><?= wfMessage( 'lookupuser-table-userrights' )->escaped() ?></th>
			<th width="3%"><?= wfMessage( 'lookupuser-table-blocked' )->escaped() ?></th>
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
			<th width="25%"><?= wfMessage( 'lookupuser-table-title' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupuser-table-url' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'lookupuser-table-lastedited' )->escaped() ?></th>
			<th width="15%"><?= wfMessage( 'lookupuser-table-editcount' )->escaped() ?></th>
			<th width="15%"><?= wfMessage( 'lookupuser-table-userrights' )->escaped() ?></th>
			<th width="3%"><?= wfMessage( 'lookupuser-table-blocked' )->escaped() ?></th>
		</tr>
	</tfoot>
</table>
