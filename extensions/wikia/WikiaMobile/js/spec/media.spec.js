/*global describe, it, runs, waitsFor, expect, require, document*/
ddescribe("Media module", function () {
	'use strict';

	window.wgStyleVersion = 123;

	var qsMock = function() {
			return {
				getVal: function(){}
			}
		},
		modal = {
			open: function(){},
			getWrapper: function(){}
		},
		loader = function(){
			return {
				done: function(func) {
					//func({});
				}
			}
		},
		media;

	loader.MULTI = '';

	media = modules.media(null, modal, null, qsMock, null,null, null, null, loader, null);

	it('should be defined', function(){
		expect(media).toBeDefined();

		expect(typeof media.openModal).toBe('function');
		expect(typeof media.getImages).toBe('function');
		expect(typeof media.getCurrent).toBe('function');
		expect(typeof media.hideShare).toBe('function');
		expect(typeof media.init).toBe('function');
		expect(typeof media.cleanup).toBe('function');
	});

	it('should init', function(){
		var body = getBody();

		body.innerHTML = '<img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;0&quot;}]"><img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;1&quot;}]"><img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;2&quot;}]"><img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;3&quot;}]"><img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;4&quot;}]">' +
		'<img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="vid.mp4" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;video&quot;,&quot;full&quot;:&quot;link_to_vid.mp4&quot;,&quot;capt&quot;:&quot;5&quot;,&quot;type&quot;:&quot;video&quot;}]">' +
			'<img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;0&quot;}]">';

		media.init(body.getElementsByTagName('img'));

		var imgs = media.getImages();

		for(var i = 0, l = imgs.length-2; i < l; i++){
			expect(imgs[i].element).toBeDefined();
			expect(imgs[i].url).toBe('http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg');
			expect(imgs[i].name).toBe('Bo 2 wii.jpg');
			expect(imgs[i].caption).toBe(i + '');
			expect(imgs[i].type).not.toBeDefined();
		}

		expect(imgs[5].isVideo).toBeTruthy();
	});
});
