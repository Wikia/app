/**
 * Full screen modal in Wikia Mobile
 *
 * @author Jakub "Student" Olek
 */

(function(){
	if(define){
		//AMD
		define('modal', modal);//late binding
	}else{
		window.Modal = modal();//late binding
	}

	function modal(){
		var opened = false, created = false,
			toolbar, content, caption, wrapper,
			loader, topBar,
			page, pageLength,
			position,
			clickEvent,
			track, onClose,
			stopHiding;

		/* private */
		function setup(){
			loader = WikiaMobile.loader;
			track = WikiaMobile.track;
			clickEvent = WikiaMobile.getClickEvent();
			wrapper = document.getElementById('wkMdlWrp');
			content = document.getElementById('wkMdlCnt');
			topBar = document.getElementById('wkMdlTB');
			toolbar = document.getElementById('wkMdlTlBar');
			caption = document.getElementById('wkMdlFtr');
			page = document.querySelectorAll('#wkAdPlc, #wkTopNav, #wkPage, #wkFtr');
			pageLength = page.length;

			//TODO: create better resolution 'finder'
			var deviceWidth = ($.os.ios) ? 268 : 300,
				deviceHeight = ($.os.ios) ? 416 : 513;

			//close modal on back button
			document.getElementById('wkMdlClo').addEventListener(clickEvent, function(){
				if(window.location.hash == '#Modal'){
					window.history.back();
				}
				close();
			});

			content.addEventListener(clickEvent, function(){
				if(!stopHiding){
					var par = this.parentElement,
						className = par.className;

					if(className.indexOf('hdn') > -1){
						par.className = className.replace(' hdn', '');
					}else{
						par.className += ' hdn';
					}
				}
			});

			//hide adress bar on orientation change
			window.addEventListener('orientationchange', function() {
				if(window.pageYOffset == 0) setTimeout(function() {window.scrollTo( 0, 1 )},1);
			});

			window.addEventListener('hashchange', function() {
				if(window.location.hash == '' && isOpen()){
					close();
				}
			});

			document.head.insertAdjacentHTML('beforeend', '<style>#wkMdlWrp{min-height: ' + deviceHeight + '}@media only screen and (orientation:landscape) and (min-width: 321px){#wkMdlWrp{min-height:' + deviceWidth + 'px;}}</style>');
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

				wrapper.className = 'open';

				for(var i = 0; i < pageLength; i++){
					page[i].style.display = 'none';
				}

				//needed for closing modal on back button
				window.location.hash = "Modal";
			}

			loader.show(content, {center: true});

			if(con){
				if(typeof con == 'object'){
					Wikia.getMultiTypePackage(con);
				}else if(typeof con == 'string'){
					setContent(con);
				}
			}

			wrapper.className += ' ' + classes;

			setToolbar(tool);
			setCaption(cap);

			track('modal/open');
			opened = true;
		}

		function close(){
			if(opened){
				for(var i = 0; i < pageLength; i++){
					page[i].style.display = 'block';
				}

				content.innerHTML = '';
				caption.innerHTML = '';
				wrapper.className = caption.className = topBar.className = '';
				if(!Modernizr.positionfixed) WikiaMobile.moveSlot();

				if(typeof onClose === 'function'){
					onClose();
				}

				window.scrollTo(0, position);
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
			isOpen: isOpen
		}
	}
})();