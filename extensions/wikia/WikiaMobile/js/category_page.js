/**
 * module used to handle category pages pagination
 *
 * @param throbber.js throbber
 * @param track.js track
 */
/* global wgTitle */
require(['throbber', 'track', 'wikia.nirvana', 'wikia.window'], function (throbber, track, nirvana, window) {
	'use strict';

	var d = window.document;

	$(d.getElementById('wkCatExh')).on('click', 'a', function(event){
		track.event('category', track.IMAGE_LINK, {
			label: 'exhibition',
			href: this.href
		}, event);
	});

	$(d.getElementsByClassName('alphaSec'))
		.on('click', 'a.cld', function(event){
			track.event('category', track.TEXT_LINK, {
				label: 'category',
				href: this.href
			}, event);
		}).on('click', 'a[data-batch]', function(event){
			onClick($(this), event);
		});

	/**
	 * @param MouseEvent event
	 */
	function onClick(element, event) {
		var forward = element.addClass('active').hasClass('pagMore'),
			add = (forward ? 1 : -1),
			parent = element.parent(),
			prev = (forward ? parent.find('.pagLess') : element),
			prevBatch = parseInt(prev.attr('data-batch'), 10),
			next = (forward ? element : parent.find('.pagMore')),
			nextBatch = prevBatch + 2,
			batch = (forward ? nextBatch : prevBatch),
			id = parent[0].id,
			container = parent.find('ul');

		event.preventDefault();

		prev.attr('data-batch', prevBatch + add);
		next.attr('data-batch', nextBatch + add);

		throbber.show(element[0], {size: '40px'});

		nirvana.sendRequest({
			controller: 'WikiaMobile',
			method: 'getCategoryBatch',
			format: 'html',
			type: 'GET',
			data: {
				category: wgTitle,
				batch: batch,
				//this is already encoded and $.ajax encode all data
				index: decodeURIComponent(id)
			}
		}).done(
			function (result) {
				container.remove();
				prev.removeClass('active').toggleClass('visible', batch > 1);
				next.before(result).removeClass('active').toggleClass('visible', batch < parseInt(parent.attr('data-batches'), 10));

				if (forward) {
					parent.prev()[0].scrollIntoView();
					track.event('category', track.PAGINATE, {label: 'next'});
				} else {
					track.event('category', track.PAGINATE, {label: 'previous'});
				}

				throbber.hide(element[0]);
			}
		);
	}
});
