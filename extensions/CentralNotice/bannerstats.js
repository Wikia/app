/**
 * This script retrieves click-thru rates for all the banners in all the campaigns in
 * wgCentralNoticeAllocationCampaigns. It then adds the rates to the allocation tables.
 */
$( document ).ready( function () {
	/* TODO: Once the lag issue with retrieving the stats is resolved, finish implementing this functionality */
	/*
	if ( typeof wgCentralNoticeAllocationCampaigns !== 'undefined' ) {
		$.each( wgCentralNoticeAllocationCampaigns, function( index, campaignName ) {
			var statUrl = 'http://fundraising-analytics.wikimedia.org/json_reporting/' + campaignName;
			$.ajax( {
				'url': statUrl,
				'data': {},
				'dataType': 'jsonp',
				'type': 'GET',
				'success': function( data ) {
					//console.debug( "Success" );
					//console.debug( data );
				},
				'error': function( xhr ) {
					//console.debug( "Error" );
					//console.debug( xhr );
				}
			} );
		} )
	}
	*/
} );
