/*global getComputedStyle, WebKitCSSMatrix */

/* !
 * iScroll Lite base on iScroll v4.1.6 ~ Copyright (c) 2011 Matteo Spinelli, http://cubiq.org
 * Released under MIT license, http://cubiq.org/license
 *
 * made even lighter by Jakub 'Student' Olek
 *
 */

(function(w){
	var m = Math,
		vendor = (/webkit/i).test(navigator.appVersion) ? 'webkit' :
			(/firefox/i).test(navigator.userAgent) ? 'Moz' :
				'opera' in w ? 'O' : '',

		// Browser capabilities
		has3d = 'WebKitCSSMatrix' in w && 'm11' in new WebKitCSSMatrix(),
		hasTransform = vendor + 'Transform' in document.documentElement.style,
		hasTransitionEnd = (/iphone|ipad/gi).test(navigator.appVersion) || (/playbook/gi).test(navigator.appVersion),

		// Events
		RESIZE_EV = 'viewportsize',
		START_EV = 'touchstart',
		MOVE_EV = 'touchmove',
		END_EV = 'touchend',
		CANCEL_EV = 'touchcancel',

		// Helpers
		trnOpen = 'translate' + (has3d ? '3d(' : '('),
		trnClose = has3d ? ',0)' : ')',

		// Constructor
		iScroll = function (el, onstop) {
			this.wrapper = el;

			var scroll = el.children[0];

			this.scroller = scroll;

			this.onstop = onstop;

			// Set starting position
			this.x = 0;

			// Set some default styles
			scroll.style[vendor + 'TransitionProperty'] = hasTransform ? '-' + vendor.toLowerCase() + '-transform' : 'left';
			scroll.style[vendor + 'TransitionDuration'] = '0';
			scroll.style[vendor + 'TransformOrigin'] = '0 0';
			if (hasTransitionEnd) {scroll.style[vendor + 'TransitionTimingFunction'] = 'cubic-bezier(0.33,0.66,0.66,1)';}

			if (hasTransform) {scroll.style[vendor + 'Transform'] = trnOpen + '0,0' + trnClose;}
			else {scroll.style.cssText += ';position:absolute;left:0;';}

			this.scrollerW = this.scroller.offsetWidth;
			this.refresh();

			w.addEventListener(RESIZE_EV, this);
			scroll.addEventListener(START_EV, this);
			scroll.addEventListener(MOVE_EV, this);
			scroll.addEventListener(END_EV, this);
			scroll.addEventListener(CANCEL_EV, this);
		};

	// Prototype
	iScroll.prototype = {
		x: 0,
		steps: [],

		handleEvent: function (e) {
			var that = this,
				point,
				x;
			switch(e.type) {
			case START_EV:
				point = e.touches[0];

				if (hasTransitionEnd) {this._transitionTime(0);}

				this.moved = false;
				this.animating = false;
				this.distX = 0;

				if(hasTransform) {
					// Very lame general purpose alternative to CSSMatrix
					x = ~~getComputedStyle(this.scroller, null)[vendor + 'Transform'].replace(/[^0-9\-.,]/g, '').split(',')[4];
				} else {
					x = ~~getComputedStyle(this.scroller, null).left.replace(/[^0-9\-]/g, '');
				}

				if(x != this.x) {
					if (hasTransitionEnd) {
						this.scroller.removeEventListener('webkitTransitionEnd', this);
					} else {
						clearTimeout(this.aniTime);
					}
					this.steps = [];
					this._pos(x);
				}

				this.startX = this.x;
				this.pointX = point.pageX;

				this.startTime = e.timeStamp || Date.now();
				break;
			case MOVE_EV:
					point = e.touches[0];
					var deltaX = point.pageX - that.pointX,
						newX = that.x + deltaX,
						timestamp = e.timeStamp || Date.now();

					that.pointX = point.pageX;

					// Slow down if outside of the boundaries
					if (newX > 0 || newX < that.maxScrollX) {
						newX = that.x + (deltaX / 2);
					}

					that.distX += deltaX;

					if (m.abs(that.distX) > 15) {
						e.preventDefault();
					}

					that.moved = true;
					that._pos(newX);

					if (timestamp - that.startTime > 300) {
						that.startTime = timestamp;
						that.startX = that.x;
					}
					break;
			case END_EV:
			case CANCEL_EV:
				if (e.touches.length != 0) return;

				var momentumX = {},
					duration = (e.timeStamp || Date.now()) - that.startTime,
					newPosX = that.x;

				if (!that.moved) {
					that._resetPos(200);
					return;
				}

				if (duration < 300) {
					momentumX = newPosX ? that._momentum(newPosX - that.startX, duration) : { dist:0, time:0 };

					newPosX = newPosX + momentumX.dist;

					if ((that.x > 0 && newPosX > 0) || (that.x < that.maxScrollX && newPosX < that.maxScrollX)) {momentumX = { dist:0, time:0 };}
				}

				if (momentumX.dist) {
					that.scrollTo((newPosX >> 0), m.max(momentumX.time, 10));
					return;
				}

				that._resetPos(200);
				break;
			case RESIZE_EV: this.refresh(); break;
			case 'webkitTransitionEnd':
				if (e.target != this.scroller) return;

				this.scroller.removeEventListener('webkitTransitionEnd', this);

				this._startAni();
				break;
			}
		},

		_pos: function (x) {
			if (hasTransform) {
				this.scroller.style[vendor + 'Transform'] = trnOpen + x + 'px,0' + trnClose;
			} else {
				this.scroller.style.left = (x >> 0) + 'px';
			}

			this.x = x;
		},

		_resetPos: function (time) {
			var	x = this.x,
				max = this.maxScrollX,
				resetX = x >= 0 ? 0 : x <  max ? max : x;

			if (resetX == x) {
				if(this.moved){
					if(typeof this.onstop == 'function') {this.onstop(this.wrapper, -x, -max - 10);}
					this.moved = false;
				}
				return;
			}

			this.scrollTo(resetX, time);
		},

		/**
		 *
		 * Utilities
		 *
		 */
		_startAni: function () {
			var that = this,
				startX = that.x,
				startTime = Date.now(),
				step, easeOut,
				animate;

			if (that.animating) return;

			if (!that.steps.length) {
				that._resetPos(400);
				return;
			}

			step = that.steps.shift();

			if (step.x == startX) {step.time = 0;}

			that.animating = true;
			that.moved = true;

			if (hasTransitionEnd) {
				that._transitionTime(step.time);
				that._pos(step.x);
				that.animating = false;
				if (step.time) {
					this.scroller.addEventListener('webkitTransitionEnd', this);
				} else {
					that._resetPos(0);
				}
				return;
			}

			animate = function() {
				var now = Date.now(),
					newX;

				if (now >= startTime + step.time) {
					that._pos(step.x);
					that.animating = false;
					that._startAni();
					return;
				}

				now = (now - startTime) / step.time - 1;
				easeOut = m.sqrt(1 - now * now);
				newX = (step.x - startX) * easeOut + startX;
				that._pos(newX);
				if (that.animating) {that.aniTime = setTimeout(animate, 17);}
			};

			animate();
		},

		_transitionTime: function (time) {
			this.scroller.style[vendor + 'TransitionDuration'] = time + 'ms';
		},

		_momentum: function (dist, time) {
			var decele = 0.0006,
				maxDistUpper = -this.x,
				maxDistLower = this.scrollerW - this.wrapperW + this.x,
				s = m.abs(dist) / time,
				newDist = (s * s) / (2 * decele),
				outsideDist = this.wrapperW / (6 / (newDist / s * decele)),
				maxDist = newDist;

			// Proportinally reduce speed if we are outside of the boundaries
			if (dist > 0 && newDist > maxDistUpper) {
				maxDist = maxDistUpper + outsideDist;
			} else if (dist < 0 && newDist > maxDistLower) {
				maxDist = maxDistLower + outsideDist;
			}

			return { dist: (maxDist * (dist < 0 ? -1 : 1)), time: (~~((s * maxDist / newDist) / decele)) };
		},

		/**
		 *
		 * Public methods
		 *
		 */
		destroy: function() {
			var scroller = this.scroller;
			scroller.style[vendor + 'Transform'] = '';

			// Remove the event listeners
			w.removeEventListener(RESIZE_EV, this);
			scroller.removeEventListener(START_EV, this);
			scroller.removeEventListener(MOVE_EV, this);
			scroller.removeEventListener(END_EV, this);
			scroller.removeEventListener(CANCEL_EV, this);
			if (hasTransitionEnd) {scroller.removeEventListener('webkitTransitionEnd', this);}
		},

		refresh: function() {
			this.wrapperW = this.wrapper.offsetWidth;
			this.maxScrollX = this.wrapperW - this.scrollerW - 10;
			this.scroller.style[vendor + 'TransitionDuration'] = '0';
			this._resetPos(200);
		},

		scrollTo: function (x, time) {
			clearTimeout(this.aniTime);
			this.moved = false;
			this.animating = false;
			this.steps = [{ x: x, time: time }];
			this._startAni();
		}
	};

	w.iScroll = iScroll;
})(window);