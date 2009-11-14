//Modal
$.fn.extend({
  makeModal: function(options) {
	var settings = { width: 400 };
	if (options) {
		$.extend(settings, options);
	}

	if (options.id) {
		var id = options.id;
	}
	else {
		var id = $(this).attr('id') + 'Wrapper';
	}

   	this.wrap('<div class="modalWrapper" id="'+id+'"></div>');

   	var wrapper = this.closest(".modalWrapper");

	// macbre: addcustom CSS class to popup wrapper
	if (options.className) {
		wrapper.addClass(options.className);
	}

	// let's have it dynamically generated, so every newly created modal will be on the top
	var zIndex = ($('.blackout').length+1) * 1000;

	function getModalTop() {
		var modalTop = (($(window).height() - wrapper.outerHeight()) / 2) + $(window).scrollTop();
		if (modalTop < $(window).scrollTop() + 20) {
			return $(window).scrollTop() + 20;
		} else {
			return modalTop;
		}
	}

   	wrapper
   		.prepend('<h1 class="modalTitle color1"><div style="background-image: url(http://images.wikia.com/common/skins/monaco/images/sprite.png?20091113);"></div>' + this.attr('title') + '</h1>')
   		.width(settings.width)
   		.css({
   			marginLeft: -wrapper.outerWidth() / 2,
			top: getModalTop(),
			zIndex: zIndex + 1
   		})
   		.fadeIn("fast")
		.log('makeModal: #' + this.attr('id'));

	$("[id$='TOP_LEADERBOARD']").add("[id$='TOP_RIGHT_BOXAD']").css("visibility", "hidden");
	
	// get rid of tooltip - remove title attr
	this.removeAttr('title');

	// add event handlers
	var persistent = (typeof options.persistent == 'boolean') ? options.persistent : false;

	// macbre: function called when modal is closed
	var onClose = (typeof options.onClose == 'function') ? options.onClose : false;

	$("h1.modalTitle div").bind("click", function() {
		if (onClose) {
			onClose();
		}

		if (persistent) {
			wrapper.hideModal();
		}
		else {
			wrapper.closeModal();
		}
	});

   	$(window)
   		.bind("keypress.modal", function(event) {
   			if (event.keyCode == 27) {
				if (onClose) {
					onClose();
				}

				if (persistent) {
					wrapper.hideModal();
				}
				else {
					wrapper.closeModal();
				}
   			}
   		})
   		.bind("resize.modal", function() {
   			wrapper.css("top", getModalTop());
   			$(".blackout:last").height($(document).height());
   		});

   	$("#positioned_elements").append('<div class="blackout"></div>');
   	$(".blackout:last")
   		.height($(document).height())
		.css({zIndex: zIndex})
   		.fadeTo("fast", 0.65)
   		.bind("click", function() {
			if (onClose) {
				onClose();
			}

			if (persistent) {
				wrapper.hideModal();
			}
			else {
				wrapper.closeModal();
			}
   		});
  },
  closeModal: function() {
  	$(window).unbind(".modal");
  	this.animate({
  		top: this.offset()["top"] + 100,
  		opacity: 0
  	}, "fast", function() {
  		$(this).remove();
  	});
  	$(".blackout:last").fadeOut("fast", function() {
  		$(this).remove();
  	});
	$("[id$='TOP_LEADERBOARD']").add("[id$='TOP_RIGHT_BOXAD']").css("visibility", "visible");
  },
  // just hide the modal - don't remove DOM node
  hideModal: function() {
	$(".blackout:last").fadeOut("fast").addClass('blackoutHidden');
	this.animate({
  			top: this.offset()["top"] + 100,
  			opacity: 0
  		}, "fast", function() {
			$(this).css("display", "none");
		}
	);
	$("[id$='TOP_LEADERBOARD']").add("[id$='TOP_RIGHT_BOXAD']").css("visibility", "visible");
  },
  // show previously hidden modal
  showModal: function() {

	var wrapper = this.closest(".modalWrapper");

	// let's have it dynamically generated, so every newly created modal will be on the top
	var zIndex = ($('.blackout').length+1) * 1000;
   	$(".blackout.blackoutHidden:last")
   		.height($(document).height())
		.css({
			display: 'block',
			opacity: 0.65,
			zIndex: zIndex
		})
		.removeClass('blackoutHidden');

	wrapper
		.css({
			top: getModalTop(),
			zIndex:  zIndex+1,
			opacity: 1,
			display: "block"
		})
		.log('showModal: #' + this.attr('id'));
	$("[id$='TOP_LEADERBOARD']").add("[id$='TOP_RIGHT_BOXAD']").css("visibility", "hidden");

	//Defined twice in different scopes. This is bad. Figure out how to define just once.
	function getModalTop() {
		var modalTop = (($(window).height() - wrapper.outerHeight()) / 2) + $(window).scrollTop();
		if (modalTop < $(window).scrollTop() + 20) {
			return $(window).scrollTop() + 20;
		} else {
			return modalTop;
		}
	}
  }
});
