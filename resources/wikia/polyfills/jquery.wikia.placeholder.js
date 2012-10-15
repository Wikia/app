/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * HTML5 placeholder attribute fallback for HTML5-disabled browsers.
 * A placeholder CSS class should be defined (use the forms mixin in Oasis)
 */
jQuery.fn.placeholder = function() {
	 //feature detection
	var hasNativeSupport = 'placeholder' in document.createElement('input');

	return this.each(function() {
		if(hasNativeSupport){
			return;
		}
		var input = $(this);
		var text = input.attr('placeholder');

		if(input.val() == ''){
			input
				.addClass('placeholder')
				.val(text);
		}

		input.focus(function(){
			if(input.val() == text){
				input.val('');
			}

			input.removeClass('placeholder');
		});

		input.blur(function(){
			if(input.val() == ''){
				input
					.addClass('placeholder')
					.val(text);
			}
		});

		//clear the field if a submit event is fired somewhere around here
		input.closest('form').submit(function(){
			if(input.val() == text){
				input.val('');
			}
		});
	});
};

$(function() {
	$('input[placeholder], textarea[placeholder]').placeholder();
});
