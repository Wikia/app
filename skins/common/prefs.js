
// generate toc from prefs form, fold sections
// XXX: needs testing on IE/Mac and safari
// more comments to follow
function tabbedprefs(prefform) {
	// modified by Bartek for Wikia, 01.04.2008/29.07.2008 (load optimization)
	if (!document.createElement) {
		return;
	}
	if (prefform.nodeName.toLowerCase() == 'a') {
		return; // Occasional IE problem
	}
	prefform.className = prefform.className + 'jsprefs';
	var sections = [];
	var children = prefform.childNodes;
	var seci = 0;
	for (var i = 0; i < children.length; i++) {
		if (children[i].nodeName.toLowerCase() == 'fieldset') {
			children[i].id = 'prefsection-' + seci;
			children[i].className = 'prefsection';
			if (is_opera || is_khtml) {
				children[i].className = 'prefsection operaprefsection';
			}
			var legends = children[i].getElementsByTagName('legend');
			sections[seci] = {};
			if (legends[0]) legends[0].className = 'mainLegend';
			if (legends[0] && legends[0].firstChild.nodeValue) {
				sections[seci].text = legends[0].firstChild.nodeValue;
			} else {
				sections[seci].text = '# ' + seci;
			}
			sections[seci].secid = children[i].id;
			seci++;
			if (sections.length != 1) {
				children[i].style.display = 'none';
			} else {
				var selectedid = children[i].id;
			}
		}
	}
	var toc = document.createElement('ul');
	toc.id = 'preftoc';
	toc.selectedid = selectedid;
	for (i = 0; i < sections.length; i++) {
		var li = document.createElement('li');
		if (i === 0) {
			li.className = 'selected';
		}
		var a = document.createElement('a');
		a.href = '#' + sections[i].secid;
		a.onmousedown = a.onclick = uncoversection;
		a.appendChild(document.createTextNode(sections[i].text));
		a.secid = sections[i].secid;
		li.appendChild(a);
		toc.appendChild(li);
	}
	prefform.parentNode.insertBefore(toc, prefform.parentNode.childNodes[0]);
	document.getElementById('prefsubmit').id = 'prefcontrol';

	/* Wikia change begin - @author: Macbre */
	// proper styling for preferences tabs
	if (window.skin == 'oasis') {
		toc.className = 'tabs';
	}
	/* Wikia change end */
}

// added by Bartek for Wikia, 18.03.2008/29.07.2008
// it can be used by any feature to link to specific tabs of
// Special:Preferences
function initprefs () {
        if (typeof (wgCanonicalSpecialPageName) != 'undefined') {
                if ('Preferences' == wgCanonicalSpecialPageName) {
                        var prefform = document.getElementById('preferences');
                        if (prefform) {
                                tabbedprefs (prefform) ;
                                loadsection (prefform) ;
                        }
                }
        }
}

// added by Bartek for Wikia, 18.03.2008/29.07.2008
// it can be used by any feature to link to specific tabs of
// Special:Preferences
function loadsection (prefform) {
        if (!document.createElement) {
                return;
        }
        if (prefform.nodeName.toLowerCase() == 'a') {
                return; //  Occasional IE problem
        }
        var our_loc = window.location.href ;
        var section_loc = our_loc.split ("#") ;
        if (section_loc [1]) {
                // make a switch and go to appriopriate section
                var first_sec = document.getElementById ("prefsection-0") ;
                var init_sec = document.getElementById (section_loc [1]) ;
                var sec_num = section_loc [1].split ("-") ;
                if (sec_num [1]) {
                        var ul = document.getElementById('preftoc');
                        first_sec.style.display = 'none';
                        init_sec.style.display = 'block';
                        ul.selectedid = section_loc [1] ;
                        var lis = ul.getElementsByTagName ('li');
                        for (var i = 0; i< lis.length; i++) {
                                lis[i].className = '';
                        }
                        ul.childNodes [sec_num [1]].className = 'selected' ;
                }
        }
}

function uncoversection() {
	var oldsecid = this.parentNode.parentNode.selectedid;
	var newsec = document.getElementById(this.secid);
	if (oldsecid != this.secid) {
		var ul = document.getElementById('preftoc');
		document.getElementById(oldsecid).style.display = 'none';
		newsec.style.display = 'block';
		ul.selectedid = this.secid;
		var lis = ul.getElementsByTagName('li');
		for (var i = 0; i< lis.length; i++) {
			lis[i].className = '';
		}
		this.parentNode.className = 'selected';
	}
	return false;
}

// Timezone stuff
// tz in format [+-]HHMM
function checkTimezone(tz, msg) {
	var localclock = new Date();
	// returns negative offset from GMT in minutes
	var tzRaw = localclock.getTimezoneOffset();
	var tzHour = Math.floor( Math.abs(tzRaw) / 60);
	var tzMin = Math.abs(tzRaw) % 60;
	var tzString = ((tzRaw >= 0) ? "-" : "+") + ((tzHour < 10) ? "0" : "") + tzHour + ((tzMin < 10) ? "0" : "") + tzMin;
	if (tz != tzString) {
		var junk = msg.split('$1');
		document.write(junk[0] + "UTC" + tzString + junk[1]);
	}
}

function unhidetzbutton() {
	var tzb = document.getElementById('guesstimezonebutton');
	if (tzb) {
		tzb.style.display = 'inline';
	}
	updateTimezoneSelection(false);
}

// in [-]HH:MM format...
// won't yet work with non-even tzs
function fetchTimezone() {
	// FIXME: work around Safari bug
	var localclock = new Date();
	// returns negative offset from GMT in minutes
	var tzRaw = localclock.getTimezoneOffset();
	var tzHour = Math.floor( Math.abs(tzRaw) / 60);
	var tzMin = Math.abs(tzRaw) % 60;
	var tzString = ((tzRaw >= 0) ? "-" : "") + ((tzHour < 10) ? "0" : "") + tzHour +
		":" + ((tzMin < 10) ? "0" : "") + tzMin;
	return tzString;
}

function guessTimezone(box) {
	document.getElementsByName("wpHourDiff")[0].value = fetchTimezone();
	updateTimezoneSelection(true);
}

function updateTimezoneSelection(force_offset) {
	var wpTimeZone = document.getElementsByName("wpTimeZone")[0];
	var wpHourDiff = document.getElementsByName("wpHourDiff")[0];
	var wpLocalTime = document.getElementById("wpLocalTime");
	var wpServerTime = document.getElementsByName("wpServerTime")[0];
	var minDiff = 0;

	if (force_offset) wpTimeZone.selectedIndex = 1;
	if (wpTimeZone.selectedIndex == 1) {
		wpHourDiff.disabled = false;
		var diffArr = wpHourDiff.value.split(':');
		if (diffArr.length == 1) {
			minDiff = parseInt(diffArr[0], 10) * 60;
		} else {
			minDiff = Math.abs(parseInt(diffArr[0], 10))*60 + parseInt(diffArr[1], 10);
			if (parseInt(diffArr[0], 10) < 0) minDiff = -minDiff;
		}
	} else {
		wpHourDiff.disabled = true;
		var diffArr = wpTimeZone.options[wpTimeZone.selectedIndex].value.split('|');
		minDiff = parseInt(diffArr[1], 10);
	}
	if (isNaN(minDiff)) minDiff = 0;
	var localTime = parseInt(wpServerTime.value, 10) + minDiff;
	while (localTime < 0) localTime += 1440;
	while (localTime >= 1440) localTime -= 1440;

	var hour = String(Math.floor(localTime/60));
	if (hour.length<2) hour = '0'+hour;
	var min = String(localTime%60);
	if (min.length<2) min = '0'+min;
	changeText(wpLocalTime, hour+':'+min);

	if (wpTimeZone.selectedIndex != 1) {
		hour = String(Math.abs(Math.floor(minDiff/60)));
		if (hour.length<2) hour = '0'+hour;
		if (minDiff < 0) hour = '-'+hour;
		min = String(minDiff%60);
		if (min.length<2) min = '0'+min;
		wpHourDiff.value = hour+':'+min;
	}
}

hookEvent("load", unhidetzbutton);
hookEvent("load", initprefs);
