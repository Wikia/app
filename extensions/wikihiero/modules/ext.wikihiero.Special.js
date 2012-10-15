jQuery( function ( $ ) {

var $textarea = $( '#hiero-text' );
var $submit = $( '#hiero-submit' );
var $result = $( '#hiero-result' );

$textarea.keyup( function() {
	if ( $textarea.val().length == 0 ) {
		$submit.attr( 'disabled', 'disabled' );
	} else {
		$submit.removeAttr( 'disabled' );
	}
});
$textarea.keyup();

$submit.click( function( e ) {
	e.preventDefault();
	$result.hide();
	$result.injectSpinner( 'hiero' );
	var text = $textarea.val();
	var data = {
		'format': 'json',
		'action': 'parse',
		'text': '<hiero>' + text + '</hiero>',
		'disablepp': ''
	};
	$.post( mw.util.wikiScript( 'api' ),
		data,
		function( data ) {
			var html = '<table class="wikitable">'
				+ '<tr><th>' + mw.msg( 'wikihiero-input' ) + '</th><th>' 
				+ mw.msg( 'wikihiero-result' ) + '</th></tr>'
				+ '<tr><td><code>&lt;hiero&gt;' + mw.html.escape( text ).replace( '\n', '<br/>' ) + '&lt;/hiero&gt;</code></td>'
				+ '<td>' + data.parse.text['*'] + '</td></tr></table>';
			$.removeSpinner( 'hiero' );
			$result.html( html );
			$result.show();
		}
	).error( function() {
		$result.text( mw.msg( 'wikihiero-load-error' ) );
		$result.show();
	});
});

});