/*global define, WikiaMobile */
/**
 * Full screen modal in Wikia Mobile
 *
 * @author Jakub "Student" Olek
 */

define('modal', ['loader', 'events', 'ads'], function modal(loader, events, ads){
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
		positionfixed = Features.positionfixed;

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
		!w.pageYOffset && w.scrollTo(0, 1);
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

		stopHiding = options.stopHiding || false;

		onClose = options.onClose;

		if(!opened){
			position = w.scrollY;

			var ev = w.event,
				ht = ~~(ev && ev.screenY - (window.innerHeight / 2)) || 0,
				wd = ~~(ev && ev.screenX - (window.innerWidth / 2)) || 0;

			wrapper.className = '';
			wrapper.style.webkitTransform = 'translate(' + wd + 'px,' + ht + 'px) scale(.3)';

			//browser needs time to move whole modal around
			setTimeout(function(){
				wrapper.style.top = position + 'px';
				wrapper.className += ' zoomer open';

				setTimeout(function(){
					html.className += ' noPage';
					wrapper.style.top = 0;
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
		}

		//move topbar along with scroll manually for browsers with no support for position fixed
		!positionfixed && w.addEventListener('scroll', fixTopBar);

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
			w.removeEventListener('viewportsize', onOrientationChange);
			w.removeEventListener('hashchange', onHashChange);
			closeButton.removeEventListener('click', onCloseClick);
			content.removeEventListener('click', onContentClick);

			html.className = html.className.replace(' noPage','');

			content.innerHTML = '';
			caption.innerHTML = '';
			caption.className = '';
			topBar.className = '';

			if(typeof onClose === 'function'){
				onClose();
			}

			//remove event listners since they are not needed outside modal
			if(!positionfixed){
				w.removeEventListener('scroll', fixTopBar);
				topBar.style.top = '';
			}

			//scroll to where user was before
			//in setTimout because ios4.x has to do this after everything has to do now
			//otherwise it forgets to scroll...
			setTimeout(function(){
				if(!stopScrolling){
					w.scrollTo(0, position);
					wrapper.style.top = position + 'px';
				}

				wrapper.className = 'zoomer';

				setTimeout(function(){
					wrapper.style.top = 0;
				},310);

				ads && ads.fix();
			},50);

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