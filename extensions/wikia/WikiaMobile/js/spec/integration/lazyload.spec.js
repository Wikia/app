/*global describe, it, runs, waitsFor, expect, require, document*/

describe("Lazyload module", function () {

	var body = getBody();

	body.innerHTML = '<div id="wkPage"><section id="mw-content-text"></section></div>' +
		'<div id="wkPage"><section id="mw-content-text"><img alt="Sectionals2.jpg" width="480" height="207" ' +
		'data-src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="lazy media" ' +
		'data-params="[{&quot;name&quot;:&quot;Sectionals2.jpg&quot;,&quot;full&quot;:&quot;data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D&quot;}]">' +
		'</section></div>';

	var Image = function(){};

	Image.prototype.__defineSetter__('onload', function(onload){
		onload.call(this);
		jasmine.Clock.tick(250);
	});

	var lazyload = modules.lazyload({
		isThumbUrl: function(){},
		getThumbURL: function(a){
			return a;
		}
	}, {
		makeArray: function(array){
			return Array.prototype.slice.call(array);
		}
	},{
		addEventListener: function(){},
		Image: Image
	});

	it('is defined', function(){
		expect(lazyload).toBeDefined();
	});

	it('lazyloads images', function(){
		var images = body.getElementsByClassName('lazy');

		jasmine.Clock.useMock();

		lazyload(images);

		expect(images[0].className).toContain('load loaded');
		expect(images[0].src).toMatch('data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D');
	});

});