/** IMPLEMENTATION USING HTML/CSS (DIVS FOR TILES) **/

if (typeof FoggyFoto === 'undefined') {
	/**
	 * This class controls the flow of the entire FoggyFoto game.  The actual gameplay is inside of 
	 * the FoggyFoto.FlipBoard class.
	 */
	FoggyFoto = function(){
		var self = this;
		this.debug = true; // whether to log a whole bunch of info to console.log
	
	
	
	
		
		/**
		 * Simple wrapper for console.log to allow us to turn on/off debugging for this
		 * whole class at once.
		 */
		this.log = function(msg){
			if(self.debug){
				console.log(msg);
			}
		};	
	};
}



if (typeof FoggyFoto.GameConfigs === 'undefined') {
	/**
	 * This class stores a configuration for a single game type. For example, to play the game on TrueBlood with
	 * category Characters, you would have one GameConfig object, but to play on Glee with category Characters or
	 * TrueBlood with category Episodes would be another.
	 */
	FoggyFoto.GameConfigs = function(wikiDomain, category, iconSrc){
		var self = this;
		this._wikiDomain = wikiDomain; // eg: "lyrics.wikia.com"
		this._category = category; // eg: "Category:Albums released in 1984";
		this._iconSrc = iconSrc; // the URL of the square icon for the selector-screen.
	};

	/**
	 * Loads all possible game configurations to present the player with a choice for which to play.
	 */
	FoggyFoto.getConfigs = function(){
		var configs = [];

		// Hard-coded games. Eventually this will just be a fallback in case the MediaWiki message containing the data doesn't load.
		configs.push( new FoggyFoto.GameConfigs("trueblood.wikia.com", "Category:Characters", "") );
		configs.push( new FoggyFoto.GameConfigs("gameofthrones.wikia.com", "Category:Characters", "") );
		configs.push( new FoggyFoto.GameConfigs("glee.wikia.com", "Category:Characters", "") );
		configs.push( new FoggyFoto.GameConfigs("lyrics.wikia.com", "Category:Album", "") );
		configs.push( new FoggyFoto.GameConfigs("muppet.wikia.com", "Category:Characters", "") );
		configs.push( new FoggyFoto.GameConfigs("ben10.wikia.com", "Category:Episodes", "") );
		configs.push( new FoggyFoto.GameConfigs("trueblood.wikia.com", "Category:Episodes", "") );

		return configs;
	}
}





// Once the page is loaded, start the game.
$(document).ready(function(){
	console.log("Starting FoggyFoto game...");
	var flipBoard = new FoggyFoto.FlipBoard();
	flipBoard.init(function(){
		console.log("Game has started!");
	});
});
