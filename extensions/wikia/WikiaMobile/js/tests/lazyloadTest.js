/*
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/lazyload.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
window.addEventListener('load', function(){
	'use strict';

	var async = new AsyncSpec(this);

	document.body.innerHTML = '<div id="wkPage"><section id="mw-content-text"></section></div>';

	describe("Lazyload module", function () {
		var lazyload = define.getModule({
			isThumbUrl: function(){},
			getThumbURL: function(a){
				return a;
			}
		});

		it('is defined', function(){
			expect(lazyload).toBeDefined();
		});

		async.it('lazyloads images', function(done){
			document.body.innerHTML = '<div id="wkPage"><section id="mw-content-text"><img alt="Sectionals2.jpg" width="480" height="207" data-src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="lazy media" data-params="[{&quot;name&quot;:&quot;Sectionals2.jpg&quot;,&quot;full&quot;:&quot;data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D&quot;}]"></section></div>';

			lazyload(document.getElementsByClassName('lazy'));

			var img = document.getElementsByTagName('img')[0];

			img.addEventListener('load', function(){
				expect(img.src).toMatch('data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D');

				done();
			});


		});

	});
});
