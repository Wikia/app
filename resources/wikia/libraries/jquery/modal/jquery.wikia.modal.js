//Modal
$.fn.extend({
	getModalTopOffset: function() {
		var top = Math.max((($(window).height() - this.outerHeight()) / 2), 20);
		var opts = this.data('settings');
		if (opts && typeof opts.topMaximum == "number") {
			top = Math.min(top,opts.topMaximum);
		}
		return $(window).scrollTop() + top;
	},

	/**
	 * @desc calculates max height of modal content
	 * @param {Number} modalTopOffset
	 * @param {jQuery} $headline - jQuery collection for modal header
	 * @param {jQuery} $tabs - jQuery collection for modal tabs
	 * @returns {Number} - max height value
	 */
	getMaxModalContentHeight: function(modalTopOffset, $headline, $tabs) {
		return $(window).height() - 2 * modalTopOffset - $headline.outerHeight() - $tabs.outerHeight();
	},

	makeModal: function(options) {
		var settings = {
			showCloseButton: true,
			width: 400,
			height: "auto",
			tabsOutsideContent: false,
			topOffset: 50,
			escapeToClose: true
		}, calculatedZIndex, modalWidth, mainContent, $modalContent;

		if (options) {
			$.extend(settings, options);
		}

		// modal wrapper ID
		var ts = Math.round((new Date()).getTime() / 1000),
			id = settings.id || ($(this).attr('id') || ts) + 'Wrapper',
			wrapper;

		//wrap with modal chrome
		if (skin === 'oasis' || skin === 'venus' || settings.appendToBody) {
			/**
			 * Generate modal content and add it to <body>
			 * <section class="modalWrapper" id="'+id+'"><section class="modalContent">[modal content]</section></section>');
			 * @see http://stackoverflow.com/questions/1191164/jquery-html5-append-appendto-and-ie
			 */
			wrapper = $('<section>', {'class': 'modalWrapper', 'id': id}).
				append(
					$('<section>', {'class': 'modalContent'}).append(this)
				).
				appendTo('body');
		}
		else {
			this.wrap('<div class="modalWrapper" id="'+id+'"></div>');
			wrapper = this.closest(".modalWrapper");
			wrapper.appendTo('#positioned_elements');
		}

		$modalContent = wrapper.find('.modalContent');

		// macbre: addcustom CSS class to popup wrapper
		if (settings.className) {
			wrapper.addClass(settings.className);
		}

		// let's have it dynamically generated, so every newly created modal will be on top
		var zIndex = settings.zIndex ? parseInt(settings.zIndex) : (5001101 + ($('body').children('.blackout').length) * 2);
		calculatedZIndex = zIndex + 1;

		// needed here for getModalTopOffset()
		wrapper.data('settings', settings);

		if(!settings.noHeadline) {
			//set up headline
			var headline = wrapper.find("h1:first");

			if (headline.exists()) {
				headline.remove();
			} else {
				// no <h1> found - use title attribute (backward compatibility with Monaco)
				headline = $('<h1>').html($(this).attr('title') || '');
			}

			// add headline
			headline.prependTo(wrapper);
		}

		// skin === oasis is for backward support
		if (settings.tabsOutsideContent || skin === 'oasis' || skin === 'venus') {
			// find tabs with .modal-tabs class and move them outside modal content
			var modalTabs = wrapper.find('.modal-tabs');
			if (modalTabs.exists()) {
				modalTabs.insertBefore($modalContent);
			}
		}

		$modalContent.css('max-height', this.getMaxModalContentHeight(settings.topOffset, headline, modalTabs));

		// calculate modal width for oasis
		if (skin === 'oasis' || skin === 'venus') {

			if(settings.width !== 'auto') {

				// use provided width
				if (settings.width !== undefined) {
					modalWidth = settings.width + 40 /* padding */;
				} else {
					// or use wikiaMainContent
					mainContent = $("#WikiaMainContent");
					if (mainContent.length > 0) {
						modalWidth = mainContent.width();
					}
				}
			} else {
				modalWidth = 'auto';
			}

			//position modal. width must be set before calculating negative left margin
			wrapper.width(modalWidth)
				.css({
				left: '50%',
				height: settings.height,
				'margin-left': -wrapper.outerWidth(false)/2,
				top: $(window).scrollTop() + settings.topOffset,
				zIndex: calculatedZIndex
			});
		} else if (settings.suppressDefaultStyles) {
			// z-index and top value need to be set when modal is created
			// their values are calculated based on the current state of the page
			wrapper.css({
				zIndex: calculatedZIndex,
				top: $(window).scrollTop() + settings.topOffset
			});
		} else {
			wrapper
				.width(settings.width)
				.css({
					marginLeft: -wrapper.outerWidth(false) / 2,
					top: wrapper.getModalTopOffset(),
					zIndex: calculatedZIndex
				})
				.fadeIn("fast");
		}

		//add close button
		if (settings.showCloseButton) {
			wrapper.prepend('<button class="close wikia-chiclet-button"><img src="' + stylepath + '/oasis/images/icon_close.png"></button>');
		}

		wrapper.log('makeModal: #' + id);

		// get rid of tooltip - remove title attr
		this.removeAttr('title');

		// add event handlers
		var persistent = (typeof settings.persistent == 'boolean') ? settings.persistent : false;

		// macbre: function called when modal is closed
		var onClose = (typeof settings.onClose == 'function') ? settings.onClose : false;
		var closeOnBlackoutClick = (typeof settings.closeOnBlackoutClick == 'boolean') ? settings.closeOnBlackoutClick : true;

		wrapper.find('.close').bind("click", function() {
			var wrapper = $(this).closest('.modalWrapper');
			var settings = wrapper.data('settings');

			if (typeof settings.onClose == 'function') {
				// let extension decide what to do
				// close can be prevented by onClose() returning false
				if (settings.onClose({click:1}) == false) {
					return;
				}
			}

			if (persistent) {
				wrapper.hideModal();
			} else {
				wrapper.closeModal();
			}
		});

		if(settings.escapeToClose) {
			$(window).bind("keydown.modal" + id, function(event) {
				if (event.keyCode == 27) {
					if (typeof settings.onClose == 'function') {
						// let extension decide what to do
						// close can be prevented by onClose() returning false
						if (settings.onClose({keypress:1}) == false) {
							return;
						}
					}

					if (persistent) {
						wrapper.hideModal();
					} else {
						wrapper.closeModal();
					}
					return false;
				}
			});
		}
		$(window).bind("resize.modal", function() {
			if (window.skin == 'oasis' || !settings.resizeModal) {
				return;
			}

			wrapper.css("top", wrapper.getModalTopOffset());
			$(".blackout:last").height($(document).height());
		});

		// macbre: associate blackout with current modal
		// jakub: adding control of blackoutOpacity;
		var blackoutOpacity = 0.65;
		if (settings.blackoutOpacity) {
			blackoutOpacity = settings.blackoutOpacity;
		}

		var blackout = $('<div>').addClass('blackout').attr('data-opacity', blackoutOpacity);

		blackout
			.css({zIndex: zIndex})
			.fadeTo("fast", blackoutOpacity)
			.bind("click", function() {
				if (!closeOnBlackoutClick) {
					return;
				}

				if (typeof settings.onClose == 'function') {
					// let extension decide what to do
					// close can be prevented by onClose() returning false
					if (settings.onClose({click:1}) == false) {
						return;
					}
				}

				if (persistent) {
					wrapper.hideModal();
				} else {
					wrapper.closeModal();
				}
		});

		if (skin == 'oasis' || skin == 'venus' || settings.appendToBody) {
			blackout.appendTo("body");
		} else {
			blackout.appendTo("#positioned_elements");
		}

		wrapper.data('blackout', blackout);

		if (typeof settings.onCreate == 'function') {
			settings.onCreate(this,wrapper);
		}

		// BugId:7498
		$(document.body).addClass('modalShown');

		return wrapper;
	},


	closeModal: function() {
		$(window).unbind(".modal" + this.attr('id'));

		this.animate({
			top: this.offset()["top"] + 100,
			opacity: 0
		}, "fast", function() {
			$(this).remove();
		});

		// removed associated blackout
		var blackout = $(this).data('blackout'),
			settings = $(this).data('settings');

		blackout.fadeOut("fast", function() {
			$(this).remove();
			var callback = settings && settings.onAfterClose;
			if($.isFunction(callback)) {
				callback();
			}
		});

		// BugId:7498
		$(document.body).removeClass('modalShown');
	},

	// just hide the modal - don't remove DOM node
	hideModal: function() {
		// hide associated blackout
		var blackout = $(this).data('blackout'),
			settings = $(this).data('settings');

		blackout.fadeOut("fast").addClass('blackoutHidden');

		this.animate({
			top: this.offset()["top"] + 100,
			opacity: 0
		}, "fast", function() {
			$(this).hide();
			var callback = settings && settings.onAfterClose;
			if($.isFunction(callback)) {
				callback();
			}
		});

		// BugId:7498
		$(document.body).removeClass('modalShown');
	},

	// show previously hidden modal
	showModal: function() {
		var wrapper = this.closest(".modalWrapper");

		// let's have it dynamically generated, so every newly created modal will be on the top
		var zIndex = 5001101 + ($('body').children('.blackout').length) * 2 ;
		// show associated blackout
		var blackout = $(this).data('blackout');
		var blackoutOpacity = blackout.attr('data-opacity');
		if ( !blackoutOpacity ){
			blackoutOpacity = 0.65;
		}
		blackout
			.css({
				display: 'block',
				opacity: blackoutOpacity,
				zIndex: zIndex
			})
			.removeClass('blackoutHidden');

		wrapper
			.css({
				top: wrapper.getModalTopOffset(),
				zIndex:  zIndex+1,
				opacity: 1,
				display: "block"
			})
			.log('showModal: #' + this.attr('id'));

		// BugId:7498
		$(document.body).addClass('modalShown');
	},

	// change the width of modal and reposition it (refs RT #55210)
	resizeModal: function(width) {
		width = parseInt(width);
		var wrapper = this.closest(".modalWrapper");

		wrapper
			.width(width)
			.css('marginLeft', -wrapper.outerWidth(false) >> 1)
			.log('resizeModal: #' + this.attr('id') + ' resized to ' + width + 'px');
	},

	isModalShown: function(){
		return $(document.body).hasClass('modalShown');
	},

	getModalWrapper: function(){
		return $('.modalWrapper');
	}
});
