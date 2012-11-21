/*global define, WikiaMobile */
/**
 * Full screen modal in Wikia Mobile
 *
 * @author Jakub "Student" Olek
 */

define('modal', ['loader', 'events', require.optional('ads')], function modal(loader, events, ads){
	var d = document,
		w = window,
		html = d.documentElement,
		opened,
		created,
		toolbar,
		content,
		caption,
		wrapper,
		closeButton,
		topBar,
		position,
		onClose,
		stopHiding,
		positionfixed = Features.positionfixed,
		scrollable;

	/* private */
	function setup(){
		wrapper = d.getElementById('wkMdlWrp');
		content = d.getElementById('wkMdlCnt');
		topBar = d.getElementById('wkMdlTB');
		toolbar = d.getElementById('wkMdlTlBar');
		caption = d.getElementById('wkMdlFtr');
		closeButton = d.getElementById('wkMdlClo');

		created = true;
	}

	function onContentClick(){
		if(!stopHiding){
			if(wrapper.className.indexOf('hdn') > -1){
				showUI();
			}else{
				hideUI();
			}
		}
	}

	function onCloseClick(ev){
		ev.stopPropagation();
		ev.preventDefault();
		close();
		w.history.back();
	}

	function onHashChange(ev){
		if(isOpen() && w.location.hash === ''){
			ev.preventDefault();
			close();
		}
	}

	function onOrientationChange(ev){
		wrapper.style.minHeight = ev.height + 'px';
		!w.pageYOffset && w.scrollTo(0, 0);
	}

	function hideUI(){
		if(wrapper.className.indexOf('hdn') == -1){
			wrapper.className += ' hdn';
		}
	}

	function showUI(){
		wrapper.className = wrapper.className.replace(' hdn', '');
	}

	function fixTopBar(){
		topBar.style.top = w.pageYOffset + 'px';
	}

	/* public */
	function open(options){
		options = options || {};

		!created && setup();

		var con = options.content,
			tool = options.toolbar,
			cap = options.caption,
			classes = options.classes || '';

		if(!opened){
			position = w.scrollY;

			var ev = w.event,
				ht = ~~(ev && ev.y - (screen.height / 2)) || 0,
				wd = ~~(ev && ev.x - (screen.width / 2)) || 0;

			wrapper.className = '';
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
			w.location.hash = "Modal";

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

		stopHiding = options.stopHiding;
		scrollable = options.scrollable;
		onClose = options.onClose;

		//move topbar along with scroll manually for browsers with no support for position fixed
		scrollable && !positionfixed && w.addEventListener('scroll', fixTopBar);

		loader.show(content, {center: true});

		if(con){
			if(typeof con == 'object'){
				Wikia.getMultiTypePackage(con);
			}else if(typeof con == 'string'){
				setContent(con);
			}
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

				ads && ads.fix();
			},10);

			opened = false;
		}
	}

	function isOpen(){
		return opened;
	}

	function setContent(con){
		loader.remove(content);
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
		isOpen: isOpen,
		getWrapper: function(){
			return wrapper;
		},
		hideUI: hideUI,
		showUI: showUI,
		setStopHiding: function(val){
			stopHiding = (val) ? true : false;
		},
		addClass: function(classes){
			if(classes && wrapper.className.indexOf(classes) == -1){
				wrapper.className += ' ' + classes;
			}
		},
		removeClass: function(classes){
			classes && (wrapper.className = wrapper.className.replace(' ' + classes,''));
		}
	}
});