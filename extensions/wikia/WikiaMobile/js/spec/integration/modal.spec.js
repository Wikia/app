/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Modal module", function () {
	'use strict';
	var timerCallback,
		open,
		close;

	var trueFeatures = window.Features;

	window.Features = {};

	beforeEach(function() {
		timerCallback = jasmine.createSpy('timerCallback');
		jasmine.Clock.useMock();
	});

	var modal = modules.modal({
		show: function(){},
		hide: function(){},
		remove: function(){}
	}, jQuery);

	it('should be defined', function(){

		getBody().innerHTML = "<div id=wkMdlWrp><div id=wkMdlTB><div id=wkMdlTlBar></div><div id=wkMdlClo class=clsIco></div></div><div id=wkMdlCnt></div><div id=wkMdlFtr></div></div>";

		expect(modal).toBeDefined();

		expect(typeof modal.setCaption).toBe('function');
		expect(typeof modal.setToolbar).toBe('function');
		expect(typeof modal.open).toBe('function');
		expect(typeof modal.close).toBe('function');
		expect(typeof modal.isOpen).toBe('function');
		expect(typeof modal.getWrapper).toBe('function');
		expect(typeof modal.showUI).toBe('function');
		expect(typeof modal.hideUI).toBe('function');
		expect(typeof modal.setStopHiding).toBe('function');
		expect(typeof modal.addClass).toBe('function');
		expect(typeof modal.removeClass).toBe('function');
	});

	it('should init itself on open', function(){
		var wrap = document.getElementById('wkMdlWrp');

		window.scrollY = 30;

		modal.open({
			content: 'TEST',
			onOpen: function(){
				open = true;
			},
			onClose: function(){
				close = true;
			}
		});

		expect(window.location.hash).toBe('#Modal');

		jasmine.Clock.tick(60);

		expect(document.getElementById('wkMdlCnt').innerHTML).toBe('TEST');
		expect(wrap.className).toMatch('zoomer open');
		expect(wrap.style.top).toMatch('30px');

		jasmine.Clock.tick(310);

		expect(document.documentElement.className).toMatch('modal');
		expect(wrap.className).toMatch('zoomer open');
		expect(wrap.style.top).toMatch('0px');

		expect(open).toBe(true);
	});

	it('should close modal', function(){
		var wrap = document.getElementById('wkMdlWrp');

		modal.close();

		expect(document.documentElement.className).not.toMatch(' modal');

		jasmine.Clock.tick(15);

		expect(wrap.className).toBe('zoomer');
		expect(wrap.style.top).toMatch('30px');

		jasmine.Clock.tick(320);

		expect(document.getElementById('wkMdlCnt').innerHTML).toBe('');
		expect(document.getElementById('wkMdlTlBar').innerHTML).toBe('');
		expect(document.getElementById('wkMdlFtr').innerHTML).toBe('');
		expect(document.getElementById('wkMdlFtr').className).toBe('');

		expect(wrap.style.top).toMatch('0px');

		expect(close).toBe(true);
	});

	it('should handle toolbar correctly', function(){
		modal.open({
			content: 'TEST',
			toolbar: 'TEST'
		});

		expect(document.getElementById('wkMdlTlBar').innerHTML).toBe('TEST');
		expect(document.getElementById('wkMdlTlBar').style.display).toBe('block');

		modal.setToolbar();

		expect(document.getElementById('wkMdlTlBar').style.display).toBe('none');

		modal.setToolbar('NUMANUMAHYAY');

		expect(document.getElementById('wkMdlTlBar').innerHTML).toBe('NUMANUMAHYAY');
		expect(document.getElementById('wkMdlTlBar').style.display).toBe('block');
	});

	it('should handle caption correctly', function(){
		modal.open({
			content: 'TEST',
			caption: 'TEST'
		});

		expect(document.getElementById('wkMdlFtr').innerHTML).toBe('TEST');
		expect(document.getElementById('wkMdlFtr').style.display).toBe('block');

		modal.setCaption();

		expect(document.getElementById('wkMdlFtr').innerHTML).toBe('TEST');
		expect(document.getElementById('wkMdlFtr').style.display).toBe('none');

		modal.setCaption('EXAMPLE');

		expect(document.getElementById('wkMdlFtr').innerHTML).toBe('EXAMPLE');
		expect(document.getElementById('wkMdlFtr').style.display).toBe('block');
	});

	it('should handle content correctly', function(){
		modal.open({
			content: 'TEST'
		});

		expect(document.getElementById('wkMdlCnt').innerHTML).toBe('TEST');

		modal.setContent();
		expect(document.getElementById('wkMdlCnt').innerHTML).toBe('TEST');

		modal.setContent('EXAMPLE');
		expect(document.getElementById('wkMdlCnt').innerHTML).toBe('EXAMPLE');

	});

	it('should return wrapper', function(){
		var wrap = document.getElementById('wkMdlWrp');
		expect(modal.getWrapper()).toBe(wrap);
	});

	it('should add/remove class', function(done){
		var wrap = document.getElementById('wkMdlWrp');

		modal.addClass('ClassyClass');
		expect(wrap.className).toMatch('ClassyClass');

		modal.removeClass('ClassyClass');
		expect(wrap.className).not.toMatch('ClassyClass');
	});

	it('should return if modal is open', function(){
		modal.open({
			content: 'WhatevZ'
		});

		expect(modal.isOpen()).toBe(true)

		modal.close();

		expect(modal.isOpen()).toBe(false);
	});

	 window.Features = trueFeatures;
});
