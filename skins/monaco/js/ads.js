/**
 * http://acko.net/blog/mouse-handling-and-absolute-positions-in-javascript
 */
function getAbsolutePosition(element){
	var r = {x:element.offsetLeft,y:element.offsetTop};
	if(element.offsetParent){
		var tmp = getAbsolutePosition(element.offsetParent);
		r.x += tmp.x;
		r.y += tmp.y;
	}
	return r;
};
/**
 * http://www.hedgerwow.com/360/dhtml/js-onfontresize2.html
 */
YAHOO.namespace('YAHOO.example').FontSizeMonitor = (function(){
	var $E = YAHOO.util.Event;
	var $D = YAHOO.util.Dom;
	var p_frame = document.createElement('iframe');
	var p_ie = !!(document.expando && document.uniqueID);
	var p_gecko = !!(document.getBoxObjectFor);
	var p_init = function(){
		var dB = document.body;
		if(!dB ) return setTimeout(p_init,0);
		if(!p_frame._ready){
			with(p_frame.style){
				width = '10em';
				height = '50pt';
				visibility = 'hidden';
				position = 'absolute';
				zIndex = -1;
				top = '0';
				left = '0';
				border = 'none';
				background = "red";
			};
			dB.insertBefore(p_frame,dB.firstChild);
		};
		if(p_ie){
			p_frame._ready = true ;
			$E.on(p_frame,'resize',oApi._onFontResize,oApi,true);
			} else {
			if(!p_gecko){
				var dDoc = p_frame.contentDocument || p_frame.contentWindow;
				if(!dDoc) return setTimeout(p_init,0);
				p_frame._ready = true ;
				dDoc.onresize = function(e){
					oApi._onFontResize.call(oApi,e);
				};;
				}else{
				with(p_frame.style){
					visibility = 'visible';
					zIndex = 1000;
					left = (YAHOO.util.Dom.hasClass(document.body, 'rtl') ? '' : '-') + '5000px';
				};
				var sHtml = [
				'<html><body><script>',
				'self.onresize=function(e){parent.YAHOO.example.FontSizeMonitor._onFontResize(e);}',
				'<\/script></body></html>'].join('');
				p_frame.src= 'data:text/html;charset=utf-8,' + encodeURIComponent(sHtml);
			}
		}
	};
	var onResize = function(){
	};
	var oApi = {
		_onFontResize:function(e){
			var n = p_frame.offsetWidth / 10;
			this.onChange.fire(n);
		},
		onChange:new YAHOO.util.CustomEvent('change')
	};
	p_init();
	return oApi;
})();
/**
 * @author Inez Korczynski
 */
var HCHARS = "0123456789ABCDEF";

function dec2hex(n) {
	n = parseInt(n, 10);
	n = (YAHOO.lang.isNumber(n)) ? n : 0;
	n = (n > 255 || n < 0) ? 0 : n;
	return HCHARS.charAt((n - n % 16) / 16) + HCHARS.charAt(n % 16);
}

function rgb2hex(r, g, b) {
	if (YAHOO.lang.isArray(r)) {
		return rgb2hex(r[0], r[1], r[2]);
	}
	return dec2hex(r) + dec2hex(g) + dec2hex(b);
}

function getHEX(color) {
	if(color == 'transparent') {
		return color;
	}

	if(color.match("^\#")) {
		return color.substring(1);
	}

	return rgb2hex(color.substring(4).substr(0, color.length-5).split(', '));
}

function AdGetColor(type) {

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
		adColorsContent[type] = getHEX(YAHOO.util.Dom.getStyle('article', 'color'));
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

		adColorsContent[type] = getHEX(YAHOO.util.Dom.getStyle(link, 'color'));
		return adColorsContent[type];
	}

	if(type == 'bg') {
        var color = getHEX(YAHOO.util.Dom.getStyle('article', 'background-color'));

        if(color == 'transparent' || color == AdGetColor('text')) {
	        color = getHEX(YAHOO.util.Dom.getStyle('wikia_page', 'background-color'));
        }

        if(color == 'transparent' || color == '000000') {
            color = getHEX(YAHOO.util.Dom.getStyle(document.body, 'background-color'));
        }

		adColorsContent[type] = color;
		return adColorsContent[type];
	}

}

/**
 * @author Inez Korczynski
 */
var DARTord = (new Date).valueOf();
function ad_call(adSpaceId, zoneId, pos) {

	if(pos.substring(0,4) == 'http') {
		curAdSpaceId = adSpaceId;
		FASTfix(zoneId);
		document.write('<scr'+'ipt type="text/javascript" src="'+pos.replace(/RANDOM/, DARTord)+'"></scr'+'ipt>');
		return;
	}

	curAdSpaceId = -1;

	if($('adSpace' + adSpaceId)) {

		if(pos.substring(0, 4) == 'FAST' && !FASTisValid(pos)) {
			return;
		}

		curAdSpaceId = adSpaceId;

 		var source = Array();
 		source.push('slot=' + pos);
 		source.push('catid=' + wgCatId);
 		source.push('lang=' + wgContentLanguage);
		if(pos == 'FAST_BOTTOM' && FASTisCollisionBottom()) {
			source.push('fast=1');
		} else if(pos == 'FAST_TOP') {
			source.push('fast=' + (FASTisCollisionTop() ? '14' : '24'));
		}

		document.write('<scr'+'ipt type="text/javascript">');
		document.write('var base_url = "http://wikia-ads.wikia.com/www/delivery/ajs.php";');
		document.write('base_url += "?loc=" + escape(window.location);');
		document.write('if(typeof document.referrer != "undefined") base_url += "&referer=" + escape(document.referrer);');
		document.write('if(typeof document.context != "undefined") base_url += "&context=" + escape(document.context);');
		document.write('if(typeof document.mmm_fo != "undefined") base_url += "&mmm_fo=1";');
		document.write('base_url += "&zoneid='+zoneId+'";');
		document.write('base_url += "&cb=" + Math.floor(Math.random()*99999999999);');
		document.write('if(typeof document.MAX_used != "undefined" && document.MAX_used != ",") base_url += "&exclude=" + document.MAX_used;');
		document.write('base_url += "&source='+source.join(';')+'";');
		document.write('base_url += "&block=1";');
		document.write('</scr'+'ipt>');
		document.write('<scr'+'ipt type="text/javascript" src="'+base_url+'"></scr'+'ipt>');
	}
}

/**
 * @author Inez Korczynski
 */
TieDivLib = new function() {
	var Dom = YAHOO.util.Dom;
	var items = Array();
	var block = false;
	var loopCount = 300;
	var rtl;
	var xy;
	var pos = [];
	var aX;
	var aY;

	this.tie = function(source, target, pos) {

		if($(target).style.height == '') {
			with($(target).style) {
				height = '75px';
				width = '200px';
				margin = '0 auto';
			}
		}

		items.push([source, target, pos]);

		with($(source).style) {
			position = 'absolute';
			zIndex = (pos == 'bl' || pos == 'r' || pos == 'FAST_SIDE' || pos == 'FAST_HOME3' || pos == 'FAST_HOME4') ? 21 : 5;
		}
	}

	this.recalc = function() {
		if(block) return;
		block = true;
		if(pos.loaded != true || pos.shrink != Math.round(Dom.getY('monaco_shrinkwrap_main')) || pos.articleW != $('article').offsetWidth || pos.articleH != $('article').offsetHeight || pos.sidebarW != $('widget_sidebar').offsetWidth || pos.sidebarH != $('widget_sidebar').offsetHeight) {
			pos.shrink = Math.round(Dom.getY('monaco_shrinkwrap_main'));
			pos.articleW = $('article').offsetWidth;
			pos.articleH = $('article').offsetHeight;
			pos.sidebarW = $('widget_sidebar').offsetWidth;
			pos.sidebarH = $('widget_sidebar').offsetHeight;
			for(i = 0; i < items.length; i++) {

				if(Dom.getStyle(items[i][0], 'display') != 'block') {
					Dom.setStyle(items[i][0], 'display', 'block');
				}

				if(!rtl) {
					xy = getAbsolutePosition($(items[i][1]));
					xy.x = Dom.getX(items[i][1]);
					if(items[i][2].substring(0, 4) == 'http' || items[i][2].substring(0, 4) == 'FAST' || items[i][2] == 'bl' || items[i][2] == 'r') {
						if(items[i][2].substring(0, 4) == 'http' || items[i][2] == 'FAST_HOME1' || items[i][2] == 'FAST_HOME2' || items[i][2] == 'FAST_TOP' || (items[i][2] == 'FAST_BOTTOM' && fast_bottom_type == 'FAST4')) {
							if($(items[i][0]).style.right == '') {
								$(items[i][0]).style.right = 5 + Dom.getX('wikia_page') + $('wikia_page').offsetWidth - (Dom.getX(items[i][1]) + $(items[i][1]).offsetWidth) + 'px';
							}
						} else {
							if($(items[i][0]).style.left == '') {
								$(items[i][0]).style.left = Dom.getX(items[i][1]) - aX - (YAHOO.util.Dom.getX('wikia_page') - parseFloat(YAHOO.util.Dom.getStyle('wikia_page', 'margin-left'))) + 'px';
							}
						}
						if(xy.y != parseFloat($(items[i][0]).style.top) + pos.shrink) {
							$(items[i][0]).style.top = (xy.y - pos.shrink + aY) + 'px';
						}
					} else {
						if(xy.y != parseFloat($(items[i][0]).style.top) + pos.shrink || xy.x != parseFloat($(items[i][0]).style.left)) {
							$(items[i][0]).style.top = xy.y - pos.shrink + aY + 'px';
							$(items[i][0]).style.left = xy.x - (YAHOO.util.Dom.getX('wikia_page') - parseFloat(YAHOO.util.Dom.getStyle('wikia_page', 'margin-left'))) - aX + 'px';
						}
					}
				} else {
					xy = getAbsolutePosition($(items[i][1]));
					xy.x = Dom.getX(items[i][1]) - (YAHOO.util.Dom.getX('wikia_page') - parseFloat(YAHOO.util.Dom.getStyle('wikia_page', 'margin-left')));
					Dom.setXY(items[i][0], [xy.x, xy.y]);
				}
			}
		}
		block = false;
	}

	this.timer = function() {
		TieDivLib.recalc();
		loopCount--;
		if(loopCount > 0) {
			setTimeout(TieDivLib.timer, 350);
		}
	}

	this.init = function() {
		rtl = Dom.hasClass(document.body, 'rtl');
		aX = (YAHOO.env.ua.ie > 0) ? Dom.getX('wikia_header') : 0;
		aY = ((YAHOO.env.ua.ie > 0) ? 2 : 0) - 1;
		TieDivLib.timer();

		YAHOO.util.Event.addListener(window, 'load', function() {
			setTimeout(function() { loopCount = 0; pos.loaded = true; }, 2000);
			YAHOO.example.FontSizeMonitor.onChange.subscribe(TieDivLib.recalc);
		});

		YAHOO.util.Event.addListener(document, 'click', function() {
			TieDivLib.loop(3);
		});

		YAHOO.util.Event.addListener(document, 'keydown', function() {
			TieDivLib.loop(3);
		});

		YAHOO.util.Event.addListener(window, 'resize', function() {
			TieDivLib.recalc();
		});
	}

	this.loop = function(count) {
		var go = false;
		if(loopCount <= 0) go = true;
		loopCount = count;
		if(go) TieDivLib.timer();
	}

	this.getItems = function() {
		return items;
	}

}
