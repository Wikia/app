$( function() {
	'use strict';

	var $chatIncomingMsgSoundsSelect = $( '#chatIncomingMsgSound' ),
		$play,
		chatSampleSound,
		$target,
		selected = $chatIncomingMsgSoundsSelect.val();

	function getAudioSource( audioFileName ) {
		return window.wgExtensionsPath + '/wikia/Chat2/sounds/' + audioFileName;
	}

	$chatIncomingMsgSoundsSelect.after( '<a id="playChatSound" style="display: none;">Play</a>' );
	$play = $( '#playChatSound' );
	$play.after( '<audio id="chatSampleSound" />' );
	chatSampleSound = document.getElementById( 'chatSampleSound' );

	// onload display "Play" link next to selectbox if there is a sound selected
	if( selected !== '' ) {
		$play.show();
		chatSampleSound.src = getAudioSource( selected );
	}

	// bind click to the play button
	$play.click( function( event ) {
		event.preventDefault();
		chatSampleSound.play();
	} );

	// if the selected sound changes change also stat of the "Play" link and audio source
	$chatIncomingMsgSoundsSelect.change( function( event ) {
		$target = $( event.target );
		selected = $target.val();

		if( selected === '' ) {
			$play.hide();
		} else {
			chatSampleSound.src = getAudioSource( selected );
			$play.show();
		}
	} );

} );
