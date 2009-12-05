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

/**
 * JavaScript for the theme chooser.
 */
WIKIA.WikiStickies.themeChooser = function () {
    // TODO: Is there some why to populate this dynamically?
    //       Seems like a bad idea to hardcode these like magic numbers.
    var themes = [
        'Sapphire',
        'Jade',
        'Slate',
        'Smoke',
        'Beach',
        'Brick',
        'Gaming'
    ];
    for (var i = 0; i < themes.length; i++) {
        // Copy the template, search and replace the values
        var ltheme = themes[i].toLowerCase();
        var thtml = $("#wikistickies-themechooser").html();
        // TODO: This should gracefully degrade better. And '$' isn't a valid
        //       character in HTML ID or class names. It needed to change.
        thtml = thtml.replace(/_THEME/g, themes[i]);
        thtml = thtml.replace(/_THEME/g, ltheme);

        // Create element with that preview and append it
        // TODO: Need to create ALL of the table, if you're going to use a
        //       table, in JavaScript. Cannot leave empty stub tables in
        //       template because they cause validation errors.
        $("#theme_scroller tr").append("<td>" + thtml + "</td>");
        $("#theme_preview_image_" + ltheme).attr("src", "http://images.wikia.com/common/skins/monaco/" + ltheme + "/images/preview.png");

        // Check the box with the current theme ($wgAdminSkin)
        if (WIKIA.WikiStickies.wgAdminSkin.replace(/monaco-/, '') == ltheme) {
            // Check the box and change the theme
            $("#theme_radio_" + ltheme).attr("checked", true);
            WIKIA.WikiStickies.track( '/admin/' + ltheme );
            NWB.changeTheme(ltheme, false);
        }
    }
};

$(document).ready(function() {
	$('.wikistickiesfeed .MoreLink').click(WIKIA.WikiStickies.toggleMore);
	$('.wikistickiesfeed').children('ul').find('a').click(WIKIA.WikiStickies.trackContainer);
	WIKIA.WikiStickies.placeContent();
	if ($('#wikistickies-themechooser').length) {
        WIKIA.WikiStickies.themeChooser();
    }
});
