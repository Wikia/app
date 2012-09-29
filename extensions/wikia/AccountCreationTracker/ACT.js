$(document).ready(function() {
	$('#TrackedUsers input[type=checkbox]').removeAttr('checked');
	var oCache = {
		iCacheLower: -1
	};
	
	function fnSetKey(aoData, sKey, mValue) {
		for(var i = 0, iLen = aoData.length; i < iLen; i++) {
			if(aoData[i].name == sKey) {
				aoData[i].value = mValue;
			}
		}
	}
	
	function fnGetKey(aoData, sKey) {
		for(var i = 0, iLen = aoData.length; i < iLen; i++) {
			if(aoData[i].name == sKey) {
				return aoData[i].value;
			}
		}
		return null;
	}
	
	function fnDataTablesPipeline(sSource, aoData, fnCallback) {
		var iPipe = 5;
		/* Ajust the pipe size */
	
		var bNeedServer = false;
		var sEcho = fnGetKey(aoData, "sEcho");
		var iRequestStart = fnGetKey(aoData, "iDisplayStart");
		var iRequestLength = fnGetKey(aoData, "iDisplayLength");
		var iRequestEnd = iRequestStart + iRequestLength;
		oCache.iDisplayStart = iRequestStart;
	
		/* outside pipeline? */
		if(oCache.iCacheLower < 0 || iRequestStart < oCache.iCacheLower || iRequestEnd > oCache.iCacheUpper) {
			bNeedServer = true;
		}
	
		/* sorting etc changed? */
		if(oCache.lastRequest && !bNeedServer) {
			for(var i = 0, iLen = aoData.length; i < iLen; i++) {
				if(aoData[i].name != "iDisplayStart" && aoData[i].name != "iDisplayLength" && aoData[i].name != "sEcho") {
					if(aoData[i].value != oCache.lastRequest[i].value) {
						bNeedServer = true;
						break;
					}
				}
			}
		}
	
		/* Store the request for checking next time around */
		oCache.lastRequest = aoData.slice();
	
		if(bNeedServer) {
			if(iRequestStart < oCache.iCacheLower) {
				iRequestStart = iRequestStart - (iRequestLength * (iPipe - 1));
				if(iRequestStart < 0) {
					iRequestStart = 0;
				}
			}
	
			oCache.iCacheLower = iRequestStart;
			oCache.iCacheUpper = iRequestStart + (iRequestLength * iPipe);
			oCache.iDisplayLength = fnGetKey(aoData, "iDisplayLength");
			fnSetKey(aoData, "iDisplayStart", iRequestStart);
			fnSetKey(aoData, "iDisplayLength", iRequestLength * iPipe);
	
			$.getJSON(sSource, aoData, function(json) {
				/* Callback processing */
				oCache.lastJson = jQuery.extend(true, {}, json);
	
				if(oCache.iCacheLower != oCache.iDisplayStart) {
					json.aaData.splice(0, oCache.iDisplayStart - oCache.iCacheLower);
				}
				json.aaData.splice(oCache.iDisplayLength, json.aaData.length);
	
				fnCallback(json)
			});
	
		} else {
			json = jQuery.extend(true, {}, oCache.lastJson);
			json.sEcho = sEcho;
			/* Update the echo for each response */
			json.aaData.splice(0, iRequestStart - oCache.iCacheLower);
			json.aaData.splice(iRequestLength, json.aaData.length);
			fnCallback(json);
			return;
		}
	}


	$('table#TrackedUsers tbody tr').click( function() {
		if ( $(this).hasClass('row_selected') ) {
			$(this).removeClass('row_selected');
			$('input',this).removeAttr('checked');
		} else {
			$(this).addClass('row_selected');
			$('input',this).attr('checked','checked');
		}
	} );
	var oTable = $('table#TrackedUsers').dataTable({
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": true,
		"bInfo": false,
		"aaSorting": [[5,'desc']],
		"bAutoWidth": false
	});
	
	var oTableNukeList = $('#PagesToNukeDT').dataTable({		
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": false,
		"bInfo": false,
		"bAutoWidth": false,
		"aoColumns": [ 
			{ "bVisible": false },
			null,
			null,
			null,
			null
		 ]
	});
	
	$('#PagesToNukeDT').delegate('tbody tr', 'click', function() {
		oTableNukeList.fnDeleteRow(this);
	});

	function fnGetSelected( oTableLocal ) {
		var aReturn = new Array();
		var aTrs = oTableLocal.fnGetNodes();
		for ( var i=0 ; i<aTrs.length ; i++ ) {
			if ( $(aTrs[i]).hasClass('row_selected') ) {
				aReturn.push( parseInt($('td:eq(1)',aTrs[i]).text()) );
			}
		}
		return aReturn;
	}

	
	$('#FetchContributions').click( function() {
		var sel = fnGetSelected( oTable );
		if( sel.length == 0 ) {
			$.showModal('Error', 'You need to select at least one user');
			return;
		}
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
			"aoColumns": [ 
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				{ "bVisible": false },
				null
			 ],
			"fnServerData": fnDataTablesPipeline,
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
				$(this).popover({
					content: 'Added page to NukeList (below)', 
					placement: 'bottom'
				})
				.popover('show');
			}
		});
		
		$('#PagesToNuke').show();
		
		
	});

	var interval = null;
	var interval_i = 0;
	var interval_in_progress = 0;
	$('#NukeRollback').click( function() {
		$('#NukeRollback').attr('disabled','disabled');
		
		var aReturn = new Array();
		var aTrs = oTableNukeList.fnGetNodes();
		
		interval_i = 0;
		interval_in_progress = 0;
		interval = setInterval( function() {
			var current_i = interval_i++;
			if( current_i >= aTrs.length ) {
				window.clearInterval(interval);
				$('#NukeRollback').removeAttr('disabled');
				return;
			}
			var link = oTableNukeList.fnGetData( current_i )[0];

			$.ajax({
				url: link,
				success: function(data) {
					var result = $.parseJSON( data );
					if( 'msg' in result ) {
						$('td:eq(4)',aTrs[current_i]).text(result['msg']);
					} else {
						$('td:eq(4)',aTrs[current_i]).text('error');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$('td:eq(4)',aTrs[current_i]).text('error');
				}
			});
			
		}, 500);
			
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
