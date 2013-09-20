/*global Features, WikiaMobile */
/**
 * Full screen modal in Wikia Mobile
 *
 * @author Jakub "Student" Olek
 */

define('modal', ['throbber', 'jquery'], function modal(throbber, $){
	'use strict';

	var d = document,
		w = window,
		html = d.documentElement,
		opened,
		created,
		toolbar,
		content,
		caption,
		wrapper,
		$wrapper,
		closeButton,
		topBar,
		position,
		onClose,
		onResize,
		stopHiding,
		positionfixed = Features.positionfixed,
		scrollable;

	/* private */
	function setup(){
		wrapper = d.getElementById('wkMdlWrp');
		$wrapper = $(wrapper);
		content = d.getElementById('wkMdlCnt');
		topBar = d.getElementById('wkMdlTB');
		toolbar = d.getElementById('wkMdlTlBar');
		caption = d.getElementById('wkMdlFtr');
		closeButton = d.getElementById('wkMdlClo');

		created = true;
	}

	function onContentClick(){
		if(!stopHiding) $wrapper.toggleClass('hdn');
	}

	function onCloseClick(ev){
		ev.stopPropagation();
		ev.preventDefault();
		close();
		w.history.back();
	}

	function onHashChange(ev){
		if(opened && w.location.hash === ''){
			ev.preventDefault();
			close();
		}
	}

	function onOrientationChange(ev){
		//Setting minHeight is essential to hide url bar in a browser
		//in GameGuides though there is nothing to hide

		if(!Features.gameguides) {
			wrapper.style.minHeight = ev.height + 'px';
		}

		if(!w.pageYOffset) {
			w.scrollTo(0, 1);
		}

		if(typeof onResize === 'function') {
			onResize(ev);
		}
	}

	function hideUI(){
		$wrapper.addClass('hdn');
	}

	function showUI(){
		$wrapper.removeClass('hdn');
	}

	function fixTopBar(){
		topBar.style.top = w.pageYOffset + 'px';
	}

	/* public */
	function open(options){
		options = options || {};

		!created && setup();

		$.event.trigger('ads:unfix');

		var con = options.content,
			tool = options.toolbar,
			cap = options.caption,
			classes = options.classes || '';

		stopHiding = options.stopHiding;
		scrollable = options.scrollable;
		onResize = options.onResize;

		if(!opened){
			position = w.scrollY;

			var ev = w.event,
				ht = ~~(ev && ev.y - (screen.height / 2)) || 0,
				wd = ~~(ev && ev.x - (screen.width / 2)) || 0;

			wrapper.className = '';
			wrapper.style.display = 'block';
			wrapper.style.webkitTransform = 'translate(' + wd + 'px,' + ht + 'px) scale(.1)';

			//browser needs time to move whole modal around
			setTimeout(function(){
				wrapper.style.top = position + 'px';
				wrapper.className += ' zoomer open';

				setTimeout(function(){
					wrapper.style.top = 0;
					html.className += ' modal';

					if(typeof options.onOpen === 'function') {options.onOpen(content);}
				},310);

			},50);

			//needed for closing modal on back button
			w.location.hash = 'Modal';

			//hide adress bar on orientation change
			w.addEventListener('viewportsize', onOrientationChange);

			//handle close on back button
			w.addEventListener('hashchange', onHashChange);

			//close modal on back button
			closeButton.addEventListener('click', onCloseClick);

			//handle hiding ui of modal on click
			content.addEventListener('click', onContentClick);
		} else {
			//this means this is opening a modal from a modal
			//lets fire an onClose callback
			if(typeof onClose === 'function'){
				onClose();
			}
			//and on open as well if needed
			if(typeof options.onOpen === 'function') {options.onOpen(content);}
		}

		onClose = options.onClose;

		//move topbar along with scroll manually for browsers with no support for position fixed
		scrollable && !positionfixed && w.addEventListener('scroll', fixTopBar);

		throbber.show(content, {center: true});

		if(typeof con == 'string'){
			setContent(con);
		}

		if(classes && wrapper.className.indexOf(classes) == -1){
			wrapper.className += ' ' + classes;
		}

		setToolbar(tool);
		setCaption(cap);

		//track('modal/open');
		opened = true;
	}

	function close(stopScrolling){
		if(opened){
			//rest of closing will be done after all animations
			//to make to as light to a browser as I can get
			html.className = html.className.replace(' modal','');

			//scroll to where user was before
			//in setTimout because ios4.x has to do this after everything has to do now
			//otherwise it forgets to scroll...
			setTimeout(function(){
				if(!stopScrolling){
					wrapper.style.top = position + 'px';
					w.scrollTo(0, position);
				}

				wrapper.className = 'zoomer';

				setTimeout(function(){
					wrapper.style.display = 'none';
					wrapper.style.top = 0;

					content.innerHTML = '';
					caption.innerHTML = '';
					caption.className = '';
					topBar.className = '';

					w.removeEventListener('viewportsize', onOrientationChange);
					w.removeEventListener('hashchange', onHashChange);
					closeButton.removeEventListener('click', onCloseClick);
					content.removeEventListener('click', onContentClick);

					//remove event listners since they are not needed outside modal
					if(scrollable && !positionfixed){
						w.removeEventListener('scroll', fixTopBar);
						topBar.style.top = '';
					}

					if(typeof onClose === 'function'){
						onClose();
					}
				},310);

				$.event.trigger('ads:fix');
			},10);

			opened = false;
		}
	}

	function setContent(con){
		throbber.remove(content);
		if(typeof con === 'string'){
			content.innerHTML = con;
		}
	}

	function setToolbar(tool){
		if(typeof tool == 'string'){
			toolbar.innerHTML = tool;
			toolbar.style.display = 'block';
		}else{
			toolbar.style.display = 'none';
		}
	}

	function setCaption(cap){
		if(typeof cap === 'string' && cap !== ''){
			caption.innerHTML = cap;
			caption.style.display = 'block';
		}else{
			caption.style.display = 'none';
		}
	}

	return {
		setCaption: setCaption,
		setToolbar: setToolbar,
		setContent: setContent,
		open: open,
		close: close,
		isOpen: function () {
			return opened;
		},
		getWrapper: function () {
			return wrapper;
		},
		hideUI: hideUI,
		showUI: showUI,
		setStopHiding: function (val) {
			stopHiding = Boolean(val);
		},
		addClass: function (classes) {
			$wrapper.addClass(classes);
		},
		removeClass: function (classes) {
			$wrapper.removeClass(classes);
		}
	}
});