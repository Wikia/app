/**
 * Handling of interactive swipeing of gallery/image modals
 *
 * @author Jakub "Student" Olek
 */
define('pager', ['wikia.window'], function (window) {
	var tr = ('ontransitionend' in window) ? 'transitionend' : ('onwebkittransitionend' in window) ?  'webkitTransitionEnd' : false,
		addTransitionEnd = (function(){
			return (tr) ?
				function(elm, c){
					elm.addEventListener(tr, c, true);
				} :
				function(elm, c, t){
					window.setTimeout(c, t);
				};
		})(),
		removeTransitionEnd = (function(){
			return (tr) ?
				function(elm, c){
					elm.removeEventListener(tr, c, true)
				} :
				function(){};
		})(),
		setTransform = function(prev, current, next, x, padding){
			x = ~~(x * 1.2);
			var	translate = 'translate3d(' + x + 'px,0,0)',
				style;

			current.style.webkitTransform = translate;

			if (prev) {
				style = prev.style;

				if(x > padding) {
					style.webkitTransform = translate;
				}else if(style.webkitTransform != '') {
					style.webkitTransform = '';
				}
			}

			if (next) {
				style = next.style;

				if(x < -padding) {
					style.webkitTransform = translate;
				}else if(style.webkitTransform != '') {
					style.webkitTransform = '';
				}
			}
		},
		wrap = function(pages){
			var i = pages.length-1;

			while(i >= 0){
				pages[i] = '<section>' + pages[i--] + '</section>';
			}

			return pages;
		};

	return function(options){
		var pos,
			isFunction,
			container,
			wrapper,
			onStart,
			onStartFired = false,
			animating = false,
			onEnd,
			onOrientCallback,
			checkCancel,
			pages,
			center,
			circle,
			currentPageNum,
			current,
			prev,
			next,
			toX,
			lastPage,
			width,
			padding,
			eventsNotAdded = true,
			end = function(){
				var insertPage,
					changePage = (toX !== 0),
					elem,
					where;

				removeTransitionEnd(current, end);

				current.style.webkitTransform = '';
				if(next) next.style.webkitTransform = '';
				if(prev) prev.style.webkitTransform = '';

				current.style.webkitTransition = '';
				if(next) next.style.webkitTransition = '';
				if(prev) prev.style.webkitTransition = '';

				if(changePage) {
					if(toX > 0){
						current = current.previousElementSibling;
						currentPageNum--;

						if(currentPageNum > 0){
							insertPage = currentPageNum-1;
						}else if(circle){
							if(currentPageNum === 0){
								insertPage = lastPage;
							}else if(currentPageNum === -1){
								currentPageNum = lastPage;
								insertPage = currentPageNum-1;
							}
						}

						where = 'afterbegin';
					}else{
						current = current.nextElementSibling;
						currentPageNum++;

						if(currentPageNum < lastPage){
							insertPage = currentPageNum+1;
						}else if(circle){
							if(currentPageNum == lastPage){
								insertPage = 0;
							}else if(currentPageNum == lastPage+1){
								currentPageNum = 0;
								insertPage = 1;
							}
						}

						where = 'beforeend';
					}

					if(insertPage >= 0 && where) container.insertAdjacentHTML(where, pages[insertPage]);

					current.className = 'swiperPage current';

					if(prev = current.previousElementSibling) {
						prev.className = 'swiperPage prev';
						if(elem = prev.previousElementSibling) container.removeChild(elem);
					}
					if(next = current.nextElementSibling){
						next.className = 'swiperPage next';
						if(elem = next.nextElementSibling) container.removeChild(elem);
					}
				}

				onStartFired = animating = false;
				onEnd && onEnd(pages[currentPageNum], current, currentPageNum);
			},
			loadCurrentPage = function(){
				container.innerHTML = ((currentPageNum > 0) ? pages[currentPageNum-1] :
					(circle && currentPageNum === 0) ? pages[lastPage] : '') +
					pages[currentPageNum] +
					((lastPage > 0 && currentPageNum < lastPage) ? pages[currentPageNum+1] :
						(circle && currentPageNum === lastPage) ? pages[0] : '');

				var elems = container.childNodes;

				if(elems.length <= 2){
					if(currentPageNum !== 0) {
						prev = elems[0];
						current = elems[1];
						next = false;
					}else{
						prev = false;
						current = elems[0];
						next = elems[1];
					}

				}else{
					prev = elems[0];
					current = elems[1];
					next = elems[2];
				}

				current.className = 'swiperPage current';
				if(prev) prev.className = 'swiperPage prev';
				if(next) next.className = 'swiperPage next';

				width = container.offsetWidth;
				padding = width * 0.2;
			},
			goTo = function(delta){
				toX = (delta < -100 && next) ? -width :
					(delta > 100 && prev) ? width :
					0;

				current.style.webkitTransition = '-webkit-transform .3s';
				if(prev) prev.style.webkitTransition = '-webkit-transform .3s';
				if(next) next.style.webkitTransition = '-webkit-transform .3s';

				animating = true;

				addTransitionEnd(current, end, 300);

				setTransform(prev, current, next, toX, padding);
			},
			onTouchStart = function(ev){
				if (ev.touches.length == 1) {

					//since this is internal tool for now
					//and is used only in modal
					//we can assume that this should always be at the top
					//if need arises better place for this probably is onStart
					//so fix it with this line in case:
					window.scrollTo(0,1);

					if ( isFunction ? !checkCancel() : true ) {
						pos = ev.touches[0].pageX;

						wrapper.removeEventListener('touchstart', onTouchStart);
						wrapper.addEventListener('touchmove', onTouchMove);
						wrapper.addEventListener('touchend', onTouchEnd);
						wrapper.addEventListener('touchcancel', onTouchEnd);
					}
				}

			},
			onTouchMove = function(ev){
				if ( ev.touches.length === 1 ) {
					if( isFunction ? !checkCancel() : true ) {
						ev.preventDefault();

						var delta = ev.touches[0].pageX - pos;

						onStart && !onStartFired && onStart();

						onStartFired = true;

						!animating && setTransform(prev, current, next, delta, padding);
					}
				}
			},
			onTouchEnd = function(ev){
				if(ev.touches.length === 0) {

					if ( isFunction ? !checkCancel() : true ) {
						onStartFired && goTo(ev.changedTouches[0].pageX - pos);
					}

					wrapper.addEventListener('touchstart', onTouchStart);
					wrapper.removeEventListener('touchmove', onTouchMove);
					wrapper.removeEventListener('touchend', onTouchEnd);
					wrapper.removeEventListener('touchcancel', onTouchEnd);
				}
			},
			cleanup = function(onePage){
				eventsNotAdded = true;
				!onePage && window.removeEventListener('viewportsize', onResize);
				wrapper.removeEventListener('touchstart', onTouchStart);
			},
			events = function(){
				if(eventsNotAdded){
					eventsNotAdded = false;
					wrapper.addEventListener('touchstart', onTouchStart);
				}
			},
			onResize = function(){
				width = wrapper.offsetWidth;
				padding = width * 0.2;
				onOrientCallback && onOrientCallback();
			};

		//get options
		container = options.container;
		wrapper = options.wrapper || container;
		currentPageNum = options.pageNumber || 0;
		onEnd = (typeof options.onEnd === 'function') ? options.onEnd : false;
		onStart = (typeof options.onStart === 'function') ? options.onStart : false;
		onOrientCallback = (typeof options.onResize === 'function') ? options.onResize : false;
		checkCancel = options.setCancel;
		isFunction = (typeof checkCancel === 'function');
		pages = options.pages;
		circle = options.circle || false;
		center = options.center || false;

		//true init
		if(container && pages){
			lastPage = pages.length-1;
			circle = (circle && lastPage);
			pages = (center) ? wrap(pages) : pages;
			loadCurrentPage();

			window.addEventListener('viewportsize', onResize);
			(lastPage || circle) && events();

			return {
				prev: function(){
					goTo(101);
				},
				next: function(){
					goTo(-101);
				},
				reset: function(options){
					if(options.pages){
						pages = center ? wrap(options.pages) : options.pages;
					}
					lastPage = pages.length-1;
					circle = (circle && lastPage);
					currentPageNum = (typeof options.pageNumber === 'number') ? options.pageNumber : currentPageNum;

					loadCurrentPage();
					//add/remove events when necessary
					(lastPage || circle) ? events() : cleanup(true);
				},
				cleanup: cleanup,
				getCurrent: function () {
					return current;
				}
			};
		}else {
			throw 'no container or pages specified';
		}
	};
});