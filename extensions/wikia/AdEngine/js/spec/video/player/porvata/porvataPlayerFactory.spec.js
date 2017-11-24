describe('ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory', function () {
	'use strict';

	var WIDTH = 100,
		HEIGHT = 100,
		mocks = {
		ima: {
			addEventListener: noop,
			dispatchEvent: noop,
			getAdsManager: noop,
			getStatus: noop,
			playVideo: noop,
			reload: noop,
			resize: noop
		},
		adsManager: {
			getRemainingTime: noop,
			getVolume: noop,
			pause: noop,
			resume: noop,
			setVolume: noop,
			stop: noop
		},
		domElementTweaker: {
			show: noop,
			hide: noop
		},
		doc: {
			documentElement: {
				classList: {
					add: noop,
					remove: noop
				}
			}
		},
		videoSettings: {
			getParams: function () {
				return {
					width: WIDTH,
					height: HEIGHT,
					container: {
						querySelector: function () {
							return {
								style: {},
								classList: {
									add: noop
								}
							};
						}
					}
				};
			},
			isAutoPlay: function () {
				return false;
			}
		}
	};

	function logMock() {
	}

	function noop() {
	}

	logMock.levels = {};

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory'](mocks.domElementTweaker, mocks.doc, logMock);
	}

	it('player created with all properties', function () {
		var module = getModule(),
			createdPlayer = module.create(mocks.videoSettings, mocks.ima);

		expect(createdPlayer.container).toBeDefined();
		expect(createdPlayer.ima).toEqual(mocks.ima);
		expect(typeof createdPlayer.addEventListener).toBe('function');
		expect(typeof createdPlayer.getRemainingTime).toBe('function');
		expect(typeof createdPlayer.isMuted).toBe('function');
		expect(typeof createdPlayer.isPaused).toBe('function');
		expect(typeof createdPlayer.isPlaying).toBe('function');
		expect(typeof createdPlayer.pause).toBe('function');
		expect(typeof createdPlayer.play).toBe('function');
		expect(typeof createdPlayer.reload).toBe('function');
		expect(typeof createdPlayer.resize).toBe('function');
		expect(typeof createdPlayer.resume).toBe('function');
		expect(typeof createdPlayer.setVolume).toBe('function');
		expect(typeof createdPlayer.stop).toBe('function');
	});

	it('IMA is called', function () {
		var imaAddEventListenerSpy = spyOn(mocks.ima, 'addEventListener'),
			getStatusSpy = spyOn(mocks.ima, 'getStatus').and.returnValue('paused'),
			playSpy = spyOn(mocks.ima, 'playVideo'),
			reloadSpy = spyOn(mocks.ima, 'reload'),
			resizeSpy = spyOn(mocks.ima, 'resize'),
			getRemainingTimeSpy = spyOn(mocks.adsManager, 'getRemainingTime').and.returnValue('777'),
			getVolumeSpy = spyOn(mocks.adsManager, 'getVolume').and.returnValue(75),
			pauseSpy = spyOn(mocks.adsManager, 'pause'),
			resumeSpy = spyOn(mocks.adsManager, 'resume'),
			setVolumeSpy = spyOn(mocks.adsManager, 'setVolume'),
			stopSpy = spyOn(mocks.adsManager, 'stop'),
			module = getModule(),
			createdPlayer = module.create(mocks.videoSettings, mocks.ima);

		spyOn(mocks.ima, 'getAdsManager').and.returnValue(mocks.adsManager);

		createdPlayer.addEventListener('foo', noop);
		expect(imaAddEventListenerSpy).toHaveBeenCalledWith('foo', noop);

		expect(createdPlayer.getRemainingTime()).toEqual('777');
		expect(getRemainingTimeSpy).toHaveBeenCalled();

		expect(createdPlayer.isMuted()).toEqual(false);
		expect(getVolumeSpy).toHaveBeenCalled();

		expect(createdPlayer.isPaused()).toEqual(true);
		expect(getStatusSpy).toHaveBeenCalled();

		createdPlayer.pause();
		expect(pauseSpy).toHaveBeenCalled();

		createdPlayer.play(300, 500);
		expect(playSpy).toHaveBeenCalledWith(300, 500);
		playSpy.calls.reset();

		createdPlayer = module.create(mocks.videoSettings, mocks.ima);
		createdPlayer.play(undefined, 500);
		expect(playSpy).toHaveBeenCalledWith(WIDTH, HEIGHT);

		createdPlayer.reload();
		expect(reloadSpy).toHaveBeenCalled();

		createdPlayer.reload('foo');
		expect(reloadSpy).toHaveBeenCalledWith('foo');

		createdPlayer.resize(600, 600);
		expect(resizeSpy).toHaveBeenCalledWith(600, 600);

		createdPlayer.resume();
		expect(resumeSpy).toHaveBeenCalled();

		createdPlayer.setVolume(100);
		expect(setVolumeSpy).toHaveBeenCalledWith(100);

		createdPlayer.stop();
		expect(stopSpy).toHaveBeenCalled();

	});
});
