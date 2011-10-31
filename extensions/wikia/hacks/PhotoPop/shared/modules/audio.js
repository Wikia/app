var exports = exports || {};

define.call(exports, [
			'modules/data',
			'modules/settings'
		],

	function(data, settings){

		data.storage.addEventListener({name: "get", key: "mute"}, function(event) {
			mute = event.value || false;
		});

		var sounds = {},
		mute = false,
		isApp = Wikia.Platform.is('app'),
		prefix = ((isApp) ? '' : "extensions/wikia/hacks/PhotoPop/") + "shared/audio/",
		path,
		audioFiles = settings.sounds;

		data.storage.get('mute')

		for(var p in audioFiles){
			path = prefix + audioFiles[p] + ".wav";
			sounds[p] = (isApp) ? path : new Audio(path);
		}

		return {
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

				data.storage.set('mute', mute);
				return mute;
			},

			getMute: function(){
				return mute;
			},

			toggleMute: function(){
				return this.setMute(!this.getMute());
			}
		};
	}
);