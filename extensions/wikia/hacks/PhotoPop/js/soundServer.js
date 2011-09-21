var soundServer = {
	
	sounds: {},
	
	mute: false,
	
	init: function(counfigSounds) {
		var 	path = "extensions/wikia/hacks/PhotoPop/audio/";
			
		soundServer.sounds = {
			"win": new Audio(path + counfigSounds.win + ".wav" ),
			"fail": new Audio(path + counfigSounds.fail + ".wav" ),
			"pop": new Audio(path + counfigSounds.pop + ".wav" ),
			"timeEnd": new Audio(path + counfigSounds.timeEnd + ".wav" ),
			"wrongAnswer": new Audio(path + counfigSounds.wrongAnswer + ".wav" )
		}
	},
	
	play: function(sound) {
		if(!soundServer.mute) {
			soundServer.sounds[sound].play();		
		}

	}
}