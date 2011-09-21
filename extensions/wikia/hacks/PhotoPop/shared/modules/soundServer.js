var exports = exports || {};

define.call(exports, {
	
	sounds: {},
	
	mute: false,
	
	init: function(counfigSounds) {
		var path = ((document && !Titanium) ? "extensions/wikia/hacks/PhotoPop/" : '') + "shared/audio/";
			
		this.sounds = {
			"win": new Audio(path + counfigSounds.win + ".wav" ),
			"fail": new Audio(path + counfigSounds.fail + ".wav" ),
			"pop": new Audio(path + counfigSounds.pop + ".wav" ),
			"timeEnd": new Audio(path + counfigSounds.timeEnd + ".wav" ),
			"wrongAnswer": new Audio(path + counfigSounds.wrongAnswer + ".wav" )
		}
	},
	
	play: function(sound) {
		if(!this.mute) {
			this.sounds[sound].play();		
		}
	}
});