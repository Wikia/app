var SponsorshipDashboardUserEditor = {

	init: function(){

		$( '#userGroupList' ).change(
			SponsorshipDashboardUserEditor.addToList
		);

		$( 'a.delete' ).click( SponsorshipDashboardUserEditor.removeUser );
		$( 'a.sd-save' ).click( SponsorshipDashboardUserEditor.submit );
		$('#userReportsDisplay').bind('click', SponsorshipDashboardUserEditor.checkForEvents );
		SponsorshipDashboardUserEditor.refreshElementList();
	},
	addToList : function(){

		var elementValue = $( '#groupReportList' ).val();
		var currentArray = $( '#groupReportsInput' ).val().split( ',' );
		if ( elementValue > 0 ){
			if ( $.inArray( elementValue, currentArray ) == -1 ){
				currentArray.push( elementValue + '|' );
				$( '#groupReportsInput' ).val( currentArray.join(',') );
				$( '#groupReports' ).append( SponsorshipDashboardGroupEditor.reportItemText( elementValue ) );
			}
		}
	},
	refreshElementList : function(){
		
		var currentArrayTmp = $( '#groupReportsInput' ).val().split( ',' );
		
		for ( var i = 0; i < currentArrayTmp.length; i = i + 1){

			var value = currentArrayTmp[i].replace( '|', '' );
			if ( value > 0 ){
				$( '#groupReports' ).append( SponsorshipDashboardGroupEditor.reportItemText( value ) );
				$( '#groupReportList option[value=' + value + ']' ).hide();
			}
		}
	},
	reportItemText : function( value ){

		var elementText = '<li>';
		elementText = elementText + '<a data-id="' + value + '" class="delete wikia-button secondary"><img src="'+wgBlankImgUrl+'" class="sprite trash"></a> ';
		elementText = elementText + $( "#groupReportList option[value=" + value + "]" ).html();
		elementText = elementText + '</li>';
		$( '#groupReportList option[value=' + value + ']' ).hide();

		return elementText;
	},
	removeReport : function( elementId ){

		$( '#groupReportsInput' ).val( $( '#groupReportsInput' ).val().replace( ',' + elementId + '|', '' ) );
		$( '#groupReportList option[value=' + elementId + ']' ).show();
		$( '#groupReports a[data-id=' + elementId + ']' ).parent('li').remove();

	},
	checkForEvents : function( ev ){

		var node = $(ev.target).parent('a');
		$().log( node, node );
		if ( node.hasClass('delete') && node.attr( 'data-id' ) > 0 ){
			SponsorshipDashboardGroupEditor.removeReport( node.attr( 'data-id' ) );
		}
	}
};

//on content ready
wgAfterContentAndJS.push( SponsorshipDashboardGroupEditor.init );