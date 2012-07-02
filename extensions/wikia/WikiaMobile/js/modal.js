/*global define, WikiaMobile */
/**
 * Full screen modal in Wikia Mobile
 *
 * @author Jakub "Student" Olek
 */

define('modal', ['loader', 'track', 'events', 'ads'], function modal(loader, track, events, ads){
	var d = document,
		w = window,
		opened, created,
		toolbar, content, caption, wrapper,
		topBar,
		position,
		clickEvent = events.click,
		onClose,
		stopHiding;

	/* private */
	function setup(){
		wrapper = d.getElementById('wkMdlWrp');
		content = d.getElementById('wkMdlCnt');
		topBar = d.getElementById('wkMdlTB');
		toolbar = d.getElementById('wkMdlTlBar');
		caption = d.getElementById('wkMdlFtr');

		//TODO: create better resolution 'finder'
		var deviceWidth = ($.os.ios) ? 268 : 320,
			deviceHeight = ($.os.ios) ? 416 : 523;

		//close modal on back button
		d.getElementById('wkMdlClo').addEventListener('click', function(){
			if(w.location.hash == '#Modal'){
				w.history.back();
			}
			close();
		});

		content.addEventListener('tap', function(){
			if(!stopHiding){
				if(wrapper.className.indexOf('hdn') > -1){
					showUI();
				}else{
					hideUI();
				}
			}
		});

		//hide adress bar on orientation change
		w.addEventListener('orientationchange', function() {
			if(w.pageYOffset == 0) setTimeout(function() {w.scrollTo( 0, 1 );},10);
		});

		w.addEventListener('hashchange', function() {
			if(w.location.hash == '' && isOpen()){
				close();
			}
		});

		d.head.insertAdjacentHTML('beforeend', '<style>#wkMdlWrp{min-height: ' + deviceHeight + 'px}@media only screen and (orientation:landscape) and (min-width: 321px){#wkMdlWrp{min-height:' + deviceWidth + 'px;}}</style>');
		created = true;
	}

	function hideUI(){
		if(wrapper.className.indexOf('hdn') == -1){
			wrapper.className += ' hdn';
		}
	}

	function showUI(){
		wrapper.className = wrapper.className.replace(' hdn', '');
	}

	/* public */
	function open(options){
		options = options || {};

		if(!created) setup();

		var con = options.content,
			tool = options.toolbar,
			cap = options.caption,
			classes = options.classes || '';

		stopHiding = options.stopHiding || false;

		onClose = options.onClose;

		if(!opened){
			position = window.pageYOffset;
			d.documentElement.className += ' modal';
			wrapper.className = 'open';

			//needed for closing modal on back button
			w.location.hash = "Modal";
		}

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

		track('modal/open');
		opened = true;
	}

	function close(){
		if(opened){
			d.documentElement.className = d.documentElement.className.replace(' modal','');

			content.innerHTML = '';
			caption.innerHTML = '';
			wrapper.className = caption.className = topBar.className = '';
			if(!Modernizr.positionfixed) ads.moveSlot();

			if(typeof onClose === 'function'){
				onClose();
			}

			w.scrollTo(0, position);
			track('modal/close');
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
		if(typeof cap == 'string' && cap != ''){
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