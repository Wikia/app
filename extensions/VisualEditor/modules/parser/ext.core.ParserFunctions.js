/**
 * Some parser functions, and quite a bunch of stubs of parser functions.
 * Instantiated and called by the TemplateHandler extension.
 *
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 */


function ParserFunctions ( manager ) {
	this.manager = manager;
}

ParserFunctions.prototype.fun = {};

ParserFunctions.prototype['pf_#if'] = function ( target, argList, argDict ) {
	if ( target.trim() !== '' ) {
		this.manager.env.dp('#if, first branch', target.trim(), argDict[1] );
		return argDict[1] || [];
	} else {
		this.manager.env.dp('#if, second branch', target.trim(), argDict[2] );
		return argDict[2] || [];
	}
};

ParserFunctions.prototype['pf_#switch'] = function ( target, argList, argDict ) {
	this.manager.env.dp( 'switch enter: ' + target.trim() +
			' looking in ', argDict );
	target = target.trim();
	if ( target in argDict ) {
		this.manager.env.dp( 'switch found: ' + target +
				' res=', argDict[target] );
		return argDict[target];
	} else if ( '#default' in argDict ) {
		return argDict['#default'];
	} else { 
		var lastKV = argList[argList.length - 1];
		if ( lastKV && ! lastKV[0].length ) {
			return lastKV[1];
		} else {
			return [];
		}
	}
};

// #ifeq
ParserFunctions.prototype['pf_#ifeq'] = function ( target, argList, argDict ) {
	if ( argList.length < 2 ) {
		return [];
	} else {
		if ( target.trim() === this.manager.env.tokensToString( argList[0][1] ).trim() ) {
			return ( argList[1] && argList[1][1]) || [];
		} else {
			return ( argList[2] && argList[2][1]) || [];
		}
	}
};

ParserFunctions.prototype['pf_lc'] = function ( target, argList, argDict ) {
	return [ target.toLowerCase() ];
};

ParserFunctions.prototype['pf_uc'] = function ( target, argList, argDict ) {
	return [ target.toUpperCase() ];
};

ParserFunctions.prototype['pf_ucfirst'] = function ( target, argList, argDict ) {
	if ( target ) {
		return [ target[0].toUpperCase() + target.substr(1) ];
	} else {
		return [];
	}
};

ParserFunctions.prototype['pf_lcfirst'] = function ( target, argList, argDict ) {
	if ( target ) {
		return [ target[0].toLowerCase() + target.substr(1) ];
	} else {
		return [];
	}
};

ParserFunctions.prototype['pf_#tag'] = function ( target, argList, argDict ) {
	// XXX: handle things like {{#tag:nowiki|{{{input1|[[shouldnotbelink]]}}}}}
	// https://www.mediawiki.org/wiki/Future/Parser_development#Token_stream_transforms
	return [ new TagTk( target ) ] 
		.concat( argList[0].v, 
			 [ new EndTagTk( target ) ] );
};

// A first approximation, anyway..
// Based on http://jacwright.com/projects/javascript/date_format/ for now, MIT
// licensed.
ParserFunctions.prototype['pf_#time'] = function ( target, argList, argDict ) {
	var res,
		tpl = target.trim();
	//try {
	//	var date = new Date( this.manager.env.tokensToString( argList[0][1] ) );
	//	res = [ date.format( target ) ];
	//} catch ( e ) {
	//	this.manager.env.dp( 'ERROR: #time ' + e );
	
		try {
			res = [ new Date().format ( tpl ) ];
		} catch ( e2 ) {
			this.manager.env.dp( 'ERROR: #time ' + e2 );
			res = [ new Date().toString() ];
		}
	//}
	return res;
};

// Simulates PHP's date function
Date.prototype.format = function(format) {
    var returnStr = '';
    var replace = Date.replaceChars;
    for (var i = 0; i < format.length; i++) {       
		var curChar = format.charAt(i);         
		if (i - 1 >= 0 && format.charAt(i - 1) == "\\") {
            returnStr += curChar;
        }
        else if (replace[curChar]) {
            returnStr += replace[curChar].call(this);
        } else if (curChar != "\\"){
            returnStr += curChar;
        }
    }
    return returnStr;
};

// XXX: support localization
Date.replaceChars = {
    shortMonths: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    longMonths: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    shortDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    longDays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],

    // Day
    d: function() { return (this.getDate() < 10 ? '0' : '') + this.getDate(); },
    D: function() { return Date.replaceChars.shortDays[this.getDay()]; },
    j: function() { return this.getDate(); },
    l: function() { return Date.replaceChars.longDays[this.getDay()]; },
    N: function() { return this.getDay() + 1; },
    S: function() { return (this.getDate() % 10 == 1 && this.getDate() != 11 ? 'st' : (this.getDate() % 10 == 2 && this.getDate() != 12 ? 'nd' : (this.getDate() % 10 == 3 && this.getDate() != 13 ? 'rd' : 'th'))); },
    w: function() { return this.getDay(); },
    z: function() { var d = new Date(this.getFullYear(),0,1); return Math.ceil((this - d) / 86400000); }, // Fixed now
    // Week
    W: function() { var d = new Date(this.getFullYear(), 0, 1); return Math.ceil((((this - d) / 86400000) + d.getDay() + 1) / 7); }, // Fixed now
    // Month
    F: function() { return Date.replaceChars.longMonths[this.getMonth()]; },
    m: function() { return (this.getMonth() < 9 ? '0' : '') + (this.getMonth() + 1); },
    M: function() { return Date.replaceChars.shortMonths[this.getMonth()]; },
    n: function() { return this.getMonth() + 1; },
    t: function() { var d = new Date(); return new Date(d.getFullYear(), d.getMonth(), 0).getDate(); }, // Fixed now, gets #days of date
    // Year
    L: function() { var year = this.getFullYear(); return (year % 400 === 0 || (year % 100 !== 0 && year % 4 === 0)); },   // Fixed now
    o: function() { var d  = new Date(this.valueOf());  d.setDate(d.getDate() - ((this.getDay() + 6) % 7) + 3); return d.getFullYear();}, //Fixed now
    Y: function() { return this.getFullYear(); },
    y: function() { return ('' + this.getFullYear()).substr(2); },
    // Time
    a: function() { return this.getHours() < 12 ? 'am' : 'pm'; },
    A: function() { return this.getHours() < 12 ? 'AM' : 'PM'; },
    B: function() { return Math.floor((((this.getUTCHours() + 1) % 24) + this.getUTCMinutes() / 60 + this.getUTCSeconds() / 3600) * 1000 / 24); }, // Fixed now
    g: function() { return this.getHours() % 12 || 12; },
    G: function() { return this.getHours(); },
    h: function() { return ((this.getHours() % 12 || 12) < 10 ? '0' : '') + (this.getHours() % 12 || 12); },
    H: function() { return (this.getHours() < 10 ? '0' : '') + this.getHours(); },
    i: function() { return (this.getMinutes() < 10 ? '0' : '') + this.getMinutes(); },
    s: function() { return (this.getSeconds() < 10 ? '0' : '') + this.getSeconds(); },
    u: function() { var m = this.getMilliseconds(); return (m < 10 ? '00' : (m < 100 ?
'0' : '')) + m; },
    // Timezone
    e: function() { return "Not Yet Supported"; },
    I: function() { return "Not Yet Supported"; },
    O: function() { return (-this.getTimezoneOffset() < 0 ? '-' : '+') + (Math.abs(this.getTimezoneOffset() / 60) < 10 ? '0' : '') + (Math.abs(this.getTimezoneOffset() / 60)) + '00'; },
    P: function() { return (-this.getTimezoneOffset() < 0 ? '-' : '+') + (Math.abs(this.getTimezoneOffset() / 60) < 10 ? '0' : '') + (Math.abs(this.getTimezoneOffset() / 60)) + ':00'; }, // Fixed now
    T: function() { var m = this.getMonth(); this.setMonth(0); var result = this.toTimeString().replace(/^.+ \(?([^\)]+)\)?$/, '$1'); this.setMonth(m); return result;},
    Z: function() { return -this.getTimezoneOffset() * 60; },
    // Full Date/Time
    c: function() { return this.format("Y-m-d\\TH:i:sP"); }, // Fixed now
    r: function() { return this.toString(); },
    U: function() { return this.getTime() / 1000; }
};

ParserFunctions.prototype['pf_#ifexpr'] = function ( target, argList, argDict ) {
	this.manager.env.dp( '#ifexp: ' + JSON.stringify( argList ) );
	var res;
	try {
		var f = new Function ( 'return (' + target + ')' );
		res = f();
	} catch ( e ) {
		return [ 'class="error" in expression ' + target ];
	}
	if ( res ) {
		return ( argList[0] && argList[0][1] ) || [];
	} else {
		return ( argList[1] && argList[1][1] ) || [];
	}
};
ParserFunctions.prototype['pf_#iferror'] = function ( target, argList, argDict ) {
	if ( target.indexOf( 'class="error"' ) >= 0 ) {
		return ( argList[0] && argList[0][1] ) || [];
	} else {
		return ( argList[1] && argList[1][1] ) || [];
	}
};
ParserFunctions.prototype['pf_#expr'] = function ( target, argList, argDict ) {
	var res;
	try {
		var f = new Function ( 'return (' + target + ')' );
		res = f();
	} catch ( e ) {
		return [ 'class="error" in expression ' + target ];
	}
	return [ res.toString() ];
};

ParserFunctions.prototype['pf_localurl'] = function ( target, argList, argDict ) {
	return ( this.manager.env.wgScriptPath + '/index' +
				this.manager.env.wgScriptExtension + '?title=' +
				this.manager.env.normalizeTitle( target ) + '&' +
				argList.map( 
					function( kv ) { 
						//console.log( JSON.stringify( kv ) );
						return (kv.v !== '' && kv.k + '=' + kv.v ) || kv.k;
					} 
				).join('&') 
		   );
};


/**
 * Stub section: Pick any of these and actually implement them!
 */

// FIXME
ParserFunctions.prototype['pf_#ifexist'] = function ( target, argList, argDict ) {
	return ( argList[0] && argList[0][1] ) || [];
};
ParserFunctions.prototype['pf_formatnum'] = function ( target, argList, argDict ) {
	return [ target ];
};
ParserFunctions.prototype['pf_currentpage'] = function ( target, argList, argDict ) {
	return [ target ];
};
ParserFunctions.prototype['pf_pagename'] = function ( target, argList, argDict ) {
	return [ target ];
};
ParserFunctions.prototype['pf_pagesize'] = function ( target, argList, argDict ) {
	return [ '100' ];
};
ParserFunctions.prototype['pf_pagename'] = function ( target, argList, argDict ) {
	return [ target ];
};
ParserFunctions.prototype['pf_fullpagename'] = function ( target, argList, argDict ) {
	return [target];
};
ParserFunctions.prototype['pf_fullpagenamee'] = function ( target, argList, argDict ) {
	return [target];
};
ParserFunctions.prototype['pf_fullurl'] = function ( target, argList, argDict ) {
	return [target];
};
ParserFunctions.prototype['pf_urlencode'] = function ( target, argList, argDict ) {
	this.manager.env.tp( 'urlencode: ' + target  );
	return [target.trim()];
};
ParserFunctions.prototype['pf_anchorencode'] = function ( target, argList, argDict ) {
	return [target];
};
ParserFunctions.prototype['pf_namespace'] = function ( target, argList, argDict ) {
	return ['Main'];
};
ParserFunctions.prototype['pf_protectionlevel'] = function ( target, argList, argDict ) {
	return [''];
};
ParserFunctions.prototype['pf_ns'] = function ( target, argList, argDict ) {
	return [target];
};

ParserFunctions.prototype['pf_subjectspace'] = function ( target, argList, argDict ) {
	return ['Main'];
};
ParserFunctions.prototype['pf_talkspace'] = function ( target, argList, argDict ) {
	return ['Talk'];
};

if (typeof module == "object") {
	module.exports.ParserFunctions = ParserFunctions;
}
