/**
 * module used to handle category pages pagination
 *
 * @param events.js events
 * @param loader.js loader
 * @param track.js track
 */
/* global wgTitle */
require(['events', 'loader', 'track'], function (events, loader, track) {
	'use strict';

	var d = document,
		clickEvent = events.click,
		expAll = d.getElementById('expAll'),
		elements,
		wkCatExh = d.getElementById('wkCatExh'),
		categorySection = d.getElementsByClassName('alphaSec')[0],
		i,
		l;

	if (expAll) {
		elements = d.querySelectorAll('.alphaSec .artSec, .alphaSec .collSec');
		l = elements.length;

		expAll.addEventListener(clickEvent, function() {
			if (this.className.indexOf('exp') > -1) {
				this.className = this.className.replace(' exp', '');

				for(i = 0; i < l; i++){
					elements[i].className = elements[i].className.replace(' open', '');
				}
			} else {
				this.className += ' exp';

				for(i = 0; i < l; i++){
					elements[i].className += ' open';
				}
			}
		});
	}

	if (wkCatExh) {
		wkCatExh.addEventListener(clickEvent, function (ev) {
			var t = ev.target;
			if (t.tagName == 'A') {
				track.event('category', track.IMAGE_LINK, {
					label: 'exhibition',
					href: t.href
				});
			}

		});
	}

	if (categorySection) {
		categorySection.addEventListener(clickEvent, function (ev) {
			var t = ev.target;

			if (t.tagName == 'A' && t.parentElement.className.indexOf('cld') > -1) {
				ev.preventDefault();
				track.event('category', track.TEXT_LINK, {
					label: 'category',
					href: t.href
				});
			} else if(t.className.indexOf('pag') > -1) {
				onClick.call(t, ev);
			}
		});
	}

	/**
	 * @param MouseEvent event
	 */
	function onClick(event) {
		event.preventDefault();
		var self = this,
			forward = (self.className.indexOf('pagMore') > -1),
			parent = self.parentElement,
			prev = (forward) ? parent.getElementsByClassName('pagLess')[0] : self,
			prevBatch = ~~(prev.getAttribute('data-batch')),
			next = (forward) ? self : parent.getElementsByClassName('pagMore')[0],
			nextBatch = prevBatch + 2,
			batch = (forward) ? nextBatch : prevBatch,
			add = (forward ? 1 : -1),
			id = parent.id,
			container = parent.getElementsByTagName('ul')[0];

		prev.setAttribute('data-batch', prevBatch + add);
		next.setAttribute('data-batch', nextBatch + add);

		loader.show(self, {size: '40px'});

		self.className += ' active';

		Wikia.nirvana.sendRequest({
			controller: 'WikiaMobileController',
			method: 'getCategoryBatch',
			format: 'html',
			type: 'GET',
			data: {
				category: wgTitle,
				batch: batch,
				//this is already encoded and $.ajax encode all data
				index: decodeURIComponent(id.slice(8))
			},
			callback: function (result) {
				container.parentElement.removeChild(container);
				next.insertAdjacentHTML('beforebegin', result);

				if (forward) {
					parent.previousElementSibling.scrollIntoView();
					track.event('category', track.PAGINATE, {label: 'next'});
				} else {
					track.event('category', track.PAGINATE, {label: 'previous'});
				}

				loader.hide(self);

				prev.className = 'pagLess' + (batch > 1 ? ' visible' : '');
				next.className = 'pagMore' + (batch < ~~(parent.getAttribute('data-batches')) ? ' visible' : '');
			}
		});
	}
});
