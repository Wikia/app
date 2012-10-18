/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/loader.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/popover.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Popover module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	function fire(event, element){
		var evt = document.createEvent("HTMLEvents");
		evt.initEvent(event, true, true); // event type,bubbling,cancelable
		return !element.dispatchEvent(evt);
	}

	async.it('should be defined as module', function(done){
		require(['popover'], function(pop){
			expect(pop).toBeDefined();
			expect(typeof pop).toBe('function');
			done();
		});
	});

	async.it('should throw exception', function(done){
		document.body.innerHTML = '<div id="popover"></div>';

		require(['popover'], function(pop){

			expect(function(){
				pop();
			}).toThrow();

			expect(function(){
				pop({
					on: document.getElementById('asd')
				});
			}).toThrow();

			done();
		});
	});

	async.it('should set position correctly', function(done){
		document.body.innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		require(['popover'], function(pop){
			var p = pop({
				on: container,
				create: 'TESTTHIS',
				position: 'top'
			});

			fire('click', container);

			expect(container.className).toMatch('top');

			done();
		});

		require(['popover'], function(pop){
			document.body.innerHTML = '<div id="popover"></div>';
			container = document.getElementById('popover');

			var p = pop({
				on: container,
				create: 'TESTTHIS',
				position: 'left'
			});

			fire('click', container);

			expect(container.className).toMatch('left');

			done();
		});

		require(['popover'], function(pop){
			document.body.innerHTML = '<div id="popover"></div>';
			container = document.getElementById('popover');

			var p = pop({
				on: container,
				create: 'TESTTHIS',
				position: 'right'
			});

			fire('click', container);

			expect(container.className).toMatch('right');

			done();
		});

		require(['popover'], function(pop){
			document.body.innerHTML = '<div id="popover"></div>';
			container = document.getElementById('popover');

			var p = pop({
				on: container,
				create: 'TESTTHIS',
				position: 'bottom'
			});

			fire('click', container);

			expect(container.className).toMatch('bottom');

			done();
		});

		require(['popover'], function(pop){
			document.body.innerHTML = '<div id="popover"></div>';
			container = document.getElementById('popover');

			var p = pop({
				on: container,
				create: 'TESTTHIS'
			});

			fire('click', container);

			expect(container.className).toMatch('bottom');

			done();
		});
	});

	async.it('should open/close popover', function(done){
		document.body.innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		require(['popover'], function(pop){
			var p = pop({
				on: container
			});

			fire('click', container);

			expect(container.innerHTML).toBe('<div class="ppOvr" style="top: 13px; "></div>');

			p.open();

			expect(container.className).toMatch('on');

			p.close();

			expect(container.className).not.toMatch('on');

			done();
		});
	});

	async.it('should set a text of popover', function(done){
		document.body.innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		require(['popover'], function(pop){
			var p = pop({
				on: container,
				create: 'TESTTHIS'
			});

			fire('click', container);

			expect(container.innerText).toBe('TESTTHIS');

			done();
		});
	});

	async.it('should set a text of popover with a function', function(done){
		document.body.innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		require(['popover'], function(pop){
			var p = pop({
				on: container,
				create: function(cnt){
					cnt.innerText = 'TESTTHIS';
				}
			});

			fire('click', container);

			expect(container.innerText).toBe('TESTTHIS');

			done();
		});
	});

	async.it('should change content', function(done){
		document.body.innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		require(['popover'], function(pop){
			var p = pop({
				on: container,
				create: 'TESTTHIS'
			});

			fire('click', container);

			expect(container.innerText).toBe('TESTTHIS');

			p.changeContent(function(cnt){
					cnt.innerText = 'TEXTTHISNUMBET2';
			});

			expect(container.innerText).toBe('TEXTTHISNUMBET2');

			done();
		});
	});

	async.it('should run onopen callback', function(done){
		document.body.innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		require(['popover'], function(pop){
			var p = pop({
				on: container,
				create: 'TESTTHIS',
				open: function(){
					done();
				}
			});

			fire('click', container);
		});
	});

	async.it('should run onclose callback', function(done){
		document.body.innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		require(['popover'], function(pop){
			var p = pop({
				on: container,
				create: 'TESTTHIS',
				close: function(){
					done();
				}
			});

			fire('click', container);
			fire('click', container);

		});
	});

});