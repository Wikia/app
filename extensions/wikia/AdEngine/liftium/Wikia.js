/************************************************************************
 *									*
 * Begin LiftiumDART a class used for generating DART urls		*
 *									*
************************************************************************/ 

/* Logic for generating a dart tag. Documentation stripped from this version.
 * See AdProviderDART.php for more info
 */ 

// Scope variables if you are in an iframe
var Liftium = window.Liftium;
try {
var wgIsMainpage = window.wgIsMainpage || top.wgIsMainpage || false;  
} catch (e) { } 

var LiftiumDART = {
	random: Math.round(Math.random() * 23456787654), // The random number should be generated once and the same for all
	sites : {
	  'Auto' : 'wka.auto',
	  'Creative' : 'wka.crea',
	  'Education' : 'wka.edu',
	  'Entertainment' : 'wka.ent',
	  'Finance' : 'wka.fin',
	  'Gaming' : 'wka.gaming',
	  'Green' : 'wka.green',
	  'Humor' : 'wka.humor',
	  'Lifestyle' : 'wka.life',
	  'Music' : 'wka.music',
	  'Philosophy' : 'wka.phil',
	  'Politics' : 'wka.poli',
	  'Science' : 'wka.sci',
	  'Sports' : 'wka.sports',
	  'Technology' : 'wka.tech',
	  'Test Site' : 'wka.test',
	  'Toys' : 'wka.toys',
	  'Travel' : 'wka.travel'},
	slotconfig : {
	   'TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"}, 
	   'TOP_LEADERBOARD': {'tile': 2, 'loc': "top", 'dcopt': "ist"},
	   'DOCKED_LEADERBOARD': {'tile': 8, 'loc': "bottom"},
	   'LEFT_SKYSCRAPER_1': {'tile': 3, 'loc': "top"},
	   'LEFT_SKYSCRAPER_2': {'tile': 3, 'loc': "middle"},
	   'LEFT_SKYSCRAPER_3': {'tile': 6, 'loc': "middle"},
	   'FOOTER_BOXAD': {'tile': 5, 'loc': "footer"},
	   'PREFOOTER_LEFT_BOXAD': {'tile': 5, 'loc': "footer"},
	   'PREFOOTER_RIGHT_BOXAD': {'tile': 5, 'loc': "footer"},
	   'PREFOOTER_BIG': {'tile': 5, 'loc': "footer"},
	   'HOME_TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"},
	   'HOME_TOP_LEADERBOARD': {'tile': 2, 'loc': "top", 'dcopt': "ist"},
	   'HOME_LEFT_SKYSCRAPER_1': {'tile':3, 'loc': "top"},
	   'HOME_LEFT_SKYSCRAPER_2': {'tile':3, 'loc': "middle"},
	   'INCONTENT_BOXAD_1': {'tile':4, 'loc': "middle"},
	   'INCONTENT_BOXAD_2': {'tile':5, 'loc': "middle"},
	   'INCONTENT_BOXAD_3': {'tile':6, 'loc': "middle"},
	   'INCONTENT_BOXAD_4': {'tile':7, 'loc': "middle"},
	   'INCONTENT_BOXAD_5': {'tile':8, 'loc': "middle"},
	   'INCONTENT_LEADERBOARD_1': {'tile':4, 'loc': "middle"},
	   'INCONTENT_LEADERBOARD_2': {'tile':5, 'loc': "middle"},
	   'INCONTENT_LEADERBOARD_3': {'tile':6, 'loc': "middle"},
	   'INCONTENT_LEADERBOARD_4': {'tile':7, 'loc': "middle"},
	   'INCONTENT_LEADERBOARD_5': {'tile':8, 'loc': "middle"},
	   'EXIT_STITIAL_INVISIBLE': {'tile':1, 'loc': "exit", 'dcopt': "ist"},
	   'EXIT_STITIAL_BOXAD_1': {'tile':2, 'loc': "exit"},
	   'EXIT_STITIAL_BOXAD_2': {'tile':3, 'loc': "exit"},
	   'INVISIBLE_1': {'tile':10, 'loc': "invisible"},
	   'INVISIBLE_2': {'tile':11, 'loc': "invisible"},
	   'HOME_INVISIBLE_TOP': {'tile':12, 'loc': "invisible"},
	   'INVISIBLE_TOP': {'tile':13, 'loc': "invisible"},
	   'TEST_TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"},
	   'TEST_HOME_TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"} 
	},
	sizeconfig : {
	   '300x250':'300x250',
	   '600x250':'600x250,300x250',
	   '728x90':'728x90,468x60',
	   '160x600':'160x600,120x600',
	   '0x0':'1x1'
	}
};

LiftiumDART.callAd = function (slotname, size, network_options){
	if (Liftium.e(LiftiumDART.slotconfig[slotname])){
		Liftium.d("Notice: LiftiumDART not configured for " + slotname);
	}

	var url = LiftiumDART.getUrl(slotname, size, network_options, false);
	return '<scr' + 'ipt type="text/javascript" src="' + url + '"><\/sc' + 'ript>';
};


LiftiumDART.getUrl = function(slotname, size, network_options, iframe) {
	var url2 = AdConfig.DART.getUrl(slotname, size, true, 'Liftium');
	// replace sz=foo,bar,baz with sz=foo only
	var sz = url2.match(/;sz=[0-9x,]+;/);
	if (sz != null) {
		var sz2 = sz[0].match(/[0-9]+x[0-9]+/);
		url2 = url2.replace(/;sz=[0-9x,]+;/, ';sz=' + sz2[0] + ';');
	}
	Liftium.d("Dart URL2= " + url2, 4);
	return url2;

	// Hack for dart sizes 
        if (LiftiumDART.sizeconfig[size]){
                size = LiftiumDART.sizeconfig[size];
        }
	var url = 'http://' +
		LiftiumDART.getSubdomain() +
		'.doubleclick.net/' + 
		LiftiumDART.getAdType(iframe) + '/' +
		LiftiumDART.getDARTSite(Liftium.getPageVar('Hub')) + '/' +
		LiftiumDART.getZone1(Liftium.getPageVar('wgDBname')) + '/' +
		LiftiumDART.getZone2() + ';' +
		LiftiumDART.getAllDartKeyvalues(slotname) + 
		LiftiumDART.getResolution() + 
		LiftiumDART.getPrefooterStatus() + 
		LiftiumDART.getTitle() +
		"lang=" + Liftium.getPageVar('cont_lang', 'unknown') + ";" + 
		LiftiumDART.getQuantcastSegmentKV() +
		LiftiumDART.getImpressionCount(slotname) + 
		LiftiumDART.getDcoptKV(slotname) +
                'mtfIFPath=/extensions/wikia/AdEngine/;' +  // http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=117857, http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=117427
		"src=liftium;" +
		"sz=" + size + ';' +
		"mtfInline=true;" +	// http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=182220
		LiftiumDART.getTileKV(slotname) +

		"ord=" + LiftiumDART.random;

	Liftium.d("Dart URL = " + url, 4);
	return url;
};

LiftiumDART.getSubdomain = function() {
	var subdomain = 'ad';

	if (!Liftium.e(Liftium.geo.continent)) {
		switch (Liftium.geo.continent) {
			case 'AF':
			case 'EU':
				subdomain = 'ad-emea';
				break;
			case 'AS':
				Liftium.d('country: ' + Liftium.getCountry().toUpperCase(), 4);
				switch (Liftium.getCountry().toUpperCase()) {
					// Middle East
					case 'AE':
					case 'CY':
					case 'BH':
					case 'IL':
					case 'IQ':
					case 'IR':
					case 'JO':
					case 'KW':
					case 'LB':
					case 'OM':
					case 'PS':
					case 'QA':
					case 'SA':
					case 'SY':
					case 'TR':
					case 'YE':
						subdomain = 'ad-emea';
						break;
					default:
						subdomain = 'ad-apac';
				}
				break;
			case 'OC':
				subdomain = 'ad-apac';
				break;
			case 'NA':
			case 'SA':
			default:
				subdomain = 'ad';
		}
	}

	return subdomain;
}

LiftiumDART.getAdType = function(iframe){
	if (iframe) {
		return 'adi';
	} else {
		return 'adj';
	}
};

LiftiumDART.getDARTSite = function(hub){
	if(typeof LiftiumDART.sites[hub] != "undefined"){
		return LiftiumDART.sites[hub];
	} else {
		return 'wka.wikia';
	}
};

// Effectively the dbname, defaulting to wikia.
LiftiumDART.getZone1 = function(dbname){
	// Zone1 is prefixed with "_" because zone's can't start with a number, and some dbnames do.
	if (Liftium.e(dbname)){
		return '_wikia';
	} else {
		return '_' + dbname.replace('/[^0-9A-Z_a-z]/', '_');
	}
};

// Page type, ie, "home" or "article"
LiftiumDART.getZone2 = function(){
	if (!Liftium.e(Liftium.getPageVar('page_type'))) {
		return Liftium.getPageVar('page_type');
	} else {
		return 'article';
	}
};

LiftiumDART.getTileKV = function (slotname){
	if (!Liftium.e(LiftiumDART.slotconfig[slotname]) && LiftiumDART.slotconfig[slotname].tile){
		return 'tile=' + LiftiumDART.slotconfig[slotname].tile + ';';
	} else {
		return '';
	}
};

LiftiumDART.getDcoptKV = function(slotname){
	if (!Liftium.e(LiftiumDART.slotconfig[slotname]) && LiftiumDART.slotconfig[slotname].dcopt){
		return 'dcopt=' + LiftiumDART.slotconfig[slotname].dcopt + ';';
	} else {
		return '';
	}
};

LiftiumDART.getLocKv = function (slotname){
	if (!Liftium.e(LiftiumDART.slotconfig[slotname]) && LiftiumDART.slotconfig[slotname].loc){
		return 'loc=' + LiftiumDART.slotconfig[slotname].loc + ';';
	} else {
		return '';
	}
};

// Title is one of the always-present key-values
LiftiumDART.getArticleKV = function(){
	if (! Liftium.e(Liftium.getPageVar('article_id'))){
		return "artid=" + Liftium.getPageVar('article_id') + ';';
	} else {
		return '';
	}
};

LiftiumDART.getTitle = function(){
	if (!Liftium.e(wgPageName)) {
		return "wpage=" + wgPageName + ";";
	} else {
		return "";
	}
};


LiftiumDART.getDomainKV = function (hostname){
	var lhost, pieces, sld='', np;
	lhost = hostname.toLowerCase();

	pieces = lhost.split(".");
	np = pieces.length;

	if (pieces[np-2] == 'co'){
		// .co.uk or .co.jp
		sld = pieces[np-3] + '.' + pieces[np-2] + '.' + pieces[np-1];
	} else {
		sld = pieces[np-2] + '.' + pieces[np-1];
	}

	if (sld !== ''){
		return 'dmn=' + sld.replace(/\./g, '') + ';';
	} else {
		return '';
	}

};


LiftiumDART.getQuantcastSegmentKV = function (){
	var COOKIE_NAME = 'qcseg';
	var kv = '';
	if (typeof(wgIntegrateQuantcastSegments) === 'undefined' || Liftium.e(wgIntegrateQuantcastSegments)) {
		return kv;
	}
	if (!Liftium.e(Liftium.cookie(COOKIE_NAME))) {
	try {
		var qc = eval("(" + Liftium.cookie(COOKIE_NAME) + ")");
		if (!Liftium.e(qc) && !Liftium.e(qc.segments)) {
			for (var i in qc.segments) {
				kv += 'qcseg=' + qc.segments[i].id + ';';
			}
		}
	} catch (e) {
	}
	}

	return kv;
};

LiftiumDART.getImpressionCount = function (slotname) {
	// return key-value only if impression cookie exists

	if (Liftium.e(Liftium.adDriverNumCall)) {
		Liftium.d('Loading AdDriver data from cookie');
		var cookie = Liftium.cookie('adDriverNumAllCall');
		if (!Liftium.e(cookie)) {
			Liftium.adDriverNumCall = eval('(' + cookie + ')');
			Liftium.d('AdDriver data loaded:', 7, Liftium.AdDriverNumCall);
		}
	}

	if (!Liftium.e(Liftium.adDriverNumCall)) {
		for (var i=0; i < Liftium.adDriverNumCall.length; i++) {
			if (Liftium.adDriverNumCall[i].slotname == slotname) {
				// check cookie expiration
				if (parseInt(Liftium.adDriverNumCall[i].ts) + window.wgAdDriverCookieLifetime*3600000 > Liftium.now.getTime()) {  // wgAdDriverCookieLifetime in hours, convert to msec
					var num = parseInt(Liftium.adDriverNumCall[i].num);
					return 'impct=' + num + ';';
				}
			}
		}
	}

	return '';
}

LiftiumDART.getResolution = function () {
	if (Liftium.e(LiftiumDART.width) || Liftium.e(LiftiumDART.height)) {
		LiftiumDART.width = document.documentElement.clientWidth || document.body.clientWidth;
		LiftiumDART.height = document.documentElement.clientHeight || document.body.clientHeight;
		Liftium.d("resolution: " + LiftiumDART.width + "x" + LiftiumDART.height, 7);
		// Liftium.trackEvent(["resolution", LiftiumDART.width + "x" + LiftiumDART.height]);
	}
	if (LiftiumDART.width > 1024) {
		return 'dis=large;';
	} else {
		return '';
	}
};

LiftiumDART.getPrefooterStatus = function () {
	if (Liftium.e(LiftiumDART.hasprefooters)) {
		if (typeof AdEngine != "undefined") {
			if (AdEngine.isSlotDisplayableOnCurrentPage("PREFOOTER_LEFT_BOXAD")) {
				LiftiumDART.hasprefooters = "yes";
			} else {
				LiftiumDART.hasprefooters = "no";
			}
		} else {
			LiftiumDART.hasprefooters = "unknown";
		}
	}
	Liftium.d("has prefooters: " + LiftiumDART.hasprefooters, 7);

	return "hasp=" + LiftiumDART.hasprefooters + ";";

};

LiftiumDART.getAllDartKeyvalues = function (slotname){
	var out = 's0=' + LiftiumDART.getDARTSite(Liftium.getPageVar('Hub')).replace(/wka\./, '') + ';' +
		's1=' + LiftiumDART.getZone1(Liftium.getPageVar('wgDBname')) + ';' +
		's2=' + LiftiumDART.getZone2() + ';' +
		'@@WIKIA_PROVIDER_VALUES@@' +
		LiftiumDART.getLocKv(slotname) +
		LiftiumDART.getArticleKV() +
		LiftiumDART.getDomainKV(Liftium.getPageVar('domain')) +
		'pos=' + slotname + ';'; 
	out = out.replace(/@@WIKIA_AQ@@/, Athena.getMinuteTargeting());

	var d = Liftium.getPageVar('dart', '');
	if (!Liftium.e(d)) {
		out = out.replace(/@@WIKIA_PROVIDER_VALUES@@/, d + ';');
	}
	return out;
};

if (! window.Athena) {
  /* Support code left over from Athena */
  var Athena = {
	now : new Date(),
	definedInsideWikiajs : true	
  };

  /* Target based on the minute of the hour */
  Athena.getMinuteTargeting = function (){
        return Athena.now.getMinutes() % 15;
  };

  Athena.getPageVar = Liftium.getPageVar;
  Athena.setPageVar = Liftium.setPageVar;

}



/************************************************************************
 *									*
 * Begin AdsInContent, a class used for putting ads inline in the article
 *									*
************************************************************************/ 


var AdsInContent = {
	spaceBetweenAds : 550,
	numTries 	: 0,
	numAdsServed 	: 0,
	maxTries 	: 20,
	adsPerPage 	: 0,
	called 		: false
};

AdsInContent.putAdsInContent = function(htmlContainer) {
	AdsInContent.called = true;
	if (Liftium._(htmlContainer) === null){
		// This isn't going to work out. Probably called on the wrong page
		return false;
	} 
	if (!Liftium.e(wgEnableAdsInContent)) {
		AdsInContent.adsPerPage = parseInt(wgEnableAdsInContent);
		Liftium.d("AdsInContent: adsPerPage set to " + AdsInContent.adsPerPage, 5);
		if (isNaN(AdsInContent.adsPerPage)) {
			AdsInContent.adsPerPage = 0;
		}
	}
	if (AdsInContent.adsPerPage == 0) {
		Liftium.d("AdsInContent: adsPerPage is " + AdsInContent.adsPerPage + ", bailing out", 3);
		return false;
	}

	var html = Liftium._(htmlContainer).innerHTML;
        var numAdsServed = 0, lengthSince = 600, slotname;
	// Note that IE converts all tags to upper case when you call innerHTML, so regexp required
	var sections = html.split(/<\/H2>/i);

	// Start at section 1 instead of 0 to skip over the TOC
        for (var i = 1, l = sections.length; i < l; i++){

		// Note the selector is one less
		var selector = "#" + htmlContainer + " h2:eq(" + (i-1) + ")";
		var sectionHeight = AdsInContent.getPixelHeight(sections[i]);
		var sectionWidth = $(selector).width();

                if (lengthSince < AdsInContent.spaceBetweenAds ) { 
			Liftium.d("AdsInContent: Section skipped, " + lengthSince + " pixels since last ad", 5);
                        lengthSince += sectionHeight;

		} else {
                        var slotConfig = AdsInContent.getSlotConfig(sections[i], numAdsServed+1, sectionWidth, sectionHeight);
			if (slotConfig.type == "leaderboard" || slotConfig === false){
				// Nothing to see here, move along.
                        	lengthSince += sectionHeight;
				continue;
			}
				
			// Display an ad
                        numAdsServed++;
			Liftium.d("AdsInContent: Calling ad in section " + (i+1) + " with " + Liftium.print_r(slotConfig), 3);
                        lengthSince = sectionHeight;

			var lslot =  Liftium.getUniqueSlotname(slotConfig.size);
                        // Create div, apply styles, and insert into the DOM using jQuery

                        var loadDiv = $('<div id="' + lslot + '"></div>');
			for (var style in slotConfig.styles ){
				if (typeof slotConfig.styles[style] == "function"){
					// Prototype js library overwrites the array handler and adds crap. EVIL.
					continue;
				}
				if (style == "width" || style == "height" ) {
					// Don't reserve space for ads (#33171)
					continue;
				}
                        	loadDiv.css(style, slotConfig.styles[style]);
			}
                        loadDiv.insertAfter(selector);

			window.LiftiumPlacement = slotConfig.name;
			var t = Liftium.getNextTag(lslot);
			Liftium.callIframeAd(lslot, t);

                	if (numAdsServed >= AdsInContent.adsPerPage){
                       		break;
                	}
                }
        }

	AdsInContent.numAdsServed = numAdsServed;
        return numAdsServed;
};


AdsInContent.getSlotConfig = function(sectionHtml, adNum, sectionWidth){
	var s = {};

	// Crude check for now. Check for collision or a short section. 
	if (sectionHtml.match(/(<table|wikia-gallery)/i) || sectionHtml.length < 1000 ){
		s.name = "INCONTENT_LEADERBOARD_" + adNum;
		s.type = "leaderboard";
		s.size = "728x90";
	} else {
		s.name = "INCONTENT_BOXAD_" + adNum;
		s.type = "boxad";
		s.size = "300x250";

		// If there is a bulleted list, put boxad on the right. 
		// Otherwise, alternate left/right
		if (sectionHtml.match(/<li/i)){
			s.pos = "right";
		} else {
			s.pos = "left";
		}

	}

	// Set styles
	if (s.type == "leaderboard"){ 
		s.styles = {"width":"728px",
			    "height":"90px",
			    "margin-left":"auto",
			    "margin-right":"auto",
			    "margin-bottom":"10px",
			    "clear": "both"
                           };
	} else if (s.type == "boxad" && s.pos == "right"){
		s.styles = {"width":"300px",
			    "height":"250px",
			    "float":"right",
			    "margin-top":"10px",
			    "margin-bottom":"10px",
			    "margin-left":"10px",
			    "clear": "right"
			   };
	} else {
		// Needs 20 for the bulleted lists. 
		s.styles = {"width":"300px",
			    "height":"250px",
	                    "float":"left",
			    "margin-top": "10px",
			    "margin-bottom":"10px",
			    "margin-right":"20px",
			    "clear": "left"
			   };
	}

	if (parseInt(s.styles.width.replace('px', ''), 10) + 100 > sectionWidth) {
		Liftium.d("Section skipped, " + sectionWidth + " pixels not wide enough for ad", 5);
		return false;
	}
	
	return s;
};


AdsInContent.getPixelHeight = function(sectionHtml){
	// Crude stub for now
	return Math.floor(sectionHtml.length/7);
};

// Call Ads In Content
if (top == self && window.wgEnableAdsInContent && window.wgIsArticle && (window.wgNamespaceNumber != 6) && ! AdsInContent.called && ! window.wgIsMainpage ) {
	window.setTimeout('AdsInContent.putAdsInContent("bodyContent");', 300);
}

// AdsInContent2 a.k.a. AIC2
var AIC2 = {
	called          : false,
	startPosition   : 0,
	stopPosition    : 0,
	magicNumber     : 400,
	visible         : false
};
		
AIC2.init = function() {
	Liftium.d("AIC2: init", 5);
	AIC2.called = true;

// FIXME
if ($("#WikiaMainContent").width() != 680) {
	Liftium.d("AIC2: non standard width, bailing out", 3);
	return;
}

	if (!AIC2.checkStartStopPosition()) return;

	if (AIC2.startPosition + AIC2.magicNumber < AIC2.stopPosition) {
		Liftium.d("AIC2: page long enough", 7);
		$('#WikiaFooter').prepend('<div id="INCONTENT_BOXAD_1" class="noprint" style="height: 250px; width: 300px; position: fixed; bottom: 30px; left: 50%; margin-left: 190px;"><div id="Liftium_300x250_99"><iframe width="300" height="250" id="INCONTENT_BOXAD_1_iframe" class="" noresize="true" scrolling="no" frameborder="0" marginheight="0" marginwidth="0" style="border:none" target="_blank"></iframe></div></div><!-- END SLOTNAME: INCONTENT_BOXAD_1 -->');
		
		if (!AIC2.checkFooterAd()) {
			$(window).bind("scroll.AIC2", AIC2.onScroll);
		}
	} else {
		Liftium.d("AIC2: page too short", 3);
	}
};

AIC2.checkStartStopPosition = function() {
	Liftium.d("AIC2: check start/stop position", 7);

	try {
		var startPosition = parseInt($('#WikiaRail').offset().top) + parseInt($('#WikiaRail').height());
		var stopPosition = parseInt($("#WikiaArticleCategories").offset().top) - parseInt($(window).height());
	} catch (e) {
		// bail out - missing elements, broken dom, erroneous cast...
		return false;
	}

	Liftium.d("AIC2: start/stop old/new", 7, [AIC2.startPosition, AIC2.stopPosition, startPosition, stopPosition]);

	// first time here (AIC2.init, most likely) - set up and proceed
	if (!AIC2.startPosition && !AIC2.stopPosition) {
		AIC2.startPosition = startPosition;
		AIC2.stopPosition = stopPosition;
		Liftium.d("AIC2: start/stop position set up", 7);
		return true;
	}

	// numbers are correct - continue
	// actually, height/offset varries a bit on each scroll, allow for some wiggle room
	if (AIC2.isAlmostEqual(AIC2.startPosition, startPosition) && AIC2.isAlmostEqual(AIC2.stopPosition, stopPosition)) {
		Liftium.d("AIC2: start/stop position correct", 7);
		return true;
	}

	// numbers don't match - fix and skip a beat
	AIC2.startPosition = startPosition;
	AIC2.stopPosition = stopPosition;
	Liftium.d("AIC2: start/stop position fixed", 5);
	return false;
};

AIC2.isAlmostEqual = function(a, b) {
	if (a == b) return true;
	if (b - 3 < a && a < b + 3) return true;
	
	return false;
};

AIC2.onScroll = function() {
	Liftium.d("AIC2: onScroll", 9);
		
	if (($(window).scrollTop() > AIC2.startPosition) && ($(window).scrollTop() < AIC2.stopPosition)) {
		if (!AIC2.visible) {
			Liftium.d("AIC2.showAd", 5);
			if (!AIC2.checkStartStopPosition()) return;
			if (!AIC2.checkFooterAd()) {
				if ($('#INCONTENT_BOXAD_1').hasClass('wikia-ad') == false) {
					LiftiumOptions.placement = "INCONTENT_BOXAD_1";
					Liftium.callInjectedIframeAd("300x250", document.getElementById("INCONTENT_BOXAD_1_iframe"));
					$('#INCONTENT_BOXAD_1').addClass('wikia-ad');
				}
				$('#INCONTENT_BOXAD_1').css('position','fixed');
				$('#INCONTENT_BOXAD_1').css('bottom','30px');
				$('#INCONTENT_BOXAD_1').slideDown();
				
				AIC2.visible = true;
			}
		}
	} else {
		if (AIC2.visible) {
			Liftium.d("AIC2.hideAd", 5);
			$('#INCONTENT_BOXAD_1').slideUp();
			
			AIC2.visible = false;
		}
	}
};

AIC2.checkFooterAd = function() {
	Liftium.d("AIC2: footer ad detection", 7);
	if ($(".wikia_anchor_ad").length) {
		Liftium.d("AIC2: footer ad detected, bailing out", 3);
		$(window).unbind("scroll.AIC2");
		return true;
	} else {
		Liftium.d("AIC2: footer ad not detected, proceeding", 7);
		return false;
	}
};

/* rt#141687
if (top == self && window.wgEnableAdsInContent && window.wgIsArticle && (window.wgNamespaceNumber != 6) && ! AIC2.called && ! window.wgIsMainpage ) {
	wgAfterContentAndJS.push(function(){AIC2.init();});
}
*/



/************************************************************************
 *									*
 * Begin AQ, a class used for ContextWeb DAR				*
 *									*
************************************************************************/ 

if ( typeof AQ == "undefined"){
	var AQ = {
		eventUrls : [],
		chain : {},
		allTags : {},
		cwpid : 504082, // Our account number
		priceFloor : 0, // Tag must be worth this to serve it
		tries : 0
	};
}

AQ.next = function (slotgroup){
	top.Athena.d("AQ.next called with " + slotgroup, 3);
	top.Athena.d("AQ.chain for " + slotgroup + ": " + Athena.print_r(AQ.chain[slotgroup]), 5);

	// Mark the last tag as rejected
	var i, nexti = 0;
	for (i = AQ.chain[slotgroup].length-1; i >= 0; i--){
		if (!top.Athena.e(AQ.chain[slotgroup][i]['skipped'])){
			// Last one was skipped
			nexti = i+1;
			break;
		} else if (!top.Athena.e(AQ.chain[slotgroup][i]['attempt'])){
			// Send reject beacon. Mark as reject in the chain
			AQ.beacon(AQ.chain[slotgroup][i]['id'], "reject");
			AQ.chain[slotgroup][i]['reject'] = true;
			top.Athena.d("AQ tag #" + AQ.chain[slotgroup][i]['id'] + " rejected in " + slotgroup, 3);
			nexti = i+1;
			break;
		}
	}

	if (nexti > AQ.chain[slotgroup].length-1){
		// End of the chain
              	top.Athena.d("AQ: End of ContextWeb chain", 5);
		if (AQ.win == top){
			top.Athena.hop();
		} else {
			// We are in an iframe
			top.Athena.iframeHop(AQ.win.location);
		}
	} else {
		top.Athena.debug("AQ.next calling tag #" + AQ.chain[slotgroup][nexti]['id'] + " with a value of " + AQ.chain[slotgroup][nexti]['fValue'], 3);
		AQ.tag(slotgroup, AQ.chain[slotgroup][nexti]['id']);
	} 

};
window.AQNext = AQ.next; // Backward compatibility


/* Context Web Beacon */
AQ.beacon = function (cwtagid, action){
	if (top.Athena.rand < 0.5){
		return; 
	}
	var url = top.Athena.baseUrl + 'event/set?event=contextWebBeacon&cwtagid=' + cwtagid + '&action=' + action; 
	top.Athena.d("AQ event beacon url: " + url, 3);
	AQ.eventUrls.push(url);

	top.Athena.beaconCall(url);
};

/* 
 * Context Web populates a strCreative global variable. When the ad returns.
 * If this variable does not exist, check again in a few milliseconds
 *
 * Otherwise, figure out if it was a load or a reject by seeing if it is marked as "reject" in the chain, which is done by the AQ.next function
 *
 */

AQ.checkForLoad = function (slotgroup){

	top.Athena.d("AQ.checkForLoad called for " + slotgroup, 4);
	if (top.Athena.e(window.strCreative)){
		if (AQ.tries < 100){
			var recall = "AQ.checkForLoad('" + slotgroup + "');";
			top.Athena.d("AQ: Recalling " + recall + " in 100 ms", 6);
			window.setTimeout(recall, 100);
			AQ.tries++;
		} else {
			top.Athena.d("Giving up after 100 tries in AQ.checkForLoad");
		}
		return; 
	}

	// Walk backwards through the chain and find the first attempt
	for (var i = AQ.chain[slotgroup].length-1; i >= 0; i--){
		if (!top.Athena.e(AQ.chain[slotgroup][i]['attempt'])){
			// Found one that was started. See if AQ.next marked it as reject
			if (top.Athena.e(AQ.chain[slotgroup][i]['reject'])){
				// It loaded!
				AQ.beacon(AQ.chain[slotgroup][i]['id'], "load");
				AQ.chain[slotgroup][i]['load'] = true;
				top.Athena.d("AQ tag #" + AQ.chain[slotgroup][i]['id'] + " loaded in " + slotgroup, 3);
			}

			break; 
		}
	}
};

AQ.randomTag = function(slotgroup, win){
	AQ.randomTagCalled = true;

        // Find a the tags to choose from that aren't already in the chain
        var chooseFrom = [], found = false;
        for (var i = 0; i < AQ.allTags[slotgroup].length; i++){
                found = false;
                for (var j = 0; j < AQ.chain[slotgroup].length; j++){
                        if (AQ.allTags[slotgroup][i]['id'] == AQ.chain[slotgroup][j]['id']){
                                found = true;
                                break;
                        }
                }

                if (! found){
                        chooseFrom.push(Athena.clone(AQ.allTags[slotgroup][i]));
                }
        }

	if (top.Athena.e(chooseFrom)){
		// They are all there, no need to randomize.
		AQ.tag(slotgroup, AQ.chain[slotgroup][0]['id'], win);
		return;
	}

	// Build a new chain with the random one on top
	var r = Math.floor(Math.random() * chooseFrom.length);

	top.Athena.d("AQ.randomTag calling tag " + r + " in the chain for " + slotgroup, 2);

	var oldChain = AQ.chain[slotgroup];
	AQ.chain[slotgroup] = [];
	AQ.chain[slotgroup].push(Athena.clone(chooseFrom[r]));
	AQ.chain[slotgroup][0]['random'] = true;
	AQ.chain[slotgroup].push(Athena.clone(oldChain[0]));
	AQ.chain[slotgroup].push(Athena.clone(oldChain[1]));

	AQ.tag(slotgroup, AQ.chain[slotgroup][0]['id'], win);
};


AQ.tag = function(slotgroup, cwtagid, win){
	if (typeof win != "undefined"){
		// Keep track of which window to write to.
		AQ.win = win;
	}
	top.Athena.d("AQ.tag called for " + slotgroup + " with tag #" + cwtagid, 3);

	AQ.lastTag = cwtagid; 

	// Determine which tag in the chain we are dealing with
	var currenti; 
	for (var i = 0; i < AQ.chain[slotgroup].length; i++){
		if (AQ.chain[slotgroup][i]['id'] == cwtagid){
			currenti = i;
			break;
		}
	}

	/* Throttling for tags. The general idea is that if it is less than 50% fill rate,
	 * we are probably sending too much traffic.
	 * We want the fill rate to determine how much traffic. 
	 * Over 20% fillrate - 100% of traffic
	 * ...
	 * 10% fill rate - 20% of traffic
	var cFill = AQ.chain[slotgroup][currenti]['cFill'];
	if (top.Athena.e(AQ.randomTagCalled) && Math.random() > cFill * 5 ){
		AQ.chain[slotgroup][currenti]['skipped'] = true;
		top.Athena.d("Skipping current AQ tag due to throttling. Fill rate: " + cFill, 4);
		AQ.next(slotgroup);
		return true;
	}
	 */

	// Get size from slotgroup
	var size, w, h;
	switch (slotgroup){
	  case 'MR': size = "300x250"; w = 300; h = 250; break;
	  case 'LB': size = "728x90"; w = 728; h = 90; break;
	  case 'WS': size = "160x600"; w = 160; h = 600; break;
          default: document.write('<!-- Invalid slotgroup for AQ.tag -->'); return false;
	}
	
	// Try to figure out the page we are on using multiple methods
	try {
		var cwpage = "http://" + Athena.getPageVar("hostname") + Athena.getPageVar("request");
	} catch (e) {
		if (top != self && !Athena.e(document.referrer)) { // iframe
			cwpage = document.referrer;
		}
	}

	// Build the cw url
	var cwurl = 'http://tag.contextweb.com/TAGPUBLISH/getad.aspx';
	var cwp = { 
		"tagver": 1,
		"if": 0,
		"ca": "VIEWAD",
		"cp": AQ.cwpid,
		"ct": cwtagid,
		"cf": size,
		"cn": 1,
		"cr": 200,
		"cw": w,
		"ch": h,
		"cads": 0,
		"rq": 1,
		"cwu": cwpage, 
		"mrnd": Athena.rand
	};
	cwurl += '?' + Athena.buildQueryString(cwp, '&');

	// Send attempt beacon
	AQ.beacon(cwtagid, 'attempt');

	// Mark the chain.
	AQ.chain[slotgroup][currenti]['attempt'] = true;
	
	if ( currenti === 0 ) {
		// Check for load, only on the first tag
		window.setTimeout("AQ.checkForLoad('" + slotgroup + "');", 750 * AQ.chain[slotgroup].length);
	}

	// Write the tag
	AQ.win.document.write('<script type="text/javascript" src="' + cwurl + '"><\/scr' + 'ipt>');
	AQ.win.document.write('<script><\/script>');

	return true;
};


/************************************************************************
 *									
 * Begin Meerkat library, adapted from 				
 * http://jarodtaylor.com/meerkat/js/jquery.meerkat.1.0.js 		
 * Made the following changes:
 *  Cleaned up javascript (jslint compatible)
 *  Cookie functionality ripped, we use frequency capping to prevent 	
 *  Removed IE < 6 support
 *  Added left': '0' to the meerkat-wrap class  for IE 7
 * second display							
 *
 * Depends on jquery
 * 
************************************************************************/ 

var meerkat = function (options) {
	
	this.settings = {
		close: 'none',
		dontShow: 'none',
		meerkatPosition: 'bottom',
		animationSpeed: 'slow',
		height: 'auto',
		background: 'none'
	};

	if(options){
		jQuery.extend(this.settings, options);
	}
	
	var settings = this.settings;
	
	$('html, body').css({'margin':'0', 'padding':'0', 'height':'100%'});
	$('#meerkat').show();
	
	$('#meerkat-wrap').css({'position':'fixed', 'width':'100%', 'height': settings.height, 'left': 0, 'z-index': 1000}).css(settings.meerkatPosition,"0");
	$('#meerkat-container').css({'background': settings.background, 'height': settings.height});
	//Give the close and dontShow elements a cursor (there's no need to use a href)
	$(settings.close+","+settings.dontShow).css({"cursor":"pointer"});
		
		
	$('#meerkat-wrap').hide().slideDown(settings.animationSpeed);
	$(settings.close).click(function(){
		$("#meerkat-wrap").slideUp();							
	});
			
	$(settings.dontShow).click(function () {
		$("#meerkat-wrap").slideUp();	
	});
};


/* Special callback function for hopping. Originally implemented for VideoEgg.
 * http://developer.videoegg.com/mediawiki/index.php/VideoEgg_Ad_Platform_Integration_Guide_-_Website#Step_6._.28Optional_But_Highly_Recommended.29_Specify_an_alternate_behavior_when_no_ad_is_available
 * Your function will be called when no ad is available with a single argument containing the DOM div object where the ad would normally appear. This allows you to collapse the div or fill it with alternate content. For example, you could collapse the ad unit div and dynamically fill another div at another location on your page: function myNoAdCallback(div) { div.style.display = "none"; insertMyAd(); } var ve_alternate = myNoAdCallback;
 */
var ve_alternate = function(div){
        div.style.display = "none";
	Athena.hop();
};
