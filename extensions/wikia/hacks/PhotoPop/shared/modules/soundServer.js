var exports = exports || {};

define.call(exports, {
	
	sounds: {},
	
	mute: false,
	
	init: function(configSounds) {
		var Titanium = Titanium || undefined,
		path = ((document && !Titanium) ? "extensions/wikia/hacks/PhotoPop/" : '') + "shared/audio/";
			
		this.sounds = {
			"win": new Audio(path + configSounds.win + ".mp3" ),
			"fail": new Audio(path + configSounds.fail + ".wav" ),
			"pop": new Audio(path + configSounds.pop + ".wav" ),
			"timeEnd": new Audio(path + configSounds.timeEnd + ".wav" ),
			"wrongAnswer": new Audio(path + configSounds.wrongAnswer + ".wav" )
		}
	},
	
	play: function(sound) {
		if(!this.mute) {
			this.sounds[sound].play();		
		}
	}
});