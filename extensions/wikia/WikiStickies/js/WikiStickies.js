/**
 * @ingroup Wikia
 * @file WikiStickies.js
 * @package WikiStickies
 *
 * Base WikiStickies JavaScript file.
 *
 * This JavaScript contains the base WikiStickies functionality as well as any
 * functionality necessary for the Special:WikiStickies page.
 */

// WikiStickies "namespace."
WIKIA.WikiStickies = {};

/**
 * Toggles the display of additional items and the more/less link.
 */
WIKIA.WikiStickies.toggleMore = function (e) {
    if (e) { e.preventDefault(); }

    // TODO: Internationalize "see more" and "hide" text.
    // What's the JS equivalent of wfMsg()?
    if (this.innerHTML === 'see more') {
        // show more
        $(this.previousSibling).show();
        this.innerHTML = 'hide';
    } else {
        // show less
        $(this.previousSibling).hide();
        this.innerHTML = 'see more';
    }
};

/**
 * Wrapper for tracking
 */

WIKIA.WikiStickies.track = function( fakeUrl ) {
	WET.byStr('WikiStickies' + fakeUrl);
}

/**
 * Track the container
 */


WIKIA.WikiStickies.trackContainer = function (ev) {
	var containerId = $(ev.target).closest( '.wikistickiesfeed' ).attr('id');
	var containerName = containerId.split('-').pop();

	WIKIA.WikiStickies.track('/item/' + containerName);
}

/**
 * Appropriately sizes, positions, and finally displays a wikisticky.
 */
WIKIA.WikiStickies.placeContent = function () {
    $(".wikisticky_browser").each(function() {
        var ws_content = this.childNodes[0];
        var ws_para = this.getElementsByTagName('p')[0];
        $(ws_para).css('fontSize', '14pt');
        var verticalDifference = $(ws_content).height() - $(ws_para).height();
        while (verticalDifference < 0) {
            $(ws_para).css("fontSize", parseInt($(ws_para).css("fontSize") ) - 1);
            verticalDifference = $(ws_content).height() - $(ws_para).height();
        }
        $(ws_para).css("top", verticalDifference / 2);
        $(ws_content).css('visibility', 'visible');
    });
};

$(document).ready(function() {
	$('.wikistickiesfeed .MoreLink').click(WIKIA.WikiStickies.toggleMore);
	$('.wikistickiesfeed').children('ul').find('a').click(WIKIA.WikiStickies.trackContainer);
	WIKIA.WikiStickies.placeContent();
});
