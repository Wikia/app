//Modal
$.fn.extend({

	getModalTopOffset: function() {
		var top = Math.max((($(window).height() - this.outerHeight()) / 2), 20);
		var opts = this.data('settings');
		if (opts && typeof opts.topMaximum == "number")
			top = Math.min(top,opts.topMaximum);
		return $(window).scrollTop() + top;
	},

	makeModal: function(options) {
		var settings = {
			width: 400
		};
		if (options) {
			$.extend(settings, options);
		}

		if (settings.id) {
			var id = settings.id;
		} else {
			var id = $(this).attr('id') + 'Wrapper';
		}

		//wrap with modal chrome
		if (skin == "oasis") {
			/**
			 * Generate modal content and add it to <body>
			 * <section class="modalWrapper" id="'+id+'"><section class="modalContent">[modal content]</section></section>');
			 * @see http://stackoverflow.com/questions/1191164/jquery-html5-append-appendto-and-ie
			 */
			var wrapper = $('<section>', {'class': 'modalWrapper', 'id': id}).
				append(
					$('<section>', {'class': 'modalContent'}).append(this)
				).
				appendTo('body');
		}
		else {
			this.wrap('<div class="modalWrapper" id="'+id+'"></div>');
			var wrapper = this.closest(".modalWrapper");
		}

		// macbre: addcustom CSS class to popup wrapper
		if (settings.className) {
			wrapper.addClass(settings.className);
		}

		// let's have it dynamically generated, so every newly created modal will be on top
		if (settings.zIndex) {
			var zIndex = parseInt(settings.zIndex);
		}	else {
			var zIndex = 0;

			$("body").children('.blackout').add('#positioned_elements').children('.blackout').each(function() {
				zIndex = Math.max(zIndex, parseInt($(this).css('zIndex')));
			});

			zIndex += 1000;
		}
		/*
		function getModalTop() {
			var modalTop = (($(window).height() - wrapper.outerHeight()) / 2) + $(window).scrollTop();
			if (modalTop < $(window).scrollTop() + 20) {
				return $(window).scrollTop() + 20;
			} else {
			return modalTop;
			}
		}
		*/

		// needed here for getModalTopOffset()
		wrapper.data('settings', settings);

		if (skin == "oasis") {
			//set up headline
			var headline = wrapper.find("h1:first");

			if (headline.exists()) {
				headline.remove();
			} else {
				// no <h1> found - use title attribute (backward compatibility with Monaco)
				headline = $('<h1>').html($(this).attr('title'));
			}

			// add headline
			headline.prependTo(wrapper);

			// find tabs with .modal-tabs class and move them outside modal content
			var modalTabs = wrapper.find('.modal-tabs');
			if (modalTabs.exists()) {
				modalTabs.insertBefore(wrapper.find('.modalContent'));
			}

			//set up dimensions and position
			var modalWidth = $("#WikiaMainContent").width();

			// or use width provided
			if (typeof options.width != 'undefined') {
				modalWidth = options.width + 30 /* padding */;
			}

			wrapper.css({
				left: "50%",
				marginLeft: -modalWidth/2,
				top: $(window).scrollTop() + 50,
				width: modalWidth,
				zIndex: zIndex + 1
			});

			//add close button
			wrapper.prepend('<button class="close wikia-chiclet-button"><img src="/skins/oasis/images/icon_close.png"></button>');

		} else {
			wrapper
				.prepend('<h1 class="modalTitle color1"><img src="'+wgBlankImgUrl+'" class="sprite close" />' + this.attr('title') + '</h1>')
				.width(settings.width);
			wrapper
				.css({
					marginLeft: -wrapper.outerWidth() / 2,
					top: wrapper.getModalTopOffset(),
					zIndex: zIndex + 1
				})
				.fadeIn("fast")
		}

		wrapper.log('makeModal: #' + id);

		$("[id$='TOP_LEADERBOARD']").add("[id$='TOP_RIGHT_BOXAD']").css("visibility", "hidden");

		// get rid of tooltip - remove title attr
		this.removeAttr('title');

		// add event handlers
		var persistent = (typeof settings.persistent == 'boolean') ? settings.persistent : false;

		// macbre: function called when modal is closed
		var onClose = (typeof settings.onClose == 'function') ? settings.onClose : false;

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

		$(window)
			.bind("keypress.modal", function(event) {
				if (event.keyCode == 27) {
					if (onClose) {
						// let extension decide what to do
						// close can be prevented by onClose() returning false
						if (onClose({keypress:1}) == false) {
							return;
						}
					}

					if (persistent) {
						wrapper.hideModal();
					} else {
						wrapper.closeModal();
					}
				}
			})
			.bind("resize.modal", function() {
				wrapper.css("top", wrapper.getModalTopOffset());
				$(".blackout:last").height($(document).height());
			});

		// macbre: associate blackout with current modal
		var blackout = $('<div>').addClass('blackout');

		blackout
			.height($(document).height())
			.css({zIndex: zIndex})
			.fadeTo("fast", 0.65)
			.bind("click", function() {
				if (onClose) {
					// let extension decide what to do
					// close can be prevented by onClose() returning false
					if (onClose({click:1}) == false) {
						return;
					}
				}

			if (persistent) {
				wrapper.hideModal();
			} else {
				wrapper.closeModal();
			}
		});

		if (skin == "oasis") {
			blackout.appendTo("body");
		} else {
			blackout.appendTo("#positioned_elements");
		}

		wrapper.data('blackout', blackout);
	},


	closeModal: function() {
		$(window).unbind(".modal");
		this.animate({
			top: this.offset()["top"] + 100,
			opacity: 0
		}, "fast", function() {
			$(this).remove();
		});

		// removed associated blackout
		var blackout = $(this).data('blackout');
		blackout.fadeOut("fast", function() {
			$(this).remove();
		});

		//hide ads when a modal is present
		$("[id$='TOP_LEADERBOARD']").add("[id$='TOP_RIGHT_BOXAD']").css("visibility", "visible");
	},

	// just hide the modal - don't remove DOM node
	hideModal: function() {
		// hide associated blackout
		var blackout = $(this).data('blackout');
		blackout.fadeOut("fast").addClass('blackoutHidden');

		this.animate({
			top: this.offset()["top"] + 100,
			opacity: 0
		}, "fast", function() {
			$(this).css("display", "none");
		});

		//show ads again
		$("[id$='TOP_LEADERBOARD']").add("[id$='TOP_RIGHT_BOXAD']").css("visibility", "visible");
	},

	// show previously hidden modal
	showModal: function() {
		var wrapper = this.closest(".modalWrapper");

		// let's have it dynamically generated, so every newly created modal will be on the top
		var zIndex = ($('#positioned_elements').children('.blackout').length+1) * 1000;

		// show associated blackout
		var blackout = $(this).data('blackout');
		blackout
			.height($(document).height())
			.css({
				display: 'block',
				opacity: 0.65,
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

		$("[id$='TOP_LEADERBOARD']").add("[id$='TOP_RIGHT_BOXAD']").css("visibility", "hidden");

		/*
		//Defined twice in different scopes. This is bad. Figure out how to define just once.
		function getModalTop() {
			var modalTop = (($(window).height() - wrapper.outerHeight()) / 2) + $(window).scrollTop();
			if (modalTop < $(window).scrollTop() + 20) {
				return $(window).scrollTop() + 20;
			} else {
				return modalTop;
			}
		}
		*/
	},

	// change the width of modal and reposition it (refs RT #55210)
	resizeModal: function(width) {
		width = parseInt(width);
		var wrapper = this.closest(".modalWrapper");

		wrapper
			.width(width)
			.css('marginLeft', -wrapper.outerWidth() >> 1)
			.log('resizeModal: #' + this.attr('id') + ' resized to ' + width + 'px');
	}
});
