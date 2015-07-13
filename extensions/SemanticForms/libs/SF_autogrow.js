/**
 * SF_autogrow.js
 *
 * Allows for 'autogrow' textareas. Based heavily on the 'Autogrow Textarea
 * Plugin' by Jevin O. Sewaruth:
 * http://www.technoreply.com/autogrow-textarea-plugin/
 *
 * Some modifications were made for the code to better work with Semantic
 * Forms.
 *
 * @author Jevin O. Sewaruth
 * @author Yaron Koren
 */

var autoGrowColsDefault = [];
var autoGrowRowsDefault = [];

function autoGrowSetDefaultValues(textArea) {
	var id = textArea.id;
	autoGrowColsDefault[id] = textArea.cols;
	autoGrowRowsDefault[id] = textArea.rows;
}

function autoGrow(textArea) {
    var linesCount = 0;
    var lines = textArea.value.split('\n');

    for (var i = lines.length-1; i >= 0; --i) {
        linesCount += Math.floor((lines[i].length / autoGrowColsDefault[textArea.id]) + 1);
    }

    if (linesCount >= autoGrowRowsDefault[textArea.id]) {
        textArea.rows = linesCount + 1;
    }
    else {
        textArea.rows = autoGrowRowsDefault[textArea.id];
    }
}

function autoGrowBindEvents(textArea) {
    textArea.onkeyup = function() {
        autoGrow(textArea);
    };
}

// jQuery method
jQuery.fn.autoGrow = function() {
	return this.each(function() {
		autoGrowSetDefaultValues(this);
		autoGrowBindEvents(this);
		autoGrow(this);
	});
};
