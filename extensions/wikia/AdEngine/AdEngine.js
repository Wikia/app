var AdsCB = Math.floor(Math.random()*99999999); // generate random number to use as a cache buster during the call for ad (OpenX and DART) 
/**
 * Utility functions related to AdEngine
 * @author Nick Sullivan
*/

var AdEngine = {
	bodyWrapper : 'bodyContent',
	adColorsContent : []
};

/**
 * For pages that have divs floated right, clear right so they appear under a box ad
 * Param side should be either "left" or "right"
 * Code pulled originally from FAST.js, with some modifications.
 * @author Inez Korczynski, lightly modified by Nick Sullivan
 */
AdEngine.resetCssClear = function (side) {
	$("#" + AdEngine.bodyWrapper + " div, #" + AdEngine.bodyWrapper +" table").each(function() {
		if ($(this).css("float") == side) {
			$(this).css("clear", side);
		}
	});
};

/**
 * Utility functions for determining what colors are on articles,
 * so that we know what colors to display for ads. For example,
 * if the site has a black background, call a black ad from Google
 * Code pulled originally from FAST.js, with some modifications.
 *
 * @author Inez Korczynski, repackaged into AdEngine by Nick Sullivan,
 * rewritten to use jQuery by Nick
 */
AdEngine.getAdColor = function (type) {


	if(typeof window.themename == 'string') {
		if(typeof AdEngine.adColorsContent[window.themename] == 'object') {
			if(typeof AdEngine.adColorsContent[window.themename][type] == 'string') {
				return AdEngine.adColorsContent[window.themename][type];
			}
		}
	}

	if(typeof AdEngine.adColorsContent[type] == 'string') {
		return AdEngine.adColorsContent[type];
	}

	if(type == 'text') {
		AdEngine.adColorsContent[type] = AdEngine.normalizeColor($('#article').css('color'));
		return AdEngine.adColorsContent[type];
	}

	if(type == 'link' || type == 'url') {

		var a;
		if ($("#article a:first").length > 0){
			a=$("#article a:first");
			AdEngine.adColorsContent[type] = AdEngine.normalizeColor(a.css('color'));
		} else if ($("a:first").length > 0){
			a=$("a:first");
			AdEngine.adColorsContent[type] = AdEngine.normalizeColor(a.css('color'));
		} else {
			AdEngine.adColorsContent[type] = "black";
		}

		return AdEngine.adColorsContent[type];
	}

	if(type == 'bg') {
	        var color = AdEngine.normalizeColor($('#article').css('background-color'));

		if(color === '' || color == window.AdGetColor('text')) {
		        color = AdEngine.normalizeColor($('#wikia_page').css('background-color'));
        	}

	        if(color === '' || color == '000000') {
       		 	color = AdEngine.normalizeColor($("#bodyContent").css('background-color'));
       		}

		AdEngine.adColorsContent[type] = color;
		return AdEngine.adColorsContent[type];
	}

};

/* We can get color data in a lot of different formats. Normalize here for css. false on error */
AdEngine.normalizeColor = function(input){
	if (input == "transparent") {
		return "";
        } else if (input.match(/^#[A-F0-9a-f]{6}/)){
		// It's 6 digit already hex
		return input.toUpperCase().replace(/^#/, "");
	} else if (input.match(/^#[A-F0-9a-f]{3}$/)){
		// It's 3 digit hex. Convert to 6. Thank you IE.
		var f = input.substring(1, 1);
		var s = input.substring(2, 1);
		var t = input.substring(3, 1);
		var out = f + f + s + s + t + t;
		return out.toUpperCase();
	} else if (input.match(/^rgb/)){
		var str = input.replace(/[^0-9,]/g, '');
		var rgb = str.split(",");
		return AdEngine.dec2hex(rgb[0]) + 
		       AdEngine.dec2hex(rgb[1]) + 
		       AdEngine.dec2hex(rgb[2]); 
	} else {
		// Input is a string, like "white"
		return input;
	}
};

AdEngine.dec2hex = function(d){
	var h = parseInt(d, 10).toString(16); 
	if (h.toString() == "0"){
		return "00";
	} else {
		return h.toUpperCase();
	}
};

/* Backward compatible function call, this method is already referenced in Ad Server code */
window.AdGetColor = AdEngine.getAdColor;

/* Display the div for an ad, as long as it is not a no-op ad, such as a clear gif */
AdEngine.displaySlotIfAd = function (slotname) {
        var noopStrings = [ 'http://images.wikia.com/common/wikia/noad.gif' ]; // This should be our standard no-op

        var noopFound = false;
        for (var i = 0 ; i < noopStrings.length; i++){
                if($('#' + slotname + '_load').html().indexOf(noopStrings[i]) > -1 ) {
                	$("#" + slotname + "_load").hide();
                        noopFound = true;
                        break;
                }
        }
        // All clear
        if (! noopFound ) {
		$("#" + slotname).show();
        }
};



/* Return the meta keywords so they can be passed as hints */
AdEngine.getKeywords = function () {
	var metaTags = document.getElementsByTagName('meta');
	for (var i = 0; i < metaTags.length; i++){
		if (metaTags[i].name == "keywords"){
			return metaTags[i].content;
		}
	}
	return '';
};

/* Target based on the minute of the hour */
AdEngine.getMinuteTargeting = function (){
	var myDate = new Date();
	return myDate.getMinutes() % 15;
}; 

AdEngine.hiddenSlotOnShortPage = function (slotname) {
	if(slotname == 'PREFOOTER_LEFT_BOXAD' || slotname == 'PREFOOTER_RIGHT_BOXAD' || slotname == 'LEFT_SKYSCRAPER_2' || slotname == 'LEFT_SKYSCRAPER_3') {
		if($(document).height() >= 1680) {
			$('#' +  slotname).css("display", "block")
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}