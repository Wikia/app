/**
 * mediaPlayers is a collection of mediaPlayer objects supported by the client.
 *
 * @constructor
 */

( function( mw, $ ) {
	
mw.MediaPlayers = function()
{
	this.init();
}

mw.MediaPlayers.prototype = {
	// The list of players supported
	players : null,

	// Stores the default set of players for a given mime type
	defaultPlayers : { },

	/**
	 * Initializartion function sets the default order for players for a given
	 * mime type
	 */
	init: function() {
		this.players = new Array();

		// set up default players order for each library type
		this.defaultPlayers['video/x-flv'] = ['Kplayer', 'Vlc'];
		this.defaultPlayers['video/h264'] = ['Native', 'Kplayer', 'Vlc'];

		this.defaultPlayers['video/ogg'] = ['Native', 'Vlc', 'Java', 'Generic'];
		this.defaultPlayers['video/webm'] = ['Native', 'Vlc'];
		this.defaultPlayers['application/ogg'] = ['Native', 'Vlc', 'Java', 'Generic'];
		this.defaultPlayers['audio/ogg'] = ['Native', 'Vlc', 'Java' ];
		this.defaultPlayers['video/mp4'] = ['Vlc'];
		this.defaultPlayers['video/mpeg'] = ['Vlc'];
		this.defaultPlayers['video/x-msvideo'] = ['Vlc'];

		this.defaultPlayers['text/html'] = ['Html'];
		this.defaultPlayers['image/jpeg'] = ['Html'];
		this.defaultPlayers['image/png'] = ['Html'];
		this.defaultPlayers['image/svg'] = ['Html'];

	},

	/**
	 * Adds a Player to the player list
	 *
	 * @param {Object}
	 *      player Player object to be added
	 */
	addPlayer: function( player ) {
		for ( var i = 0; i < this.players.length; i++ ) {
			if ( this.players[i].id == player.id ) {
				// Player already found
				return ;
			}
		}
		// Add the player:
		this.players.push( player );
	},

	/**
	 * Checks if a player is supported by id
	 */
	isSupportedPlayer: function( playerId ){
		for( var i=0; i < this.players.length; i++ ){
			if( this.players[i].id == playerId ){
				return true;
			}
		}
		return false;
	},

	/**
	 * get players that support a given mimeType
	 *
	 * @param {String}
	 *      mimeType Mime type of player set
	 * @return {Array} Array of players that support a the requested mime type
	 */
	getMIMETypePlayers: function( mimeType ) {
		var mimePlayers = new Array();
		var _this = this;
		if ( this.defaultPlayers[mimeType] ) {
			$.each( this.defaultPlayers[ mimeType ], function( d, lib ) {
				var library = _this.defaultPlayers[ mimeType ][ d ];
				for ( var i = 0; i < _this.players.length; i++ ) {
					if ( _this.players[i].library == library && _this.players[i].supportsMIMEType( mimeType ) ) {
						mimePlayers.push( _this.players[i] );
					}
				}
			} );
		}
		return mimePlayers;
	},

	/**
	 * Default player for a given mime type
	 *
	 * @param {String}
	 *      mimeType Mime type of the requested player
	 * @return Player for mime type null if no player found
	 */
	defaultPlayer : function( mimeType ) {
		// mw.log( "get defaultPlayer for " + mimeType );
		var mimePlayers = this.getMIMETypePlayers( mimeType );
		if ( mimePlayers.length > 0 )
		{
			// Check for prior preference for this mime type
			for ( var i = 0; i < mimePlayers.length; i++ ) {
				if ( mimePlayers[i].id == $.cookie( 'EmbedPlayer.PlayerPreference.' + mimeType ) ){
					mw.log( "mw.MediaPlayers:: setPlayer via cookie:: " + mimeType + ' playerId: ' + mimePlayers[i].id );
					return mimePlayers[i];
				}
			}
			// Otherwise just return the first compatible player
			// (it will be chosen according to the defaultPlayers list
			return mimePlayers[0];
		}
		// mw.log( 'No default player found for ' + mimeType );
		return null;
	},

	/**
	 * Sets the format preference.
	 *
	 * @param {String}
	 *      mimeFormat Prefered format
	 */
	setFormatPreference : function ( mimeFormat ) {
		 $.cookie( 'EmbedPlayer.FormatPreference', mimeFormat );
	},

	/**
	 * Sets the player preference
	 *
	 * @param {String}
	 *      playerId Prefered player id
	 * @param {String}
	 *      mimeType Mime type for the associated player stream
	 */
	setPlayerPreference : function( playerId, mimeType ) {
		var selectedPlayer = null;
		for ( var i = 0; i < this.players.length; i++ ) {
			if ( this.players[i].id == playerId ) {
				selectedPlayer = this.players[i];
				mw.log( 'EmbedPlayer::setPlayerPreference: choosing ' + playerId + ' for ' + mimeType );
				// Update the reference cookie
				$.cookie( 'EmbedPlayer.PlayerPreference.' + mimeType, playerId);
				break;
			}
		}
		// Also update the format Preference: 
		this.setFormatPreference( mimeType );
		
		// Update All the player instances on the page
		if ( selectedPlayer ) {			
			$('.mwEmbedPlayer').each(function(inx, playerTarget ){
				var embedPlayer = $( playerTarget ).get( 0 );
				if ( embedPlayer.mediaElement.selectedSource 
						&& ( embedPlayer.mediaElement.selectedSource.mimeType == mimeType ) )
				{
					embedPlayer.selectPlayer( selectedPlayer );
				}
			});
		}
	}
};

} )( mediaWiki, jQuery );