require(['events', 'loader', 'track'], function(events, loader, track){
	var clickEvent = events.click;

	$('.pagMore, .pagLess').bind(clickEvent, function(event) {
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

		$.nirvana.sendRequest({
			controller: 'WikiaMobileController',
			method: 'getCategoryBatch',
			format: 'html',
			data:{
				category: wgTitle,
				batch: batch,
				index: encodeURIComponent(id.substr(-1, 1))
			},
			callback: function(result){
				container.parentElement.removeChild(container);
				next.insertAdjacentHTML('beforebegin', result);

				if(forward) {
					parent.previousElementSibling.scrollIntoView();
					track('category/next');
				}else{
					track('category/prev');
				}

				loader.hide(self);

				prev.className = 'pagLess' + (batch > 1 ? ' visible' : '');
				next.className = 'pagMore' + (batch < ~~(parent.getAttribute('data-batches')) ? ' visible' : '');
			}
		});
	});

	var expAll = document.getElementById('expAll'),
		wkCatExh = document.getElementById('wkCatExh');

	if(expAll){
		var elements = $('.alphaSec .artSec, .alphaSec .collSec');
		expAll.addEventListener(clickEvent, function() {
			if($(this).toggleClass('exp').hasClass('exp')){
				elements.addClass('open');
				track('category/expandAll');
			}else{
				elements.removeClass('open');
				track('category/collapseAll');
			}
		});
	}

	if(wkCatExh){
		wkCatExh.addEventListener(clickEvent, function() {
			track('category/exhibition/click');
		});
	}
});