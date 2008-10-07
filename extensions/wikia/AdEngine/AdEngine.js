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
                'http://m1.2mdn.net/viewad/817-grey.gif');  // DART sometimes sends this

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

/* The bucket name is for the type of test we are doing. This function is used because 
 * the bucket name can be set manually in php, or passed through the url
 */
AdEngine.getBucketName = function(){
	// Allow for it to be passed in the url, for testing
	var forceParam = document.location.search.match(/forceBucket=[A-Za-z0-9_\-]+/);
	if (forceParam != null ){
		AdEngine.bucketName = forceParam.toString().substr(12);
	}

	return AdEngine.bucketName;
};

/* The bucketid is the value for the current bucket that is being tested, 
 * it can also be passed through the url. 
 * Note that AdEngine.bucketid and it will be passed to DART as 'wkabkt', and some day to other AdProviders
 */
AdEngine.bucketid = ''; // Set it to empty string so we don't pass 'undefined' to ad providers
AdEngine.getBucketid = function(){
	var forceParam = document.location.search.match(/forceBucketid=[^&;]*/);
	if (forceParam != null ){
		AdEngine.bucketid = forceParam.toString().substr(14);
	} else if (YAHOO.util.Cookie.get('wkabkt') != null ){
		AdEngine.bucketid = YAHOO.util.Cookie.get('wkabkt');
	}

	return AdEngine.bucketid;
};

AdEngine.bucketDebug = function (){
	if (document.location.search.match(/bucketDebug/)){
                var msg = 'AdEngine.bucketName = "' + AdEngine.bucketName + '"\n' +
                  'AdEngine.bucketid = "' + AdEngine.bucketid + '"\n' + 
                  'wkabkt cookie = "' + YAHOO.util.Cookie.get('wkabkt') + '"\n';

                alert('Data from AdEngine.bucketDebug:\n' + msg);
	}
};


/* For testing click through rates on various placements of ads. 
 * Accepts a slotname, checks to see which bucket this user should be in,
 * and then adjusts the style for the containing div. The name of the bucket
 * is returned so that it can be passed to the ad call for reporting.
 * @return a unique id to identify the test (for passing in the ad call), or '' if no test done.
 */
AdEngine.doBucketTest = function (slotname) {
	AdEngine.getBucketName();
	AdEngine.getBucketid(); 

	// Set up the bucketid
	if (AdEngine.bucketid == ''){ // It will be empty if it hasn't been set by AdEngine.getBucketid()
		var bucketids = new Array('');

		// Set up the various tests
		if (slotname == 'TOP_LEADERBOARD' && AdEngine.bucketName == 'lp'){
			bucketids = new Array('lp_center', 'lp_left', 'lp_right', 'lp_control');

		} else if (slotname == 'TOP_LEADERBOARD' && AdEngine.bucketName == 'lp_at'){
			bucketids = new Array('lp_at_center', 'lp_at_left', 'lp_at_right', 'lp_at_control');

		} else if (slotname == 'TOP_RIGHT_BOXAD' && AdEngine.bucketName == 'bp'){
			bucketids = new Array('bp_overline', 'bp_down', 'bp_control');

		} 
		// Set up other bucket tests here. 

		if (bucketids.length > 1){
			AdEngine.bucketid = bucketids[Math.floor(Math.random()*bucketids.length)];
		}

	}


	// Do the switching of the css via javascript
	if (slotname == 'TOP_LEADERBOARD'){

	  switch (AdEngine.bucketid){
		case '': return; // No buckets for this page

		// Shift around the leaderboards in their current slot
		case 'lp_left':
			YAHOO.util.Dom.setStyle(slotname, "margin-left", "0");
			YAHOO.util.Dom.setStyle(slotname, "margin-right", "auto");
			break;
		case 'lp_center':
			YAHOO.util.Dom.setStyle(slotname, "margin-left", "auto");
			YAHOO.util.Dom.setStyle(slotname, "margin-right", "auto");
			break;
		case 'lp_right':
			YAHOO.util.Dom.setStyle(slotname, "margin-left", "auto");
			YAHOO.util.Dom.setStyle(slotname, "margin-right", "0");
			break;

		// Shift around the leaderboards in a new slot, above the title
		case 'lp_at_left':
			YAHOO.util.Dom.setStyle(slotname, "margin-left", "0");
			YAHOO.util.Dom.setStyle(slotname, "margin-right", "auto");
			break;
		case 'lp_at_center':
			YAHOO.util.Dom.setStyle(slotname, "margin-left", "auto");
			YAHOO.util.Dom.setStyle(slotname, "margin-right", "auto");
			break;
		case 'lp_at_right':
			YAHOO.util.Dom.setStyle(slotname, "margin-left", "auto");
			YAHOO.util.Dom.setStyle(slotname, "margin-right", "0");
			break;
	  }
	
	} else if (slotname == 'TOP_RIGHT_BOXAD'){

       	  // Shift the box ad up and down
	  switch (AdEngine.bucketid){
		case 'bp_overline':
			YAHOO.util.Dom.setStyle(slotname, "margin-top", "-45px");
			break;
		case 'bp_down':
			YAHOO.util.Dom.setStyle(slotname, "margin-top", "45px");
			break;
          }

	}	

	// Remember the bucketid for the current session
	YAHOO.util.Cookie.set("wkabkt", AdEngine.bucketid);
	
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
