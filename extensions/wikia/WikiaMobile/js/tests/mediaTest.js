/*
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/media.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Media module", function () {
	'use strict';

	window.wgStyleVersion = 123;

	var qsMock = function() {
			return {
				getVal: function(){}
			}
		},
		media;

	// ['JSMessages', 'modal', 'loader', 'querystring', require.optional('popover'), 'track', require.optional('share'), require.optional('cache')]
	media = define.getModule(undefined, undefined, undefined, qsMock, undefined, undefined);

	it('should be defined', function(){
		expect(media).toBeDefined();

		expect(typeof media.openModal).toBe('function');
		expect(typeof media.getImages).toBe('function');
		expect(typeof media.getCurrent).toBe('function');
		expect(typeof media.hideShare).toBe('function');
		expect(typeof media.init).toBe('function');
		expect(typeof media.cleanup).toBe('function');
	});
/**
	it('should init', function(){
		document.body.innerHTML = '<img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;0&quot;}]"><img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;1&quot;}]"><img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;2&quot;}]"><img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;3&quot;}]"><img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;4&quot;}]">' +
		'<img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="vid.mp4" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;video&quot;,&quot;full&quot;:&quot;link_to_vid.mp4&quot;,&quot;capt&quot;:&quot;5&quot;,&quot;type&quot;:&quot;video&quot;}]">' +
			'<img alt="Bo 2 wii.jpg" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="256" height="360" data-src="http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg" class="lazy noSect" data-params="[{&quot;name&quot;:&quot;Bo 2 wii.jpg&quot;,&quot;full&quot;:&quot;http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg&quot;,&quot;capt&quot;:&quot;0&quot;}]">';

		media.init(document.getElementsByTagName('img'));

		var imgs = media.getImages();

		for(var i = 0, l = imgs.length-2; i < l; i++){
			expect(imgs[i].element).toBeDefined();
			expect(imgs[i].url).toBe('http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg');
			expect(imgs[i].name).toBe('Bo 2 wii.jpg');
			expect(imgs[i].caption).toBe(i + '');
			expect(imgs[i].type).not.toBeDefined();
		}

		expect(imgs[5].isVideo).toBeDefined();
		expect(imgs[5].isVideo).toBe(true);
	});

	it('should open modal', function(done){
		document.body.innerHTML += "<div id=wkMdlWrp><div id=wkMdlTB><div id=wkMdlTlBar></div><div id=wkMdlClo class=clsIco></div></div><div id=wkMdlCnt></div><div id=wkMdlFtr></div></div>";

		media.openModal(0);

		expect(document.getElementById('wkMdlWrp').className).toBe(' imgMdl');
		expect(document.getElementById('wkMdlTlBar').childElementCount).toBe(2);
	});
**/
});
