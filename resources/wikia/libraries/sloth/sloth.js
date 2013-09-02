/**
 * Library to lazy initialize components of a web page
 *
 * @author Hakubo bukaj.kelo<@gmail.com>
 * @see https://github.com/hakubo/Sloth
 */
define('sloth', function(){
	//some private vars
	var slice = Array.prototype.slice,
		win = window,
		wTop,
		wBottom,
		undef,
		debounce,
		delegate = win.setTimeout,
		branches = [],
		Branch = function(element, threshold, callback){
			this.element = element;
			this.threshold = threshold;
			this.callback = function(){
				callback(element);
			};
		},
		addEvent = function(){
			win.addEventListener('scroll', execute);
		},
		removeEvent = function(){
			win.removeEventListener('scroll', execute);
		},
		lock = 0,
		execute = function(){
			var i = branches.length,
				branch;

			removeEvent();

			if(i && !lock) {
				lock = delegate(function(){
					lock = 0;
					addEvent();
				}, debounce);

				wTop = win.scrollY;
				wBottom = wTop + win.innerHeight;

				while(i--){
					branch = branches[i];

					if (branch.isVisible()) {
						delegate( branch.callback, 0 );
						branches.splice(i, 1);
					}
				}
			}
		};

	Branch.prototype.isVisible = function(){
		var elem =  this.element,
			threshold = this.threshold,
			top = elem.y - threshold,
			height = elem.offsetHeight,
			bottom = top + height + threshold;

		return (height && wBottom >= top && wTop <= bottom);
	};

	//return Sloth function
	return function(params){
		if(params) {
			var elements = params.on,
				threshold = params.threshold !== undef ? params.threshold : 100,
				callback = params.callback,
				i;

			debounce = params.debounce !== undef ? params.debounce : 500;

			if(!elements) throw 'No elements passed';
			if(!callback) throw 'No callback passed';

			if(elements.length !== undef){
				elements = slice.call(elements);
				i = elements.length;

				while(i--) branches.push(new Branch(elements[i], threshold, callback));
			}else {
				branches.push(new Branch(elements, threshold, callback))
			}
		}

		execute();
	}
});