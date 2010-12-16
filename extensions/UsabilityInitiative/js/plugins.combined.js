/**
 * Common version-independent functions
 */

if ( typeof mw == 'undefined' ) {
	mw = {};
}

mw.usability = {
	messages: {}
}

/**
 * This may eventually load something instead of just calling the callback.
 */
mw.usability.load = function( deps, callback ) {
	callback();
};

/**
 * Add messages to a local message table
 */
mw.usability.addMessages = function( messages ) {
	for ( var key in messages ) {
		this.messages[key] = messages[key];
	}
};

/**
 * Get a message
 */
mw.usability.getMsg = function( key, args ) {
	if ( !( key in this.messages ) ) {
		return '[' + key + ']';
	}
	var msg = this.messages[key];
	if ( typeof args == 'object' || typeof args == 'array' ) {
		for ( var argKey in args ) {
			msg = msg.replace( '\$' + (parseInt( argKey ) + 1), args[argKey] );
		}
	} else if ( typeof args == 'string' || typeof args == 'number' ) {
		msg = msg.replace( '$1', args );
	}
	return msg;
};
/*
 * jQuery UI 1.7.1
 *
 * Copyright (c) 2009 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI
 */
;jQuery.ui || (function($) {

var _remove = $.fn.remove,
	isFF2 = $.browser.mozilla && (parseFloat($.browser.version) < 1.9);

//Helper functions and ui object
$.ui = {
	version: "1.7.1",

	// $.ui.plugin is deprecated.  Use the proxy pattern instead.
	plugin: {
		add: function(module, option, set) {
			var proto = $.ui[module].prototype;
			for(var i in set) {
				proto.plugins[i] = proto.plugins[i] || [];
				proto.plugins[i].push([option, set[i]]);
			}
		},
		call: function(instance, name, args) {
			var set = instance.plugins[name];
			if(!set || !instance.element[0].parentNode) { return; }

			for (var i = 0; i < set.length; i++) {
				if (instance.options[set[i][0]]) {
					set[i][1].apply(instance.element, args);
				}
			}
		}
	},

	contains: function(a, b) {
		return document.compareDocumentPosition
			? a.compareDocumentPosition(b) & 16
			: a !== b && a.contains(b);
	},

	hasScroll: function(el, a) {

		//If overflow is hidden, the element might have extra content, but the user wants to hide it
		if ($(el).css('overflow') == 'hidden') { return false; }

		var scroll = (a && a == 'left') ? 'scrollLeft' : 'scrollTop',
			has = false;

		if (el[scroll] > 0) { return true; }

		// TODO: determine which cases actually cause this to happen
		// if the element doesn't have the scroll set, see if it's possible to
		// set the scroll
		el[scroll] = 1;
		has = (el[scroll] > 0);
		el[scroll] = 0;
		return has;
	},

	isOverAxis: function(x, reference, size) {
		//Determines when x coordinate is over "b" element axis
		return (x > reference) && (x < (reference + size));
	},

	isOver: function(y, x, top, left, height, width) {
		//Determines when x, y coordinates is over "b" element
		return $.ui.isOverAxis(y, top, height) && $.ui.isOverAxis(x, left, width);
	},

	keyCode: {
		BACKSPACE: 8,
		CAPS_LOCK: 20,
		COMMA: 188,
		CONTROL: 17,
		DELETE: 46,
		DOWN: 40,
		END: 35,
		ENTER: 13,
		ESCAPE: 27,
		HOME: 36,
		INSERT: 45,
		LEFT: 37,
		NUMPAD_ADD: 107,
		NUMPAD_DECIMAL: 110,
		NUMPAD_DIVIDE: 111,
		NUMPAD_ENTER: 108,
		NUMPAD_MULTIPLY: 106,
		NUMPAD_SUBTRACT: 109,
		PAGE_DOWN: 34,
		PAGE_UP: 33,
		PERIOD: 190,
		RIGHT: 39,
		SHIFT: 16,
		SPACE: 32,
		TAB: 9,
		UP: 38
	}
};

// WAI-ARIA normalization
if (isFF2) {
	var attr = $.attr,
		removeAttr = $.fn.removeAttr,
		ariaNS = "http://www.w3.org/2005/07/aaa",
		ariaState = /^aria-/,
		ariaRole = /^wairole:/;

	$.attr = function(elem, name, value) {
		var set = value !== undefined;

		return (name == 'role'
			? (set
				? attr.call(this, elem, name, "wairole:" + value)
				: (attr.apply(this, arguments) || "").replace(ariaRole, ""))
			: (ariaState.test(name)
				? (set
					? elem.setAttributeNS(ariaNS,
						name.replace(ariaState, "aaa:"), value)
					: attr.call(this, elem, name.replace(ariaState, "aaa:")))
				: attr.apply(this, arguments)));
	};

	$.fn.removeAttr = function(name) {
		return (ariaState.test(name)
			? this.each(function() {
				this.removeAttributeNS(ariaNS, name.replace(ariaState, ""));
			}) : removeAttr.call(this, name));
	};
}

//jQuery plugins
$.fn.extend({
	remove: function() {
		// Safari has a native remove event which actually removes DOM elements,
		// so we have to use triggerHandler instead of trigger (#3037).
		$("*", this).add(this).each(function() {
			$(this).triggerHandler("remove");
		});
		return _remove.apply(this, arguments );
	},

	enableSelection: function() {
		return this
			.attr('unselectable', 'off')
			.css('MozUserSelect', '')
			.unbind('selectstart.ui');
	},

	disableSelection: function() {
		return this
			.attr('unselectable', 'on')
			.css('MozUserSelect', 'none')
			.bind('selectstart.ui', function() { return false; });
	},

	scrollParent: function() {
		var scrollParent;
		if(($.browser.msie && (/(static|relative)/).test(this.css('position'))) || (/absolute/).test(this.css('position'))) {
			scrollParent = this.parents().filter(function() {
				return (/(relative|absolute|fixed)/).test($.curCSS(this,'position',1)) && (/(auto|scroll)/).test($.curCSS(this,'overflow',1)+$.curCSS(this,'overflow-y',1)+$.curCSS(this,'overflow-x',1));
			}).eq(0);
		} else {
			scrollParent = this.parents().filter(function() {
				return (/(auto|scroll)/).test($.curCSS(this,'overflow',1)+$.curCSS(this,'overflow-y',1)+$.curCSS(this,'overflow-x',1));
			}).eq(0);
		}

		return (/fixed/).test(this.css('position')) || !scrollParent.length ? $(document) : scrollParent;
	}
});


//Additional selectors
$.extend($.expr[':'], {
	data: function(elem, i, match) {
		return !!$.data(elem, match[3]);
	},

	focusable: function(element) {
		var nodeName = element.nodeName.toLowerCase(),
			tabIndex = $.attr(element, 'tabindex');
		return (/input|select|textarea|button|object/.test(nodeName)
			? !element.disabled
			: 'a' == nodeName || 'area' == nodeName
				? element.href || !isNaN(tabIndex)
				: !isNaN(tabIndex))
			// the element and all of its ancestors must be visible
			// the browser may report that the area is hidden
			&& !$(element)['area' == nodeName ? 'parents' : 'closest'](':hidden').length;
	},

	tabbable: function(element) {
		var tabIndex = $.attr(element, 'tabindex');
		return (isNaN(tabIndex) || tabIndex >= 0) && $(element).is(':focusable');
	}
});


// $.widget is a factory to create jQuery plugins
// taking some boilerplate code out of the plugin code
function getter(namespace, plugin, method, args) {
	function getMethods(type) {
		var methods = $[namespace][plugin][type] || [];
		return (typeof methods == 'string' ? methods.split(/,?\s+/) : methods);
	}

	var methods = getMethods('getter');
	if (args.length == 1 && typeof args[0] == 'string') {
		methods = methods.concat(getMethods('getterSetter'));
	}
	return ($.inArray(method, methods) != -1);
}

$.widget = function(name, prototype) {
	var namespace = name.split(".")[0];
	name = name.split(".")[1];

	// create plugin method
	$.fn[name] = function(options) {
		var isMethodCall = (typeof options == 'string'),
			args = Array.prototype.slice.call(arguments, 1);

		// prevent calls to internal methods
		if (isMethodCall && options.substring(0, 1) == '_') {
			return this;
		}

		// handle getter methods
		if (isMethodCall && getter(namespace, name, options, args)) {
			var instance = $.data(this[0], name);
			return (instance ? instance[options].apply(instance, args)
				: undefined);
		}

		// handle initialization and non-getter methods
		return this.each(function() {
			var instance = $.data(this, name);

			// constructor
			(!instance && !isMethodCall &&
				$.data(this, name, new $[namespace][name](this, options))._init());

			// method call
			(instance && isMethodCall && $.isFunction(instance[options]) &&
				instance[options].apply(instance, args));
		});
	};

	// create widget constructor
	$[namespace] = $[namespace] || {};
	$[namespace][name] = function(element, options) {
		var self = this;

		this.namespace = namespace;
		this.widgetName = name;
		this.widgetEventPrefix = $[namespace][name].eventPrefix || name;
		this.widgetBaseClass = namespace + '-' + name;

		this.options = $.extend({},
			$.widget.defaults,
			$[namespace][name].defaults,
			$.metadata && $.metadata.get(element)[name],
			options);

		this.element = $(element)
			.bind('setData.' + name, function(event, key, value) {
				if (event.target == element) {
					return self._setData(key, value);
				}
			})
			.bind('getData.' + name, function(event, key) {
				if (event.target == element) {
					return self._getData(key);
				}
			})
			.bind('remove', function() {
				return self.destroy();
			});
	};

	// add widget prototype
	$[namespace][name].prototype = $.extend({}, $.widget.prototype, prototype);

	// TODO: merge getter and getterSetter properties from widget prototype
	// and plugin prototype
	$[namespace][name].getterSetter = 'option';
};

$.widget.prototype = {
	_init: function() {},
	destroy: function() {
		this.element.removeData(this.widgetName)
			.removeClass(this.widgetBaseClass + '-disabled' + ' ' + this.namespace + '-state-disabled')
			.removeAttr('aria-disabled');
	},

	option: function(key, value) {
		var options = key,
			self = this;

		if (typeof key == "string") {
			if (value === undefined) {
				return this._getData(key);
			}
			options = {};
			options[key] = value;
		}

		$.each(options, function(key, value) {
			self._setData(key, value);
		});
	},
	_getData: function(key) {
		return this.options[key];
	},
	_setData: function(key, value) {
		this.options[key] = value;

		if (key == 'disabled') {
			this.element
				[value ? 'addClass' : 'removeClass'](
					this.widgetBaseClass + '-disabled' + ' ' +
					this.namespace + '-state-disabled')
				.attr("aria-disabled", value);
		}
	},

	enable: function() {
		this._setData('disabled', false);
	},
	disable: function() {
		this._setData('disabled', true);
	},

	_trigger: function(type, event, data) {
		var callback = this.options[type],
			eventName = (type == this.widgetEventPrefix
				? type : this.widgetEventPrefix + type);

		event = $.Event(event);
		event.type = eventName;

		// copy original event properties over to the new event
		// this would happen if we could call $.event.fix instead of $.Event
		// but we don't have a way to force an event to be fixed multiple times
		if (event.originalEvent) {
			for (var i = $.event.props.length, prop; i;) {
				prop = $.event.props[--i];
				event[prop] = event.originalEvent[prop];
			}
		}

		this.element.trigger(event, data);

		return !($.isFunction(callback) && callback.call(this.element[0], event, data) === false
			|| event.isDefaultPrevented());
	}
};

$.widget.defaults = {
	disabled: false
};


/** Mouse Interaction Plugin **/

$.ui.mouse = {
	_mouseInit: function() {
		var self = this;

		this.element
			.bind('mousedown.'+this.widgetName, function(event) {
				return self._mouseDown(event);
			})
			.bind('click.'+this.widgetName, function(event) {
				if(self._preventClickEvent) {
					self._preventClickEvent = false;
					event.stopImmediatePropagation();
					return false;
				}
			});

		// Prevent text selection in IE
		if ($.browser.msie) {
			this._mouseUnselectable = this.element.attr('unselectable');
			this.element.attr('unselectable', 'on');
		}

		this.started = false;
	},

	// TODO: make sure destroying one instance of mouse doesn't mess with
	// other instances of mouse
	_mouseDestroy: function() {
		this.element.unbind('.'+this.widgetName);

		// Restore text selection in IE
		($.browser.msie
			&& this.element.attr('unselectable', this._mouseUnselectable));
	},

	_mouseDown: function(event) {
		// don't let more than one widget handle mouseStart
		// TODO: figure out why we have to use originalEvent
		event.originalEvent = event.originalEvent || {};
		if (event.originalEvent.mouseHandled) { return; }

		// we may have missed mouseup (out of window)
		(this._mouseStarted && this._mouseUp(event));

		this._mouseDownEvent = event;

		var self = this,
			btnIsLeft = (event.which == 1),
			elIsCancel = (typeof this.options.cancel == "string" ? $(event.target).parents().add(event.target).filter(this.options.cancel).length : false);
		if (!btnIsLeft || elIsCancel || !this._mouseCapture(event)) {
			return true;
		}

		this.mouseDelayMet = !this.options.delay;
		if (!this.mouseDelayMet) {
			this._mouseDelayTimer = setTimeout(function() {
				self.mouseDelayMet = true;
			}, this.options.delay);
		}

		if (this._mouseDistanceMet(event) && this._mouseDelayMet(event)) {
			this._mouseStarted = (this._mouseStart(event) !== false);
			if (!this._mouseStarted) {
				event.preventDefault();
				return true;
			}
		}

		// these delegates are required to keep context
		this._mouseMoveDelegate = function(event) {
			return self._mouseMove(event);
		};
		this._mouseUpDelegate = function(event) {
			return self._mouseUp(event);
		};
		$(document)
			.bind('mousemove.'+this.widgetName, this._mouseMoveDelegate)
			.bind('mouseup.'+this.widgetName, this._mouseUpDelegate);

		// preventDefault() is used to prevent the selection of text here -
		// however, in Safari, this causes select boxes not to be selectable
		// anymore, so this fix is needed
		($.browser.safari || event.preventDefault());

		event.originalEvent.mouseHandled = true;
		return true;
	},

	_mouseMove: function(event) {
		// IE mouseup check - mouseup happened when mouse was out of window
		if ($.browser.msie && !event.button) {
			return this._mouseUp(event);
		}

		if (this._mouseStarted) {
			this._mouseDrag(event);
			return event.preventDefault();
		}

		if (this._mouseDistanceMet(event) && this._mouseDelayMet(event)) {
			this._mouseStarted =
				(this._mouseStart(this._mouseDownEvent, event) !== false);
			(this._mouseStarted ? this._mouseDrag(event) : this._mouseUp(event));
		}

		return !this._mouseStarted;
	},

	_mouseUp: function(event) {
		$(document)
			.unbind('mousemove.'+this.widgetName, this._mouseMoveDelegate)
			.unbind('mouseup.'+this.widgetName, this._mouseUpDelegate);

		if (this._mouseStarted) {
			this._mouseStarted = false;
			this._preventClickEvent = (event.target == this._mouseDownEvent.target);
			this._mouseStop(event);
		}

		return false;
	},

	_mouseDistanceMet: function(event) {
		return (Math.max(
				Math.abs(this._mouseDownEvent.pageX - event.pageX),
				Math.abs(this._mouseDownEvent.pageY - event.pageY)
			) >= this.options.distance
		);
	},

	_mouseDelayMet: function(event) {
		return this.mouseDelayMet;
	},

	// These are placeholder methods, to be overriden by extending plugin
	_mouseStart: function(event) {},
	_mouseDrag: function(event) {},
	_mouseStop: function(event) {},
	_mouseCapture: function(event) { return true; }
};

$.ui.mouse.defaults = {
	cancel: null,
	distance: 1,
	delay: 0
};

})(jQuery);/*
 * jQuery UI Datepicker 1.7.1
 *
 * Copyright (c) 2009 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Datepicker
 *
 * Depends:
 *	ui.core.js
 */

(function($) { // hide the namespace

$.extend($.ui, { datepicker: { version: "1.7.1" } });

var PROP_NAME = 'datepicker';

/* Date picker manager.
   Use the singleton instance of this class, $.datepicker, to interact with the date picker.
   Settings for (groups of) date pickers are maintained in an instance object,
   allowing multiple different settings on the same page. */

function Datepicker() {
	this.debug = false; // Change this to true to start debugging
	this._curInst = null; // The current instance in use
	this._keyEvent = false; // If the last event was a key event
	this._disabledInputs = []; // List of date picker inputs that have been disabled
	this._datepickerShowing = false; // True if the popup picker is showing , false if not
	this._inDialog = false; // True if showing within a "dialog", false if not
	this._mainDivId = 'ui-datepicker-div'; // The ID of the main datepicker division
	this._inlineClass = 'ui-datepicker-inline'; // The name of the inline marker class
	this._appendClass = 'ui-datepicker-append'; // The name of the append marker class
	this._triggerClass = 'ui-datepicker-trigger'; // The name of the trigger marker class
	this._dialogClass = 'ui-datepicker-dialog'; // The name of the dialog marker class
	this._disableClass = 'ui-datepicker-disabled'; // The name of the disabled covering marker class
	this._unselectableClass = 'ui-datepicker-unselectable'; // The name of the unselectable cell marker class
	this._currentClass = 'ui-datepicker-current-day'; // The name of the current day marker class
	this._dayOverClass = 'ui-datepicker-days-cell-over'; // The name of the day hover marker class
	this.regional = []; // Available regional settings, indexed by language code
	this.regional[''] = { // Default regional settings
		closeText: 'Done', // Display text for close link
		prevText: 'Prev', // Display text for previous month link
		nextText: 'Next', // Display text for next month link
		currentText: 'Today', // Display text for current month link
		monthNames: ['January','February','March','April','May','June',
			'July','August','September','October','November','December'], // Names of months for drop-down and formatting
		monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // For formatting
		dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], // For formatting
		dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'], // For formatting
		dayNamesMin: ['Su','Mo','Tu','We','Th','Fr','Sa'], // Column headings for days starting at Sunday
		dateFormat: 'mm/dd/yy', // See format options on parseDate
		firstDay: 0, // The first day of the week, Sun = 0, Mon = 1, ...
		isRTL: false // True if right-to-left language, false if left-to-right
	};
	this._defaults = { // Global defaults for all the date picker instances
		showOn: 'focus', // 'focus' for popup on focus,
			// 'button' for trigger button, or 'both' for either
		showAnim: 'show', // Name of jQuery animation for popup
		showOptions: {}, // Options for enhanced animations
		defaultDate: null, // Used when field is blank: actual date,
			// +/-number for offset from today, null for today
		appendText: '', // Display text following the input box, e.g. showing the format
		buttonText: '...', // Text for trigger button
		buttonImage: '', // URL for trigger button image
		buttonImageOnly: false, // True if the image appears alone, false if it appears on a button
		hideIfNoPrevNext: false, // True to hide next/previous month links
			// if not applicable, false to just disable them
		navigationAsDateFormat: false, // True if date formatting applied to prev/today/next links
		gotoCurrent: false, // True if today link goes back to current selection instead
		changeMonth: false, // True if month can be selected directly, false if only prev/next
		changeYear: false, // True if year can be selected directly, false if only prev/next
		showMonthAfterYear: false, // True if the year select precedes month, false for month then year
		yearRange: '-10:+10', // Range of years to display in drop-down,
			// either relative to current year (-nn:+nn) or absolute (nnnn:nnnn)
		showOtherMonths: false, // True to show dates in other months, false to leave blank
		calculateWeek: this.iso8601Week, // How to calculate the week of the year,
			// takes a Date and returns the number of the week for it
		shortYearCutoff: '+10', // Short year values < this are in the current century,
			// > this are in the previous century,
			// string value starting with '+' for current year + value
		minDate: null, // The earliest selectable date, or null for no limit
		maxDate: null, // The latest selectable date, or null for no limit
		duration: 'normal', // Duration of display/closure
		beforeShowDay: null, // Function that takes a date and returns an array with
			// [0] = true if selectable, false if not, [1] = custom CSS class name(s) or '',
			// [2] = cell title (optional), e.g. $.datepicker.noWeekends
		beforeShow: null, // Function that takes an input field and
			// returns a set of custom settings for the date picker
		onSelect: null, // Define a callback function when a date is selected
		onChangeMonthYear: null, // Define a callback function when the month or year is changed
		onClose: null, // Define a callback function when the datepicker is closed
		numberOfMonths: 1, // Number of months to show at a time
		showCurrentAtPos: 0, // The position in multipe months at which to show the current month (starting at 0)
		stepMonths: 1, // Number of months to step back/forward
		stepBigMonths: 12, // Number of months to step back/forward for the big links
		altField: '', // Selector for an alternate field to store selected dates into
		altFormat: '', // The date format to use for the alternate field
		constrainInput: true, // The input is constrained by the current date format
		showButtonPanel: false // True to show button panel, false to not show it
	};
	$.extend(this._defaults, this.regional['']);
	this.dpDiv = $('<div id="' + this._mainDivId + '" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible"></div>');
}

$.extend(Datepicker.prototype, {
	/* Class name added to elements to indicate already configured with a date picker. */
	markerClassName: 'hasDatepicker',

	/* Debug logging (if enabled). */
	log: function () {
		if (this.debug)
			console.log.apply('', arguments);
	},

	/* Override the default settings for all instances of the date picker.
	   @param  settings  object - the new settings to use as defaults (anonymous object)
	   @return the manager object */
	setDefaults: function(settings) {
		extendRemove(this._defaults, settings || {});
		return this;
	},

	/* Attach the date picker to a jQuery selection.
	   @param  target    element - the target input field or division or span
	   @param  settings  object - the new settings to use for this date picker instance (anonymous) */
	_attachDatepicker: function(target, settings) {
		// check for settings on the control itself - in namespace 'date:'
		var inlineSettings = null;
		for (var attrName in this._defaults) {
			var attrValue = target.getAttribute('date:' + attrName);
			if (attrValue) {
				inlineSettings = inlineSettings || {};
				try {
					inlineSettings[attrName] = eval(attrValue);
				} catch (err) {
					inlineSettings[attrName] = attrValue;
				}
			}
		}
		var nodeName = target.nodeName.toLowerCase();
		var inline = (nodeName == 'div' || nodeName == 'span');
		if (!target.id)
			target.id = 'dp' + (++this.uuid);
		var inst = this._newInst($(target), inline);
		inst.settings = $.extend({}, settings || {}, inlineSettings || {});
		if (nodeName == 'input') {
			this._connectDatepicker(target, inst);
		} else if (inline) {
			this._inlineDatepicker(target, inst);
		}
	},

	/* Create a new instance object. */
	_newInst: function(target, inline) {
		var id = target[0].id.replace(/([:\[\]\.])/g, '\\\\$1'); // escape jQuery meta chars
		return {id: id, input: target, // associated target
			selectedDay: 0, selectedMonth: 0, selectedYear: 0, // current selection
			drawMonth: 0, drawYear: 0, // month being drawn
			inline: inline, // is datepicker inline or not
			dpDiv: (!inline ? this.dpDiv : // presentation div
			$('<div class="' + this._inlineClass + ' ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>'))};
	},

	/* Attach the date picker to an input field. */
	_connectDatepicker: function(target, inst) {
		var input = $(target);
		inst.trigger = $([]);
		if (input.hasClass(this.markerClassName))
			return;
		var appendText = this._get(inst, 'appendText');
		var isRTL = this._get(inst, 'isRTL');
		if (appendText)
			input[isRTL ? 'before' : 'after']('<span class="' + this._appendClass + '">' + appendText + '</span>');
		var showOn = this._get(inst, 'showOn');
		if (showOn == 'focus' || showOn == 'both') // pop-up date picker when in the marked field
			input.focus(this._showDatepicker);
		if (showOn == 'button' || showOn == 'both') { // pop-up date picker when button clicked
			var buttonText = this._get(inst, 'buttonText');
			var buttonImage = this._get(inst, 'buttonImage');
			inst.trigger = $(this._get(inst, 'buttonImageOnly') ?
				$('<img/>').addClass(this._triggerClass).
					attr({ src: buttonImage, alt: buttonText, title: buttonText }) :
				$('<button type="button"></button>').addClass(this._triggerClass).
					html(buttonImage == '' ? buttonText : $('<img/>').attr(
					{ src:buttonImage, alt:buttonText, title:buttonText })));
			input[isRTL ? 'before' : 'after'](inst.trigger);
			inst.trigger.click(function() {
				if ($.datepicker._datepickerShowing && $.datepicker._lastInput == target)
					$.datepicker._hideDatepicker();
				else
					$.datepicker._showDatepicker(target);
				return false;
			});
		}
		input.addClass(this.markerClassName).keydown(this._doKeyDown).keypress(this._doKeyPress).
			bind("setData.datepicker", function(event, key, value) {
				inst.settings[key] = value;
			}).bind("getData.datepicker", function(event, key) {
				return this._get(inst, key);
			});
		$.data(target, PROP_NAME, inst);
	},

	/* Attach an inline date picker to a div. */
	_inlineDatepicker: function(target, inst) {
		var divSpan = $(target);
		if (divSpan.hasClass(this.markerClassName))
			return;
		divSpan.addClass(this.markerClassName).append(inst.dpDiv).
			bind("setData.datepicker", function(event, key, value){
				inst.settings[key] = value;
			}).bind("getData.datepicker", function(event, key){
				return this._get(inst, key);
			});
		$.data(target, PROP_NAME, inst);
		this._setDate(inst, this._getDefaultDate(inst));
		this._updateDatepicker(inst);
		this._updateAlternate(inst);
	},

	/* Pop-up the date picker in a "dialog" box.
	   @param  input     element - ignored
	   @param  dateText  string - the initial date to display (in the current format)
	   @param  onSelect  function - the function(dateText) to call when a date is selected
	   @param  settings  object - update the dialog date picker instance's settings (anonymous object)
	   @param  pos       int[2] - coordinates for the dialog's position within the screen or
	                     event - with x/y coordinates or
	                     leave empty for default (screen centre)
	   @return the manager object */
	_dialogDatepicker: function(input, dateText, onSelect, settings, pos) {
		var inst = this._dialogInst; // internal instance
		if (!inst) {
			var id = 'dp' + (++this.uuid);
			this._dialogInput = $('<input type="text" id="' + id +
				'" size="1" style="position: absolute; top: -100px;"/>');
			this._dialogInput.keydown(this._doKeyDown);
			$('body').append(this._dialogInput);
			inst = this._dialogInst = this._newInst(this._dialogInput, false);
			inst.settings = {};
			$.data(this._dialogInput[0], PROP_NAME, inst);
		}
		extendRemove(inst.settings, settings || {});
		this._dialogInput.val(dateText);

		this._pos = (pos ? (pos.length ? pos : [pos.pageX, pos.pageY]) : null);
		if (!this._pos) {
			var browserWidth = window.innerWidth || document.documentElement.clientWidth ||	document.body.clientWidth;
			var browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
			var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft;
			var scrollY = document.documentElement.scrollTop || document.body.scrollTop;
			this._pos = // should use actual width/height below
				[(browserWidth / 2) - 100 + scrollX, (browserHeight / 2) - 150 + scrollY];
		}

		// move input on screen for focus, but hidden behind dialog
		this._dialogInput.css('left', this._pos[0] + 'px').css('top', this._pos[1] + 'px');
		inst.settings.onSelect = onSelect;
		this._inDialog = true;
		this.dpDiv.addClass(this._dialogClass);
		this._showDatepicker(this._dialogInput[0]);
		if ($.blockUI)
			$.blockUI(this.dpDiv);
		$.data(this._dialogInput[0], PROP_NAME, inst);
		return this;
	},

	/* Detach a datepicker from its control.
	   @param  target    element - the target input field or division or span */
	_destroyDatepicker: function(target) {
		var $target = $(target);
		var inst = $.data(target, PROP_NAME);
		if (!$target.hasClass(this.markerClassName)) {
			return;
		}
		var nodeName = target.nodeName.toLowerCase();
		$.removeData(target, PROP_NAME);
		if (nodeName == 'input') {
			inst.trigger.remove();
			$target.siblings('.' + this._appendClass).remove().end().
				removeClass(this.markerClassName).
				unbind('focus', this._showDatepicker).
				unbind('keydown', this._doKeyDown).
				unbind('keypress', this._doKeyPress);
		} else if (nodeName == 'div' || nodeName == 'span')
			$target.removeClass(this.markerClassName).empty();
	},

	/* Enable the date picker to a jQuery selection.
	   @param  target    element - the target input field or division or span */
	_enableDatepicker: function(target) {
		var $target = $(target);
		var inst = $.data(target, PROP_NAME);
		if (!$target.hasClass(this.markerClassName)) {
			return;
		}
		var nodeName = target.nodeName.toLowerCase();
		if (nodeName == 'input') {
		target.disabled = false;
			inst.trigger.filter("button").
			each(function() { this.disabled = false; }).end().
				filter("img").
				css({opacity: '1.0', cursor: ''});
		}
		else if (nodeName == 'div' || nodeName == 'span') {
			var inline = $target.children('.' + this._inlineClass);
			inline.children().removeClass('ui-state-disabled');
		}
		this._disabledInputs = $.map(this._disabledInputs,
			function(value) { return (value == target ? null : value); }); // delete entry
	},

	/* Disable the date picker to a jQuery selection.
	   @param  target    element - the target input field or division or span */
	_disableDatepicker: function(target) {
		var $target = $(target);
		var inst = $.data(target, PROP_NAME);
		if (!$target.hasClass(this.markerClassName)) {
			return;
		}
		var nodeName = target.nodeName.toLowerCase();
		if (nodeName == 'input') {
		target.disabled = true;
			inst.trigger.filter("button").
			each(function() { this.disabled = true; }).end().
				filter("img").
				css({opacity: '0.5', cursor: 'default'});
		}
		else if (nodeName == 'div' || nodeName == 'span') {
			var inline = $target.children('.' + this._inlineClass);
			inline.children().addClass('ui-state-disabled');
		}
		this._disabledInputs = $.map(this._disabledInputs,
			function(value) { return (value == target ? null : value); }); // delete entry
		this._disabledInputs[this._disabledInputs.length] = target;
	},

	/* Is the first field in a jQuery collection disabled as a datepicker?
	   @param  target    element - the target input field or division or span
	   @return boolean - true if disabled, false if enabled */
	_isDisabledDatepicker: function(target) {
		if (!target) {
			return false;
		}
		for (var i = 0; i < this._disabledInputs.length; i++) {
			if (this._disabledInputs[i] == target)
				return true;
		}
		return false;
	},

	/* Retrieve the instance data for the target control.
	   @param  target  element - the target input field or division or span
	   @return  object - the associated instance data
	   @throws  error if a jQuery problem getting data */
	_getInst: function(target) {
		try {
			return $.data(target, PROP_NAME);
		}
		catch (err) {
			throw 'Missing instance data for this datepicker';
		}
	},

	/* Update the settings for a date picker attached to an input field or division.
	   @param  target  element - the target input field or division or span
	   @param  name    object - the new settings to update or
	                   string - the name of the setting to change or
	   @param  value   any - the new value for the setting (omit if above is an object) */
	_optionDatepicker: function(target, name, value) {
		var settings = name || {};
		if (typeof name == 'string') {
			settings = {};
			settings[name] = value;
		}
		var inst = this._getInst(target);
		if (inst) {
			if (this._curInst == inst) {
				this._hideDatepicker(null);
			}
			extendRemove(inst.settings, settings);
			var date = new Date();
			extendRemove(inst, {rangeStart: null, // start of range
				endDay: null, endMonth: null, endYear: null, // end of range
				selectedDay: date.getDate(), selectedMonth: date.getMonth(),
				selectedYear: date.getFullYear(), // starting point
				currentDay: date.getDate(), currentMonth: date.getMonth(),
				currentYear: date.getFullYear(), // current selection
				drawMonth: date.getMonth(), drawYear: date.getFullYear()}); // month being drawn
			this._updateDatepicker(inst);
		}
	},

	// change method deprecated
	_changeDatepicker: function(target, name, value) {
		this._optionDatepicker(target, name, value);
	},

	/* Redraw the date picker attached to an input field or division.
	   @param  target  element - the target input field or division or span */
	_refreshDatepicker: function(target) {
		var inst = this._getInst(target);
		if (inst) {
			this._updateDatepicker(inst);
		}
	},

	/* Set the dates for a jQuery selection.
	   @param  target   element - the target input field or division or span
	   @param  date     Date - the new date
	   @param  endDate  Date - the new end date for a range (optional) */
	_setDateDatepicker: function(target, date, endDate) {
		var inst = this._getInst(target);
		if (inst) {
			this._setDate(inst, date, endDate);
			this._updateDatepicker(inst);
			this._updateAlternate(inst);
		}
	},

	/* Get the date(s) for the first entry in a jQuery selection.
	   @param  target  element - the target input field or division or span
	   @return Date - the current date or
	           Date[2] - the current dates for a range */
	_getDateDatepicker: function(target) {
		var inst = this._getInst(target);
		if (inst && !inst.inline)
			this._setDateFromField(inst);
		return (inst ? this._getDate(inst) : null);
	},

	/* Handle keystrokes. */
	_doKeyDown: function(event) {
		var inst = $.datepicker._getInst(event.target);
		var handled = true;
		var isRTL = inst.dpDiv.is('.ui-datepicker-rtl');
		inst._keyEvent = true;
		if ($.datepicker._datepickerShowing)
			switch (event.keyCode) {
				case 9:  $.datepicker._hideDatepicker(null, '');
						break; // hide on tab out
				case 13: var sel = $('td.' + $.datepicker._dayOverClass +
							', td.' + $.datepicker._currentClass, inst.dpDiv);
						if (sel[0])
							$.datepicker._selectDay(event.target, inst.selectedMonth, inst.selectedYear, sel[0]);
						else
							$.datepicker._hideDatepicker(null, $.datepicker._get(inst, 'duration'));
						return false; // don't submit the form
						break; // select the value on enter
				case 27: $.datepicker._hideDatepicker(null, $.datepicker._get(inst, 'duration'));
						break; // hide on escape
				case 33: $.datepicker._adjustDate(event.target, (event.ctrlKey ?
							-$.datepicker._get(inst, 'stepBigMonths') :
							-$.datepicker._get(inst, 'stepMonths')), 'M');
						break; // previous month/year on page up/+ ctrl
				case 34: $.datepicker._adjustDate(event.target, (event.ctrlKey ?
							+$.datepicker._get(inst, 'stepBigMonths') :
							+$.datepicker._get(inst, 'stepMonths')), 'M');
						break; // next month/year on page down/+ ctrl
				case 35: if (event.ctrlKey || event.metaKey) $.datepicker._clearDate(event.target);
						handled = event.ctrlKey || event.metaKey;
						break; // clear on ctrl or command +end
				case 36: if (event.ctrlKey || event.metaKey) $.datepicker._gotoToday(event.target);
						handled = event.ctrlKey || event.metaKey;
						break; // current on ctrl or command +home
				case 37: if (event.ctrlKey || event.metaKey) $.datepicker._adjustDate(event.target, (isRTL ? +1 : -1), 'D');
						handled = event.ctrlKey || event.metaKey;
						// -1 day on ctrl or command +left
						if (event.originalEvent.altKey) $.datepicker._adjustDate(event.target, (event.ctrlKey ?
									-$.datepicker._get(inst, 'stepBigMonths') :
									-$.datepicker._get(inst, 'stepMonths')), 'M');
						// next month/year on alt +left on Mac
						break;
				case 38: if (event.ctrlKey || event.metaKey) $.datepicker._adjustDate(event.target, -7, 'D');
						handled = event.ctrlKey || event.metaKey;
						break; // -1 week on ctrl or command +up
				case 39: if (event.ctrlKey || event.metaKey) $.datepicker._adjustDate(event.target, (isRTL ? -1 : +1), 'D');
						handled = event.ctrlKey || event.metaKey;
						// +1 day on ctrl or command +right
						if (event.originalEvent.altKey) $.datepicker._adjustDate(event.target, (event.ctrlKey ?
									+$.datepicker._get(inst, 'stepBigMonths') :
									+$.datepicker._get(inst, 'stepMonths')), 'M');
						// next month/year on alt +right
						break;
				case 40: if (event.ctrlKey || event.metaKey) $.datepicker._adjustDate(event.target, +7, 'D');
						handled = event.ctrlKey || event.metaKey;
						break; // +1 week on ctrl or command +down
				default: handled = false;
			}
		else if (event.keyCode == 36 && event.ctrlKey) // display the date picker on ctrl+home
			$.datepicker._showDatepicker(this);
		else {
			handled = false;
		}
		if (handled) {
			event.preventDefault();
			event.stopPropagation();
		}
	},

	/* Filter entered characters - based on date format. */
	_doKeyPress: function(event) {
		var inst = $.datepicker._getInst(event.target);
		if ($.datepicker._get(inst, 'constrainInput')) {
			var chars = $.datepicker._possibleChars($.datepicker._get(inst, 'dateFormat'));
			var chr = String.fromCharCode(event.charCode == undefined ? event.keyCode : event.charCode);
			return event.ctrlKey || (chr < ' ' || !chars || chars.indexOf(chr) > -1);
		}
	},

	/* Pop-up the date picker for a given input field.
	   @param  input  element - the input field attached to the date picker or
	                  event - if triggered by focus */
	_showDatepicker: function(input) {
		input = input.target || input;
		if (input.nodeName.toLowerCase() != 'input') // find from button/image trigger
			input = $('input', input.parentNode)[0];
		if ($.datepicker._isDisabledDatepicker(input) || $.datepicker._lastInput == input) // already here
			return;
		var inst = $.datepicker._getInst(input);
		var beforeShow = $.datepicker._get(inst, 'beforeShow');
		extendRemove(inst.settings, (beforeShow ? beforeShow.apply(input, [input, inst]) : {}));
		$.datepicker._hideDatepicker(null, '');
		$.datepicker._lastInput = input;
		$.datepicker._setDateFromField(inst);
		if ($.datepicker._inDialog) // hide cursor
			input.value = '';
		if (!$.datepicker._pos) { // position below input
			$.datepicker._pos = $.datepicker._findPos(input);
			$.datepicker._pos[1] += input.offsetHeight; // add the height
		}
		var isFixed = false;
		$(input).parents().each(function() {
			isFixed |= $(this).css('position') == 'fixed';
			return !isFixed;
		});
		if (isFixed && $.browser.opera) { // correction for Opera when fixed and scrolled
			$.datepicker._pos[0] -= document.documentElement.scrollLeft;
			$.datepicker._pos[1] -= document.documentElement.scrollTop;
		}
		var offset = {left: $.datepicker._pos[0], top: $.datepicker._pos[1]};
		$.datepicker._pos = null;
		inst.rangeStart = null;
		// determine sizing offscreen
		inst.dpDiv.css({position: 'absolute', display: 'block', top: '-1000px'});
		$.datepicker._updateDatepicker(inst);
		// fix width for dynamic number of date pickers
		// and adjust position before showing
		offset = $.datepicker._checkOffset(inst, offset, isFixed);
		inst.dpDiv.css({position: ($.datepicker._inDialog && $.blockUI ?
			'static' : (isFixed ? 'fixed' : 'absolute')), display: 'none',
			left: offset.left + 'px', top: offset.top + 'px'});
		if (!inst.inline) {
			var showAnim = $.datepicker._get(inst, 'showAnim') || 'show';
			var duration = $.datepicker._get(inst, 'duration');
			var postProcess = function() {
				$.datepicker._datepickerShowing = true;
				if ($.browser.msie && parseInt($.browser.version,10) < 7) // fix IE < 7 select problems
					$('iframe.ui-datepicker-cover').css({width: inst.dpDiv.width() + 4,
						height: inst.dpDiv.height() + 4});
			};
			if ($.effects && $.effects[showAnim])
				inst.dpDiv.show(showAnim, $.datepicker._get(inst, 'showOptions'), duration, postProcess);
			else
				inst.dpDiv[showAnim](duration, postProcess);
			if (duration == '')
				postProcess();
			if (inst.input[0].type != 'hidden')
				inst.input[0].focus();
			$.datepicker._curInst = inst;
		}
	},

	/* Generate the date picker content. */
	_updateDatepicker: function(inst) {
		var dims = {width: inst.dpDiv.width() + 4,
			height: inst.dpDiv.height() + 4};
		var self = this;
		inst.dpDiv.empty().append(this._generateHTML(inst))
			.find('iframe.ui-datepicker-cover').
				css({width: dims.width, height: dims.height})
			.end()
			.find('button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a')
				.bind('mouseout', function(){
					$(this).removeClass('ui-state-hover');
					if(this.className.indexOf('ui-datepicker-prev') != -1) $(this).removeClass('ui-datepicker-prev-hover');
					if(this.className.indexOf('ui-datepicker-next') != -1) $(this).removeClass('ui-datepicker-next-hover');
				})
				.bind('mouseover', function(){
					if (!self._isDisabledDatepicker( inst.inline ? inst.dpDiv.parent()[0] : inst.input[0])) {
						$(this).parents('.ui-datepicker-calendar').find('a').removeClass('ui-state-hover');
						$(this).addClass('ui-state-hover');
						if(this.className.indexOf('ui-datepicker-prev') != -1) $(this).addClass('ui-datepicker-prev-hover');
						if(this.className.indexOf('ui-datepicker-next') != -1) $(this).addClass('ui-datepicker-next-hover');
					}
				})
			.end()
			.find('.' + this._dayOverClass + ' a')
				.trigger('mouseover')
			.end();
		var numMonths = this._getNumberOfMonths(inst);
		var cols = numMonths[1];
		var width = 17;
		if (cols > 1) {
			inst.dpDiv.addClass('ui-datepicker-multi-' + cols).css('width', (width * cols) + 'em');
		} else {
			inst.dpDiv.removeClass('ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4').width('');
		}
		inst.dpDiv[(numMonths[0] != 1 || numMonths[1] != 1 ? 'add' : 'remove') +
			'Class']('ui-datepicker-multi');
		inst.dpDiv[(this._get(inst, 'isRTL') ? 'add' : 'remove') +
			'Class']('ui-datepicker-rtl');
		if (inst.input && inst.input[0].type != 'hidden' && inst == $.datepicker._curInst)
			$(inst.input[0]).focus();
	},

	/* Check positioning to remain on screen. */
	_checkOffset: function(inst, offset, isFixed) {
		var dpWidth = inst.dpDiv.outerWidth();
		var dpHeight = inst.dpDiv.outerHeight();
		var inputWidth = inst.input ? inst.input.outerWidth() : 0;
		var inputHeight = inst.input ? inst.input.outerHeight() : 0;
		var viewWidth = (window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth) + $(document).scrollLeft();
		var viewHeight = (window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight) + $(document).scrollTop();

		offset.left -= (this._get(inst, 'isRTL') ? (dpWidth - inputWidth) : 0);
		offset.left -= (isFixed && offset.left == inst.input.offset().left) ? $(document).scrollLeft() : 0;
		offset.top -= (isFixed && offset.top == (inst.input.offset().top + inputHeight)) ? $(document).scrollTop() : 0;

		// now check if datepicker is showing outside window viewport - move to a better place if so.
		offset.left -= (offset.left + dpWidth > viewWidth && viewWidth > dpWidth) ? Math.abs(offset.left + dpWidth - viewWidth) : 0;
		offset.top -= (offset.top + dpHeight > viewHeight && viewHeight > dpHeight) ? Math.abs(offset.top + dpHeight + inputHeight*2 - viewHeight) : 0;

		return offset;
	},

	/* Find an object's position on the screen. */
	_findPos: function(obj) {
        while (obj && (obj.type == 'hidden' || obj.nodeType != 1)) {
            obj = obj.nextSibling;
        }
        var position = $(obj).offset();
	    return [position.left, position.top];
	},

	/* Hide the date picker from view.
	   @param  input  element - the input field attached to the date picker
	   @param  duration  string - the duration over which to close the date picker */
	_hideDatepicker: function(input, duration) {
		var inst = this._curInst;
		if (!inst || (input && inst != $.data(input, PROP_NAME)))
			return;
		if (inst.stayOpen)
			this._selectDate('#' + inst.id, this._formatDate(inst,
				inst.currentDay, inst.currentMonth, inst.currentYear));
		inst.stayOpen = false;
		if (this._datepickerShowing) {
			duration = (duration != null ? duration : this._get(inst, 'duration'));
			var showAnim = this._get(inst, 'showAnim');
			var postProcess = function() {
				$.datepicker._tidyDialog(inst);
			};
			if (duration != '' && $.effects && $.effects[showAnim])
				inst.dpDiv.hide(showAnim, $.datepicker._get(inst, 'showOptions'),
					duration, postProcess);
			else
				inst.dpDiv[(duration == '' ? 'hide' : (showAnim == 'slideDown' ? 'slideUp' :
					(showAnim == 'fadeIn' ? 'fadeOut' : 'hide')))](duration, postProcess);
			if (duration == '')
				this._tidyDialog(inst);
			var onClose = this._get(inst, 'onClose');
			if (onClose)
				onClose.apply((inst.input ? inst.input[0] : null),
					[(inst.input ? inst.input.val() : ''), inst]);  // trigger custom callback
			this._datepickerShowing = false;
			this._lastInput = null;
			if (this._inDialog) {
				this._dialogInput.css({ position: 'absolute', left: '0', top: '-100px' });
				if ($.blockUI) {
					$.unblockUI();
					$('body').append(this.dpDiv);
				}
			}
			this._inDialog = false;
		}
		this._curInst = null;
	},

	/* Tidy up after a dialog display. */
	_tidyDialog: function(inst) {
		inst.dpDiv.removeClass(this._dialogClass).unbind('.ui-datepicker-calendar');
	},

	/* Close date picker if clicked elsewhere. */
	_checkExternalClick: function(event) {
		if (!$.datepicker._curInst)
			return;
		var $target = $(event.target);
		if (($target.parents('#' + $.datepicker._mainDivId).length == 0) &&
				!$target.hasClass($.datepicker.markerClassName) &&
				!$target.hasClass($.datepicker._triggerClass) &&
				$.datepicker._datepickerShowing && !($.datepicker._inDialog && $.blockUI))
			$.datepicker._hideDatepicker(null, '');
	},

	/* Adjust one of the date sub-fields. */
	_adjustDate: function(id, offset, period) {
		var target = $(id);
		var inst = this._getInst(target[0]);
		if (this._isDisabledDatepicker(target[0])) {
			return;
		}
		this._adjustInstDate(inst, offset +
			(period == 'M' ? this._get(inst, 'showCurrentAtPos') : 0), // undo positioning
			period);
		this._updateDatepicker(inst);
	},

	/* Action for current link. */
	_gotoToday: function(id) {
		var target = $(id);
		var inst = this._getInst(target[0]);
		if (this._get(inst, 'gotoCurrent') && inst.currentDay) {
			inst.selectedDay = inst.currentDay;
			inst.drawMonth = inst.selectedMonth = inst.currentMonth;
			inst.drawYear = inst.selectedYear = inst.currentYear;
		}
		else {
		var date = new Date();
		inst.selectedDay = date.getDate();
		inst.drawMonth = inst.selectedMonth = date.getMonth();
		inst.drawYear = inst.selectedYear = date.getFullYear();
		}
		this._notifyChange(inst);
		this._adjustDate(target);
	},

	/* Action for selecting a new month/year. */
	_selectMonthYear: function(id, select, period) {
		var target = $(id);
		var inst = this._getInst(target[0]);
		inst._selectingMonthYear = false;
		inst['selected' + (period == 'M' ? 'Month' : 'Year')] =
		inst['draw' + (period == 'M' ? 'Month' : 'Year')] =
			parseInt(select.options[select.selectedIndex].value,10);
		this._notifyChange(inst);
		this._adjustDate(target);
	},

	/* Restore input focus after not changing month/year. */
	_clickMonthYear: function(id) {
		var target = $(id);
		var inst = this._getInst(target[0]);
		if (inst.input && inst._selectingMonthYear && !$.browser.msie)
			inst.input[0].focus();
		inst._selectingMonthYear = !inst._selectingMonthYear;
	},

	/* Action for selecting a day. */
	_selectDay: function(id, month, year, td) {
		var target = $(id);
		if ($(td).hasClass(this._unselectableClass) || this._isDisabledDatepicker(target[0])) {
			return;
		}
		var inst = this._getInst(target[0]);
		inst.selectedDay = inst.currentDay = $('a', td).html();
		inst.selectedMonth = inst.currentMonth = month;
		inst.selectedYear = inst.currentYear = year;
		if (inst.stayOpen) {
			inst.endDay = inst.endMonth = inst.endYear = null;
		}
		this._selectDate(id, this._formatDate(inst,
			inst.currentDay, inst.currentMonth, inst.currentYear));
		if (inst.stayOpen) {
			inst.rangeStart = this._daylightSavingAdjust(
				new Date(inst.currentYear, inst.currentMonth, inst.currentDay));
			this._updateDatepicker(inst);
		}
	},

	/* Erase the input field and hide the date picker. */
	_clearDate: function(id) {
		var target = $(id);
		var inst = this._getInst(target[0]);
		inst.stayOpen = false;
		inst.endDay = inst.endMonth = inst.endYear = inst.rangeStart = null;
		this._selectDate(target, '');
	},

	/* Update the input field with the selected date. */
	_selectDate: function(id, dateStr) {
		var target = $(id);
		var inst = this._getInst(target[0]);
		dateStr = (dateStr != null ? dateStr : this._formatDate(inst));
		if (inst.input)
			inst.input.val(dateStr);
		this._updateAlternate(inst);
		var onSelect = this._get(inst, 'onSelect');
		if (onSelect)
			onSelect.apply((inst.input ? inst.input[0] : null), [dateStr, inst]);  // trigger custom callback
		else if (inst.input)
			inst.input.trigger('change'); // fire the change event
		if (inst.inline)
			this._updateDatepicker(inst);
		else if (!inst.stayOpen) {
			this._hideDatepicker(null, this._get(inst, 'duration'));
			this._lastInput = inst.input[0];
			if (typeof(inst.input[0]) != 'object')
				inst.input[0].focus(); // restore focus
			this._lastInput = null;
		}
	},

	/* Update any alternate field to synchronise with the main field. */
	_updateAlternate: function(inst) {
		var altField = this._get(inst, 'altField');
		if (altField) { // update alternate field too
			var altFormat = this._get(inst, 'altFormat') || this._get(inst, 'dateFormat');
			var date = this._getDate(inst);
			dateStr = this.formatDate(altFormat, date, this._getFormatConfig(inst));
			$(altField).each(function() { $(this).val(dateStr); });
		}
	},

	/* Set as beforeShowDay function to prevent selection of weekends.
	   @param  date  Date - the date to customise
	   @return [boolean, string] - is this date selectable?, what is its CSS class? */
	noWeekends: function(date) {
		var day = date.getDay();
		return [(day > 0 && day < 6), ''];
	},

	/* Set as calculateWeek to determine the week of the year based on the ISO 8601 definition.
	   @param  date  Date - the date to get the week for
	   @return  number - the number of the week within the year that contains this date */
	iso8601Week: function(date) {
		var checkDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
		var firstMon = new Date(checkDate.getFullYear(), 1 - 1, 4); // First week always contains 4 Jan
		var firstDay = firstMon.getDay() || 7; // Day of week: Mon = 1, ..., Sun = 7
		firstMon.setDate(firstMon.getDate() + 1 - firstDay); // Preceding Monday
		if (firstDay < 4 && checkDate < firstMon) { // Adjust first three days in year if necessary
			checkDate.setDate(checkDate.getDate() - 3); // Generate for previous year
			return $.datepicker.iso8601Week(checkDate);
		} else if (checkDate > new Date(checkDate.getFullYear(), 12 - 1, 28)) { // Check last three days in year
			firstDay = new Date(checkDate.getFullYear() + 1, 1 - 1, 4).getDay() || 7;
			if (firstDay > 4 && (checkDate.getDay() || 7) < firstDay - 3) { // Adjust if necessary
				return 1;
			}
		}
		return Math.floor(((checkDate - firstMon) / 86400000) / 7) + 1; // Weeks to given date
	},

	/* Parse a string value into a date object.
	   See formatDate below for the possible formats.

	   @param  format    string - the expected format of the date
	   @param  value     string - the date in the above format
	   @param  settings  Object - attributes include:
	                     shortYearCutoff  number - the cutoff year for determining the century (optional)
	                     dayNamesShort    string[7] - abbreviated names of the days from Sunday (optional)
	                     dayNames         string[7] - names of the days from Sunday (optional)
	                     monthNamesShort  string[12] - abbreviated names of the months (optional)
	                     monthNames       string[12] - names of the months (optional)
	   @return  Date - the extracted date value or null if value is blank */
	parseDate: function (format, value, settings) {
		if (format == null || value == null)
			throw 'Invalid arguments';
		value = (typeof value == 'object' ? value.toString() : value + '');
		if (value == '')
			return null;
		var shortYearCutoff = (settings ? settings.shortYearCutoff : null) || this._defaults.shortYearCutoff;
		var dayNamesShort = (settings ? settings.dayNamesShort : null) || this._defaults.dayNamesShort;
		var dayNames = (settings ? settings.dayNames : null) || this._defaults.dayNames;
		var monthNamesShort = (settings ? settings.monthNamesShort : null) || this._defaults.monthNamesShort;
		var monthNames = (settings ? settings.monthNames : null) || this._defaults.monthNames;
		var year = -1;
		var month = -1;
		var day = -1;
		var doy = -1;
		var literal = false;
		// Check whether a format character is doubled
		var lookAhead = function(match) {
			var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) == match);
			if (matches)
				iFormat++;
			return matches;
		};
		// Extract a number from the string value
		var getNumber = function(match) {
			lookAhead(match);
			var origSize = (match == '@' ? 14 : (match == 'y' ? 4 : (match == 'o' ? 3 : 2)));
			var size = origSize;
			var num = 0;
			while (size > 0 && iValue < value.length &&
					value.charAt(iValue) >= '0' && value.charAt(iValue) <= '9') {
				num = num * 10 + parseInt(value.charAt(iValue++),10);
				size--;
			}
			if (size == origSize)
				throw 'Missing number at position ' + iValue;
			return num;
		};
		// Extract a name from the string value and convert to an index
		var getName = function(match, shortNames, longNames) {
			var names = (lookAhead(match) ? longNames : shortNames);
			var size = 0;
			for (var j = 0; j < names.length; j++)
				size = Math.max(size, names[j].length);
			var name = '';
			var iInit = iValue;
			while (size > 0 && iValue < value.length) {
				name += value.charAt(iValue++);
				for (var i = 0; i < names.length; i++)
					if (name == names[i])
						return i + 1;
				size--;
			}
			throw 'Unknown name at position ' + iInit;
		};
		// Confirm that a literal character matches the string value
		var checkLiteral = function() {
			if (value.charAt(iValue) != format.charAt(iFormat))
				throw 'Unexpected literal at position ' + iValue;
			iValue++;
		};
		var iValue = 0;
		for (var iFormat = 0; iFormat < format.length; iFormat++) {
			if (literal)
				if (format.charAt(iFormat) == "'" && !lookAhead("'"))
					literal = false;
				else
					checkLiteral();
			else
				switch (format.charAt(iFormat)) {
					case 'd':
						day = getNumber('d');
						break;
					case 'D':
						getName('D', dayNamesShort, dayNames);
						break;
					case 'o':
						doy = getNumber('o');
						break;
					case 'm':
						month = getNumber('m');
						break;
					case 'M':
						month = getName('M', monthNamesShort, monthNames);
						break;
					case 'y':
						year = getNumber('y');
						break;
					case '@':
						var date = new Date(getNumber('@'));
						year = date.getFullYear();
						month = date.getMonth() + 1;
						day = date.getDate();
						break;
					case "'":
						if (lookAhead("'"))
							checkLiteral();
						else
							literal = true;
						break;
					default:
						checkLiteral();
				}
		}
		if (year == -1)
			year = new Date().getFullYear();
		else if (year < 100)
			year += new Date().getFullYear() - new Date().getFullYear() % 100 +
				(year <= shortYearCutoff ? 0 : -100);
		if (doy > -1) {
			month = 1;
			day = doy;
			do {
				var dim = this._getDaysInMonth(year, month - 1);
				if (day <= dim)
					break;
				month++;
				day -= dim;
			} while (true);
		}
		var date = this._daylightSavingAdjust(new Date(year, month - 1, day));
		if (date.getFullYear() != year || date.getMonth() + 1 != month || date.getDate() != day)
			throw 'Invalid date'; // E.g. 31/02/*
		return date;
	},

	/* Standard date formats. */
	ATOM: 'yy-mm-dd', // RFC 3339 (ISO 8601)
	COOKIE: 'D, dd M yy',
	ISO_8601: 'yy-mm-dd',
	RFC_822: 'D, d M y',
	RFC_850: 'DD, dd-M-y',
	RFC_1036: 'D, d M y',
	RFC_1123: 'D, d M yy',
	RFC_2822: 'D, d M yy',
	RSS: 'D, d M y', // RFC 822
	TIMESTAMP: '@',
	W3C: 'yy-mm-dd', // ISO 8601

	/* Format a date object into a string value.
	   The format can be combinations of the following:
	   d  - day of month (no leading zero)
	   dd - day of month (two digit)
	   o  - day of year (no leading zeros)
	   oo - day of year (three digit)
	   D  - day name short
	   DD - day name long
	   m  - month of year (no leading zero)
	   mm - month of year (two digit)
	   M  - month name short
	   MM - month name long
	   y  - year (two digit)
	   yy - year (four digit)
	   @ - Unix timestamp (ms since 01/01/1970)
	   '...' - literal text
	   '' - single quote

	   @param  format    string - the desired format of the date
	   @param  date      Date - the date value to format
	   @param  settings  Object - attributes include:
	                     dayNamesShort    string[7] - abbreviated names of the days from Sunday (optional)
	                     dayNames         string[7] - names of the days from Sunday (optional)
	                     monthNamesShort  string[12] - abbreviated names of the months (optional)
	                     monthNames       string[12] - names of the months (optional)
	   @return  string - the date in the above format */
	formatDate: function (format, date, settings) {
		if (!date)
			return '';
		var dayNamesShort = (settings ? settings.dayNamesShort : null) || this._defaults.dayNamesShort;
		var dayNames = (settings ? settings.dayNames : null) || this._defaults.dayNames;
		var monthNamesShort = (settings ? settings.monthNamesShort : null) || this._defaults.monthNamesShort;
		var monthNames = (settings ? settings.monthNames : null) || this._defaults.monthNames;
		// Check whether a format character is doubled
		var lookAhead = function(match) {
			var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) == match);
			if (matches)
				iFormat++;
			return matches;
		};
		// Format a number, with leading zero if necessary
		var formatNumber = function(match, value, len) {
			var num = '' + value;
			if (lookAhead(match))
				while (num.length < len)
					num = '0' + num;
			return num;
		};
		// Format a name, short or long as requested
		var formatName = function(match, value, shortNames, longNames) {
			return (lookAhead(match) ? longNames[value] : shortNames[value]);
		};
		var output = '';
		var literal = false;
		if (date)
			for (var iFormat = 0; iFormat < format.length; iFormat++) {
				if (literal)
					if (format.charAt(iFormat) == "'" && !lookAhead("'"))
						literal = false;
					else
						output += format.charAt(iFormat);
				else
					switch (format.charAt(iFormat)) {
						case 'd':
							output += formatNumber('d', date.getDate(), 2);
							break;
						case 'D':
							output += formatName('D', date.getDay(), dayNamesShort, dayNames);
							break;
						case 'o':
							var doy = date.getDate();
							for (var m = date.getMonth() - 1; m >= 0; m--)
								doy += this._getDaysInMonth(date.getFullYear(), m);
							output += formatNumber('o', doy, 3);
							break;
						case 'm':
							output += formatNumber('m', date.getMonth() + 1, 2);
							break;
						case 'M':
							output += formatName('M', date.getMonth(), monthNamesShort, monthNames);
							break;
						case 'y':
							output += (lookAhead('y') ? date.getFullYear() :
								(date.getYear() % 100 < 10 ? '0' : '') + date.getYear() % 100);
							break;
						case '@':
							output += date.getTime();
							break;
						case "'":
							if (lookAhead("'"))
								output += "'";
							else
								literal = true;
							break;
						default:
							output += format.charAt(iFormat);
					}
			}
		return output;
	},

	/* Extract all possible characters from the date format. */
	_possibleChars: function (format) {
		var chars = '';
		var literal = false;
		for (var iFormat = 0; iFormat < format.length; iFormat++)
			if (literal)
				if (format.charAt(iFormat) == "'" && !lookAhead("'"))
					literal = false;
				else
					chars += format.charAt(iFormat);
			else
				switch (format.charAt(iFormat)) {
					case 'd': case 'm': case 'y': case '@':
						chars += '0123456789';
						break;
					case 'D': case 'M':
						return null; // Accept anything
					case "'":
						if (lookAhead("'"))
							chars += "'";
						else
							literal = true;
						break;
					default:
						chars += format.charAt(iFormat);
				}
		return chars;
	},

	/* Get a setting value, defaulting if necessary. */
	_get: function(inst, name) {
		return inst.settings[name] !== undefined ?
			inst.settings[name] : this._defaults[name];
	},

	/* Parse existing date and initialise date picker. */
	_setDateFromField: function(inst) {
		var dateFormat = this._get(inst, 'dateFormat');
		var dates = inst.input ? inst.input.val() : null;
		inst.endDay = inst.endMonth = inst.endYear = null;
		var date = defaultDate = this._getDefaultDate(inst);
		var settings = this._getFormatConfig(inst);
		try {
			date = this.parseDate(dateFormat, dates, settings) || defaultDate;
		} catch (event) {
			this.log(event);
			date = defaultDate;
		}
		inst.selectedDay = date.getDate();
		inst.drawMonth = inst.selectedMonth = date.getMonth();
		inst.drawYear = inst.selectedYear = date.getFullYear();
		inst.currentDay = (dates ? date.getDate() : 0);
		inst.currentMonth = (dates ? date.getMonth() : 0);
		inst.currentYear = (dates ? date.getFullYear() : 0);
		this._adjustInstDate(inst);
	},

	/* Retrieve the default date shown on opening. */
	_getDefaultDate: function(inst) {
		var date = this._determineDate(this._get(inst, 'defaultDate'), new Date());
		var minDate = this._getMinMaxDate(inst, 'min', true);
		var maxDate = this._getMinMaxDate(inst, 'max');
		date = (minDate && date < minDate ? minDate : date);
		date = (maxDate && date > maxDate ? maxDate : date);
		return date;
	},

	/* A date may be specified as an exact value or a relative one. */
	_determineDate: function(date, defaultDate) {
		var offsetNumeric = function(offset) {
			var date = new Date();
			date.setDate(date.getDate() + offset);
			return date;
		};
		var offsetString = function(offset, getDaysInMonth) {
			var date = new Date();
			var year = date.getFullYear();
			var month = date.getMonth();
			var day = date.getDate();
			var pattern = /([+-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g;
			var matches = pattern.exec(offset);
			while (matches) {
				switch (matches[2] || 'd') {
					case 'd' : case 'D' :
						day += parseInt(matches[1],10); break;
					case 'w' : case 'W' :
						day += parseInt(matches[1],10) * 7; break;
					case 'm' : case 'M' :
						month += parseInt(matches[1],10);
						day = Math.min(day, getDaysInMonth(year, month));
						break;
					case 'y': case 'Y' :
						year += parseInt(matches[1],10);
						day = Math.min(day, getDaysInMonth(year, month));
						break;
				}
				matches = pattern.exec(offset);
			}
			return new Date(year, month, day);
		};
		date = (date == null ? defaultDate :
			(typeof date == 'string' ? offsetString(date, this._getDaysInMonth) :
			(typeof date == 'number' ? (isNaN(date) ? defaultDate : offsetNumeric(date)) : date)));
		date = (date && date.toString() == 'Invalid Date' ? defaultDate : date);
		if (date) {
			date.setHours(0);
			date.setMinutes(0);
			date.setSeconds(0);
			date.setMilliseconds(0);
		}
		return this._daylightSavingAdjust(date);
	},

	/* Handle switch to/from daylight saving.
	   Hours may be non-zero on daylight saving cut-over:
	   > 12 when midnight changeover, but then cannot generate
	   midnight datetime, so jump to 1AM, otherwise reset.
	   @param  date  (Date) the date to check
	   @return  (Date) the corrected date */
	_daylightSavingAdjust: function(date) {
		if (!date) return null;
		date.setHours(date.getHours() > 12 ? date.getHours() + 2 : 0);
		return date;
	},

	/* Set the date(s) directly. */
	_setDate: function(inst, date, endDate) {
		var clear = !(date);
		var origMonth = inst.selectedMonth;
		var origYear = inst.selectedYear;
		date = this._determineDate(date, new Date());
		inst.selectedDay = inst.currentDay = date.getDate();
		inst.drawMonth = inst.selectedMonth = inst.currentMonth = date.getMonth();
		inst.drawYear = inst.selectedYear = inst.currentYear = date.getFullYear();
		if (origMonth != inst.selectedMonth || origYear != inst.selectedYear)
			this._notifyChange(inst);
		this._adjustInstDate(inst);
		if (inst.input) {
			inst.input.val(clear ? '' : this._formatDate(inst));
		}
	},

	/* Retrieve the date(s) directly. */
	_getDate: function(inst) {
		var startDate = (!inst.currentYear || (inst.input && inst.input.val() == '') ? null :
			this._daylightSavingAdjust(new Date(
			inst.currentYear, inst.currentMonth, inst.currentDay)));
			return startDate;
	},

	/* Generate the HTML for the current state of the date picker. */
	_generateHTML: function(inst) {
		var today = new Date();
		today = this._daylightSavingAdjust(
			new Date(today.getFullYear(), today.getMonth(), today.getDate())); // clear time
		var isRTL = this._get(inst, 'isRTL');
		var showButtonPanel = this._get(inst, 'showButtonPanel');
		var hideIfNoPrevNext = this._get(inst, 'hideIfNoPrevNext');
		var navigationAsDateFormat = this._get(inst, 'navigationAsDateFormat');
		var numMonths = this._getNumberOfMonths(inst);
		var showCurrentAtPos = this._get(inst, 'showCurrentAtPos');
		var stepMonths = this._get(inst, 'stepMonths');
		var stepBigMonths = this._get(inst, 'stepBigMonths');
		var isMultiMonth = (numMonths[0] != 1 || numMonths[1] != 1);
		var currentDate = this._daylightSavingAdjust((!inst.currentDay ? new Date(9999, 9, 9) :
			new Date(inst.currentYear, inst.currentMonth, inst.currentDay)));
		var minDate = this._getMinMaxDate(inst, 'min', true);
		var maxDate = this._getMinMaxDate(inst, 'max');
		var drawMonth = inst.drawMonth - showCurrentAtPos;
		var drawYear = inst.drawYear;
		if (drawMonth < 0) {
			drawMonth += 12;
			drawYear--;
		}
		if (maxDate) {
			var maxDraw = this._daylightSavingAdjust(new Date(maxDate.getFullYear(),
				maxDate.getMonth() - numMonths[1] + 1, maxDate.getDate()));
			maxDraw = (minDate && maxDraw < minDate ? minDate : maxDraw);
			while (this._daylightSavingAdjust(new Date(drawYear, drawMonth, 1)) > maxDraw) {
				drawMonth--;
				if (drawMonth < 0) {
					drawMonth = 11;
					drawYear--;
				}
			}
		}
		inst.drawMonth = drawMonth;
		inst.drawYear = drawYear;
		var prevText = this._get(inst, 'prevText');
		prevText = (!navigationAsDateFormat ? prevText : this.formatDate(prevText,
			this._daylightSavingAdjust(new Date(drawYear, drawMonth - stepMonths, 1)),
			this._getFormatConfig(inst)));
		var prev = (this._canAdjustMonth(inst, -1, drawYear, drawMonth) ?
			'<a class="ui-datepicker-prev ui-corner-all" onclick="DP_jQuery.datepicker._adjustDate(\'#' + inst.id + '\', -' + stepMonths + ', \'M\');"' +
			' title="' + prevText + '"><span class="ui-icon ui-icon-circle-triangle-' + ( isRTL ? 'e' : 'w') + '">' + prevText + '</span></a>' :
			(hideIfNoPrevNext ? '' : '<a class="ui-datepicker-prev ui-corner-all ui-state-disabled" title="'+ prevText +'"><span class="ui-icon ui-icon-circle-triangle-' + ( isRTL ? 'e' : 'w') + '">' + prevText + '</span></a>'));
		var nextText = this._get(inst, 'nextText');
		nextText = (!navigationAsDateFormat ? nextText : this.formatDate(nextText,
			this._daylightSavingAdjust(new Date(drawYear, drawMonth + stepMonths, 1)),
			this._getFormatConfig(inst)));
		var next = (this._canAdjustMonth(inst, +1, drawYear, drawMonth) ?
			'<a class="ui-datepicker-next ui-corner-all" onclick="DP_jQuery.datepicker._adjustDate(\'#' + inst.id + '\', +' + stepMonths + ', \'M\');"' +
			' title="' + nextText + '"><span class="ui-icon ui-icon-circle-triangle-' + ( isRTL ? 'w' : 'e') + '">' + nextText + '</span></a>' :
			(hideIfNoPrevNext ? '' : '<a class="ui-datepicker-next ui-corner-all ui-state-disabled" title="'+ nextText + '"><span class="ui-icon ui-icon-circle-triangle-' + ( isRTL ? 'w' : 'e') + '">' + nextText + '</span></a>'));
		var currentText = this._get(inst, 'currentText');
		var gotoDate = (this._get(inst, 'gotoCurrent') && inst.currentDay ? currentDate : today);
		currentText = (!navigationAsDateFormat ? currentText :
			this.formatDate(currentText, gotoDate, this._getFormatConfig(inst)));
		var controls = (!inst.inline ? '<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" onclick="DP_jQuery.datepicker._hideDatepicker();">' + this._get(inst, 'closeText') + '</button>' : '');
		var buttonPanel = (showButtonPanel) ? '<div class="ui-datepicker-buttonpane ui-widget-content">' + (isRTL ? controls : '') +
			(this._isInRange(inst, gotoDate) ? '<button type="button" class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" onclick="DP_jQuery.datepicker._gotoToday(\'#' + inst.id + '\');"' +
			'>' + currentText + '</button>' : '') + (isRTL ? '' : controls) + '</div>' : '';
		var firstDay = parseInt(this._get(inst, 'firstDay'),10);
		firstDay = (isNaN(firstDay) ? 0 : firstDay);
		var dayNames = this._get(inst, 'dayNames');
		var dayNamesShort = this._get(inst, 'dayNamesShort');
		var dayNamesMin = this._get(inst, 'dayNamesMin');
		var monthNames = this._get(inst, 'monthNames');
		var monthNamesShort = this._get(inst, 'monthNamesShort');
		var beforeShowDay = this._get(inst, 'beforeShowDay');
		var showOtherMonths = this._get(inst, 'showOtherMonths');
		var calculateWeek = this._get(inst, 'calculateWeek') || this.iso8601Week;
		var endDate = inst.endDay ? this._daylightSavingAdjust(
			new Date(inst.endYear, inst.endMonth, inst.endDay)) : currentDate;
		var defaultDate = this._getDefaultDate(inst);
		var html = '';
		for (var row = 0; row < numMonths[0]; row++) {
			var group = '';
			for (var col = 0; col < numMonths[1]; col++) {
				var selectedDate = this._daylightSavingAdjust(new Date(drawYear, drawMonth, inst.selectedDay));
				var cornerClass = ' ui-corner-all';
				var calender = '';
				if (isMultiMonth) {
					calender += '<div class="ui-datepicker-group ui-datepicker-group-';
					switch (col) {
						case 0: calender += 'first'; cornerClass = ' ui-corner-' + (isRTL ? 'right' : 'left'); break;
						case numMonths[1]-1: calender += 'last'; cornerClass = ' ui-corner-' + (isRTL ? 'left' : 'right'); break;
						default: calender += 'middle'; cornerClass = ''; break;
					}
					calender += '">';
				}
				calender += '<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix' + cornerClass + '">' +
					(/all|left/.test(cornerClass) && row == 0 ? (isRTL ? next : prev) : '') +
					(/all|right/.test(cornerClass) && row == 0 ? (isRTL ? prev : next) : '') +
					this._generateMonthYearHeader(inst, drawMonth, drawYear, minDate, maxDate,
					selectedDate, row > 0 || col > 0, monthNames, monthNamesShort) + // draw month headers
					'</div><table class="ui-datepicker-calendar"><thead>' +
					'<tr>';
				var thead = '';
				for (var dow = 0; dow < 7; dow++) { // days of the week
					var day = (dow + firstDay) % 7;
					thead += '<th' + ((dow + firstDay + 6) % 7 >= 5 ? ' class="ui-datepicker-week-end"' : '') + '>' +
						'<span title="' + dayNames[day] + '">' + dayNamesMin[day] + '</span></th>';
				}
				calender += thead + '</tr></thead><tbody>';
				var daysInMonth = this._getDaysInMonth(drawYear, drawMonth);
				if (drawYear == inst.selectedYear && drawMonth == inst.selectedMonth)
					inst.selectedDay = Math.min(inst.selectedDay, daysInMonth);
				var leadDays = (this._getFirstDayOfMonth(drawYear, drawMonth) - firstDay + 7) % 7;
				var numRows = (isMultiMonth ? 6 : Math.ceil((leadDays + daysInMonth) / 7)); // calculate the number of rows to generate
				var printDate = this._daylightSavingAdjust(new Date(drawYear, drawMonth, 1 - leadDays));
				for (var dRow = 0; dRow < numRows; dRow++) { // create date picker rows
					calender += '<tr>';
					var tbody = '';
					for (var dow = 0; dow < 7; dow++) { // create date picker days
						var daySettings = (beforeShowDay ?
							beforeShowDay.apply((inst.input ? inst.input[0] : null), [printDate]) : [true, '']);
						var otherMonth = (printDate.getMonth() != drawMonth);
						var unselectable = otherMonth || !daySettings[0] ||
							(minDate && printDate < minDate) || (maxDate && printDate > maxDate);
						tbody += '<td class="' +
							((dow + firstDay + 6) % 7 >= 5 ? ' ui-datepicker-week-end' : '') + // highlight weekends
							(otherMonth ? ' ui-datepicker-other-month' : '') + // highlight days from other months
							((printDate.getTime() == selectedDate.getTime() && drawMonth == inst.selectedMonth && inst._keyEvent) || // user pressed key
							(defaultDate.getTime() == printDate.getTime() && defaultDate.getTime() == selectedDate.getTime()) ?
							// or defaultDate is current printedDate and defaultDate is selectedDate
							' ' + this._dayOverClass : '') + // highlight selected day
							(unselectable ? ' ' + this._unselectableClass + ' ui-state-disabled': '') +  // highlight unselectable days
							(otherMonth && !showOtherMonths ? '' : ' ' + daySettings[1] + // highlight custom dates
							(printDate.getTime() >= currentDate.getTime() && printDate.getTime() <= endDate.getTime() ? // in current range
							' ' + this._currentClass : '') + // highlight selected day
							(printDate.getTime() == today.getTime() ? ' ui-datepicker-today' : '')) + '"' + // highlight today (if different)
							((!otherMonth || showOtherMonths) && daySettings[2] ? ' title="' + daySettings[2] + '"' : '') + // cell title
							(unselectable ? '' : ' onclick="DP_jQuery.datepicker._selectDay(\'#' +
							inst.id + '\',' + drawMonth + ',' + drawYear + ', this);return false;"') + '>' + // actions
							(otherMonth ? (showOtherMonths ? printDate.getDate() : '&#xa0;') : // display for other months
							(unselectable ? '<span class="ui-state-default">' + printDate.getDate() + '</span>' : '<a class="ui-state-default' +
							(printDate.getTime() == today.getTime() ? ' ui-state-highlight' : '') +
							(printDate.getTime() >= currentDate.getTime() && printDate.getTime() <= endDate.getTime() ? // in current range
							' ui-state-active' : '') + // highlight selected day
							'" href="#">' + printDate.getDate() + '</a>')) + '</td>'; // display for this month
						printDate.setDate(printDate.getDate() + 1);
						printDate = this._daylightSavingAdjust(printDate);
					}
					calender += tbody + '</tr>';
				}
				drawMonth++;
				if (drawMonth > 11) {
					drawMonth = 0;
					drawYear++;
				}
				calender += '</tbody></table>' + (isMultiMonth ? '</div>' + 
							((numMonths[0] > 0 && col == numMonths[1]-1) ? '<div class="ui-datepicker-row-break"></div>' : '') : '');
				group += calender;
			}
			html += group;
		}
		html += buttonPanel + ($.browser.msie && parseInt($.browser.version,10) < 7 && !inst.inline ?
			'<iframe src="javascript:false;" class="ui-datepicker-cover" frameborder="0"></iframe>' : '');
		inst._keyEvent = false;
		return html;
	},

	/* Generate the month and year header. */
	_generateMonthYearHeader: function(inst, drawMonth, drawYear, minDate, maxDate,
			selectedDate, secondary, monthNames, monthNamesShort) {
		minDate = (inst.rangeStart && minDate && selectedDate < minDate ? selectedDate : minDate);
		var changeMonth = this._get(inst, 'changeMonth');
		var changeYear = this._get(inst, 'changeYear');
		var showMonthAfterYear = this._get(inst, 'showMonthAfterYear');
		var html = '<div class="ui-datepicker-title">';
		var monthHtml = '';
		// month selection
		if (secondary || !changeMonth)
			monthHtml += '<span class="ui-datepicker-month">' + monthNames[drawMonth] + '</span> ';
		else {
			var inMinYear = (minDate && minDate.getFullYear() == drawYear);
			var inMaxYear = (maxDate && maxDate.getFullYear() == drawYear);
			monthHtml += '<select class="ui-datepicker-month" ' +
				'onchange="DP_jQuery.datepicker._selectMonthYear(\'#' + inst.id + '\', this, \'M\');" ' +
				'onclick="DP_jQuery.datepicker._clickMonthYear(\'#' + inst.id + '\');"' +
			 	'>';
			for (var month = 0; month < 12; month++) {
				if ((!inMinYear || month >= minDate.getMonth()) &&
						(!inMaxYear || month <= maxDate.getMonth()))
					monthHtml += '<option value="' + month + '"' +
						(month == drawMonth ? ' selected="selected"' : '') +
						'>' + monthNamesShort[month] + '</option>';
			}
			monthHtml += '</select>';
		}
		if (!showMonthAfterYear)
			html += monthHtml + ((secondary || changeMonth || changeYear) && (!(changeMonth && changeYear)) ? '&#xa0;' : '');
		// year selection
		if (secondary || !changeYear)
			html += '<span class="ui-datepicker-year">' + drawYear + '</span>';
		else {
			// determine range of years to display
			var years = this._get(inst, 'yearRange').split(':');
			var year = 0;
			var endYear = 0;
			if (years.length != 2) {
				year = drawYear - 10;
				endYear = drawYear + 10;
			} else if (years[0].charAt(0) == '+' || years[0].charAt(0) == '-') {
				year = drawYear + parseInt(years[0], 10);
				endYear = drawYear + parseInt(years[1], 10);
			} else {
				year = parseInt(years[0], 10);
				endYear = parseInt(years[1], 10);
			}
			year = (minDate ? Math.max(year, minDate.getFullYear()) : year);
			endYear = (maxDate ? Math.min(endYear, maxDate.getFullYear()) : endYear);
			html += '<select class="ui-datepicker-year" ' +
				'onchange="DP_jQuery.datepicker._selectMonthYear(\'#' + inst.id + '\', this, \'Y\');" ' +
				'onclick="DP_jQuery.datepicker._clickMonthYear(\'#' + inst.id + '\');"' +
				'>';
			for (; year <= endYear; year++) {
				html += '<option value="' + year + '"' +
					(year == drawYear ? ' selected="selected"' : '') +
					'>' + year + '</option>';
			}
			html += '</select>';
		}
		if (showMonthAfterYear)
			html += (secondary || changeMonth || changeYear ? '&#xa0;' : '') + monthHtml;
		html += '</div>'; // Close datepicker_header
		return html;
	},

	/* Adjust one of the date sub-fields. */
	_adjustInstDate: function(inst, offset, period) {
		var year = inst.drawYear + (period == 'Y' ? offset : 0);
		var month = inst.drawMonth + (period == 'M' ? offset : 0);
		var day = Math.min(inst.selectedDay, this._getDaysInMonth(year, month)) +
			(period == 'D' ? offset : 0);
		var date = this._daylightSavingAdjust(new Date(year, month, day));
		// ensure it is within the bounds set
		var minDate = this._getMinMaxDate(inst, 'min', true);
		var maxDate = this._getMinMaxDate(inst, 'max');
		date = (minDate && date < minDate ? minDate : date);
		date = (maxDate && date > maxDate ? maxDate : date);
		inst.selectedDay = date.getDate();
		inst.drawMonth = inst.selectedMonth = date.getMonth();
		inst.drawYear = inst.selectedYear = date.getFullYear();
		if (period == 'M' || period == 'Y')
			this._notifyChange(inst);
	},

	/* Notify change of month/year. */
	_notifyChange: function(inst) {
		var onChange = this._get(inst, 'onChangeMonthYear');
		if (onChange)
			onChange.apply((inst.input ? inst.input[0] : null),
				[inst.selectedYear, inst.selectedMonth + 1, inst]);
	},

	/* Determine the number of months to show. */
	_getNumberOfMonths: function(inst) {
		var numMonths = this._get(inst, 'numberOfMonths');
		return (numMonths == null ? [1, 1] : (typeof numMonths == 'number' ? [1, numMonths] : numMonths));
	},

	/* Determine the current maximum date - ensure no time components are set - may be overridden for a range. */
	_getMinMaxDate: function(inst, minMax, checkRange) {
		var date = this._determineDate(this._get(inst, minMax + 'Date'), null);
		return (!checkRange || !inst.rangeStart ? date :
			(!date || inst.rangeStart > date ? inst.rangeStart : date));
	},

	/* Find the number of days in a given month. */
	_getDaysInMonth: function(year, month) {
		return 32 - new Date(year, month, 32).getDate();
	},

	/* Find the day of the week of the first of a month. */
	_getFirstDayOfMonth: function(year, month) {
		return new Date(year, month, 1).getDay();
	},

	/* Determines if we should allow a "next/prev" month display change. */
	_canAdjustMonth: function(inst, offset, curYear, curMonth) {
		var numMonths = this._getNumberOfMonths(inst);
		var date = this._daylightSavingAdjust(new Date(
			curYear, curMonth + (offset < 0 ? offset : numMonths[1]), 1));
		if (offset < 0)
			date.setDate(this._getDaysInMonth(date.getFullYear(), date.getMonth()));
		return this._isInRange(inst, date);
	},

	/* Is the given date in the accepted range? */
	_isInRange: function(inst, date) {
		// during range selection, use minimum of selected date and range start
		var newMinDate = (!inst.rangeStart ? null : this._daylightSavingAdjust(
			new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay)));
		newMinDate = (newMinDate && inst.rangeStart < newMinDate ? inst.rangeStart : newMinDate);
		var minDate = newMinDate || this._getMinMaxDate(inst, 'min');
		var maxDate = this._getMinMaxDate(inst, 'max');
		return ((!minDate || date >= minDate) && (!maxDate || date <= maxDate));
	},

	/* Provide the configuration settings for formatting/parsing. */
	_getFormatConfig: function(inst) {
		var shortYearCutoff = this._get(inst, 'shortYearCutoff');
		shortYearCutoff = (typeof shortYearCutoff != 'string' ? shortYearCutoff :
			new Date().getFullYear() % 100 + parseInt(shortYearCutoff, 10));
		return {shortYearCutoff: shortYearCutoff,
			dayNamesShort: this._get(inst, 'dayNamesShort'), dayNames: this._get(inst, 'dayNames'),
			monthNamesShort: this._get(inst, 'monthNamesShort'), monthNames: this._get(inst, 'monthNames')};
	},

	/* Format the given date for display. */
	_formatDate: function(inst, day, month, year) {
		if (!day) {
			inst.currentDay = inst.selectedDay;
			inst.currentMonth = inst.selectedMonth;
			inst.currentYear = inst.selectedYear;
		}
		var date = (day ? (typeof day == 'object' ? day :
			this._daylightSavingAdjust(new Date(year, month, day))) :
			this._daylightSavingAdjust(new Date(inst.currentYear, inst.currentMonth, inst.currentDay)));
		return this.formatDate(this._get(inst, 'dateFormat'), date, this._getFormatConfig(inst));
	}
});

/* jQuery extend now ignores nulls! */
function extendRemove(target, props) {
	$.extend(target, props);
	for (var name in props)
		if (props[name] == null || props[name] == undefined)
			target[name] = props[name];
	return target;
};

/* Determine whether an object is an array. */
function isArray(a) {
	return (a && (($.browser.safari && typeof a == 'object' && a.length) ||
		(a.constructor && a.constructor.toString().match(/\Array\(\)/))));
};

/* Invoke the datepicker functionality.
   @param  options  string - a command, optionally followed by additional parameters or
                    Object - settings for attaching new datepicker functionality
   @return  jQuery object */
$.fn.datepicker = function(options){

	/* Initialise the date picker. */
	if (!$.datepicker.initialized) {
		$(document).mousedown($.datepicker._checkExternalClick).
			find('body').append($.datepicker.dpDiv);
		$.datepicker.initialized = true;
	}

	var otherArgs = Array.prototype.slice.call(arguments, 1);
	if (typeof options == 'string' && (options == 'isDisabled' || options == 'getDate'))
		return $.datepicker['_' + options + 'Datepicker'].
			apply($.datepicker, [this[0]].concat(otherArgs));
	return this.each(function() {
		typeof options == 'string' ?
			$.datepicker['_' + options + 'Datepicker'].
				apply($.datepicker, [this].concat(otherArgs)) :
			$.datepicker._attachDatepicker(this, options);
	});
};

$.datepicker = new Datepicker(); // singleton instance
$.datepicker.initialized = false;
$.datepicker.uuid = new Date().getTime();
$.datepicker.version = "1.7.1";

// Workaround for #4055
// Add another global to avoid noConflict issues with inline event handlers
window.DP_jQuery = $;

})(jQuery);
/*
 * jQuery UI Dialog 1.7.1
 *
 * Copyright (c) 2009 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Dialog
 *
 * Depends:
 *	ui.core.js
 *	ui.draggable.js
 *	ui.resizable.js
 */
(function($) {

var setDataSwitch = {
		dragStart	: "start.draggable",
		drag		: "drag.draggable",
		dragStop	: "stop.draggable",
		maxHeight	: "maxHeight.resizable",
		minHeight	: "minHeight.resizable",
		maxWidth	: "maxWidth.resizable",
		minWidth	: "minWidth.resizable",
		resizeStart	: "start.resizable",
		resize		: "drag.resizable",
		resizeStop	: "stop.resizable"
	},
	
	uiDialogClasses =
		'ui-dialog ' +
		'ui-widget ' +
		'ui-widget-content ' +
		'ui-corner-all ';

$.widget("ui.dialog", {

	_init: function() {
		this.originalTitle = this.element.attr('title');

		var self = this,
			options = this.options,

			title = options.title || this.originalTitle || '&nbsp;',
			titleId = $.ui.dialog.getTitleId(this.element),

			uiDialog = (this.uiDialog = $('<div/>'))
				.appendTo(document.body)
				.hide()
				.addClass(uiDialogClasses + options.dialogClass)
				.css({
					position: 'absolute',
					overflow: 'hidden',
					zIndex: options.zIndex
				})
				// setting tabIndex makes the div focusable
				// setting outline to 0 prevents a border on focus in Mozilla
				.attr('tabIndex', -1).css('outline', 0).keydown(function(event) {
					(options.closeOnEscape && event.keyCode
						&& event.keyCode == $.ui.keyCode.ESCAPE && self.close(event));
				})
				.attr({
					role: 'dialog',
					'aria-labelledby': titleId
				})
				.mousedown(function(event) {
					self.moveToTop(false, event);
				}),

			uiDialogContent = this.element
				.show()
				.removeAttr('title')
				.addClass(
					'ui-dialog-content ' +
					'ui-widget-content')
				.appendTo(uiDialog),

			uiDialogTitlebar = (this.uiDialogTitlebar = $('<div></div>'))
				.addClass(
					'ui-dialog-titlebar ' +
					'ui-widget-header ' +
					'ui-corner-all ' +
					'ui-helper-clearfix'
				)
				.prependTo(uiDialog),

			uiDialogTitlebarClose = $('<a href="#"/>')
				.addClass(
					'ui-dialog-titlebar-close ' +
					'ui-corner-all'
				)
				.attr('role', 'button')
				.hover(
					function() {
						uiDialogTitlebarClose.addClass('ui-state-hover');
					},
					function() {
						uiDialogTitlebarClose.removeClass('ui-state-hover');
					}
				)
				.focus(function() {
					uiDialogTitlebarClose.addClass('ui-state-focus');
				})
				.blur(function() {
					uiDialogTitlebarClose.removeClass('ui-state-focus');
				})
				.mousedown(function(ev) {
					ev.stopPropagation();
				})
				.click(function(event) {
					self.close(event);
					return false;
				})
				.appendTo(uiDialogTitlebar),

			uiDialogTitlebarCloseText = (this.uiDialogTitlebarCloseText = $('<span/>'))
				.addClass(
					'ui-icon ' +
					'ui-icon-closethick'
				)
				.text(options.closeText)
				.appendTo(uiDialogTitlebarClose),

			uiDialogTitle = $('<span/>')
				.addClass('ui-dialog-title')
				.attr('id', titleId)
				.html(title)
				.prependTo(uiDialogTitlebar);

		uiDialogTitlebar.find("*").add(uiDialogTitlebar).disableSelection();

		(options.draggable && $.fn.draggable && this._makeDraggable());
		(options.resizable && $.fn.resizable && this._makeResizable());

		this._createButtons(options.buttons);
		this._isOpen = false;

		(options.bgiframe && $.fn.bgiframe && uiDialog.bgiframe());
		(options.autoOpen && this.open());
		
	},

	destroy: function() {
		(this.overlay && this.overlay.destroy());
		this.uiDialog.hide();
		this.element
			.unbind('.dialog')
			.removeData('dialog')
			.removeClass('ui-dialog-content ui-widget-content')
			.hide().appendTo('body');
		this.uiDialog.remove();

		(this.originalTitle && this.element.attr('title', this.originalTitle));
	},

	close: function(event) {
		var self = this;
		
		if (false === self._trigger('beforeclose', event)) {
			return;
		}

		(self.overlay && self.overlay.destroy());
		self.uiDialog.unbind('keypress.ui-dialog');

		(self.options.hide
			? self.uiDialog.hide(self.options.hide, function() {
				self._trigger('close', event);
			})
			: self.uiDialog.hide() && self._trigger('close', event));

		$.ui.dialog.overlay.resize();

		self._isOpen = false;
	},

	isOpen: function() {
		return this._isOpen;
	},

	// the force parameter allows us to move modal dialogs to their correct
	// position on open
	moveToTop: function(force, event) {

		if ((this.options.modal && !force)
			|| (!this.options.stack && !this.options.modal)) {
			return this._trigger('focus', event);
		}
		
		if (this.options.zIndex > $.ui.dialog.maxZ) {
			$.ui.dialog.maxZ = this.options.zIndex;
		}
		(this.overlay && this.overlay.$el.css('z-index', $.ui.dialog.overlay.maxZ = ++$.ui.dialog.maxZ));

		//Save and then restore scroll since Opera 9.5+ resets when parent z-Index is changed.
		//  http://ui.jquery.com/bugs/ticket/3193
		var saveScroll = { scrollTop: this.element.attr('scrollTop'), scrollLeft: this.element.attr('scrollLeft') };
		this.uiDialog.css('z-index', ++$.ui.dialog.maxZ);
		this.element.attr(saveScroll);
		this._trigger('focus', event);
	},

	open: function() {
		if (this._isOpen) { return; }

		var options = this.options,
			uiDialog = this.uiDialog;

		this.overlay = options.modal ? new $.ui.dialog.overlay(this) : null;
		(uiDialog.next().length && uiDialog.appendTo('body'));
		this._size();
		this._position(options.position);
		uiDialog.show(options.show);
		this.moveToTop(true);

		// prevent tabbing out of modal dialogs
		(options.modal && uiDialog.bind('keypress.ui-dialog', function(event) {
			if (event.keyCode != $.ui.keyCode.TAB) {
				return;
			}

			var tabbables = $(':tabbable', this),
				first = tabbables.filter(':first')[0],
				last  = tabbables.filter(':last')[0];

			if (event.target == last && !event.shiftKey) {
				setTimeout(function() {
					first.focus();
				}, 1);
			} else if (event.target == first && event.shiftKey) {
				setTimeout(function() {
					last.focus();
				}, 1);
			}
		}));

		// set focus to the first tabbable element in the content area or the first button
		// if there are no tabbable elements, set focus on the dialog itself
		$([])
			.add(uiDialog.find('.ui-dialog-content :tabbable:first'))
			.add(uiDialog.find('.ui-dialog-buttonpane :tabbable:first'))
			.add(uiDialog)
			.filter(':first')
			.focus();

		this._trigger('open');
		this._isOpen = true;
	},

	_createButtons: function(buttons) {
		var self = this,
			hasButtons = false,
			uiDialogButtonPane = $('<div></div>')
				.addClass(
					'ui-dialog-buttonpane ' +
					'ui-widget-content ' +
					'ui-helper-clearfix'
				);

		// if we already have a button pane, remove it
		this.uiDialog.find('.ui-dialog-buttonpane').remove();

		(typeof buttons == 'object' && buttons !== null &&
			$.each(buttons, function() { return !(hasButtons = true); }));
		if (hasButtons) {
			$.each(buttons, function(name, fn) {
				$('<button type="button"></button>')
					.addClass(
						'ui-state-default ' +
						'ui-corner-all'
					)
					.text(name)
					.click(function() { fn.apply(self.element[0], arguments); })
					.hover(
						function() {
							$(this).addClass('ui-state-hover');
						},
						function() {
							$(this).removeClass('ui-state-hover');
						}
					)
					.focus(function() {
						$(this).addClass('ui-state-focus');
					})
					.blur(function() {
						$(this).removeClass('ui-state-focus');
					})
					.appendTo(uiDialogButtonPane);
			});
			uiDialogButtonPane.appendTo(this.uiDialog);
		}
	},

	_makeDraggable: function() {
		var self = this,
			options = this.options,
			heightBeforeDrag;

		this.uiDialog.draggable({
			cancel: '.ui-dialog-content',
			handle: '.ui-dialog-titlebar',
			containment: 'document',
			start: function() {
				heightBeforeDrag = options.height;
				$(this).height($(this).height()).addClass("ui-dialog-dragging");
				(options.dragStart && options.dragStart.apply(self.element[0], arguments));
			},
			drag: function() {
				(options.drag && options.drag.apply(self.element[0], arguments));
			},
			stop: function() {
				$(this).removeClass("ui-dialog-dragging").height(heightBeforeDrag);
				(options.dragStop && options.dragStop.apply(self.element[0], arguments));
				$.ui.dialog.overlay.resize();
			}
		});
	},

	_makeResizable: function(handles) {
		handles = (handles === undefined ? this.options.resizable : handles);
		var self = this,
			options = this.options,
			resizeHandles = typeof handles == 'string'
				? handles
				: 'n,e,s,w,se,sw,ne,nw';

		this.uiDialog.resizable({
			cancel: '.ui-dialog-content',
			alsoResize: this.element,
			maxWidth: options.maxWidth,
			maxHeight: options.maxHeight,
			minWidth: options.minWidth,
			minHeight: options.minHeight,
			start: function() {
				$(this).addClass("ui-dialog-resizing");
				(options.resizeStart && options.resizeStart.apply(self.element[0], arguments));
			},
			resize: function() {
				(options.resize && options.resize.apply(self.element[0], arguments));
			},
			handles: resizeHandles,
			stop: function() {
				$(this).removeClass("ui-dialog-resizing");
				options.height = $(this).height();
				options.width = $(this).width();
				(options.resizeStop && options.resizeStop.apply(self.element[0], arguments));
				$.ui.dialog.overlay.resize();
			}
		})
		.find('.ui-resizable-se').addClass('ui-icon ui-icon-grip-diagonal-se');
	},

	_position: function(pos) {
		var wnd = $(window), doc = $(document),
			pTop = doc.scrollTop(), pLeft = doc.scrollLeft(),
			minTop = pTop;

		if ($.inArray(pos, ['center','top','right','bottom','left']) >= 0) {
			pos = [
				pos == 'right' || pos == 'left' ? pos : 'center',
				pos == 'top' || pos == 'bottom' ? pos : 'middle'
			];
		}
		if (pos.constructor != Array) {
			pos = ['center', 'middle'];
		}
		if (pos[0].constructor == Number) {
			pLeft += pos[0];
		} else {
			switch (pos[0]) {
				case 'left':
					pLeft += 0;
					break;
				case 'right':
					pLeft += wnd.width() - this.uiDialog.outerWidth();
					break;
				default:
				case 'center':
					pLeft += (wnd.width() - this.uiDialog.outerWidth()) / 2;
			}
		}
		if (pos[1].constructor == Number) {
			pTop += pos[1];
		} else {
			switch (pos[1]) {
				case 'top':
					pTop += 0;
					break;
				case 'bottom':
					pTop += wnd.height() - this.uiDialog.outerHeight();
					break;
				default:
				case 'middle':
					pTop += (wnd.height() - this.uiDialog.outerHeight()) / 2;
			}
		}

		// prevent the dialog from being too high (make sure the titlebar
		// is accessible)
		pTop = Math.max(pTop, minTop);
		this.uiDialog.css({top: pTop, left: pLeft});
	},

	_setData: function(key, value){
		(setDataSwitch[key] && this.uiDialog.data(setDataSwitch[key], value));
		switch (key) {
			case "buttons":
				this._createButtons(value);
				break;
			case "closeText":
				this.uiDialogTitlebarCloseText.text(value);
				break;
			case "dialogClass":
				this.uiDialog
					.removeClass(this.options.dialogClass)
					.addClass(uiDialogClasses + value);
				break;
			case "draggable":
				(value
					? this._makeDraggable()
					: this.uiDialog.draggable('destroy'));
				break;
			case "height":
				this.uiDialog.height(value);
				break;
			case "position":
				this._position(value);
				break;
			case "resizable":
				var uiDialog = this.uiDialog,
					isResizable = this.uiDialog.is(':data(resizable)');

				// currently resizable, becoming non-resizable
				(isResizable && !value && uiDialog.resizable('destroy'));

				// currently resizable, changing handles
				(isResizable && typeof value == 'string' &&
					uiDialog.resizable('option', 'handles', value));

				// currently non-resizable, becoming resizable
				(isResizable || this._makeResizable(value));
				break;
			case "title":
				$(".ui-dialog-title", this.uiDialogTitlebar).html(value || '&nbsp;');
				break;
			case "width":
				this.uiDialog.width(value);
				break;
		}

		$.widget.prototype._setData.apply(this, arguments);
	},

	_size: function() {
		/* If the user has resized the dialog, the .ui-dialog and .ui-dialog-content
		 * divs will both have width and height set, so we need to reset them
		 */
		var options = this.options;

		// reset content sizing
		this.element.css({
			height: 0,
			minHeight: 0,
			width: 'auto'
		});

		// reset wrapper sizing
		// determine the height of all the non-content elements
		var nonContentHeight = this.uiDialog.css({
				height: 'auto',
				width: options.width
			})
			.height();

		this.element
			.css({
				minHeight: Math.max(options.minHeight - nonContentHeight, 0),
				height: options.height == 'auto'
					? 'auto'
					: Math.max(options.height - nonContentHeight, 0)
			});
	}
});

$.extend($.ui.dialog, {
	version: "1.7.1",
	defaults: {
		autoOpen: true,
		bgiframe: false,
		buttons: {},
		closeOnEscape: true,
		closeText: 'close',
		dialogClass: '',
		draggable: true,
		hide: null,
		height: 'auto',
		maxHeight: false,
		maxWidth: false,
		minHeight: 150,
		minWidth: 150,
		modal: false,
		position: 'center',
		resizable: true,
		show: null,
		stack: true,
		title: '',
		width: 300,
		zIndex: 1000
	},

	getter: 'isOpen',

	uuid: 0,
	maxZ: 0,

	getTitleId: function($el) {
		return 'ui-dialog-title-' + ($el.attr('id') || ++this.uuid);
	},

	overlay: function(dialog) {
		this.$el = $.ui.dialog.overlay.create(dialog);
	}
});

$.extend($.ui.dialog.overlay, {
	instances: [],
	maxZ: 0,
	events: $.map('focus,mousedown,mouseup,keydown,keypress,click'.split(','),
		function(event) { return event + '.dialog-overlay'; }).join(' '),
	create: function(dialog) {
		if (this.instances.length === 0) {
			// prevent use of anchors and inputs
			// we use a setTimeout in case the overlay is created from an
			// event that we're going to be cancelling (see #2804)
			setTimeout(function() {
				$(document).bind($.ui.dialog.overlay.events, function(event) {
					var dialogZ = $(event.target).parents('.ui-dialog').css('zIndex') || 0;
					return (dialogZ > $.ui.dialog.overlay.maxZ);
				});
			}, 1);

			// allow closing by pressing the escape key
			$(document).bind('keydown.dialog-overlay', function(event) {
				(dialog.options.closeOnEscape && event.keyCode
						&& event.keyCode == $.ui.keyCode.ESCAPE && dialog.close(event));
			});

			// handle window resize
			$(window).bind('resize.dialog-overlay', $.ui.dialog.overlay.resize);
		}

		var $el = $('<div></div>').appendTo(document.body)
			.addClass('ui-widget-overlay').css({
				width: this.width(),
				height: this.height()
			});

		(dialog.options.bgiframe && $.fn.bgiframe && $el.bgiframe());

		this.instances.push($el);
		return $el;
	},

	destroy: function($el) {
		this.instances.splice($.inArray(this.instances, $el), 1);

		if (this.instances.length === 0) {
			$([document, window]).unbind('.dialog-overlay');
		}

		$el.remove();
	},

	height: function() {
		// handle IE 6
		if ($.browser.msie && $.browser.version < 7) {
			var scrollHeight = Math.max(
				document.documentElement.scrollHeight,
				document.body.scrollHeight
			);
			var offsetHeight = Math.max(
				document.documentElement.offsetHeight,
				document.body.offsetHeight
			);

			if (scrollHeight < offsetHeight) {
				return $(window).height() + 'px';
			} else {
				return scrollHeight + 'px';
			}
		// handle "good" browsers
		} else {
			return $(document).height() + 'px';
		}
	},

	width: function() {
		// handle IE 6
		if ($.browser.msie && $.browser.version < 7) {
			var scrollWidth = Math.max(
				document.documentElement.scrollWidth,
				document.body.scrollWidth
			);
			var offsetWidth = Math.max(
				document.documentElement.offsetWidth,
				document.body.offsetWidth
			);

			if (scrollWidth < offsetWidth) {
				return $(window).width() + 'px';
			} else {
				return scrollWidth + 'px';
			}
		// handle "good" browsers
		} else {
			return $(document).width() + 'px';
		}
	},

	resize: function() {
		/* If the dialog is draggable and the user drags it past the
		 * right edge of the window, the document becomes wider so we
		 * need to stretch the overlay. If the user then drags the
		 * dialog back to the left, the document will become narrower,
		 * so we need to shrink the overlay to the appropriate size.
		 * This is handled by shrinking the overlay before setting it
		 * to the full document size.
		 */
		var $overlays = $([]);
		$.each($.ui.dialog.overlay.instances, function() {
			$overlays = $overlays.add(this);
		});

		$overlays.css({
			width: 0,
			height: 0
		}).css({
			width: $.ui.dialog.overlay.width(),
			height: $.ui.dialog.overlay.height()
		});
	}
});

$.extend($.ui.dialog.overlay.prototype, {
	destroy: function() {
		$.ui.dialog.overlay.destroy(this.$el);
	}
});

})(jQuery);
/*
 * jQuery UI Draggable 1.7.1
 *
 * Copyright (c) 2009 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Draggables
 *
 * Depends:
 *	ui.core.js
 */
(function($) {

$.widget("ui.draggable", $.extend({}, $.ui.mouse, {

	_init: function() {

		if (this.options.helper == 'original' && !(/^(?:r|a|f)/).test(this.element.css("position")))
			this.element[0].style.position = 'relative';

		(this.options.addClasses && this.element.addClass("ui-draggable"));
		(this.options.disabled && this.element.addClass("ui-draggable-disabled"));

		this._mouseInit();

	},

	destroy: function() {
		if(!this.element.data('draggable')) return;
		this.element
			.removeData("draggable")
			.unbind(".draggable")
			.removeClass("ui-draggable"
				+ " ui-draggable-dragging"
				+ " ui-draggable-disabled");
		this._mouseDestroy();
	},

	_mouseCapture: function(event) {

		var o = this.options;

		if (this.helper || o.disabled || $(event.target).is('.ui-resizable-handle'))
			return false;

		//Quit if we're not on a valid handle
		this.handle = this._getHandle(event);
		if (!this.handle)
			return false;

		return true;

	},

	_mouseStart: function(event) {

		var o = this.options;

		//Create and append the visible helper
		this.helper = this._createHelper(event);

		//Cache the helper size
		this._cacheHelperProportions();

		//If ddmanager is used for droppables, set the global draggable
		if($.ui.ddmanager)
			$.ui.ddmanager.current = this;

		/*
		 * - Position generation -
		 * This block generates everything position related - it's the core of draggables.
		 */

		//Cache the margins of the original element
		this._cacheMargins();

		//Store the helper's css position
		this.cssPosition = this.helper.css("position");
		this.scrollParent = this.helper.scrollParent();

		//The element's absolute position on the page minus margins
		this.offset = this.element.offset();
		this.offset = {
			top: this.offset.top - this.margins.top,
			left: this.offset.left - this.margins.left
		};

		$.extend(this.offset, {
			click: { //Where the click happened, relative to the element
				left: event.pageX - this.offset.left,
				top: event.pageY - this.offset.top
			},
			parent: this._getParentOffset(),
			relative: this._getRelativeOffset() //This is a relative to absolute position minus the actual position calculation - only used for relative positioned helper
		});

		//Generate the original position
		this.originalPosition = this._generatePosition(event);
		this.originalPageX = event.pageX;
		this.originalPageY = event.pageY;

		//Adjust the mouse offset relative to the helper if 'cursorAt' is supplied
		if(o.cursorAt)
			this._adjustOffsetFromHelper(o.cursorAt);

		//Set a containment if given in the options
		if(o.containment)
			this._setContainment();

		//Call plugins and callbacks
		this._trigger("start", event);

		//Recache the helper size
		this._cacheHelperProportions();

		//Prepare the droppable offsets
		if ($.ui.ddmanager && !o.dropBehaviour)
			$.ui.ddmanager.prepareOffsets(this, event);

		this.helper.addClass("ui-draggable-dragging");
		this._mouseDrag(event, true); //Execute the drag once - this causes the helper not to be visible before getting its correct position
		return true;
	},

	_mouseDrag: function(event, noPropagation) {

		//Compute the helpers position
		this.position = this._generatePosition(event);
		this.positionAbs = this._convertPositionTo("absolute");

		//Call plugins and callbacks and use the resulting position if something is returned
		if (!noPropagation) {
			var ui = this._uiHash();
			this._trigger('drag', event, ui);
			this.position = ui.position;
		}

		if(!this.options.axis || this.options.axis != "y") this.helper[0].style.left = this.position.left+'px';
		if(!this.options.axis || this.options.axis != "x") this.helper[0].style.top = this.position.top+'px';
		if($.ui.ddmanager) $.ui.ddmanager.drag(this, event);

		return false;
	},

	_mouseStop: function(event) {

		//If we are using droppables, inform the manager about the drop
		var dropped = false;
		if ($.ui.ddmanager && !this.options.dropBehaviour)
			dropped = $.ui.ddmanager.drop(this, event);

		//if a drop comes from outside (a sortable)
		if(this.dropped) {
			dropped = this.dropped;
			this.dropped = false;
		}

		if((this.options.revert == "invalid" && !dropped) || (this.options.revert == "valid" && dropped) || this.options.revert === true || ($.isFunction(this.options.revert) && this.options.revert.call(this.element, dropped))) {
			var self = this;
			$(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), function() {
				self._trigger("stop", event);
				self._clear();
			});
		} else {
			this._trigger("stop", event);
			this._clear();
		}

		return false;
	},

	_getHandle: function(event) {

		var handle = !this.options.handle || !$(this.options.handle, this.element).length ? true : false;
		$(this.options.handle, this.element)
			.find("*")
			.andSelf()
			.each(function() {
				if(this == event.target) handle = true;
			});

		return handle;

	},

	_createHelper: function(event) {

		var o = this.options;
		var helper = $.isFunction(o.helper) ? $(o.helper.apply(this.element[0], [event])) : (o.helper == 'clone' ? this.element.clone() : this.element);

		if(!helper.parents('body').length)
			helper.appendTo((o.appendTo == 'parent' ? this.element[0].parentNode : o.appendTo));

		if(helper[0] != this.element[0] && !(/(fixed|absolute)/).test(helper.css("position")))
			helper.css("position", "absolute");

		return helper;

	},

	_adjustOffsetFromHelper: function(obj) {
		if(obj.left != undefined) this.offset.click.left = obj.left + this.margins.left;
		if(obj.right != undefined) this.offset.click.left = this.helperProportions.width - obj.right + this.margins.left;
		if(obj.top != undefined) this.offset.click.top = obj.top + this.margins.top;
		if(obj.bottom != undefined) this.offset.click.top = this.helperProportions.height - obj.bottom + this.margins.top;
	},

	_getParentOffset: function() {

		//Get the offsetParent and cache its position
		this.offsetParent = this.helper.offsetParent();
		var po = this.offsetParent.offset();

		// This is a special case where we need to modify a offset calculated on start, since the following happened:
		// 1. The position of the helper is absolute, so it's position is calculated based on the next positioned parent
		// 2. The actual offset parent is a child of the scroll parent, and the scroll parent isn't the document, which means that
		//	the scroll is included in the initial calculation of the offset of the parent, and never recalculated upon drag
		if(this.cssPosition == 'absolute' && this.scrollParent[0] != document && $.ui.contains(this.scrollParent[0], this.offsetParent[0])) {
			po.left += this.scrollParent.scrollLeft();
			po.top += this.scrollParent.scrollTop();
		}

		if((this.offsetParent[0] == document.body) //This needs to be actually done for all browsers, since pageX/pageY includes this information
		|| (this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() == 'html' && $.browser.msie)) //Ugly IE fix
			po = { top: 0, left: 0 };

		return {
			top: po.top + (parseInt(this.offsetParent.css("borderTopWidth"),10) || 0),
			left: po.left + (parseInt(this.offsetParent.css("borderLeftWidth"),10) || 0)
		};

	},

	_getRelativeOffset: function() {

		if(this.cssPosition == "relative") {
			var p = this.element.position();
			return {
				top: p.top - (parseInt(this.helper.css("top"),10) || 0) + this.scrollParent.scrollTop(),
				left: p.left - (parseInt(this.helper.css("left"),10) || 0) + this.scrollParent.scrollLeft()
			};
		} else {
			return { top: 0, left: 0 };
		}

	},

	_cacheMargins: function() {
		this.margins = {
			left: (parseInt(this.element.css("marginLeft"),10) || 0),
			top: (parseInt(this.element.css("marginTop"),10) || 0)
		};
	},

	_cacheHelperProportions: function() {
		this.helperProportions = {
			width: this.helper.outerWidth(),
			height: this.helper.outerHeight()
		};
	},

	_setContainment: function() {

		var o = this.options;
		if(o.containment == 'parent') o.containment = this.helper[0].parentNode;
		if(o.containment == 'document' || o.containment == 'window') this.containment = [
			0 - this.offset.relative.left - this.offset.parent.left,
			0 - this.offset.relative.top - this.offset.parent.top,
			$(o.containment == 'document' ? document : window).width() - this.helperProportions.width - this.margins.left,
			($(o.containment == 'document' ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top
		];

		if(!(/^(document|window|parent)$/).test(o.containment) && o.containment.constructor != Array) {
			var ce = $(o.containment)[0]; if(!ce) return;
			var co = $(o.containment).offset();
			var over = ($(ce).css("overflow") != 'hidden');

			this.containment = [
				co.left + (parseInt($(ce).css("borderLeftWidth"),10) || 0) + (parseInt($(ce).css("paddingLeft"),10) || 0) - this.margins.left,
				co.top + (parseInt($(ce).css("borderTopWidth"),10) || 0) + (parseInt($(ce).css("paddingTop"),10) || 0) - this.margins.top,
				co.left+(over ? Math.max(ce.scrollWidth,ce.offsetWidth) : ce.offsetWidth) - (parseInt($(ce).css("borderLeftWidth"),10) || 0) - (parseInt($(ce).css("paddingRight"),10) || 0) - this.helperProportions.width - this.margins.left,
				co.top+(over ? Math.max(ce.scrollHeight,ce.offsetHeight) : ce.offsetHeight) - (parseInt($(ce).css("borderTopWidth"),10) || 0) - (parseInt($(ce).css("paddingBottom"),10) || 0) - this.helperProportions.height - this.margins.top
			];
		} else if(o.containment.constructor == Array) {
			this.containment = o.containment;
		}

	},

	_convertPositionTo: function(d, pos) {

		if(!pos) pos = this.position;
		var mod = d == "absolute" ? 1 : -1;
		var o = this.options, scroll = this.cssPosition == 'absolute' && !(this.scrollParent[0] != document && $.ui.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent, scrollIsRootNode = (/(html|body)/i).test(scroll[0].tagName);

		return {
			top: (
				pos.top																	// The absolute mouse position
				+ this.offset.relative.top * mod										// Only for relative positioned nodes: Relative offset from element to offset parent
				+ this.offset.parent.top * mod											// The offsetParent's offset without borders (offset + border)
				- ($.browser.safari && this.cssPosition == 'fixed' ? 0 : ( this.cssPosition == 'fixed' ? -this.scrollParent.scrollTop() : ( scrollIsRootNode ? 0 : scroll.scrollTop() ) ) * mod)
			),
			left: (
				pos.left																// The absolute mouse position
				+ this.offset.relative.left * mod										// Only for relative positioned nodes: Relative offset from element to offset parent
				+ this.offset.parent.left * mod											// The offsetParent's offset without borders (offset + border)
				- ($.browser.safari && this.cssPosition == 'fixed' ? 0 : ( this.cssPosition == 'fixed' ? -this.scrollParent.scrollLeft() : scrollIsRootNode ? 0 : scroll.scrollLeft() ) * mod)
			)
		};

	},

	_generatePosition: function(event) {

		var o = this.options, scroll = this.cssPosition == 'absolute' && !(this.scrollParent[0] != document && $.ui.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent, scrollIsRootNode = (/(html|body)/i).test(scroll[0].tagName);

		// This is another very weird special case that only happens for relative elements:
		// 1. If the css position is relative
		// 2. and the scroll parent is the document or similar to the offset parent
		// we have to refresh the relative offset during the scroll so there are no jumps
		if(this.cssPosition == 'relative' && !(this.scrollParent[0] != document && this.scrollParent[0] != this.offsetParent[0])) {
			this.offset.relative = this._getRelativeOffset();
		}

		var pageX = event.pageX;
		var pageY = event.pageY;

		/*
		 * - Position constraining -
		 * Constrain the position to a mix of grid, containment.
		 */

		if(this.originalPosition) { //If we are not dragging yet, we won't check for options

			if(this.containment) {
				if(event.pageX - this.offset.click.left < this.containment[0]) pageX = this.containment[0] + this.offset.click.left;
				if(event.pageY - this.offset.click.top < this.containment[1]) pageY = this.containment[1] + this.offset.click.top;
				if(event.pageX - this.offset.click.left > this.containment[2]) pageX = this.containment[2] + this.offset.click.left;
				if(event.pageY - this.offset.click.top > this.containment[3]) pageY = this.containment[3] + this.offset.click.top;
			}

			if(o.grid) {
				var top = this.originalPageY + Math.round((pageY - this.originalPageY) / o.grid[1]) * o.grid[1];
				pageY = this.containment ? (!(top - this.offset.click.top < this.containment[1] || top - this.offset.click.top > this.containment[3]) ? top : (!(top - this.offset.click.top < this.containment[1]) ? top - o.grid[1] : top + o.grid[1])) : top;

				var left = this.originalPageX + Math.round((pageX - this.originalPageX) / o.grid[0]) * o.grid[0];
				pageX = this.containment ? (!(left - this.offset.click.left < this.containment[0] || left - this.offset.click.left > this.containment[2]) ? left : (!(left - this.offset.click.left < this.containment[0]) ? left - o.grid[0] : left + o.grid[0])) : left;
			}

		}

		return {
			top: (
				pageY																// The absolute mouse position
				- this.offset.click.top													// Click offset (relative to the element)
				- this.offset.relative.top												// Only for relative positioned nodes: Relative offset from element to offset parent
				- this.offset.parent.top												// The offsetParent's offset without borders (offset + border)
				+ ($.browser.safari && this.cssPosition == 'fixed' ? 0 : ( this.cssPosition == 'fixed' ? -this.scrollParent.scrollTop() : ( scrollIsRootNode ? 0 : scroll.scrollTop() ) ))
			),
			left: (
				pageX																// The absolute mouse position
				- this.offset.click.left												// Click offset (relative to the element)
				- this.offset.relative.left												// Only for relative positioned nodes: Relative offset from element to offset parent
				- this.offset.parent.left												// The offsetParent's offset without borders (offset + border)
				+ ($.browser.safari && this.cssPosition == 'fixed' ? 0 : ( this.cssPosition == 'fixed' ? -this.scrollParent.scrollLeft() : scrollIsRootNode ? 0 : scroll.scrollLeft() ))
			)
		};

	},

	_clear: function() {
		this.helper.removeClass("ui-draggable-dragging");
		if(this.helper[0] != this.element[0] && !this.cancelHelperRemoval) this.helper.remove();
		//if($.ui.ddmanager) $.ui.ddmanager.current = null;
		this.helper = null;
		this.cancelHelperRemoval = false;
	},

	// From now on bulk stuff - mainly helpers

	_trigger: function(type, event, ui) {
		ui = ui || this._uiHash();
		$.ui.plugin.call(this, type, [event, ui]);
		if(type == "drag") this.positionAbs = this._convertPositionTo("absolute"); //The absolute position has to be recalculated after plugins
		return $.widget.prototype._trigger.call(this, type, event, ui);
	},

	plugins: {},

	_uiHash: function(event) {
		return {
			helper: this.helper,
			position: this.position,
			absolutePosition: this.positionAbs, //deprecated
			offset: this.positionAbs
		};
	}

}));

$.extend($.ui.draggable, {
	version: "1.7.1",
	eventPrefix: "drag",
	defaults: {
		addClasses: true,
		appendTo: "parent",
		axis: false,
		cancel: ":input,option",
		connectToSortable: false,
		containment: false,
		cursor: "auto",
		cursorAt: false,
		delay: 0,
		distance: 1,
		grid: false,
		handle: false,
		helper: "original",
		iframeFix: false,
		opacity: false,
		refreshPositions: false,
		revert: false,
		revertDuration: 500,
		scope: "default",
		scroll: true,
		scrollSensitivity: 20,
		scrollSpeed: 20,
		snap: false,
		snapMode: "both",
		snapTolerance: 20,
		stack: false,
		zIndex: false
	}
});

$.ui.plugin.add("draggable", "connectToSortable", {
	start: function(event, ui) {

		var inst = $(this).data("draggable"), o = inst.options,
			uiSortable = $.extend({}, ui, { item: inst.element });
		inst.sortables = [];
		$(o.connectToSortable).each(function() {
			var sortable = $.data(this, 'sortable');
			if (sortable && !sortable.options.disabled) {
				inst.sortables.push({
					instance: sortable,
					shouldRevert: sortable.options.revert
				});
				sortable._refreshItems();	//Do a one-time refresh at start to refresh the containerCache
				sortable._trigger("activate", event, uiSortable);
			}
		});

	},
	stop: function(event, ui) {

		//If we are still over the sortable, we fake the stop event of the sortable, but also remove helper
		var inst = $(this).data("draggable"),
			uiSortable = $.extend({}, ui, { item: inst.element });

		$.each(inst.sortables, function() {
			if(this.instance.isOver) {

				this.instance.isOver = 0;

				inst.cancelHelperRemoval = true; //Don't remove the helper in the draggable instance
				this.instance.cancelHelperRemoval = false; //Remove it in the sortable instance (so sortable plugins like revert still work)

				//The sortable revert is supported, and we have to set a temporary dropped variable on the draggable to support revert: 'valid/invalid'
				if(this.shouldRevert) this.instance.options.revert = true;

				//Trigger the stop of the sortable
				this.instance._mouseStop(event);

				this.instance.options.helper = this.instance.options._helper;

				//If the helper has been the original item, restore properties in the sortable
				if(inst.options.helper == 'original')
					this.instance.currentItem.css({ top: 'auto', left: 'auto' });

			} else {
				this.instance.cancelHelperRemoval = false; //Remove the helper in the sortable instance
				this.instance._trigger("deactivate", event, uiSortable);
			}

		});

	},
	drag: function(event, ui) {

		var inst = $(this).data("draggable"), self = this;

		var checkPos = function(o) {
			var dyClick = this.offset.click.top, dxClick = this.offset.click.left;
			var helperTop = this.positionAbs.top, helperLeft = this.positionAbs.left;
			var itemHeight = o.height, itemWidth = o.width;
			var itemTop = o.top, itemLeft = o.left;

			return $.ui.isOver(helperTop + dyClick, helperLeft + dxClick, itemTop, itemLeft, itemHeight, itemWidth);
		};

		$.each(inst.sortables, function(i) {
			
			//Copy over some variables to allow calling the sortable's native _intersectsWith
			this.instance.positionAbs = inst.positionAbs;
			this.instance.helperProportions = inst.helperProportions;
			this.instance.offset.click = inst.offset.click;
			
			if(this.instance._intersectsWith(this.instance.containerCache)) {

				//If it intersects, we use a little isOver variable and set it once, so our move-in stuff gets fired only once
				if(!this.instance.isOver) {

					this.instance.isOver = 1;
					//Now we fake the start of dragging for the sortable instance,
					//by cloning the list group item, appending it to the sortable and using it as inst.currentItem
					//We can then fire the start event of the sortable with our passed browser event, and our own helper (so it doesn't create a new one)
					this.instance.currentItem = $(self).clone().appendTo(this.instance.element).data("sortable-item", true);
					this.instance.options._helper = this.instance.options.helper; //Store helper option to later restore it
					this.instance.options.helper = function() { return ui.helper[0]; };

					event.target = this.instance.currentItem[0];
					this.instance._mouseCapture(event, true);
					this.instance._mouseStart(event, true, true);

					//Because the browser event is way off the new appended portlet, we modify a couple of variables to reflect the changes
					this.instance.offset.click.top = inst.offset.click.top;
					this.instance.offset.click.left = inst.offset.click.left;
					this.instance.offset.parent.left -= inst.offset.parent.left - this.instance.offset.parent.left;
					this.instance.offset.parent.top -= inst.offset.parent.top - this.instance.offset.parent.top;

					inst._trigger("toSortable", event);
					inst.dropped = this.instance.element; //draggable revert needs that
					//hack so receive/update callbacks work (mostly)
					inst.currentItem = inst.element;
					this.instance.fromOutside = inst;

				}

				//Provided we did all the previous steps, we can fire the drag event of the sortable on every draggable drag, when it intersects with the sortable
				if(this.instance.currentItem) this.instance._mouseDrag(event);

			} else {

				//If it doesn't intersect with the sortable, and it intersected before,
				//we fake the drag stop of the sortable, but make sure it doesn't remove the helper by using cancelHelperRemoval
				if(this.instance.isOver) {

					this.instance.isOver = 0;
					this.instance.cancelHelperRemoval = true;
					
					//Prevent reverting on this forced stop
					this.instance.options.revert = false;
					
					// The out event needs to be triggered independently
					this.instance._trigger('out', event, this.instance._uiHash(this.instance));
					
					this.instance._mouseStop(event, true);
					this.instance.options.helper = this.instance.options._helper;

					//Now we remove our currentItem, the list group clone again, and the placeholder, and animate the helper back to it's original size
					this.instance.currentItem.remove();
					if(this.instance.placeholder) this.instance.placeholder.remove();

					inst._trigger("fromSortable", event);
					inst.dropped = false; //draggable revert needs that
				}

			};

		});

	}
});

$.ui.plugin.add("draggable", "cursor", {
	start: function(event, ui) {
		var t = $('body'), o = $(this).data('draggable').options;
		if (t.css("cursor")) o._cursor = t.css("cursor");
		t.css("cursor", o.cursor);
	},
	stop: function(event, ui) {
		var o = $(this).data('draggable').options;
		if (o._cursor) $('body').css("cursor", o._cursor);
	}
});

$.ui.plugin.add("draggable", "iframeFix", {
	start: function(event, ui) {
		var o = $(this).data('draggable').options;
		$(o.iframeFix === true ? "iframe" : o.iframeFix).each(function() {
			$('<div class="ui-draggable-iframeFix" style="background: #fff;"></div>')
			.css({
				width: this.offsetWidth+"px", height: this.offsetHeight+"px",
				position: "absolute", opacity: "0.001", zIndex: 1000
			})
			.css($(this).offset())
			.appendTo("body");
		});
	},
	stop: function(event, ui) {
		$("div.ui-draggable-iframeFix").each(function() { this.parentNode.removeChild(this); }); //Remove frame helpers
	}
});

$.ui.plugin.add("draggable", "opacity", {
	start: function(event, ui) {
		var t = $(ui.helper), o = $(this).data('draggable').options;
		if(t.css("opacity")) o._opacity = t.css("opacity");
		t.css('opacity', o.opacity);
	},
	stop: function(event, ui) {
		var o = $(this).data('draggable').options;
		if(o._opacity) $(ui.helper).css('opacity', o._opacity);
	}
});

$.ui.plugin.add("draggable", "scroll", {
	start: function(event, ui) {
		var i = $(this).data("draggable");
		if(i.scrollParent[0] != document && i.scrollParent[0].tagName != 'HTML') i.overflowOffset = i.scrollParent.offset();
	},
	drag: function(event, ui) {

		var i = $(this).data("draggable"), o = i.options, scrolled = false;

		if(i.scrollParent[0] != document && i.scrollParent[0].tagName != 'HTML') {

			if(!o.axis || o.axis != 'x') {
				if((i.overflowOffset.top + i.scrollParent[0].offsetHeight) - event.pageY < o.scrollSensitivity)
					i.scrollParent[0].scrollTop = scrolled = i.scrollParent[0].scrollTop + o.scrollSpeed;
				else if(event.pageY - i.overflowOffset.top < o.scrollSensitivity)
					i.scrollParent[0].scrollTop = scrolled = i.scrollParent[0].scrollTop - o.scrollSpeed;
			}

			if(!o.axis || o.axis != 'y') {
				if((i.overflowOffset.left + i.scrollParent[0].offsetWidth) - event.pageX < o.scrollSensitivity)
					i.scrollParent[0].scrollLeft = scrolled = i.scrollParent[0].scrollLeft + o.scrollSpeed;
				else if(event.pageX - i.overflowOffset.left < o.scrollSensitivity)
					i.scrollParent[0].scrollLeft = scrolled = i.scrollParent[0].scrollLeft - o.scrollSpeed;
			}

		} else {

			if(!o.axis || o.axis != 'x') {
				if(event.pageY - $(document).scrollTop() < o.scrollSensitivity)
					scrolled = $(document).scrollTop($(document).scrollTop() - o.scrollSpeed);
				else if($(window).height() - (event.pageY - $(document).scrollTop()) < o.scrollSensitivity)
					scrolled = $(document).scrollTop($(document).scrollTop() + o.scrollSpeed);
			}

			if(!o.axis || o.axis != 'y') {
				if(event.pageX - $(document).scrollLeft() < o.scrollSensitivity)
					scrolled = $(document).scrollLeft($(document).scrollLeft() - o.scrollSpeed);
				else if($(window).width() - (event.pageX - $(document).scrollLeft()) < o.scrollSensitivity)
					scrolled = $(document).scrollLeft($(document).scrollLeft() + o.scrollSpeed);
			}

		}

		if(scrolled !== false && $.ui.ddmanager && !o.dropBehaviour)
			$.ui.ddmanager.prepareOffsets(i, event);

	}
});

$.ui.plugin.add("draggable", "snap", {
	start: function(event, ui) {

		var i = $(this).data("draggable"), o = i.options;
		i.snapElements = [];

		$(o.snap.constructor != String ? ( o.snap.items || ':data(draggable)' ) : o.snap).each(function() {
			var $t = $(this); var $o = $t.offset();
			if(this != i.element[0]) i.snapElements.push({
				item: this,
				width: $t.outerWidth(), height: $t.outerHeight(),
				top: $o.top, left: $o.left
			});
		});

	},
	drag: function(event, ui) {

		var inst = $(this).data("draggable"), o = inst.options;
		var d = o.snapTolerance;

		var x1 = ui.offset.left, x2 = x1 + inst.helperProportions.width,
			y1 = ui.offset.top, y2 = y1 + inst.helperProportions.height;

		for (var i = inst.snapElements.length - 1; i >= 0; i--){

			var l = inst.snapElements[i].left, r = l + inst.snapElements[i].width,
				t = inst.snapElements[i].top, b = t + inst.snapElements[i].height;

			//Yes, I know, this is insane ;)
			if(!((l-d < x1 && x1 < r+d && t-d < y1 && y1 < b+d) || (l-d < x1 && x1 < r+d && t-d < y2 && y2 < b+d) || (l-d < x2 && x2 < r+d && t-d < y1 && y1 < b+d) || (l-d < x2 && x2 < r+d && t-d < y2 && y2 < b+d))) {
				if(inst.snapElements[i].snapping) (inst.options.snap.release && inst.options.snap.release.call(inst.element, event, $.extend(inst._uiHash(), { snapItem: inst.snapElements[i].item })));
				inst.snapElements[i].snapping = false;
				continue;
			}

			if(o.snapMode != 'inner') {
				var ts = Math.abs(t - y2) <= d;
				var bs = Math.abs(b - y1) <= d;
				var ls = Math.abs(l - x2) <= d;
				var rs = Math.abs(r - x1) <= d;
				if(ts) ui.position.top = inst._convertPositionTo("relative", { top: t - inst.helperProportions.height, left: 0 }).top - inst.margins.top;
				if(bs) ui.position.top = inst._convertPositionTo("relative", { top: b, left: 0 }).top - inst.margins.top;
				if(ls) ui.position.left = inst._convertPositionTo("relative", { top: 0, left: l - inst.helperProportions.width }).left - inst.margins.left;
				if(rs) ui.position.left = inst._convertPositionTo("relative", { top: 0, left: r }).left - inst.margins.left;
			}

			var first = (ts || bs || ls || rs);

			if(o.snapMode != 'outer') {
				var ts = Math.abs(t - y1) <= d;
				var bs = Math.abs(b - y2) <= d;
				var ls = Math.abs(l - x1) <= d;
				var rs = Math.abs(r - x2) <= d;
				if(ts) ui.position.top = inst._convertPositionTo("relative", { top: t, left: 0 }).top - inst.margins.top;
				if(bs) ui.position.top = inst._convertPositionTo("relative", { top: b - inst.helperProportions.height, left: 0 }).top - inst.margins.top;
				if(ls) ui.position.left = inst._convertPositionTo("relative", { top: 0, left: l }).left - inst.margins.left;
				if(rs) ui.position.left = inst._convertPositionTo("relative", { top: 0, left: r - inst.helperProportions.width }).left - inst.margins.left;
			}

			if(!inst.snapElements[i].snapping && (ts || bs || ls || rs || first))
				(inst.options.snap.snap && inst.options.snap.snap.call(inst.element, event, $.extend(inst._uiHash(), { snapItem: inst.snapElements[i].item })));
			inst.snapElements[i].snapping = (ts || bs || ls || rs || first);

		};

	}
});

$.ui.plugin.add("draggable", "stack", {
	start: function(event, ui) {

		var o = $(this).data("draggable").options;

		var group = $.makeArray($(o.stack.group)).sort(function(a,b) {
			return (parseInt($(a).css("zIndex"),10) || o.stack.min) - (parseInt($(b).css("zIndex"),10) || o.stack.min);
		});

		$(group).each(function(i) {
			this.style.zIndex = o.stack.min + i;
		});

		this[0].style.zIndex = o.stack.min + group.length;

	}
});

$.ui.plugin.add("draggable", "zIndex", {
	start: function(event, ui) {
		var t = $(ui.helper), o = $(this).data("draggable").options;
		if(t.css("zIndex")) o._zIndex = t.css("zIndex");
		t.css('zIndex', o.zIndex);
	},
	stop: function(event, ui) {
		var o = $(this).data("draggable").options;
		if(o._zIndex) $(ui.helper).css('zIndex', o._zIndex);
	}
});

})(jQuery);
/*
 * jQuery UI Resizable 1.7.1
 *
 * Copyright (c) 2009 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Resizables
 *
 * Depends:
 *	ui.core.js
 */
(function($) {

$.widget("ui.resizable", $.extend({}, $.ui.mouse, {

	_init: function() {

		var self = this, o = this.options;
		this.element.addClass("ui-resizable");

		$.extend(this, {
			_aspectRatio: !!(o.aspectRatio),
			aspectRatio: o.aspectRatio,
			originalElement: this.element,
			_proportionallyResizeElements: [],
			_helper: o.helper || o.ghost || o.animate ? o.helper || 'ui-resizable-helper' : null
		});

		//Wrap the element if it cannot hold child nodes
		if(this.element[0].nodeName.match(/canvas|textarea|input|select|button|img/i)) {

			//Opera fix for relative positioning
			if (/relative/.test(this.element.css('position')) && $.browser.opera)
				this.element.css({ position: 'relative', top: 'auto', left: 'auto' });

			//Create a wrapper element and set the wrapper to the new current internal element
			this.element.wrap(
				$('<div class="ui-wrapper" style="overflow: hidden;"></div>').css({
					position: this.element.css('position'),
					width: this.element.outerWidth(),
					height: this.element.outerHeight(),
					top: this.element.css('top'),
					left: this.element.css('left')
				})
			);

			//Overwrite the original this.element
			this.element = this.element.parent().data(
				"resizable", this.element.data('resizable')
			);

			this.elementIsWrapper = true;

			//Move margins to the wrapper
			this.element.css({ marginLeft: this.originalElement.css("marginLeft"), marginTop: this.originalElement.css("marginTop"), marginRight: this.originalElement.css("marginRight"), marginBottom: this.originalElement.css("marginBottom") });
			this.originalElement.css({ marginLeft: 0, marginTop: 0, marginRight: 0, marginBottom: 0});

			//Prevent Safari textarea resize
			this.originalResizeStyle = this.originalElement.css('resize');
			this.originalElement.css('resize', 'none');

			//Push the actual element to our proportionallyResize internal array
			this._proportionallyResizeElements.push(this.originalElement.css({ position: 'static', zoom: 1, display: 'block' }));

			// avoid IE jump (hard set the margin)
			this.originalElement.css({ margin: this.originalElement.css('margin') });

			// fix handlers offset
			this._proportionallyResize();

		}

		this.handles = o.handles || (!$('.ui-resizable-handle', this.element).length ? "e,s,se" : { n: '.ui-resizable-n', e: '.ui-resizable-e', s: '.ui-resizable-s', w: '.ui-resizable-w', se: '.ui-resizable-se', sw: '.ui-resizable-sw', ne: '.ui-resizable-ne', nw: '.ui-resizable-nw' });
		if(this.handles.constructor == String) {

			if(this.handles == 'all') this.handles = 'n,e,s,w,se,sw,ne,nw';
			var n = this.handles.split(","); this.handles = {};

			for(var i = 0; i < n.length; i++) {

				var handle = $.trim(n[i]), hname = 'ui-resizable-'+handle;
				var axis = $('<div class="ui-resizable-handle ' + hname + '"></div>');

				// increase zIndex of sw, se, ne, nw axis
				//TODO : this modifies original option
				if(/sw|se|ne|nw/.test(handle)) axis.css({ zIndex: ++o.zIndex });

				//TODO : What's going on here?
				if ('se' == handle) {
					axis.addClass('ui-icon ui-icon-gripsmall-diagonal-se');
				};

				//Insert into internal handles object and append to element
				this.handles[handle] = '.ui-resizable-'+handle;
				this.element.append(axis);
			}

		}

		this._renderAxis = function(target) {

			target = target || this.element;

			for(var i in this.handles) {

				if(this.handles[i].constructor == String)
					this.handles[i] = $(this.handles[i], this.element).show();

				//Apply pad to wrapper element, needed to fix axis position (textarea, inputs, scrolls)
				if (this.elementIsWrapper && this.originalElement[0].nodeName.match(/textarea|input|select|button/i)) {

					var axis = $(this.handles[i], this.element), padWrapper = 0;

					//Checking the correct pad and border
					padWrapper = /sw|ne|nw|se|n|s/.test(i) ? axis.outerHeight() : axis.outerWidth();

					//The padding type i have to apply...
					var padPos = [ 'padding',
						/ne|nw|n/.test(i) ? 'Top' :
						/se|sw|s/.test(i) ? 'Bottom' :
						/^e$/.test(i) ? 'Right' : 'Left' ].join("");

					target.css(padPos, padWrapper);

					this._proportionallyResize();

				}

				//TODO: What's that good for? There's not anything to be executed left
				if(!$(this.handles[i]).length)
					continue;

			}
		};

		//TODO: make renderAxis a prototype function
		this._renderAxis(this.element);

		this._handles = $('.ui-resizable-handle', this.element)
			.disableSelection();

		//Matching axis name
		this._handles.mouseover(function() {
			if (!self.resizing) {
				if (this.className)
					var axis = this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i);
				//Axis, default = se
				self.axis = axis && axis[1] ? axis[1] : 'se';
			}
		});

		//If we want to auto hide the elements
		if (o.autoHide) {
			this._handles.hide();
			$(this.element)
				.addClass("ui-resizable-autohide")
				.hover(function() {
					$(this).removeClass("ui-resizable-autohide");
					self._handles.show();
				},
				function(){
					if (!self.resizing) {
						$(this).addClass("ui-resizable-autohide");
						self._handles.hide();
					}
				});
		}

		//Initialize the mouse interaction
		this._mouseInit();

	},

	destroy: function() {

		this._mouseDestroy();

		var _destroy = function(exp) {
			$(exp).removeClass("ui-resizable ui-resizable-disabled ui-resizable-resizing")
				.removeData("resizable").unbind(".resizable").find('.ui-resizable-handle').remove();
		};

		//TODO: Unwrap at same DOM position
		if (this.elementIsWrapper) {
			_destroy(this.element);
			var wrapper = this.element;
			wrapper.parent().append(
				this.originalElement.css({
					position: wrapper.css('position'),
					width: wrapper.outerWidth(),
					height: wrapper.outerHeight(),
					top: wrapper.css('top'),
					left: wrapper.css('left')
				})
			).end().remove();
		}

		this.originalElement.css('resize', this.originalResizeStyle);
		_destroy(this.originalElement);

	},

	_mouseCapture: function(event) {

		var handle = false;
		for(var i in this.handles) {
			if($(this.handles[i])[0] == event.target) handle = true;
		}

		return this.options.disabled || !!handle;

	},

	_mouseStart: function(event) {

		var o = this.options, iniPos = this.element.position(), el = this.element;

		this.resizing = true;
		this.documentScroll = { top: $(document).scrollTop(), left: $(document).scrollLeft() };

		// bugfix for http://dev.jquery.com/ticket/1749
		if (el.is('.ui-draggable') || (/absolute/).test(el.css('position'))) {
			el.css({ position: 'absolute', top: iniPos.top, left: iniPos.left });
		}

		//Opera fixing relative position
		if ($.browser.opera && (/relative/).test(el.css('position')))
			el.css({ position: 'relative', top: 'auto', left: 'auto' });

		this._renderProxy();

		var curleft = num(this.helper.css('left')), curtop = num(this.helper.css('top'));

		if (o.containment) {
			curleft += $(o.containment).scrollLeft() || 0;
			curtop += $(o.containment).scrollTop() || 0;
		}

		//Store needed variables
		this.offset = this.helper.offset();
		this.position = { left: curleft, top: curtop };
		this.size = this._helper ? { width: el.outerWidth(), height: el.outerHeight() } : { width: el.width(), height: el.height() };
		this.originalSize = this._helper ? { width: el.outerWidth(), height: el.outerHeight() } : { width: el.width(), height: el.height() };
		this.originalPosition = { left: curleft, top: curtop };
		this.sizeDiff = { width: el.outerWidth() - el.width(), height: el.outerHeight() - el.height() };
		this.originalMousePosition = { left: event.pageX, top: event.pageY };

		//Aspect Ratio
		this.aspectRatio = (typeof o.aspectRatio == 'number') ? o.aspectRatio : ((this.originalSize.width / this.originalSize.height) || 1);

		var cursor = $('.ui-resizable-' + this.axis).css('cursor');
		$('body').css('cursor', cursor == 'auto' ? this.axis + '-resize' : cursor);

		el.addClass("ui-resizable-resizing");
		this._propagate("start", event);
		return true;
	},

	_mouseDrag: function(event) {

		//Increase performance, avoid regex
		var el = this.helper, o = this.options, props = {},
			self = this, smp = this.originalMousePosition, a = this.axis;

		var dx = (event.pageX-smp.left)||0, dy = (event.pageY-smp.top)||0;
		var trigger = this._change[a];
		if (!trigger) return false;

		// Calculate the attrs that will be change
		var data = trigger.apply(this, [event, dx, dy]), ie6 = $.browser.msie && $.browser.version < 7, csdif = this.sizeDiff;

		if (this._aspectRatio || event.shiftKey)
			data = this._updateRatio(data, event);

		data = this._respectSize(data, event);

		// plugins callbacks need to be called first
		this._propagate("resize", event);

		el.css({
			top: this.position.top + "px", left: this.position.left + "px",
			width: this.size.width + "px", height: this.size.height + "px"
		});

		if (!this._helper && this._proportionallyResizeElements.length)
			this._proportionallyResize();

		this._updateCache(data);

		// calling the user callback at the end
		this._trigger('resize', event, this.ui());

		return false;
	},

	_mouseStop: function(event) {

		this.resizing = false;
		var o = this.options, self = this;

		if(this._helper) {
			var pr = this._proportionallyResizeElements, ista = pr.length && (/textarea/i).test(pr[0].nodeName),
						soffseth = ista && $.ui.hasScroll(pr[0], 'left') /* TODO - jump height */ ? 0 : self.sizeDiff.height,
							soffsetw = ista ? 0 : self.sizeDiff.width;

			var s = { width: (self.size.width - soffsetw), height: (self.size.height - soffseth) },
				left = (parseInt(self.element.css('left'), 10) + (self.position.left - self.originalPosition.left)) || null,
				top = (parseInt(self.element.css('top'), 10) + (self.position.top - self.originalPosition.top)) || null;

			if (!o.animate)
				this.element.css($.extend(s, { top: top, left: left }));

			self.helper.height(self.size.height);
			self.helper.width(self.size.width);

			if (this._helper && !o.animate) this._proportionallyResize();
		}

		$('body').css('cursor', 'auto');

		this.element.removeClass("ui-resizable-resizing");

		this._propagate("stop", event);

		if (this._helper) this.helper.remove();
		return false;

	},

	_updateCache: function(data) {
		var o = this.options;
		this.offset = this.helper.offset();
		if (isNumber(data.left)) this.position.left = data.left;
		if (isNumber(data.top)) this.position.top = data.top;
		if (isNumber(data.height)) this.size.height = data.height;
		if (isNumber(data.width)) this.size.width = data.width;
	},

	_updateRatio: function(data, event) {

		var o = this.options, cpos = this.position, csize = this.size, a = this.axis;

		if (data.height) data.width = (csize.height * this.aspectRatio);
		else if (data.width) data.height = (csize.width / this.aspectRatio);

		if (a == 'sw') {
			data.left = cpos.left + (csize.width - data.width);
			data.top = null;
		}
		if (a == 'nw') {
			data.top = cpos.top + (csize.height - data.height);
			data.left = cpos.left + (csize.width - data.width);
		}

		return data;
	},

	_respectSize: function(data, event) {

		var el = this.helper, o = this.options, pRatio = this._aspectRatio || event.shiftKey, a = this.axis,
				ismaxw = isNumber(data.width) && o.maxWidth && (o.maxWidth < data.width), ismaxh = isNumber(data.height) && o.maxHeight && (o.maxHeight < data.height),
					isminw = isNumber(data.width) && o.minWidth && (o.minWidth > data.width), isminh = isNumber(data.height) && o.minHeight && (o.minHeight > data.height);

		if (isminw) data.width = o.minWidth;
		if (isminh) data.height = o.minHeight;
		if (ismaxw) data.width = o.maxWidth;
		if (ismaxh) data.height = o.maxHeight;

		var dw = this.originalPosition.left + this.originalSize.width, dh = this.position.top + this.size.height;
		var cw = /sw|nw|w/.test(a), ch = /nw|ne|n/.test(a);

		if (isminw && cw) data.left = dw - o.minWidth;
		if (ismaxw && cw) data.left = dw - o.maxWidth;
		if (isminh && ch)	data.top = dh - o.minHeight;
		if (ismaxh && ch)	data.top = dh - o.maxHeight;

		// fixing jump error on top/left - bug #2330
		var isNotwh = !data.width && !data.height;
		if (isNotwh && !data.left && data.top) data.top = null;
		else if (isNotwh && !data.top && data.left) data.left = null;

		return data;
	},

	_proportionallyResize: function() {

		var o = this.options;
		if (!this._proportionallyResizeElements.length) return;
		var element = this.helper || this.element;

		for (var i=0; i < this._proportionallyResizeElements.length; i++) {

			var prel = this._proportionallyResizeElements[i];

			if (!this.borderDif) {
				var b = [prel.css('borderTopWidth'), prel.css('borderRightWidth'), prel.css('borderBottomWidth'), prel.css('borderLeftWidth')],
					p = [prel.css('paddingTop'), prel.css('paddingRight'), prel.css('paddingBottom'), prel.css('paddingLeft')];

				this.borderDif = $.map(b, function(v, i) {
					var border = parseInt(v,10)||0, padding = parseInt(p[i],10)||0;
					return border + padding;
				});
			}

			if ($.browser.msie && !(!($(element).is(':hidden') || $(element).parents(':hidden').length)))
				continue;

			prel.css({
				height: (element.height() - this.borderDif[0] - this.borderDif[2]) || 0,
				width: (element.width() - this.borderDif[1] - this.borderDif[3]) || 0
			});

		};

	},

	_renderProxy: function() {

		var el = this.element, o = this.options;
		this.elementOffset = el.offset();

		if(this._helper) {

			this.helper = this.helper || $('<div style="overflow:hidden;"></div>');

			// fix ie6 offset TODO: This seems broken
			var ie6 = $.browser.msie && $.browser.version < 7, ie6offset = (ie6 ? 1 : 0),
			pxyoffset = ( ie6 ? 2 : -1 );

			this.helper.addClass(this._helper).css({
				width: this.element.outerWidth() + pxyoffset,
				height: this.element.outerHeight() + pxyoffset,
				position: 'absolute',
				left: this.elementOffset.left - ie6offset +'px',
				top: this.elementOffset.top - ie6offset +'px',
				zIndex: ++o.zIndex //TODO: Don't modify option
			});

			this.helper
				.appendTo("body")
				.disableSelection();

		} else {
			this.helper = this.element;
		}

	},

	_change: {
		e: function(event, dx, dy) {
			return { width: this.originalSize.width + dx };
		},
		w: function(event, dx, dy) {
			var o = this.options, cs = this.originalSize, sp = this.originalPosition;
			return { left: sp.left + dx, width: cs.width - dx };
		},
		n: function(event, dx, dy) {
			var o = this.options, cs = this.originalSize, sp = this.originalPosition;
			return { top: sp.top + dy, height: cs.height - dy };
		},
		s: function(event, dx, dy) {
			return { height: this.originalSize.height + dy };
		},
		se: function(event, dx, dy) {
			return $.extend(this._change.s.apply(this, arguments), this._change.e.apply(this, [event, dx, dy]));
		},
		sw: function(event, dx, dy) {
			return $.extend(this._change.s.apply(this, arguments), this._change.w.apply(this, [event, dx, dy]));
		},
		ne: function(event, dx, dy) {
			return $.extend(this._change.n.apply(this, arguments), this._change.e.apply(this, [event, dx, dy]));
		},
		nw: function(event, dx, dy) {
			return $.extend(this._change.n.apply(this, arguments), this._change.w.apply(this, [event, dx, dy]));
		}
	},

	_propagate: function(n, event) {
		$.ui.plugin.call(this, n, [event, this.ui()]);
		(n != "resize" && this._trigger(n, event, this.ui()));
	},

	plugins: {},

	ui: function() {
		return {
			originalElement: this.originalElement,
			element: this.element,
			helper: this.helper,
			position: this.position,
			size: this.size,
			originalSize: this.originalSize,
			originalPosition: this.originalPosition
		};
	}

}));

$.extend($.ui.resizable, {
	version: "1.7.1",
	eventPrefix: "resize",
	defaults: {
		alsoResize: false,
		animate: false,
		animateDuration: "slow",
		animateEasing: "swing",
		aspectRatio: false,
		autoHide: false,
		cancel: ":input,option",
		containment: false,
		delay: 0,
		distance: 1,
		ghost: false,
		grid: false,
		handles: "e,s,se",
		helper: false,
		maxHeight: null,
		maxWidth: null,
		minHeight: 10,
		minWidth: 10,
		zIndex: 1000
	}
});

/*
 * Resizable Extensions
 */

$.ui.plugin.add("resizable", "alsoResize", {

	start: function(event, ui) {

		var self = $(this).data("resizable"), o = self.options;

		_store = function(exp) {
			$(exp).each(function() {
				$(this).data("resizable-alsoresize", {
					width: parseInt($(this).width(), 10), height: parseInt($(this).height(), 10),
					left: parseInt($(this).css('left'), 10), top: parseInt($(this).css('top'), 10)
				});
			});
		};

		if (typeof(o.alsoResize) == 'object' && !o.alsoResize.parentNode) {
			if (o.alsoResize.length) { o.alsoResize = o.alsoResize[0];	_store(o.alsoResize); }
			else { $.each(o.alsoResize, function(exp, c) { _store(exp); }); }
		}else{
			_store(o.alsoResize);
		}
	},

	resize: function(event, ui){
		var self = $(this).data("resizable"), o = self.options, os = self.originalSize, op = self.originalPosition;

		var delta = {
			height: (self.size.height - os.height) || 0, width: (self.size.width - os.width) || 0,
			top: (self.position.top - op.top) || 0, left: (self.position.left - op.left) || 0
		},

		_alsoResize = function(exp, c) {
			$(exp).each(function() {
				var el = $(this), start = $(this).data("resizable-alsoresize"), style = {}, css = c && c.length ? c : ['width', 'height', 'top', 'left'];

				$.each(css || ['width', 'height', 'top', 'left'], function(i, prop) {
					var sum = (start[prop]||0) + (delta[prop]||0);
					if (sum && sum >= 0)
						style[prop] = sum || null;
				});

				//Opera fixing relative position
				if (/relative/.test(el.css('position')) && $.browser.opera) {
					self._revertToRelativePosition = true;
					el.css({ position: 'absolute', top: 'auto', left: 'auto' });
				}

				el.css(style);
			});
		};

		if (typeof(o.alsoResize) == 'object' && !o.alsoResize.nodeType) {
			$.each(o.alsoResize, function(exp, c) { _alsoResize(exp, c); });
		}else{
			_alsoResize(o.alsoResize);
		}
	},

	stop: function(event, ui){
		var self = $(this).data("resizable");

		//Opera fixing relative position
		if (self._revertToRelativePosition && $.browser.opera) {
			self._revertToRelativePosition = false;
			el.css({ position: 'relative' });
		}

		$(this).removeData("resizable-alsoresize-start");
	}
});

$.ui.plugin.add("resizable", "animate", {

	stop: function(event, ui) {
		var self = $(this).data("resizable"), o = self.options;

		var pr = self._proportionallyResizeElements, ista = pr.length && (/textarea/i).test(pr[0].nodeName),
					soffseth = ista && $.ui.hasScroll(pr[0], 'left') /* TODO - jump height */ ? 0 : self.sizeDiff.height,
						soffsetw = ista ? 0 : self.sizeDiff.width;

		var style = { width: (self.size.width - soffsetw), height: (self.size.height - soffseth) },
					left = (parseInt(self.element.css('left'), 10) + (self.position.left - self.originalPosition.left)) || null,
						top = (parseInt(self.element.css('top'), 10) + (self.position.top - self.originalPosition.top)) || null;

		self.element.animate(
			$.extend(style, top && left ? { top: top, left: left } : {}), {
				duration: o.animateDuration,
				easing: o.animateEasing,
				step: function() {

					var data = {
						width: parseInt(self.element.css('width'), 10),
						height: parseInt(self.element.css('height'), 10),
						top: parseInt(self.element.css('top'), 10),
						left: parseInt(self.element.css('left'), 10)
					};

					if (pr && pr.length) $(pr[0]).css({ width: data.width, height: data.height });

					// propagating resize, and updating values for each animation step
					self._updateCache(data);
					self._propagate("resize", event);

				}
			}
		);
	}

});

$.ui.plugin.add("resizable", "containment", {

	start: function(event, ui) {
		var self = $(this).data("resizable"), o = self.options, el = self.element;
		var oc = o.containment,	ce = (oc instanceof $) ? oc.get(0) : (/parent/.test(oc)) ? el.parent().get(0) : oc;
		if (!ce) return;

		self.containerElement = $(ce);

		if (/document/.test(oc) || oc == document) {
			self.containerOffset = { left: 0, top: 0 };
			self.containerPosition = { left: 0, top: 0 };

			self.parentData = {
				element: $(document), left: 0, top: 0,
				width: $(document).width(), height: $(document).height() || document.body.parentNode.scrollHeight
			};
		}

		// i'm a node, so compute top, left, right, bottom
		else {
			var element = $(ce), p = [];
			$([ "Top", "Right", "Left", "Bottom" ]).each(function(i, name) { p[i] = num(element.css("padding" + name)); });

			self.containerOffset = element.offset();
			self.containerPosition = element.position();
			self.containerSize = { height: (element.innerHeight() - p[3]), width: (element.innerWidth() - p[1]) };

			var co = self.containerOffset, ch = self.containerSize.height,	cw = self.containerSize.width,
						width = ($.ui.hasScroll(ce, "left") ? ce.scrollWidth : cw ), height = ($.ui.hasScroll(ce) ? ce.scrollHeight : ch);

			self.parentData = {
				element: ce, left: co.left, top: co.top, width: width, height: height
			};
		}
	},

	resize: function(event, ui) {
		var self = $(this).data("resizable"), o = self.options,
				ps = self.containerSize, co = self.containerOffset, cs = self.size, cp = self.position,
				pRatio = self._aspectRatio || event.shiftKey, cop = { top:0, left:0 }, ce = self.containerElement;

		if (ce[0] != document && (/static/).test(ce.css('position'))) cop = co;

		if (cp.left < (self._helper ? co.left : 0)) {
			self.size.width = self.size.width + (self._helper ? (self.position.left - co.left) : (self.position.left - cop.left));
			if (pRatio) self.size.height = self.size.width / o.aspectRatio;
			self.position.left = o.helper ? co.left : 0;
		}

		if (cp.top < (self._helper ? co.top : 0)) {
			self.size.height = self.size.height + (self._helper ? (self.position.top - co.top) : self.position.top);
			if (pRatio) self.size.width = self.size.height * o.aspectRatio;
			self.position.top = self._helper ? co.top : 0;
		}

		self.offset.left = self.parentData.left+self.position.left;
		self.offset.top = self.parentData.top+self.position.top;

		var woset = Math.abs( (self._helper ? self.offset.left - cop.left : (self.offset.left - cop.left)) + self.sizeDiff.width ),
					hoset = Math.abs( (self._helper ? self.offset.top - cop.top : (self.offset.top - co.top)) + self.sizeDiff.height );

		var isParent = self.containerElement.get(0) == self.element.parent().get(0),
			isOffsetRelative = /relative|absolute/.test(self.containerElement.css('position'));

		if(isParent && isOffsetRelative) woset -= self.parentData.left;

		if (woset + self.size.width >= self.parentData.width) {
			self.size.width = self.parentData.width - woset;
			if (pRatio) self.size.height = self.size.width / self.aspectRatio;
		}

		if (hoset + self.size.height >= self.parentData.height) {
			self.size.height = self.parentData.height - hoset;
			if (pRatio) self.size.width = self.size.height * self.aspectRatio;
		}
	},

	stop: function(event, ui){
		var self = $(this).data("resizable"), o = self.options, cp = self.position,
				co = self.containerOffset, cop = self.containerPosition, ce = self.containerElement;

		var helper = $(self.helper), ho = helper.offset(), w = helper.outerWidth() - self.sizeDiff.width, h = helper.outerHeight() - self.sizeDiff.height;

		if (self._helper && !o.animate && (/relative/).test(ce.css('position')))
			$(this).css({ left: ho.left - cop.left - co.left, width: w, height: h });

		if (self._helper && !o.animate && (/static/).test(ce.css('position')))
			$(this).css({ left: ho.left - cop.left - co.left, width: w, height: h });

	}
});

$.ui.plugin.add("resizable", "ghost", {

	start: function(event, ui) {

		var self = $(this).data("resizable"), o = self.options, cs = self.size;

		self.ghost = self.originalElement.clone();
		self.ghost
			.css({ opacity: .25, display: 'block', position: 'relative', height: cs.height, width: cs.width, margin: 0, left: 0, top: 0 })
			.addClass('ui-resizable-ghost')
			.addClass(typeof o.ghost == 'string' ? o.ghost : '');

		self.ghost.appendTo(self.helper);

	},

	resize: function(event, ui){
		var self = $(this).data("resizable"), o = self.options;
		if (self.ghost) self.ghost.css({ position: 'relative', height: self.size.height, width: self.size.width });
	},

	stop: function(event, ui){
		var self = $(this).data("resizable"), o = self.options;
		if (self.ghost && self.helper) self.helper.get(0).removeChild(self.ghost.get(0));
	}

});

$.ui.plugin.add("resizable", "grid", {

	resize: function(event, ui) {
		var self = $(this).data("resizable"), o = self.options, cs = self.size, os = self.originalSize, op = self.originalPosition, a = self.axis, ratio = o._aspectRatio || event.shiftKey;
		o.grid = typeof o.grid == "number" ? [o.grid, o.grid] : o.grid;
		var ox = Math.round((cs.width - os.width) / (o.grid[0]||1)) * (o.grid[0]||1), oy = Math.round((cs.height - os.height) / (o.grid[1]||1)) * (o.grid[1]||1);

		if (/^(se|s|e)$/.test(a)) {
			self.size.width = os.width + ox;
			self.size.height = os.height + oy;
		}
		else if (/^(ne)$/.test(a)) {
			self.size.width = os.width + ox;
			self.size.height = os.height + oy;
			self.position.top = op.top - oy;
		}
		else if (/^(sw)$/.test(a)) {
			self.size.width = os.width + ox;
			self.size.height = os.height + oy;
			self.position.left = op.left - ox;
		}
		else {
			self.size.width = os.width + ox;
			self.size.height = os.height + oy;
			self.position.top = op.top - oy;
			self.position.left = op.left - ox;
		}
	}

});

var num = function(v) {
	return parseInt(v, 10) || 0;
};

var isNumber = function(value) {
	return !isNaN(parseInt(value, 10));
};

})(jQuery);
/*
 * jQuery UI Tabs 1.7.1
 *
 * Copyright (c) 2009 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Tabs
 *
 * Depends:
 *	ui.core.js
 */
(function($) {

$.widget("ui.tabs", {

	_init: function() {
		if (this.options.deselectable !== undefined) {
			this.options.collapsible = this.options.deselectable;
		}
		this._tabify(true);
	},

	_setData: function(key, value) {
		if (key == 'selected') {
			if (this.options.collapsible && value == this.options.selected) {
				return;
			}
			this.select(value);
		}
		else {
			this.options[key] = value;
			if (key == 'deselectable') {
				this.options.collapsible = value;
			}
			this._tabify();
		}
	},

	_tabId: function(a) {
		return a.title && a.title.replace(/\s/g, '_').replace(/[^A-Za-z0-9\-_:\.]/g, '') ||
			this.options.idPrefix + $.data(a);
	},

	_sanitizeSelector: function(hash) {
		return hash.replace(/:/g, '\\:'); // we need this because an id may contain a ":"
	},

	_cookie: function() {
		var cookie = this.cookie || (this.cookie = this.options.cookie.name || 'ui-tabs-' + $.data(this.list[0]));
		return $.cookie.apply(null, [cookie].concat($.makeArray(arguments)));
	},

	_ui: function(tab, panel) {
		return {
			tab: tab,
			panel: panel,
			index: this.anchors.index(tab)
		};
	},

	_cleanup: function() {
		// restore all former loading tabs labels
		this.lis.filter('.ui-state-processing').removeClass('ui-state-processing')
				.find('span:data(label.tabs)')
				.each(function() {
					var el = $(this);
					el.html(el.data('label.tabs')).removeData('label.tabs');
				});
	},

	_tabify: function(init) {

		this.list = this.element.children('ul:first');
		this.lis = $('li:has(a[href])', this.list);
		this.anchors = this.lis.map(function() { return $('a', this)[0]; });
		this.panels = $([]);

		var self = this, o = this.options;

		var fragmentId = /^#.+/; // Safari 2 reports '#' for an empty hash
		this.anchors.each(function(i, a) {
			var href = $(a).attr('href');

			// For dynamically created HTML that contains a hash as href IE < 8 expands
			// such href to the full page url with hash and then misinterprets tab as ajax.
			// Same consideration applies for an added tab with a fragment identifier
			// since a[href=#fragment-identifier] does unexpectedly not match.
			// Thus normalize href attribute...
			var hrefBase = href.split('#')[0], baseEl;
			if (hrefBase && (hrefBase === location.toString().split('#')[0] ||
					(baseEl = $('base')[0]) && hrefBase === baseEl.href)) {
				href = a.hash;
				a.href = href;
			}

			// inline tab
			if (fragmentId.test(href)) {
				self.panels = self.panels.add(self._sanitizeSelector(href));
			}

			// remote tab
			else if (href != '#') { // prevent loading the page itself if href is just "#"
				$.data(a, 'href.tabs', href); // required for restore on destroy

				// TODO until #3808 is fixed strip fragment identifier from url
				// (IE fails to load from such url)
				$.data(a, 'load.tabs', href.replace(/#.*$/, '')); // mutable data

				var id = self._tabId(a);
				a.href = '#' + id;
				var $panel = $('#' + id);
				if (!$panel.length) {
					$panel = $(o.panelTemplate).attr('id', id).addClass('ui-tabs-panel ui-widget-content ui-corner-bottom')
						.insertAfter(self.panels[i - 1] || self.list);
					$panel.data('destroy.tabs', true);
				}
				self.panels = self.panels.add($panel);
			}

			// invalid tab href
			else {
				o.disabled.push(i);
			}
		});

		// initialization from scratch
		if (init) {

			// attach necessary classes for styling
			this.element.addClass('ui-tabs ui-widget ui-widget-content ui-corner-all');
			this.list.addClass('ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all');
			this.lis.addClass('ui-state-default ui-corner-top');
			this.panels.addClass('ui-tabs-panel ui-widget-content ui-corner-bottom');

			// Selected tab
			// use "selected" option or try to retrieve:
			// 1. from fragment identifier in url
			// 2. from cookie
			// 3. from selected class attribute on <li>
			if (o.selected === undefined) {
				if (location.hash) {
					this.anchors.each(function(i, a) {
						if (a.hash == location.hash) {
							o.selected = i;
							return false; // break
						}
					});
				}
				if (typeof o.selected != 'number' && o.cookie) {
					o.selected = parseInt(self._cookie(), 10);
				}
				if (typeof o.selected != 'number' && this.lis.filter('.ui-tabs-selected').length) {
					o.selected = this.lis.index(this.lis.filter('.ui-tabs-selected'));
				}
				o.selected = o.selected || 0;
			}
			else if (o.selected === null) { // usage of null is deprecated, TODO remove in next release
				o.selected = -1;
			}

			// sanity check - default to first tab...
			o.selected = ((o.selected >= 0 && this.anchors[o.selected]) || o.selected < 0) ? o.selected : 0;

			// Take disabling tabs via class attribute from HTML
			// into account and update option properly.
			// A selected tab cannot become disabled.
			o.disabled = $.unique(o.disabled.concat(
				$.map(this.lis.filter('.ui-state-disabled'),
					function(n, i) { return self.lis.index(n); } )
			)).sort();

			if ($.inArray(o.selected, o.disabled) != -1) {
				o.disabled.splice($.inArray(o.selected, o.disabled), 1);
			}

			// highlight selected tab
			this.panels.addClass('ui-tabs-hide');
			this.lis.removeClass('ui-tabs-selected ui-state-active');
			if (o.selected >= 0 && this.anchors.length) { // check for length avoids error when initializing empty list
				this.panels.eq(o.selected).removeClass('ui-tabs-hide');
				this.lis.eq(o.selected).addClass('ui-tabs-selected ui-state-active');

				// seems to be expected behavior that the show callback is fired
				self.element.queue("tabs", function() {
					self._trigger('show', null, self._ui(self.anchors[o.selected], self.panels[o.selected]));
				});
				
				this.load(o.selected);
			}

			// clean up to avoid memory leaks in certain versions of IE 6
			$(window).bind('unload', function() {
				self.lis.add(self.anchors).unbind('.tabs');
				self.lis = self.anchors = self.panels = null;
			});

		}
		// update selected after add/remove
		else {
			o.selected = this.lis.index(this.lis.filter('.ui-tabs-selected'));
		}

		// update collapsible
		this.element[o.collapsible ? 'addClass' : 'removeClass']('ui-tabs-collapsible');

		// set or update cookie after init and add/remove respectively
		if (o.cookie) {
			this._cookie(o.selected, o.cookie);
		}

		// disable tabs
		for (var i = 0, li; (li = this.lis[i]); i++) {
			$(li)[$.inArray(i, o.disabled) != -1 &&
				!$(li).hasClass('ui-tabs-selected') ? 'addClass' : 'removeClass']('ui-state-disabled');
		}

		// reset cache if switching from cached to not cached
		if (o.cache === false) {
			this.anchors.removeData('cache.tabs');
		}

		// remove all handlers before, tabify may run on existing tabs after add or option change
		this.lis.add(this.anchors).unbind('.tabs');

		if (o.event != 'mouseover') {
			var addState = function(state, el) {
				if (el.is(':not(.ui-state-disabled)')) {
					el.addClass('ui-state-' + state);
				}
			};
			var removeState = function(state, el) {
				el.removeClass('ui-state-' + state);
			};
			this.lis.bind('mouseover.tabs', function() {
				addState('hover', $(this));
			});
			this.lis.bind('mouseout.tabs', function() {
				removeState('hover', $(this));
			});
			this.anchors.bind('focus.tabs', function() {
				addState('focus', $(this).closest('li'));
			});
			this.anchors.bind('blur.tabs', function() {
				removeState('focus', $(this).closest('li'));
			});
		}

		// set up animations
		var hideFx, showFx;
		if (o.fx) {
			if ($.isArray(o.fx)) {
				hideFx = o.fx[0];
				showFx = o.fx[1];
			}
			else {
				hideFx = showFx = o.fx;
			}
		}

		// Reset certain styles left over from animation
		// and prevent IE's ClearType bug...
		function resetStyle($el, fx) {
			$el.css({ display: '' });
			if ($.browser.msie && fx.opacity) {
				$el[0].style.removeAttribute('filter');
			}
		}

		// Show a tab...
		var showTab = showFx ?
			function(clicked, $show) {
				$(clicked).closest('li').removeClass('ui-state-default').addClass('ui-tabs-selected ui-state-active');
				$show.hide().removeClass('ui-tabs-hide') // avoid flicker that way
					.animate(showFx, showFx.duration || 'normal', function() {
						resetStyle($show, showFx);
						self._trigger('show', null, self._ui(clicked, $show[0]));
					});
			} :
			function(clicked, $show) {
				$(clicked).closest('li').removeClass('ui-state-default').addClass('ui-tabs-selected ui-state-active');
				$show.removeClass('ui-tabs-hide');
				self._trigger('show', null, self._ui(clicked, $show[0]));
			};

		// Hide a tab, $show is optional...
		var hideTab = hideFx ?
			function(clicked, $hide) {
				$hide.animate(hideFx, hideFx.duration || 'normal', function() {
					self.lis.removeClass('ui-tabs-selected ui-state-active').addClass('ui-state-default');
					$hide.addClass('ui-tabs-hide');
					resetStyle($hide, hideFx);
					self.element.dequeue("tabs");
				});
			} :
			function(clicked, $hide, $show) {
				self.lis.removeClass('ui-tabs-selected ui-state-active').addClass('ui-state-default');
				$hide.addClass('ui-tabs-hide');
				self.element.dequeue("tabs");
			};

		// attach tab event handler, unbind to avoid duplicates from former tabifying...
		this.anchors.bind(o.event + '.tabs', function() {
			var el = this, $li = $(this).closest('li'), $hide = self.panels.filter(':not(.ui-tabs-hide)'),
					$show = $(self._sanitizeSelector(this.hash));

			// If tab is already selected and not collapsible or tab disabled or
			// or is already loading or click callback returns false stop here.
			// Check if click handler returns false last so that it is not executed
			// for a disabled or loading tab!
			if (($li.hasClass('ui-tabs-selected') && !o.collapsible) ||
				$li.hasClass('ui-state-disabled') ||
				$li.hasClass('ui-state-processing') ||
				self._trigger('select', null, self._ui(this, $show[0])) === false) {
				this.blur();
				return false;
			}

			o.selected = self.anchors.index(this);

			self.abort();

			// if tab may be closed
			if (o.collapsible) {
				if ($li.hasClass('ui-tabs-selected')) {
					o.selected = -1;

					if (o.cookie) {
						self._cookie(o.selected, o.cookie);
					}

					self.element.queue("tabs", function() {
						hideTab(el, $hide);
					}).dequeue("tabs");
					
					this.blur();
					return false;
				}
				else if (!$hide.length) {
					if (o.cookie) {
						self._cookie(o.selected, o.cookie);
					}
					
					self.element.queue("tabs", function() {
						showTab(el, $show);
					});

					self.load(self.anchors.index(this)); // TODO make passing in node possible, see also http://dev.jqueryui.com/ticket/3171
					
					this.blur();
					return false;
				}
			}

			if (o.cookie) {
				self._cookie(o.selected, o.cookie);
			}

			// show new tab
			if ($show.length) {
				if ($hide.length) {
					self.element.queue("tabs", function() {
						hideTab(el, $hide);
					});
				}
				self.element.queue("tabs", function() {
					showTab(el, $show);
				});
				
				self.load(self.anchors.index(this));
			}
			else {
				throw 'jQuery UI Tabs: Mismatching fragment identifier.';
			}

			// Prevent IE from keeping other link focussed when using the back button
			// and remove dotted border from clicked link. This is controlled via CSS
			// in modern browsers; blur() removes focus from address bar in Firefox
			// which can become a usability and annoying problem with tabs('rotate').
			if ($.browser.msie) {
				this.blur();
			}

		});

		// disable click in any case
		this.anchors.bind('click.tabs', function(){return false;});

	},

	destroy: function() {
		var o = this.options;

		this.abort();
		
		this.element.unbind('.tabs')
			.removeClass('ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible')
			.removeData('tabs');

		this.list.removeClass('ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all');

		this.anchors.each(function() {
			var href = $.data(this, 'href.tabs');
			if (href) {
				this.href = href;
			}
			var $this = $(this).unbind('.tabs');
			$.each(['href', 'load', 'cache'], function(i, prefix) {
				$this.removeData(prefix + '.tabs');
			});
		});

		this.lis.unbind('.tabs').add(this.panels).each(function() {
			if ($.data(this, 'destroy.tabs')) {
				$(this).remove();
			}
			else {
				$(this).removeClass([
					'ui-state-default',
					'ui-corner-top',
					'ui-tabs-selected',
					'ui-state-active',
					'ui-state-hover',
					'ui-state-focus',
					'ui-state-disabled',
					'ui-tabs-panel',
					'ui-widget-content',
					'ui-corner-bottom',
					'ui-tabs-hide'
				].join(' '));
			}
		});

		if (o.cookie) {
			this._cookie(null, o.cookie);
		}
	},

	add: function(url, label, index) {
		if (index === undefined) {
			index = this.anchors.length; // append by default
		}

		var self = this, o = this.options,
			$li = $(o.tabTemplate.replace(/#\{href\}/g, url).replace(/#\{label\}/g, label)),
			id = !url.indexOf('#') ? url.replace('#', '') : this._tabId($('a', $li)[0]);

		$li.addClass('ui-state-default ui-corner-top').data('destroy.tabs', true);

		// try to find an existing element before creating a new one
		var $panel = $('#' + id);
		if (!$panel.length) {
			$panel = $(o.panelTemplate).attr('id', id).data('destroy.tabs', true);
		}
		$panel.addClass('ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide');

		if (index >= this.lis.length) {
			$li.appendTo(this.list);
			$panel.appendTo(this.list[0].parentNode);
		}
		else {
			$li.insertBefore(this.lis[index]);
			$panel.insertBefore(this.panels[index]);
		}

		o.disabled = $.map(o.disabled,
			function(n, i) { return n >= index ? ++n : n; });

		this._tabify();

		if (this.anchors.length == 1) { // after tabify
			$li.addClass('ui-tabs-selected ui-state-active');
			$panel.removeClass('ui-tabs-hide');
			this.element.queue("tabs", function() {
				self._trigger('show', null, self._ui(self.anchors[0], self.panels[0]));
			});
				
			this.load(0);
		}

		// callback
		this._trigger('add', null, this._ui(this.anchors[index], this.panels[index]));
	},

	remove: function(index) {
		var o = this.options, $li = this.lis.eq(index).remove(),
			$panel = this.panels.eq(index).remove();

		// If selected tab was removed focus tab to the right or
		// in case the last tab was removed the tab to the left.
		if ($li.hasClass('ui-tabs-selected') && this.anchors.length > 1) {
			this.select(index + (index + 1 < this.anchors.length ? 1 : -1));
		}

		o.disabled = $.map($.grep(o.disabled, function(n, i) { return n != index; }),
			function(n, i) { return n >= index ? --n : n; });

		this._tabify();

		// callback
		this._trigger('remove', null, this._ui($li.find('a')[0], $panel[0]));
	},

	enable: function(index) {
		var o = this.options;
		if ($.inArray(index, o.disabled) == -1) {
			return;
		}

		this.lis.eq(index).removeClass('ui-state-disabled');
		o.disabled = $.grep(o.disabled, function(n, i) { return n != index; });

		// callback
		this._trigger('enable', null, this._ui(this.anchors[index], this.panels[index]));
	},

	disable: function(index) {
		var self = this, o = this.options;
		if (index != o.selected) { // cannot disable already selected tab
			this.lis.eq(index).addClass('ui-state-disabled');

			o.disabled.push(index);
			o.disabled.sort();

			// callback
			this._trigger('disable', null, this._ui(this.anchors[index], this.panels[index]));
		}
	},

	select: function(index) {
		if (typeof index == 'string') {
			index = this.anchors.index(this.anchors.filter('[href$=' + index + ']'));
		}
		else if (index === null) { // usage of null is deprecated, TODO remove in next release
			index = -1;
		}
		if (index == -1 && this.options.collapsible) {
			index = this.options.selected;
		}

		this.anchors.eq(index).trigger(this.options.event + '.tabs');
	},

	load: function(index) {
		var self = this, o = this.options, a = this.anchors.eq(index)[0], url = $.data(a, 'load.tabs');

		this.abort();

		// not remote or from cache
		if (!url || this.element.queue("tabs").length !== 0 && $.data(a, 'cache.tabs')) {
			this.element.dequeue("tabs");
			return;
		}

		// load remote from here on
		this.lis.eq(index).addClass('ui-state-processing');

		if (o.spinner) {
			var span = $('span', a);
			span.data('label.tabs', span.html()).html(o.spinner);
		}

		this.xhr = $.ajax($.extend({}, o.ajaxOptions, {
			url: url,
			success: function(r, s) {
				$(self._sanitizeSelector(a.hash)).html(r);

				// take care of tab labels
				self._cleanup();

				if (o.cache) {
					$.data(a, 'cache.tabs', true); // if loaded once do not load them again
				}

				// callbacks
				self._trigger('load', null, self._ui(self.anchors[index], self.panels[index]));
				try {
					o.ajaxOptions.success(r, s);
				}
				catch (e) {}

				// last, so that load event is fired before show...
				self.element.dequeue("tabs");
			}
		}));
	},

	abort: function() {
		// stop possibly running animations
		this.element.queue([]);
		this.panels.stop(false, true);

		// terminate pending requests from other tabs
		if (this.xhr) {
			this.xhr.abort();
			delete this.xhr;
		}

		// take care of tab labels
		this._cleanup();

	},

	url: function(index, url) {
		this.anchors.eq(index).removeData('cache.tabs').data('load.tabs', url);
	},

	length: function() {
		return this.anchors.length;
	}

});

$.extend($.ui.tabs, {
	version: '1.7.1',
	getter: 'length',
	defaults: {
		ajaxOptions: null,
		cache: false,
		cookie: null, // e.g. { expires: 7, path: '/', domain: 'jquery.com', secure: true }
		collapsible: false,
		disabled: [],
		event: 'click',
		fx: null, // e.g. { height: 'toggle', opacity: 'toggle', duration: 200 }
		idPrefix: 'ui-tabs-',
		panelTemplate: '<div></div>',
		spinner: '<em>Loading&#8230;</em>',
		tabTemplate: '<li><a href="#{href}"><span>#{label}</span></a></li>'
	}
});

/*
 * Tabs Extensions
 */

/*
 * Rotate
 */
$.extend($.ui.tabs.prototype, {
	rotation: null,
	rotate: function(ms, continuing) {

		var self = this, o = this.options;
		
		var rotate = self._rotate || (self._rotate = function(e) {
			clearTimeout(self.rotation);
			self.rotation = setTimeout(function() {
				var t = o.selected;
				self.select( ++t < self.anchors.length ? t : 0 );
			}, ms);
			
			if (e) {
				e.stopPropagation();
			}
		});
		
		var stop = self._unrotate || (self._unrotate = !continuing ?
			function(e) {
				if (e.clientX) { // in case of a true click
					self.rotate(null);
				}
			} :
			function(e) {
				t = o.selected;
				rotate();
			});

		// start rotation
		if (ms) {
			this.element.bind('tabsshow', rotate);
			this.anchors.bind(o.event + '.tabs', stop);
			rotate();
		}
		// stop rotation
		else {
			clearTimeout(self.rotation);
			this.element.unbind('tabsshow', rotate);
			this.anchors.unbind(o.event + '.tabs', stop);
			delete this._rotate;
			delete this._unrotate;
		}
	}
});

})(jQuery);
/*
 * jQuery Asynchronous Plugin 1.0
 *
 * Copyright (c) 2008 Vincent Robert (genezys.net)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 */
(function($){

// opts.delay : (default 10) delay between async call in ms
// opts.bulk : (default 500) delay during which the loop can continue synchronously without yielding the CPU
// opts.test : (default true) function to test in the while test part
// opts.loop : (default empty) function to call in the while loop part
// opts.end : (default empty) function to call at the end of the while loop
$.whileAsync = function(opts)
{
	var delay = Math.abs(opts.delay) || 10,
		bulk = isNaN(opts.bulk) ? 500 : Math.abs(opts.bulk),
		test = opts.test || function(){ return true; },
		loop = opts.loop || function(){},
		end  = opts.end  || function(){};
	
	(function(){

		var t = false,
			begin = new Date();
			
		while( t = test() )
		{
			loop();
			if( bulk === 0 || (new Date() - begin) > bulk )
			{
				break;
			}
		}
		if( t )
		{
			setTimeout(arguments.callee, delay);
		}
		else
		{
			end();
		}
		
	})();
}

// opts.delay : (default 10) delay between async call in ms
// opts.bulk : (default 500) delay during which the loop can continue synchronously without yielding the CPU
// opts.loop : (default empty) function to call in the each loop part, signature: function(index, value) this = value
// opts.end : (default empty) function to call at the end of the each loop
$.eachAsync = function(array, opts)
{
	var i = 0,
		l = array.length,
		loop = opts.loop || function(){};
	
	$.whileAsync(
		$.extend(opts, {
			test: function(){ return i < l; },
			loop: function()
			{
				var val = array[i];
				return loop.call(val, i++, val);
			}
		})
	);
}

$.fn.eachAsync = function(opts)
{
	$.eachAsync(this, opts);
	return this;
}

})(jQuery);

/**
 * Plugin that automatically truncates the plain text contents of an element and adds an ellipsis
 */
( function( $ ) {

// Cache ellipsed substrings for every string-width combination
var cache = { };

$.fn.autoEllipsis = function( options ) {
	options = $.extend( {
		'position': 'center',
		'tooltip': false,
		'restoreText': false
	}, options );
	$(this).each( function() {
		var $this = $(this);
		if ( options.restoreText ) {
			if ( ! $this.data( 'autoEllipsis.originalText' ) ) {
				$this.data( 'autoEllipsis.originalText', $this.text() );
			} else {
				$this.text( $this.data( 'autoEllipsis.originalText' ) );
			}
		}
		var text = $this.text();
		var w = $this.width();
		var $text = $( '<span />' ).css( 'whiteSpace', 'nowrap' );
		$this.empty().append( $text );
		
		// Try cache
		if ( !( text in cache ) ) {
			cache[text] = {};
		}
		if ( w in cache[text] ) {
			$text.text( cache[text][w] );
			return;
		}
		
		$text.text( text );
		if ( $text.width() > w ) {
			switch ( options.position ) {
				case 'right':
					// Use binary search-like technique for efficiency
					var l = 0, r = text.length;
					do {
						var m = Math.ceil( ( l + r ) / 2 );
						$text.text( text.substr( 0, m ) + '...' );
						if ( $text.width() > w ) {
							// Text is too long
							r = m - 1;
						} else {
							l = m;
						}
					} while ( l < r );
					$text.text( text.substr( 0, l ) + '...' );
					break;
				case 'center':
					// TODO: Use binary search like for 'right'
					var i = [Math.round( text.length / 2 ), Math.round( text.length / 2 )];
					var side = 1; // Begin with making the end shorter
					while ( $text.outerWidth() > w  && i[0] > 0 ) {
						$text.text( text.substr( 0, i[0] ) + '...' + text.substr( i[1] ) );
						// Alternate between trimming the end and begining
						if ( side == 0 ) {
							// Make the begining shorter
							i[0]--;
							side = 1;
						} else {
							// Make the end shorter
							i[1]++;
							side = 0;
						}
					}
					break;
				case 'left':
					// TODO: Use binary search like for 'right'
					var r = 0;
					while ( $text.outerWidth() > w && r < text.length ) {
						$text.text( '...' + text.substr( r ) );
						r++;
					}
					break;
			}
			if ( options.tooltip )
				$text.attr( 'title', text );
		}
		cache[text][w] = $text.text();
	} );
};

} )( jQuery );/*

jQuery Browser Plugin
	* Version 2.3
	* 2008-09-17 19:27:05
	* URL: http://jquery.thewikies.com/browser
	* Description: jQuery Browser Plugin extends browser detection capabilities and can assign browser selectors to CSS classes.
	* Author: Nate Cavanaugh, Minhchau Dang, & Jonathan Neal
	* Copyright: Copyright (c) 2008 Jonathan Neal under dual MIT/GPL license.
	* JSLint: This javascript file passes JSLint verification.
*//*jslint
		bitwise: true,
		browser: true,
		eqeqeq: true,
		forin: true,
		nomen: true,
		plusplus: true,
		undef: true,
		white: true
*//*global
		jQuery
*/

(function ($) {
	$.browserTest = function (a, z) {
		var u = 'unknown', x = 'X', m = function (r, h) {
			for (var i = 0; i < h.length; i = i + 1) {
				r = r.replace(h[i][0], h[i][1]);
			}

			return r;
		}, c = function (i, a, b, c) {
			var r = {
				name: m((a.exec(i) || [u, u])[1], b)
			};

			r[r.name] = true;

			r.version = (c.exec(i) || [x, x, x, x])[3];

			if (r.name.match(/safari/) && r.version > 400) {
				r.version = '2.0';
			}

			if (r.name === 'presto') {
				r.version = ($.browser.version > 9.27) ? 'futhark' : 'linear_b';
			}
			r.versionNumber = parseFloat(r.version, 10) || 0;
			r.versionX = (r.version !== x) ? (r.version + '').substr(0, 1) : x;
			r.className = r.name + r.versionX;

			return r;
		};

		a = (a.match(/Opera|Navigator|Minefield|KHTML|Chrome/) ? m(a, [
			[/(Firefox|MSIE|KHTML,\slike\sGecko|Konqueror)/, ''],
			['Chrome Safari', 'Chrome'],
			['KHTML', 'Konqueror'],
			['Minefield', 'Firefox'],
			['Navigator', 'Netscape']
		]) : a).toLowerCase();

		$.browser = $.extend((!z) ? $.browser : {}, c(a, /(camino|chrome|firefox|netscape|konqueror|lynx|msie|opera|safari)/, [], /(camino|chrome|firefox|netscape|netscape6|opera|version|konqueror|lynx|msie|safari)(\/|\s)([a-z0-9\.\+]*?)(\;|dev|rel|\s|$)/));

		$.layout = c(a, /(gecko|konqueror|msie|opera|webkit)/, [
			['konqueror', 'khtml'],
			['msie', 'trident'],
			['opera', 'presto']
		], /(applewebkit|rv|konqueror|msie)(\:|\/|\s)([a-z0-9\.]*?)(\;|\)|\s)/);

		$.os = {
			name: (/(win|mac|linux|sunos|solaris|iphone)/.exec(navigator.platform.toLowerCase()) || [u])[0].replace('sunos', 'solaris')
		};

		if (!z) {
			$('html').addClass([$.os.name, $.browser.name, $.browser.className, $.layout.name, $.layout.className].join(' '));
		}
	};

	$.browserTest(navigator.userAgent);
})(jQuery);

( function( $ ) {

$.fn.collapsibleTabs = function( $$options ) {
	// return if the function is called on an empty jquery object
	if( !this.length ) return this;
	//merge options into the defaults
	var $settings = $.extend( {}, $.collapsibleTabs.defaults, $$options );

	this.each( function() {
		var $this = $( this );
		// add the element to our array of collapsible managers
		$.collapsibleTabs.instances = ( $.collapsibleTabs.instances.length == 0 ?
			$this : $.collapsibleTabs.instances.add( $this ) );
		// attach the settings to the elements
		$this.data( 'collapsibleTabsSettings', $settings );
		// attach data to our collapsible elements
		$this.children( $settings.collapsible ).each( function() {
			var $collapsible = $( this );
			$collapsible.data( 'collapsibleTabsSettings', {
				'expandedContainer': $settings.expandedContainer,
				'collapsedContainer': $settings.collapsedContainer,
				'expandedWidth': $collapsible.width(),
				'prevElement': $collapsible.prev()
			} );
		} );
	} );
	
	// if we haven't already bound our resize hanlder, bind it now
	if( !$.collapsibleTabs.boundEvent ) {
		$( window )
			.delayedBind( '500', 'resize', function( ) { $.collapsibleTabs.handleResize(); } );
	}
	// call our resize handler to setup the page
	$.collapsibleTabs.handleResize();
	return this;
};

$.collapsibleTabs = {
	instances: [],
	boundEvent: null,
	defaults: {
		expandedContainer: '#p-views ul',
		collapsedContainer: '#p-cactions ul',
		collapsible: 'li.collapsible',
		shifting: false,
		expandCondition: function( eleWidth ) {
			return ( $( '#left-navigation' ).position().left + $( '#left-navigation' ).width() )
				< ( $( '#right-navigation' ).position().left - eleWidth );
		},
		collapseCondition: function() {
			return ( $( '#left-navigation' ).position().left + $( '#left-navigation' ).width() )
				> $( '#right-navigation' ).position().left;
		}
	},
	handleResize: function( e ){
		$.collapsibleTabs.instances.each( function() {
			var $this = $( this ), data = $this.data( 'collapsibleTabsSettings' );
			if( data.shifting ) return;

			// if the two navigations are colliding
			if( $this.children( data.collapsible ).length > 0 && data.collapseCondition() ) {
				
				$this.trigger( "beforeTabCollapse" );
				// move the element to the dropdown menu
				$.collapsibleTabs.moveToCollapsed( $this.children( data.collapsible + ':last' ) );
			}

			// if there are still moveable items in the dropdown menu,
			// and there is sufficient space to place them in the tab container
			if( $( data.collapsedContainer + ' ' + data.collapsible ).length > 0
					&& data.expandCondition( $( data.collapsedContainer ).children(
							data.collapsible+":first" ).data( 'collapsibleTabsSettings' ).expandedWidth ) ) {
				//move the element from the dropdown to the tab
				$this.trigger( "beforeTabExpand" );
				$.collapsibleTabs
					.moveToExpanded( data.collapsedContainer + " " + data.collapsible + ':first' );
			}
		});
	},
	moveToCollapsed: function( ele ) {
		var $moving = $( ele );
		var data = $moving.data( 'collapsibleTabsSettings' );
		$( data.expandedContainer ).data( 'collapsibleTabsSettings' ).shifting = true;
		$moving
			.remove()
			.prependTo( data.collapsedContainer )
			.data( 'collapsibleTabsSettings', data );
		$( data.expandedContainer ).data( 'collapsibleTabsSettings' ).shifting = false;
		$.collapsibleTabs.handleResize();
	},
	moveToExpanded: function( ele ) {
		var $moving = $( ele );
		var data = $moving.data( 'collapsibleTabsSettings' );
		$( data.expandedContainer ).data( 'collapsibleTabsSettings' ).shifting = true;
		// remove this element from where it's at and put it in the dropdown menu
		$moving.remove().insertAfter( data.prevElement ).data( 'collapsibleTabsSettings', data );
		$( data.expandedContainer ).data( 'collapsibleTabsSettings' ).shifting = false;
		$.collapsibleTabs.handleResize();
	}
};

} )( jQuery );/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

/**
 * Create a cookie with the given name and value and other optional parameters.
 *
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Set the value of a cookie.
 * @example $.cookie('the_cookie', 'the_value', { expires: 7, path: '/', domain: 'jquery.com', secure: true });
 * @desc Create a cookie with all available options.
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Create a session cookie.
 * @example $.cookie('the_cookie', null);
 * @desc Delete a cookie by passing null as value. Keep in mind that you have to use the same path and domain
 *       used when the cookie was set.
 *
 * @param String name The name of the cookie.
 * @param String value The value of the cookie.
 * @param Object options An object literal containing key/value pairs to provide optional cookie attributes.
 * @option Number|Date expires Either an integer specifying the expiration date from now on in days or a Date object.
 *                             If a negative value is specified (e.g. a date in the past), the cookie will be deleted.
 *                             If set to null or omitted, the cookie will be a session cookie and will not be retained
 *                             when the the browser exits.
 * @option String path The value of the path atribute of the cookie (default: path of page that created the cookie).
 * @option String domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).
 * @option Boolean secure If true, the secure attribute of the cookie will be set and the cookie transmission will
 *                        require a secure protocol (like HTTPS).
 * @type undefined
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */

/**
 * Get the value of a cookie with the given name.
 *
 * @example $.cookie('the_cookie');
 * @desc Get the value of a cookie.
 *
 * @param String name The name of the cookie.
 * @return The value of the cookie.
 * @type String
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

(function( $ ) {
/**
 * Function that escapes spaces in event names. This is needed because
 * "_delayedBind-foo bar-1000" refers to two events
 */
function encodeEvent( event ) {
	return event.replace( /-/g, '--' ).replace( / /g, '-' );
}

$.fn.extend( {
	/**
	 * Bind a callback to an event in a delayed fashion.
	 * In detail, this means that the callback will be called a certain
	 * time after the event fires, but the timer is reset every time
	 * the event fires.
	 * @param timeout Number of milliseconds to wait
	 * @param event Name of the event (string)
	 * @param data Data to pass to the event handler (optional)
	 * @param callback Function to call
	 */
	delayedBind: function( timeout, event, data, callback ) {
		var encEvent = encodeEvent( event );
		return this.each( function() {
			var that = this;
			// Bind the top half
			// Do this only once for every (event, timeout) pair
			if (  !( $(this).data( '_delayedBindBound-' + encEvent + '-' + timeout ) ) ) {
				$(this).data( '_delayedBindBound-' + encEvent + '-' + timeout, true );
				$(this).bind( event, function() {
					var timerID = $(this).data( '_delayedBindTimerID-' + encEvent + '-' + timeout );
					// Cancel the running timer
					if ( typeof timerID != 'undefined' )
						clearTimeout( timerID );
					timerID = setTimeout( function() {
						$(that).trigger( '_delayedBind-' + encEvent + '-' + timeout );
					}, timeout );
					$(this).data( '_delayedBindTimerID-' + encEvent + '-' + timeout, timerID );
				} );
			}
			
			// Bottom half
			$(this).bind( '_delayedBind-' + encEvent + '-' + timeout, data, callback );
		} );
	},
	
	/**
	 * Cancel the timers for delayed events on the selected elements.
	 */
	delayedBindCancel: function( timeout, event ) {
		var encEvent = encodeEvent( event );
		return this.each( function() {
			var timerID = $(this).data( '_delayedBindTimerID-' + encEvent + '-' + timeout );
			if ( typeof timerID != 'undefined' )
				clearTimeout( timerID );
		} );
	},
	
	/**
	 * Unbind an event bound with delayedBind()
	 */
	delayedBindUnbind: function( timeout, event, callback ) {
		var encEvent = encodeEvent( event );
		return this.each( function() {
			$(this).unbind( '_delayedBind-' + encEvent + '-' + timeout, callback );
		} );
	}
} );
} )( jQuery );
/**
 * Plugin that fills a <select> with namespaces
 */

(function ($) {
$.fn.namespaceSelector = function( defaultNS ) {
	if ( typeof defaultNS == 'undefined' )
		defaultNS = 0;
	return this.each( function() {
		for ( var id in wgFormattedNamespaces ) {
			var opt = $( '<option />' )
				.attr( 'value', id )
				.text( wgFormattedNamespaces[id] );
			if ( id == defaultNS )
				opt.attr( 'selected', 'selected' );
			opt.appendTo( $(this) );
		}
	});
};})(jQuery);

/**
 * This plugin provides a generic way to add suggestions to a text box.
 *
 * Usage:
 *
 * Set options:
 *		$('#textbox').suggestions( { option1: value1, option2: value2 } );
 *		$('#textbox').suggestions( option, value );
 * Get option:
 *		value = $('#textbox').suggestions( option );
 * Initialize:
 *		$('#textbox').suggestions();
 *
 * Options:
 *
 * fetch(query): Callback that should fetch suggestions and set the suggestions property. Executed in the context of the
 * 		textbox
 * 		Type: Function
 * cancel: Callback function to call when any pending asynchronous suggestions fetches should be canceled.
 * 		Executed in the context of the textbox
 *		Type: Function
 * special: Set of callbacks for rendering and selecting
 *		Type: Object of Functions 'render' and 'select'
 * result: Set of callbacks for rendering and selecting
 *		Type: Object of Functions 'render' and 'select'
 * $region: jQuery selection of element to place the suggestions below and match width of
 * 		Type: jQuery Object, Default: $(this)
 * suggestions: Suggestions to display
 * 		Type: Array of strings
 * maxRows: Maximum number of suggestions to display at one time
 * 		Type: Number, Range: 1 - 100, Default: 7
 * delay: Number of ms to wait for the user to stop typing
 * 		Type: Number, Range: 0 - 1200, Default: 120
 */
( function( $ ) {

$.suggestions = {
	/**
	 * Cancel any delayed updateSuggestions() call and inform the user so
	 * they can cancel their result fetching if they use AJAX or something
	 */
	cancel: function( context ) {
		if ( context.data.timerID != null ) {
			clearTimeout( context.data.timerID );
		}
		if ( typeof context.config.cancel == 'function' ) {
			context.config.cancel.call( context.data.$textbox );
		}
	},
	/**
	 * Restore the text the user originally typed in the textbox, before it was overwritten by highlight(). This
	 * restores the value the currently displayed suggestions are based on, rather than the value just before
	 * highlight() overwrote it; the former is arguably slightly more sensible.
	 */
	restore: function( context ) {
		context.data.$textbox.val( context.data.prevText );
	},
	/**
	 * Ask the user-specified callback for new suggestions. Any previous delayed call to this function still pending
	 * will be canceled.  If the value in the textbox hasn't changed since the last time suggestions were fetched, this
	 * function does nothing.
	 * @param {Boolean} delayed Whether or not to delay this by the currently configured amount of time
	 */
	update: function( context, delayed ) {
		// Only fetch if the value in the textbox changed
		function maybeFetch() {
			if ( context.data.$textbox.val() !== context.data.prevText ) {
				context.data.prevText = context.data.$textbox.val();
				if ( typeof context.config.fetch == 'function' ) {
					context.config.fetch.call( context.data.$textbox, context.data.$textbox.val() );
				}
			}
		}
		// Cancel previous call
		if ( context.data.timerID != null ) {
			clearTimeout( context.data.timerID );
		}
		if ( delayed ) {
			// Start a new asynchronous call
			context.data.timerID = setTimeout( maybeFetch, context.config.delay );
		} else {
			maybeFetch();
		}
		$.suggestions.special( context );
	},
	special: function( context ) {
		// Allow custom rendering - but otherwise don't do any rendering
		if ( typeof context.config.special.render == 'function' ) {
			// Wait for the browser to update the value
			setTimeout( function() {
				// Render special
				$special = context.data.$container.find( '.suggestions-special' );
				context.config.special.render.call( $special, context.data.$textbox.val() );
			}, 1 );
		}
	},
	/**
	 * Sets the value of a property, and updates the widget accordingly
	 * @param {String} property Name of property
	 * @param {Mixed} value Value to set property with
	 */
	configure: function( context, property, value ) {
		// Validate creation using fallback values
		switch( property ) {
			case 'fetch':
			case 'cancel':
			case 'special':
			case 'result':
			case '$region':
				context.config[property] = value;
				break;
			case 'suggestions':
				context.config[property] = value;
				// Update suggestions
				if ( typeof context.data !== 'undefined'  ) {
					if ( typeof context.config.suggestions == 'undefined' ||
							context.config.suggestions.length == 0 ) {
						// Hide the div when no suggestion exist
						context.data.$container.hide();
					} else {
						// Rebuild the suggestions list
						context.data.$container.show();
						// Update the size and position of the list
						context.data.$container.css( {
							'top': context.config.$region.offset().top + context.config.$region.outerHeight(),
							'bottom': 'auto',
							'width': context.config.$region.outerWidth(),
							'height': 'auto',
							'left': context.config.$region.offset().left,
							'right': 'auto'
						} );
						var $results = context.data.$container.children( '.suggestions-results' );
						$results.empty();
						for ( var i = 0; i < context.config.suggestions.length; i++ ) {
							$result = $( '<div />' )
								.addClass( 'suggestions-result' )
								.attr( 'rel', i )
								.data( 'text', context.config.suggestions[i] )
								.appendTo( $results );
							// Allow custom rendering
							if ( typeof context.config.result.render == 'function' ) {
								context.config.result.render.call( $result, context.config.suggestions[i] );
							} else {
								$result.text( context.config.suggestions[i] ).autoEllipsis();
							}
						}
					}
				}
				break;
			case 'maxRows':
				context.config[property] = Math.max( 1, Math.min( 100, value ) );
				break;
			case 'delay':
				context.config[property] = Math.max( 0, Math.min( 1200, value ) );
				break;
			case 'submitOnClick':
				context.config[property] = value ? true : false;
				break;
		}
	},
	/**
	 * Highlight a result in the results table
	 * @param result <tr> to highlight: jQuery object, or 'prev' or 'next'
	 * @param updateTextbox If true, put the suggestion in the textbox
	 */
	highlight: function( context, result, updateTextbox ) {
		var selected = context.data.$container.find( '.suggestions-result-current' );
		if ( !result.get || selected.get( 0 ) != result.get( 0 ) ) {
			if ( result == 'prev' ) {
				result = selected.prev();
			} else if ( result == 'next' ) {
				if ( selected.size() == 0 )
					// No item selected, go to the first one
					result = context.data.$container.find( '.suggestions-results div:first' );
				else {
					result = selected.next();
					if ( result.size() == 0 )
						// We were at the last item, stay there
						result = selected;
				}
			}
			selected.removeClass( 'suggestions-result-current' );
			result.addClass( 'suggestions-result-current' );
		}
		if ( updateTextbox ) {
			if ( result.size() == 0 ) {
				$.suggestions.restore( context );
			} else {
				context.data.$textbox.val( result.data( 'text' ) );
				
				// .val() doesn't call any event handlers, so
				// let the world know what happened
				context.data.$textbox.change();
			}
		}
		$.suggestions.special( context );
	},
	/**
	 * Respond to keypress event
	 * @param {Integer} key Code of key pressed
	 */
	keypress: function( e, context, key ) {
		var wasVisible = context.data.$container.is( ':visible' );
		var preventDefault = false;
		switch ( key ) {
			// Arrow down
			case 40:
				if ( wasVisible ) {
					$.suggestions.highlight( context, 'next', true );
				} else {
					$.suggestions.update( context, false );
				}
				context.data.$textbox.trigger( 'change' );
				preventDefault = true;
				break;
			// Arrow up
			case 38:
				if ( wasVisible ) {
					$.suggestions.highlight( context, 'prev', true );
				}
				context.data.$textbox.trigger( 'change' );
				preventDefault = wasVisible;
				break;
			// Escape
			case 27:
				context.data.$container.hide();
				$.suggestions.restore( context );
				$.suggestions.cancel( context );
				context.data.$textbox.trigger( 'change' );
				preventDefault = wasVisible;
				break;
			// Enter
			case 13:
				context.data.$container.hide();
				preventDefault = wasVisible;
				if ( typeof context.config.result.select == 'function' ) {
					context.config.result.select.call(
						context.data.$container.find( '.suggestions-result-current' ),
						context.data.$textbox
					);
				}
				break;
			default:
				$.suggestions.update( context, true );
				break;
		}
		if ( preventDefault ) {
			e.preventDefault();
			e.stopImmediatePropagation();
		}
	}
};
$.fn.suggestions = function() {
	
	// Multi-context fields
	var returnValue = null;
	var args = arguments;
	
	$(this).each( function() {

		/* Construction / Loading */
		
		var context = $(this).data( 'suggestions-context' );
		if ( typeof context == 'undefined' ) {
			context = {
				config: {
				    'fetch' : function() {},
					'cancel': function() {},
					'special': {},
					'result': {},
					'$region': $(this),
					'suggestions': [],
					'maxRows': 7,
					'delay': 120,
					'submitOnClick': false
				}
			};
		}
		
		/* API */
		
		// Handle various calling styles
		if ( args.length > 0 ) {
			if ( typeof args[0] == 'object' ) {
				// Apply set of properties
				for ( var key in args[0] ) {
					$.suggestions.configure( context, key, args[0][key] );
				}
			} else if ( typeof args[0] == 'string' ) {
				if ( args.length > 1 ) {
					// Set property values
					$.suggestions.configure( context, args[0], args[1] );
				} else if ( returnValue == null ) {
					// Get property values, but don't give access to internal data - returns only the first
					returnValue = ( args[0] in context.config ? undefined : context.config[args[0]] );
				}
			}
		}
		
		/* Initialization */
		
		if ( typeof context.data == 'undefined' ) {
			context.data = {
				// ID of running timer
				'timerID': null,
				// Text in textbox when suggestions were last fetched
				'prevText': null,
				// Number of results visible without scrolling
				'visibleResults': 0,
				// Suggestion the last mousedown event occured on
				'mouseDownOn': $( [] ),
				'$textbox': $(this)
			};
			context.data.$container = $( '<div />' )
				.css( {
					'top': Math.round( context.data.$textbox.offset().top + context.data.$textbox.outerHeight() ),
					'left': Math.round( context.data.$textbox.offset().left ),
					'width': context.data.$textbox.outerWidth(),
					'display': 'none'
				} )
				.mouseover( function( e ) {
					$.suggestions.highlight( context, $( e.target ).closest( '.suggestions-results div' ), false );
				} )
				.addClass( 'suggestions' )
				.append(
					$( '<div />' ).addClass( 'suggestions-results' )
						// Can't use click() because the container div is hidden when the textbox loses focus. Instead,
						// listen for a mousedown followed by a mouseup on the same div
						.mousedown( function( e ) {
							context.data.mouseDownOn = $( e.target ).closest( '.suggestions-results div' );
						} )
						.mouseup( function( e ) {
							var $result = $( e.target ).closest( '.suggestions-results div' );
							var $other = context.data.mouseDownOn;
							context.data.mouseDownOn = $( [] );
							if ( $result.get( 0 ) != $other.get( 0 ) ) {
								return;
							}
							$.suggestions.highlight( context, $result, true );
							context.data.$container.hide();
							if ( typeof context.config.result.select == 'function' ) {
								context.config.result.select.call( $result, context.data.$textbox );
							}
							context.data.$textbox.focus();
						} )
				)
				.append(
					$( '<div />' ).addClass( 'suggestions-special' )
						// Can't use click() because the container div is hidden when the textbox loses focus. Instead,
						// listen for a mousedown followed by a mouseup on the same div
						.mousedown( function( e ) {
							context.data.mouseDownOn = $( e.target ).closest( '.suggestions-special' );
						} )
						.mouseup( function( e ) {
							var $special = $( e.target ).closest( '.suggestions-special' );
							var $other = context.data.mouseDownOn;
							context.data.mouseDownOn = $( [] );
							if ( $special.get( 0 ) != $other.get( 0 ) ) {
								return;
							}
							context.data.$container.hide();
							if ( typeof context.config.special.select == 'function' ) {
								context.config.special.select.call( $special, context.data.$textbox );
							}
							context.data.$textbox.focus();
						} )
				)
				.appendTo( $( 'body' ) );
			$(this)
				// Stop browser autocomplete from interfering
				.attr( 'autocomplete', 'off')
				.keydown( function( e ) {
					// Store key pressed to handle later
					context.data.keypressed = ( e.keyCode == undefined ) ? e.which : e.keyCode;
					context.data.keypressedCount = 0;
					
					switch ( context.data.keypressed ) {
						// This preventDefault logic is duplicated from
						// $.suggestions.keypress(), which sucks
						case 40:
							e.preventDefault();
							e.stopImmediatePropagation();
							break;
						case 38:
						case 27:
						case 13:
							if ( context.data.$container.is( ':visible' ) ) {
								e.preventDefault();
								e.stopImmediatePropagation();
							}
					}
				} )
				.keypress( function( e ) {
					context.data.keypressedCount++;
					$.suggestions.keypress( e, context, context.data.keypressed );
				} )
				.keyup( function( e ) {
					// Some browsers won't throw keypress() for arrow keys. If we got a keydown and a keyup without a
					// keypress in between, solve it
					if ( context.data.keypressedCount == 0 ) {
						$.suggestions.keypress( e, context, context.data.keypressed );
					}
				} )
				.blur( function() {
					// When losing focus because of a mousedown
					// on a suggestion, don't hide the suggestions
					if ( context.data.mouseDownOn.size() > 0 ) {
						return;
					}
					context.data.$container.hide();
					$.suggestions.cancel( context );
				} );
		}
		// Store the context for next time
		$(this).data( 'suggestions-context', context );
	} );
	return returnValue !== null ? returnValue : $(this);
};

} )( jQuery );
/**
 * These plugins provide extra functionality for interaction with textareas.
 */
( function( $ ) {
$.fn.textSelection = function( command, options ) {
var fn = {
/**
 * Get the contents of the textarea
 */
getContents: function() {
	return this.val();
},
/**
 * Get the currently selected text in this textarea. Will focus the textarea
 * in some browsers (IE/Opera)
 */
getSelection: function() {
	var e = this.get( 0 );
	var retval = '';
	if ( $(e).is( ':hidden' ) ) {
		// Do nothing
	} else if ( document.selection && document.selection.createRange ) {
		e.focus();
		var range = document.selection.createRange();
		retval = range.text;
	} else if ( e.selectionStart || e.selectionStart == '0' ) {
		retval = e.value.substring( e.selectionStart, e.selectionEnd );
	}
	return retval;
},
/**
 * Ported from skins/common/edit.js by Trevor Parscal
 * (c) 2009 Wikimedia Foundation (GPLv2) - http://www.wikimedia.org
 *
 * Inserts text at the begining and end of a text selection, optionally
 * inserting text at the caret when selection is empty.
 */
encapsulateSelection: function( options ) {
	return this.each( function() {
		/**
		 * Check if the selected text is the same as the insert text
		 */
		function checkSelectedText() {
			if ( !selText ) {
				selText = options.peri;
				isSample = true;
			} else if ( options.replace ) {
				selText = options.peri;
			} else if ( selText.charAt( selText.length - 1 ) == ' ' ) {
				// Exclude ending space char
				selText = selText.substring(0, selText.length - 1);
				options.post += ' ';
			}
		}
		var selText = $(this).textSelection( 'getSelection' );
		var isSample = false;
		if ( this.style.display == 'none' ) {
			// Do nothing
		} else if ( this.selectionStart || this.selectionStart == '0' ) {
			// Mozilla/Opera
			$(this).focus();
			var startPos = this.selectionStart;
			var endPos = this.selectionEnd;
			checkSelectedText();
			if ( options.ownline ) {
				if ( startPos != 0 && this.value.charAt( startPos - 1 ) != "\n" ) {
					options.pre = "\n" + options.pre;
				}
				if ( this.value.charAt( endPos ) != "\n" ) {
					options.post += "\n";
				}
			}
			this.value = this.value.substring( 0, startPos ) + options.pre + selText + options.post +
				this.value.substring( endPos, this.value.length );
			if ( window.opera ) {
				options.pre = options.pre.replace( /\r?\n/g, "\r\n" );
				selText = selText.replace( /\r?\n/g, "\r\n" );
				options.post = options.post.replace( /\r?\n/g, "\r\n" );
			}
			if ( isSample ) {
				this.selectionStart = startPos + options.pre.length;
				this.selectionEnd = startPos + options.pre.length + selText.length;
			} else {
				this.selectionStart = startPos + options.pre.length + selText.length +
					options.post.length;
				this.selectionEnd = this.selectionStart;
			}
		} else if ( document.selection && document.selection.createRange ) {
			// IE
			$(this).focus();
			var range = document.selection.createRange();
			if ( options.ownline && range.moveStart ) {
				var range2 = document.selection.createRange();
				range2.collapse();
				range2.moveStart( 'character', -1 );
				// FIXME: Which check is correct?
				if ( range2.text != "\r" && range2.text != "\n" && range2.text != "" ) {
					options.pre = "\n" + options.pre;
				}
				var range3 = document.selection.createRange();
				range3.collapse( false );
				range3.moveEnd( 'character', 1 );
				if ( range3.text != "\r" && range3.text != "\n" && range3.text != "" ) {
					options.post += "\n";
				}
			}
			checkSelectedText();
			range.text = options.pre + selText + options.post;
			if ( isSample && range.moveStart ) {
				range.moveStart( 'character', - options.post.length - selText.length );
				range.moveEnd( 'character', - options.post.length );
			}
			range.select();
		}
		// Scroll the textarea to the inserted text
		$(this).textSelection( 'scrollToCaretPosition' );
		$(this).trigger( 'encapsulateSelection', [ options.pre, options.peri, options.post, options.ownline,
			options.replace ] );
	});
},
/**
 * Ported from Wikia's LinkSuggest extension
 * https://svn.wikia-code.com/wikia/trunk/extensions/wikia/LinkSuggest
 * Some code copied from
 * http://www.dedestruct.com/2008/03/22/howto-cross-browser-cursor-position-in-textareas/
 *
 * Get the position (in resolution of bytes not nessecarily characters)
 * in a textarea
 */
 getCaretPosition: function( options ) {
	function getCaret( e ) {
		var caretPos = 0, endPos = 0;
		if ( $.browser.msie ) {
			// IE Support
			var postFinished = false;
			var periFinished = false;
			var postFinished = false;
			var preText, rawPreText, periText;
			var rawPeriText, postText, rawPostText;
			// Create range containing text in the selection
			var periRange = document.selection.createRange().duplicate();
			// Create range containing text before the selection
			var preRange = document.body.createTextRange();
			// Select all the text
			preRange.moveToElementText(e);
			// Move the end where we need it
			preRange.setEndPoint("EndToStart", periRange);
			// Create range containing text after the selection
			var postRange = document.body.createTextRange();
			// Select all the text
			postRange.moveToElementText(e);
			// Move the start where we need it
			postRange.setEndPoint("StartToEnd", periRange);
			// Load the text values we need to compare
			preText = rawPreText = preRange.text;
			periText = rawPeriText = periRange.text;
			postText = rawPostText = postRange.text;
			/*
			 * Check each range for trimmed newlines by shrinking the range by 1
			 * character and seeing if the text property has changed. If it has
			 * not changed then we know that IE has trimmed a \r\n from the end.
			 */
			do {
				if ( !postFinished ) {
					if ( preRange.compareEndPoints( "StartToEnd", preRange ) == 0 ) {
						postFinished = true;
					} else {
						preRange.moveEnd( "character", -1 )
						if ( preRange.text == preText ) {
							rawPreText += "\r\n";
						} else {
							postFinished = true;
						}
					}
				}
				if ( !periFinished ) {
					if ( periRange.compareEndPoints( "StartToEnd", periRange ) == 0 ) {
						periFinished = true;
					} else {
						periRange.moveEnd( "character", -1 )
						if ( periRange.text == periText ) {
							rawPeriText += "\r\n";
						} else {
							periFinished = true;
						}
					}
				}
				if ( !postFinished ) {
					if ( postRange.compareEndPoints("StartToEnd", postRange) == 0 ) {
						postFinished = true;
					} else {
						postRange.moveEnd( "character", -1 )
						if ( postRange.text == postText ) {
							rawPostText += "\r\n";
						} else {
							postFinished = true;
						}
					}
				}
			} while ( ( !postFinished || !periFinished || !postFinished ) );
			caretPos = rawPreText.replace( /\r\n/g, "\n" ).length;
			endPos = caretPos + rawPeriText.replace( /\r\n/g, "\n" ).length;
		} else if ( e.selectionStart || e.selectionStart == '0' ) {
			// Firefox support
			caretPos = e.selectionStart;
			endPos = e.selectionEnd;
		}
		return options.startAndEnd ? [ caretPos, endPos ] : caretPos;
	}
	return getCaret( this.get( 0 ) );
},
setSelection: function( options ) {
	return this.each( function() {
		if ( $(this).is( ':hidden' ) ) {
			// Do nothing
		} else if ( this.selectionStart || this.selectionStart == '0' ) {
			// Opera 9.0 doesn't allow setting selectionStart past
			// selectionEnd; any attempts to do that will be ignored
			// Make sure to set them in the right order
			if ( options.start > this.selectionEnd ) {
				this.selectionEnd = options.end;
				this.selectionStart = options.start;
			} else {
				this.selectionStart = options.start;
				this.selectionEnd = options.end;
			}
		} else if ( document.body.createTextRange ) {
			var selection = document.body.createTextRange();
			selection.moveToElementText( this );
			var length = selection.text.length;
			selection.moveStart( 'character', options.start );
			selection.moveEnd( 'character', -length + options.end );
			selection.select();
		}
	});
},
/**
 * Ported from Wikia's LinkSuggest extension
 * https://svn.wikia-code.com/wikia/trunk/extensions/wikia/LinkSuggest
 *
 * Scroll a textarea to the current cursor position. You can set the cursor
 * position with setSelection()
 * @param force boolean Whether to force a scroll even if the caret position
 *  is already visible. Defaults to false
 */
scrollToCaretPosition: function( options ) {
	function getLineLength( e ) {
		return Math.floor( e.scrollWidth / ( $.os.name == 'linux' ? 7 : 8 ) );
	}
	function getCaretScrollPosition( e ) {
		// FIXME: This functions sucks and is off by a few lines most
		// of the time. It should be replaced by something decent.
		var text = e.value.replace( /\r/g, "" );
		var caret = $( e ).textSelection( 'getCaretPosition' );
		var lineLength = getLineLength( e );
		var row = 0;
		var charInLine = 0;
		var lastSpaceInLine = 0;
		for ( i = 0; i < caret; i++ ) {
			charInLine++;
			if ( text.charAt( i ) == " " ) {
				lastSpaceInLine = charInLine;
			} else if ( text.charAt( i ) == "\n" ) {
				lastSpaceInLine = 0;
				charInLine = 0;
				row++;
			}
			if ( charInLine > lineLength ) {
				if ( lastSpaceInLine > 0 ) {
					charInLine = charInLine - lastSpaceInLine;
					lastSpaceInLine = 0;
					row++;
				}
			}
		}
		var nextSpace = 0;
		for ( j = caret; j < caret + lineLength; j++ ) {
			if (
				text.charAt( j ) == " " ||
				text.charAt( j ) == "\n" ||
				caret == text.length
			) {
				nextSpace = j;
				break;
			}
		}
		if ( nextSpace > lineLength && caret <= lineLength ) {
			charInLine = caret - lastSpaceInLine;
			row++;
		}
		return ( $.os.name == 'mac' ? 13 : ( $.os.name == 'linux' ? 15 : 16 ) ) * row;
	}
	return this.each(function() {
		if ( $(this).is( ':hidden' ) ) {
			// Do nothing
		} else if ( this.selectionStart || this.selectionStart == '0' ) {
			// Mozilla
			var scroll = getCaretScrollPosition( this );
			if ( options.force || scroll < $(this).scrollTop() ||
					scroll > $(this).scrollTop() + $(this).height() )
				$(this).scrollTop( scroll );
		} else if ( document.selection && document.selection.createRange ) {
			// IE / Opera
			/*
			 * IE automatically scrolls the selected text to the
			 * bottom of the textarea at range.select() time, except
			 * if it was already in view and the cursor position
			 * wasn't changed, in which case it does nothing. To
			 * cover that case, we'll force it to act by moving one
			 * character back and forth.
			 */
			var range = document.selection.createRange();
			var pos = $(this).textSelection( 'getCaretPosition' );
			var oldScrollTop = this.scrollTop;
			range.moveToElementText( this );
			range.collapse();
			range.move( 'character', pos + 1);
			range.select();
			if ( this.scrollTop != oldScrollTop )
				this.scrollTop += range.offsetTop;
			else if ( options.force ) {
				range.move( 'character', -1 );
				range.select();
			}
		}
		$(this).trigger( 'scrollToPosition' );
	} );
}
};
	// Apply defaults
	switch ( command ) {
		//case 'getContents': // no params
		//case 'setContents': // no params with defaults
		//case 'getSelection': // no params
		case 'encapsulateSelection':
			options = $.extend( {
				'pre': '', // Text to insert before the cursor/selection
				'peri': '', // Text to insert between pre and post and select afterwards
				'post': '', // Text to insert after the cursor/selection
				'ownline': false, // Put the inserted text on a line of its own
				'replace': false // If there is a selection, replace it with peri instead of leaving it alone
			}, options );
			break;
		case 'getCaretPosition':
			options = $.extend( {
				'startAndEnd': false // Return [start, end] instead of just start
			}, options );
			// FIXME: We may not need character position-based functions if we insert markers in the right places
			break;
		case 'setSelection':
			options = $.extend( {
				'start': undefined, // Position to start selection at
				'end': undefined, // Position to end selection at. Defaults to start
				'startContainer': undefined, // Element to start selection in (iframe only)
				'endContainer': undefined // Element to end selection in (iframe only). Defaults to startContainer
			}, options );
			if ( options.end === undefined )
				options.end = options.start;
			if ( options.endContainer == undefined )
				options.endContainer = options.startContainer;
			// FIXME: We may not need character position-based functions if we insert markers in the right places
			break;
		case 'scrollToCaretPosition':
			options = $.extend( {
				'force': false // Force a scroll even if the caret position is already visible
			}, options );
			break;
	}
	var context = $(this).data( 'wikiEditor-context' );
	var hasIframe = context !== undefined && context.$iframe !== undefined;
	
	// IE selection restore voodoo
	var needSave = false;
	if ( hasIframe && context.savedSelection !== null ) {
		context.fn.restoreSelection();
		needSave = true;
	}
	retval = ( hasIframe ? context.fn : fn )[command].call( this, options );
	if ( hasIframe && needSave ) {
		context.fn.saveSelection();
	}
	return retval;
};

} )( jQuery );/**
 * This plugin provides a way to build a wiki-text editing user interface around a textarea.
 * 
 * @example To intialize without any modules:
 * 		$j( 'div#edittoolbar' ).wikiEditor();
 * 
 * @example To initialize with one or more modules, or to add modules after it's already been initialized:
 * 		$j( 'textarea#wpTextbox1' ).wikiEditor( 'addModule', 'toolbar', { ... config ... } );
 * 
 */
( function( $ ) {

/**
 * Global static object for wikiEditor that provides generally useful functionality to all modules and contexts.
 */
$.wikiEditor = {
	/**
	 * For each module that is loaded, static code shared by all instances is loaded into this object organized by
	 * module name. The existance of a module in this object only indicates the module is available. To check if a
	 * module is in use by a specific context check the context.modules object.
	 */
	'modules': {},
	/**
	 * In some cases like with the iframe's HTML file, it's convienent to have a lookup table of all instances of the
	 * WikiEditor. Each context contains an instance field which contains a key that corrosponds to a reference to the
	 * textarea which the WikiEditor was build around. This way, by passing a simple integer you can provide a way back
	 * to a specific context.
	 */
	'instances': [],
	/**
	 * For each browser name, an array of conditions that must be met are supplied in [operaton, value]-form where
	 * operation is a string containing a JavaScript compatible binary operator and value is either a number to be
	 * compared with $.browser.versionNumber or a string to be compared with $.browser.version. If a browser is not
	 * specifically mentioned, we just assume things will work.
	 */
	'browsers': {
		// Left-to-right languages
		'ltr': {
			// The toolbar layout is broken in IE6
			'msie': [['>=', 7]],
			// Layout issues in FF < 2
			'firefox': [['>=', 2]],
			// Text selection bugs galore - this may be a different situation with the new iframe-based solution
			'opera': [['>=', 9.6]],
			// jQuery minimums
			'safari': [['>=', 3]],
			'chrome': [['>=', 3]]
		},
		// Right-to-left languages
		'rtl': {
			// The toolbar layout is broken in IE 7 in RTL mode, and IE6 in any mode
			'msie': [['>=', 8]],
			// Layout issues in FF < 2
			'firefox': [['>=', 2]],
			// Text selection bugs galore - this may be a different situation with the new iframe-based solution
			'opera': [['>=', 9.6]],
			// jQuery minimums
			'safari': [['>=', 3]],
			'chrome': [['>=', 3]]
		}
	},
	/**
	 * Path to images - this is a bit messy, and it would need to change if this code (and images) gets moved into the
	 * core - or anywhere for that matter...
	 */
	'imgPath' : wgScriptPath + '/extensions/UsabilityInitiative/images/wikiEditor/',
	/**
	 * Checks the current browser against the browsers object to determine if the browser has been black-listed or not.
	 * Because these rules are often very complex, the object contains configurable operators and can check against
	 * either the browser version number or string. This process also involves checking if the current browser is amung
	 * those which we have configured as compatible or not. If the browser was not configured as comptible we just go on
	 * assuming things will work - the argument here is to prevent the need to update the code when a new browser comes
	 * to market. The assumption here is that any new browser will be built on an existing engine or be otherwise so
	 * similar to another existing browser that things actually do work as expected. The merrits of this argument, which
	 * is essentially to blacklist rather than whitelist are debateable, but at this point we've decided it's the more
	 * "open-web" way to go.
	 */
	'isSupported': function( module ) {
		// Check for and make use of cached value and early opportunities to bail
		if ( module ) {
			// If the module doesn't exist, it's clearly not supported
			if ( typeof $.wikiEditor.modules[module] == 'undefined' ) {
				return false;
			} else if ( typeof $.wikiEditor.modules[module].supported !== 'undefined' ) {
				// Cache hit
				return $.wikiEditor.modules[module].supported;
			}
		} else {
			if ( typeof $.wikiEditor.supported !== 'undefined' ) {
				// Cache hit
				return $.wikiEditor.supported;
			}
		}
		// Provide quick way to cache support
		function cacheSupport( value ) {
			return module ? $.wikiEditor.modules[module].supported = value : $.wikiEditor.supported = value;
		}
		// Fallback to the wikiEditor browser map if no special map is provided in the module
		var map = module && 'browsers' in $.wikiEditor.modules[module] ?
				$.wikiEditor.modules[module].browsers : $.wikiEditor.browsers;
		// Check if we have any compatiblity information on-hand for the current browser
		if ( !( $.browser.name in map[$( 'body' ).is( '.rtl' ) ? 'rtl' : 'ltr'] ) ) {
			// Assume good faith :) 
			return cacheSupport( true );
		}
		// Check over each browser condition to determine if we are running in a compatible client
		var browser = map[$( 'body' ).is( '.rtl' ) ? 'rtl' : 'ltr'][$.browser.name];
		for ( var condition in browser ) {
			var op = browser[condition][0];
			var val = browser[condition][1];
			if ( typeof val == 'string' ) {
				if ( !( eval( '$.browser.version' + op + '"' + val + '"' ) ) ) {
					return cacheSupport( false );
				}
			} else if ( typeof val == 'number' ) {
				if ( !( eval( '$.browser.versionNumber' + op + val ) ) ) {
					return cacheSupport( false );
				}
			}
		}
		// Return and also cache the return value - this will be checked somewhat often
		return cacheSupport( true );
	},
	/**
	 * Checks if a module has a specific requirement
	 */
	'isRequired': function( module, requirement ) {
		if ( typeof $.wikiEditor.modules[module]['req'] !== 'undefined' ) {
			for ( req in $.wikiEditor.modules[module]['req'] ) {
				if ( $.wikiEditor.modules[module]['req'][req] == requirement ) {
					return true;
				}
			}
		}
		return false;
	},
	/**
	 * Provides a way to extract messages from objects. Wraps the mw.usability.getMsg() function, which
	 * may eventually become a wrapper for some kind of core MW functionality.
	 * 
	 * @param object Object to extract messages from
	 * @param property String of name of property which contains the message. This should be the base name of the
	 * property, which means that in the case of the object { this: 'that', fooMsg: 'bar' }, passing property as 'this'
	 * would return the raw text 'that', while passing property as 'foo' would return the internationalized message
	 * with the key 'bar'.
	 */
	'autoMsg': function( object, property ) {
		// Accept array of possible properties, of which the first one found will be used
		if ( typeof property == 'object' ) {
			for ( var i in property ) {
				if ( property[i] in object || property[i] + 'Msg' in object ) {
					property = property[i];
					break;
				}
			}
		}
		if ( property in object ) {
			return object[property];
		} else if ( property + 'Msg' in object ) {
			if ( typeof object[property + 'Msg' ] == 'object' ) {
				// [ messageKey, arg1, arg2, ... ]
				return mw.usability.getMsg.apply( mw.usability, object[property + 'Msg' ] );
			} else {
				return mw.usability.getMsg( object[property + 'Msg'] );
			}
		} else {
			return '';
		}
	},
	/**
	 * Provieds a way to extract a property of an object in a certain language, falling back on the property keyed as
	 * 'default'. If such key doesn't exist, the object itself is considered the actual value, which should ideally
	 * be the case so that you may use a string or object of any number of strings keyed by language with a default.
	 * 
	 * @param object Object to extract property from
	 * @param lang Language code, defaults to wgUserLanguage
	 */
	'autoLang': function( object, lang ) {
		return object[lang || wgUserLanguage] || object['default'] || object;
	},
	/**
	 * Provieds a way to extract the path of an icon in a certain language, automatically appending a version number for
	 * caching purposes and prepending an image path when icon paths are relative.
	 * 
	 * @param icon Icon object from e.g. toolbar config
	 * @param path Default icon path, defaults to $.wikiEditor.imgPath
	 * @param lang Language code, defaults to wgUserLanguage
	 */
	'autoIcon': function( icon, path, lang ) {
		var src = $.wikiEditor.autoLang( icon, lang );
		path = path || $.wikiEditor.imgPath;
		// Prepend path if src is not absolute
		if ( src.substr( 0, 7 ) != 'http://' && src.substr( 0, 8 ) != 'https://' && src[0] != '/' ) {
			src = path + src;
		}
		return src + '?' + wgWikiEditorIconVersion;
	}
};

/**
 * jQuery plugin that provides a way to initialize a wikiEditor instance on a textarea.
 */
$.fn.wikiEditor = function() {

// Skip any further work when running in browsers that are unsupported
if ( !$j.wikiEditor.isSupported() ) {
	return $(this);
}

/* Initialization */

// The wikiEditor context is stored in the element's data, so when this function gets called again we can pick up right
// where we left off
var context = $(this).data( 'wikiEditor-context' );
// On first call, we need to set things up, but on all following calls we can skip right to the API handling
if ( typeof context == 'undefined' ) {
	
	// Star filling the context with useful data - any jQuery selections, as usual should be named with a preceding $
	context = {
		// Reference to the textarea element which the wikiEditor is being built around
		'$textarea': $(this),
		// Container for any number of mutually exclusive views that are accessible by tabs
		'views': {},
		// Container for any number of module-specific data - only including data for modules in use on this context
		'modules': {},
		// General place to shouve bits of data into
		'data': {},
		// Unique numeric ID of this instance used both for looking up and differentiating instances of wikiEditor
		'instance': $.wikiEditor.instances.push( $(this) ) - 1,
		// Array mapping elements in the textarea to character offsets
		'offsets': null,
		// Cache for context.fn.htmlToText()
		'htmlToTextMap': {},
		// The previous HTML of the iframe, stored to detect whether something really changed.
		'oldHTML': null,
		// Same for delayedChange()
		'oldDelayedHTML': null,
		// The previous selection of the iframe, stored to detect whether the selection has changed
		'oldDelayedSel': null,
		// Saved selection state for IE
		'savedSelection': null,
		// Stack of states in { html: [string] } form
		'history': [],
		// Current history state position - this is number of steps backwards, so it's always -1 or less
		'historyPosition': -1,
		/// The previous historyPosition, stored to detect if change events were due to an undo or redo action
		'oldDelayedHistoryPosition': -1
	};
	
	/*
	 * Externally Accessible API
	 * 
	 * These are available using calls to $j(selection).wikiEditor( call, data ) where selection is a jQuery selection
	 * of the textarea that the wikiEditor instance was built around.
	 */
	
	context.api = {
		/**
		 * Activates a module on a specific context with optional configuration data.
		 * 
		 * @param data Either a string of the name of a module to add without any additional configuration parameters,
		 * or an object with members keyed with module names and valued with configuration objects.
		 */
		'addModule': function( context, data ) {
			var modules = {};
			if ( typeof data == 'string' ) {
				modules[data] = {};
			} else if ( typeof data == 'object' ) {
				modules = data;
			}
			for ( var module in modules ) {
				// Check for the existance of an available / supported module with a matching name and a create function
				if ( typeof module == 'string' && $.wikiEditor.isSupported( module ) ) {
					// Extend the context's core API with this module's own API calls
					if ( 'api' in $.wikiEditor.modules[module] ) {
						for ( var call in $.wikiEditor.modules[module].api ) {
							// Modules may not overwrite existing API functions - first come, first serve
							if ( !( call in context.api ) ) {
								context.api[call] = $.wikiEditor.modules[module].api[call];
							}
						}
					}
					// Activate the module on this context
					if ( 'fn' in $.wikiEditor.modules[module] && 'create' in $.wikiEditor.modules[module].fn ) {
						// Add a place for the module to put it's own stuff
						context.modules[module] = {};
						// Tell the module to create itself on the context
						$.wikiEditor.modules[module].fn.create( context, modules[module] );
					}
				}
			}
		}
	};
	
	/* 
	 * Event Handlers
	 * 
	 * These act as filters returning false if the event should be ignored or returning true if it should be passed
	 * on to all modules. This is also where we can attach some extra information to the events.
	 */
	
	context.evt = {
		/**
		 * Filters change events, which occur when the user interacts with the contents of the iframe. The goal of this
		 * function is to both classify the scope of changes as 'division' or 'character' and to prevent further
		 * processing of events which did not actually change the content of the iframe.
		 */
		'keydown': function( event ) {
			switch ( event.which ) {
				case 90: // z
				case 89: // y
					if ( event.which == 89 && !$.browser.msie ) { 
						// only handle y events for IE
						return true;
					} else if ( ( event.ctrlKey || event.metaKey ) && context.history.length ) {
						// HistoryPosition is a negative number between -1 and -context.history.length, in other words
						// it's the number of steps backwards from the latest state.
						var newPosition;
						if ( event.shiftKey || event.which == 89 ) {
							// Redo
							newPosition = context.historyPosition + 1;
						} else {
							// Undo
							newPosition = context.historyPosition - 1;
						}
						// Only act if we are switching to a valid state
						if ( newPosition >= ( context.history.length * -1 ) && newPosition < 0 ) {
							// Make sure we run the history storing code before we make this change
							context.fn.updateHistory( context.oldDelayedHTML != context.$content.html() );
							context.oldDelayedHistoryPosition = context.historyPosition;
							context.historyPosition = newPosition;
							// Change state
							// FIXME: Destroys event handlers, will be a problem with template folding
							context.$content.html(
								context.history[context.history.length + context.historyPosition].html
							);
							context.fn.purgeOffsets();
							if( context.history[context.history.length + context.historyPosition].sel ) {
								context.fn.setSelection( { 
									start: context.history[context.history.length + context.historyPosition].sel[0],
									end: context.history[context.history.length + context.historyPosition].sel[1]
								} );
							}
						}
						// Prevent the browser from jumping in and doing its stuff
						return false;
					}
					break;
					// Intercept all tab events to provide consisten behavior across browsers
					// Webkit browsers insert tab characters by default into the iframe rather than changing input focus
				case 9: //tab
						// if any modifier keys are pressed, allow the browser to do it's thing
						if ( event.ctrlKey || event.altKey || event.shiftKey ) { 
							return true;
						} else {
							var $tabindexList = $j( '[tabindex]:visible' ).sort( function( a, b ) {
								return a.tabIndex - b.tabIndex;
							} );
							for( var i=0; i < $tabindexList.length; i++ ) {
								if( $tabindexList.eq( i ).attr('id') == context.$iframe.attr( 'id' ) ) {
									$tabindexList.get( i + 1 ).focus();
									break;
								}
							}
							return false;
						}
					break;
				 case 86: //v
					 if ( event.ctrlKey ){
						 //paste, intercepted for IE
						 context.evt.paste( event );
					 }
					 break;
			}
			return true;
		},
		'change': function( event ) {
			event.data.scope = 'division';
			var newHTML = context.$content.html();
			if ( context.oldHTML != newHTML ) {
				context.fn.purgeOffsets();
				context.oldHTML = newHTML;
				event.data.scope = 'realchange';
			}
			// Are we deleting a <p> with one keystroke? if so, either remove preceding <br> or merge <p>s
			switch ( event.which ) {
				case 8: // backspace
					// do something here...
					break;
			}
			return true;
		},
		'delayedChange': function( event ) {
			event.data.scope = 'division';
			var newHTML = context.$content.html();
			if ( context.oldDelayedHTML != newHTML ) {
				context.oldDelayedHTML = newHTML;
				event.data.scope = 'realchange';
			}
			context.fn.updateHistory( event.data.scope == 'realchange' );
			return true;
		},
		'paste': function( event ) {
			context.$content.find( ':not(.wikiEditor)' ).addClass( 'wikiEditor' );
			if ( $.layout.name !== 'webkit' ) {
				context.$content.addClass( 'pasting' );
			}
			setTimeout( function() {
				// Unwrap the span found in webkit copies
				context.$content.find( 'link, style, meta' ).remove(); //MS Word
				context.$content.find( 'p:not(.wikiEditor) p:not(.wikiEditor)' ) //MS Word+webkit
					.each( function(){
						var outerParent = $(this).parent();
						outerParent.replaceWith( outerParent.childNodes() );
					} );
				context.$content.find( 'span.Apple-style-span' ).each( function() {
					$( this.childNodes ).insertBefore( this );
				} ).remove(); //Apple Richtext
				var $selection = context.$content.find( ':not(.wikiEditor)' );
				while ( $selection.length && $selection.length > 0 ) {
					var $currentElement = $selection.eq( 0 );
					while ( !$currentElement.parent().is( 'body' ) && !$currentElement.parent().is( '.wikiEditor' ) ) {
						$currentElement = $currentElement.parent();
					}
					var text = $currentElement.text();
					if ( $currentElement.is( 'br' ) ) {
						$currentElement.addClass( 'wikiEditor' );
					} else if ( $currentElement.is( 'span' ) && text.length == 0 ) {
						// Markers!
						$currentElement.remove();
					} else {
						$newElement = $( '<p></p>' )
							.addClass( 'wikiEditor' )
							.insertAfter( $currentElement );
						if ( text.length ) {
							$newElement.text( text );
						} else {
							$newElement.append( $( '<br>' ).addClass( 'wikiEditor' ) );
						}
						$currentElement.remove();
					}
					$selection = context.$content.find( ':not(.wikiEditor)' );
				}
				context.$content.find( '.wikiEditor' ).removeClass( 'wikiEditor' );
				// Remove newlines from all text nodes
				var t = context.fn.traverser( context.$content );
				while ( t ) {
					if ( t.node.nodeName == '#text' ) {
						if ( ( t.node.nodeValue.indexOf( '\n' ) != 1 || t.node.nodeValue.indexOf( '\r' ) != -1 ) ) {
							t.node.nodeValue = t.node.nodeValue.replace( /\r|\n/g, ' ' );
						}
					}
					t = t.next();
				}
				if ( $.layout.name !== 'webkit' ) {
					context.$content.removeClass( 'pasting' );
				}
			}, 0 );
			return true;
		},
		'ready': function( event ) {
			// Initialize our history queue
			context.history.push( { 'html': context.$content.html(), 'sel':  context.fn.getCaretPosition() } );
			return true;
		}
	};
	
	/* Internal Functions */
	
	context.fn = {
		/**
		 * Executes core event filters as well as event handlers provided by modules.
		 */
		'trigger': function( name, event ) {
			// Event is an optional argument, but from here on out, at least the type field should be dependable
			if ( typeof event == 'undefined' ) {
				event = { 'type': 'custom' };
			}
			// Ensure there's a place for extra information to live
			if ( typeof event.data == 'undefined' ) {
				event.data = {};
			}
			// Allow filtering to occur
			if ( name in context.evt ) {
				if ( !context.evt[name]( event ) ) {
					return false;
				}
			}
			// Pass the event around to all modules activated on this context
			for ( var module in context.modules ) {
				if (
					module in $.wikiEditor.modules &&
					'evt' in $.wikiEditor.modules[module] &&
					name in $.wikiEditor.modules[module].evt
				) {
					$.wikiEditor.modules[module].evt[name]( context, event );
				}
			}
			return true;
		},
		/**
		 * Adds a button to the UI
		 */
		'addButton': function( options ) {
			// Ensure that buttons and tabs are visible
			context.$controls.show();
			context.$buttons.show();
			return $( '<button />' )
				.text( $.wikiEditor.autoMsg( options, 'caption' ) )
				.click( options.action )
				.appendTo( context.$buttons );
		},
		/**
		 * Adds a view to the UI, which is accessed using a set of tabs. Views are mutually exclusive and by default a
		 * wikitext view will be present. Only when more than one view exists will the tabs will be visible.
		 */
		'addView': function( options ) {
			// Adds a tab
			function addTab( options ) {
				// Ensure that buttons and tabs are visible
				context.$controls.show();
				context.$tabs.show();
				// Return the newly appended tab
				return $( '<div></div>' )
					.attr( 'rel', 'wikiEditor-ui-view-' + options.name )
					.addClass( context.view == options.name ? 'current' : null )
					.append( $( '<a></a>' )
						.attr( 'href', '#' )
						.mousedown( function() {
							// No dragging!
							return false;
						} )
						.click( function( event ) {
							context.$ui.find( '.wikiEditor-ui-view' ).hide();
							context.$ui.find( '.' + $(this).parent().attr( 'rel' ) ).show();
							context.$tabs.find( 'div' ).removeClass( 'current' );
							$(this).parent().addClass( 'current' );
							$(this).blur();
							if ( 'init' in options && typeof options.init == 'function' ) {
								options.init( context );
							}
							event.preventDefault();
							return false;
						} )
						.text( $.wikiEditor.autoMsg( options, 'title' ) )
					)
					.appendTo( context.$tabs );
			}
			// Automatically add the previously not-needed wikitext tab
			if ( !context.$tabs.children().size() ) {
				addTab( { 'name': 'wikitext', 'titleMsg': 'wikieditor-wikitext-tab' } );
			}
			// Add the tab for the view we were actually asked to add
			addTab( options );
			// Return newly appended view
			return $( '<div></div>' )
				.addClass( 'wikiEditor-ui-view wikiEditor-ui-view-' + options.name )
				.hide()
				.appendTo( context.$ui );
		},
		'htmlToText': function( html ) {
			// This function is slow for large inputs, so aggressively cache input/output pairs
			if ( html in context.htmlToTextMap ) {
				return context.htmlToTextMap[html];
			}
			var origHTML = html;
			
			// We use this elaborate trickery for cross-browser compatibility
			// IE does overzealous whitespace collapsing for $( '<pre />' ).html( html );
			// We also do <br> and easy cases for <p> conversion here, complicated cases are handled later
			html = html
				.replace( /\r?\n/g, "" ) // IE7 inserts newlines before block elements
				.replace( /&nbsp;/g, " " ) // We inserted these to prevent IE from collapsing spaces
				.replace( /\<br[^\>]*\>\<\/p\>/gi, '</p>' ) // Remove trailing <br> from <p>
				.replace( /\<\/p\>\s*\<p[^\>]*\>/gi, "\n" ) // Easy case for <p> conversion
				.replace( /\<br[^\>]*\>/gi, "\n" ) // <br> conversion
				.replace( /\<\/p\>(\n*)\<p[^\>]*\>/gi, "$1\n" )
				// Un-nest <p> tags
				.replace( /\<p[^\>]*\><p[^\>]*\>/gi, '<p>' )
				.replace( /\<\/p\><\/p\>/gi, '</p>' );
			// Save leading and trailing whitespace now and restore it later. IE eats it all, and even Firefox
			// won't leave everything alone
			var leading = html.match( /^\s*/ )[0];
			var trailing = html.match( /\s*$/ )[0];
			html = html.substr( leading.length, html.length - leading.length - trailing.length );
			var $pre = $( '<pre>' + html + '</pre>' );
			$pre.find( '.wikiEditor-noinclude' ).each( function() { $( this ).remove(); } );
			// Convert tabs, <p>s and <br>s back
			$pre.find( '.wikiEditor-tab' ).each( function() { $( this ).text( "\t" ); } );
			$pre.find( 'br' ).each( function() { $( this ).replaceWith( "\n" ); } );
			// Converting <p>s is wrong if there's nothing before them, so check that.
			// .find( '* + p' ) isn't good enough because textnodes aren't considered
			$pre.find( 'p' ).each( function() {
				var text =  $( this ).text();
				// If this <p> is preceded by some text, add a \n at the beginning, and if
				// it's followed by a textnode, add a \n at the end
				// We need the traverser because there can be other weird stuff in between
				
				// Check for preceding text
				var t = new context.fn.rawTraverser( this.firstChild, 0, this, $pre.get( 0 ) ).prev();
				while ( t && t.node.nodeName != '#text' && t.node.nodeName != 'BR' && t.node.nodeName != 'P' ) {
					t = t.prev();
				}
				if ( t ) {
					text = "\n" + text;
				}
				
				// Check for following text
				t = new context.fn.rawTraverser( this.lastChild, 0, this, $pre.get( 0 ) ).next();
				while ( t && t.node.nodeName != '#text' && t.node.nodeName != 'BR' && t.node.nodeName != 'P' ) {
					t = t.next();
				}
				if ( t && !t.inP && t.node.nodeName == '#text' && t.node.nodeValue.charAt( 0 ) != '\n'
						&& t.node.nodeValue.charAt( 0 ) != '\r' ) {
					text += "\n";
				}
				$( this ).text( text );
			} );
			var retval;
			if ( $.browser.msie ) {
				// IE aggressively collapses whitespace in .text() after having done DOM manipulation,
				// but for some crazy reason this does work. Also convert \r back to \n
				retval = $( '<pre>' + $pre.html() + '</pre>' ).text().replace( /\r/g, '\n' );
			} else {
				retval = $pre.text();
			}
			return context.htmlToTextMap[origHTML] = leading + retval + trailing;
		},
		/**
		 * Get the first element before the selection that's in a certain class
		 * @param classname Class to match. Defaults to '', meaning any class
		 * @param strict If true, the element the selection starts in cannot match (default: false)
		 * @return jQuery object or null if unknown
		 */
		'beforeSelection': function( classname, strict ) {
			if ( typeof classname == 'undefined' ) {
				classname = '';
			}
			var e = null, offset = null;
			if ( context.$iframe[0].contentWindow.getSelection ) {
				// Firefox and Opera
				var selection = context.$iframe[0].contentWindow.getSelection();
				// On load, webkit seems to not have a valid selection
				if ( selection.baseNode !== null ) {
					// Start at the selection's start and traverse the DOM backwards
					// This is done by traversing an element's children first, then the element itself, then its parent
					e = selection.getRangeAt( 0 ).startContainer;
					offset = selection.getRangeAt( 0 ).startOffset;
				} else {
					return null;
				}
				
				// When the cursor is on an empty line, Opera gives us a bogus range object with
				// startContainer=endContainer=body and startOffset=endOffset=1
				var body = context.$iframe[0].contentWindow.document.body;
				if ( $.browser.opera && e == body && offset == 1 ) {
					return null;
				}
			}
			if ( !e && context.$iframe[0].contentWindow.document.selection ) {
				// IE
				// Because there's nothing like range.startContainer in IE, we need to do a DOM traversal
				// to find the element the start of the selection is in
				var range = context.$iframe[0].contentWindow.document.selection.createRange();
				// Set range2 to the text before the selection
				var range2 = context.$iframe[0].contentWindow.document.body.createTextRange();
				// For some reason this call throws errors in certain cases, e.g. when the selection is
				// not in the iframe
				try {
					range2.setEndPoint( 'EndToStart', range );
				} catch ( ex ) {
					return null;
				}
				var seekPos = context.fn.htmlToText( range2.htmlText ).length;
				var offset = context.fn.getOffset( seekPos );
				e = offset ? offset.node : null;
				offset = offset ? offset.offset : null;
				if ( !e ) {
					return null;
				}
			}
			if ( e.nodeName != '#text' ) {
				// The selection is not in a textnode, but between two non-text nodes
				// (usually inside the <body> between two <br>s). Go to the rightmost
				// child of the node just before the selection
				var newE = e.firstChild;
				for ( var i = 0; i < offset - 1 && newE; i++ ) {
					newE = newE.nextSibling;
				}
				while ( newE && newE.lastChild ) {
					newE = newE.lastChild;
				}
				e = newE || e;
			}
			
			// We'd normally use if( $( e ).hasClass( class ) in the while loop, but running the jQuery
			// constructor thousands of times is very inefficient
			var classStr = ' ' + classname + ' ';
			while ( e ) {
				if ( !strict && ( !classname || ( ' ' + e.className + ' ' ).indexOf( classStr ) != -1 ) ) {
					return $( e );
				}
				var next = e.previousSibling;
				while ( next && next.lastChild ) {
					next = next.lastChild;
				}
				e = next || e.parentNode;
				strict = false;
			}
			return $( [] );
		},
		/**
		 * Object used by traverser(). Don't use this unless you know what you're doing
		 */
		'rawTraverser': function( node, depth, inP, ancestor ) {
			this.node = node;
			this.depth = depth;
			this.inP = inP;
			this.ancestor = ancestor;
			this.next = function() {
				var p = this.node;
				var nextDepth = this.depth;
				var nextInP = this.inP;
				while ( p && !p.nextSibling ) {
					p = p.parentNode;
					nextDepth--;
					if ( p == ancestor ) {
						// We're back at the ancestor, stop here
						p = null;
					}
					if ( p && p.nodeName == "P" ) {
						nextInP = null;
					}
				}
				p = p ? p.nextSibling : null;
				if ( p && p.nodeName == "P" ) {
					nextInP = p;
				}
				do {
					// Filter nodes with the wikiEditor-noinclude class
					// Don't use $( p ).hasClass( 'wikiEditor-noinclude' ) because
					// $() is slow in a tight loop
					while ( p && ( ' ' + p.className + ' ' ).indexOf( ' wikiEditor-noinclude ' ) != -1 ) {
						p = p.nextSibling;
					}
					if ( p && p.firstChild ) {
						p = p.firstChild;
						nextDepth++;
						if ( p.nodeName == "P" ) {
							nextInP = p;
						}
					}
				} while ( p && p.firstChild );
				return p ? new context.fn.rawTraverser( p, nextDepth, nextInP, this.ancestor ) : null;
			};
			this.prev = function() {
				var p = this.node;
				var prevDepth = this.depth;
				var prevInP = this.inP;
				while ( p && !p.previousSibling ) {
					p = p.parentNode;
					prevDepth--;
					if ( p == ancestor ) {
						// We're back at the ancestor, stop here
						p = null;
					}
					if ( p && p.nodeName == "P" ) {
						prevInP = null;
					}
				}
				p = p ? p.previousSibling : null;
				if ( p && p.nodeName == "P" ) {
					prevInP = p;
				}
				do {
					// Filter nodes with the wikiEditor-noinclude class
					// Don't use $( p ).hasClass( 'wikiEditor-noinclude' ) because
					// $() is slow in a tight loop
					while ( p && ( ' ' + p.className + ' ' ).indexOf( ' wikiEditor-noinclude ' ) != -1 ) {
						p = p.previousSibling;
					}
					if ( p && p.lastChild ) {
						p = p.lastChild;
						prevDepth++;
						if ( p.nodeName == "P" ) {
							prevInP = p;
						}
					}
				} while ( p && p.lastChild );
				return p ? new context.fn.rawTraverser( p, prevDepth, prevInP, this.ancestor ) : null;
			};
		},
		/**
		 * Get an object used to traverse the leaf nodes in the iframe DOM. This traversal skips leaf nodes
		 * inside an element with the wikiEditor-noinclude class. This basically wraps rawTraverser
		 *
		 * Usage:
		 * var t = context.fn.traverser( context.$content );
		 * // t.node is the first textnode, t.depth is its depth
		 * t.goNext();
		 * // t.node is the second textnode, t.depth is its depth
		 * // Trying to advance past the end will set t.node to null
		 */
		'traverser': function( start ) {
			// Find the leftmost leaf node in the tree
			var node = start.jquery ? start.get( 0 ) : start;
			var depth = 0;
			var inP = node.nodeName == "P" ? node : null;
			do {
				// Filter nodes with the wikiEditor-noinclude class
				// Don't use $( p ).hasClass( 'wikiEditor-noinclude' ) because
				// $() is slow in a tight loop
				while ( node && ( ' ' + node.className + ' ' ).indexOf( ' wikiEditor-noinclude ' ) != -1 ) {
					node = node.nextSibling;
				}
				if ( node && node.firstChild ) {
					node = node.firstChild;
					depth++;
					if ( node.nodeName == "P" ) {
						inP = node;
					}
				}
			} while ( node && node.firstChild );
			return new context.fn.rawTraverser( node, depth, inP, node );
		},
		'getOffset': function( offset ) {
			if ( !context.offsets ) {
				context.fn.refreshOffsets();
			}
			if ( offset in context.offsets ) {
				return context.offsets[offset];
			}
			// Our offset is not pre-cached. Find the highest offset below it and interpolate
			var lowerBound = -1;
			for ( var o in context.offsets ) {
				if ( o > offset ) {
					break;
				}
				lowerBound = o;
			}
			if ( !( lowerBound in context.offsets ) ) {
				// Weird edge case: either offset is too large or the document is empty
				return null;
			}
			var base = context.offsets[lowerBound];
			return context.offsets[offset] = {
				'node': base.node,
				'offset': base.offset + offset - lowerBound,
				'length': base.length,
				'depth': base.depth,
				'lastTextNode': base.lastTextNode,
				'lastTextNodeDepth': base.lastTextNodeDepth
			};
		},
		'purgeOffsets': function() {
			context.offsets = null;
		},
		'refreshOffsets': function() {
			context.offsets = [ ];
			var t = context.fn.traverser( context.$content );
			var pos = 0, lastTextNode = null, lastTextNodeDepth = null;
			while ( t ) {
				if ( t.node.nodeName != '#text' && t.node.nodeName != 'BR' ) {
					t = t.next();
					continue;
				}
				var nextPos = t.node.nodeName == '#text' ? pos + t.node.nodeValue.length : pos + 1;
				var nextT = t.next();
				var leavingP = t.node.nodeName == '#text' && t.inP && nextT && ( !nextT.inP || nextT.inP != t.inP );
				context.offsets[pos] = {
					'node': t.node,
					'offset': 0,
					'length': nextPos - pos + ( leavingP ? 1 : 0 ),
					'depth': t.depth,
					'lastTextNode': lastTextNode,
					'lastTextNodeDepth': lastTextNodeDepth
				};
				if ( leavingP ) {
					// <p>Foo</p> looks like "Foo\n", make it quack like it too
					// Basically we're faking the \n character much like we're treating <br>s
					context.offsets[nextPos] = {
						'node': t.node,
						'offset': nextPos - pos,
						'length': nextPos - pos + 1,
						'depth': t.depth,
						'lastTextNode': lastTextNode,
						'lastTextNodeDepth': lastTextNodeDepth
					};
				}
				pos = nextPos + ( leavingP ? 1 : 0 );
				if ( t.node.nodeName == '#text' ) {
					lastTextNode = t.node;
					lastTextNodeDepth = t.depth;
				}
				t = nextT;
			}
		},
		'saveSelection': function() {
			if ( !$.browser.msie ) {
				// Only IE needs this
				return;
			}
			context.$iframe[0].contentWindow.focus();
			context.savedSelection = context.$iframe[0].contentWindow.document.selection.createRange();
		},
		'restoreSelection': function() {
			if ( !$.browser.msie || context.savedSelection === null ) {
				return;
			}
			context.$iframe[0].contentWindow.focus();
			context.savedSelection.select();
			context.savedSelection = null;
		},
		/**
		 * Update the history queue
		 *
		 * @param htmlChange pass true or false to inidicate if there was a text change that should potentially
		 * 	be given a new history state. 
		 */
		'updateHistory': function( htmlChange ) {
			var newHTML = context.$content.html();
			var newSel = context.fn.getCaretPosition();
			// Was text changed? Was it because of a REDO or UNDO action? 
			if (
				context.history.length == 0 ||
				( htmlChange && context.oldDelayedHistoryPosition == context.historyPosition )
			) {
				context.fn.purgeOffsets();
				context.oldDelayedSel = newSel;
				// Do we need to trim extras from our history? 
				// FIXME: this should really be happing on change, not on the delay
				if ( context.historyPosition < -1 ) {
					//clear out the extras
					context.history.splice( context.history.length + context.historyPosition + 1 );
					context.historyPosition = -1;
				}
				context.history.push( { 'html': newHTML, 'sel': newSel } );
				// If the history has grown longer than 10 items, remove the earliest one
				while ( context.history.length > 10 ) {
					context.history.shift();
				}
			} else if ( context.oldDelayedSel != newSel ) {
				// If only the selection was changed, update it
				context.oldDelayedSel = newSel;
				context.history[context.history.length + context.historyPosition].sel = newSel;
			}
			// synch our old delayed history position until the next undo/redo action
			context.oldDelayedHistoryPosition = context.historyPosition;
		},
		/**
		 * Sets up the iframe in place of the textarea to allow more advanced operations
		 */
		'setupIframe': function() {
			context.$iframe = $( '<iframe></iframe>' )
				.attr( {
					'frameBorder': 0,
					'border': 0,
					'tabindex': 1,
					'src': wgScriptPath + '/extensions/UsabilityInitiative/js/plugins/jquery.wikiEditor.html?' +
						'instance=' + context.instance + '&ts=' + ( new Date() ).getTime() + '&is=content',
					'id': 'wikiEditor-iframe-' + context.instance
				} )
				.css( {
					'backgroundColor': 'white',
					'width': '100%',
					'height': context.$textarea.height(),
					'display': 'none',
					'overflow-y': 'scroll',
					'overflow-x': 'hidden'
				} )
				.insertAfter( context.$textarea )
				.load( function() {
					// Internet Explorer will reload the iframe once we turn on design mode, so we need to only turn it
					// on during the first run, and then bail
					if ( !this.isSecondRun ) {
						// Turn the document's design mode on
						context.$iframe[0].contentWindow.document.designMode = 'on';
						// Let the rest of this function happen next time around
						if ( $.browser.msie ) {
							this.isSecondRun = true;
							return;
						}
					}
					// Get a reference to the content area of the iframe
					context.$content = $( context.$iframe[0].contentWindow.document.body );
					// If we just do "context.$content.text( context.$textarea.val() )", Internet Explorer will strip
					// out the whitespace charcters, specifically "\n" - so we must manually encode text and append it
					// TODO: Refactor this into a textToHtml() function
					var html = context.$textarea.val()
						// We're gonna use &esc; as an escape sequence
						.replace( /&esc;/g, '&esc;esc;' )
						// Escape existing uses of <p>, </p>, &nbsp; and <span class="wikiEditor-tab"></span>
						.replace( /\<p\>/g, '&esc;&lt;p&gt;' )
						.replace( /\<\/p\>/g, '&esc;&lt;/p&gt;' )
						.replace(
							/\<span class="wikiEditor-tab"\>\<\/span\>/g,
							'&esc;&lt;span&nbsp;class=&quot;wikiEditor-tab&quot;&gt;&lt;/span&gt;'
						)
						.replace( /&nbsp;/g, '&esc;&amp;nbsp;' );
					// We must do some extra processing on IE to avoid dirty diffs, specifically IE will collapse
					// leading spaces - browser sniffing is not ideal, but executing this code on a non-broken browser
					// doesn't cause harm
					if ( $.browser.msie ) {
						html = html.replace( /\t/g, '<span class="wikiEditor-tab"></span>' );
						if ( $.browser.versionNumber <= 7 ) {
							// Replace all spaces matching &nbsp; - IE <= 7 needs this because of its overzealous
							// whitespace collapsing
							html = html.replace( / /g, "&nbsp;" );
						} else {
							// IE8 is happy if we just convert the first leading space to &nbsp;
							html = html.replace( /(^|\n) /g, "$1&nbsp;" );
						}
					}
					// Use a dummy div to escape all entities
					// This'll also escape <br>, <span> and &nbsp; , so we unescape those after
					// We also need to unescape the doubly-escaped things mentioned above
					html = $( '<div />' ).text( '<p>' + html.replace( /\r?\n/g, '</p><p>' ) + '</p>' ).html()
						.replace( /&amp;nbsp;/g, '&nbsp;' )
						// Allow <p> tags to survive encoding
						.replace( /&lt;p&gt;/g, '<p>' )
						.replace( /&lt;\/p&gt;/g, '</p>' )
						// And <span class="wikiEditor-tab"></span> too
						.replace(
							/&lt;span( |&nbsp;)class=("|&quot;)wikiEditor-tab("|&quot;)&gt;&lt;\/span&gt;/g,
							'<span class="wikiEditor-tab"></span>'
						)
						// Empty <p> tags need <br> tags in them 
						.replace( /<p><\/p>/g, '<p><br></p>' )
						// Unescape &esc; stuff
						.replace( /&amp;esc;&amp;amp;nbsp;/g, '&amp;nbsp;' )
						.replace( /&amp;esc;&amp;lt;p&amp;gt;/g, '&lt;p&gt;' )
						.replace( /&amp;esc;&amp;lt;\/p&amp;gt;/g, '&lt;/p&gt;' )
						.replace(
							/&amp;esc;&amp;lt;span&amp;nbsp;class=&amp;quot;wikiEditor-tab&amp;quot;&amp;gt;&amp;lt;\/span&amp;gt;/g,
							'&lt;span class="wikiEditor-tab"&gt;&lt;\/span&gt;'
						)
						.replace( /&amp;esc;esc;/g, '&amp;esc;' );
					context.$content.html( html );
					
					// Reflect direction of parent frame into child
					if ( $( 'body' ).is( '.rtl' ) ) {
						context.$content.addClass( 'rtl' ).attr( 'dir', 'rtl' );
					}
					// Activate the iframe, encoding the content of the textarea and copying it to the content of iframe
					context.$textarea.attr( 'disabled', true );
					context.$textarea.hide();
					context.$iframe.show();
					// Let modules know we're ready to start working with the content
					context.fn.trigger( 'ready' );
					// Only save HTML now: ready handlers may have modified it
					context.oldHTML = context.oldDelayedHTML = context.$content.html();
					//remove our temporary loading
					/* Disaling our loading div for now
					$( '.wikiEditor-ui-loading' ).fadeOut( 'fast', function() {
						$( this ).remove();
					} );
					*/
					// Setup event handling on the iframe
					$( context.$iframe[0].contentWindow.document )
						.bind( 'keydown', function( event ) {
							return context.fn.trigger( 'keydown', event );
						} )
						.bind( 'paste', function( event ) {
							return context.fn.trigger( 'paste', event );
						} )
						.bind( 'keyup paste mouseup cut encapsulateSelection', function( event ) {
							return context.fn.trigger( 'change', event );
						} )
						.delayedBind( 250, 'keyup paste mouseup cut encapsulateSelection', function( event ) {
							context.fn.trigger( 'delayedChange', event );
						} );
				} );
			// Attach a submit handler to the form so that when the form is submitted the content of the iframe gets
			// decoded and copied over to the textarea
			context.$textarea.closest( 'form' ).submit( function() {
				context.$textarea.attr( 'disabled', false );
				context.$textarea.val( context.$textarea.textSelection( 'getContents' ) );
			} );
			/* FIXME: This was taken from EditWarning.js - maybe we could do a jquery plugin for this? */
			// Attach our own handler for onbeforeunload which respects the current one
			context.fallbackWindowOnBeforeUnload = window.onbeforeunload;
			window.onbeforeunload = function() {
				context.$textarea.val( context.$textarea.textSelection( 'getContents' ) );
				if ( context.fallbackWindowOnBeforeUnload ) {
					return context.fallbackWindowOnBeforeUnload();
				}
			};
		},
		
		/*
		 * Compatibility with the $.textSelection jQuery plug-in. When the iframe is in use, these functions provide
		 * equivilant functionality to the otherwise textarea-based functionality.
		 */
		
		/**
		 * Gets the complete contents of the iframe (in plain text, not HTML)
		 */
		'getContents': function() {
			// For <p></p>, .html() returns <p>&nbsp;</p> in IE
			// This seems to convince IE while not affecting display
			var html;
			if ( $.browser.msie ) {
				// Don't manipulate the iframe DOM itself, causes cursor jumping issues
				var $c = $( context.$content.get( 0 ).cloneNode( true ) );
				$c.find( 'p' ).each( function() {
					if ( $(this).html() == '' ) {
						$(this).replaceWith( '<p></p>' );
					}
				} );
				html = $c.html();
			} else {
				html = context.$content.html();
			}
			return context.fn.htmlToText( html );
		},
		/**
		 * Gets the currently selected text in the content
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 */
		'getSelection': function() {
			var retval;
			if ( context.$iframe[0].contentWindow.getSelection ) {
				// Firefox and Opera
				retval = context.$iframe[0].contentWindow.getSelection();
				if ( $.browser.opera ) {
					// Opera strips newlines in getSelection(), so we need something more sophisticated
					if ( retval.rangeCount > 0 ) {
						retval = context.fn.htmlToText( $( '<pre />' )
								.append( retval.getRangeAt( 0 ).cloneContents() )
								.html()
						);
					} else {
						retval = '';
					}
				}
			} else if ( context.$iframe[0].contentWindow.document.selection ) { // should come last; Opera!
				// IE
				retval = context.$iframe[0].contentWindow.document.selection.createRange();
			}
			if ( typeof retval.text != 'undefined' ) {
				// In IE8, retval.text is stripped of newlines, so we need to process retval.htmlText
				// to get a reliable answer. IE7 does get this right though
				// Run this fix for all IE versions anyway, it doesn't hurt
				retval = context.fn.htmlToText( retval.htmlText );
			} else if ( typeof retval.toString != 'undefined' ) {
				retval = retval.toString();
			}
			return retval;
		},
		/**
		 * Inserts text at the begining and end of a text selection, optionally inserting text at the caret when
		 * selection is empty.
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 */
		'encapsulateSelection': function( options ) {
			var selText = $(this).textSelection( 'getSelection' );
			var selTextArr;
			var selectAfter = false;
			var setSelectionTo = null;
			var pre = options.pre, post = options.post;
			if ( !selText ) {
				selText = options.peri;
				selectAfter = true;
			} else if ( options.replace ) {
				selText = options.peri;
			} else if ( selText.charAt( selText.length - 1 ) == ' ' ) {
				// Exclude ending space char
				// FIXME: Why?
				selText = selText.substring( 0, selText.length - 1 );
				post += ' ';
			}
			if ( options.splitlines ) {
				selTextArr = selText.split( /\n/ );
			}

			if ( context.$iframe[0].contentWindow.getSelection ) {
				// Firefox and Opera
				var range = context.$iframe[0].contentWindow.getSelection().getRangeAt( 0 );
				if ( options.ownline ) {
					// We need to figure out if the cursor is at the start or end of a line
					var atStart = false, atEnd = false;
					var body = context.$content.get( 0 );
					if ( range.startOffset == 0 ) {
						// Start of a line
						// FIXME: Not necessarily the case with syntax highlighting or
						// template collapsing
						atStart = true;
					} else if ( range.startContainer == body ) {
						// Look up the node just before the start of the selection
						// If it's a <BR>, we're at the start of a line that starts with a
						// block element; if not, we're at the end of a line
						var n = body.firstChild;
						for ( var i = 0; i < range.startOffset - 1 && n; i++ ) {
							n = n.nextSibling;
						}
						if ( n && n.nodeName == 'BR' ) {
							atStart = true;
						} else {
							atEnd = true;
						}
					} else if ( range.startContainer.nodeName == '#text' &&
							range.startOffset == range.startContainer.nodeValue.length ) {
						// Apparently this happens when splitting text nodes
						atEnd = true;
					}
					
					if ( !atStart ) {
						pre  = "\n" + options.pre;
					}
					if ( !atEnd ) {
						post += "\n";
					}
				}
				var insertText = "";
				if ( options.splitlines ) {
					for( var j = 0; j < selTextArr.length; j++ ) {
						insertText = insertText + pre + selTextArr[j] + post;
						if( j != selTextArr.length - 1 ) {
							insertText += "\n";
						}
					}
				} else {
					insertText = pre + selText + post;
				}
				var insertLines = insertText.split( "\n" );
				range.extractContents();
				// Insert the contents one line at a time - insertNode() inserts at the beginning, so this has to happen
				// in reverse order
				// Track the first and last inserted node, and if we need to also track where the text we need to select
				// afterwards starts and ends
				var firstNode = null, lastNode = null;
				var selSC = null, selEC = null, selSO = null, selEO = null, offset = 0;
				for ( var i = insertLines.length - 1; i >= 0; i-- ) {
					firstNode = context.$iframe[0].contentWindow.document.createTextNode( insertLines[i] );
					range.insertNode( firstNode );
					lastNode = lastNode || firstNode;
					var newOffset = offset + insertLines[i].length;
					if ( !selEC && post.length <= newOffset ) {
						selEC = firstNode;
						selEO = selEC.nodeValue.length - ( post.length - offset );
					}
					if ( selEC && !selSC && pre.length >= insertText.length - newOffset ) {
						selSC = firstNode;
						selSO = pre.length - ( insertText.length - newOffset );
					}
					offset = newOffset;
					if ( i > 0 ) {
						firstNode = context.$iframe[0].contentWindow.document.createElement( 'br' );
						range.insertNode( firstNode );
						newOffset = offset + 1;
						if ( !selEC && post.length <= newOffset ) {
							selEC = firstNode;
							selEO = 1 - ( post.length - offset );
						}
						if ( selEC && !selSC && pre.length >= insertText.length - newOffset ) {
							selSC = firstNode;
							selSO = pre.length - ( insertText.length - newOffset );
						}
						offset = newOffset;
					}
				}
				if ( firstNode ) {
					context.fn.scrollToTop( $( firstNode.parentNode ) );
				}
				if ( selectAfter ) {
					setSelectionTo = {
						startContainer: selSC,
						endContainer: selEC,
						start: selSO,
						end: selEO
					};
				} else if  ( lastNode ) {
					setSelectionTo = {
						startContainer: lastNode,
						endContainer: lastNode,
						start: lastNode.nodeValue.length,
						end: lastNode.nodeValue.length
					};
				}
			} else if ( context.$iframe[0].contentWindow.document.selection ) {
				// IE
				context.$iframe[0].contentWindow.focus();
				var range = context.$iframe[0].contentWindow.document.selection.createRange();
				if ( options.ownline && range.moveStart ) {
					// Check if we're at the start of a line
					// If not, prepend a newline
					var range2 = context.$iframe[0].contentWindow.document.selection.createRange();
					range2.collapse();
					range2.moveStart( 'character', -1 );
					// FIXME: Which check is correct?
					if ( range2.text != "\r" && range2.text != "\n" && range2.text != "" ) {
						pre = "\n" + pre;
					}
					
					// Check if we're at the end of a line
					// If not, append a newline
					var range3 = context.$iframe[0].contentWindow.document.selection.createRange();
					range3.collapse( false );
					range3.moveEnd( 'character', 1 );
					if ( range3.text != "\r" && range3.text != "\n" && range3.text != "" ) {
						post += "\n";
					}
				}
				// TODO: Clean this up. Duplicate code due to the pre-existing browser specific structure of this
				// function
				var insertText = "";
				if ( options.splitlines ) {
					for( var j = 0; j < selTextArr.length; j++ ) {
						insertText = insertText + pre + selTextArr[j] + post;
						if( j != selTextArr.length - 1 ) {
							insertText += "\n"; 
						}
					}
				} else {
					insertText = pre + selText + post;
				}
				// TODO: Maybe find a more elegant way of doing this like the Firefox code above?
				range.pasteHTML( insertText
						.replace( /\</g, '&lt;' )
						.replace( />/g, '&gt;' )
						.replace( /\r?\n/g, '<br />' )
				);
				if ( selectAfter ) {
					range.moveStart( 'character', -post.length - selText.length );
					range.moveEnd( 'character', -post.length );
					range.select();
				}
			}
			
			if ( setSelectionTo ) {
				context.fn.setSelection( setSelectionTo );
			}
			// Trigger the encapsulateSelection event (this might need to get named something else/done differently)
			$( context.$iframe[0].contentWindow.document ).trigger(
				'encapsulateSelection', [ pre, options.peri, post, options.ownline, options.replace ]
			);
			return context.$textarea;
		},
		/**
		 * Gets the position (in resolution of bytes not nessecarily characters) in a textarea
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 */
		'getCaretPosition': function( options ) {
			var startPos = null, endPos = null;
			if ( context.$iframe[0].contentWindow.getSelection ) {
				var selection = context.$iframe[0].contentWindow.getSelection();
				if ( selection.rangeCount == 0 ) {
					// We don't know where the cursor is
					return [ 0, 0 ];
				}
				var sc = selection.getRangeAt( 0 ).startContainer, ec = selection.getRangeAt( 0 ).endContainer;
				var so = selection.getRangeAt( 0 ).startOffset, eo = selection.getRangeAt( 0 ).endOffset;
				if ( sc.nodeName == 'BODY' ) {
					// Grab the node just before the start of the selection
					var n = sc.firstChild;
					for ( var i = 0; i < so - 1 && n; i++ ) {
						n = n.nextSibling;
					}
					sc = n;
					so = 0;
				}
				if ( ec.nodeName == 'BODY' ) {
					var n = ec.firstChild;
					for ( var i = 0; i < eo - 1 && n; i++ ) {
						n = n.nextSibling;
					}
					ec = n;
					eo = 0;
				}
				
				// Make sure sc and ec are leaf nodes
				while ( sc.firstChild ) {
					sc = sc.firstChild;
				}
				while ( ec.firstChild ) {
					ec = ec.firstChild;
				}
				// Make sure the offsets are regenerated if necessary
				context.fn.getOffset( 0 );
				var o;
				for ( o in context.offsets ) {
					if ( startPos === null && context.offsets[o].node == sc ) {
						// For some wicked reason o is a string, even though
						// we put it in as an integer. Use ~~ to coerce it too an int
						startPos = ~~o + so - context.offsets[o].offset;
					}
					if ( startPos !== null && context.offsets[o].node == ec ) {
						endPos = ~~o + eo - context.offsets[o].offset;
						break;
					}
				}
			} else if ( context.$iframe[0].contentWindow.document.selection ) {
				// IE
				// FIXME: This is mostly copypasted from the textSelection plugin
				var d = context.$iframe[0].contentWindow.document;
				var postFinished = false;
				var periFinished = false;
				var postFinished = false;
				var preText, rawPreText, periText;
				var rawPeriText, postText, rawPostText;
				// Depending on the document state, and if the cursor has ever been manually placed within the document
				// the following call such as setEndPoint can result in nasty errors. These cases are always cases
				// in which the start and end points can safely be assumed to be 0, so we will just try our best to do
				// the full process but fall back to 0.
				try {
					// Create range containing text in the selection
					var periRange = d.selection.createRange().duplicate();
					// Create range containing text before the selection
					var preRange = d.body.createTextRange();
					// Move the end where we need it
					preRange.setEndPoint( "EndToStart", periRange );
					// Create range containing text after the selection
					var postRange = d.body.createTextRange();
					// Move the start where we need it
					postRange.setEndPoint( "StartToEnd", periRange );
					// Load the text values we need to compare
					preText = rawPreText = preRange.text;
					periText = rawPeriText = periRange.text;
					postText = rawPostText = postRange.text;
					/*
					 * Check each range for trimmed newlines by shrinking the range by 1
					 * character and seeing if the text property has changed. If it has
					 * not changed then we know that IE has trimmed a \r\n from the end.
					 */
					do {
						if ( !postFinished ) {
							if ( preRange.compareEndPoints( "StartToEnd", preRange ) == 0 ) {
								postFinished = true;
							} else {
								preRange.moveEnd( "character", -1 )
								if ( preRange.text == preText ) {
									rawPreText += "\r\n";
								} else {
									postFinished = true;
								}
							}
						}
						if ( !periFinished ) {
							if ( periRange.compareEndPoints( "StartToEnd", periRange ) == 0 ) {
								periFinished = true;
							} else {
								periRange.moveEnd( "character", -1 )
								if ( periRange.text == periText ) {
									rawPeriText += "\r\n";
								} else {
									periFinished = true;
								}
							}
						}
						if ( !postFinished ) {
							if ( postRange.compareEndPoints("StartToEnd", postRange) == 0 ) {
								postFinished = true;
							} else {
								postRange.moveEnd( "character", -1 )
								if ( postRange.text == postText ) {
									rawPostText += "\r\n";
								} else {
									postFinished = true;
								}
							}
						}
					} while ( ( !postFinished || !periFinished || !postFinished ) );
					startPos = rawPreText.replace( /\r\n/g, "\n" ).length;
					endPos = startPos + rawPeriText.replace( /\r\n/g, "\n" ).length;
				} catch( e ) {
					startPos = endPos = 0;
				}
			}
			return [ startPos, endPos ];
		},
		/**
		 * Sets the selection of the content
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 *
		 * @param start Character offset of selection start
		 * @param end Character offset of selection end
		 * @param startContainer Element in iframe to start selection in. If not set, start is a character offset
		 * @param endContainer Element in iframe to end selection in. If not set, end is a character offset
		 */
		'setSelection': function( options ) {
			var sc = options.startContainer, ec = options.endContainer;
			sc = sc && sc.jquery ? sc[0] : sc;
			ec = ec && ec.jquery ? ec[0] : ec;
			if ( context.$iframe[0].contentWindow.getSelection ) {
				// Firefox and Opera
				var start = options.start, end = options.end;
				if ( !sc || !ec ) {
					var s = context.fn.getOffset( start );
					var e = context.fn.getOffset( end );
					sc = s ? s.node : null;
					ec = e ? e.node : null;
					start = s ? s.offset : null;
					end = e ? e.offset : null;
				}
				if ( !sc || !ec ) {
					// The requested offset isn't in the offsets array
					// Give up
					return context.$textarea;
				}
				
				var sel = context.$iframe[0].contentWindow.getSelection();
				while ( sc.firstChild && sc.nodeName != '#text' ) {
					sc = sc.firstChild;
				}
				while ( ec.firstChild && ec.nodeName != '#text' ) {
					ec = ec.firstChild;
				}
				var range = context.$iframe[0].contentWindow.document.createRange();
				range.setStart( sc, start );
				range.setEnd( ec, end );
				sel.removeAllRanges();
				sel.addRange( range );
				context.$iframe[0].contentWindow.focus();
			} else if ( context.$iframe[0].contentWindow.document.body.createTextRange ) {
				// IE
				var range = context.$iframe[0].contentWindow.document.body.createTextRange();
				if ( sc ) {
					range.moveToElementText( sc );
				}
				range.collapse();
				range.moveEnd( 'character', options.start );
				
				var range2 = context.$iframe[0].contentWindow.document.body.createTextRange();
				if ( ec ) {
					range2.moveToElementText( ec );
				}
				range2.collapse();
				range2.moveEnd( 'character', options.end );
				
				// IE does newline emulation for <p>s: <p>foo</p><p>bar</p> becomes foo\nbar just fine
				// but <p>foo</p><br><br><p>bar</p> becomes foo\n\n\n\nbar , one \n too many
				// Correct for this
				var matches, counted = 0;
				// while ( matches = range.htmlText.match( regex ) && matches.length <= counted ) doesn't work
				// because the assignment side effect hasn't happened yet when the second term is evaluated
				while ( matches = range.htmlText.match( /\<\/p\>(\<br[^\>]*\>)+\<p\>/gi ) ) {
					if ( matches.length <= counted )
						break;
					range.moveEnd( 'character', matches.length );
					counted += matches.length;
				}
				range2.moveEnd( 'character', counted );
				while ( matches = range2.htmlText.match( /\<\/p\>(\<br[^\>]*\>)+\<p\>/gi ) ) {
					if ( matches.length <= counted )
						break;
					range2.moveEnd( 'character', matches.length );
					counted += matches.length;
				}

				range2.setEndPoint( 'StartToEnd', range );
				range2.select();
			}
			return context.$textarea;
		},
		/**
		 * Scroll a textarea to the current cursor position. You can set the cursor position with setSelection()
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 */
		'scrollToCaretPosition': function( options ) {
			// FIXME: context.$textarea.trigger( 'scrollToPosition' ) ?
		},
		/**
		 * Scroll an element to the top of the iframe
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 *
		 * @param $element jQuery object containing an element in the iframe
		 * @param force If true, scroll the element even if it's already visible
		 */
		'scrollToTop': function( $element, force ) {
			var html = context.$content.closest( 'html' ),
				body = context.$content.closest( 'body' ),
				parentHtml = $( 'html' ),
				parentBody = $( 'body' );
			var y = $element.offset().top;
			if ( !$.browser.msie && ! $element.is( 'body' ) ) {
				y = parentHtml.scrollTop() > 0 ? y + html.scrollTop() - parentHtml.scrollTop() : y;
				y = parentBody.scrollTop() > 0 ? y + body.scrollTop() - parentBody.scrollTop() : y;
			}
			var topBound = html.scrollTop() > body.scrollTop() ? html.scrollTop() : body.scrollTop(),
				bottomBound = topBound + context.$iframe.height();
			if ( force || y < topBound || y > bottomBound ) {
					html.scrollTop( y );
					body.scrollTop( y );
				}
			$element.trigger( 'scrollToTop' );
		}
	};
	
	/*
	 * Base UI Construction
	 * 
	 * The UI is built from several containers, the outer-most being a div classed as "wikiEditor-ui". These containers
	 * provide a certain amount of "free" layout, but in some situations procedural layout is needed, which is performed
	 * as a response to the "resize" event.
	 */
	
	// Assemble a temporary div to place over the wikiEditor while it's being constructed
	/* Disabling our loading div for now
	var $loader = $( '<div></div>' )
		.addClass( 'wikiEditor-ui-loading' )
		.append( $( '<span>' + mw.usability.getMsg( 'wikieditor-loading' ) + '</span>' )
			.css( 'marginTop', context.$textarea.height() / 2 ) );
	*/
	// Encapsulate the textarea with some containers for layout
	context.$textarea
	/* Disabling our loading div for now
		.after( $loader )
		.add( $loader )
	*/
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-view wikiEditor-ui-view-wikitext' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-left' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-bottom' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-text' ) );
	// Get references to some of the newly created containers
	context.$ui = context.$textarea.parent().parent().parent().parent().parent();
	context.$wikitext = context.$textarea.parent().parent().parent().parent();
	// Add in tab and button containers
	context.$wikitext
		.before(
			$( '<div></div>' ).addClass( 'wikiEditor-ui-controls' )
				.append( $( '<div></div>' ).addClass( 'wikiEditor-ui-tabs' ).hide() )
				.append( $( '<div></div>' ).addClass( 'wikiEditor-ui-buttons' ) )
		)
		.before( $( '<div style="clear:both;"></div>' ) );
	// Get references to some of the newly created containers
	context.$controls = context.$ui.find( '.wikiEditor-ui-buttons' ).hide();
	context.$buttons = context.$ui.find( '.wikiEditor-ui-buttons' );
	context.$tabs = context.$ui.find( '.wikiEditor-ui-tabs' );
	// Clear all floating after the UI
	context.$ui.after( $( '<div style="clear:both;"></div>' ) );
	// Attach a right container
	context.$wikitext.append( $( '<div></div>' ).addClass( 'wikiEditor-ui-right' ) );
	// Attach a top container to the left pane
	context.$wikitext.find( '.wikiEditor-ui-left' ).prepend( $( '<div></div>' ).addClass( 'wikiEditor-ui-top' ) );
	// Setup the intial view
	context.view = 'wikitext';
	// Trigger the "resize" event anytime the window is resized
	$( window ).resize( function( event ) { context.fn.trigger( 'resize', event ); } );
}

/* API Execution */

// Since javascript gives arguments as an object, we need to convert them so they can be used more easily
var args = $.makeArray( arguments );

// Dynamically setup the Iframe when needed when adding modules
if ( typeof context.$iframe === 'undefined' && arguments[0] == 'addModule' && typeof arguments[1] == 'object' ) {
	for ( module in arguments[1] ) {
		// Only allow modules which are supported (and thus actually being turned on) affect this decision
		if ( $.wikiEditor.isSupported( module ) && $.wikiEditor.isRequired( module, 'iframe' ) ) {
			context.fn.setupIframe();
			break;
		}
	}
}

// There would need to be some arguments if the API is being called
if ( args.length > 0 ) {
	// Handle API calls
	var call = args.shift();
	if ( call in context.api ) {
		context.api[call]( context, typeof args[0] == 'undefined' ? {} : args[0] );
	}
}

// Store the context for next time, and support chaining
return $(this).data( 'wikiEditor-context', context );

}; } )( jQuery );
/**
 * Extend the RegExp object with an escaping function
 * From http://simonwillison.net/2006/Jan/20/escape/
 */
RegExp.escape = function( s ) { return s.replace(/([.*+?^${}()|\/\\[\]])/g, '\\$1'); };

/**
 * Dialog Module for wikiEditor
 */
( function( $ ) { $.wikiEditor.modules.dialogs = {

/**
 * Compatability map
 */
'browsers': {
	// Left-to-right languages
	'ltr': {
		'msie': [['>=', 7]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]],
		'chrome': [['>=', 4]]
	},
	// Right-to-left languages
	'rtl': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]],
		'chrome': [['>=', 4]]
	}
},
/**
 * Core Requirements
 */
'req': [ 'iframe' ],
/**
 * API accessible functions
 */
api: {
	addDialog: function( context, data ) {
		$.wikiEditor.modules.dialogs.fn.create( context, data )
	},
	openDialog: function( context, module ) {
		if ( module in $.wikiEditor.modules.dialogs.modules ) {
			$( '#' + $.wikiEditor.modules.dialogs.modules[module].id ).dialog( 'open' );
		}
	},
	closeDialog: function( context, data ) {
		if ( module in $.wikiEditor.modules.dialogs.modules ) {
			$( '#' + $.wikiEditor.modules.dialogs.modules[module].id ).dialog( 'close' );
		}
	}
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates a dialog module within a wikiEditor
	 *
	 * @param {Object} context Context object of editor to create module in
	 * @param {Object} config Configuration object to create module from
	 */
	create: function( context, config ) {
		// Add modules
		for ( module in config ) {
			$.wikiEditor.modules.dialogs.modules[module] = config[module];
		}
		// Build out modules immediately
		mw.usability.load( ['$j.ui', '$j.ui.dialog', '$j.ui.draggable', '$j.ui.resizable' ], function() {
			for ( module in $.wikiEditor.modules.dialogs.modules ) {
				var module = $.wikiEditor.modules.dialogs.modules[module];
				// Only create the dialog if it doesn't exist yet
				if ( $( '#' + module.id ).size() == 0 ) {
					var configuration = module.dialog;
					// Add some stuff to configuration
					configuration.bgiframe = true;
					configuration.autoOpen = false;
					configuration.modal = true;
					configuration.title = $.wikiEditor.autoMsg( module, 'title' );
					// Transform messages in keys
					// Stupid JS won't let us do stuff like
					// foo = { mw.usability.getMsg ('bar'): baz }
					configuration.newButtons = {};
					for ( msg in configuration.buttons )
						configuration.newButtons[mw.usability.getMsg( msg )] = configuration.buttons[msg];
					configuration.buttons = configuration.newButtons;
					// Create the dialog <div>
					var dialogDiv = $( '<div /> ' )
						.attr( 'id', module.id )
						.html( module.html )
						.data( 'context', context )
						.appendTo( $( 'body' ) )
						.each( module.init )
						.dialog( configuration );
					if ( !( 'resizeme' in module ) || module.resizeme ) {
						dialogDiv
							.bind( 'dialogopen', $.wikiEditor.modules.dialogs.fn.resize )
							.find( '.ui-tabs' ).bind( 'tabsshow', function() {
								$(this).closest( '.ui-dialog-content' ).each(
									$.wikiEditor.modules.dialogs.fn.resize );
							});
					}
					dialogDiv.bind( 'dialogclose', function() {
						context.fn.restoreSelection();
					} );
					// Add tabindexes to dialog form elements
					// Find the highest tabindex in use
					var maxTI = 0;
					$j( '[tabindex]' ).each( function() {
						var ti = parseInt( $j(this).attr( 'tabindex' ) );
						if ( ti > maxTI )
							maxTI = ti;
					});
					
					var tabIndex = maxTI + 1;
					$j( '.ui-dialog input, .ui-dialog button' )
						.not( '[tabindex]' )
						.each( function() {
							$j(this).attr( 'tabindex', tabIndex++ );
						});
				}
			}
		});
	},
	/**
	 * Resize a dialog so its contents fit
	 *
	 * Usage: dialog.each( resize ); or dialog.bind( 'blah', resize );
	 * NOTE: This function assumes $j.ui.dialog has already been loaded
	 */
	resize: function() {
		var wrapper = $(this).closest( '.ui-dialog' );
		var oldWidth = wrapper.width();
		// Make sure elements don't wrapped so we get an accurate idea of whether they really fit. Also temporarily show
		// hidden elements. Work around jQuery bug where <div style="display:inline;" /> inside a dialog is both
		// :visible and :hidden
		var oldHidden = $(this).find( '*' ).not( ':visible' );
		// Save the style attributes of the hidden elements to restore them later. Calling hide() after show() messes up
		// for elements hidden with a class
		oldHidden.each( function() {
			$(this).data( 'oldstyle', $(this).attr( 'style' ) );
		});
		oldHidden.show();
		var oldWS = $(this).css( 'white-space' );
		$(this).css( 'white-space', 'nowrap' );
		if ( wrapper.width() <= $(this).get(0).scrollWidth ) {
			var thisWidth = $(this).data( 'thisWidth' ) ? $(this).data( 'thisWidth' ) : 0;
			thisWidth = Math.max( $(this).get(0).scrollWidth, thisWidth );
			$(this).width( thisWidth );
			$(this).data( 'thisWidth', thisWidth );
			var wrapperWidth = $(this).data( 'wrapperWidth' ) ? $(this).data( 'wrapperWidth' ) : 0;
			wrapperWidth = Math.max( wrapper.get(0).scrollWidth, wrapperWidth );
			wrapper.width( wrapperWidth );
			$(this).data( 'wrapperWidth', wrapperWidth );
			$(this).dialog( { 'width': wrapper.width() } );
			wrapper.css( 'left', parseInt( wrapper.css( 'left' ) ) - ( wrapper.width() - oldWidth ) / 2 );
		}
		$(this).css( 'white-space', oldWS );
		oldHidden.each( function() {
			$(this).attr( 'style', $(this).data( 'oldstyle' ) );
		});		
	}
},
// This stuff is just hanging here, perhaps we could come up with a better home for this stuff
modules: {},
quickDialog: function( body, settings ) {
	$( '<div />' )
		.text( body )
		.appendTo( $( 'body' ) )
		.dialog( $.extend( {
			bgiframe: true,
			modal: true
		}, settings ) )
		.dialog( 'open' );
}

}; } ) ( jQuery );
/* Highlight module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.highlight = {

/**
 * Core Requirements
 */
'req': [ 'iframe' ],
/**
 * Configuration
 */
cfg: {
	'styleVersion': 3
},
/**
 * Internally used event handlers
 */
evt: {
	delayedChange: function( context, event ) {
		/*
		 * Triggered on any of the following events, with the intent on detecting if something was added, deleted or
		 * replaced due to user action.
		 *
		 * The following conditions are indicative that one or more divisions need to be re-scanned/marked:
		 * 		Keypress while something is highlighted
		 * 		Cut
		 * 		Paste
		 * 		Drag+drop selected text
		 * The following conditions are indicative that special handlers need to be consulted to properly parse content
		 * 		Keypress with any of the following characters
		 * 			}	Template or Table handler
		 * 			>	Tag handler
		 * 			]	Link handler
		 * The following conditions are indicative that divisions might be being made which would need encapsulation
		 * 		Keypress with any of the following characters
		 * 			=	Heading
		 * 			#	Ordered
		 * 			*	Unordered
		 * 			;	Definition
		 * 			:	Definition
		 */
		if ( event.data.scope == 'realchange' ) {
			$.wikiEditor.modules.highlight.fn.scan( context, "" );
			$.wikiEditor.modules.highlight.fn.mark( context, "", "" );
		}
	},
	ready: function( context, event ) {
		// Highlight stuff for the first time
		$.wikiEditor.modules.highlight.fn.scan( context, "" );
		$.wikiEditor.modules.highlight.fn.mark( context, "", "" );
	}
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates a highlight module within a wikiEditor
	 * 
	 * @param config Configuration object to create module from
	 */
	create: function( context, config ) {
		context.modules.highlight.markersStr = '';
	},
	/**
	 * Divides text into divisions
	 */
	divide: function( context ) {
		/*
		 * We need to add some markup to the iframe content to encapsulate divisions
		 */
	},
	/**
	 * Isolates division which was affected by most recent change
	 */
	isolate: function( context ) {
		/*
		 * A change just occured, and we need to know which sections were affected
		 */
		return []; // array of sections?
	},
	/**
	 * Strips division of HTML
	 * FIXME: Isn't this done by context.fn.htmlToText() already?
	 * 
	 * @param division
	 */
	strip: function( context, division ) {
		return $( '<div />' ).html( division.html().replace( /\<br[^\>]*\>/g, "\n" ) ).text();
	},
	/**
	 * Scans text division for tokens
	 * 
	 * @param division
	 */
	scan: function( context, division ) {
		/**
		 * Builds a Token object
		 * 
		 * @param offset
		 * @param label
		 */
		function Token( offset, label, tokenStart, match ) {
			this.offset = offset;
			this.label = label;
			this.tokenStart = tokenStart;
			this.match = match;
		}
		// Reset tokens
		var tokenArray = context.modules.highlight.tokenArray = [];
		// We need to look over some text and find interesting areas, then return the positions of those areas as tokens
		var text = context.fn.getContents();
		for ( module in context.modules ) {
			if ( module in $.wikiEditor.modules && 'exp' in $.wikiEditor.modules[module] ) {
			   for ( var i = 0; i < $.wikiEditor.modules[module].exp.length; i++ ) {
					var regex = $.wikiEditor.modules[module].exp[i].regex;
					var label = $.wikiEditor.modules[module].exp[i].label;
					var markAfter = false;
					if ( typeof $.wikiEditor.modules[module].exp[i].markAfter != 'undefined' ) {
						markAfter = true;
					}
					match = text.match( regex );
					var oldOffset = 0;
					while ( match != null ) {
						var markOffset = 0;
						var tokenStart = match.index + oldOffset + markOffset;
						if ( markAfter ) {
							markOffset += match[0].length;
						}
						tokenArray.push( new Token( match.index + oldOffset + markOffset,
							label, tokenStart, match ) );
						oldOffset += match.index + match[0].length;
						newSubstring = text.substring( oldOffset );
						match = newSubstring.match( regex );
					}
				}
			}
		}
		//sort by offset, or if offset same, sort by start
		tokenArray.sort( function( a, b ) {
			return a.offset - b.offset || a.tokenStart - b.tokenStart;
		} );
		context.fn.trigger( 'scan' );
	},
	/**
	 * Marks up text with HTML
	 * 
	 * @param division
	 * @param tokens
	 */
	// FIXME: What do division and tokens do?
	// TODO: Document the scan() and mark() APIs somewhere
	mark: function( context, division, tokens ) {
		// Reset markers
		var markers = context.modules.highlight.markers = [];
		// Get all markers
		context.fn.trigger( 'mark' );
		markers.sort( function( a, b ) { return a.start - b.start || a.end - b.end; } );
		
		// Serialize the markers array to a string and compare it with the one stored in the previous run
		// If they're equal, there's no markers to change
		var markersStr = '';
		for ( var i = 0; i < markers.length; i++ ) {
			markersStr += markers[i].start + ',' + markers[i].end + ',' + markers[i].type + ',';
		}
		if ( context.modules.highlight.markersStr == markersStr ) {
			// No change, bail out
			return;
		}
		context.modules.highlight.markersStr = markersStr;
		
		// Traverse the iframe DOM, inserting markers where they're needed.
		// Store visited markers here so we know which markers should be removed
		var visited = [], v = 0;
		for ( var i = 0; i < markers.length; i++ ) {
			// We want to isolate each marker, so we may need to split textNodes
			// if a marker starts or ends halfway one.
			var start = markers[i].start;
			var s = context.fn.getOffset( start );
			if ( !s ) {
				// This shouldn't happen
				continue;
			}
			var startNode = s.node;
			var startDepth = s.depth;

			// Don't wrap leading BRs, produces undesirable results
			// FIXME: It's also possible that the offset is a bit high because getOffset() has incremented
			// .length to fake the newline caused by startNode being in a P. In this case, prevent
			// the textnode splitting below from making startNode an empty textnode, IE barfs on that
			while ( startNode.nodeName == 'BR' || s.offset == startNode.nodeValue.length ) {
				start++;
				s = context.fn.getOffset( start );
				startNode = s.node;
				startDepth = s.depth;
			}

			// The next marker starts somewhere in this textNode or at this BR
			if ( s.offset > 0 && s.node.nodeName == '#text' ) {
				// Split off the prefix
				// This leaves the prefix in the current node and puts
				// the rest in a new node which is our start node
				startNode = startNode.splitText( s.offset );
				// This also invalidates cached offset objects
				context.fn.purgeOffsets(); // TODO: Optimize better, get end offset object earlier
			}
			// Because we can't put block elements in <p>s, we'll have to split the <p> as well
			// if afterWrap() needs us to
			if ( markers[i].splitPs && startNode.parentNode.nodeName == 'P' ) {
				// Create a new <p> left of startNode, and append startNode's left siblings to it
				var startP = startNode.ownerDocument.createElement( 'p' );
				while ( startNode.parentNode.firstChild != startNode ) {
					startP.appendChild( startNode.parentNode.firstChild );
				}
				if ( startP.firstChild ) {
					startNode.parentNode.insertBefore( startP, startNode );
				}
			}
			
			var end = markers[i].end;
			var e = context.fn.getOffset( end );
			if ( !e ) {
				// This shouldn't happen
				continue;
			}
			var endNode = e.node;
			var endDepth = e.depth;
			if ( e.offset < e.length - 1 && e.node.nodeName == '#text' ) {
				// Split off the suffix. This puts the suffix in a new node and leaves the rest in endNode
				endNode.splitText( e.offset );
				// This also invalidates cached offset objects
				context.fn.purgeOffsets(); // TODO: Optimize better, get end offset object earlier
			}
			// Split <p>s if needed, see above
			if ( markers[i].splitPs && endNode.parentNode.nodeName == 'P' && endNode.parentNode.parentNode ) {
				// Move textnodes preceding endNode out of the wrapping <p>
				var endP = endNode.parentNode;
				while ( endP.firstChild != endNode ) {
					endP.parentNode.insertBefore( endP.firstChild, endP );
				}
				// Move endNode itself out as well
				endP.parentNode.insertBefore( endNode, endP );
				if ( !endP.firstChild ) {
					// endP is empty, remove it
					endP.parentNode.removeChild( endP );
				}
			}
			
			// Don't wrap trailing BRs, doing that causes weird issues
			if ( endNode.nodeName == 'BR' ) {
				endNode = e.lastTextNode;
				endDepth = e.lastTextNodeDepth;
			}
			
			// Now wrap everything between startNode and endNode (may be equal). First find the common ancestor of
			// startNode and endNode. ca1 and ca2 will be children of this common ancestor, such that ca1 is an
			// ancestor of startNode and ca2 of endNode. We also check that startNode and endNode are the leftmost and
			// rightmost leaves in the subtrees rooted at ca1 and ca2 respectively; if this is not the case, we
			// can't cleanly wrap things without misnesting and we silently fail.
			var ca1 = startNode, ca2 = endNode;
			// Correct for startNode and endNode possibly not having the same depth
			if ( startDepth > endDepth ) {
				for ( var j = 0; j < startDepth - endDepth && ca1; j++ ) {
					ca1 = ca1.parentNode.firstChild == ca1 ? ca1.parentNode : null;
				}
			}
			else if ( startDepth < endDepth ) {
				for ( var j = 0; j < endDepth - startDepth && ca2; j++ ) {
					ca2 = ca2.parentNode.lastChild == ca2 ? ca2.parentNode : null;
				}
			}
			// Now that ca1 and ca2 have the same depth, have them walk up the tree simultaneously
			// to find the common ancestor
			while (
				ca1 &&
				ca2 &&
				ca1.parentNode &&
				ca2.parentNode &&
				ca1.parentNode != ca2.parentNode &&
				ca1.parentNode.firstChild &&
				ca2.parentNode.lastChild
			) {
				ca1 = ca1.parentNode.firstChild == ca1 ? ca1.parentNode : null;
				ca2 = ca2.parentNode.lastChild == ca2 ? ca2.parentNode : null;
			}
			if ( ca1 && ca2 && ca1.parentNode ) {
				var anchor = markers[i].getAnchor( ca1, ca2 );
				if ( !anchor ) {
					var commonAncestor = ca1.parentNode;
					if ( markers[i].anchor == 'wrap' ) {
						// We have to store things like .parentNode and .nextSibling because
						// appendChild() changes these properties
						var newNode = ca1.ownerDocument.createElement( 'span' );
						
						var nextNode = ca2.nextSibling;
						// Append all nodes between ca1 and ca2 (inclusive) to newNode
						var n = ca1;
						while ( n != nextNode ) {
							var ns = n.nextSibling;
							newNode.appendChild( n );
							n = ns;
						}
						// Insert newNode in the right place
						if ( nextNode ) {
							commonAncestor.insertBefore( newNode, nextNode );
						} else {
							commonAncestor.appendChild( newNode );
						}
						
						anchor = newNode;
					} else if ( markers[i].anchor == 'tag' ) {
						anchor = commonAncestor;
					}
					$( anchor ).data( 'marker', markers[i] )
						.addClass( 'wikiEditor-highlight' );
					
					// Allow the module adding this marker to manipulate it
					markers[i].afterWrap( anchor, markers[i] );

				} else {
					// Update the marker object
					$( anchor ).data( 'marker', markers[i] );
					markers[i].onSkip( anchor );
				}
				visited[v++] = anchor;
			}
		}
		
		// Remove markers that were previously inserted but weren't passed to this function
		// This function works because visited[] contains the visited elements in order and find() and each()
		// preserve order
		var j = 0;
		context.$content.find( '.wikiEditor-highlight' ).each( function() {
			if ( visited[j] == this ) {
				// This marker is legit, leave it in
				j++;
				return true;
			}
			
			// Remove this marker
			var marker = $(this).data( 'marker' );
			if ( marker && typeof marker.beforeUnwrap == 'function' )
				marker.beforeUnwrap( this );
			if ( ( marker && marker.anchor == 'tag' ) || $(this).is( 'p' ) ) {
				// Remove all classes
				$(this).removeAttr( 'class' );
			} else {
				// Assume anchor == 'wrap'
				if ( $(this).children().size() > 0 ) {
					$(this).replaceWith( $(this).children() );
				} else {
					$(this).replaceWith( $(this).html() );
				}
			}
		});
	}
}

}; })( jQuery );

/* Preview module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.preview = {

/**
 * Compatability map
 */
'browsers': {
	// Left-to-right languages
	'ltr': {
		'msie': [['>=', 7]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 9.6]],
		'safari': [['>=', 4]]
	},
	// Right-to-left languages
	'rtl': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 9.6]],
		'safari': [['>=', 4]]
	}
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates a preview module within a wikiEditor
	 * @param context Context object of editor to create module in
	 * @param config Configuration object to create module from
	 */
	create: function( context, config ) {
		if ( 'initialized' in context.modules.preview ) {
			return;
		}
		context.modules.preview = {
			'initialized': true,
			'previewText': null,
			'changesText': null
		};
		context.modules.preview.$preview = context.fn.addView( {
			'name': 'preview',
			'titleMsg': 'wikieditor-preview-tab',
			'init': function( context ) {
				// Gets the latest copy of the wikitext
				var wikitext = context.fn.getContents();
				// Aborts when nothing has changed since the last preview
				if ( context.modules.preview.previewText == wikitext ) {
					return;
				}
				context.modules.preview.$preview.find( '.wikiEditor-preview-contents' ).empty();
				context.modules.preview.$preview.find( '.wikiEditor-preview-loading' ).show();
				$.post(
					wgScriptPath + '/api.php',
					{
						'action': 'parse',
						'title': wgPageName,
						'text': wikitext,
						'prop': 'text',
						'pst': '',
						'format': 'json'
					},
					function( data ) {
						if (
							typeof data.parse == 'undefined' ||
							typeof data.parse.text == 'undefined' ||
							typeof data.parse.text['*'] == 'undefined'
						) {
							return;
						}
						context.modules.preview.previewText = wikitext;
						context.modules.preview.$preview.find( '.wikiEditor-preview-loading' ).hide();
						context.modules.preview.$preview.find( '.wikiEditor-preview-contents' )
							.html( data.parse.text['*'] )
							.find( 'a:not([href^=#])' ).click( function() { return false; } );
					},
					'json'
				);
			}
		} );
		
		context.$changesTab = context.fn.addView( {
			'name': 'changes',
			'titleMsg': 'wikieditor-preview-changes-tab',
			'init': function( context ) {
				// Gets the latest copy of the wikitext
				var wikitext = context.fn.getContents();
				// Aborts when nothing has changed since the last time
				if ( context.modules.preview.changesText == wikitext ) {
					return;
				}
				context.$changesTab.find( 'table.diff tbody' ).empty();
				context.$changesTab.find( '.wikiEditor-preview-loading' ).show();
				
				// Call the API. First PST the input, then diff it
				var postdata = {
					'action': 'parse',
					'onlypst': '',
					'text': wikitext,
					'format': 'json'
				};
				
				$.post( wgScriptPath + '/api.php', postdata, function( data ) {
					try {
						var postdata2 = {
							'action': 'query',
							'indexpageids': '',
							'prop': 'revisions',
							'titles': wgPageName,
							'rvdifftotext': data.parse.text['*'],
							'rvprop': '',
							'format': 'json'
						};
						var section = $( '[name=wpSection]' ).val();
						if ( section != '' )
							postdata['rvsection'] = section;
						
						$.post( wgScriptPath + '/api.php', postdata2, function( data ) {
								// Add diff CSS
								if ( $( 'link[href=' + stylepath + '/common/diff.css]' ).size() == 0 ) {
									$( 'head' ).append( $( '<link />' ).attr( {
										'rel': 'stylesheet',
										'type': 'text/css',
										'href': stylepath + '/common/diff.css'
									} ) );
								}
								try {
									var diff = data.query.pages[data.query.pageids[0]]
										.revisions[0].diff['*'];
									context.$changesTab.find( 'table.diff tbody' )
										.html( diff );
									context.$changesTab
										.find( '.wikiEditor-preview-loading' ).hide();
									context.modules.preview.changesText = wikitext;
								} catch ( e ) { } // "blah is undefined" error, ignore
							}, 'json'
						);
					} catch( e ) { } // "blah is undefined" error, ignore
				}, 'json' );
			}
		} );
		
		var loadingMsg = mw.usability.getMsg( 'wikieditor-preview-loading' );
		context.modules.preview.$preview
			.add( context.$changesTab )
			.append( $( '<div />' )
				.addClass( 'wikiEditor-preview-loading' )
				.append( $( '<img />' )
					.addClass( 'wikiEditor-preview-spinner' )
					.attr( {
						'src': $.wikiEditor.imgPath + 'dialogs/loading.gif',
						'valign': 'absmiddle',
						'alt': loadingMsg,
						'title': loadingMsg
					} )
				)
				.append(
					$( '<span></span>' ).text( loadingMsg )
				)
			)
			.append( $( '<div />' )
				.addClass( 'wikiEditor-preview-contents' )
			);
		context.$changesTab.find( '.wikiEditor-preview-contents' )
			.html( '<table class="diff"><col class="diff-marker" /><col class="diff-content" />' +
				'<col class="diff-marker" /><col class="diff-content" /><tbody /></table>' );
	}
}

}; } )( jQuery );
/* Publish module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.publish = {

/**
 * Compatability map
 */
'browsers': {
	// Left-to-right languages
	'ltr': {
		'msie': [['>=', 7]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 9.6]],
		'safari': [['>=', 4]]
	},
	// Right-to-left languages
	'rtl': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 9.6]],
		'safari': [['>=', 4]]
	}
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates a publish module within a wikiEditor
	 * @param context Context object of editor to create module in
	 * @param config Configuration object to create module from
	 */
	create: function( context, config ) {
		// Build the dialog behind the Publish button
		var dialogID = 'wikiEditor-' + context.instance + '-dialog';
		$.wikiEditor.modules.dialogs.fn.create(
			context,
			{
				previewsave: {
					id: dialogID,
					titleMsg: 'wikieditor-publish-dialog-title',
					html: '\
						<div class="wikiEditor-dialog-copywarn"></div>\
						<div class="wikiEditor-dialog-editoptions">\
							<form id="wikieditor-' + context.instance + '-publish-dialog-form">\
								<label for="wikiEditor-' + context.instance + '-dialog-summary"\
									rel="wikieditor-publish-dialog-summary"></label>\
								<br />\
								<input type="text" id="wikiEditor-' + context.instance + '-dialog-summary"\
									style="width: 100%;" />\
								<br />\
								<input type="checkbox"\
									id="wikiEditor-' + context.instance + '-dialog-minor" />\
								<label for="wikiEditor-' + context.instance + '-dialog-minor"\
									rel="wikieditor-publish-dialog-minor"></label>\
								<br />\
								<input type="checkbox"\
									id="wikiEditor-' + context.instance + '-dialog-watch" />\
								<label for="wikiEditor-' + context.instance + '-dialog-watch"\
									rel="wikieditor-publish-dialog-watch"></label>\
							</form>\
						</div>',
					init: function() {
						$(this).find( '[rel]' ).each( function() {
							$(this).text( mw.usability.getMsg( $(this).attr( 'rel' ) ) );
						});
						$(this).find( '.wikiEditor-dialog-copywarn' )
							.html( $( '#editpage-copywarn' ).html() );
						
						if ( $( '#wpMinoredit' ).size() == 0 )
							$( '#wikiEditor-' + context.instance + '-dialog-minor' ).hide();
						else if ( $( '#wpMinoredit' ).is( ':checked' ) )
							$( '#wikiEditor-' + context.instance + '-dialog-minor' )
								.attr( 'checked', 'checked' );
						if ( $( '#wpWatchthis' ).size() == 0 )
							$( '#wikiEditor-' + context.instance + '-dialog-watch' ).hide();
						else if ( $( '#wpWatchthis' ).is( ':checked' ) )
							$( '#wikiEditor-' + context.instance + '-dialog-watch' )
								.attr( 'checked', 'checked' );
						
						$(this).find( 'form' ).submit( function( e ) {
							$(this).closest( '.ui-dialog' ).find( 'button:first' ).click();
							e.preventDefault();
						});
					},
					dialog: {
						buttons: {
							'wikieditor-publish-dialog-publish': function() {
								var minorChecked = $( '#wikiEditor-' + context.instance +
									'-dialog-minor' ).is( ':checked' ) ?
										'checked' : '';
								var watchChecked = $( '#wikiEditor-' + context.instance +
									'-dialog-watch' ).is( ':checked' ) ?
										'checked' : '';
								$( '#wpMinoredit' ).attr( 'checked', minorChecked );
								$( '#wpWatchthis' ).attr( 'checked', watchChecked );
								$( '#wpSummary' ).val( $j( '#wikiEditor-' + context.instance +
									'-dialog-summary' ).val() );
								$( '#editform' ).submit();
							},
							'wikieditor-publish-dialog-goback': function() {
								$(this).dialog( 'close' );
							}
						},
						open: function() {
							$( '#wikiEditor-' + context.instance + '-dialog-summary' ).focus();
						},
						width: 500
					},
					resizeme: false
				}
			}
		);
		context.fn.addButton( {
			'captionMsg': 'wikieditor-publish-button-publish',
			'action': function() {
				$( '#' + dialogID ).dialog( 'open' );
				return false;
			}
		} );
		context.fn.addButton( {
			'captionMsg': 'wikieditor-publish-button-cancel',
			'action': function() { }
		} );
	}
}

}; } )( jQuery );
/* TemplateEditor module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.templateEditor = {
/**
 * Compatability map
 */
'browsers': {
	// Left-to-right languages
	'ltr': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]]
	},
	// Right-to-left languages
	'rtl': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]]
	}
},
/**
 * Core Requirements
 */
'req': [ 'iframe' ],
/**
 * Event handlers
 */
evt: {
	mark: function( context, event ) {
		// Get references to the markers and tokens from the current context
		var markers = context.modules.highlight.markers;
		var tokenArray = context.modules.highlight.tokenArray;
		// Collect matching level 0 template call boundaries from the tokenArray
		var level = 0;
		
		var tokenIndex = 0;
		while ( tokenIndex < tokenArray.length ){
			while ( tokenIndex < tokenArray.length && tokenArray[tokenIndex].label != 'TEMPLATE_BEGIN' ) {
				tokenIndex++;
			}
			//open template
			if ( tokenIndex < tokenArray.length ) {
				var beginIndex = tokenIndex;
				var endIndex = -1; //no match found
				var openTemplates = 1;
				var templatesMatched = false;
				while ( tokenIndex < tokenArray.length - 1 && endIndex == -1 ) {
					tokenIndex++;
					if ( tokenArray[tokenIndex].label == 'TEMPLATE_BEGIN' ) {
						openTemplates++;
					} else if ( tokenArray[tokenIndex].label == 'TEMPLATE_END' ) {
						openTemplates--;
						if ( openTemplates == 0 ) {
							endIndex = tokenIndex;
						} //we can stop looping
					}
				}//while finding template ending
				if ( endIndex != -1 ) {
					// Create a model for the template
					var model = new $.wikiEditor.modules.templateEditor.fn.model(
					        context.fn.getContents().substring( tokenArray[beginIndex].offset,
							tokenArray[endIndex].offset
						)
					);
					markers.push( {
						start: tokenArray[beginIndex].offset,
						end: tokenArray[endIndex].offset,
						type: 'template',
						anchor: 'wrap',
						splitPs: model.isCollapsible(),
						afterWrap: $.wikiEditor.modules.templateEditor.fn.stylize,
						beforeUnwrap: function( node ) {
							// FIXME: $( node ).data( 'display' ) doesn't exist any more
							//$( node ).data( 'display' ).remove();
						},
						onSkip: function() { }, // TODO update template info
						getAnchor: function( ca1, ca2 ) {
							// FIXME: Relies on the current <span> structure that is likely to die
							return $( ca1.parentNode ).is( 'span.wikiEditor-template-text' ) ?
								ca1.parentNode : null;
						},
						model: model
					} );
				} else { //else this was an unmatched opening
					tokenArray[beginIndex].label = 'TEMPLATE_FALSE_BEGIN';
					tokenIndex = beginIndex;
				}
			}//if opentemplates
		}
	}
},
/**
 * Regular expressions that produce tokens
 */
exp: [
	{ 'regex': /{{/, 'label': "TEMPLATE_BEGIN" },
	{ 'regex': /}}/, 'label': "TEMPLATE_END", 'markAfter': true }
],
/**
 * Configuration 
 */
cfg: {
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates template form module within wikieditor
	 * @param context Context object of editor to create module in
	 * @param config Configuration object to create module from
	 */
	create: function( context, config ) {
		// Initialize module within the context
		context.modules.templateEditor = {};
	},
	stylize: function( wrappedTemplate ) {
		$( wrappedTemplate ).each( function() {
			if ( typeof $(this).data( 'setupDone' ) != 'undefined' ) {
				// We have a model, so all this init stuff has already happened
				return;
			}
			var model = $(this).data( 'marker' ).model;
			
			//check if model is collapsible
			if ( !model.isCollapsible() ) {
				$(this).addClass( 'wikiEditor-template-text' );
				return;
			}
			
			var $template = $( this )
				.wrap( '<div class="wikiEditor-template"></div>' )
				.addClass( 'wikiEditor-template-text wikiEditor-nodisplay' )
				.parent()
				.addClass( 'wikiEditor-template-collapsed' )
				.data( 'model', model );
			
			$( '<span />' )
			.addClass( 'wikiEditor-template-name wikiEditor-noinclude' )
			.text( model.getName() )
			.mousedown( function(){createDialog( $template );} ) //have to pass template so model stays in sync
			.prependTo( $template );
			
			
			var $options = $( '<ul />' )
			.addClass( 'wikiEditor-template-modes wikiEditor-noinclude' )
			.append( $( '<li />' )
				.addClass( 'wikiEditor-template-action-wikiText' )
				.append( $( '<img />' ).attr( 'src',
					$.wikiEditor.imgPath + 'templateEditor/' + 'wiki-text.png' ) )
				.mousedown( toggleWikiTextEditor ) )
			.insertAfter( $template.find( '.wikiEditor-template-name' ) );
			
			$(this).data( 'setupDone', true );
			
			function toggleWikiTextEditor(){
				var $template = $( this ).closest( '.wikiEditor-template' );
				$template
					.toggleClass( 'wikiEditor-template-expanded' )
					.toggleClass( 'wikiEditor-template-collapsed' );
				var $wikitext = $template.children('.wikiEditor-template-text');
				$wikitext.toggleClass('wikiEditor-nodisplay');
				
				//if we just collapsed this
				if( $template.hasClass('wikiEditor-template-collapsed') ) {
					var model = new $.wikiEditor.modules.templateEditor.fn.model(
						$template.children( '.wikiEditor-template-text' ).text()
					);
					$template.data( 'model' , model );
					$template.children( '.wikiEditor-template-name' ).text( model.getName() );
				}
				else{ //we just expanded this
					$wikitext.text($template.data('model').getText());
				}
				
				return false;
			};
		
			// Expand
			function expandTemplate( $displayDiv ) {
				// Housekeeping
				$displayDiv.removeClass( 'wikiEditor-template-collapsed' );
				$displayDiv.addClass( 'wikiEditor-template-expanded' );
				// remove mousedown hander from the entire thing
				$displayDiv.unbind( 'mousedown' );
				//$displayDiv.text( model.getText() );
				$keyValueTable = $( '<table />' )
					.appendTo( $displayDiv );
				$header_row = $( '<tr />' )
					.appendTo( $keyValueTable );
				$( '<th />' )
					.attr( 'colspan', '2' )
					.text( model.getName() )
					.appendTo( $header_row );
				for( param in model.getAllParamNames() ){
					$keyVal_row = $( '<tr />' )
						.appendTo( $keyValueTable );
					
					$( '<td />' )
						.text( param )
						.appendTo( $keyVal_row );
					$( '<td />' )
						.text( model.getValue( param ) )
						.appendTo( $keyVal_row );
				}
			};
			// Collapse
			function collapseTemplate( $displayDiv ) {
				// Housekeeping
				$displayDiv.addClass( 'wikiEditor-template-collapsed' );
				$displayDiv.removeClass( 'wikiEditor-template-expanded' );
				$displayDiv.text( model.getName() );
			};
			
			
			function createDialog( $templateDiv ){
				var $wikitext = $templateDiv.children('.wikiEditor-template-text');
				//TODO: check if template model has been changed
				var templateModel = new $.wikiEditor.modules.templateEditor.fn.model( $wikitext.text() );
				$templateDiv.data('model', templateModel);
				var $dialog = $("<div></div>");
				var $title =
					$("<div>" + templateModel.getName() + "</div>").addClass('wikiEditor-template-dialog-title');
				var $table = $("<table></table>")
						  .addClass('wikiEditor-template-dialog-table')
						  .appendTo($dialog);
				var allInitialParams = templateModel.getAllInitialParams();
				for( var paramIndex in allInitialParams ){
					var param = allInitialParams[paramIndex];
					if(typeof param.name == 'undefined'){continue;} //param 0 is the name
					var $paramRow = $("<tr></tr>")
							.addClass('wikiEditor-template-dialog-row');
					var $paramName = $("<td></td>")
										.addClass('wikiEditor-template-dialog-name')
										.text( param.name );
					var $paramVal = $("<td></td>")
										.addClass('wikiEditor-template-dialog-value');
					var $paramInput =$("<input></input>")
										.data('name', param.name)
										.val( templateModel.getValue(param.name) );
					$paramVal.append($paramInput);
					$paramRow.append($paramName).append($paramVal);
					$table.append($paramRow);
				}
				//click handler for values
				$("<button></button>").click(function(){
					$('.wikiEditor-template-dialog-value input').each( function(){
						templateModel.setValue( $(this).data('name'), $(this).val() );
					});
					//keep text consistent
					$wikitext.text( templateModel.getText() );
					
					$dialog.dialog('close');
					
				}).text("OK").appendTo($dialog);
				$dialog.dialog(); //opens dialog
				return false;
			};
			
			
			
			
			function toggleWikiText( ) {
				var $template = $( this ).closest( '.wikiEditor-template' );
				$template
					.toggleClass( 'wikiEditor-template-collapsed' )
					.toggleClass( 'wikiEditor-template-expanded' )
					.children( '.wikiEditor-template-text, .wikiEditor-template-name, .wikiEditor-template-modes' )
					.toggleClass( 'wikiEditor-nodisplay' );
				
				//if we just collapsed this
				if( $template.hasClass('wikiEditor-template-collapsed') ) {
					var model = new $.wikiEditor.modules.templateEditor.fn.model(
						$template.children( '.wikiEditor-template-text' ).text()
					);
					$template.data( 'model' , model );
					$template.children( '.wikiEditor-template-name' ).text( model.getName() );
				}
				else{ //else we just expanded this
					$template.children( '.wikiEditor-template-text' ).children('.wikiEditor-template-inner-text').text( 
							$template.data('model')
							.getText()
							.replace(/\{\{/, '')
							.replace(/\}\}$/, '')
					);
					
				}
				return false;
			}
			
		function noEdit() {
			return false;
		}
		
		});
		
	},
	
	
	/**
	 * Gets templateInfo node from templateInfo extension, if it exists
	 */
	getTemplateInfo: function ( templateName ){
		var templateInfo = '';
		//API call here
		return $( templateInfo );
	},
	
	/**
	 * Builds a template model from given wikitext representation, allowing object-oriented manipulation of the contents
	 * of the template while preserving whitespace and formatting.
	 * 
	 * @param wikitext String of wikitext content
	 */
	model: function( wikitext ) {
		
		/* Private members */
		
		var collapsible = true;
		
		/* Private Functions */
		
		/**
		 * Builds a Param object.
		 * 
		 * @param name
		 * @param value
		 * @param number
		 * @param nameIndex
		 * @param equalsIndex
		 * @param valueIndex
		 */
		function Param( name, value, number, nameIndex, equalsIndex, valueIndex ) {
			this.name = name;
			this.value = value;
			this.number = number;
			this.nameIndex = nameIndex;
			this.equalsIndex = equalsIndex;
			this.valueIndex = valueIndex;
		}
		/**
		 * Builds a Range object.
		 * 
		 * @param begin
		 * @param end
		 */
		function Range( begin, end ) {
			this.begin = begin;
			this.end = end;
		}
		/**
		 * Set 'original' to true if you want the original value irrespective of whether the model's been changed
		 * 
		 * @param name
		 * @param value
		 * @param original
		 */
		function getSetValue( name, value, original ) {
			var valueRange;
			var rangeIndex;
			var retVal;
			if ( isNaN( name ) ) {
				// It's a string!
				if ( typeof paramsByName[name] == 'undefined' ) {
					// Does not exist
					return "";
				}
				rangeIndex = paramsByName[name];
			} else {
				// It's a number!
				rangeIndex = parseInt( name );
			}
			if ( typeof params[rangeIndex]  == 'undefined' ) {
				// Does not exist
				return "";
			}
			valueRange = ranges[params[rangeIndex].valueIndex];
			if ( typeof valueRange.newVal == 'undefined' || original ) {
				// Value unchanged, return original wikitext
				retVal = wikitext.substring( valueRange.begin, valueRange.end );
			} else {
				// New value exists, return new value
				retVal = valueRange.newVal;
			}
			if ( value != null ) {
				ranges[params[rangeIndex].valueIndex].newVal = value;
			}
			return retVal;
		};
		
		/* Public Functions */
		
		/**
		 * Get template name
		 */
		this.getName = function() {
			if( typeof ranges[templateNameIndex].newVal == 'undefined' ) {
				return wikitext.substring( ranges[templateNameIndex].begin, ranges[templateNameIndex].end );
			} else {
				return ranges[templateNameIndex].newVal;
			}
		};
		/**
		 * Set template name (if we want to support this)
		 * 
		 * @param name
		 */
		this.setName = function( name ) {
			ranges[templateNameIndex].newVal = name;
		};
		/**
		 * Set value for a given param name / number
		 * 
		 * @param name
		 * @param value
		 */
		this.setValue = function( name, value ) {
			return getSetValue( name, value, false );
		};
		/**
		 * Get value for a given param name / number
		 * 
		 * @param name
		 */
		this.getValue = function( name ) {
			return getSetValue( name, null, false );
		};
		/**
		 * Get original value of a param
		 * 
		 * @param name
		 */
		this.getOriginalValue = function( name ) {
			return getSetValue( name, null, true );
		};
		/**
		 * Get a list of all param names (numbers for the anonymous ones)
		 */
		this.getAllParamNames = function() {
			return paramsByName;
		};
		/**
		 * Get the initial params
		 */
		this.getAllInitialParams = function(){
			return params;
		}
		/**
		 * Get original template text
		 */
		this.getOriginalText = function() {
			return wikitext;
		};
		/**
		 * Get modified template text
		 */
		this.getText = function() {
			newText = "";
			for ( i = 0 ; i < ranges.length; i++ ) {
				if( typeof ranges[i].newVal == 'undefined' ) {
					newText += wikitext.substring( ranges[i].begin, ranges[i].end );
				} else {
					newText += ranges[i].newVal;
				}
			}
			return newText;
		};
		
		this.isCollapsible = function() {
			return collapsible;
		}
		
		/**
		 *  Update ranges if there's been a change in one or more 'segments' of the template.
		 *  Removes adjustment function so adjustment is only made once ever.
		 */

		this.updateRanges = function() {
			var adjustment = 0;
			for (var i = 0 ; i < ranges.length; i++ ) {
				ranges[i].begin += adjustment;
				if( typeof ranges[i].adjust != 'undefined' ) {
					adjustment += ranges[i].adjust();
					// NOTE: adjust should be a function that has the information necessary to calculate the length of
					// this 'segment'
					delete ranges[i].adjust;
				}
				ranges[i].end += adjustment;
			}
		};
		
		
		// Whitespace* {{ whitespace* nonwhitespace:
		if ( wikitext.match( /\s*{{\s*\S*:/ ) ) {
			collapsible = false; // is a parser function
		}
		/*
		 * Take all template-specific characters that are not particular to the template we're looking at, namely {|=},
		 * and convert them into something harmless, in this case 'X'
		 */
		// Get rid of first {{ with whitespace
		var sanatizedStr = wikitext.replace( /{{/, "  " );
		// Replace end
		endBraces = sanatizedStr.match( /}}\s*$/ );
		if ( endBraces ) {
			sanatizedStr = sanatizedStr.substring( 0, endBraces.index ) + "  " +
				sanatizedStr.substring( endBraces.index + 2 );
		}
		
		//treat HTML comments like whitespace
		while ( sanatizedStr.indexOf( '<!' ) != -1 ) {
			startIndex = sanatizedStr.indexOf( '<!' );
			endIndex = sanatizedStr.indexOf('-->') + 3;
			sanatizedSegment = sanatizedStr.substring( startIndex,endIndex ).replace( /\S/g , ' ' );
			sanatizedStr =
				sanatizedStr.substring( 0, startIndex ) + sanatizedSegment + sanatizedStr.substring( endIndex );
		}
		
		// Match the open braces we just found with equivalent closing braces note, works for any level of braces
		while ( sanatizedStr.indexOf( '{{' ) != -1 ) {
			startIndex = sanatizedStr.indexOf( '{{' ) + 1;
			openBraces = 2;
			endIndex = startIndex;
			while ( (openBraces > 0)  && (endIndex < sanatizedStr.length) ) {
				var brace = sanatizedStr[++endIndex];
				openBraces += brace == '}' ? -1 : brace == '{' ? 1 : 0;
			}
			sanatizedSegment = sanatizedStr.substring( startIndex,endIndex ).replace( /[{}|=]/g , 'X' );
			sanatizedStr =
				sanatizedStr.substring( 0, startIndex ) + sanatizedSegment + sanatizedStr.substring( endIndex );
		}
		//links, images, etc, which also can nest
		while ( sanatizedStr.indexOf( '[[' ) != -1 ) {
			startIndex = sanatizedStr.indexOf( '[[' ) + 1;
			openBraces = 2;
			endIndex = startIndex;
			while ( (openBraces > 0)  && (endIndex < sanatizedStr.length) ) {
				var brace = sanatizedStr[++endIndex];
				openBraces += brace == ']' ? -1 : brace == '[' ? 1 : 0;
			}
			sanatizedSegment = sanatizedStr.substring( startIndex,endIndex ).replace( /[\[\]|=]/g , 'X' );
			sanatizedStr =
				sanatizedStr.substring( 0, startIndex ) + sanatizedSegment + sanatizedStr.substring( endIndex );
		}
		
		/*
		 * Parse 1 param at a time
		 */
		var ranges = [];
		var params = [];
		var templateNameIndex = 0;
		var doneParsing = false;
		oldDivider = 0;
		divider = sanatizedStr.indexOf( '|', oldDivider );
		if ( divider == -1 ) {
			divider = sanatizedStr.length;
			doneParsing = true;
			collapsible = false; //zero params
		}
		nameMatch = sanatizedStr.substring( 0, divider ).match( /[^\s]/ );
		if ( nameMatch != null ) {
			ranges.push( new Range( 0 ,nameMatch.index ) ); //whitespace and squiggles upto the name
			nameEndMatch = sanatizedStr.substring( 0 , divider ).match( /[^\s]\s*$/ ); //last nonwhitespace character
			templateNameIndex = ranges.push( new Range( nameMatch.index,
				nameEndMatch.index + 1 ) );
			templateNameIndex--; //push returns 1 less than the array
			ranges[templateNameIndex].old = wikitext.substring( ranges[templateNameIndex].begin,
				ranges[templateNameIndex].end );
		} else {
			ranges.push(new Range(0,0));
			ranges[templateNameIndex].old = "";
		}
		params.push( ranges[templateNameIndex].old ); //put something in params (0)
		/*
		 * Start looping over params
		 */
		var currentParamNumber = 0;
		var valueEndIndex = ranges[templateNameIndex].end;
		var paramsByName = [];
		while ( !doneParsing ) {
			currentParamNumber++;
			oldDivider = divider;
			divider = sanatizedStr.indexOf( '|', oldDivider + 1 );
			if ( divider == -1 ) {
				divider = sanatizedStr.length;
				doneParsing = true;
			}
			currentField = sanatizedStr.substring( oldDivider+1, divider );
			if ( currentField.indexOf( '=' ) == -1 ) {
				// anonymous field, gets a number
				valueBegin = currentField.match( /\S+/ ); //first nonwhitespace character
				if( valueBegin == null ){ //ie
					continue;
				}
				valueBeginIndex = valueBegin.index + oldDivider+1;
				valueEnd = currentField.match( /[^\s]\s*$/ ); //last nonwhitespace character
				if( valueEnd == null ){ //ie
					continue;
				}
				valueEndIndex = valueEnd.index + oldDivider + 2;
				ranges.push( new Range( ranges[ranges.length-1].end,
					valueBeginIndex ) ); //all the chars upto now
				nameIndex = ranges.push( new Range( valueBeginIndex, valueBeginIndex ) ) - 1;
				equalsIndex = ranges.push( new Range( valueBeginIndex, valueBeginIndex ) ) - 1;
				valueIndex = ranges.push( new Range( valueBeginIndex, valueEndIndex ) ) - 1;
				params.push( new Param(
					currentParamNumber,
					wikitext.substring( ranges[valueIndex].begin, ranges[valueIndex].end ),
					currentParamNumber,
					nameIndex,
					equalsIndex,
					valueIndex
				) );
				paramsByName[currentParamNumber] = currentParamNumber;
			} else {
				// There's an equals, could be comment or a value pair
				currentName = currentField.substring( 0, currentField.indexOf( '=' ) );
				// Still offset by oldDivider - first nonwhitespace character
				nameBegin = currentName.match( /\S+/ );
				if ( nameBegin == null ) {
					// This is a comment inside a template call / parser abuse. let's not encourage it
					currentParamNumber--;
					continue;
				}
				nameBeginIndex = nameBegin.index + oldDivider + 1;
				// Last nonwhitespace and non } character
				nameEnd = currentName.match( /[^\s]\s*$/ );
				if( nameEnd == null ){ //ie
					continue;
				}
				nameEndIndex = nameEnd.index + oldDivider + 2;
				// All the chars upto now 
				ranges.push( new Range( ranges[ranges.length-1].end, nameBeginIndex ) );
				nameIndex = ranges.push( new Range( nameBeginIndex, nameEndIndex ) ) - 1;
				currentValue = currentField.substring( currentField.indexOf( '=' ) + 1);
				oldDivider += currentField.indexOf( '=' ) + 1;
				// First nonwhitespace character
				valueBegin = currentValue.match( /\S+/ );
				if( valueBegin == null ){ //ie
					continue;
				}
				valueBeginIndex = valueBegin.index + oldDivider + 1;
				// Last nonwhitespace and non } character
				valueEnd = currentValue.match( /[^\s]\s*$/ );
				if( valueEnd == null ){ //ie
					continue;
				}
				valueEndIndex = valueEnd.index + oldDivider + 2;
				// All the chars upto now
				equalsIndex = ranges.push( new Range( ranges[ranges.length-1].end, valueBeginIndex) ) - 1;
				valueIndex = ranges.push( new Range( valueBeginIndex, valueEndIndex ) ) - 1;
				params.push( new Param(
					wikitext.substring( nameBeginIndex, nameEndIndex ),
					wikitext.substring( valueBeginIndex, valueEndIndex ),
					currentParamNumber,
					nameIndex,
					equalsIndex,
					valueIndex
				) );
				paramsByName[wikitext.substring( nameBeginIndex, nameEndIndex )] = currentParamNumber;
			}
		}
		// The rest of the string
		ranges.push( new Range( valueEndIndex, wikitext.length ) );
		
		// Save vars
		this.ranges = ranges;
		this.wikitext = wikitext;
		this.params = params;
		this.paramsByName = paramsByName;
		this.templateNameIndex = templateNameIndex;
	} // model
}

}; } )( jQuery );
/* TOC Module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.toc = {

/**
 * Compatability map
 */
'browsers': {
	// Left-to-right languages
	'ltr': {
		'msie': [['>=', 7]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]],
		'chrome': [['>=', 4]]
	},
	// Right-to-left languages
	'rtl': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]],
		'chrome': [['>=', 4]]
	}
},
/**
 * Core Requirements
 */
'req': [ 'iframe' ],
/**
 * Configuration
 */
cfg: {
	// Default width of table of contents
	defaultWidth: '166px',
	// Minimum width to allow resizing to before collapsing the table of contents - used when resizing and collapsing
	minimumWidth: '70px',
	// Minimum width of the wikiText area
	textMinimumWidth: '450px',
	// The style property to be used for positioning the flexible module in regular mode
	flexProperty: 'marginRight',
	// Boolean var indicating text direction
	rtl: false
},
/**
 * API accessible functions
 */
api: {
	//
},
/**
 * Event handlers
 */
evt: {
	change: function( context, event ) {
		$.wikiEditor.modules.toc.fn.update( context );
	},
	ready: function( context, event ) {
		// Add the TOC to the document
		$.wikiEditor.modules.toc.fn.build( context );
		context.$content.parent()
			.blur( function() {
				var context = event.data.context;
				$.wikiEditor.modules.toc.fn.unhighlight( context );
			});
		$.wikiEditor.modules.toc.evt.resize( context );
	},
	resize: function( context, event ) {
		var availableWidth = context.$wikitext.width() - parseFloat( $.wikiEditor.modules.toc.cfg.textMinimumWidth ),
			totalMinWidth = parseFloat( $.wikiEditor.modules.toc.cfg.minimumWidth ) + 
				parseFloat( $.wikiEditor.modules.toc.cfg.textMinimumWidth );
		context.$ui.find( '.wikiEditor-ui-right' )
			.resizable( 'option', 'maxWidth', availableWidth );
		if ( context.modules.toc.$toc.data( 'positionMode' ) != 'disabled' && 
			context.$wikitext.width() < totalMinWidth ) {
				$.wikiEditor.modules.toc.fn.disable( context );
		} else if ( context.modules.toc.$toc.data( 'positionMode' ) == 'disabled'  &&
			context.$wikitext.width() >  totalMinWidth ) {
				$.wikiEditor.modules.toc.fn.enable( context );
		} else if ( context.modules.toc.$toc.data( 'positionMode' ) == 'regular'  &&
			context.$ui.find( '.wikiEditor-ui-right' ).width() > availableWidth ) {
			//switch mode
			$.wikiEditor.modules.toc.fn.switchLayout( context );
		} else if ( context.modules.toc.$toc.data( 'positionMode' ) == 'goofy'  &&
			context.modules.toc.$toc.data( 'previousWidth' ) < context.$wikitext.width() ) {
			//switch mode
			$.wikiEditor.modules.toc.fn.switchLayout( context );
		}
		if ( context.modules.toc.$toc.data( 'positionMode' ) == 'goofy' ) {
			context.modules.toc.$toc.find( 'div' ).autoEllipsis(
				{ 'position': 'right', 'tooltip': true, 'restoreText': true }
			);
		}
		// reset the height of the TOC
		if ( !context.modules.toc.$toc.data( 'collapsed' ) ){
			context.modules.toc.$toc.height(
				context.$ui.find( '.wikiEditor-ui-left' ).height() - 
				context.$ui.find( '.tab-toc' ).outerHeight()
			);
		}

		// store the width of the view for comparison on next resize
		context.modules.toc.$toc.data( 'previousWidth', context.$wikitext.width() );
	},
	mark: function( context, event ) {
		var hash = '';
		var markers = context.modules.highlight.markers;
		var tokenArray = context.modules.highlight.tokenArray;
		var outline = context.data.outline = [];
		var h = 0;
		for ( var i = 0; i < tokenArray.length; i++ ) {
			if ( tokenArray[i].label != 'TOC_HEADER' ) {
				continue;
			}
			h++;
			markers.push( {
				index: h,
				start: tokenArray[i].tokenStart,
				end: tokenArray[i].offset,
				type: 'toc',
				anchor: 'tag',
				splitPs: false,
				afterWrap: function( node ) {
					var marker = $( node ).data( 'marker' );
					$( node ).addClass( 'wikiEditor-toc-header' )
						.addClass( 'wikiEditor-toc-section-' + marker.index )
						.data( 'section', marker.index );
				},
				beforeUnwrap: function( node ) {
					$( node ).removeClass( 'wikiEditor-toc-header' )
						.removeClass( 'wikiEditor-toc-section-' + $( node ).data( 'section' ) );
				},
				onSkip: function( node ) {
					var marker = $( node ).data( 'marker' );
					if ( $( node ).data( 'section' ) != marker.index ) {
						$( node )
							.removeClass( 'wikiEditor-toc-section-' + $( node ).data( 'section' ) )
							.addClass( 'wikiEditor-toc-section-' + marker.index )
							.data( 'section', marker.index );
					}
				},
				getAnchor: function( ca1, ca2 ) {
					return $( ca1.parentNode ).is( '.wikiEditor-toc-header' ) ?
						ca1.parentNode : null;
				}
			} );
			hash += tokenArray[i].match[2] + '\n';
			outline.push ( {
				'text': tokenArray[i].match[2],
				'level': tokenArray[i].match[1].length,
				'index': h
			} );
		}
		// Only update the TOC if it's been changed - we do this by comparing a hash of the headings this time to last
		if ( typeof context.modules.toc.lastHash == 'undefined' || context.modules.toc.lastHash !== hash ) {
			$.wikiEditor.modules.toc.fn.build( context );
			$.wikiEditor.modules.toc.fn.update( context );
			// Remember the changed version
			context.modules.toc.lastHash = hash;
		}
	}
},
exp: [
	{ 'regex': /^(={1,6})([^\r\n]+?)\1\s*$/m, 'label': 'TOC_HEADER', 'markAfter': true }
],
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates a table of contents module within a wikiEditor
	 *
	 * @param {Object} context Context object of editor to create module in
	 * @param {Object} config Configuration object to create module from
	 */
	create: function( context, config ) {
		if ( '$toc' in context.modules.toc ) {
			return;
		}
		$.wikiEditor.modules.toc.cfg.rtl = config.rtl;
		$.wikiEditor.modules.toc.cfg.flexProperty = config.rtl ? 'marginLeft' : 'marginRight';
		var height = context.$ui.find( '.wikiEditor-ui-left' ).height();
		context.modules.toc.$toc = $( '<div />' )
			.addClass( 'wikiEditor-ui-toc' )
			.data( 'context', context )
			.data( 'positionMode', 'regular' )
			.data( 'collapsed', false );
			context.$ui.find( '.wikiEditor-ui-right' )
				.append( context.modules.toc.$toc );
			context.modules.toc.$toc.height(
				context.$ui.find( '.wikiEditor-ui-left' ).height()
			);
			$.wikiEditor.modules.toc.fn.redraw( context, $.wikiEditor.modules.toc.cfg.defaultWidth );
		},
		
	
	redraw: function( context, fixedWidth ) {
		var fixedWidth = parseFloat( fixedWidth );
		if( context.modules.toc.$toc.data( 'positionMode' ) == 'regular' ) {
			context.$ui.find( '.wikiEditor-ui-right' )
			.css( 'width', fixedWidth + 'px' );
			context.$ui.find( '.wikiEditor-ui-left' )
				.css( $.wikiEditor.modules.toc.cfg.flexProperty, ( -1 * fixedWidth ) + 'px' )
				.children()
				.css( $.wikiEditor.modules.toc.cfg.flexProperty, fixedWidth + 'px' );
		} else if( context.modules.toc.$toc.data( 'positionMode' ) == 'goofy' ) {
			context.$ui.find( '.wikiEditor-ui-left' )
				.css( 'width', fixedWidth );
			context.$ui.find( '.wikiEditor-ui-right' )
				.css( $.wikiEditor.modules.toc.cfg.rtl ? 'right': 'left', fixedWidth );
			context.$wikitext.css( 'height', context.$ui.find( '.wikiEditor-ui-right' ).height() );
		}
	},
	switchLayout: function( context ) {
		var width,
			height = context.$ui.find( '.wikiEditor-ui-right' ).height();
		if( context.modules.toc.$toc.data( 'positionMode' ) == 'regular'
		 	&& !context.modules.toc.$toc.data( 'collapsed' ) ) {
			// store position mode
			context.modules.toc.$toc.data( 'positionMode', 'goofy' );
			// store the width of the TOC, to ensure we dont allow it to be larger than this when switching back
			context.modules.toc.$toc.data( 'positionModeChangeAt', 
				context.$ui.find( '.wikiEditor-ui-right' ).width() );
			width = $.wikiEditor.modules.toc.cfg.textMinimumWidth;
			// set our styles for goofy mode
			context.$ui.find( '.wikiEditor-ui-left' )
				.css( $.wikiEditor.modules.toc.cfg.flexProperty, '')
				.css( { 'position': 'absolute', 'float': 'none',
					'left': $.wikiEditor.modules.toc.cfg.rtl ? 'auto': 0, 
					'right' : $.wikiEditor.modules.toc.cfg.rtl ? 0 : 'auto' } )
				.children()
				.css( $.wikiEditor.modules.toc.cfg.flexProperty, '' );
			context.$ui.find( '.wikiEditor-ui-right' )
				.css( { 'width': 'auto', 'position': 'absolute', 'float': 'none',
				'right': $.wikiEditor.modules.toc.cfg.rtl ? 'auto': 0, 
				'left' : $.wikiEditor.modules.toc.cfg.rtl ? 0 : 'auto' } );
			context.$wikitext
				.css( 'position', 'relative' );
		} else if ( context.modules.toc.$toc.data( 'positionMode' ) == 'goofy' ) {
			// store position mode
			context.modules.toc.$toc.data( 'positionMode', 'regular' );
			// set width
			width = context.$wikitext.width() - context.$ui.find( '.wikiEditor-ui-left' ).width();
			if ( width > context.modules.toc.$toc.data( 'positionModeChangeAt' ) ) {
				width = context.modules.toc.$toc.data( 'positionModeChangeAt' );
			}
			// set our styles for regular mode
			context.$wikitext
				.css( { 'position': '', 'height': '' } );
			context.$ui.find( '.wikiEditor-ui-right' )
				.css( $.wikiEditor.modules.toc.cfg.flexProperty, '' )
				.css( { 'position': '', 'left': '', 'right': '', 'float': '', 'top': '', 'height': '' } );
			context.$ui.find( '.wikiEditor-ui-left' )
				.css( { 'width': '', 'position': '', 'left': '', 'float': '', 'right': '' } );
		}
		$.wikiEditor.modules.toc.fn.redraw( context, width );
	},
	disable: function( context ) {
		if ( context.modules.toc.$toc.data( 'collapsed' ) ) {
			context.$ui.find( '.wikiEditor-ui-toc-expandControl' ).hide();
		} else {
			if( context.modules.toc.$toc.data( 'positionMode' ) == 'goofy' ) {
				$.wikiEditor.modules.toc.fn.switchLayout( context );
			}
			context.$ui.find( '.wikiEditor-ui-right' ).hide();
			context.$ui.find( '.wikiEditor-ui-left' )
				.css( $.wikiEditor.modules.toc.cfg.flexProperty, '' )
				.children()
				.css( $.wikiEditor.modules.toc.cfg.flexProperty, '' );
		}
		context.modules.toc.$toc.data( 'positionMode', 'disabled' );
	},
	enable: function( context ) {
		context.modules.toc.$toc.data( 'positionMode', 'regular' );
		if ( context.modules.toc.$toc.data( 'collapsed' ) ) {
			context.$ui.find( '.wikiEditor-ui-toc-expandControl' ).show();
		} else {
			context.$ui.find( '.wikiEditor-ui-right' ).show();
			$.wikiEditor.modules.toc.fn.redraw( context, $.wikiEditor.modules.toc.cfg.minimumWidth );
			context.modules.toc.$toc.find( 'div' ).autoEllipsis(
				{ 'position': 'right', 'tooltip': true, 'restoreText': true }
			);
		}
	},
	unhighlight: function( context ) {
		// FIXME: For some reason, IE calls this function twice, the first time with context undefined
		// Investigate this when you have time please! In the meantime, the user interaction is working just
		// fine because the second call is valid
		if ( context ) {
			context.modules.toc.$toc.find( 'div' ).removeClass( 'current' );
		}
	},
	/**
	 * Highlight the section the cursor is currently within
	 *
	 * @param {Object} context
	 */
	update: function( context ) {
		var div = context.fn.beforeSelection( 'wikiEditor-toc-header' );
		if ( div === null ) {
			// beforeSelection couldn't figure it out, keep the old highlight state
			return;
		}
		
		$.wikiEditor.modules.toc.fn.unhighlight( context );
		var section = div.data( 'section' ) || 0;
		if ( context.data.outline.length > 0 ) {
			var sectionLink = context.modules.toc.$toc.find( 'div.section-' + section );
			sectionLink.addClass( 'current' );
			
			// Scroll the highlighted link into view if necessary
			var relTop = sectionLink.offset().top - context.modules.toc.$toc.offset().top;
			var scrollTop = context.modules.toc.$toc.scrollTop();
			var divHeight = context.modules.toc.$toc.height();
			var sectionHeight = sectionLink.height();
			if ( relTop < 0 )
				// Scroll up
				context.modules.toc.$toc.scrollTop( scrollTop + relTop );
			else if ( relTop + sectionHeight > divHeight )
				// Scroll down
				context.modules.toc.$toc.scrollTop( scrollTop + relTop + sectionHeight - divHeight );
		}
	},
	
	/**
	 * Collapse the contents module
	 *
	 * @param {Object} event Event object with context as data
	 */
	collapse: function( event ) {
		var $this = $( this ), 
			context = $this.data( 'context' );
		if( context.modules.toc.$toc.data( 'positionMode' ) == 'goofy' ) {
			$.wikiEditor.modules.toc.fn.switchLayout( context );
		}
		var pT = $this.parent().position().top - 1;
		context.modules.toc.$toc.data( 'collapsed', true );
		var leftParam = {}, leftChildParam = {};
		leftParam[ $.wikiEditor.modules.toc.cfg.flexProperty ] = '-1px';
		leftChildParam[ $.wikiEditor.modules.toc.cfg.flexProperty ] = '1px';
		context.$ui.find( '.wikiEditor-ui-left' )
			.animate( leftParam, 'fast', function() {
				$( this ).css( $.wikiEditor.modules.toc.cfg.flexProperty, 0 );
			} )
			.children()
			.animate( leftChildParam, 'fast',  function() { 
				$( this ).css( $.wikiEditor.modules.toc.cfg.flexProperty, 0 ); 
			} );
		context.$ui.find( '.wikiEditor-ui-right' )
			.css( { 
				'marginTop' : '1px', 
				'position' : 'absolute', 
				'left' : $.wikiEditor.modules.toc.cfg.rtl ? 0 : 'auto', 
				'right' : $.wikiEditor.modules.toc.cfg.rtl ? 'auto' : 0, 
				'top' : pT } )
			.fadeOut( 'fast', function() {
				$( this ).hide()
				.css( { 'marginTop': '0', 'width': '1px' } );
				context.$ui.find( '.wikiEditor-ui-toc-expandControl' ).fadeIn( 'fast' );
				// Let the UI know things have moved around
				context.fn.trigger( 'tocCollapse' );
				context.fn.trigger( 'resize' );
			 } );
			
		$.cookie( 'wikiEditor-' + context.instance + '-toc-width', 0 );
		return false;
	},
	
	/**
	 * Expand the contents module
	 *
	 * @param {Object} event Event object with context as data
	 */
	expand: function( event ) {
		var $this = $( this ),
			context = $this.data( 'context' ),
			openWidth = parseFloat( context.modules.toc.$toc.data( 'openWidth' ) ),
			availableSpace = context.$wikitext.width() - parseFloat( $.wikiEditor.modules.toc.cfg.textMinimumWidth );
		if ( availableSpace < $.wikiEditor.modules.toc.cfg.textMinmumWidth ) return false;
		context.modules.toc.$toc.data( 'collapsed', false );
		// check if we've got enough room to open to our stored width
		if ( availableSpace < openWidth ) openWidth = availableSpace;
		context.$ui.find( '.wikiEditor-ui-toc-expandControl' ).hide();
		var leftParam = {}, leftChildParam = {};
		leftParam[ $.wikiEditor.modules.toc.cfg.flexProperty ] = parseFloat( openWidth ) * -1;
		leftChildParam[ $.wikiEditor.modules.toc.cfg.flexProperty ] = openWidth;
		context.$ui.find( '.wikiEditor-ui-left' )
			.animate( leftParam, 'fast' )
			.children()
			.animate( leftChildParam, 'fast' );
		context.$ui.find( '.wikiEditor-ui-right' )
			.show()
			.css( 'marginTop', '1px' )
			.animate( { 'width' : openWidth }, 'fast', function() {
				context.$content.trigger( 'mouseup' );
				$( this ).css( {
					'marginTop' : '0',
					'position' : 'relative',
					'right' : 'auto',
					'left' : 'auto',
					'top': 'auto' } );
					context.fn.trigger( 'tocExpand' );
					context.fn.trigger( 'resize' );
			 } );
		$.cookie( 'wikiEditor-' + context.instance + '-toc-width',
			context.modules.toc.$toc.data( 'openWidth' ) );
		return false;
	},
	/**
	 * Builds table of contents
	 *
	 * @param {Object} context
	 */
	build: function( context ) {
		/**
		 * Builds a structured outline from flat outline
		 *
		 * @param {Object} outline Array of objects with level fields
		 */
		function buildStructure( outline, offset, level ) {
			if ( offset == undefined ) offset = 0;
			if ( level == undefined ) level = 1;
			var sections = [];
			for ( var i = offset; i < outline.length; i++ ) {
				if ( outline[i].nLevel == level ) {
					var sub = buildStructure( outline, i + 1, level + 1 );
					if ( sub.length ) {
						outline[i].sections = sub;
					}
					sections[sections.length] = outline[i];
				} else if ( outline[i].nLevel < level ) {
					break;
				}
			}
			return sections;
		}
		/**
		 * Builds unordered list HTML object from structured outline
		 *
		 * @param {Object} structure Structured outline
		 */
		function buildList( structure ) {
			var list = $( '<ul />' );
			for ( i in structure ) {
				var div = $( '<div />' )
					.addClass( 'section-' + structure[i].index )
					.data( 'index', structure[i].index )
					.mousedown( function() {
						// No dragging!
						return false;
					} )
					.click( function( event ) {
						var wrapper = context.$content.find(
							'.wikiEditor-toc-section-' + $( this ).data( 'index' ) );
						if ( wrapper.size() == 0 )
							wrapper = context.$content;
						context.fn.scrollToTop( wrapper, true );
						context.$textarea.textSelection( 'setSelection', {
							'start': 0,
							'startContainer': wrapper
						} );
						// Highlight the clicked link
						$.wikiEditor.modules.toc.fn.unhighlight( context );
						$( this ).addClass( 'current' );
						
						if ( typeof $.trackAction != 'undefined' )
							$.trackAction( 'ntoc.heading' );
						event.preventDefault();
					} )
					.text( structure[i].text );
				if ( structure[i].text == '' )
					div.html( '&nbsp;' );
				var item = $( '<li />' ).append( div );
				if ( structure[i].sections !== undefined ) {
					item.append( buildList( structure[i].sections ) );
				}
				list.append( item );
			}
			return list;
		}
		/**
		 * Builds controls for collapsing and expanding the TOC
		 *
		 */
		function buildCollapseControls( ) {
			var $collapseControl = $( '<div />' ), $expandControl = $( '<div />' );
			$collapseControl
				.addClass( 'tab' )
				.addClass( 'tab-toc' )
				.append( '<a href="#" />' )
				.mousedown( function() {
					// No dragging!
					return false;
				} )
				.bind( 'click.wikiEditor-toc', function() {
					context.modules.toc.$toc.trigger( 'collapse.wikiEditor-toc' ); return false;
				} )
				.find( 'a' )
				.text( mw.usability.getMsg( 'wikieditor-toc-hide' ) );
			$expandControl
				.addClass( 'wikiEditor-ui-toc-expandControl' )
				.append( '<a href="#" />' )
				.mousedown( function() {
					// No dragging!
					return false;
				} )
				.bind( 'click.wikiEditor-toc', function() {
					context.modules.toc.$toc.trigger( 'expand.wikiEditor-toc' ); return false;
				} )
				.hide()
				.find( 'a' )
				.text( mw.usability.getMsg( 'wikieditor-toc-show' ) );
			$collapseControl.insertBefore( context.modules.toc.$toc );
			context.$ui.find( '.wikiEditor-ui-left .wikiEditor-ui-top' ).append( $expandControl );
		}
		/**
		 * Initializes resizing controls on the TOC and sets the width of
		 * the TOC based on it's previous state
		 *
		 */
		function buildResizeControls( ) {
			context.$ui
				.data( 'resizableDone', true )
				.find( '.wikiEditor-ui-right' )
				.data( 'wikiEditor-ui-left', context.$ui.find( '.wikiEditor-ui-left' ) )
				.resizable( { handles: 'w,e', preventPositionLeftChange: true, 
					minWidth: parseFloat( $.wikiEditor.modules.toc.cfg.minimumWidth ),
					start: function( e, ui ) {
						var $this = $( this );
						// Toss a transparent cover over our iframe
						$( '<div />' )
							.addClass( 'wikiEditor-ui-resize-mask' )
							.css( {
								'position': 'absolute',
								'z-index': 2,
								'left': 0,
								'top': 0,
								'bottom': 0,
								'right': 0
							} )
							.appendTo( context.$ui.find( '.wikiEditor-ui-left' ) );
						$this.resizable( 'option', 'maxWidth', $this.parent().width() - 
							parseFloat( $.wikiEditor.modules.toc.cfg.textMinimumWidth ) );
						if(context.modules.toc.$toc.data( 'positionMode' ) == 'goofy' ) {
							$.wikiEditor.modules.toc.fn.switchLayout( context );
						}
					},
					resize: function( e, ui ) {
						// for some odd reason, ui.size.width seems a step ahead of what the *actual* width of
						// the resizable is
						$( this ).css( { 'width': ui.size.width, 'top': 'auto', 'height': 'auto' } )
							.data( 'wikiEditor-ui-left' )
								.css( $.wikiEditor.modules.toc.cfg.flexProperty, ( -1 * ui.size.width ) )
							.children().css( $.wikiEditor.modules.toc.cfg.flexProperty, ui.size.width );
						// Let the UI know things have moved around
						context.fn.trigger( 'resize' );
					},
					stop: function ( e, ui ) {
						context.$ui.find( '.wikiEditor-ui-resize-mask' ).remove();
						context.$content.trigger( 'mouseup' );
						if( ui.size.width <= parseFloat( $.wikiEditor.modules.toc.cfg.minimumWidth ) ) {
							context.modules.toc.$toc.trigger( 'collapse.wikiEditor-toc' );
						} else {
							context.modules.toc.$toc.find( 'div' ).autoEllipsis(
								{ 'position': 'right', 'tooltip': true, 'restoreText': true }
							);
							context.modules.toc.$toc.data( 'openWidth', ui.size.width );
							$.cookie( 'wikiEditor-' + context.instance + '-toc-width', ui.size.width );
						}
						// Let the UI know things have moved around
						context.fn.trigger( 'resize' );
					}
				});
			// Convert our east resize handle into a secondary west resize handle
			var handle = $.wikiEditor.modules.toc.cfg.rtl ? 'w' : 'e';
			context.$ui.find( '.ui-resizable-' + handle )
				.removeClass( 'ui-resizable-' + handle )
				.addClass( 'ui-resizable-' + ( handle == 'w' ? 'e' : 'w' ) )
				.addClass( 'wikiEditor-ui-toc-resize-grip' );
			// Bind collapse and expand event handlers to the TOC
			context.modules.toc.$toc
				.bind( 'collapse.wikiEditor-toc', $.wikiEditor.modules.toc.fn.collapse )
				.bind( 'expand.wikiEditor-toc', $.wikiEditor.modules.toc.fn.expand  );
			context.modules.toc.$toc.data( 'openWidth', $.wikiEditor.modules.toc.cfg.defaultWidth );
			// If the toc-width cookie is set, reset the widths based upon that
			if ( $.cookie( 'wikiEditor-' + context.instance + '-toc-width' ) == 0 ) {
				context.modules.toc.$toc.trigger( 'collapse.wikiEditor-toc', { data: context } );
			} else if ( $.cookie( 'wikiEditor-' + context.instance + '-toc-width' ) > 0 ) {
				var initialWidth = $.cookie( 'wikiEditor-' + context.instance + '-toc-width' );
				if( initialWidth < parseFloat( $.wikiEditor.modules.toc.cfg.minimumWidth ) )
					initialWidth = parseFloat( $.wikiEditor.modules.toc.cfg.minimumWidth ) + 1;
				context.modules.toc.$toc.data( 'openWidth', initialWidth + 'px' );
				$.wikiEditor.modules.toc.fn.redraw( context, initialWidth );
			}
		}
		
		// Normalize heading levels for list creation
		// This is based on Linker::generateTOC(), so it should behave like the
		// TOC on rendered articles does - which is considdered to be correct
		// at this point in time.
		if ( context.data.outline ) {
			var outline = context.data.outline;
			var lastLevel = 0;
			var nLevel = 0;
			for ( var i = 0; i < outline.length; i++ ) {
				if ( outline[i].level > lastLevel ) {
					nLevel++;
				}
				else if ( outline[i].level < lastLevel ) {
					nLevel -= Math.max( 1, lastLevel - outline[i].level );
				}
				if ( nLevel <= 0 ) {
					nLevel = 1;
				}
				outline[i].nLevel = nLevel;
				lastLevel = outline[i].level;
			}
			// Recursively build the structure and add special item for
			// section 0, if needed
			var structure = buildStructure( outline );
			if ( $( 'input[name=wpSection]' ).val() == '' ) {
				structure.unshift( { 'text': wgPageName.replace( /_/g, ' ' ), 'level': 1, 'index': 0 } );
			}
			context.modules.toc.$toc.html( buildList( structure ) );
			
			if ( wgNavigableTOCResizable && !context.$ui.data( 'resizableDone' ) ) {
				buildResizeControls();
				buildCollapseControls();
			}
			context.modules.toc.$toc.find( 'div' ).autoEllipsis(
				{ 'position': 'right', 'tooltip': true, 'restoreText': true }
			);
		}
	}
}

};

/*
 * Extending resizable to allow west resizing without altering the left position attribute
 */
$.ui.plugin.add( "resizable", "preventPositionLeftChange", {
	resize: function( event, ui ) {
		$( this ).data( "resizable" ).position.left = 0;
	}
} );
 
} ) ( jQuery );
/**
 * Toolbar module for wikiEditor
 */
( function( $ ) { $.wikiEditor.modules.toolbar = {

/**
 * API accessible functions
 */
api : {
	addToToolbar : function( context, data ) {
		for ( type in data ) {
			switch ( type ) {
				case 'sections':
					var $sections = context.modules.toolbar.$toolbar.find( 'div.sections' );
					var $tabs = context.modules.toolbar.$toolbar.find( 'div.tabs' );
					for ( section in data[type] ) {
						if ( section == 'main' ) {
							// Section
							context.modules.toolbar.$toolbar.prepend(
								$.wikiEditor.modules.toolbar.fn.buildSection(
									context, section, data[type][section]
								)
							);
							continue;
						}
						// Section
						$sections.append(
							$.wikiEditor.modules.toolbar.fn.buildSection( context, section, data[type][section] )
						);
						// Tab
						$tabs.append(
							$.wikiEditor.modules.toolbar.fn.buildTab( context, section, data[type][section] )
						);
						// Update visibility of section
						$section = $sections.find( '.section:visible' );
						if ( $section.size() ) {
							$sections.animate( { 'height': $section.outerHeight() }, 'fast' );
						}
					}
					break;
				case 'groups':
					if ( ! ( 'section' in data ) ) {
						continue;
					}
					var $section = context.modules.toolbar.$toolbar.find( 'div[rel=' + data.section + '].section' );
					for ( group in data[type] ) {
						// Group
						$section.append(
							$.wikiEditor.modules.toolbar.fn.buildGroup( context, group, data[type][group] )
						);
					}
					break;
				case 'tools':
					if ( ! ( 'section' in data && 'group' in data ) ) {
						continue;
					}
					var $group = context.modules.toolbar.$toolbar.find(
						'div[rel=' + data.section + '].section ' + 'div[rel=' + data.group + '].group'
					);
					for ( tool in data[type] ) {
						// Tool
						$group.append( $.wikiEditor.modules.toolbar.fn.buildTool( context, tool,data[type][tool] ) );
					}
					if ( $group.children().length ) {
						$group.show();
					}
					break;
				case 'pages':
					if ( ! ( 'section' in data ) ) {
						continue;
					}
					var $pages = context.modules.toolbar.$toolbar.find(
						'div[rel=' + data.section + '].section .pages'
					);
					var $index = context.modules.toolbar.$toolbar.find(
						'div[rel=' + data.section + '].section .index'
					);
					for ( page in data[type] ) {
						// Page
						$pages.append( $.wikiEditor.modules.toolbar.fn.buildPage( context, page, data[type][page] ) );
						// Index
						$index.append(
							$.wikiEditor.modules.toolbar.fn.buildBookmark( context, page, data[type][page] )
						);
					}
					$.wikiEditor.modules.toolbar.fn.updateBookletSelection( context, page, $pages, $index );
					break;
				case 'rows':
					if ( ! ( 'section' in data && 'page' in data ) ) {
						continue;
					}
					var $table = context.modules.toolbar.$toolbar.find(
						'div[rel=' + data.section + '].section ' + 'div[rel=' + data.page + '].page table'
					);
					for ( row in data[type] ) {
						// Row
						$table.append( $.wikiEditor.modules.toolbar.fn.buildRow( context, data[type][row] ) );
					}
					break;
				case 'characters':
					if ( ! ( 'section' in data && 'page' in data ) ) {
						continue;
					}
					$characters = context.modules.toolbar.$toolbar.find(
						'div[rel=' + data.section + '].section ' + 'div[rel=' + data.page + '].page div'
					);
					var actions = $characters.data( 'actions' );
					for ( character in data[type] ) {
						// Character
						$characters
						.append(
							$( $.wikiEditor.modules.toolbar.fn.buildCharacter( data[type][character], actions ) )
								.click( function() {
									$.wikiEditor.modules.toolbar.fn.doAction( $(this).parent().data( 'context' ),
										$(this).parent().data( 'actions' )[$(this).attr( 'rel' )] );
									return false;
								} )
						);
					}
					break;
				default: break;
			}
		}
	},
	removeFromToolbar : function( context, data ) {
		if ( typeof data.section == 'string' ) {
			// Section
			var tab = 'div.tabs span[rel=' + data.section + '].tab';
			var target = 'div[rel=' + data.section + '].section';
			var group = null;
			if ( typeof data.group == 'string' ) {
				// Toolbar group
				target += ' div[rel=' + data.group + '].group';
				if ( typeof data.tool == 'string' ) {
					// Save for later checking if empty
					group = target;
					// Tool
					target += ' div[rel=' + data.tool + '].tool';
				}
			} else if ( typeof data.page == 'string' ) {
				// Booklet page
				var index = target + ' div.index div[rel=' + data.page + ']';
				target += ' div.pages div[rel=' + data.page + '].page';
				if ( typeof data.character == 'string' ) {
					// Character
					target += ' a[rel=' + data.character + ']';
				} else if ( typeof data.row == 'number' ) {
					// Table row
					target += ' table tr:not(:has(th)):eq(' + data.row + ')';
				} else {
					// Just a page, remove the index too!
					context.modules.toolbar.$toolbar.find( index ).remove();
					$.wikiEditor.modules.toolbar.fn.updateBookletSelection(
						context,
						null,
						context.modules.toolbar.$toolbar.find( target ),
						context.modules.toolbar.$toolbar.find( index )
					);
				}
			} else {
				// Just a section, remove the tab too!
				context.modules.toolbar.$toolbar.find( tab ).remove();
			}
			context.modules.toolbar.$toolbar.find( target ).remove();
			// Hide empty groups
			if ( group ) {
				$group = context.modules.toolbar.$toolbar.find( group );
				if ( $group.children().length == 0 ) {
					$group.hide();
				}
			}
		}
	}
},
/**
 * Event handlers
 */
evt: {
	resize: function( context, event ) {
		context.$ui.find( '.sections' ).height( context.$ui.find( '.sections .section:visible' ).outerHeight() );
	},
	tocCollapse: function( context, event ) {
		$.wikiEditor.modules.toolbar.evt.resize( context, event );
	},
	tocExpand: function( context, event ) {
		$.wikiEditor.modules.toolbar.evt.resize( context, event );
	}
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates a toolbar module within a wikiEditor
	 *
	 * @param {Object} context Context object of editor to create module in
	 * @param {Object} config Configuration object to create module from
	 */
	create : function( context, config ) {
		if ( '$toolbar' in context.modules.toolbar ) {
			return;
		}
		context.modules.toolbar.$toolbar = $( '<div />' )
			.addClass( 'wikiEditor-ui-toolbar' )
			.attr( 'id', 'wikiEditor-ui-toolbar' );
		$.wikiEditor.modules.toolbar.fn.build( context, config );
		context.$ui.find( '.wikiEditor-ui-top' ).append( context.modules.toolbar.$toolbar );
	},
	/**
	 * Performs an operation based on parameters
	 *
	 * @param {Object} context
	 * @param {Object} action
	 * @param {Object} source
	 */
	doAction : function( context, action, source ) {
		// Verify that this has been called from a source that's within the toolbar
		// 'trackAction' defined in click tracking
		if ( $.trackAction != undefined && source.closest( '.wikiEditor-ui-toolbar' ).size() ) {
			// Build a unique id for this action by tracking the parent rel attributes up to the toolbar level
			var rels = [];
			var step = source;
			var i = 0;
			while ( !step.hasClass( 'wikiEditor-ui-toolbar' ) ) {
				if ( i > 25 ) {
					break;
				}
				i++;
				var rel = step.attr( 'rel' );
				if ( rel ) {
					rels.push( step.attr( 'rel' ) );
				}
				step = step.parent();
			}
			rels.reverse();
			var id = rels.join( '.' );
			$.trackAction( id );
		}
		switch ( action.type ) {
			case 'replace':
			case 'encapsulate':
				var parts = { 'pre' : '', 'peri' : '', 'post' : '' };
				for ( part in parts ) {
					if ( part + 'Msg' in action.options ) {
						parts[part] = mw.usability.getMsg( 
							action.options[part + 'Msg'], ( action.options[part] || null ) );
					} else {
						parts[part] = ( action.options[part] || '' )
					}
				}
				if ( 'regex' in action.options && 'regexReplace' in action.options ) {
					var selection = context.$textarea.textSelection( 'getSelection' );
					if ( selection != '' && selection.match( action.options.regex ) ) {
						parts.peri = selection.replace( action.options.regex,
							action.options.regexReplace );
						parts.pre = parts.post = '';
					}
				}
				context.$textarea.textSelection(
					'encapsulateSelection',
					$.extend( {}, action.options, parts, { 'replace': action.type == 'replace' } )
				);
				if ( typeof context.$iframe !== 'undefined' ) {
					context.$iframe[0].contentWindow.focus();
				}
				break;
			case 'callback':
				if ( typeof action.execute == 'function' ) {
					action.execute( context );
				}
				break;
			case 'dialog':
				context.fn.saveSelection();
				context.$textarea.wikiEditor( 'openDialog', action.module );
				break;
			default: break;
		}
	},
	buildGroup : function( context, id, group ) {
		var $group = $( '<div />' ).attr( { 'class' : 'group group-' + id, 'rel' : id } );
		var label = $.wikiEditor.autoMsg( group, 'label' );
		if ( label ) {
			$group.append( '<div class="label">' + label + '</div>' )
		}
		var empty = true;
		if ( 'tools' in group ) {
			for ( tool in group.tools ) {
				var tool =  $.wikiEditor.modules.toolbar.fn.buildTool( context, tool, group.tools[tool] );
				if ( tool ) {
					empty = false;
					$group.append( tool );
				}
			}
		}
		if ( empty ) {
			$group.hide();
		}
		return $group;
	},
	buildTool : function( context, id, tool ) {
		if ( 'filters' in tool ) {
			for ( filter in tool.filters ) {
				if ( $( tool.filters[filter] ).size() == 0 ) {
					return null;
				}
			}
		}
		var label = $.wikiEditor.autoMsg( tool, 'label' );
		switch ( tool.type ) {
			case 'button':
				var src = $.wikiEditor.autoIcon( tool.icon, $.wikiEditor.imgPath + 'toolbar/' );
				$button = $( '<img />' ).attr( {
					'src' : src,
					'width' : 22,
					'height' : 22,
					'alt' : label,
					'title' : label,
					'rel' : id,
					'class' : 'tool tool-button'
				} );
				if ( 'action' in tool ) {
					$button
						.data( 'action', tool.action )
						.data( 'context', context )
						.mousedown( function() {
							// No dragging!
							return false;
						} )
						.click( function() {
							$.wikiEditor.modules.toolbar.fn.doAction(
								$(this).data( 'context' ), $(this).data( 'action' ), $(this)
							);
							return false;
						} );
				}
				return $button;
			case 'select':
				var $select = $( '<div />' )
					.attr( { 'rel' : id, 'class' : 'tool tool-select' } );
				$options = $( '<div />' ).addClass( 'options' );
				if ( 'list' in tool ) {
					for ( option in tool.list ) {
						var optionLabel = $.wikiEditor.autoMsg( tool.list[option], 'label' );
						$options.append(
							$( '<a />' )
								.data( 'action', tool.list[option].action )
								.data( 'context', context )
								.mousedown( function() {
									// No dragging!
									return false;
								} )
								.click( function() {
									$.wikiEditor.modules.toolbar.fn.doAction(
										$(this).data( 'context' ), $(this).data( 'action' ), $(this)
									);
									// Hide the dropdown
									// Sanity check: if this somehow gets called while the dropdown
									// is hidden, don't show it
									if ( $(this).parent().is( ':visible' ) ) {
										$(this).parent().animate( { 'opacity': 'toggle' }, 'fast' );
									}
									return false;
								} )
								.text( optionLabel )
								.addClass( 'option' )
								.attr( { 'rel': option, 'href': '#' } )
						);
					}
				}
				$select.append( $( '<div />' ).addClass( 'menu' ).append( $options ) );
				$select.append( $( '<a />' )
							.addClass( 'label' )
							.text( label )
							.data( 'options', $options )
							.attr( 'href', '#' )
							.mousedown( function() {
								// No dragging!
								return false;
							} )
							.click( function() {
								$(this).data( 'options' ).animate( { 'opacity': 'toggle' }, 'fast' );
								return false;
							} )
				);
				return $select;
			default:
				return null;
		}
	},
	buildBookmark : function( context, id, page ) {
		var label = $.wikiEditor.autoMsg( page,
		'label' );
		return $( '<div />' )
			.text( label )
			.attr( 'rel', id )
			.data( 'context', context )
			.mousedown( function() {
				// No dragging!
				return false;
			} )
			.click( function( event ) {
				$(this).parent().parent().find( '.page' ).hide();
				$(this).parent().parent().find( '.page-' + $(this).attr( 'rel' ) ).show();
				$(this).siblings().removeClass( 'current' );
				$(this).addClass( 'current' );
				var section = $(this).parent().parent().attr( 'rel' );
				$.cookie(
					'wikiEditor-' + $(this).data( 'context' ).instance + '-booklet-' + section + '-page',
					$(this).attr( 'rel' )
				);
				// Click tracking
				if($.trackAction != undefined){
					$.trackAction(section + '.' + $(this).attr('rel'));
				}
				// No dragging!
				return false;
			} )
	},
	buildPage : function( context, id, page ) {
		var $page = $( '<div />' ).attr( {
			'class' : 'page page-' + id,
			'rel' : id
		} );
		switch ( page.layout ) {
			case 'table':
				$page.addClass( 'page-table' );
				var html =
					'<table cellpadding=0 cellspacing=0 ' + 'border=0 width="100%" class="table table-"' + id + '">';
				if ( 'headings' in page ) {
					html += $.wikiEditor.modules.toolbar.fn.buildHeading( context, page.headings )
				}
				if ( 'rows' in page ) {
					for ( row in page.rows ) {
						html += $.wikiEditor.modules.toolbar.fn.buildRow( context, page.rows[row] )
					}
				}
				$page.html( html );
				break;
			case 'characters':
				$page.addClass( 'page-characters' );
				$characters = $( '<div />' ).data( 'context', context ).data( 'actions', {} );
				var actions = $characters.data( 'actions' );
				if ( 'language' in page ) {
					$characters.attr( 'lang', page.language );
				}
				if ( 'direction' in page ) {
					$characters.attr( 'dir', page.direction );
				}
				if ( 'characters' in page ) {
					var html = '';
					for ( character in page.characters ) {
						html += $.wikiEditor.modules.toolbar.fn.buildCharacter( page.characters[character], actions );
					}
					$characters
						.html( html )
						.children()
						.mousedown( function() {
							// No dragging!
							return false;
						} )
						.click( function() {
							$.wikiEditor.modules.toolbar.fn.doAction(
								$(this).parent().data( 'context' ),
								$(this).parent().data( 'actions' )[$(this).attr( 'rel' )],
								$(this)
							);
							return false;
						} );
				}
				$page.append( $characters );
				break;
		}
		return $page;
	},
	buildHeading : function( context, headings ) {
		var html = '<tr>';
		for ( heading in headings ) {
			html += '<th>' + $.wikiEditor.autoMsg( headings[heading], ['html', 'text'] ) + '</th>';
		}
		return html;
	},
	buildRow : function( context, row ) {
		var html = '<tr>';
		for ( cell in row ) {
			html += '<td class="cell cell-' + cell + '" valign="top"><span>' +
				$.wikiEditor.autoMsg( row[cell], ['html', 'text'] ) + '</span></td>';
		}
		html += '</tr>';
		return html;
	},
	buildCharacter : function( character, actions ) {
		if ( typeof character == 'string' ) {
			character = {
				'label' : character,
				'action' : {
					'type' : 'encapsulate',
					'options' : {
						'pre' : character
					}
				}
			};
		} else if ( 0 in character && 1 in character ) {
			character = {
				'label' : character[0],
				'action' : {
					'type' : 'encapsulate',
					'options' : {
						'pre' : character[1]
					}
				}
			};
		}
		if ( 'action' in character && 'label' in character ) {
			actions[character.label] = character.action;
			return '<a rel="' + character.label + '" href="#">' + character.label + '</a>';
		}
	},
	buildTab : function( context, id, section ) {
		var selected = $.cookie( 'wikiEditor-' + context.instance + '-toolbar-section' );
		return $( '<span />' )
			.attr( { 'class' : 'tab tab-' + id, 'rel' : id } )
			.append(
				$( '<a />' )
					.addClass( selected == id ? 'current' : null )
					.attr( 'href', '#' )
					.text( $.wikiEditor.autoMsg( section, 'label' ) )
					.data( 'context', context )
					.mouseup( function( e ) {
						$(this).blur();
					} )
					.mousedown( function() {
						// No dragging!
						return false;
					} )
					.click( function( e ) {
						var $sections = $(this).data( 'context' ).$ui.find( '.sections' );
						var $section =
							$(this).data( 'context' ).$ui.find( '.section-' + $(this).parent().attr( 'rel' ) );
						var show = $section.css( 'display' ) == 'none';
						$previousSections = $section.parent().find( '.section:visible' );
						$previousSections.css( 'position', 'absolute' );
						$previousSections.fadeOut( 'fast', function() { $(this).css( 'position', 'relative' ); } );
						$(this).parent().parent().find( 'a' ).removeClass( 'current' );
						$sections.css( 'overflow', 'hidden' );
						if ( show ) {
							$section.fadeIn( 'fast' );
							$sections
								.css( 'display', 'block' )
								.animate( { 'height': $section.outerHeight() }, $section.outerHeight() * 2, function() {
									$(this).css( 'overflow', 'visible' ).css( 'height', 'auto' );
									context.fn.trigger( 'resize' );
								} );
							$(this).addClass( 'current' );
						} else {
							$sections
								.css( 'height', $section.outerHeight() )
								.animate( { 'height': 'hide' }, $section.outerHeight() * 2, function() {
									$(this).css( { 'overflow': 'visible', 'height': 0 } );
									context.fn.trigger( 'resize' );
								} );
						}
						// Click tracking
						if($.trackAction != undefined){
							$.trackAction($section.attr('rel') + '.' + ( show ? 'show': 'hide' )  );
						}
						// Save the currently visible section
						$.cookie(
							'wikiEditor-' + $(this).data( 'context' ).instance + '-toolbar-section',
							show ? $section.attr( 'rel' ) : null
						);
						return false;
					} )
			);
	},
	buildSection : function( context, id, section ) {
		context.$textarea.trigger( 'wikiEditor-toolbar-buildSection-' + id, [section] );
		var selected = $.cookie( 'wikiEditor-' + context.instance + '-toolbar-section' );
		var $section;
		switch ( section.type ) {
			case 'toolbar':
				var $section = $( '<div />' ).attr( { 'class' : 'toolbar section section-' + id, 'rel' : id } );
				if ( 'groups' in section ) {
					for ( group in section.groups ) {
						$section.append(
							$.wikiEditor.modules.toolbar.fn.buildGroup( context, group, section.groups[group] )
						);
					}
				}
				break;
			case 'booklet':
				var $pages = $( '<div />' ).addClass( 'pages' );
				var $index = $( '<div />' ).addClass( 'index' );
				if ( 'pages' in section ) {
					for ( page in section.pages ) {
						$pages.append(
							$.wikiEditor.modules.toolbar.fn.buildPage( context, page, section.pages[page] )
						);
						$index.append(
							$.wikiEditor.modules.toolbar.fn.buildBookmark( context, page, section.pages[page] )
						);
					}
				}
				$section = $( '<div />' ).attr( { 'class' : 'booklet section section-' + id, 'rel' : id } )
					.append( $index )
					.append( $pages );
				$.wikiEditor.modules.toolbar.fn.updateBookletSelection( context, page, $pages, $index );
				break;
		}
		if ( $section !== null && id !== 'main' ) {
			var show = selected == id;
			$section.css( 'display', show ? 'block' : 'none' );
		}
		return $section;
	},
	updateBookletSelection : function( context, id, $pages, $index ) {
		var cookie = 'wikiEditor-' + context.instance + '-booklet-' + id + '-page';
		var selected = $.cookie( cookie );
		var $selectedIndex = $index.find( '*[rel=' + selected + ']' );
		if ( $selectedIndex.size() == 0 ) {
			selected = $index.children().eq( 0 ).attr( 'rel' );
			$.cookie( cookie, selected );
		}
		$pages.children().hide();
		$pages.find( '*[rel=' + selected + ']' ).show();
		$index.children().removeClass( 'current' );
		$selectedIndex.addClass( 'current' );
	},
	build : function( context, config ) {
		var $tabs = $( '<div />' ).addClass( 'tabs' ).appendTo( context.modules.toolbar.$toolbar );
		var $sections = $( '<div />' ).addClass( 'sections' ).appendTo( context.modules.toolbar.$toolbar );
		context.modules.toolbar.$toolbar.append( $( '<div />' ).css( 'clear', 'both' ) );
		var sectionQueue = [];
		for ( section in config ) {
			if ( section == 'main' ) {
				context.modules.toolbar.$toolbar.prepend(
					$.wikiEditor.modules.toolbar.fn.buildSection( context, section, config[section] )
				);
			} else {
				sectionQueue.push( {
					'$sections' : $sections,
					'context' : context,
					'id' : section,
					'config' : config[section]
				} );
				$tabs.append( $.wikiEditor.modules.toolbar.fn.buildTab( context, section, config[section] ) );
			}
		}
		$.eachAsync( sectionQueue, {
			'bulk' : 0,
			'end' : function() {
				// HACK: Opera doesn't seem to want to redraw after these bits
				// are added to the DOM, so we can just FORCE it!
				$( 'body' ).css( 'position', 'static' );
				$( 'body' ).css( 'position', 'relative' );
			},
			'loop' : function( i, s ) {
				s.$sections.append( $.wikiEditor.modules.toolbar.fn.buildSection( s.context, s.id, s.config ) );
				var $section = s.$sections.find( '.section:visible' );
				if ( $section.size() ) {
					$sections.animate( { 'height': $section.outerHeight() }, $section.outerHeight() * 2, function( ) {
						context.fn.trigger( 'resize' );
					} );
				}
			}
		} );
	}
}

}; } )( jQuery );
