/* global Wikia, Audio, Titanium*/
var exports = exports || {};

define.call(exports, [
			'modules/data',
			'modules/settings'
		],

	function(data, settings){
		var sounds = {},
		mute = false,
		isApp = Wikia.Platform.is('app'),
		checkAudioSupport = new Audio(),
		prefix = (isApp) ? settings.sharedAudioPath : settings.webPrefix + ((checkAudioSupport.canPlayType('audio/mpeg')) ? settings.sharedAudioPath : settings.webAudioPath),
		path,
		audioFiles = settings.sounds,
		ext = (function() {
			if(isApp || checkAudioSupport.canPlayType('audio/mpeg')) {
				return '.mp3';
			} else if (checkAudioSupport.canPlayType('audio/ogg')) {
				return '.ogg';
			} else {
				return '.wav';
			}})();

		function getMute(){
			return mute;
		}

		data.storage.addEventListener({name: "get", key: "mute"}, function(event, options) {
			mute = options.value || false;
		});
		data.storage.get('mute');

		for(var p in audioFiles){
			path = prefix + audioFiles[p] + ext;
			sounds[p] = (isApp) ? path : new Audio(path);
		}

		return {
			play: function(sound) {
				if(isApp)
					Titanium.App.fireEvent('audio:play', {sound: sounds[sound], mute: getMute()});
				else{
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
				return (mute == true);
			},

			toggleMute: function(){
				return this.setMute(!this.getMute());
			}
		};
	}
);