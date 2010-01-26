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
    
    status = $(e.target.parentNode).find(".submerged").css("display") !== "none"; 
 
    if (!status) {
        // show more
        $(this.previousSibling).show();
        // click tracking
        WIKIA.WikiStickies.track('/item/seemore/' + WIKIA.WikiStickies.getFeedContainer( e.target ) );	
        this.innerHTML = wikistickies_msg_hide;
    } else {
        // show less
        $(this.previousSibling).hide();
        // click tracking
        WIKIA.WikiStickies.track('/item/hidemore/' + WIKIA.WikiStickies.getFeedContainer( e.target ) );	
        this.innerHTML = wikistickies_msg_see_more;
    }
    
    return false;
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

WIKIA.WikiStickies.getFeedContainer = function (target) {
	var containerId = $(target).closest( '.wikistickiesfeed' ).attr('id');
	return containerId.split('-').pop();
}


WIKIA.WikiStickies.trackContainer = function (ev) {
	WIKIA.WikiStickies.track('/item/' + WIKIA.WikiStickies.getFeedContainer( ev.target ) );
}


WIKIA.WikiStickies.trackSticky = function (ev) {
	var containerId = $(ev.target).closest( '.wikisticky_browser' ).attr('id');
	var containerName = containerId.split('-')[1];
	if (typeof containerName != "undefined") {
	WIKIA.WikiStickies.track('/item/' + containerName + '-sticky');	
	}
}

/**
 * Appropriately sizes, positions, and finally displays a wikisticky.
 */
WIKIA.WikiStickies.placeContent = function () {
    $(".wikisticky_browser").each(function() {
        var ws_content = this.childNodes[0];
        var ws_para = ws_content.childNodes[0];
        $(ws_para).css('fontSize', '14pt');
        var verticalDifference = $(ws_content).height() - $(ws_para).height();
	var infinitumGuard = 0;
        while (verticalDifference < 0) {
		if( 99 < infinitumGuard ) { // did they put in an image? do we need to operate?
			break;
		}	
		$(ws_para).css("fontSize", parseInt($(ws_para).css("fontSize") ) - 1);
		verticalDifference = $(ws_content).height() - $(ws_para).height();
		infinitumGuard++;
        }
        $(ws_para).css("top", verticalDifference / 2);
        $(ws_content).css('visibility', 'visible');
    });
};

$(document).ready(function() {
	$('.wikistickiesfeed .MoreLink').click(WIKIA.WikiStickies.toggleMore);
	$('.wikistickiesfeed').children('ul').find('a').click(WIKIA.WikiStickies.trackContainer);
	$('.wikisticky_browser').children('div').find('a').click(WIKIA.WikiStickies.trackSticky);

	WIKIA.WikiStickies.placeContent();
});
