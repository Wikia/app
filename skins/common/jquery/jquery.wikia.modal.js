//Modal
$.fn.extend({

	getModalTopOffset: function() {
		var top = Math.max((($(window).height() - this.outerHeight()) / 2), 20);
		var opts = this.data('options');
		if (opts && typeof opts.topMaximum == "number")
			top = Math.min(top,opts.topMaximum);
		return $(window).scrollTop() + top;
	},
	
	makeModal: function(options) {
		var settings = { width: 400 };
		if (options) {
			$.extend(settings, options);
		}

		if (options.id) {
			var id = options.id;
		} else {
			var id = $(this).attr('id') + 'Wrapper';
		}

		this.wrap('<div class="modalWrapper" id="'+id+'"></div>');

		var wrapper = this.closest(".modalWrapper");

		// macbre: addcustom CSS class to popup wrapper
		if (options.className) {
			wrapper.addClass(options.className);
		}

		// let's have it dynamically generated, so every newly created modal will be on top
		if (options.zIndex) {
			var zIndex = parseInt(options.zIndex);
		}	else {
			var zIndex = 0;

			$('#positioned_elements').children('.blackout').each(function() {
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
		wrapper
			// needed here for getModalTopOffset()
			.data('options', options);
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
			.log('makeModal: #' + id);

		$("[id$='TOP_LEADERBOARD']").add("[id$='TOP_RIGHT_BOXAD']").css("visibility", "hidden");

		// get rid of tooltip - remove title attr
		this.removeAttr('title');

		// add event handlers
		var persistent = (typeof options.persistent == 'boolean') ? options.persistent : false;

		// macbre: function called when modal is closed
		var onClose = (typeof options.onClose == 'function') ? options.onClose : false;

		wrapper.find('h1.modalTitle').children('.close').bind("click", function() {
			var wrapper = $(this).closest('.modalWrapper');
			var options = wrapper.data('options');

			if (typeof options.onClose == 'function') {
				// let extension decide what to do
				// close can be prevented by onClose() returning false
				if (options.onClose({click:1}) == false) {
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
			.appendTo('#positioned_elements')
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
