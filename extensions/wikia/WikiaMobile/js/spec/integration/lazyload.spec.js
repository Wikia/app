/*global describe, it, runs, waitsFor, expect, require, document*/

describe("Lazyload module", function () {

	var body = getBody();

	body.innerHTML = '<div id="wkPage"><section id="mw-content-text"></section></div>' +
		'<div id="wkPage"><section id="mw-content-text"><img alt="Sectionals2.jpg" width="480" height="207" ' +
		'data-src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="lazy media" ' +
		'data-params="[{&quot;name&quot;:&quot;Sectionals2.jpg&quot;,&quot;full&quot;:&quot;data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D&quot;}]">' +
		'</section></div>';

	var async = new AsyncSpec(this);

	var lazyload = modules.lazyload({
		isThumbUrl: function(){},
		getThumbURL: function(a){
			return a;
		}
	}, {
		makeArray: function(array){
			return Array.prototype.slice.call(array);
		}
	});

	it('is defined', function(){
		expect(lazyload).toBeDefined();
	});

	async.it('lazyloads images', function(done){
		lazyload(body.getElementsByClassName('lazy'));

		body.getElementsByClassName('lazy')[0].addEventListener('load', function(){
			expect(body.getElementsByClassName('lazy')[0].src).toMatch('data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D');

			done();
		})

	});

});