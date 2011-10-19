var exports = exports || {};

define.call(exports, function(){
	
	var sounds = {},
	mute = false,
	titanium = typeof Titanium != 'undefined';
	
	return {
		init: function(configSounds){
			var prefix = ((titanium) ? '' : "extensions/wikia/hacks/PhotoPop/") + "shared/audio/",
			path;
			mute = store.get('mute') || false;
			for(var p in configSounds){
				path = prefix + configSounds[p] + ".wav";
				sounds[p] = (titanium) ? path : new Audio(path);
			}
		},
		
		play: function(sound) {
			if(titanium)
				Titanium.App.fireEvent('soundServer:play', {sound: sounds[sound]});
			else {
				if(sound == 'win' || sound == 'fail') {
					for(var p in sounds) {
						sounds[p].pause();
						sounds[p].currentTime = 0;	
					}
				}
				sounds[sound].play();
			}
		},
		
		setMute: function(flag) {
			mute = flag;
			for(var sound in sounds) {
				sounds[sound].muted = mute;
			}
			store.set('mute', mute);
		},
		
		getMute: function(){
			return mute;
		}
	};
});