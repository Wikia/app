( function( $ ) {
// Create or extend the object
window.CodeReview = $.extend( window.CodeReview, {

	loadDiff : function(repo, rev) {
		var apiPath = mw.config.get( 'wgScriptPath' ) + '/api' + mw.config.get( 'wgScriptExtension' );
		$(CodeReview.diffTarget()).injectSpinner( 'codereview-diff' );
		try {
			$.ajax({
				url: apiPath,
				data : {
					'format' : 'json',
					'action' : 'codediff',
					'repo' : repo,
					'rev' : rev
				},
				dataType : 'json',
				success : function( data ) {
					CodeReview.decodeAndShowDiff( data );
					$.removeSpinner( 'codereview-diff' );
				}
			});
		} catch ( e ) {
			$.removeSpinner( 'codereview-diff' );
			if ( window.location.hostname == 'localhost' ) {
				alert( 'Your browser blocks XMLHttpRequest to "localhost", try using a real hostname for development/testing.' );
			}
			CodeReview.setDiff( 'Diff load failed!' );
			throw e;
		}
	},
	decodeAndShowDiff : function( data ) {
		if ( data && data.code && data.code.rev && data.code.rev.diff ) {
			CodeReview.setDiff( data.code.rev.diff );
		} else {
			CodeReview.setDiff( 'Diff load failed. :(' );
		}
	},
	diffTarget : function() {
		return document.getElementById( 'mw-codereview-diff' );
	},
	setDiff : function( diffHtml ) {
		CodeReview.diffTarget().innerHTML = diffHtml;
	}

});
})( jQuery );