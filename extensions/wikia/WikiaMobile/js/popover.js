/**
 *
 * POPOVER
 * create or/and open callback has to be provided to create pop over
 *
 * options.on - (required) element that opens popover - throws an exception if not provided
 * options.style - allows you to pass cssText for a content wrapper
 * options.create - content of popover, either string or function that gets content wrapper as an attribute
 * options.open - callback on open
 * options.close - callback on close
 *
 * @author Jakub "Student" Olek
 */
define('popover', ['throbber'], function popover(throbber){
	return function(options){
		options = options || {};

		var elm = options.on,
			initialized = false,
			isOpen = false,
			cnt;

		if(elm){
			elm.addEventListener('click', function(event){
				if(this.className.indexOf('on') > -1){
					close(event);
				}else{
					if(!initialized){
						var position = options.position || 'bottom',
							horizontal = (position == 'bottom' || position == 'top'),
							offset = (horizontal)?this.offsetHeight:this.offsetWidth,
							onCreate = options.create,
							style = options.style || '';

						this.insertAdjacentHTML('afterbegin', '<div class=ppOvr></div>');
						cnt = this.getElementsByClassName('ppOvr')[0];

						if(typeof onCreate == 'function'){
							changeContent(onCreate);
						}else if(typeof onCreate == 'string'){
							cnt.insertAdjacentHTML('afterbegin', onCreate);
						}else if(!open){
							throw 'No content or on open callback provided';
						}

						this.className += ' ' + position;
						var pos = horizontal ? (position == 'top' ? 'bottom' : 'top') : (position == 'left' ? 'right' : 'left');
						cnt.style[pos] = (offset + 13) + 'px';

						cnt.style.cssText += style;

						initialized = true;
					}

					open(event);
				}
			}, true);
		}else{
			throw 'Non existing element';
		}

		function changeContent(onCreate){
			cnt.innerHTML = '';
			throbber.show(cnt, {center: true, size: '20px'});
			onCreate(cnt);
		}

		function close(ev){
			if(isOpen){
				elm.className = elm.className.replace(" on", "");
				if(typeof options.close == 'function') {
					options.close(ev, elm);
				}
				isOpen = false;
			}
		}

		function open(ev){
			if(!isOpen){
				elm.className += " on";
				if(typeof options.open == 'function') {
					options.open(ev, elm);
				}
				isOpen = true;
			}
		}

		return {
			changeContent: changeContent,
			close: close,
			open: open
		};
	};
});
