/** IMPLEMENTATION USING HTML/CSS (DIVS FOR TILES) **/

if (typeof PhotoPop === 'undefined') {
	PhotoPop = {};
}

if (typeof PhotoPop.SoundManager === 'undefined') {
	/**
	 * Class for managing the sounds in PhotoPop.  Audio is pretty striaghtforward in HTML5... this class
	 * mainly helps by handling loading.
	 */
	PhotoPop.SoundManager = function(){
		var self = this;
		this.debug = true;

		this.soundFiles = {
			'click': wgExtensionsPath + '/wikia/PhotoPop/audio/FingerPlop4.wav',
			'right': wgExtensionsPath + '/wikia/PhotoPop/audio/Human-Applause-MediumCrowd03.wav',
			'wrong': wgExtensionsPath + '/wikia/PhotoPop/audio/tubePop.wav',
			'timeLow': wgExtensionsPath + '/wikia/PhotoPop/audio/CountdowntoBlastOff.wav',
			'timeUp': wgExtensionsPath + '/wikia/PhotoPop/audio/Sad-Trombone.wav'
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
	//console.log("Starting PhotoPop game...");
	var flipBoard = new PhotoPop.FlipBoard();
	flipBoard.init(function(){
		//console.log("Game has started!");
	});
});
