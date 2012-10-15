/**
 * Handling of interactive swipeing of gallery/image modals
 *
 * @author Jakub "Student" Olek
 */
define('pager', function () {
	var tr = ('ontransitionend' in window) ? 'transitionEnd' : ('onwebkittransitionend' in window) ?  'webkitTransitionEnd' : false,
		addTransitionEnd = (function(){
			return (tr) ?
				function(elm, c){
					elm.addEventListener(tr, c, true);
				} :
				function(elm, c, t){
					setTimeout(c, t);
				};
		})(),
		removeTransitionEnd = (function(){
			return (tr) ?
				function(elm, c){
					elm.removeEventListener(tr, c, true)
				} :
				function(){};
		})(),
		setTransform = function(prev, current, next, x){
			var translate = 'translate3d(' + x + 'px,0,0)';
			current.style.webkitTransform = translate;
			if(next) {next.style.webkitTransform = translate;}
			if(prev) {prev.style.webkitTransform = translate;}
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
			width,
			lastPage,
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
						//prev.innerHTML = ''
						if(elem = prev.previousElementSibling) container.removeChild(elem);
					}
					if(next = current.nextElementSibling){
						next.className = 'swiperPage next';
						//next.innerHTML = '';
						if(elem = next.nextElementSibling) container.removeChild(elem);
					}
				}

				onEnd && onEnd(currentPageNum);
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
			},
			goTo = function(delta){
				toX = (delta < -100 && next) ? -width :
					(delta > 100 && prev) ? width :
					0;

				current.style.webkitTransition = '-webkit-transform .3s';
				if(prev) prev.style.webkitTransition = '-webkit-transform .3s';
				if(next) next.style.webkitTransition = '-webkit-transform .3s';

				addTransitionEnd(current, end, 300);

				setTransform(prev, current, next, toX);
			},
			onTouchStart = function(ev){
				if(isFunction ? !checkCancel() : true)
					pos = ev.touches[0].pageX;
			},
			onTouchMove = function(ev){
				ev.preventDefault();
				if(isFunction ? !checkCancel() : true)
					setTransform(prev, current, next, ev.touches[0].pageX - pos);
			},
			onTouchEnd = function(ev){
				var delta = ev.changedTouches[0].pageX - pos;
				if((isFunction ? !checkCancel() : true) && delta !== 0)
					goTo(delta);
			},
			cleanup = function(onePage){
				eventsNotAdded = true;
				!onePage && window.removeEventListener('viewportsize', onResize);
				wrapper.removeEventListener('touchstart', onTouchStart, true);
				wrapper.removeEventListener('touchmove', onTouchMove, true);
				wrapper.removeEventListener('touchend', onTouchEnd, true);
				wrapper.removeEventListener('touchcancel', onTouchEnd, true);
			},
			events = function(){
				if(eventsNotAdded){
					eventsNotAdded = false;
					wrapper.addEventListener('touchstart', onTouchStart, true);
					wrapper.addEventListener('touchmove', onTouchMove, true);
					wrapper.addEventListener('touchend', onTouchEnd, true);
					wrapper.addEventListener('touchcancel', onTouchEnd, true);
				}
			},
			onResize = function(){
				width = wrapper.offsetWidth;
				onOrientCallback && onOrientCallback();
			};

		//get options
		container = options.container;
		wrapper = options.wrapper || container;
		currentPageNum = options.pageNumber || 0;
		onEnd = (typeof options.onEnd === 'function') ? options.onEnd : false;
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