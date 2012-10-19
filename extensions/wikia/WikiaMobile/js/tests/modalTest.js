/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/loader.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/modal.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/

describe("Modal module", function () {
	'use strict';
	var async = new AsyncSpec(this),
		timerCallback,
		open,
		close;

	window.Features = {};

	beforeEach(function() {
		timerCallback = jasmine.createSpy('timerCallback');
		jasmine.Clock.useMock();
	});

	async.it('should be defined', function(done){

		document.body.innerHTML = "<div id=wkMdlWrp><div id=wkMdlTB><div id=wkMdlTlBar></div><div id=wkMdlClo class=clsIco></div></div><div id=wkMdlCnt></div><div id=wkMdlFtr></div></div>";

		require(['modal'], function(modal){
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

			done();
		});

		jasmine.Clock.tick(1);
	});

	async.it('should init itself on open', function(done){
		var wrap = document.getElementById('wkMdlWrp');

		require(['modal'], function(modal){

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

			done();

		});

		jasmine.Clock.tick(1);
	});

	async.it('should close modal', function(done){
		var wrap = document.getElementById('wkMdlWrp');

		require(['modal'], function(modal){

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

			expect(close).toBe(true)

			done();

		});

		jasmine.Clock.tick(1);
	});

	async.it('should handle toolbar correctly', function(done){
		var wrap = document.getElementById('wkMdlWrp');

		require(['modal'], function(modal){

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


			done();

		});

		jasmine.Clock.tick(1);
	});

	async.it('should handle caption correctly', function(done){
		var wrap = document.getElementById('wkMdlWrp');

		require(['modal'], function(modal){

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


			done();
		});

		jasmine.Clock.tick(1);
	});

	async.it('should handle content correctly', function(done){
		var wrap = document.getElementById('wkMdlWrp');

		require(['modal'], function(modal){

			modal.open({
				content: 'TEST'
			});

			expect(document.getElementById('wkMdlCnt').innerHTML).toBe('TEST');

			modal.setContent();
			expect(document.getElementById('wkMdlCnt').innerHTML).toBe('TEST');

			modal.setContent('EXAMPLE');
			expect(document.getElementById('wkMdlCnt').innerHTML).toBe('EXAMPLE');

			done();
		});

		jasmine.Clock.tick(1);
	});

	async.it('should return wrapper', function(done){
		var wrap = document.getElementById('wkMdlWrp');

		require(['modal'], function(modal){

			expect(modal.getWrapper()).toBe(wrap);

			done();
		});

		jasmine.Clock.tick(1);
	});

	async.it('should add/remove class', function(done){
		var wrap = document.getElementById('wkMdlWrp');

		require(['modal'], function(modal){

			modal.addClass('ClassyClass');
			expect(wrap.className).toMatch(' ClassyClass');

			modal.removeClass('ClassyClass');
			expect(wrap.className).not.toMatch(' ClassyClass');

			done();
		});

		jasmine.Clock.tick(1);
	});

	async.it('should return if modal is open', function(done){
		var wrap = document.getElementById('wkMdlWrp');

		require(['modal'], function(modal){

			modal.open({
				content: 'WhatevZ'
			});

			expect(modal.isOpen()).toBe(true)

			modal.close();

			expect(modal.isOpen()).toBe(false);

			done();
		});

		jasmine.Clock.tick(1);
	});

});