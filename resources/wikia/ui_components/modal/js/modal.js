define('wikia.ui.modal', [
	'jquery',
	'wikia.window',
	'wikia.browserDetect',
	'wikia.tracker'
], function (
	$,
	w,
	browserDetect,
	tracker
) {
	'use strict';

	// constants for modal component
	var BLACKOUT_ID = 'blackout',
		BLACKOUT_VISIBLE_CLASS = 'visible',
		BLACKOUT_HIDDEN_CLASS = 'hidden',
		BODY_WITH_BLACKOUT_CLASS = 'with-blackout',
		FAKE_SCROLLBAR_CLASS = 'fake-scrollbar',
		CLOSE_CLASS = 'close',
		INACTIVE_CLASS = 'inactive',

		// vars required for disable scroll behind modal
		$wrapper = $('.WikiaSiteWrapper'),
		$win = $(w),
		wScrollTop,

		$body = $(w.document.body),

		// default modal rendering params
		modalDefaults = {
			type: 'default',
			vars: {
				closeText: $.msg('close'),
				escapeToClose: true
			},
			confirmCloseModal: false
		},
		// default modal buttons rendering params
		btnConfig = {
			type: 'button',
			vars: {
				type: 'button',
				classes: ['normal', 'secondary']
			}
		},

		// reference to UI component instance
		uiComponent,
		track = tracker.buildTrackingFunction({
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'ui-components-modal',
			trackingMethod: 'analytics'
		});

	/**
	 * THIS FUNCTION IS REQUIRED FOR EACH COMPONENT WITH AMD JS WRAPPER !!!!
	 *
	 * It's used by UI Component class 'createComponent' method as a shortcut for rendering, appending to DOM
	 * and initializing component with a single function call.
	 *
	 * Sets a reference to UI component object configured for rendering / creating modals
	 * and creates new instance of modal class passing mustache params to constructor call.
	 *
	 * @param {Object} params - mustache params for rendering modal
	 * @param {Object} component - UI Component configured for creating modal
	 * @returns {Object} - new instance of Modal object
	 */

	function createComponent(params, component) {
		uiComponent = component; // set reference to UI Component

		return new Modal(params);
	}

	/**
	 * IE 9 doesn't support flex-box. IE-10 and IE-11 has some bugs in implementation:
	 *
	 * https://connect.microsoft.com/IE/feedback/details/802625/
	 * min-height-and-flexbox-flex-direction-column-dont-work-together-in-ie-10-11-preview
	 *
	 * This is a fallback for IE which based on window 'height' and sets 'max-height' modal section
	 *
	 * @param {Object} modal - Wikia modal object
	 */

	function ieFlexboxFallback(modal) {
		var element = modal.$element,
			HEADER_AND_FOOTER_HEIGHT = 90, // modal header and footer have 45px fixed height
			SECTION_PADDING = 40, // modal section has 20px top and bottom padding
			winHeight = $(w).height(),
			// IE has problem with 'max-height' together with 'border-box', so set to 'content-box' and padding need to
			// be subtracted from 'max-height'.
			modalMaxHeight = (90 / 100) * winHeight - HEADER_AND_FOOTER_HEIGHT - SECTION_PADDING;

		element.children('section').css('maxHeight', modalMaxHeight);
	}

	/**
	 * Disable scrolling content behind modal
	 */

	function blockPageScrolling() {

		// prevent page from jumping to right if vertical scroll bar exist
		if ($wrapper.height() > $win.height()) {
			$wrapper.addClass(FAKE_SCROLLBAR_CLASS);
		}

		// set current page vertical position
		wScrollTop = $win.scrollTop();

		$body.addClass(BODY_WITH_BLACKOUT_CLASS);
		$wrapper.css('top', -wScrollTop);
	}

	/**
	 *  Cancel blockPageScrolling() function effect
	 */

	function unblockPageScrolling() {
		$body.removeClass(BODY_WITH_BLACKOUT_CLASS);
		$wrapper.removeClass(FAKE_SCROLLBAR_CLASS).css('top', 'auto');
		$win.scrollTop(wScrollTop);
	}

	/**
	 * Initializes a modal
	 * Constructor function for Modal class which creates a new instance of modal,
	 *
	 * OPTION 1 ( if called with 'params' type = string )
	 * - link it with DOM element ID passed as params
	 *
	 * OPTION 2: ( if called 'params' type = object )
	 * - renders modal component based on passed params object
	 * - append markup to DOM
	 * - link new modal instance with ID of the appended element
	 *
	 * Finally attach event handlers for modal component
	 *
	 * @constructor
	 * @param {String|Object} params - ID of modal element in DOM or object with mustache params
	 */

	function Modal(params) {
		var self = this,
			id = (typeof params === 'object') ? params.vars.id : params, // modal ID
			jQuerySelector = '#' + id,
			buttons, // array of objects with params for rendering modal buttons
			blackoutId = BLACKOUT_ID + '_' + id;

		if ($(jQuerySelector).length > 0) {
			throw 'Cannot create new modal with id ' + id + ' as it already exists in DOM';
		}

		if (typeof (uiComponent) === 'undefined') {
			throw 'Need uiComponent to render modal with id ' + id;
		}

		buttons = params.vars.buttons;
		if ($.isArray(buttons)) {
			// Create buttons
			buttons.forEach(function (button, index) {
				if (typeof button === 'object') {

					// Extend the button param with the modal default, get the button uicomponent,
					// and render the params then replace the button params with the rendered html
					buttons[index] = uiComponent.getSubComponent('button').render(
						$.extend(true, {}, btnConfig, button)
					);
				}
			});
		}

		// extend default modal params with the one passed in constructor call
		params = $.extend(true, {}, modalDefaults, params);

		// render modal markup and append to DOM
		$body.append(uiComponent.render(params));

		// cache jQuery selectors for different parts of modal
		this.$element = $(jQuerySelector);
		this.$content = this.$element.children('section');
		this.$close = this.$element.find('.' + CLOSE_CLASS);
		this.$blackout = $('#' + blackoutId);

		/** ATTACHING EVENT HANDLERS TO MODAL */

		// trigger custom buttons events based on button 'data-event' attribute
		this.$element.on('click', 'button, .modalEvent', $.proxy(function (event) {
			var $target = $(event.currentTarget),
				modalEventName = $target.data('event');

			event.preventDefault();

			if (modalEventName) {
				this.trigger(modalEventName, event);
			}
		}, self));

		// clicking outside modal triggers the close action
		this.$blackout.click($.proxy(function (event) {
			// jQuery only supports event bubbling,
			// this is a workaround to be sure that click was done on blackout and doesn't bubble up from $element
			// stopPropagation() on $element it not an option
			// because we need bubbling for other events in the $elements content
			var blackoutWasClicked = event.target === event.delegateTarget;

			if (this.isShown() && this.isActive() && blackoutWasClicked) {
				track({
					label: 'modal-close-outside'
				});
				this.trigger('close', event);
			}
		}, self));

		// attach close event to X icon in modal header
		this.$close.click($.proxy(function (event) {
			event.preventDefault();
			track({
				label: 'modal-close-button'
			});
			this.trigger('close', event);
		}, self));

		// Close modal when the escape key is pressed
		if (params.vars.escapeToClose) {
			$(window).on('keydown.modal' + id, function (event) {
				if (event.keyCode === 27) {
					track({
						label: 'modal-close-esc'
					});
					this.trigger('close', event);
				}
			}.bind(this));
		}

		// object containing modal event listeners
		this.listeners = {
			'close': [
				function () {
					if ((typeof params.confirmCloseModal === 'function') ? params.confirmCloseModal() : true) {
						self.trigger('beforeClose').then($.proxy(function () {
							// number of active modals on page
							var activeModalsNumb = $body.children('.modal-blackout').length;

							self.$blackout.remove();

							// unblock background scrolling only if this is the only if it's last active modal on page
							if (activeModalsNumb === 1) {
								unblockPageScrolling();
							}

							// Remove any event listeners for this modal
							$(window).unbind('.modal' + id);
						}, self));
					}
				}
			]
		};

	}

	/**
	 * Shows modal; adds shown class to modal and visible class to blackout
	 */
	Modal.prototype.show = function () {

		// block background only if not modal in scenario
		if ($wrapper.hasClass(FAKE_SCROLLBAR_CLASS) === false) {
			blockPageScrolling();
		}

		this.$blackout.addClass(BLACKOUT_VISIBLE_CLASS).removeClass(BLACKOUT_HIDDEN_CLASS);

		// IE flex-box fallback for small and medium modals
		if (browserDetect.isIE()) {

			this.$blackout.addClass('IE-flex-fix');

			if (this.$element.hasClass('large') === false) {
				ieFlexboxFallback(this);

				// update modal section max-height on window resize
				$(w).on('resize', $.proxy(function () {
					ieFlexboxFallback(this);
				}, this));
			}
		}
	};

	/**
	 * Triggers listeners attached to specific event. Listeners are run in the same order they were bound. This method
	 * returns a promise. If one of the listeners returns a deferred which fails, trigger method will stop executing the
	 * remaining listeners and will reject its result. When everything completes without problems,
	 * resolve will be called instead on this method's return value.
	 *
	 * Any additional parameters passed after eventName will be passed to event listeners.
	 *
	 * @param {String} eventName name of the event to trigger - the same as passed to bind method
	 * @return {{}} promise which will call its handlers after listeners had been executed
	 */

	Modal.prototype.trigger = function (eventName) {
		var deferred = new $.Deferred(),
			i = 0,
			args = [].slice.call(arguments, 1),
			listeners = this.listeners[eventName];

		// in future we may consider ignoring an event if the previous trigger call with the same
		// eventName did not compete

		(function iterate(param) {
			var result;

			// if listener returns some value then push it to array of arguments that are passed to the next listener
			if (typeof param !== 'undefined') {
				args.push(param);
			}

			while (listeners && (i < listeners.length)) {
				result = listeners[i++].apply(undefined, args);
				if (result && (typeof result.then === 'function')) {
					result.then(iterate, deferred.reject);
					return;
				}
			}
			deferred.resolve();
		})();
		return deferred.promise();
	};

	/**
	 * Add an event listener, which will be called every time an event with matching name is triggered. The event
	 * listener can be synchronous or can return a promise object. In case of promise event propagation in put on hold
	 * until it's resolved. In case the promise is rejected, remaining event listeners are not called and the
	 * corresponding trigger call also returns a rejected promise.
	 * @param {String} eventName name of the event to bind to
	 * @param {function} callback listener
	 */
	Modal.prototype.bind = function (eventName, callback) {
		if (typeof (this.listeners[eventName]) === 'undefined') {
			this.listeners[eventName] = [];
		}
		this.listeners[eventName].push(callback);
	};

	/**
	 * Disables all modal buttons, adds inactive class to the modal
	 * and runs jQuery $.startThrobbing() method on it
	 */

	Modal.prototype.deactivate = function () {
		var dialog = this.$element;

		dialog.addClass(INACTIVE_CLASS).find('button').attr('disabled', true);
		dialog.startThrobbing();
	};

	/**
	 * Runs jQuery $.stopThrobbing() on modal, removes inactive class from it and
	 * sets disabled attribute for all modal's buttons to false
	 */

	Modal.prototype.activate = function () {
		var dialog = this.$element;

		dialog.stopThrobbing();
		dialog.removeClass(INACTIVE_CLASS)
			.find('button').attr('disabled', false);
	};

	/**
	 * Returns true if modal has shown class and false otherwise
	 *
	 * @returns {Boolean}
	 */

	Modal.prototype.isShown = function () {
		return this.$blackout.hasClass(BLACKOUT_VISIBLE_CLASS);
	};

	/**
	 * Returns true if modal hasn't inactive class and false otherwise
	 *
	 * @returns {boolean}
	 */

	Modal.prototype.isActive = function () {
		return !this.$element.hasClass(INACTIVE_CLASS);
	};

	/**
	 * Sets modal's content
	 * @param {String} content HTML text
	 */
	Modal.prototype.setContent = function (content) {
		this.$content.html(content);
	};

	/**
	 * Sets modal's title
	 * @param {String} title text
	 */
	Modal.prototype.setTitle = function (title) {
		this.$element.find('header h3').text(title);
	};

	/**
	 * Scroll's modal content to a given offset
	 * @param {int} offsetTop in pixels
	 */
	Modal.prototype.scroll = function (offsetTop) {
		this.$element.find('section').scrollTop(offsetTop);
	}

	/** Public API */

	return {
		createComponent: createComponent
	};
});
