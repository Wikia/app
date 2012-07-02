/**
 * Selector based embedPlayer processing
 * 
 * @param {Function=}
 *      callback Optional Function to be called once video interfaces
 *      are ready
 *
 */
mw.processEmbedPlayers = function( playerSelect, callback ) {
	mw.log( 'EmbedPlayer:: processEmbedPlayers' );
	
	// Check if the selected player set is ready if ready issue the parent callback
	var areSelectedPlayersReady = function(){
		var playersLoaded = true;
		$(playerSelect).each(function(inx, player){
			if( ! $( player ).get(0).playerReadyFlag ){
				playersLoaded = false;
				return false;
			}
		})
		if( playersLoaded ){
			if( callback )
				callback();
		}
	}

	/**
	 * Adds a player element for the embedPlayer to rewrite
	 *
	 * uses embedPlayer interface on audio / video elements uses mvPlayList
	 * interface on playlist elements
	 *
	 * Once a player interface is established the following chain of functions
	 * are called;
	 *
	 * _this.checkPlayerSources() 
	 * _this.setupSourcePlayer() 
	 * _this.updatePlaybackInterface()
	 * _this.selectedPlayer.load() 
	 * _this.showPlayer()
	 *
	 * @param {Element}
	 *      playerElement DOM element to be swapped
	 * @param {Object}
	 *      [Optional] attributes Extra attributes to apply to the player
	 *      interface
	 */
	var addPlayerElement = function( playerElement ) {
		var _this = this;
		mw.log('EmbedPlayer:: addElement:: ' + playerElement.id );


		// Be sure to "stop" the target ( Firefox 3x keeps playing
		// the video even though its been removed from the DOM )
		if( playerElement.pause ){
			playerElement.pause();
		}
		
		// Allow modules to override the wait for metadata flag:
		$( mw ).trigger( 'checkPlayerWaitForMetaData', playerElement );

		// DOM *could* load height, width and duration eventually, in some browsers
		// By default, don't bother waiting for this.
		var waitForMeta = false;
		
		// if a plugin has told us not to waitForMeta, don't
		if ( playerElement.waitForMeta !== false ) {
			// Check if we should wait for metadata, after all
			waitForMeta = waitForMetaCheck( playerElement );
		}
		
		var ranPlayerSwapFlag = false;			
		
		// Local callback to runPlayer swap once playerElement has metadata
		function runPlayerSwap() {
			// Don't run player swap twice
			if( ranPlayerSwapFlag ){
				return ;
			}
			ranPlayerSwapFlag = true;
			mw.log("EmbedPlayer::runPlayerSwap::" + $( playerElement ).attr('id') );

			var playerInterface = new mw.EmbedPlayer( playerElement );
			var inDomPlayer = swapEmbedPlayerElement( playerElement, playerInterface );	
								
			// Trigger the EmbedPlayerNewPlayer for embedPlayer interface
			mw.log("EmbedPlayer::EmbedPlayerNewPlayer:trigger " + inDomPlayer.id );
			
			// Allow plugins to add bindings to the inDomPlayer
			$( mw ).trigger ( 'EmbedPlayerNewPlayer', inDomPlayer );

			// Add a player ready binding: 
			$( inDomPlayer ).bind( 'playerReady', areSelectedPlayersReady );
			
			// Issue the checkPlayerSources call to the new player
			// interface: make sure to use the element that is in the DOM:
			inDomPlayer.checkPlayerSources();
		}

		if( waitForMeta && mw.getConfig('EmbedPlayer.WaitForMeta' ) ) {
			mw.log('EmbedPlayer::WaitForMeta ( video missing height (' +
					$( playerElement ).attr('height') + '), width (' +
					$( playerElement ).attr('width') + ') or duration: ' +
					$( playerElement ).attr('duration')
			);
			$( playerElement ).bind("loadedmetadata", runPlayerSwap );

			// Time-out of 5 seconds ( maybe still playable but no timely
			// metadata )
			setTimeout( runPlayerSwap, 5000 );
			return ;
		} else {
			runPlayerSwap();
			return ;
		}
	};

	/**
	 * Check if we should wait for metadata.
	 *
	 * @return 	true if the size is "likely" to be updated by waiting for metadata 
	 * 			false if the size has been set via an attribute or is already loaded
	 */
	var waitForMetaCheck = function( playerElement ){
		var waitForMeta = false;
			
		// Don't wait for metadata for non html5 media elements
		if( !playerElement ){
			return false;
		}
		if( !playerElement.tagName || ( playerElement.tagName.toLowerCase() != 'audio'  && playerElement.tagName.toLowerCase() != 'video' ) ){
			return false;
		}
		// If we don't have a native player don't wait for metadata
		if( !mw.EmbedTypes.getMediaPlayers().isSupportedPlayer( 'oggNative') &&
			!mw.EmbedTypes.getMediaPlayers().isSupportedPlayer( 'webmNative') &&
			!mw.EmbedTypes.getMediaPlayers().isSupportedPlayer( 'h264Native' ) )
		{
			return false;
		}


		var width = $( playerElement ).css( 'width' );
		var height = $( playerElement ).css( 'height' );

		// Css video defaults ( firefox ) 
		if( $( playerElement ).css( 'width' ) == '300px' &&
				$( playerElement ).css( 'height' ) == '150px' 			
		){
			waitForMeta = true;
		} else {
			// Check if we should wait for duration:
			if( $( playerElement ).attr( 'duration') ||
				$( playerElement ).attr('data-durationhint')
			){
				// height, width and duration set; do not wait for meta data:
				return false;
			} else {
				waitForMeta = true;
			}
		}

		// Firefox ~ sometimes~ gives -1 for unloaded media
		if ( $(playerElement).attr( 'width' ) == -1 || $(playerElement).attr( 'height' ) == -1 ) {
			waitForMeta = true;
		}

		// Google Chrome / safari gives 0 width height for unloaded media
		if( $(playerElement).attr( 'width' ) === 0 ||
			$(playerElement).attr( 'height' ) === 0
		) {
			waitForMeta = true;
		}

		// Firefox default width height is ~sometimes~ 150 / 300
		if( this.height == 150 && this.width == 300 ){
			waitForMeta = true;
		}

		// Make sure we have a src attribute or source child
		// ( i.e not a video tag to be dynamically populated or looked up from
		// xml resource description )
		if( waitForMeta &&
			(
				$( playerElement ).attr('src') ||
				$( playerElement ).find("source[src]").length !== 0
			)
		) {
			// Detect src type ( if no type set )
			return true;
		} else {
			// playerElement is not likely to update its meta data ( no src )
			return false;
		}
	};

	/**
	 * swapEmbedPlayerElement
	 *
	 * Takes a video element as input and swaps it out with an embed player interface
	 *
	 * @param {Element}
	 *      targetElement Element to be swapped
	 * @param {Object}
	 *      playerInterface Interface to swap into the target element
	 */
	var swapEmbedPlayerElement =  function( targetElement, playerInterface ) {
		mw.log( 'EmbedPlayer::swapEmbedPlayerElement: ' + targetElement.id );
		// Create a new element to swap the player interface into
		var swapPlayerElement = document.createElement('div');

		// Add a class that identifies all embedPlayers: 
		$( swapPlayerElement ).addClass( 'mwEmbedPlayer' );
		
		// Get properties / methods from playerInterface:
		for ( var method in playerInterface ) {
			if ( method != 'readyState' ) { // readyState crashes IE ( don't include )
				swapPlayerElement[ method ] = playerInterface[ method ];
			}
		}
		// Check if we are using native controls or Persistent player ( should keep the video embed around )
		if( playerInterface.useNativePlayerControls() || playerInterface.isPersistentNativePlayer() ) {
			$( targetElement )
			.attr( 'id', playerInterface.pid )
			.addClass( 'nativeEmbedPlayerPid' )
			.show()
			.after(
				$( swapPlayerElement ).css( 'display', 'none' )
			);

		} else {
			$( targetElement ).replaceWith( swapPlayerElement );
		}


		// Set swapPlayerElement has height / width set and set to loading:
		$( swapPlayerElement ).css( {
			'width' : playerInterface.width + 'px',
			'height' : playerInterface.height + 'px'
		} );

		// If we don't already have a loadSpiner add one:
		if( $('#loadingSpinner_' + playerInterface.id ).length == 0 && !$.browser.mozilla ){
			if( playerInterface.useNativePlayerControls() || playerInterface.isPersistentNativePlayer() ) {
				var $spinner = $( targetElement )
					.getAbsoluteOverlaySpinner();
			}else{
				var $spinner = $( swapPlayerElement ).getAbsoluteOverlaySpinner();
			}
			$spinner.attr('id', 'loadingSpinner_' + playerInterface.id );
		}
		return swapPlayerElement;
	};

	// Add a loader for <div> embed player rewrites: 
	$( playerSelect ).each( function( index, playerElement) {
		
		// Make sure the playerElement has an id:
		if( !$( playerElement ).attr('id') ){
			$( playerElement ).attr( "id", 'mwe_v' + ( index ) );
		}

		// If we are dynamically embedding on a "div" check if we can
		// add a poster image behind the loader:
		if( playerElement.nodeName.toLowerCase() == 'div'
			&& ( attributes.poster || $(playerElement).attr( 'poster' ) ) ){
			var posterSrc = ( attributes.poster ) ? attributes.poster : $(playerElement).attr( 'poster' );

			// Set image size:
			var width = $( playerElement ).width();
			var height = $( playerElement ).height();
			if( !width ){
				var width = ( attributes.width ) ? attributes.width : '100%';
			}
			if( !height ){
				var height = ( attributes.height ) ? attributes.height : '100%';
			}

			mw.log('EmbedPlayer:: set loading background: ' + posterSrc);
			$( playerElement ).append(
				$( '<img />' )
				.attr( 'src', posterSrc)
				.css({
					'position' : 'absolute',
					'width' : width,
					'height' : height
				})
			);
		}
	});

	// deprecated EmbedPlayerManagerReady event ( should remove )
	$( mw ).trigger( 'EmbedPlayerManagerReady' );
	
	// Make sure we have user preference setup for setting preferences on video selection 
	var addedToPlayerManager = false;
	mw.log("EmbedPlayer:: do: " + $( playerSelect ).length + ' players ');
	
	// Add each selected element to the player manager:
	$( playerSelect ).each( function( index, playerElement) {
		// Make sure the video tag was not generated by our library:
		if( $( playerElement ).hasClass( 'nativeEmbedPlayerPid' ) ){
			$('#loadingSpinner_' + $( playerElement ).attr('id') ).remove();
			mw.log( 'EmbedPlayer::$.embedPlayer skip embedPlayer gennerated video: ' + playerElement );
		} else {
			addedToPlayerManager = true;										
			// Add the player
			addPlayerElement( playerElement );
		}
	});
	if( addedToPlayerManager ){
		if( callback ){
			$( mw ).bind( "playersReadyEvent", callback );
		}
	} else {
		// Run the callback directly if no players were added
		if( callback ){
			callback();
		}
	}
};