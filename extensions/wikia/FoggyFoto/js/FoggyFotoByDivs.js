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
	FoggyFoto.GameConfigs = function(){
		var self = this;
		this.debug = true; // whether to log a whole bunch of info to console.log
	
		this._wikiDomain = "lyrics.wikia.com";
		//this._category = "Category:
	
	
		
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





// Once the page is loaded, start the game.
$(document).ready(function(){
	console.log("Starting FoggyFoto game...");
	var flipBoard = new FoggyFoto.FlipBoard();
	flipBoard.init(function(){
		console.log("Game has started!");
	});
});
