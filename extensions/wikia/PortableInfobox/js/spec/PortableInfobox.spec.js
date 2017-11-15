/* global beforeEach, describe, it, expect, jasmine, mw, $ */

describe('Portable Infobox', function () {
	describe('collapsible sections', function () {
		var portableInfoboxHtml = `
		<section class="pi-item pi-group pi-border-color pi-collapse">
			<h2 class="pi-item pi-header pi-secondary-font pi-item-spacing pi-secondary-background">Bugged</h2>
			<div class="pi-item pi-data pi-item-spacing pi-border-color">
				<div class="pi-data-value pi-font">
					<figure class="article-thumb tleft show-info-icon" style="width: 250px">
						<a href="/wiki/User:PanSola" class="image image-thumbnail link-internal" title="User:PanSola">
							<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" alt="Wookieepedia" class="thumbimage lzy lzyPlcHld " data-image-key="Wookieepedia.png" data-image-name="Wookieepedia.png" data-src="https://vignette.wikia.nocookie.net/infobox/images/b/b1/Wookieepedia.png/revision/latest?cb=20160107195313" width="250" height="65" onload="if(typeof ImgLzy==='object'){ImgLzy.load(this)}">
							<noscript>&lt;img src="https://vignette.wikia.nocookie.net/infobox/images/b/b1/Wookieepedia.png/revision/latest?cb=20160107195313" 	 alt="Wookieepedia"  	class="thumbimage " 	 	data-image-key="Wookieepedia.png" 	data-image-name="Wookieepedia.png" 	 	 width="250"  	 height="65"  	 	 	 	&gt;</noscript></a>
							<figcaption><a href="/wiki/File:Wookieepedia.png" class="sprite info-icon"></a></figcaption>
					</figure>
				</div>
			</div>
		</section>
		`,
			div = document.createElement('div');

		beforeEach(function () {
			div.innerHTML = portableInfoboxHtml;

			mw.hook('wikipage.content').fire($(div));
		});

		it('collapsed state is toggled on collapsible header click', function () {
			var portableInfoboxHeader = div.querySelector('.pi-header');

			portableInfoboxHeader.click();

			expect(div.querySelector('.pi-collapse').className).toContain('pi-collapse-closed');

			portableInfoboxHeader.click();

			expect(div.querySelector('.pi-collapse').className).not.toContain('pi-collapse-closed');
		});

		it('emit global scroll event on collapsible header click', function () {
			var portableInfoboxHeader = div.querySelector('.pi-header'),
				scrollSpy = jasmine.createSpy('scrollSpy');

			$(window).on('scroll', scrollSpy);

			portableInfoboxHeader.click();
			portableInfoboxHeader.click();

			expect(scrollSpy).toHaveBeenCalledTimes(2);
		});
	});
});
