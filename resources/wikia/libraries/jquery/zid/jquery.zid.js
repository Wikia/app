/**
 * jQuery Zid v0.8
 *
 * Terms of Use - Zid
 * under the MIT (http://www.opensource.org/licenses/mit-license.php) License.
 *
 * Copyright 2013 Wikia. All rights reserved.
 * ( https://github.com/kvas-damian/zid )
 *
 */

// Debouncing function from John Hann
// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
// Copy pasted from http://paulirish.com/2009/throttled-smartresize-jquery-event-handler/

(function ($, sr) {
	'use strict';
	var debounce = function (func, threshold, execAsap) {
		var timeout;
		return function debounced() {
			var obj = this,
				args = arguments;

			function delayed() {
				if (!execAsap) {
					func.apply(obj, args);
				}
				timeout = null;
			}
			if (timeout) {
				clearTimeout(timeout);
			}
			else if (execAsap) {
				func.apply(obj, args);
			}

			timeout = setTimeout(delayed, threshold || 50);
		};
	};
	jQuery.fn[sr] = function (fn) {
		return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
	};
})(jQuery, 'smartresize');

// Zid magic

(function ($) {
	'use strict';
	var Zid = function (options, element) {
		this.element = $(element);
		this._init(options);
	};

	Zid.settings = {
		selector: '.item',
		width: 225,
		gutter: 20
	};

	Zid.prototype = {

		_init: function (options) {
			var container = this;
			this.cols = 0;
			this.box = this.element;
			this.options = $.extend(true, {}, Zid.settings, options);
			this.itemsArr = $.makeArray(this.box.find(this.options.selector));
			this.isResizing = false;
			this.minBreakPoint = 1;
			this.maxBreakPoint = 1;

			this.columns = [];

			// build columns
			this._setCols();
			// render items in columns
			this._renderItems('append', this.itemsArr);
			// add class 'zid' to container
			$(this.box).addClass('zid');
			// add smartresize
			$(window).smartresize(function () {
				container.resize();
			});
		},

		_setCols: function () {
			var i,
				div,
				clear = $('<div></div>').css({
					'clear': 'both',
					'height': '0',
					'width': '0',
					'display': 'block'
				}).attr('id', 'clear' + this.options.selector);
			// calculate columns count
			this.cols = Math.floor(this.box.width() / (this.options.width + this.options.gutter));
			// We should always render at least one column
			if (this.cols < 1) {
				this.cols = 1;
			}
			// add columns to box
			for (i = 0; i < this.cols; i++) {
				div = $('<div></div>').addClass('zidcolumn').css({
					'width': 'calc(' + (100 / this.cols) + '% - ' +
						(((this.cols - 1) * this.options.gutter) / this.cols) + 'px )',
					'paddingLeft': (i === 0) ? 0 : this.options.gutter,
					'paddingBottom': this.options.gutter,
					'float': 'left'
				});
				this.box.append(div);
				this.columns.push(div);
			}
			
			
			this.box.find($('#clear' + this.options.selector)).remove();
			// add clear float
			this.box.append(clear);
			this._setbreakPoints();
		},
		_setbreakPoints: function() {
			this.maxBreakPoint = (this.cols + 1) * (this.options.width + this.options.gutter);
			this.minBreakPoint = (this.cols <= 1) ? 1 : this.cols * (this.options.width + this.options.gutter);
		},

		_renderItems: function (method, arr) {
			// push out the items to the columns
			$.each(arr, $.proxy(
				function (index, value) {
					var item = $(value),
						col = this._getLowestColumn();
					// prepend on append to column
					if (method === 'prepend') {
						col.prepend(item);
					} else {
						col.append(item);
					}
				},
				this
			));
		},

		_getLowestColumn: function () {
			var lowest = this.columns[0],
				lowestHeight = lowest.height();

			$.each(this.columns, function (index, currentColumn) {
				var currHeight = currentColumn.height();
				if (currHeight < lowestHeight) {
					lowest = currentColumn;
					lowestHeight = currHeight;
				}
			});

			return lowest;
		},

		repaint: function() {
			// hide columns in box
			var oldCols = this.box.find($('.zidcolumn'));
			this.columns = [];
			// build columns
			this._setCols();
			// render items in columns
			this.isResizing = true;
			this._renderItems('append', this.itemsArr);
			this.isResizing = false;
			oldCols.remove();
		},

		resize: function () {
			var boxWidth = this.box.width();
			if (boxWidth < this.minBreakPoint || boxWidth >= this.maxBreakPoint) {
				this.repaint();
			}
		},

		append: function (items) {
			this.itemsArr = this.itemsArr.concat($.makeArray(items));
			this._renderItems('append', items);
		},

		prepend: function (items) {
			this.itemsArr = $.makeArray(items).concat(this.itemsArr);
			this._renderItems('prepend', items);
		}
	};

	$.fn.zid = function (options, e) {
		if (typeof options === 'string') {
			this.each(function () {
				var container = $.data(this, 'zid');
				container[options].apply(container, [e]);
			});
		} else {
			this.each(function () {
				$.data(this, 'zid', new Zid(options, this));
			});
		}
		return this;
	};
})(jQuery);
