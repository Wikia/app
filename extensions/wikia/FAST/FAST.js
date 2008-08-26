var FASTtoc = false;
var FASTtocY;
var FASTtocHeight;
var FASTcontentY = YAHOO.util.Dom.getY('bodyContent');

var adSizes= new Array(11);
adSizes["FAST1"] = [728,90];
adSizes["FAST2"] = [300,250];
adSizes["FAST3"] = [300,250];
adSizes["FAST4"] = [300,250];
adSizes["FAST5"] = [728,90];
adSizes["FAST6"] = [160,600];
adSizes["FAST7"] = [160,600];
adSizes["FAST_HOME1"] = [728,90];
adSizes["FAST_HOME2"] = [300,250];
adSizes["FAST_HOME3"] = [160,600];
adSizes["FAST_HOME4"] = [160,600];
adSizes["HOME_TOP_LEADERBOARD"] = [728,90];
adSizes["HOME_TOP_RIGHT_BOXAD"] = [300,250];

var fast_bottom_type;

if($('toc')) {
	FASTtoc = true;
	FASTtocY = YAHOO.util.Dom.getY('toc');
	FASTtocHeight = $('toc').offsetHeight - 38;
}

function FASTfix(banner) {
	var Dom = YAHOO.util.Dom;

	if(banner == 'FAST1') {
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin-bottom', '10px');
		Dom.setStyle('adSpace' + curAdSpaceId, 'text-align', 'center');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin-left', 'auto');
	} else if(banner == 'FAST2') {
		Dom.setStyle('adSpace' + curAdSpaceId, 'float', 'right');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin-bottom', '10px');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin-left', '10px');
		Dom.getElementsBy(function(el) {
			if((el.nodeName == 'DIV' || el.nodeName == 'TABLE') && el.id.substring(0,7) != 'adSpace' && Dom.getStyle(el, 'float') == 'right') {
				return true;
			}
			return false;
		}, null, 'bodyContent', function(el) {
			if((FASTtoc && Dom.getY(el) > FASTtocY && Dom.getY(el) - FASTtocHeight < FASTcontentY + 300) || Dom.getY(el) < FASTcontentY + 300) {
				Dom.setStyle(el, 'clear', 'right');
			}
		});
	} else if(banner == 'FAST3') {
		fast_bottom_type = banner;
		Dom.setStyle('adSpace' + curAdSpaceId, 'float', 'left');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin-right', '20px');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin-bottom', '10px');
		var sections = Dom.getElementsByClassName('mw-headline');
		var lastSectionY = Dom.getY(sections[sections.length - 2]);
		Dom.getElementsBy(function(el) {
			if((el.nodeName == 'DIV' || el.nodeName == 'TABLE') && el.id.substring(0,7) != 'adSpace' && Dom.getStyle(el, 'float') == 'left') {
				return true;
			}
			return false;
		}, null, 'bodyContent', function(el) {
			if(Dom.getY(el) < (lastSectionY + 300 + 35)) {
				Dom.setStyle(el, 'clear', 'left');
			}
		});
	} else if(banner == 'FAST4') {
		fast_bottom_type = banner;
		Dom.setStyle('adSpace' + curAdSpaceId, 'float', 'right');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin-left', '10px');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin-bottom', '10px');
		var sections = Dom.getElementsByClassName('mw-headline');
		var lastSectionY = Dom.getY(sections[sections.length - 2]);
		Dom.getElementsBy(function(el) {
			if((el.nodeName == 'DIV' || el.nodeName == 'TABLE') && el.id.substring(0,7) != 'adSpace' && Dom.getStyle(el, 'float') == 'right') {
				return true;
			}
			return false;
		}, null, 'bodyContent', function(el) {
			if(Dom.getY(el) < (lastSectionY + 300 + 35)) {
				Dom.setStyle(el, 'clear', 'right');
			}
		});
	} else if(banner == 'FAST5') {
		fast_bottom_type = banner;
		if($('adSpaceFAST5')) {
			curAdSpaceId = 'FAST5';
		}
		Dom.setStyle($('adSpace' + curAdSpaceId).parentNode, 'display', '');
	} else if(banner == 'FAST6') {
		Dom.setStyle($('adSpace' + curAdSpaceId).parentNode, 'display', '');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin', '0 auto');
	} else if(banner == 'FAST7') {
		if($('adSpaceFAST7')) {
			curAdSpaceId = 'FAST7';
		}
		Dom.setStyle($('adSpace' + curAdSpaceId).parentNode, 'display', '');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin', '0 auto');
	} else if(banner == 'HOME_TOP_LEADERBOARD' || banner == 'FAST_HOME1') {
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin-bottom', '10px');
		Dom.setStyle('adSpace' + curAdSpaceId, 'text-align', 'right');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin-left', 'auto');
	} else if(banner == 'FAST_HOME3') {
		Dom.setStyle($('adSpace' + curAdSpaceId).parentNode, 'display', '');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin', '0 auto');
	} else if(banner == 'FAST_HOME4') {
		Dom.setStyle($('adSpace' + curAdSpaceId).parentNode, 'display', '');
		Dom.setStyle('adSpace' + curAdSpaceId, 'margin', '0 auto');
	}

	Dom.setStyle('adSpace' + curAdSpaceId, 'width', adSizes[banner][0]+'px');
	Dom.setStyle('adSpace' + curAdSpaceId, 'height', adSizes[banner][1]+'px');

	return true;
}

function FASTisCollisionBottom() {
	var Dom = YAHOO.util.Dom;
	var sections = Dom.getElementsByClassName('mw-headline');
	var lastSectionY = Dom.getY(sections[sections.length - 2]);
	var tables = $('bodyContent').getElementsByTagName('table');
	for(var i = 0; i < tables.length; i++) {
		if(Dom.getY(tables[i]) > (lastSectionY + 30)) {
			return true;
		}
	}

	if(lastSectionY < (Dom.getY('bodyContent') + 500)) {
		return true;
	}

	return false;
}

function FASTisCollisionTop() {
	var Dom = YAHOO.util.Dom;

	var tables = $('bodyContent').getElementsByTagName('table');
	for(var i = 0; i < tables.length; i++) {
		if(tables[i].id != 'toc' && Dom.getStyle(tables[i], 'float') == 'none' && ((FASTtoc && Dom.getY(tables[i]) > FASTtocY && Dom.getY(tables[i]) - FASTtocHeight < FASTcontentY + 300) || (Dom.getY(tables[i]) < FASTcontentY + 300))) {
			return true;
		}
	}
	return false;
}

function FASTisLongArticle() {
	return ($('bodyContent').offsetHeight > 800 ? true : false);
}

function FASTisShortArticle() {
	return ($('bodyContent').offsetHeight < 400 ? true : false);
}

function FASTisValid(pos) {
	if(FASTisShortArticle()) {
		return false;
	}

	if(pos == 'FAST_SIDE' || pos == 'FAST_BOTTOM' || pos == 'FAST4' || pos == 'FAST5') {
		if(!FASTisLongArticle()) {
			return false;
		}
	}

	return true;
}
