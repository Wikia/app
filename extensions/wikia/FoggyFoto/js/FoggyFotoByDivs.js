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
		configs.push( new FoggyFoto.GameConfigs("glee.wikia.com", "Category:Characters", "") );
		configs.push( new FoggyFoto.GameConfigs("lyrics.wikia.com", "Category:Album", "") );
		configs.push( new FoggyFoto.GameConfigs("muppet.wikia.com", "Category:The_Muppets_Characters", "") );
		configs.push( new FoggyFoto.GameConfigs("dexter.wikia.com", "Category:Characters", "") );
		configs.push( new FoggyFoto.GameConfigs("futurama.wikia.com", "Category:Characters", "") );
		//configs.push( new FoggyFoto.GameConfigs("gameofthrones.wikia.com", "Category:Characters", "") );
		//configs.push( new FoggyFoto.GameConfigs("ben10.wikia.com", "Category:Episodes", "") );

		return configs;
	};
}

if (typeof FoggyFoto.SoundManager === 'undefined') {
	/**
	 * Class for managing the sounds in FoggyFoto.  Audio is pretty striaghtforward in HTML5... this class
	 * mainly helps by handling loading.
	 */
	FoggyFoto.SoundManager = function(){
		var self = this;
		this.debug = true;

		this.soundFiles = {
			'click': '/extensions/wikia/FoggyFoto/audio/FingerPlop4.wav',
			'right': '/extensions/wikia/FoggyFoto/audio/Human-Applause-MediumCrowd03.wav',
			'wrong': '/extensions/wikia/FoggyFoto/audio/tubePop.wav',
			'timeLow': '/extensions/wikia/FoggyFoto/audio/CountdowntoBlastOff.wav',
			'timeUp': '/extensions/wikia/FoggyFoto/audio/Sad-Trombone.wav',
		};
		
		// Caches actual Audio objects.
		this.soundCache = {};

		/**
		 * Given the sound name (a key from the self.soundFiles object above), play that sound.
		 */
		this.play = function(soundName){
			if(this.soundFiles[ soundName ]){
				self.soundCache[soundName] = new Audio( this.soundFiles[soundName] );
				self.log("Playing '" + soundName + "' sound");
				self.soundCache[soundName].play();
			} else {
				self.log("Tried to play invalid sound: " + soundName);
			}
		};

		/**
		 * Given the sound name (a key from the self.soundFiles object above), try to pause that
		 * sound if it's already playing.
		 */
		this.pause = function(soundName){
			if(this.soundCache[ soundName ]){
				self.log("Pausing '" + soundName + "' sound");
				this.soundCache[soundName].pause();
			} else {
				self.log("Tried to pause sound which hasn't been started: " + soundName);
			}
		};

		/**
		 * Simple wrapper for console.log to allow us to turn on/off debugging for this
		 * whole class at once.
		 */
		this.log = function(msg){
			if(self.debug){
				if (typeof console == "undefined") {
					window.console = {
						log: function () {}
					};
				}

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
