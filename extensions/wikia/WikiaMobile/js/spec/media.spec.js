/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Media module", function () {
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


	function MediaClass(data){
		this.url = data.image.full;
		this.name = data.image.name;
		this.caption = data.image.capt;
		this.type = data.image.type;
		this.element = data.image
	}

	MediaClass.types = {
		VIDEO: 'video',
		IMAGE: 'image'
	};

	loader.MULTI = '';

	media = modules.media(null, modal, null, qsMock, null,null, null, null, loader, null, null, MediaClass);

	it('should be defined', function(){
		expect(media).toBeDefined();

		expect(typeof media.openModal).toBe('function');
		expect(typeof media.getMedia).toBe('function');
		expect(typeof media.getCurrent).toBe('function');
		expect(typeof media.hideShare).toBe('function');
		expect(typeof media.init).toBe('function');
		expect(typeof media.cleanup).toBe('function');
	});

	it('should init and parse elements', function(){
		function Elem(data){
			this.data = data;
			this.props = {}
		}

		Elem.prototype.getAttribute = function(){
			return this.data;
		};

		Elem.prototype.setAttribute = function(){};

		media.init([
			new Elem('[{"name":"Bo 2 wii.jpg","full":"http:\/\/images.jolek.wikia-dev.com\/__cb20120915045654\/callofduty\/images\/5\/50\/Bo_2_wii.jpg","capt":"0","type":"image"}]'),
			new Elem('[{"name":"video","full":"link_to_vid.mp4","capt":"5","type":"video"}]')
		]);

		var imgs = media.getMedia();

		expect(imgs[0].element).toBeDefined();
		expect(imgs[0].url).toBe('http://images.jolek.wikia-dev.com/__cb20120915045654/callofduty/images/5/50/Bo_2_wii.jpg');
		expect(imgs[0].name).toBe('Bo 2 wii.jpg');
		expect(imgs[0].caption).toBe(0 + '');
		expect(imgs[0].type).toBe('image');
		expect(imgs[1].type).toBe('video');
	});
});
