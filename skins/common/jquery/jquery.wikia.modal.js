//Modal
$.fn.extend({
  makeModal: function(options) {
	var settings = { width: 400 };
	if (options) {
		$.extend(settings, options);
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
   		.fadeIn("fast");

	$("h1.modalTitle div").bind("click", function() {
		wrapper.closeModal();
	});

   	$(window)
   		.bind("keypress.modal", function(event) {
   			if (event.keyCode == 27) {
   				wrapper.closeModal();
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
   			wrapper.closeModal();
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
  	})
  } 
});
