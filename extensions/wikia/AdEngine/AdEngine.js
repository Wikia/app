var AdsCB = Math.floor(Math.random()*99999999); // generate random number to use as a cache buster during the call for ad (OpenX and DART) 
/**
 * Utility functions related to AdEngine
 * @author Nick Sullivan
*/

function AdEngine (){
	this.bodyWrapper = 'bodyContent';
}

/**
 * For pages that have divs floated right, clear right so they appear under a box ad
 * Param side should be either "left" or "right"
 * Code pulled originally from FAST.js, with some modifications.
 * @author Inez Korczynski, lightly modified by Nick Sullivan
 */
AdEngine.resetCssClear = function (side) {
	var Dom = YAHOO.util.Dom;
	Dom.getElementsBy(function(el) {
	if((el.nodeName == 'DIV' || el.nodeName == 'TABLE') &&
		    // el.id.substring(0,7) != 'adSpace' &&
		    Dom.getStyle(el, 'float') == side) {
			return true;
		}
		return false;

	}, null, this.bodyWrapper , function(el) {
			Dom.setStyle(el, 'clear', side);
	});

};

/**
 * Utility functions for determining what colors are on articles,
 * so that we know what colors to display for ads. For example,
 * if the site has a black background, call a black ad from Google
 * Code pulled originally from FAST.js, with some modifications.
 *
 * @author Inez Korczynski, repackaged into AdEngine by Nick Sullivan
 */
AdEngine.getAdColor = function (type) {

	if(typeof adColorsContent == 'undefined') {
		adColorsContent = new Array();
	}

	if(typeof themename == 'string') {
		if(typeof adColorsContent[themename] == 'object') {
			if(typeof adColorsContent[themename][type] == 'string') {
				return adColorsContent[themename][type];
			}
		}
	}

	if(typeof adColorsContent[type] == 'string') {
		return adColorsContent[type];
	}

	if(type == 'text') {
		adColorsContent[type] = AdEngine.getHEX(YAHOO.util.Dom.getStyle('article', 'color'));
		return adColorsContent[type];
	}

	if(type == 'link' || type == 'url') {
		var link;

		var editSections = YAHOO.util.Dom.getElementsByClassName('editsection', 'span', 'article');
		if(editSections.length > 0) {
			link = editSections[0].getElementsByTagName('a')[0];
		}

		if(link == null) {
			var links = $('bodyContent').getElementsByTagName('a');
			for(i = 0; i < links.length; i++) {
				if(!YAHOO.util.Dom.hasClass(links[i], 'new')) {
					link = links[i];
					break;
				}
			}
			if(link == null) {
				link = links[0];
			}
		}

		adColorsContent[type] = AdEngine.getHEX(YAHOO.util.Dom.getStyle(link, 'color'));
		return adColorsContent[type];
	}

	if(type == 'bg') {
	        var color = AdEngine.getHEX(YAHOO.util.Dom.getStyle('article', 'background-color'));

		if(color == 'transparent' || color == AdGetColor('text')) {
		        color = AdEngine.getHEX(YAHOO.util.Dom.getStyle('wikia_page', 'background-color'));
        	}

	        if(color == 'transparent' || color == '000000') {
       		 	color = AdEngine.getHEX(YAHOO.util.Dom.getStyle(document.body, 'background-color'));
       		}

		adColorsContent[type] = color;
		return adColorsContent[type];
	}

};

AdEngine.dec2hex = function (n) {
	var HCHARS = "0123456789ABCDEF";
	n = parseInt(n, 10);
	n = (YAHOO.lang.isNumber(n)) ? n : 0;
	n = (n > 255 || n < 0) ? 0 : n;
	return HCHARS.charAt((n - n % 16) / 16) + HCHARS.charAt(n % 16);
};

AdEngine.rgb2hex = function (r, g, b) {
	if (YAHOO.lang.isArray(r)) {
		return AdEngine.rgb2hex(r[0], r[1], r[2]);
	}
	return AdEngine.dec2hex(r) + AdEngine.dec2hex(g) + AdEngine.dec2hex(b);
};

AdEngine.getHEX = function (color) {
	if(color == 'transparent') {
		return color;
	}

	if(color.match("^\#")) {
		return color.substring(1);
	}

	return AdEngine.rgb2hex(color.substring(4).substr(0, color.length-5).split(', '));
};


/* Backward compatible function call, this method is already referenced in Ad Server code */
function AdGetColor(type) {
	return AdEngine.getAdColor(type);
}

/* Display the div for an ad, as long as it is not a no-op ad, such as a clear gif */
AdEngine.displaySlotIfAd = function (slotname) {
        var noopStrings = new Array(
                'http://images.wikia.com/common/wikia/noad.gif', // This should be our standard no-op
                'http://m1.2mdn.net/viewad/817-grey.gif'  // DART sometimes sends this
        );
        var noopFound = false;
        for (i = 0 ; i < noopStrings.length; i++){
                if($(slotname + '_load').innerHTML.indexOf(noopStrings[i]) > -1 ) {
                        noopFound = true;
                        break;
                }
        }
        // All clear
        if (! noopFound ) {
                YAHOO.util.Dom.setStyle(slotname, 'display', 'block');
        }
};

AdEngine.getBucketName = function(){
	// Allow for it to be passed in the url, for testing
	var forceParam = document.location.search.match(/forceBucket=[A-Za-z0-9_\-]+/);
	if (forceParam != null ){
		AdEngine.bucketName = forceParam.toString().substr(12);
		return AdEngine.bucketName;
	} else if (AdEngine.bucketName != '' ){
		return AdEngine.bucketName;
	} else {
		return '';
	}
};

/* For testing click through rates on various placements of ads. 
 * Accepts a slotname, checks to see which bucket this user should be in,
 * and then adjusts the style for the containing div. The name of the bucket
 * is returned so that it can be passed to the ad call for reporting.
 * @return a unique id to identify the test (for passing in the ad call), or '' if no test done.
 */
AdEngine.doBucketTest = function (slotname) {
	var myBucket = AdEngine.getBucketName();
	AdEngine.bucketid = ''; // Ad Engine bucket id is passed to the ad call for CTR tracking

	if (slotname == 'TOP_LEADERBOARD' && myBucket == 'lp'){
		// Switch around the leaderboard in it's current position
		
		var rand = randomnumber=Math.ceil(Math.random()*4);
		switch (rand){
			// Pick from different placements and shift accordingly
			case 1:
				document.getElementById(slotname).className=slotname + '_center';
				AdEngine.bucketid = 'lp_center';
				break;
			case 2:
				document.getElementById(slotname).className=slotname + '_left';
				AdEngine.bucketid ='lp_left';
				break;
			case 3:
				document.getElementById(slotname).className=slotname + '_right';
				AdEngine.bucketid ='lp_right';
				break;
			default: // not in bucket test
				AdEngine.bucketid ='lp_control';
		}
		
	} else if (slotname == 'TOP_LEADERBOARD' && myBucket == 'lp_at'){
		// Switch around the leaderboard in it's current position
		
		var rand = randomnumber=Math.ceil(Math.random()*4);
		switch (rand){
			// Pick from different placements and shift accordingly
			case 1:
				document.getElementById(slotname).className=slotname + '_center';
				AdEngine.bucketid ='lp_at_center';
				break;
			case 2:
				document.getElementById(slotname).className=slotname + '_left';
				AdEngine.bucketid ='lp_at_left';
				break;
			case 3:
				document.getElementById(slotname).className=slotname + '_right';
				AdEngine.bucketid ='lp_at_right';
				break;
			default: // not in bucket test
				AdEngine.bucketid ='lp_at_control';
		}
		
	} else if (slotname == 'TOP_RIGHT_BOXAD' && myBucket == 'bp'){
		// Switch around the leaderboard in it's current position
		
		var rand = randomnumber=Math.ceil(Math.random()*3);
		switch (rand){
			// Pick from different placements and shift accordingly
			case 1:
				document.getElementById(slotname).className=slotname + '_overline';
				AdEngine.bucketid ='bp_overline';
				break;
			case 2:
				document.getElementById(slotname).className=slotname + '_down';
				AdEngine.bucketid ='bp_down';
				break;
			default: // not in bucket test
				AdEngine.bucketid ='bp_control';
		}
	}	

	// Set up other bucket tests here. Set this.bucket and it will be passed to DART as 'wkabkt'
	return AdEngine.bucketid;

};

/* Return the meta keywords so they can be passed as hints */
AdEngine.getKeywords = function () {
	var metaTags = document.getElementsByTagName('meta');
	for (i = 0; i < metaTags.length; i++){
		if (metaTags[i].name == "keywords"){
			return metaTags[i].content;
		}
	}
	return '';
};
