/*
* jQuery TagCloud 0.5.0
* Copyright (c) 2008 Ron Valstar
* Dual licensed under the MIT and GPL licenses:
*   http://www.opensource.org/licenses/mit-license.php
*   http://www.gnu.org/licenses/gpl.html
*/
;(function($) {
	// private variables
	var oSettings;
	var oUlCss = {};
	var oLiCss = {};
	var fGAng = 2.399963; // sphere angle in radians*pi
	// default settings
	$.tagcloud = {
		 id: "TagCloud"
		,version: "0.5.0"
		,defaults: {
			 height: null
			,type: "cloud"		// "cloud", "list" or "sphere"
			,sizemax: 20
			,sizemin: 10
			,colormax: "00F"
			,colormin: "B4D2FF"
			,hotmin: 0
			,hotmax: 100
			,seed: null			// only for type=="cloud"
			,power: .5			// only for type=="sphere"
		}
	};
	$.fn.extend({
		tagcloud: function(_settings) {
			oSettings = $.extend({}, $.tagcloud.defaults, _settings);
			if (oSettings.seed===null) oSettings.seed = Math.ceil(Math.random()*45309714203);

			switch (oSettings.type) {
				// treemap ::	http://www.jquery.info/The-TreeMap-plugin
								
				case "sphere":
				case "cloud":
					oUlCss = {position:"relative"};
					oLiCss = {position:"absolute",display:"block"};
				break;
				case "list":
					oUlCss = {height:"auto"};
					oLiCss = {position:"static",display:"inline"};
				break;
			}

			Rng.setSeed(oSettings.seed+123456);

			return this.each(function(i,o) {
				var mUl = $(o);
				var aLi = mUl.find(">li");
				var iNumLi = aLi.length;


				var iUlW = mUl.width();
//				var iUlH = oSettings.height===null?mUl.height():oSettings.height;
				var iUlH = oSettings.height===null?(.004*iUlW*iNumLi):oSettings.height;
				mUl.css({width:iUlW,height:iUlH,listStyle:"none",margin:0,padding:0});
				mUl.css(oUlCss);
				

				var iValMx = -2147483647;
				var iValMn = 2147483648;
				var iLastVal = -1;
				for (var j=0;j<iNumLi;j++) {
					var mLi = $(aLi[j]);
					var iVal = mLi.attr("value")==-1?iLastVal++:mLi.attr("value");
					if (iVal>iValMx) iValMx = iVal;
					if (iVal<iValMn) iValMn = iVal;
					iLastVal = iVal;
				}
				var iValRn = iValMx-iValMn;

				// place on line to create minimal overlays
				var aLine = new Array();
				for (var j=0;j<iNumLi;j++) aLine[j] = j;
				for (var j, x, k = aLine.length; k; j = parseInt(Rng.rand(0,1000)/1000 * k), x = aLine[--k], aLine[k] = aLine[j], aLine[j] = x);

				iLastVal = -1;
				iLastHot = -1;
				for (var j=0;j<iNumLi;j++) {
					var mLi = $(aLi[j]);;
					var iVal = mLi.attr("value")==-1?iLastVal++:mLi.attr("value");
					iLastVal = iVal;
					var iHot = Math.max(oSettings.hotmin,Math.min(oSettings.hotmax,mLi.attr("hot")==-1?iLastHot++:mLi.attr("hot")));
					iLastHot = iHot;
					//
					var fPrt = ((iNumLi-j-1)/(iNumLi-1));
					var fPrt = (iVal-iValMn)/iValRn;
					var fPrtHot = (iHot-oSettings.hotmin)/(oSettings.hotmax-oSettings.hotmin);
					//
					var iSzFnt = oSettings.sizemin + fPrt*(oSettings.sizemax-oSettings.sizemin);
					var sColor = colorRng(oSettings.colormin,oSettings.colormax,(fPrt*3+fPrtHot*7)/10);
					//
					mLi.css({"fontSize":iSzFnt,position:"absolute",color:"#"+sColor,margin:0,padding:0}).children().css({color:"#"+sColor});
					var iLiW = mLi.width();
					var iLiH = mLi.height()
					//
					var oCss = {};
					if (oSettings.type!="list") {
						if (oSettings.type=="cloud") {
							var iXps = Rng.rand(0,iUlW-iLiW);
							var iYps = aLine[j]*(iUlH/iNumLi) - iLiH/2;
						} else {
							var fRds = Math.pow(j/iNumLi,oSettings.power);
							var fRad = (j+Math.PI/2)*fGAng;
							var iXps = iUlW/2 - iLiW/2 + .5*iUlW*fRds*Math.sin(fRad);
							var iYps = iUlH/2 - iLiH/2 + .5*iUlH*fRds*Math.cos(fRad);
						}
						oCss.left = iXps;
						oCss.top  = iYps;
					}
					for (var prop in oLiCss) oCss[prop] = oLiCss[prop];
					mLi.css(oCss);
				}
			});
		}
	});
	// Park-Miller RNG
	var Rng = new function() {
		this.seed = 23145678901;
		this.A = 48271;
		this.M = 2147483647;
		this.Q = this.M/this.A;
		this.R = this.M%this.A;
		this.oneOverM = 1.0/this.M;
	}
	Rng.setSeed = function(seed) {
		this.seed = seed;
	}
	Rng.next = function() {
		var hi   = this.seed/this.Q;
		var lo   = this.seed%this.Q;
		var test = this.A*lo - this.R*hi;
		this.seed = test + (test>0?0:this.M);
		return (this.seed*this.oneOverM);
	}
	Rng.rand = function(lrn, urn) {
		return Math.floor((urn - lrn + 1) * this.next() + lrn);
	}
	// hex dec
	function d2h(d) {return d.toString(16);}
	function h2d(h) {return parseInt(h,16);}
//	function getC(s,rgb) {
//		var aRng = [[[0,1],[1,2],[2,3]],[[0,2],[2,4],[4,6]]][s.length==3?0:1][rgb];
//		return s.substring(aRng[0],aRng[1]);
//	}
	function getRGB(s) {
		var b3 = s.length==3;
		var aClr = [];
		for (var i=0;i<3;i++) {
			var sClr = s.substring( i*(b3?1:2), (i+1)*(b3?1:2) );
			aClr.push(h2d(b3?sClr+sClr:sClr));
		}
		return aClr;
	}
	function getHex(a) {
		var s = "";
		for (var i=0;i<3;i++) {
			var c = d2h(a[i]);
			if (c.length==1) c = "0"+c; // todo: this can be better
			s += c;
		}
		return s;
	}
	function colorRng(mn,mx,prt) {
		var aMin = getRGB(mn);
		var aMax = getRGB(mx);
		var aRtr = [];
		for (var i=0;i<3;i++) aRtr.push( aMin[i] + Math.floor(prt*(aMax[i]-aMin[i])) );
		return getHex(aRtr);
	}
	// trace
	function trace(o) {
		if (window.console&&window.console.log) {
			if (typeof(o)=="string")	window.console.log(o);
			else						for (var prop in o) window.console.log(prop+": "+o[prop]);
		}
	};
	// set functions
	$.fn.TagCloud = $.fn.Tagcloud = $.fn.tagcloud;
})(jQuery);