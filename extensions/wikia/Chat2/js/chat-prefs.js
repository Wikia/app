$( function() {
	'use strict';

	var $chatIncomingMsgSoundsSelect = $( '#chatIncomingMsgSound'),
		$play,
		chatSampleSound,
		selected;

	$chatIncomingMsgSoundsSelect.after( '<a id="playChatSound">Play</a>' );
	$play = $( '#playChatSound' );
	$play.click(function( event ) {
		event.preventDefault();
		selected = $chatIncomingMsgSoundsSelect.val();
		$play.after( '<audio id="chatSampleSound" src="' + wgExtensionsPath + '/wikia/Chat2/sounds/' + selected + '">' );
		chatSampleSound = document.getElementById( 'chatSampleSound' );
		chatSampleSound.play();
		//chatSampleSound.parentNode.removeChild( chatSampleSound );
	} );
} );
