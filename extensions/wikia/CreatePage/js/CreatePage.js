var CreatePage = {};
var CreatePageEnabled = false;

ShareFeature.ajax = function( provider ) {
	$.post(wgScript,
			{
				'action':'ajax', 
				'rs':'wfCreatePageAjaxUpdateStats',
				'provider': provider
			},
			function() {
				 $('.modalWrapper').closeModal();
			}
		);
};

CreatePage.openDialog = function(e) {
	e.preventDefault();
	if( false == CreatePageEnabled ) {
		CreatePageEnabled = true;
		$().getModal(
			wgScript + '?action=ajax&rs=wfCreatePageAjaxGetDialog',
			'#CreatePageDialog', {
					width: 450,
					callback: function() {
						CreatePageEnabled = false;
						CreatePage.track( 'open' );
					},
				onClose: function() {
					CreatePage.track( 'close' );
				}
			}
		);
	}
}

CreatePage.track = function( str ) {
	WET.byStr('CreatePage/' + str);
};

$(function() {
	if( $( '#dynamic-links-write-article-icon' ).exists() ) {
		// open dialog on clicking
		$( '#dynamic-links-write-article-icon' ).click( function(e) { CreatePage.openDialog(e); });
	}
	if( $( '#dynamic-links-write-article-link' ).exists() ) {
		// open dialog on clicking
		$( '#dynamic-links-write-article-link' ).click( function(e) { CreatePage.openDialog(e); });
	}

});
