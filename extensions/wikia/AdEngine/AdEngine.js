if (!window.wgDisableOldAdDriver) {

var AdsCB = Math.floor(Math.random()*99999999); // generate random number to use as a cache buster during the call for ad (OpenX and DART)
/**
 * Utility functions related to AdEngine
 * @author Nick Sullivan
*/

var AdEngine = {
	bodyWrapper : 'bodyContent',
	adColorsContent : [],
	hidableSlotThreshold1 : 2400,
	hidableSlotThreshold2 : 4000,
	hidableSlotsThresholds : {},

	init : function () {
		AdEngine.hidableSlotsThresholds['LEFT_SKYSCRAPER_2'] = AdEngine.hidableSlotThreshold1;
		AdEngine.hidableSlotsThresholds['LEFT_SKYSCRAPER_3'] = AdEngine.hidableSlotThreshold2;
		AdEngine.hidableSlotsThresholds['PREFOOTER_LEFT_BOXAD'] = AdEngine.hidableSlotThreshold1;
		AdEngine.hidableSlotsThresholds['PREFOOTER_RIGHT_BOXAD'] = AdEngine.hidableSlotThreshold1;
	}
};

AdEngine.init();

/**
 * For pages that have divs floated right, clear right so they appear under a box ad
 * Param side should be either "left" or "right"
 * Code pulled originally from FAST.js, with some modifications.
 * @author Inez Korczynski, lightly modified by Nick Sullivan
 */
AdEngine.resetCssClear = function (side) {
	$("#" + AdEngine.bodyWrapper + " div, #" + AdEngine.bodyWrapper + " table").each(function() {
		var $this = $(this);
		if ($this.css("float") === side) {
			$this.css("clear", side);
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
	var color;

	if (typeof window.themename === 'string') {
		if (typeof AdEngine.adColorsContent[window.themename] === 'object') {
			if (typeof AdEngine.adColorsContent[window.themename][type] === 'string') {
				return AdEngine.adColorsContent[window.themename][type];
			}
		}
	}

	if (typeof AdEngine.adColorsContent[type] === 'string') {
		return AdEngine.adColorsContent[type];
	}

	if (type === 'text') {
		AdEngine.adColorsContent[type] = AdEngine.normalizeColor($('#article').css('color'));
		return AdEngine.adColorsContent[type];
	}

	if (type === 'link' || type === 'url') {
		color = $('#article a:first').css('color') || $('a:first').css('color');
		if (color) {
			AdEngine.adColorsContent[type] = AdEngine.normalizeColor(color);
		} else {
			// fallback
			AdEngine.adColorsContent[type] = 'black';
		}
		return AdEngine.adColorsContent[type];
	}

	if (type === 'bg') {
		color = AdEngine.normalizeColor($('#article').css('background-color'));

		if (color === '' || color === window.AdGetColor('text')) {
			color = AdEngine.normalizeColor($('#wikia_page').css('background-color'));
		}

		if (color === '' || color === '000000') {
			color = AdEngine.normalizeColor($("#bodyContent").css('background-color'));
		}

		AdEngine.adColorsContent[type] = color;
		return AdEngine.adColorsContent[type];
	}
};

/* We can get color data in a lot of different formats. Normalize here for css. false on error */
AdEngine.normalizeColor = function (input) {
	var out, str, rgb;
	if (input === "transparent") {
		return "";
	}
	if (input.match(/^#[A-F0-9a-f]{6}$/)) {
		// It's 6 digit already hex
		return input.toUpperCase().replace(/^#/, '');
	}
	if (input.match(/^#[A-F0-9a-f]{3}$/)){
		// It's 3 digit hex. Convert to 6. Thank you IE.
		out = input.toUpperCase();
		return out[0] + out[0] + out[1] + out[1] + out[2] + out[2];
	}
	if (input.match(/^rgb/)){
		str = input.replace(/[^0-9,]/g, '');
		rgb = str.split(",");
		return AdEngine.dec2hex(rgb[0]) + AdEngine.dec2hex(rgb[1]) + AdEngine.dec2hex(rgb[2]);
	}
	return input;
};

AdEngine.dec2hex = function (d) {
	var h = parseInt(d, 10).toString(16);
	if (h.length === 1) {
		h = '0' + h;
	}
	return h.toUpperCase();
};

/* Backward compatible function call, this method is already referenced in Ad Server code */
window.AdGetColor = AdEngine.getAdColor;

/* Display the div for an ad, as long as it is not a no-op ad, such as a clear gif */
AdEngine.displaySlotIfAd = function (slotname) {
	// FIXME: this check is highly unlikely to be used
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

AdEngine.isSlotHidable = function(slotname) {
	return slotname in AdEngine.hidableSlotsThresholds;
};

AdEngine.isSlotDisplayableOnCurrentPage = function(slotname) {
	if (AdEngine.isSlotHidable(slotname)) {
		if($(document).height() >= AdEngine.hidableSlotsThresholds[slotname]) {
			return true;
		}
		else {
			return false;
		}
	}

	return true;
};

AdEngine.hiddenSlotOnShortPage = function(slotname) {
	if (AdEngine.isSlotHidable(slotname)) {
		if (AdEngine.isSlotDisplayableOnCurrentPage(slotname)) {
			$('#' + slotname).show();
			return false;
		}
		else {
			return true;
		}
	}

	return false;
};

} // endif (!window.wgDisableOldAdDriver)
