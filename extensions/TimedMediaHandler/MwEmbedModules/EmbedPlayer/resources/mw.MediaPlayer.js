/**
 * mediaPlayer represents a media player plugin.
 *
 * @param {String}
 *      id id used for the plugin.
 * @param {Array}
 *      supported_types an array of supported MIME types.
 * @param {String}
 *      library external script containing the plugin interface code.
 * @constructor
 */
	
( function( mw, $ ) {
	
mw.MediaPlayer = function( id, supported_types, library )
{
	this.id = id;
	this.supported_types = supported_types;
	this.library = library;
	this.loaded = false;
	this.loading_callbacks = new Array();
	return this;
}
mw.MediaPlayer.prototype = {
	// Id of the mediaPlayer
	id:null,

	// Mime types supported by this player
	supported_types:null,

	// Player library ie: native, vlc, java etc.
	library:null,

	// Flag stores the mediaPlayer load state
	loaded:false,

	/**
	 * Checks support for a given MIME type
	 *
	 * @param {String}
	 *      type Mime type to check against supported_types
	 * @return {Boolean} true if mime type is supported false if mime type is
	 *     unsupported
	 */
	supportsMIMEType: function( type ) {
		for ( var i = 0; i < this.supported_types.length; i++ ) {
			if ( this.supported_types[i] == type )
				return true;
		}
		return false;
	},

	/**
	 * Get the "name" of the player from a predictable msg key
	 */
	getName: function() {
		return gM( 'mwe-embedplayer-ogg-player-' + this.id );
	},

	/**
	 * Loads the player library & player skin config ( if needed ) and then
	 * calls the callback.
	 *
	 * @param {Function}
	 *      callback Function to be called once player library is loaded.
	 */
	load: function( callback ) {
		// Load player library ( upper case the first letter of the library )
		mw.load( [
			'mw.EmbedPlayer' + this.library.substr(0,1).toUpperCase() + this.library.substr(1)
		], function() {
			if( callback ){
				callback();
			}
		} );
	}
};
} )( mediaWiki, jQuery );