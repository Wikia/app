$(document).ready(function() {
	$('table#TrackedUsers tbody tr').click( function() {
		if ( $(this).hasClass('row_selected') ) {
			$(this).removeClass('row_selected');
		} else {
			$(this).addClass('row_selected');
		}
	} );
	var oTable = $('table#TrackedUsers').dataTable({
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": true,
		"bInfo": false,
		"bAutoWidth": false
	});
	
	var oTableNukeList = $('#PagesToNukeDT').dataTable({		
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": false,
		"bInfo": false,
		"bAutoWidth": false
	});
	
	$('#PagesToNukeDT').delegate('tbody tr', 'click', function() {
		oTableNukeList.fnDeleteRow(this);
	});

	
	$('#FetchContributions').click( function() {
		function fnGetSelected( oTableLocal ) {
			var aReturn = new Array();
			var aTrs = oTableLocal.fnGetNodes();
			for ( var i=0 ; i<aTrs.length ; i++ ) {
				if ( $(aTrs[i]).hasClass('row_selected') ) {
					aReturn.push( parseInt($('td:first-child',aTrs[i]).text()) );
				}
			}
			return aReturn;
		}
		var sel = fnGetSelected( oTable );
		$('#UserContributions').html('\
			<table class="" id="UserContributionsDT"> \
			<thead> \
				<th>Time</th> \
				<th>User</th> \
				<th>Action</th> \
				<th>Wiki</th> \
				<th>Page</th> \
				<th>Page NS</th> \
				<th>Bytes added</th> \
				<th>Revision</th> \
				<th>IP</th> \
			</thead> \
			<tbody> \
			</tbody> \
			</table> ');
		var oTableContribs = $('#UserContributionsDT').dataTable({
			"bPaginate": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": false,
			"bFilter": false,
			"bSort": true,
			"bInfo": true,
			"bLengthChange": true,
			"bAutoWidth": true,
			"aaSorting": [[0,'desc']],
			"bProcessing": true,	
			"bServerSide": true,
			"sAjaxSource": "/wikia.php?controller=AccountCreationTrackerExternalController&method=fetchContributionsDataTables&users=" + encodeURI(sel),
			"aoColumnsDefs": [ { "bVisible": false, "aTargets": [ 2 ] } ],
			"fnDrawCallback": function( oSettings ) {
				$('#UserContributionsDT .timeago').timeago();
				//setTimeout(oTableContribs.fnAdjustColumnSizing, 500);
			}
		});
		
		$('#UserContributionsDT').delegate('tbody tr', 'click', function() {
			var user_id = $('.user_id', this).text();
			var user_name = $('.user_name', this).text();
			var wiki_id = $('.wiki_id', this).text();
			var wiki_name = $('.wiki_name', this).text();
			var page_id = $('.page_id', this).text();
			var page_name = $('.page_name', this).text();
			var nuke_url = $('.wiki_name', this).attr('href');
			nuke_url += 'wikia.php?controller=AccountCreationTrackerExternalController&method=nukeContribs';
			nuke_url += '&user_id=' + user_id;
			nuke_url += '&wiki_id=' + wiki_id;
			nuke_url += '&page_id=' + page_id;
			if(user_id) {
				oTableNukeList.fnAddData([nuke_url,user_name,wiki_name,page_name,'---']);
			}
		});
		
	});

	
});

var ACT = {
	init: function() {
		$('#act-search-btn').bind('click', ACT.search);
	},

	search: function() {
		var username = $('#act-username').val();
		$('#act-form').submit();
	}
}

//on content ready
wgAfterContentAndJS.push( ACT.init );
