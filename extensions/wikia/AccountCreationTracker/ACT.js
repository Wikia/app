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
		$('#UserContributionsDT').dataTable({
			"bPaginate": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": false,
			"bFilter": false,
			"bSort": true,
			"bInfo": true,
			"bLengthChange": true,
			"bAutoWidth": false,
			"aaSorting": [[0,'desc']],
			"bProcessing": true,	
			"bServerSide": true,
			"sAjaxSource": "/wikia.php?controller=AccountCreationTrackerExternalController&method=fetchContributionsDataTables&users=" + encodeURI(sel),
			"aoColumnsDefs": [ { "bVisible": false, "aTargets": [ 2 ] } ],
			"fnDrawCallback": function( oSettings ) {
				$('#UserContributionsDT .timeago').timeago();
			}
		});
		

		/*
		$.nirvana.sendRequest({
			controller: 'AccountCreationTrackerExternalController',
			method: 'fetchContributions',
			format: 'json',
			data: {
				users: sel
			},
			callback: $.proxy(function(data) {
				$('#UserContributions').html( data.html );
			}, this),
			onErrorCallback: $.proxy(function(jqXHR, textStatus, errorThrown) {
			}, this)
		});
		*/
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
