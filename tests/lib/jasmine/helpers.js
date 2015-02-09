function getBody( html ){
	var rand = (Math.random() * Math.random() + '').slice(2),
		element = document.createElement('div');

	element.style.width = '1024px';
	element.style.height = '800px';

	if(getBody.id) document.body.removeChild(document.getElementById(getBody.id));

	element.id = rand;
	getBody.id = rand;

	if ( html ) {
		element.innerHTML = html;
	}

	document.body.appendChild(element);

	return document.getElementById(rand);
}

function fireEvent(event, element){
	var evt = document.createEvent("HTMLEvents");
	evt.initEvent(event, true, true); // event type,bubbling,cancelable
	return !element.dispatchEvent(evt);
}

/**
 * Polyfill for `Function.prototype.bind` because PhantomJS 1.9.8 doens't support it
 * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/bind#Polyfill
 */
if (!Function.prototype.bind) {
	Function.prototype.bind = function(oThis) {
		if (typeof this !== 'function') {
			// closest thing possible to the ECMAScript 5
			// internal IsCallable function
			throw new TypeError('Function.prototype.bind - what is trying to be bound is not callable');
		}

		var aArgs   = Array.prototype.slice.call(arguments, 1),
			fToBind = this,
			fNOP    = function() {},
			fBound  = function() {
				return fToBind.apply(this instanceof fNOP && oThis
						? this
						: oThis,
					aArgs.concat(Array.prototype.slice.call(arguments)));
			};

		fNOP.prototype = this.prototype;
		fBound.prototype = new fNOP();

		return fBound;
	};
}