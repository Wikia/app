/* global require */
require(['jquery'], function($) {
	'use strict';

	/* temp location, move to core when needed */
	// jQuery plugin: PutCursorAtEnd 1.0
	// http://plugins.jquery.com/project/PutCursorAtEnd
	// by teedyay
	//
	// Puts the cursor at the end of a textbox/ textarea
	// codesnippet: 691e18b1-f4f9-41b4-8fe8-bc8ee51b48d4

    $.fn.putCursorAtEnd = function () {
        return this.each(function () {
            $(this).focus();
            // If this function exists...
            if (this.setSelectionRange) {
                // ... then use it
                // (Doesn't work in IE)
                // Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
                var len = $(this).val().length * 2;
                this.setSelectionRange(len, len);
            } else {
                // ... otherwise replace the contents with itself
                // (Doesn't work in Google Chrome)
                $(this).val($(this).val());
            }
            // Scroll to the bottom, in case we're in a tall textarea
            // (Necessary for Firefox and Google Chrome)
            this.scrollTop = 999999;
        });
    };

    $.fn.putCursorAtEndCE = function () {
	    return this.each(function () {
		    var range, selection;

		    // Firefox, Chrome, Opera, Safari, IE 9+
		    if (document.createRange) {
			    //Create a range (a range is a like the selection but invisible)
		        range = document.createRange();
			    //Select the entire contents of the element with the range
		        range.selectNodeContents(this);
			    //collapse the range to the end point. false means collapse to end rather than the start
		        range.collapse(false);
			    //get the selection object (allows you to change selection)
		        selection = window.getSelection();
			    //remove any selections already made
		        selection.removeAllRanges();
		        selection.addRange(range);//make the range you have just created the visible selection
		    } else if (document.selection) {
			    //IE 8 and lower


		        range = document.body.createTextRange();
		        range.moveToElementText(this);
		        range.collapse(false);
		        range.select();
		    }
	    });
    };

    $(function () {
	    $('#Wall').wikiaWall();
    });
});
