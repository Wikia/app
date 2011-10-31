var exports = exports || {};

define.call(exports, function(){
	
	var sounds = {},
	mute = false,
	isApp = Wikia.Platform.is('app');
	
	return {
		init: function(configSounds){
			var prefix = ((isApp) ? '' : "extensions/wikia/hacks/PhotoPop/") + "shared/audio/",
			path;
			mute = store.get('mute') || false;
			
			for(var p in configSounds){
				path = prefix + configSounds[p] + ".wav";
				sounds[p] = (isApp) ? path : new Audio(path);
			}
		},
		
		play: function(sound) {
			if(isApp)
				Titanium.App.fireEvent('sounds:play', {sound: sounds[sound], mute: mute});
			else{
				if(sound == 'win' || sound == 'fail'){
					for(var p in sounds){
						sounds[p].currentTime = 0;
						sounds[p].pause();
					}
				}
				sounds[sound].play();
			}
		},
		
		setMute: function(flag) {
			mute = flag;
			
			for(var sound in sounds){
				sounds[sound].muted = mute;
			}
			
			store.set('mute', mute);
			return mute;
		},
		
		getMute: function(){
			return mute;
		},
		
		toggleMute: function(){
			return this.setMute(!this.getMute());
		}
	};
});