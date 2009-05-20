//Modal
$.fn.extend({
  makeModal: function(options) {
	var settings = { width: 400 };
	if (options) {
		$.extend(settings, options);
	}

	// try to load CSS for modal dialogs
	if (!window.wgMakeModalCSSLoaded) {
		appendCSS('\n\
/* Make Modal CSS */\n\
div.modalWrapper {			\n\
	background: #FFF;		\n\
	border: 1px solid #AAA;		\n\
	display: none;			\n\
	left: 50%;			\n\
	padding: 2px;			\n\
	position: absolute;		\n\
	visibility: visible;		\n\
	z-index: 1001;			\n\
}					\n\
h1.modalTitle {				\n\
	font-weight: bold;		\n\
	padding: 5px;			\n\
	position: relative;		\n\
}					\n\
h1.modalTitle div {			\n\
	clip: rect(0px 320px 16px 304px);\n\
	cursor: pointer;		\n\
	height: 16px;			\n\
	position: absolute;		\n\
	right: -27px;			\n\
	width: 352px;			\n\
}					\n\
.modalInside {				\n\
	padding: 5px !important;	\n\
}					\n\
.blackout {				\n\
	background: #000;		\n\
	left: 0;			\n\
	opacity: 0;			\n\
	position: absolute;		\n\
	top: 0;				\n\
	visibility: visible;		\n\
	width: 100%;			\n\
	z-index: 1000;			\n\
}					\n\
#positioned_elements {			\n\
	visibility: hidden;		\n\
}					');
		$().log('makeModal: CSS loaded');
		window.wgMakeModalCSSLoaded = true;
	}

   	this.addClass('modalInside').wrap('<div class="modalWrapper"></div>');

   	var wrapper = this.closest(".modalWrapper");

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
   		.prepend('<h1 class="modalTitle color1"><div style="background-image: url(http://images.wikia.com/common/skins/monaco/images/sprite.png);"></div>' + this.attr('title') + '</h1>')
   		.width(settings.width)
   		.css({
   			marginLeft: -wrapper.outerWidth() / 2,
			top: getModalTop(),
			zIndex: zIndex + 1
   		})
   		.fadeIn("fast")
		.log('makeModal: #' + this.attr('id'));

	// add event handlers
	var persistent = (typeof options.persistent == 'boolean') ? options.persistent : false;

	$("h1.modalTitle div").bind("click", function() {
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
  },
  // just hide the modal - don't remove DOM node
  hideModal: function() {
	this.animate({
  		top: this.offset()["top"] + 100,
  		opacity: 0
  	}, "fast");
  	$(".blackout:last").fadeOut("fast").addClass('blackoutHidden');
  },
  // show previously hidden modal
  showModal: function() {

	var wrapper = this.closest(".modalWrapper");

	// let's have it dynamically generated, so every newly created modal will be on the top 
	var zIndex = ($('.blackout').length+1) * 1000;

	wrapper
		.css('zIndex', zIndex+1)
		.animate({
	  		top: wrapper.offset()["top"] - 100,
  			opacity: 1
	  	}, "fast")
		.log('showModal: #' + this.attr('id'));

   	$(".blackout.blackoutHidden:last")
   		.height($(document).height())
		.css({zIndex: zIndex})
		.removeClass('blackoutHidden')
   		.fadeIn("fast");
  }
});
